<?php

namespace App\Http\Controllers\admin\Auth;

use App\Conversation;
use App\User;
use App\Event;
use App\Invite;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }



    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        Validator::make($data, [
            'first_name' => 'required|max:255|alpha',
            'sur_name' => 'required|max:255|alpha',
            'last_name' => 'required|max:255|alpha',
            'email' => 'required|email|unique:users',
            'login' => 'required|unique:users',
            'password' => 'required|min:6|alpha_dash|confirmed|max:20',
            'birthday' => 'required|date',
            'mobile_phone' => 'required',
            'position' => 'max:255',
            'avatar' => 'image|nullable'
        ], [
            'first_name.required' => 'Поле "Фамилия" должно быть заполнено.',
            'first_name.alpha' => 'Поле "Фамилия" может содержать только буквы.',
            'first_name.max' => 'Поле "Фамилия" не должно превышать 255 символов.',

            'sur_name.required' => 'Поле "Имя" должно быть заполнено.',
            'sur_name.alpha' => 'Поле "Имя" может содержать только буквы.',
            'sur_name.max' => 'Поле "Имя" не должно превышать 255 символов.',

            'last_name.required' => 'Поле "Отчество" должно быть заполнено.',
            'last_name.alpha' => 'Поле "Отчество" может содержать только буквы.',
            'last_name.max' => 'Поле "Отчество" не должно превышать 255 символов.',

            'email.required' => 'Поле "mail" должно быть заполнено.',
            'login.required' => 'Поле "Логин" должно быть заполнено.',

            'password.required' => 'Поле "Пароль" должно быть заполнено.',
            'password.min' => 'Пароль должен состоять не меньще чем из 6 символов.',
            'password.alpha_dash' => 'Пароль может содержать только буквы, цифры, тире и символы подчеркивания.',
            'password.confirmed' => 'Пароль и контрольный пароль не соответствуют.',
            'password.max' => 'Пароль не должен быть больше чем 20 символов.',

            'birthday.required' => 'Поле "день рождения" должно быть установлено.',
            'birthday.date' => 'Поле "день рождения" должно быть датой.',

            'mobile_phone.required' => 'Поле "Личный телефон" должно быть заполнено.',
            'position.max' => 'Поле "Должность" не должно превышать 255 символов.',

            'avatar.image' => 'Поле "Аватар" может содержать только файл картинку.'
        ])->validate();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $linkAvatar = '';

        $fullName = $data['first_name'] . " " . $data['sur_name'] . " " . $data['last_name'];

        $user = User::create([
            'login' => $data['login'],
            'first_name' => $data['first_name'],
            'sur_name' => $data['sur_name'],
            'last_name' => $data['last_name'],
            'name' => $fullName,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'birthday' => $data['birthday'],
            'mobile_phone' => $data['mobile_phone'],
            'work_phone' => $data['work_phone'],
            'position' => $data['position'],
            'department_id' => $data['department'],
            'office_id' => $data['office'],
        ]);

        if (isset($data['avatar'])) {
            $savePath = 'avatar/' . Str::slug($user->id . '_' . str_replace(' ', '_', $fullName));
            $linkAvatar = url($data['avatar']->store($savePath, 'public'));
        } else {
            $linkAvatar = url('avatar/default/default.png');
        }

        $user->avatar = $linkAvatar;
        $user->save();
        $user->assignRole('user');

        //Создаём событие "День рождения"
        $eventModel = new Event();
        $eventModel->title = $fullName . " празднует день рождения.";
        $eventModel->className = "bg-pink";
        $eventModel->start = $data['birthday'];
        $eventModel->end = $data['birthday'];
        $eventModel->user_id = $user->id;
        $eventModel->repeats = "2";
        $eventModel->save();
    }

    public function register(Request $request)
    {
        $this->validator($request->all());
        event(new Registered($user = $this->create($request->all())));
        return redirect()->back()->with('status', 'Пользователь создан.');
    }
}
