<?php

namespace App\Laravel\Controllers\Portal;

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Portal\{AccountChangePasswordRequest,ProfileRequest};

use DB,ImageUploader,ImageRemover;

class ProfileController extends Controller{
    protected $data;

    public function __construct(){
        parent::__construct();
        array_merge($this->data?:[], parent::get_data());
        $this->data['page_title'] .= " - Account Setting";
        $this->per_page = env("DEFAULT_PER_PAGE", 10);
    }

    public function index(PageRequest $request){
        $this->data['page_title'] .= " - My Profile";

        if(!$this->data['auth']){
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Record not found.");
			return redirect()->route('portal.index');
		}

		return view('portal.profile.index',$this->data);
    }

    public function edit_password(PageRequest $request){
        $this->data['page_title'] .= " - Change Password";

		return view('portal.profile.change-password',$this->data);
	}

    public function update_password(AccountChangePasswordRequest $request){
		$user = $this->data['auth'];

        if(!$user){
            session()->flash('notification-status','warning');
            session()->flash('notification-msg',"Record not found.");
            return redirect()->route('portal.index');
        }

        DB::beginTransaction();
		try{
            $user->password = bcrypt($request->input('password'));
            $user->save();

			DB::commit();

			session()->flash('notification-status',"success");
			session()->flash('notification-msg',"Your password has been changed.");
			return redirect()->route('portal.index');
		}catch(\Exception $e){
			DB::rollBack();

			session()->flash('notification-status',"failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");			
            return redirect()->back();
		}

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to change password.");
        return redirect()->back();
    }

    public function edit_profile(PageRequest $request){
        $this->data['page_title'] .= " - Change Profile Picture";

		return view('portal.profile.change-profile',$this->data);
    }

    public function update_profile(ProfileRequest $request){
        $user = $this->data['auth'];

        if(!$user){
            session()->flash('notification-status','warning');
            session()->flash('notification-msg',"Record not found.");
            return redirect()->route('portal.index');
        }

        DB::beginTransaction();
        try{
            if($request->hasFile('profile_image')){
                ImageRemover::remove($user->path);

                $upload_logo = ImageUploader::upload($request->file('profile_image'), "uploads/avatar/{$user->id}");

                $user->path = $upload_logo['path'];
                $user->directory = $upload_logo['directory'];
                $user->filename = $upload_logo['filename'];
                $user->source = $upload_logo['source'];
            }
            $user->save();

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Profile picture has been modified.");
            return redirect()->route('portal.profile.index');
        }catch(\Exception $e){
            DB::rollback();
            
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
        }

        return redirect()->back();
    }
}