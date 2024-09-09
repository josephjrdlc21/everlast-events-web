<?php

namespace App\Laravel\Controllers\Frontend;

use App\Laravel\Models\{Event,Booking};

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Frontend\BookingRequest;

use Str,Carbon,DB,SnappyPDF;

class BookingsController extends Controller{
    protected $data;

    public function __construct(){
        parent::__construct();
        array_merge($this->data?:[], parent::get_data());
        $this->data['page_title'] .= " - Bookings";
        $this->per_page = env("DEFAULT_PER_PAGE", 10);
    }

    public function index(PageRequest $request){
        $this->data['page_title'] .= " - List of Bookings";

        $this->data['keyword'] = strtolower($request->get('keyword'));

        $first_record = Booking::orderBy('created_at', 'ASC')->first();
        $start_date = $request->get('start_date', now()->startOfMonth());
        if ($first_record) {
            $start_date = $request->get('start_date', $first_record->created_at->format("Y-m-d"));
        }

        $this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
        $this->data['end_date'] = Carbon::parse($request->get('end_date', now()))->format("Y-m-d");

        $this->data['record'] = Booking::where(function ($query) {
            if (strlen($this->data['keyword']) > 0) {
                return $query
                    ->whereRaw("LOWER(code) LIKE '%{$this->data['keyword']}%'")
                    ->orWhereHas('event', function ($q) {
                        $q->whereRaw("LOWER(name) LIKE '%{$this->data['keyword']}%'");
                    });
            }
        })
        ->where(function ($query) {
            return $query->where(function ($q) {
                if(strlen($this->data['start_date']) > 0) {
                    return $q->whereDate('created_at', '>=', Carbon::parse($this->data['start_date'])->format("Y-m-d"));
                }
            })->where(function ($q) {
                if(strlen($this->data['end_date']) > 0) {
                    return $q->whereDate('created_at', '<=', Carbon::parse($this->data['end_date'])->format("Y-m-d"));
                }
            });
        })
        ->orderBy('created_at','DESC')
        ->paginate($this->per_page);

        return view('frontend.bookings.index', $this->data);
    }

    public function create(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Create Booking";
        $this->data['event'] = Event::find($id);

        if(!$this->data['event']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('frontend.events.index');
        }

        return view('frontend.bookings.create', $this->data);
    }

    public function store(BookingRequest $request,$id = null){
        DB::beginTransaction();
        try{
            $booking = new Booking;
            $booking->code = str_pad(mt_rand(0, 999999999), 9, '0', STR_PAD_LEFT);
            $booking->event_id = $request->input('event_id');
            $booking->user_id = $this->data['auth']->id;
            $booking->client_remarks = $request->input('remarks');
            $booking->save();

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "You have successfully book an event.");
            return redirect()->route('frontend.bookings.index');
        }catch(\Exception $e){
            DB::rollback();

            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to process your booking.");
        return redirect()->route('frontend.events.show', [$id]);
    }

    public function show(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Information";
        $this->data['booking'] = Booking::find($id);

        if(!$this->data['booking']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('frontend.bookings.index');
        }

        return view('frontend.bookings.show', $this->data);
    }

    public function update_status(PageRequest $request,$id = null){
        $booking = Booking::find($id);

        if(!$booking){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('frontend.bookings.index');
        }

        DB::beginTransaction();
        try{
            $booking->status = 'cancelled';
            $booking->save();
        
            DB::commit();

            session()->flash('notification-status', 'success');
            session()->flash('notification-msg', "Your booking has been cancelled.");
            return redirect()->route('frontend.bookings.show', [$id]);        
        }catch(\Exception $e){
            DB::rollback();
            
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
        }
        return redirect()->back();
    }

    public function export_pdf(PageRequest $request,$id = null){
        $this->data['booking'] = Booking::find($id);

        if(!$this->data['booking']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('frontend.bookings.index');
        }

        $pdf = SnappyPDF::loadView('frontend.pdf.receipt', $this->data)
            ->setPaper('a4')
            ->setOrientation('portrait')
            ->setOption('enable-local-file-access', true);

        return $pdf->download("booking-receipt.pdf");
    }
}