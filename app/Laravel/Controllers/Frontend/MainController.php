<?php

namespace App\Laravel\Controllers\Frontend;

use App\Laravel\Models\{Sponsor,Event,Page,FAQ,Booking};

use App\Laravel\Requests\PageRequest;

use Str,Carbon;

class MainController extends Controller{
    protected $data;
    
    public function __construct(){
        parent::__construct();
		array_merge($this->data?:[], parent::get_data());
        $this->data['page_title'] .= " - Web";
    }

    public function index(PageRequest $request){
        $this->data['page_title'] .= " - Dashboard";

        $this->data['total_pending'] = Booking::where('status', 'pending')
        ->where('user_id', $this->data['auth']->id)->count();
        
        $this->data['total_approved'] = Booking::where('status', 'approved')
        ->where('user_id', $this->data['auth']->id)->count();
       
        $this->data['total_cancelled'] = Booking::where('status', 'cancelled')
        ->where('user_id', $this->data['auth']->id)->count();

        $this->data['total_payment'] =  Booking::where('payment_status', 'paid')
        ->where('user_id', $this->data['auth']->id)
        ->with('event')->get()
        ->sum(function ($booking) {
            return $booking->event->price ?? 0;
        });

        $this->data['latest_events'] = Event::orderBy('created_at', 'desc')->limit(5)->get();

        $this->data['line_chart_data'] = Booking::where('payment_status', 'paid')->where('user_id', $this->data['auth']->id)
        ->whereYear('created_at', now()->year)->with('event')->get()
        ->groupBy(function ($booking) {
            return Carbon::parse($booking->created_at)->format('m');
        })
        ->map(function ($bookings) {
            return $bookings->sum(function ($booking) {
                return $booking->event->price ?? 0;
            });
        });

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