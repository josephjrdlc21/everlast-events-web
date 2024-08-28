<?php 

namespace App\Laravel\Controllers\Frontend;

use App\Laravel\Models\UserKYC;

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Frontend\RegistrationRequest;

use Str,DB,Helper;

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

    public function logout(PageRequest $request){
        auth($this->guard)->logout();
		
		session()->flash('notification-status', "success");
		session()->flash('notification-msg', "Logged out successfully.");
		return redirect()->route('frontend.auth.login');
    }
}