<?php

namespace App\Laravel\Controllers\Portal;

use App\Laravel\Models\{User,Role};

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Portal\{UserRequest,UserResetPasswordRequest};

use Carbon,DB,Str,Helper;

class UsersController extends Controller{
    protected $data;

    public function __construct(){
        parent::__construct();
        array_merge($this->data?:[], parent::get_data());
        $this->data['statuses'] = ['' => "-- Select Status -- ",'active' => "Active",'inactive' => "Inactive"];
        $this->data['roles'] = ['' => "-- Select Role --"] + Role::where('status','active')->pluck('name', 'name')->toArray();
        $this->data['page_title'] .= " - Account Management";
        $this->per_page = env("DEFAULT_PER_PAGE", 10);
    }

    public function index(PageRequest $request){
        $this->data['page_title'] .= " - List of Users";

        $this->data['keyword'] = strtolower($request->get('keyword'));
        $this->data['selected_status'] = $request->input('status');

        $first_record = User::where('id','!=',1)->where('user_type','portal')->orderBy('created_at', 'ASC')->first();
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
        ->where('user_type','portal')
        ->orderBy('created_at','DESC')
        ->paginate($this->per_page);

        return view('portal.users.index', $this->data);
    }

    public function create(PageRequest $request){
        $this->data['page_title'] .= " - Create User";

        return view('portal.users.create', $this->data);
    }

    public function store(UserRequest $request){
        DB::beginTransaction();
        try{
            $password = Str::random(8);

            $user = new User;
            $user->firstname = Str::upper($request->input('firstname'));
            $user->lastname = Str::upper($request->input('lastname'));
            $user->middlename = Str::upper($request->input('middlename'));
            $user->suffix = Str::upper($request->input('suffix'));
            $user->name = "{$user->firstname} {$user->middlename} {$user->lastname} {$user->suffix}";
            $user->email = Str::lower($request->input('email'));
            $user->status = Str::lower($request->input('status'));
            $user->user_type = "portal";
            $user->contact_number = Helper::format_phone($request->input('contact'));
            $user->password = bcrypt($password);
            $user->save();

            $role = Role::where('name', $request->input('role'))->where('guard_name','portal')->first();
            $user->assignRole($role);
               
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "User account registered. Login credentials was sent to the email.");
            return redirect()->route('portal.users.index');
        }catch(\Exception $e){
            DB::rollback();
            
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to process user account.");
        return redirect()->back();
    }

    public function edit(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Edit User";
        $this->data['user'] = User::find($id);

        if(!$this->data['user']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.users.index');
        }

        return view('portal.users.edit', $this->data);
    }

    public function update(UserRequest $request,$id = null){
        $user = User::find($id);

        if(!$user){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.users.index');
        }

        DB::beginTransaction();
        try{
            $user->firstname = Str::upper($request->input('firstname'));
            $user->lastname = Str::upper($request->input('lastname'));
            $user->middlename = Str::upper($request->input('middlename'));
            $user->suffix = Str::upper($request->input('suffix'));
            $user->name = "{$user->firstname} {$user->middlename} {$user->lastname} {$user->suffix}";
            $user->email = Str::lower($request->input('email'));
            $user->contact_number = Helper::format_phone($request->input('contact'));
            $user->status = Str::lower($request->input('status'));
            $user->save();

            $role = Role::where('name', $request->input('role'))->where('guard_name','portal')->first();
            $user->syncRoles($role);
                
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "User account has been modified.");
            return redirect()->route('portal.users.index');
        }catch(\Exception $e){
            DB::rollback();
            
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to process to update user account.");
        return redirect()->back();
    }

    public function edit_password(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Reset Password";
        $this->data['user'] = User::find($id);

        if(!$this->data['user']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.users.index');
        }

        return view('portal.users.reset-password', $this->data);
    }

    public function update_password(UserResetPasswordRequest $request,$id = null){
        $user = User::find($id);

        if(!$user){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.users.index');
        }

        DB::beginTransaction();
        try{
            $user->password = bcrypt($request->input('password'));
            $user->save();   
                
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "User password has been reset.");
            return redirect()->route('portal.users.index');
        }catch (\Exception $e){
            DB::rollBack();

            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error. Please try again." . $e->getMessage());
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to reset to user password.");
        return redirect()->back();
    }

    public function update_status(PageRequest $request,$id = null){
        $user = User::find($id);

        if(!$user){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.users.index');
        }

        if($user->id == $this->data['auth']->id){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "You can't deactivate your account while you are logged in.");
            return redirect()->route('portal.users.index');
        }

        DB::beginTransaction();
        try{
            $user->status = $user->status === 'active' ? 'inactive' : 'active';
            $user->save();
               
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "User status has been changed.");
            return redirect()->route('portal.users.index');
        }catch(\Exception $e){
            DB::rollBack();

            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error. Please try again." . $e->getMessage());
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to change user status.");
        return redirect()->back();
    }

    public function show(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Information";
        $this->data['user'] = User::find($id);

        if(!$this->data['user']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.users.index');
        }

        return view('portal.users.show', $this->data);
    }
}