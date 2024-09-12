<?php 

namespace App\Laravel\Controllers\Portal;

use App\Laravel\Models\{Event,Booking,User,Category,UserKYC};

use App\Laravel\Requests\PageRequest;

use Str,DB,Carbon;

class MainController extends Controller{
    protected $data;
    
    public function __construct(){
        parent::__construct();
		array_merge($this->data?:[], parent::get_data());
        $this->data['page_title'] .= " - Dashboard";
    }

    public function index(PageRequest $request){
        $this->data['page_title'] .= " - Data";

        $this->data['total_registrations'] = UserKYC::all()->count();
        $this->data['total_accounts'] = User::where('status', 'active')->count();
        $this->data['total_events'] = Event::all()->count();
        $this->data['total_category'] = Category::all()->count();

        $this->data['pie_chart_data'] = [
            "pending" => Booking::where('status', 'pending')->count(),
            "approved" => Booking::where('status', 'approved')->count(),
            "cancelled" => Booking::where('status', 'cancelled')->count()
        ];

        $this->data['bar_chart_data'] = Booking::where('payment_status', 'paid')
        ->whereYear('created_at', now()->year)->with('event')->get()
        ->groupBy(function ($booking) {
            return Carbon::parse($booking->created_at)->format('m');
        })
        ->map(function ($bookings) {
            return $bookings->sum(function ($booking) {
                return $booking->event->price ?? 0;
            });
        });

        return view('portal.index', $this->data);
	}
}