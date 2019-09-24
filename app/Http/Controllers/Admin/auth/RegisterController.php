<?php

namespace App\Http\Controllers\admin\Auth;

use App\Conversation;
use App\User;
use App\Invite;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

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
    protected $redirectTo = '/admin/users/create';

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
      
		return Validator::make($data, [
            'first_name' => 'required|max:255',
            'sur_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'login' => 'required|unique:users',
            'password' => 'required|min:6',
            'mobile_phone'=>'required|numeric',
            'work_phone'=>'required|numeric',
            'region'=>'text|alpha',
            'department'=>'text|alpha',
            'office'=>'text|alpha', 
            'position'=>'text|alpha',
            'avatar' =>'image|nullable'
		]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $linkAvatar='';

       if(isset($data['avatar'])){
        $linkAvatar = url($data['avatar']->store('avatar','public'));
       }

        return User::create([
            'login' => $data['login'],
            'first_name' => $data['first_name'],
            'sur_name' => $data['sur_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'mobile_phone'=>$data['mobile_phone'],
            'work_phone'=>$data['work_phone'],
            'region_id'=>$data['region'],
            'position'=>$data['position'],
            'department_id'=>$data['department'],
            'office_id'=>$data['office'],
            'avatar' => $linkAvatar 
        ]);
    }

    public function register(Request $request){
        $this->validator($request->all());

        event(new Registered($user = $this->create($request->all())));

        return redirect()->back();
    }

}
