<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Department;
use app\User;
use App\Office;
use App\Event;
use Str;
use Hash;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('create users')) {
            return redirect()->back()->with('status', 'У вас нет доступа для этого действия.');
        }
        $departments = Department::all();
        $offices = Office::all();

        return view('admin.users.create', compact('departments', 'offices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::select('id', 'first_name', 'sur_name', 'birthday', 'last_name', 'email', 'mobile_phone', 'work_phone', 'position', 'avatar', 'department_id', 'office_id')
            ->with(['department:id,department_appellation'])
            ->with(['office:id,office_appellation'])
            ->findOrFail($id);

        if (!(Auth::user()->hasPermissionTo('edit users') && !$user->hasAnyRole(['grant admin', 'admin']) || Auth::user()->hasAnyRole(['grant admin', 'admin']))) {
            return redirect()->back()->with('status', 'У вас нет доступа к изменению этого пользователя');
        }

        $departments = Department::all();
        $offices = Office::all();

        return view('admin.users.edit', compact('user', 'departments', 'offices'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->all();

        Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'sur_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'work_phone' => 'required|numeric',
            'position' => 'text|alpha',
            'birthday' => 'date',
            'avatar' => 'image|nullable'
        ]);

        $fullName = $data['first_name'] . " " . $data['sur_name'] . " " . $data['last_name'];

        if ($data['birthday'] != null) {

            $birthdayEvent = Event::firstOrNew([
                'user_id'=> $id,
                'className'=> 'bg-pink'
            ]);
            $birthdayEvent->title = $fullName . " празднует день рождения.";

            $birthdayEvent->repeats=2;
            $birthdayEvent->start = $data['birthday'];
            $birthdayEvent->end = $data['birthday'];

            $birthdayEvent->save();
        }

        if ($data['avatar'] == 'undefined') {
            $data['avatar'] = $user['avatar'];
        } else {
            $savePath = 'avatar/' . Str::slug($user['id'] . '_' . str_replace(' ', '_', $fullName));
            $data['avatar'] = url($data['avatar']->store($savePath, 'public'));
        }

        $data += ['name' => $fullName];
        $user->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->hasPermissionTo('edit rolesAndPermissions')) {
            return redirect()->back()->with('status', 'Вы не можете удалить администратора.');
        }

        $result = $user->delete();

        if ($result) {
            return redirect()
                ->route('admin.users.index')
                ->with(['success' => 'Пользователь удалён.']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }

    public function changePasswordAdmin(Request $request, $id)
    {
        $this->changePassword($request, $id);
    }

    public function changePasswordOnlyUser(Request $request, $id)
    {
        $test = (function ($currentUser) {
            $permissions = $currentUser->getPermissionsViaRoles();

            foreach ($permissions as $permission) {
                if ($permission->name == 'change password') {
                    return true;
                }
            }
            abort(500, 'У вас нет прав для этого действия');
        });

        $currentUser = Auth::user();

        if ($currentUser['id'] == $id && $test($currentUser)) {
            $this->changePassword($request, $id);
        } else {
            abort(500, 'Произошла ошибка при смене пароля. Пароль остался прежним.');
        }
    }

    private function changePassword($request, $id)
    {
        $data = $request->validate(
            [
                'newPassword' => 'required|min:6|alpha_dash|confirmed|max:20',
            ],
            [
                'newPassword.required' => 'Поля паролей не заполнены',
                'newPassword.min' => 'Пароль должен состоять не меньще чем из 6 символов.',
                'newPassword.alpha_dash' => 'Пароль может содержать только буквы, цифры, тире и символы подчеркивания.',
                'newPassword.confirmed' => 'Контрольный пароль не соответствует паролю в первой строке.',
                'newPassword.max' => 'Пароль не должен быть больше чем 20 символов.'
            ]
        );

        $user = User::find($id);

        if (password_verify($data['newPassword'], $user->password))
            abort(500, 'Этот пароль уже использовался ранее, придумайте другой.');
        else {
            $user->password = Hash::make($data['newPassword']);
            $user->save();
            abort(200, 'Пароль успешно изменён');
        }
    }


    public function addOffice(Request $request)
    {
        $data = $request->input();

        Validator::make($data, [
            'office_appellation' => 'requaire|alpha|unique:office'
        ]);

        $item = (new Office())->create($data);

        if ($item) {
            echo $item;
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }


    public function addDepartment(Request $request)
    {
        $data = $request->input();
        Validator::make($data, [
            'department_appellation' => 'requaire|alpha|unique:department'
        ]);

        $item = (new Department())->create($data);

        if ($item) {
            echo $item;
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }
}
