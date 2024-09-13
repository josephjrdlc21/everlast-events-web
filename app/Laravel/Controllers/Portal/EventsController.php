<?php

namespace App\Laravel\Controllers\Portal;

use App\Laravel\Models\{Event,Category,Sponsor,AuditTrail};

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Portal\EventRequest;

use Str,Carbon,DB,ImageUploader,ImageRemover;

class EventsController extends Controller{
    protected $data;
    protected $event_code;

    public function __construct(){
        parent::__construct();
        array_merge($this->data?:[], parent::get_data());
        $this->data['page_title'] .= " - Events";
        $this->data['categories'] = ['' => "-- Select Category --"] + Category::where('status', 'active')->pluck('title', 'id')->toArray();
        $this->data['sponsors'] = ['' => "-- Select Sponsor --"] + Sponsor::pluck('name', 'id')->toArray();
        $this->event_code = 'EV-' . strtoupper(Str::random(5)) . random_int(10000, 99999);
        $this->per_page = env("DEFAULT_PER_PAGE", 10);
    }

    public function index(PageRequest $request){
        $this->data['page_title'] .= " - List of Events";

        $this->data['keyword'] = strtolower($request->get('keyword'));
        $this->data['selected_category'] = $request->input('category');
        $this->data['selected_sponsor'] = $request->input('sponsor');
        $this->data['selected_cancel'] = $request->input('cancel');

        $first_record = Event::orderBy('created_at', 'ASC')->first();
        $start_date = $request->get('start_date', now()->startOfMonth());
        if ($first_record) {
            $start_date = $request->get('start_date', $first_record->created_at->format("Y-m-d"));
        }

        $this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
        $this->data['end_date'] = Carbon::parse($request->get('end_date', now()))->format("Y-m-d");
        $this->data['categories'] = ['' => "All"] + Category::where('status', 'active')->pluck('title', 'id')->toArray();
        $this->data['sponsors'] = ['' => "All"] + Sponsor::pluck('name', 'id')->toArray();
        $this->data['cancel'] = ['' => "All", true => "Yes", false => "No"];
       
        $this->data['record'] = Event::where(function ($query) {
            if (strlen($this->data['keyword']) > 0) {
                return $query
                    ->whereRaw("LOWER(code) LIKE '%{$this->data['keyword']}%'")
                    ->orWhereRaw("LOWER(name) LIKE '%{$this->data['keyword']}%'");
            }
        })
        ->where(function ($query) {
            if (strlen($this->data['selected_category']) > 0) {
                $query->where('category_id', $this->data['selected_category']);
            }
        })
        ->where(function ($query) {
            if (strlen($this->data['selected_sponsor']) > 0) {
                $query->where('sponsor_id', $this->data['selected_sponsor']);
            }
        })
        ->where(function ($query) {
            if (strlen($this->data['selected_cancel']) > 0) {
                $query->where('is_cancelled', $this->data['selected_cancel']);
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

        return view('portal.events.index', $this->data);
    }

    public function create(PageRequest $request){
        $this->data['page_title'] .= " - Create Event";

        return view('portal.events.create', $this->data);
    }

    public function store(EventRequest $request){
        DB::beginTransaction();
        try{
            $event = new Event;
            $event->code = $this->event_code;
            $event->name = $request->input('event');
            $event->description = $request->input('description');
            $event->sponsor_id = $request->input('category');
            $event->category_id = $request->input('sponsor');
            $event->location = $request->input('location');
            $event->price = $request->input('price');
            $event->event_start = Carbon::parse($request->input('start_date'))->format("Y-m-d H:i:s");
            $event->event_end = Carbon::parse($request->input('end_date'))->format("Y-m-d H:i:s");
            $event->save();

            if($request->hasFile('event_image')){
                $image = $request->file('event_image');
                $upload_logo = ImageUploader::upload($image, "uploads/events/{$event->id}");

                $event->path = $upload_logo['path'];
                $event->directory = $upload_logo['directory'];
                $event->filename = $upload_logo['filename'];
                $event->source = $upload_logo['source'];
                $event->save();
            }

            $audit_trail = new AuditTrail;
			$audit_trail->user_id = $this->data['auth']->id;
			$audit_trail->process = "CREATE_EVENT";
			$audit_trail->ip = $this->data['ip'];
			$audit_trail->remarks = "{$this->data['auth']->name} has created a new event.";
			$audit_trail->type = "USER_ACTION";
			$audit_trail->save();

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "New event has been created.");
            return redirect()->route('portal.events.index');
        }catch(\Exception $e){
            DB::rollback();
            
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to create event.");
        return redirect()->back();
    }

    public function edit(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Edit Event";
        $this->data['event'] = Event::find($id);

        if(!$this->data['event']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.events.index');
        }

        return view('portal.events.edit', $this->data);
    }

    public function update(EventRequest $request,$id = null){
        $event = Event::find($id);

        if(!$event){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.events.index');
        }

        DB::beginTransaction();
        try{
            $event->name = $request->input('event');
            $event->description = $request->input('description');
            $event->sponsor_id = $request->input('category');
            $event->category_id = $request->input('sponsor');
            $event->location = $request->input('location');
            $event->price = $request->input('price');
            $event->event_start = Carbon::parse($request->input('start_date'))->format("Y-m-d H:i:s");
            $event->event_end = Carbon::parse($request->input('end_date'))->format("Y-m-d H:i:s");

            if($request->hasFile('event_image')){
                ImageRemover::remove($event->path);

                $image = $request->file('event_image');
                $upload_logo = ImageUploader::upload($image, "uploads/events/{$event->id}");

                $event->path = $upload_logo['path'];
                $event->directory = $upload_logo['directory'];
                $event->filename = $upload_logo['filename'];
                $event->source = $upload_logo['source'];
            }
            $event->save();

            $audit_trail = new AuditTrail;
			$audit_trail->user_id = $this->data['auth']->id;
			$audit_trail->process = "UPDATE_EVENT";
			$audit_trail->ip = $this->data['ip'];
			$audit_trail->remarks = "{$this->data['auth']->name} has updated event.";
			$audit_trail->type = "USER_ACTION";
			$audit_trail->save();

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Event has been modified.");
            return redirect()->route('portal.events.index');
        }catch(\Exception $e){
            DB::rollback();
            
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to update event.");
        return redirect()->back();
    }

    public function update_is_cancelled(PageRequest $request,$id = null){
        $event = Event::find($id);

        if(!$event){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.events.index');
        }

        DB::beginTransaction();
        try{
            $event->is_cancelled = $event->is_cancelled === true ? false : true;
            $event->save();
            $status = $event->is_cancelled === true ? 'cancelled' : 'start';

            $audit_trail = new AuditTrail;
			$audit_trail->user_id = $this->data['auth']->id;
			$audit_trail->process = "UPDATE_EVENT_STATUS";
			$audit_trail->ip = $this->data['ip'];
			$audit_trail->remarks = "{$this->data['auth']->name} has updated event status to {$status}.";
			$audit_trail->type = "USER_ACTION";
			$audit_trail->save();

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Event has been cancelled.");
            return redirect()->route('portal.events.index');
        }catch(\Exception $e){
            DB::rollback();
            
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to cancel event.");
        return redirect()->back();
    }

    public function show(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Information";
        $this->data['event'] = Event::find($id);

        if(!$this->data['event']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.events.index');
        }

        return view('portal.events.show', $this->data);
    }
}