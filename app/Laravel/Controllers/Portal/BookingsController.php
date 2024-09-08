<?php

namespace App\Laravel\Controllers\Portal;

use App\Laravel\Models\Booking;

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Portal\BookingRequest;

use Carbon,DB;

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

        return view('portal.bookings.index', $this->data);
    }

    public function edit_status(PageRequest $request,$id = null,$status = "pending"){
        $this->data['page_title'] .= " - Update Booking Status";
        $this->data['booking'] = Booking::find($id);

        if(!$this->data['booking']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.bookings.index');
        }

        return view('portal.bookings.edit-status', $this->data);
    }

    public function update_status(BookingRequest $request,$id = null,$status = "pending"){
        $booking = Booking::find($id);

        if(!$booking){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.bookings.index');
        }    

        DB::beginTransaction();
        try{
            switch ($status) {
                case "cancelled":
                    $booking->status = "cancelled";
                    break;
            
                case "approved":
                    $booking->status = "approved";
                    break;
            
                default:
                    $booking->status = "pending";
                    break;
            }
            
            $booking->admin_remarks = $request->input('remarks');
            $booking->save();

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Booking has been {$booking->status}.");
            return redirect()->route('portal.bookings.show', [$id]);
        }catch(\Exception $e){
            DB::rollback();

            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to process booking status.");
        return redirect()->route('portal.bookings.index');
    }

    public function update_payment(PageRequest $request,$id = null){
        $booking = Booking::find($id);

        if(!$booking){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.bookings.index');
        }

        DB::beginTransaction();
        try{
            $booking->payment_status = $booking->payment_status === 'unpaid' ? 'paid' : 'unpaid';
            $booking->save();
               
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Payment has been {$booking->payment_status}.");
        }catch(\Exception $e){
            DB::rollBack();

            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        return redirect()->route('portal.bookings.index');
    }

    public function show(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Information";
        $this->data['booking'] = Booking::find($id);

        if(!$this->data['booking']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.bookings.index');
        }

        return view('portal.bookings.show', $this->data);
    }
}