<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
//use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use App\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Mail\EmailVerificationMail;
use App\Mail\ForgetPasswordMail;
use App\PasswordReset;
use Carbon\Carbon;


class UserController extends Controller
{
    private function verifyRecaptcha($request) {
        $grecaptcha=$request->grecaptcha;
        $client = new Client();
        $response = $client->post(
            "https://www.google.com/recaptcha/api/siteverify",
            ["form_params"=>
                [
                    "secret"=>env("GOOGLE_CAPTCHA_SECRET"),
                    "response"=>$grecaptcha
                ]
            ]
        );
        return json_decode( (string)$response->getBody() );
    }

    public function getRegister() {  // Checked
        return view("auth.register");
    }

    public function postRegister(RegisterRequest $request){  // Checked
        $validatedData = $request->validated();

        $response_getBody = $this->verifyRecaptcha($request);
        if($response_getBody->success==true){
            if (
                $user=User::create([
                    "first_name"=>$request->first_name,
                    "last_name"=>$request->last_name,
                    "username"=>$request->username,
                    "email"=>$request->email,
                    "password"=>Hash::make($request->password),
                    "email_verification_code"=>$request->username.Str::random(40) // TODO know what is that
                ])
            ) {
//                return redirect()->route("getLogin")->withInput($validatedData);
                Mail::to($request->email)->send(new EmailVerificationMail($user));
                return redirect()->route("getLogin")->withInput($validatedData)->with(
                    "success",
                    "Registration successfull. Please check your email address for email verification link."
                );
            } else {
                return redirect()->route("getRegister")->withInput($validatedData)->withErrors($validatedData);
            }
        } else {
            return redirect()->back()->with("error","Invalid recaptcha");
        }
    }

    public function ajaxRegister(RegisterRequest $request){  // Checked
        $validatedData = $request->validated();

        $response_getBody = $this->verifyRecaptcha($request);
        if($response_getBody->success==true){
            $user=User::create([
                "first_name"=>$request->first_name,
                "last_name"=>$request->last_name,
                "username"=>$request->username,
                "email"=>$request->email,
                "password"=>Hash::make($request->password),
                "email_verification_code"=>$request->username.Str::random(40)
            ]);
            Mail::to($request->email)->send(new EmailVerificationMail($user));
            return response()->json([
                "message"=>"Registration successfull. Please check your email address for email verification link.",
                "redirect_url"=>route("getLogin")
            ],200);
        } else {
            return response()->json([
                "message"=>"Invalid recaptcha"
            ],400);
        }
    }

    public function getLogin() {  // Checked
        if (Auth::check()) {
            return redirect()->route("home");
        }
        else {
            return view("auth.login");
        }
    }

    public function postLogin(LoginRequest $request){  // Checked
        $fieldType  = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? "email" : "username";
        $userData   = array($fieldType => $request->username, "password" => $request->password);
        $response_getBody = $this->verifyRecaptcha($request);
        if($response_getBody->success==true){
            $remember = ( $request->remember ) ? true : false;
            if (
            Auth::attempt($userData)
            ) {
                Auth::login(Auth::user(), $remember);
                if (session("url.intended")) {
                    return redirect(session()->pull("url.intended"));
                } else {
                    return redirect()
                        ->route("home")
                        ->with("success", "Login successfull");
                }
            } else {
                $error_message = "Неверные аутентификационные данные";
                return redirect()
                    ->route("getLogin")
                    ->withErrors($error_message)
                    ->with("error", $error_message)
                    ->withInput();
            }
        } else {
            $error_message = "Invalid recaptcha";
            return redirect()
                ->back()
                ->with("error", $error_message);
        }
    }

