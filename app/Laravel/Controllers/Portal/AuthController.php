<?php 

namespace App\Laravel\Controllers\Portal;

use App\Laravel\Models\{User,Role,PasswordReset,AuditTrail};

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Portal\{RegistrationRequest,ForgotPasswordRequest,PasswordRequest};

use App\Laravel\Notifications\Portal\{ResetPassword,ResetPasswordSuccess};

use Str,DB,Helper,Mail,Carbon;

class AuthController extends Controller{
    protected $data;
    protected $guard;
    
    public function __construct(){
        parent::__construct();
		array_merge($this->data?:[], parent::get_data());
        $this->data['roles'] = ['' => "-- Select Role --"] + Role::where('status','active')->pluck('name', 'name')->toArray();
        $this->data['page_title'] .= " - Portal";
        $this->guard = "portal";
    }
	
	public function register(PageRequest $request){
		$this->data['page_title'] .= " - Register";

		return view('portal.auth.register',$this->data);
	}

	public function store(RegistrationRequest $request){
		DB::beginTransaction();
		try{
			$password = Str::random(8);

            $user = new User;
            $user->firstname = Str::upper($request->input('firstname'));
            $user->lastname = Str::upper($request->input('lastname'));
            $user->middlename = Str::upper($request->input('middlename'));
            $user->suffix = Str::upper($request->input('suffix'));
            $user->name = "{$user->firstname} {$user->middlename} {$user->lastname} {$user->suffix}";
            $user->email = Str::lower($request->input('email'));
            $user->status = "inactive";
            $user->user_type = "portal";
            $user->contact_number = Helper::format_phone($request->input('contact'));
            $user->password = bcrypt($password);
            $user->save();

            $role = Role::where('name', $request->input('role'))->where('guard_name','portal')->first();
            $user->assignRole($role);

			DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Your default password was sent to email. Wait for your account activation.");
		}catch(\Exception $e){
			DB::rollback();

			session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
		}

		return redirect()->route('portal.auth.login');
	}

    public function login(PageRequest $request){
		$this->data['page_title'] .= " - Login";

		return view('portal.auth.login',$this->data);
	}

    public function authenticate(PageRequest $request,$uri = NULL){
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
				return redirect()->route('portal.auth.login');
			}

			if(Str::lower($account->user_type) != $this->guard){
				auth($this->guard)->logout();

				session()->flash('notification-status',"warning");
				session()->flash('notification-msg',"Unable to logged in. Admin access only.");
				return redirect()->route('portal.auth.login');
			}

			$account->last_login_at = now();
			$account->save();

            $audit_trail = new AuditTrail;
			$audit_trail->user_id = $account->id;
			$audit_trail->process = "LOGIN_PORTAL_USER";
			$audit_trail->ip = $this->data['ip'];
			$audit_trail->remarks = "{$account->name} has logged in.";
			$audit_trail->type = "USER_ACTION";
			$audit_trail->save();

			if($uri AND session()->has($uri)){
				session()->flash('notification-status',"success");
				session()->flash('notification-msg',"Welcome {$account->name}!");
				return redirect(session()->get($uri));
			}

			session()->flash('notification-status',"success");
			session()->flash('notification-msg',"Welcome {$account->name}!");
			return redirect()->route('portal.index');
		}

		session()->flash('notification-status',"failed");
		session()->flash('notification-msg',"Invalid account credentials.");
		return redirect()->back();
    }

	public function forgot_password(PageRequest $request){
        $this->data['page_title'] .= " - Forgot Password";

		return view('portal.auth.forgot-password', $this->data);
    }

	public function forgot_password_email(ForgotPasswordRequest $request){
        $email = strtolower($request->input('email'));
        $token = Str::random(60);

        $user = User::where('email', $email)->where('user_type', 'portal')->first();

        if(!$user){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
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
                $data = [
                    'email' => $email, 
                    'token' => $token, 
                    'setting' => "{$this->data['settings']->brand_name}"
                ];
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
            return redirect()->route('portal.auth.forgot_password');
        }

        return view('portal.auth.reset-password', $this->data);
    }

    public function store_password(PasswordRequest $request, $refid = null){
        $password_reset = PasswordReset::where('token', $refid)->first();
        $current_date_time = Carbon::now();

        if (!$password_reset) {
            session()->flash('notification-status', "warning");
            session()->flash('notification-msg', "Token is not valid. Please try again!");
            return redirect()->route('portal.auth.forgot_password');
        }

        $user = User::where('email', strtolower($password_reset->email))->where('user_type', 'portal')->first();

        if(!$user){
            session()->flash('notification-status', "warning");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.auth.forgot_password');
        }

        DB::beginTransaction();
        try{
            $user->password = bcrypt($request->input('password'));
            $user->save();

            if (env('MAIL_SERVICE', false)) {
                $data = [
                    'email' => $password_reset->email, 
                    'date_time' => $current_date_time->format('m/d/Y h:i A'),
                    'setting' => "{$this->data['settings']->brand_name}"
                ];
                Mail::to($password_reset->email)->send(new ResetPasswordSuccess($data));
            }

            PasswordReset::where('email', $user->email)->delete();

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "New password successfully stored. Login to the platform using your updated credentials.");

            auth($this->guard)->login($user);
            return redirect()->route('portal.index');
        }catch(\Exception $e){
            DB::rollback();

            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
        }

        return redirect()->back();
    }

    public function logout(PageRequest $request){
		auth($this->guard)->logout();

        $audit_trail = new AuditTrail;
        $audit_trail->user_id = $this->data['auth']->id;
        $audit_trail->process = "LOGOUT_PORTAL_USER";
        $audit_trail->ip = $this->data['ip'];
        $audit_trail->remarks = "{$this->data['auth']->name} has logged out.";
        $audit_trail->type = "USER_ACTION";
        $audit_trail->save();
		
		session()->flash('notification-status', "success");
		session()->flash('notification-msg', "Logged out successfully.");
		return redirect()->route('portal.auth.login');
	}
}