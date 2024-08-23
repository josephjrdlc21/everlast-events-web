<?php 

namespace App\Laravel\Controllers\Portal;

use App\Laravel\Requests\PageRequest;

use Str;

class AuthController extends Controller{
    protected $data;
    protected $guard;
    
    public function __construct(){
        parent::__construct();
		array_merge($this->data?:[], parent::get_data());
        $this->data['page_title'] .= " - Portal";
        $this->guard = "portal";
    }
	
	public function register(PageRequest $request){
		$this->data['page_title'] .= " - Register";

		return view('portal.auth.register',$this->data);
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

    public function logout(PageRequest $request){
		auth($this->guard)->logout();
		
		session()->flash('notification-status', "success");
		session()->flash('notification-msg', "Logged out successfully.");
		return redirect()->route('portal.auth.login');
	}
}