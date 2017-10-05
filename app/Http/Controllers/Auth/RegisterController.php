<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function confirm($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            echo "Invalid confirmation_code";
        }

        $user = User::where('confirmation_code',$confirmation_code)->first();

        if ( ! $user)
        {
            echo "Invalid confirmation_code";
        } else{
        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        \Flash::message('You have successfully verified your account.');

        return Redirect::route('login');
        }
    }
    protected function create(array $data)
    {
        $confirmation_code = str_random(30);

        $ruser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'confirmation_code' => $confirmation_code
        ]);

        \Mail::send('email.verify', ['confirmation_code' => $confirmation_code], function($message)  use ($ruser){
            $message->to($ruser['email'], $ruser['name'])
                ->subject('Verify your email address');
        });

        return $ruser;
    }
}