    public function ajaxLogin(LoginRequest $request){  // Checked
        $response_getBody = $this->verifyRecaptcha($request);
        if ($response_getBody->success == true) {
            $user=User::where("email", $request->email)->first();
            if(!$user){
                return response()->json([
                    "message"=>"Email is not registered"
                ], 400);
            } else {
                if(!$user->email_verified_at){
                    return response()->json([
                        "message"=>"Email is not verified"
                    ], 400);
                } else {
                    if(!$user->is_active){
                        return response()->json([
                            "message" => "User is not active. Contact admin"
                        ], 400);
                    } else {
                        $remember = ( $request->remember ) ? true : false;
                        if(auth()->attempt($request->only('email','password'),$remember)){
                            return response()->json([
                                "message"=>"Login successful",
                                "redirect_url"=>route("dashboard")
                            ],200);
                        } else {
                            return response()->json([
                                "message"=>"Invalid credentials"
                            ],400);
                        }
                    }
                }
            }
        } else {
            return response()->json([
                "message"=>"Invalid recaptcha"
            ],400);
        }
    }

    public function getForgetPassword(){
        return view("auth.forget_password");
    }

    public function postForgetPassword(Request $request){
        $request->validate([
            "email"=>"required|email"
        ]);
        $user=User::where("email",$request->email)->first();
        if(!$user){
            return redirect()->back()->with("error","User not found.");
        }else{
            $reset_code=Str::random(200);
            PasswordReset::create([
                "user_id"=>$user->id,
                "reset_code"=>$reset_code
            ]);
            Mail::to($user->email)->send(new ForgetPasswordMail($user->first_name, $reset_code));
            return redirect()
                ->back()
                ->with("success","We have sent you a password reset link. Please check your email.");
        }
    }

    public function getResetPassword($reset_code){
        $password_reset_data = PasswordReset::where("reset_code",$reset_code)->first();
        if(!$password_reset_data || Carbon::now()->subMinutes(10) > $password_reset_data->created_at){
            return redirect()
                ->route("getForgetPassword")
                ->with("error","Invalid password reset link or link expired.");
        }else{
            return view("auth.reset_password",compact("reset_code"));
        }
    }

    public function postResetPassword($reset_code, Request $request){
        $password_reset_data = PasswordReset::where("reset_code",$reset_code)->first();
        if(!$password_reset_data || Carbon::now()->subMinutes(10)> $password_reset_data->created_at){
            return redirect()->route("getForgetPassword")->with("error","Invalid password reset link or link expired.");
        }else{
            $request->validate([
                "email"=>"required|email",
                "password"=>"required|min:6|max:100",
                "confirm_password"=>"required|same:password",
            ]);
            $user=User::find($password_reset_data->user_id);
            if($user->email != $request->email){
                return redirect()->back()->with("error","Enter correct email.");
            } else {
                $password_reset_data->delete();
                $user->update([
                    "password"=>Hash::make($request->password)
                ]);
                return redirect()->route("getLogin")->with("success","Password successfully reset. ");
            }
        }
    }

    public function check_username_unique(Request $request){
        $user=User::where("username", $request->username)->first();
        if ($user) {
            return "false";
        } else {
            return "true";
        }
    }

    public function check_email_unique(Request $request){
        $user=User::where("email",$request->email)->first();
        if($user){
            return "false";
        }else{
            return "true";
        }
    }

    public function verify_email($verification_code){
        $user = User::where("email_verification_code", $verification_code)->first();
        if(!$user){
            return redirect()->route("getRegister")->with("error", "Invalid URL");
        } else {
            if($user->email_verified_at){
                return redirect()->route("getLogin")->with("error", "Email already verified");
            } else {
                $user->update([
                    "email_verified_at"=>\Carbon\Carbon::now()
                ]);
                return redirect()->route("getLogin")->with("success", "Email successfully verified");
            }
        }
    }

    public function home() {  // Checked
        if (Auth::user()) {
            return view("auth.home");
        }
        else {
            return redirect()->route("getLogin");
        }
    }

    public function logout(){  // Checked
        Session::flush();
        Auth::logout();
        return redirect()->route("getLogin")->with("success","Logout successfull");
    }

    public function test(){  // Checked
        Auth::logout();
        return view("auth.test");
    }
}
