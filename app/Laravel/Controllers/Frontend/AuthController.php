<?php 

namespace App\Laravel\Controllers\Frontend;

use App\Laravel\Requests\PageRequest;

use Str;

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

    public function register(PageRequest $request){
		$this->data['page_title'] .= " - Register";

		return view('frontend.auth.register',$this->data);
	}
}