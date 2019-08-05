<?php

namespace App\Http\Controllers\Auth;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
//        $this->middleware('invite', ['only' => [
//            'showRegistrationForm',
//            'register'
//        ]]);
    }

//    public function showRegistrationForm(Request $request)
//    {
//        return view('auth.register', compact('request'));
//    }

//    public function register(Request $request)
//    {
//        $this->validator($request->all())->validate();
//        event(new Registered($user = $this->create($request->all())));
//        $this->guard()->login($user);
//        $invite = Invite::where('code', $request->input('code'))->first();
//
//        $invite->invitee_id = $user->id;
//        $invite->claimed = Carbon::now();
//        $invite->save();
//
//        $user->assignRole('dealer');
//
//        $conversation = new Conversation;
//        $conversation->user2 = $invite->responsible_manager;
//        $conversation->user1 = $user->id;
//        $conversation->save();
//
//        return $this->registered($request, $user)
//            ?: redirect($this->redirectPath());
//    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
//        return Validator::make($data, [
//            'Partner_ContactFio' => ['required', 'string', 'max:255'],
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//            'Partner_Phone' => ['required'],
//            'Partner_CompanyName' => ['required'],
//            'Partner_CompanyINN' => ['required', 'max:12'],
//            'Partner_CompanyAddress' => ['required'],
//            'password' => ['required', 'string', 'min:6', 'confirmed'],
//            'confirmTerms' => ['required']
//        ]);
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|min:6|confirmed',
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
//            'diler_companyName' => $data['Partner_CompanyName'],
//            'diler_phone' => $data['Partner_Phone'],
//            'diler_web' => $data['Partner_CompanyWeb'],
//            'diler_inn' => $data['Partner_CompanyINN'],
//            'diler_address' => $data['Partner_CompanyAddress'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
