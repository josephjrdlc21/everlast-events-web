<?php

namespace App\Laravel\Controllers\Frontend;

use App\Laravel\Models\{Sponsor,Event,Page,FAQ};

use App\Laravel\Requests\PageRequest;

use Str;

class MainController extends Controller{
    protected $data;
    
    public function __construct(){
        parent::__construct();
		array_merge($this->data?:[], parent::get_data());
        $this->data['page_title'] .= " - Web";
    }

    public function index(PageRequest $request){
        $this->data['page_title'] .= " - Dashboard";

        return view('frontend.index', $this->data);
	}

    public function home(PageRequest $request){
        $this->data['page_title'] .= " - Home";

        $this->data['sponsors'] = Sponsor::orderBy('created_at', 'desc')->limit(6)->get();
        $this->data['events'] = Event::orderBy('created_at', 'desc')->limit(6)->get();
        $this->data['faqs'] = FAQ::where('status', 'active')->orderBy('created_at', 'desc')->limit(5)->get();
        $this->data['about'] = Page::where('type', 'about')->first();
        $this->data['contact'] = Page::where('type', 'contact')->first();
        $this->data['banner'] = Page::where('type', 'banner')->first();

        return view('frontend.home', $this->data);
	}
}