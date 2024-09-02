<?php 

namespace App\Laravel\Controllers\Frontend;

use App\Laravel\Models\{UserKYC,User,PasswordReset};

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Frontend\{ForgotPasswordRequest,RegistrationRequest,PasswordRequest};

use App\Laravel\Notifications\Frontend\{ResetPassword,ResetPasswordSuccess};

use Str,DB,Helper,Mail,Carbon;

class AuthController extends Controller{
    protected $data;
    protected $guard;
    
    public function __construct(){
        parent::__construct();
		array_merge($this->data?:[], parent::get_data());
        $this->data['page_title'] .= " - Frontend";
        $this->guard = "frontend";
    }

    public function login(PageRequest $request){
		$this->data['page_title'] .= " - Login";

		return view('frontend.auth.login',$this->data);
	}

    public function authenticate(PageRequest $request){
        $email = Str::lower($request->input('email'));
        $password = $request->input('password');

		$remember_me = $request->input('remember_me',0);
		$field = filter_var($email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		if(auth($this->guard)->attempt([$field => $email,'password' => $password],$remember_me)){
			$account = auth($this->guard)->user();
			
			if(Str::lower($account->status) != "active"){
				auth($this->guard)->logout();

				session()->flash('notification-status',"info");
				session()->flash('notification-msg',"Account locked. Access to system was removed.");
				return redirect()->route('frontend.auth.login');
			}

			if(Str::lower($account->user_type) != $this->guard){
				auth($this->guard)->logout();

				session()->flash('notification-status',"warning");
				session()->flash('notification-msg',"Unable to logged in. Authorized access only.");
				return redirect()->route('frontend.auth.login');
			}
            
			$account->last_login_at = now();
			$account->save();

			session()->flash('notification-status',"success");
			session()->flash('notification-msg',"Welcome {$account->name}!");
			return redirect()->route('frontend.index');
		}

		session()->flash('notification-status',"failed");
		session()->flash('notification-msg',"Invalid account credentials.");
		return redirect()->back();
    }

    public function register(PageRequest $request){
		$this->data['page_title'] .= " - Register";

		return view('frontend.auth.register',$this->data);
	}

    public function store(RegistrationRequest $request){
        DB::beginTransaction();
        try{
            $user_kyc = new UserKYC;
            $user_kyc->firstname = Str::upper($request->input('firstname'));
            $user_kyc->lastname = Str::upper($request->input('lastname'));
            $user_kyc->middlename = Str::upper($request->input('middlename'));
            $user_kyc->suffix = Str::upper($request->input('suffix'));
            $user_kyc->name = "{$user_kyc->firstname} {$user_kyc->middlename} {$user_kyc->lastname} {$user_kyc->suffix}";
            $user_kyc->email = Str::lower($request->input('email'));
            $user_kyc->status = "pending";
            $user_kyc->user_type = $this->guard;
            $user_kyc->password = bcrypt($request->input('password'));
            $user_kyc->contact_number = Helper::format_phone($request->input('contact'));
            $user_kyc->save();

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Your account is being verify. Please wait for the admin to approve your account.");
            return redirect()->route('frontend.auth.login');
        }catch(\Exception $e){
            DB::rollback();

            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to register your account.");
        return redirect()->back();
    }

    public function forgot_password(PageRequest $request){
        $this->data['page_title'] .= " - Forgot Password";

		return view('frontend.auth.forgot-password',$this->data);
    }

    public function forgot_password_email(ForgotPasswordRequest $request){
        $email = strtolower($request->input('email'));
        $token = Str::random(60);

        $user = User::where('email', $email)->where('user_type', 'frontend')->first();

        if(!$user){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Email not found.");
            return redirect()->back();
        }

        if($user->status == "inactive"){
            session()->flash('notification-status', "warning");
            session()->flash('notification-msg', "Unable to process this request because account is locked.");
            return redirect()->back();
        }

        try{
            PasswordReset::where('email', $email)->delete();

            if(env('MAIL_SERVICE', false)){
                $data = ['email' => $email, 'token' => $token];
                Mail::to($email)->send(new ResetPassword($data));
            }

            $password_reset = new PasswordReset;
            $password_reset->email = $email;
            $password_reset->token = $token;
            $password_reset->created_at = Carbon::now();
            $password_reset->save();
        }catch(\Exception $e){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "success");
        session()->flash('notification-msg', "Password reset was sent successfully to your email.");
        return redirect()->back();
    }

    public function reset_password(PageRequest $request,$refid = null){
        $this->data['page_title'] .= " - Reset Password";

        $password_reset = PasswordReset::where('token', $refid)->first();

        if(!$password_reset){
            session()->flash('notification-status', "warning");
            session()->flash('notification-msg', "Token is not valid. Please try again!");
            return redirect()->route('frontend.auth.forgot_password');
        }

        return view('frontend.auth.reset-password', $this->data);
    }

    public function store_password(PasswordRequest $request, $refid = null){
        $password_reset = PasswordReset::where('token', $refid)->first();
        $current_date_time = Carbon::now();

        if (!$password_reset) {
            session()->flash('notification-status', "warning");
            session()->flash('notification-msg', "Token is not valid. Please try again!");
            return redirect()->route('frontend.auth.forgot_password');
        }

        $user = User::where('email', strtolower($password_reset->email))->where('user_type', 'frontend')->first();

        if(!$user){
            session()->flash('notification-status', "warning");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('frontend.auth.forgot_password');
        }

        $user->password = bcrypt($request->input('password'));
        $user->save();

        if (env('MAIL_SERVICE', false)) {
            $data = ['email' => $password_reset->email, 'date_time' => $current_date_time->format('m/d/Y h:i A')];
            Mail::to($password_reset->email)->send(new ResetPasswordSuccess($data));
        }

        PasswordReset::where('email', $user->email)->delete();

        session()->flash('notification-status', "success");
        session()->flash('notification-msg', "New password successfully stored. Login to the platform using your updated credentials.");

        auth($this->guard)->login($user);
        return redirect()->route('frontend.index');
    }

    public function logout(PageRequest $request){
        auth($this->guard)->logout();
		
		session()->flash('notification-status', "success");
		session()->flash('notification-msg', "Logged out successfully.");
		return redirect()->route('frontend.auth.login');
    }
}