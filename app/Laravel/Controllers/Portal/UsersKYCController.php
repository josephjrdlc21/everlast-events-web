<?php

namespace App\Laravel\Controllers\Portal;

use App\Laravel\Models\UserKYC;

use App\Laravel\Requests\PageRequest;

use Carbon,DB,Str;

class UsersKYCController extends Controller{
    protected $data;

    public function __construct(){
        parent::__construct();
        array_merge($this->data?:[], parent::get_data());
        $this->data['page_title'] .= " - Registrations";
        $this->per_page = env("DEFAULT_PER_PAGE", 10);
    }

    public function index(PageRequest $request){
        $this->data['page_title'] .= " - List of Pending";

        $this->data['keyword'] = strtolower($request->get('keyword'));

        $first_record = UserKYC::orderBy('created_at', 'ASC')->first();
        $start_date = $request->get('start_date', now()->startOfMonth());
        if ($first_record) {
            $start_date = $request->get('start_date', $first_record->created_at->format("Y-m-d"));
        }

        $this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
        $this->data['end_date'] = Carbon::parse($request->get('end_date', now()))->format("Y-m-d");

        $this->data['record'] = UserKYC::where(function ($query) {
            if (strlen($this->data['keyword']) > 0) {
                return $query
                    ->whereRaw("LPAD(id, 5, '0') LIKE '%{$this->data['keyword']}%'")
                    ->orWhereRaw("LOWER(name) LIKE '%{$this->data['keyword']}%'");
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
        ->where('status','pending')
        ->orderBy('created_at','DESC')
        ->paginate($this->per_page);

        return view('portal.users-kyc.index', $this->data);
    }

    public function approved(PageRequest $request){
        $this->data['page_title'] .= " - List of Approved";

        $this->data['keyword'] = strtolower($request->get('keyword'));

        $first_record = UserKYC::orderBy('created_at', 'ASC')->first();
        $start_date = $request->get('start_date', now()->startOfMonth());
        if ($first_record) {
            $start_date = $request->get('start_date', $first_record->created_at->format("Y-m-d"));
        }

        $this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
        $this->data['end_date'] = Carbon::parse($request->get('end_date', now()))->format("Y-m-d");

        $this->data['record'] = UserKYC::where(function ($query) {
            if (strlen($this->data['keyword']) > 0) {
                return $query
                    ->whereRaw("LPAD(id, 5, '0') LIKE '%{$this->data['keyword']}%'")
                    ->orWhereRaw("LOWER(name) LIKE '%{$this->data['keyword']}%'");
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
        ->where('status','approved')
        ->orderBy('created_at','DESC')
        ->paginate($this->per_page);

        return view('portal.users-kyc.approved', $this->data);
    }

    public function rejected(PageRequest $request){
        $this->data['page_title'] .= " - List of Rejected";

        $this->data['keyword'] = strtolower($request->get('keyword'));

        $first_record = UserKYC::orderBy('created_at', 'ASC')->first();
        $start_date = $request->get('start_date', now()->startOfMonth());
        if ($first_record) {
            $start_date = $request->get('start_date', $first_record->created_at->format("Y-m-d"));
        }

        $this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
        $this->data['end_date'] = Carbon::parse($request->get('end_date', now()))->format("Y-m-d");

        $this->data['record'] = UserKYC::where(function ($query) {
            if (strlen($this->data['keyword']) > 0) {
                return $query
                    ->whereRaw("LPAD(id, 5, '0') LIKE '%{$this->data['keyword']}%'")
                    ->orWhereRaw("LOWER(name) LIKE '%{$this->data['keyword']}%'");
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
        ->where('status','rejected')
        ->orderBy('created_at','DESC')
        ->paginate($this->per_page);

        return view('portal.users-kyc.rejected', $this->data);
    }

    public function update_status(PageRequest $request,$id = null,$status = "pending"){
        $registrant = UserKYC::find($id);

        if(!$registrant){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->back();
        }

        DB::beginTransaction();
        try{
            $registrant->status = $status;
            $registrant->save();
               
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "This registrant has been {$registrant->status}.");
        }catch(\Exception $e){
            DB::rollBack();

            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }
        
        return redirect()->route('portal.users_kyc.show', [$id]);
    }

    public function show(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Information";
        $this->data['registrant'] = UserKYC::find($id);

        if(!$this->data['registrant']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->back();
        }

        return view('portal.users-kyc.show', $this->data);
    }
}