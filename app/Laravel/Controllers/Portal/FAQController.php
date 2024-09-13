<?php

namespace App\Laravel\Controllers\Portal;

use App\Laravel\Models\{FAQ,AuditTrail};

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Portal\FAQRequest;

use Str,Carbon,DB;

class FAQController extends Controller{
    protected $data;

    public function __construct(){
        parent::__construct();
        array_merge($this->data?:[], parent::get_data());
        $this->data['statuses'] = ['' => "-- Select Status -- ",'active' => "Active",'inactive' => "Inactive"];
        $this->data['page_title'] .= " - FAQ";
        $this->per_page = env("DEFAULT_PER_PAGE", 10);
    }

    public function index(PageRequest $request){
        $this->data['page_title'] .= " - List of FAQ";

        $this->data['keyword'] = strtolower($request->get('keyword'));
        $this->data['selected_status'] = $request->input('status');

        $first_record = FAQ::orderBy('created_at', 'ASC')->first();
        $start_date = $request->get('start_date', now()->startOfMonth());
        if ($first_record) {
            $start_date = $request->get('start_date', $first_record->created_at->format("Y-m-d"));
        }

        $this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
        $this->data['end_date'] = Carbon::parse($request->get('end_date', now()))->format("Y-m-d");
        $this->data['statuses'] = ['' => "All", 'active' => "Active", 'inactive' => "Inactive"];

        $this->data['record'] = FAQ::where(function ($query) {
            if (strlen($this->data['keyword']) > 0) {
                return $query
                    ->whereRaw("LOWER(question) LIKE '%{$this->data['keyword']}%'");
            }
        })
        ->where(function ($query) {
            if (strlen($this->data['selected_status']) > 0) {
                return $query->where('status', $this->data['selected_status']);
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

        return view('portal.cms.faq.index', $this->data);
    }

    public function create(PageRequest $request){
        $this->data['page_title'] .= " - Create FAQ";

        return view('portal.cms.faq.create', $this->data);
    }

    public function store(FAQRequest $request){
        DB::beginTransaction();
        try{
            $faq = new FAQ;
            $faq->user_id = $this->data['auth']->id;
            $faq->question = $request->input('question');
            $faq->answer = $request->input('answer');
            $faq->status = $request->input('status');
            $faq->save();

            $audit_trail = new AuditTrail;
			$audit_trail->user_id = $this->data['auth']->id;
			$audit_trail->process = "CREATE_FAQ";
			$audit_trail->ip = $this->data['ip'];
			$audit_trail->remarks = "{$this->data['auth']->name} has created a new FAQ.";
			$audit_trail->type = "USER_ACTION";
			$audit_trail->save();

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "New FAQ has been added.");
            return redirect()->route('portal.cms.faq.index');
        }catch(\Exception $e){
            DB::rollback();
            
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to add FAQ.");
        return redirect()->back();
    }

    public function edit(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Edit FAQ";
        $this->data['faq'] = FAQ::find($id);

        if(!$this->data['faq']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.cms.faq.index');
        }

        return view('portal.cms.faq.edit', $this->data);
    }

    public function update(FAQRequest $request,$id = null){
        $faq = FAQ::find($id);

        if(!$faq){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.cms.faq.index');
        }

        DB::beginTransaction();
        try{
            $faq->user_id = $this->data['auth']->id;
            $faq->question = $request->input('question');
            $faq->answer = $request->input('answer');
            $faq->status = $request->input('status');
            $faq->save();

            $audit_trail = new AuditTrail;
			$audit_trail->user_id = $this->data['auth']->id;
			$audit_trail->process = "UPDATE_FAQ";
			$audit_trail->ip = $this->data['ip'];
			$audit_trail->remarks = "{$this->data['auth']->name} has updated FAQ.";
			$audit_trail->type = "USER_ACTION";
			$audit_trail->save();

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "FAQ has been modified.");
            return redirect()->route('portal.cms.faq.index');
        }catch(\Exception $e){
            DB::rollback();

            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to update FAQ.");
        return redirect()->back();
    }

    public function update_status(PageRequest $request,$id = null){
        $faq = FAQ::find($id);

        if(!$faq){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.cms.faq.index');
        }

        DB::beginTransaction();
        try{
            $faq->status = $faq->status === 'active' ? 'inactive' : 'active';
            $faq->save();
            
            $audit_trail = new AuditTrail;
			$audit_trail->user_id = $this->data['auth']->id;
			$audit_trail->process = "UPDATE_FAQ_STATUS";
			$audit_trail->ip = $this->data['ip'];
			$audit_trail->remarks = "{$this->data['auth']->name} has updated status to {$faq->status}.";
			$audit_trail->type = "USER_ACTION";
			$audit_trail->save();
               
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "FAQ status has been changed.");
            return redirect()->route('portal.cms.faq.index');
        }catch(\Exception $e){
            DB::rollBack();

            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error. Please try again." . $e->getMessage());
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to change FAQ status.");
        return redirect()->back();
    }

    public function show(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Information";
        $this->data['faq'] = FAQ::find($id);

        if(!$this->data['faq']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.cms.faq.index');
        }

        return view('portal.cms.faq.show', $this->data);
    }

    public function destroy(PageRequest $request,$id = null){
        $faq = FAQ::find($id);

        if(!$faq){
            session()->flash('notification-status',"failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->back();
        }

        if($faq->delete()){
            $audit_trail = new AuditTrail;
			$audit_trail->user_id = $this->data['auth']->id;
			$audit_trail->process = "DELETE_FAQ";
			$audit_trail->ip = $this->data['ip'];
			$audit_trail->remarks = "{$this->data['auth']->name} has deleted FAQ.";
			$audit_trail->type = "USER_ACTION";
			$audit_trail->save();

            session()->flash('notification-status', 'success');
            session()->flash('notification-msg', "FAQ has been deleted.");
            return redirect()->back();
        }
    }
}
