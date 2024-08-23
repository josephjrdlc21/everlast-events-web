<?php

namespace App\Laravel\Controllers\Frontend;

use App\Laravel\Requests\PageRequest;

use Str;

class MainController extends Controller{
    protected $data;
    
    public function __construct(){
        parent::__construct();
		array_merge($this->data?:[], parent::get_data());
        $this->data['page_title'] .= " - Dashboard";
    }

    public function index(PageRequest $request){
        $this->data['page_title'] .= " - Data";

        return view('frontend.index', $this->data);
	}
}