<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectClientTo = '/';
    protected $redirectAdminTo = '/admin/categories';
    protected $redirectEmployeeTo = '/employee/v1/order';
    protected $redirectEmployeeAdminTo = '/employee_admin/v1/order';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function userAthentication(Request $request)
    {


        $validator = Validator::make($request->all(), [
        'email'             => 'required',
        'password'          => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->route('user.login')->withInput()->withErrors($validator);
        }

        $authentication = \App::make('authenticator');
        $authentication_helper = \App::make('authentication_helper');


        $email      = $request->email;

        $password   = $request->password;
//        $password   = Hash::make($password);

        $remember   = $request->remember;

        $credentials = array("email" => $email, "password" => $password);

        if ($remember == null){
            $remember = false;
        }

        try
        {
            $authenticated = $authentication->authenticate($credentials, $remember);


            dd('$authenticated', $authenticated);

            if(!$authenticated){

                $user = $authentication->getUser($email);
            }else{

                $errors = "En-valid email address or password.";
                return redirect()->route("user.login")->withInput()->withErrors($errors);
            }

            if( ! $user){

                $errors = "Envalid email address.";
                return redirect()->route("user.login")->withInput()->withErrors($errors);
            }

            $adminPermissions = '_superadmin';
            $clientPermissions = '_customer';
            $employeePermissions = '_employee';
            $employeeAdminPermissions = '_employee_admin';

            try
            {

                $perm = $user->permissions;

                foreach($perm as $key=> $val)
                {
                    $permission_name = $key;
                }


                $authentication_helper->hasPermission($perm);

                if ($permission_name == $adminPermissions){

                    return redirect($this->redirectAdminTo);

                }elseif ($permission_name == $clientPermissions){

                    return redirect($this->redirectClientTo);

                }elseif ($permission_name == $employeePermissions){

                    return redirect($this->redirectEmployeeTo);

                }elseif ($permission_name == $employeeAdminPermissions){

                    return redirect($this->redirectEmployeeAdminTo);

                }

            }
            catch(JacopoExceptionsInterface $e)
            {
                $errors = "User's permissions error";
                return redirect()->route("user.login")->withInput()->withErrors($errors);
            }

        }
        catch(JacopoExceptionsInterface $e)
        {
            $errors = "User's authentication is failed";
            return redirect()->route("user.login")->withInput()->withErrors($errors);
        }

    }

}
