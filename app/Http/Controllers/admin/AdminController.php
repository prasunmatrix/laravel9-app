<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use Validator;
use Hash;
use Illuminate\Support\Str;
use App\Models\{User,PasswordReset};

class AdminController extends Controller
{
  public function index(Request $request)
  {
    //dd('test');
    $this->data['page_title'] = 'Control Panel:Login';
    $this->data['panel_title'] = 'Control Panel:Login';
    if (Auth::guard('admin')->check()) {
      // If admin is logged in, redirect him to dashboard page //
      return \Redirect::route('admin.dashboard');
    } else {
      return view('admin.login.admin_login', $this->data);
    }
  }
  public function verifylogin(Request $request)
  {
    //dd($request->all());
    if (Auth::guard('admin')->check()) {
      // If admin is logged in, redirect him/her to dashboard page //
      return Redirect::Route('admin.dashboard');
    } else {
      try {
        if ($request->isMethod('post')) {
          // Checking validation
          $validationCondition = array(
            'email' => 'required',
            'password' => 'required',
          );
          $Validator = Validator::make($request->all(), $validationCondition);

          if ($Validator->fails()) {
            // If validation error occurs, load the error listing
            return Redirect::route('admin.login')->withErrors($Validator);
          } else {
            $rememberMe = false; // set default boolean value for remember me

            if ($request->input('remember')) // if user checked remember me
              $rememberMe = true; // set user value
              //dd($rememberMe);
            $email = $request->input('email');
            $password = $request->input('password');

            /* Check if user with same email exists, who is:-
                    1. Blocked or Not
                      */
            $userExists = User::where(
              array(
                'email' => $email,
                'status' => 'A',
              )
            )->count();


            if ($userExists > 0) {
              // if user exists, check the password
              $auth = auth()->guard('admin')->attempt([
                'email' => $email,
                'password' => $password,
              ], $rememberMe);

              if ($auth) {
                return Redirect::Route('admin.dashboard');
              } else {
                $request->session()->flash('error', 'Invalid Password');
                return Redirect::Route('admin.login');
              }
            } else {
              $request->session()->flash('error', 'You are not an authorized user');
              return Redirect::Route('admin.login');
            }
          }
        }
      } catch (Exception $e) {
        return Redirect::Route('admin.login')->with('error', $e->getMessage());
      }
    }
  }
  public function dashboardView(Request $request)
  {
    //dd('test');
    //$this->data['page_title'] = 'Admin | Dashboard';
    $this->data['panel_title'] = 'Admin Dashboard';
    return view('admin.dashboard.index', $this->data);
  }
  public function logout()
  {
    //echo "aaa";die;
    //dd(Auth::guard('admin'));
    if (Auth::guard('admin')->logout()) {
      return Redirect::Route('admin.login');
    } else {
      return Redirect::Route('admin.dashboard');
    }
  }
  public function forgetPassword(Request $request)
  {
    $data['page_title'] = 'Admin | Recover Password';
    $data['panel_title'] = 'Recover Password';
    if (Auth::guard('admin')->check()) {
      // If admin is logged in, redirect him to dashboard page //
      return \Redirect::route('admin.dashboard');
    } else {
      return view('admin.login.forgotpassword', $data);
    }
  }
  public function postForgetPassword(Request $request)
  {
    //dd($request->all());
    $validator = Validator::make(
      $request->all(),
      [
        'resetemail'                 => 'required|email',
      ],
      [
        'resetemail.required'       => 'An email is required',
        'resetemail.email'          => 'This is an invalid email format',
      ]
    );
    if ($validator->fails()) {
      $resetEmailErr = array();
      $resetEmailErr['resetemailerror'] = $validator->errors()->first();
      return Redirect::back()
        ->withErrors($resetEmailErr)
        ->withInput();
    }
    $userEmail = trim($request->get('resetemail'));
    $user = User::where('email', $userEmail)->first();
    if ($user == null) {
      $resetEmailErr = array();
      $resetEmailErr['resetemailerror'] = 'You are not a registered user';
      return Redirect::back()
        ->withErrors($resetEmailErr)
        ->withInput();
    }
    $userStatus = $user->status;
    if ($userStatus == 'I') {
      $resetEmailErr = array();
      $resetEmailErr['resetemailerror'] = 'Please confirm your email first';
      return Redirect::back()
        ->withErrors($resetEmailErr)
        ->withInput();
    } else {
      $token = Str::random(250);
      //dd($token);
      $passwordResetExists = PasswordReset::where('email', $userEmail)->first();
      //dd($passwordResetExists);
      if ($passwordResetExists == null) {
        PasswordReset::create([
          'email'      => $userEmail,
          'token'      => $token
        ]);
      } else {
        PasswordReset::where('email', $userEmail)->update([
          'token' => $token
        ]);
      }
      \Mail::send(
        'email_templates.password_reset',
        [
          'user' => $userEmail,
          'app_config' => [
            'token'      => $token,
            //'appLink'       => Helper::getBaseUrl(),
            'controllerName' => 'user',
            'subject'       => 'A password reset request was made.',
          ],
        ],
        function ($m) use ($userEmail) {
          $m->to($userEmail)->subject('Password Reset');
        }
      );
      $successMsg = "A password reset link has been sent to your email";
      return Redirect::back()
        ->withSuccess($successMsg);
    }
  }
  public function getResetPassword($token)
  {
    if (Auth::guard('admin')->check()) {
      // If admin is logged in, redirect him to dashboard page //
      return \Redirect::route('admin.dashboard');
    } else {
      if (is_null($token)) {
        return Redirect::to('admin');
      } else {
        $token = trim($token);
        $tokenExists = PasswordReset::where('token', $token)->first();
        //dd($tokenExists);
        if ($tokenExists == null) {
          return Redirect::to('admin');
        } else {
          $data['page_title'] = 'Recover Password';
          $data['panel_title'] = 'Recover Password';
          $data['tok3n'] = $token;
          return view('admin.login.resetpassword', $data);
        }
      }
    }
  }
  public function postResetPassword(Request $request)
  {
    //dd($request);
    if (Auth::guard('admin')->check()) {
      // If admin is logged in, redirect him/her to dashboard page //
      return Redirect::Route('admin.dashboard');
    } else {
      $validator = Validator::make(
        $request->all(),
        [
          'password'              => 'required|confirmed|min:8',
          'tok3n'                 => 'required',
        ],
        [
          'password.min'          => 'Password must be :min chars long',
          'password.confirmed'    => 'Password & Confirm Password must be same',
          'tok3n.required'        => 'Token Missing',
        ]
      );
      if ($validator->fails()) {
        return Redirect::back()
          ->withErrors($validator)
          ->withInput();
      } else {
        $resetToken = trim($request->get('tok3n'));
        //dd($resetToken);
        $newPassword = trim($request->get('password'));
        $passwordResetExists = PasswordReset::where('token', $resetToken)->first();
        if ($passwordResetExists == null) {
          $resetPasswordErr = array();
          $resetPasswordErr['reseterror'] = 'Invalid Token';
          return Redirect::back()
            ->withErrors($resetPasswordErr)
            ->withInput();
        } else {
          $resetEmail = $passwordResetExists->email;
          //dd($resetEmail);
          $user = User::where('email', $resetEmail)->first();
          if ($user == null) {
            $resetPasswordErr = array();
            $resetPasswordErr['reseterror'] = 'You are not a registered user';
            return Redirect::back()
              ->withErrors($resetPasswordErr)
              ->withInput();
          } else {
            // $user->update([
            //   'password' => $newPassword,
            // ]);
            // $user->save();
            $newPasswordHash = Hash::make($newPassword);
            //dd($newPasswordHash);
            $userPass = User::where('email', $resetEmail)->update(['password' => $newPasswordHash]);
            //dd($userPass);
            PasswordReset::where('email', $resetEmail)->delete();
            // $request->session()->flash('alert-success', 'New Password has been set successfully');
            // return redirect()->route('admin.login');
            $successMsg = 'New Password has been set successfully';
            return Redirect('admin')
              ->withSuccess($successMsg);
          }
        }
      }
    }
  }
}
