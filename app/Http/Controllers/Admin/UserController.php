<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Department;
use app\User;
use App\Office;
use App\Region;





class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();

        return view('admin.users.list',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments=Department::all();
        $regions=Region::all();
        $offices=Office::all();

        // dump($offices);
        // die();

        return view('admin.users.create',compact('departments', 'regions', 'offices'));
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
        $user = User::select('id', 'first_name', 'sur_name', 'last_name', 'email', 'mobile_phone', 'work_phone', 'position', 'avatar', 'region_id', 'department_id', 'office_id')
        ->with(['region:id,region_appellation'])
        ->with(['department:id,department_appellation'])
        ->with(['office:id,office_appellation'])
        ->findOrFail($id);

        $departments=Department::all();
        $regions=Region::all();
        $offices=Office::all();

        return view('admin.users.edit', compact('user','departments','regions','offices'));
    }


    public function addOffice(Request $request){
        $data = $request->input();

        Validator::make($data,[
            'office_appellation'=>'requaire|alpha|unique:office'
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

    
    public function addRegion(Request $request){
        $data = $request->input();

        Validator::make($data,[
            'region_appellation'=>'requaire|alpha|unique:region'
        ]);

        $item = (new Region())->create($data);

        if ($item) {
            echo $item;
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    
    public function addDepartment(Request $request){
        $data = $request->input();
        Validator::make($data,[
            'department_appellation'=>'requaire|alpha|unique:department'
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


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = User::findOrFail($id);
        
        $validatedData=$request->all();

        Validator::make( $request->all(),[
            'first_name' => 'required|max:255',
            'sur_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'work_phone'=>'required|numeric',
            'position'=>'text|alpha',
            'avatar' =>'image|nullable'
        ]);
        
        if($validatedData['avatar']=='undefined'){
            $validatedData['avatar']=$item['avatar'];
        }else{
            $validatedData['avatar'] = url($validatedData['avatar']->store('avatar','public'));
        }
        
        $item->update($validatedData);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $result = $user->forceDelete();

        if($result) {
            return redirect()
                ->route('admin.users.index')
                ->with(['success' => 'Users Deleted.']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
}
