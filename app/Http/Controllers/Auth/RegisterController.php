<?php

namespace App\Http\Controllers\Auth;

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

    private $uploadUserRelativePath = 'app/public/users/avatars/';
    private $assetUserRelativePath = 'storage/users/avatars/';

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        //Check for avatar upload
        $uploadedFile = array_get($data,'avatar',null);
        if (isset($uploadedFile)) {
            //Parsear y copiar imagen
            $filename = uniqid('user-avatar-') . '.' . $uploadedFile->getClientOriginalExtension();
            $moved = $uploadedFile->move(storage_path($this->uploadUserRelativePath), $filename);

            if(!$moved)
                throw new \Exception("Error moviendo archivo");

            $data['avatar_asset'] = asset($this->assetUserRelativePath . $filename);
        }

        $user =  User::create([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'descripcion' => array_get($data,'descripcion',null),
            'password' => bcrypt($data['password']),
            'avatar' => array_get($data,'avatar_asset',null)
        ]);

        return $user;
    }
}
