<?php

namespace App\Laravel\Controllers\Portal;

use App\Laravel\Models\{User,AuditTrail};

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Portal\MemberResetPasswordRequest;

use Str,Carbon,DB;

class MembersController extends Controller{
    protected $data;

    public function __construct(){
        parent::__construct();
        array_merge($this->data?:[], parent::get_data());
        $this->data['statuses'] = ['' => "-- Select Status -- ",'active' => "Active",'inactive' => "Inactive"];
        $this->data['page_title'] .= " - Members";
        $this->per_page = env("DEFAULT_PER_PAGE", 10);
    }

    public function index(PageRequest $request){
        $this->data['page_title'] .= " - List of Members";

        $this->data['keyword'] = strtolower($request->get('keyword'));
        $this->data['selected_status'] = $request->input('status');

        $first_record = User::where('id','!=',1)->where('user_type','frontend')->orderBy('created_at', 'ASC')->first();
        $start_date = $request->get('start_date', now()->startOfMonth());
        if ($first_record) {
            $start_date = $request->get('start_date', $first_record->created_at->format("Y-m-d"));
        }

        $this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
        $this->data['end_date'] = Carbon::parse($request->get('end_date', now()))->format("Y-m-d");
        $this->data['statuses'] = ['' => "All",'active' => "Active",'inactive' => "Inactive"];

        $this->data['record'] = User::where(function ($query) {
            if (strlen($this->data['keyword']) > 0) {
                return $query
                    ->whereRaw("LPAD(id, 5, '0') LIKE '%{$this->data['keyword']}%'")
                    ->orWhereRaw("LOWER(name) LIKE '%{$this->data['keyword']}%'");
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
        ->where('id','!=',1)
        ->where('user_type','frontend')
        ->orderBy('created_at','DESC')
        ->paginate($this->per_page);

        return view('portal.members.index', $this->data);
    }

    public function edit_password(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Reset Password";
        $this->data['member'] = User::find($id);

        if(!$this->data['member']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.members.index');
        }

        return view('portal.members.reset-password', $this->data);
    }

    public function update_password(MemberResetPasswordRequest $request,$id = null){
        $member = User::find($id);

        if(!$member){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.members.index');
        }

        DB::beginTransaction();
        try{
            $member->password = bcrypt($request->input('password'));
            $member->save();
            
            $audit_trail = new AuditTrail;
			$audit_trail->user_id = $this->data['auth']->id;
			$audit_trail->process = "UPDATE_MEMBER_PASSWORD";
			$audit_trail->ip = $this->data['ip'];
			$audit_trail->remarks = "{$this->data['auth']->name} has updated member password.";
			$audit_trail->type = "USER_ACTION";
			$audit_trail->save();
                
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "User password has been reset.");
            return redirect()->route('portal.members.index');
        }catch (\Exception $e){
            DB::rollBack();

            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to reset to member password.");
        return redirect()->back();
    }

    public function update_status(PageRequest $request,$id = null){
        $member = User::find($id);

        if(!$member){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.members.index');
        }

        DB::beginTransaction();
        try{
            $member->status = $member->status === 'active' ? 'inactive' : 'active';
            $member->save();

            $audit_trail = new AuditTrail;
			$audit_trail->user_id = $this->data['auth']->id;
			$audit_trail->process = "UPDATE_MEMBER_STATUS";
			$audit_trail->ip = $this->data['ip'];
			$audit_trail->remarks = "{$this->data['auth']->name} has updated member status to {$member->status}.";
			$audit_trail->type = "USER_ACTION";
			$audit_trail->save();
               
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Member status has been changed to {$member->status}.");
            return redirect()->route('portal.members.index');
        }catch(\Exception $e){
            DB::rollBack();

            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to activate or deactivate member.");
        return redirect()->back();
    }

    public function show(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Information";
        $this->data['member'] = User::find($id);

        if(!$this->data['member']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->back();
        }

        return view('portal.members.show', $this->data);
    }
}