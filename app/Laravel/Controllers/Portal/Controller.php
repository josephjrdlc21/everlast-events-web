<?php

namespace App\Laravel\Controllers\Portal;

use App\Laravel\Controllers\Controller as BaseController;

use App\Laravel\Models\Setting;

use Route;

class Controller extends BaseController{

	protected $data;

	public function __construct(){
		self::set_current_route();
		self::set_loggedin_user();
		self::set_settings();
	}

	public function get_data(){
        $this->data['page_title'] = env("APP_NAME");
		return $this->data;
	}

	public function set_current_route(){
		 $this->data['current_route'] = Route::currentRouteName();
	}

	public function set_loggedin_user(){
		// consider Portal namespace will use the User model define in auth.php config file 
		// 'web' is the declared guard for User Model in auth.php and as default guard
		// adjust the guard "web" if necessary to other base Controller file like System namespace etc. if you'll use different Authenticable Model
		if (auth('portal')->user()) {
        	$this->data['auth'] = auth('portal')->user();
		}
	}

	public function set_settings(){
		$this->data['settings'] = Setting::orderBy('created_at', 'DESC')->first();
	}
}