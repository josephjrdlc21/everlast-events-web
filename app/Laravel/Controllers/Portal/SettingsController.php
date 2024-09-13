<?php

namespace App\Laravel\Controllers\Portal;

use App\Laravel\Models\{Setting,AuditTrail};

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Portal\SettingRequest;

use DB,ImageUploader,ImageRemover;

class SettingsController extends Controller{
    protected $data;

    public function __construct(){
        parent::__construct();
        array_merge($this->data?:[], parent::get_data());
        $this->data['page_title'] .= " - Settings";
        $this->per_page = env("DEFAULT_PER_PAGE", 10);
    }

    public function index(PageRequest $request){
        $this->data['page_title'] .= " - Data";
        $this->data["settings"] = Setting::orderBy('created_at','DESC')->first();

        if(!$this->data["settings"]){
            $this->data['settings'] = new Setting;
        }

        return view('portal.cms.settings.index', $this->data);
    }

    public function store(SettingRequest $request){
        DB::beginTransaction();
        try{
            $setting = Setting::orderBy('created_at', 'DESC')->first() ?? new Setting;
            $setting->brand_name = $request->input('brand');
            $setting->system_name = $request->input('system');
            $setting->save();
            
            if($request->hasFile('logo')){
                if($setting->exists){
                    ImageRemover::remove($setting->path);
                }
                $upload_logo = ImageUploader::upload($request->file('logo'), "uploads/brand/{$setting->id}");
                $setting->path = $upload_logo['path'];
                $setting->directory = $upload_logo['directory'];
                $setting->filename = $upload_logo['filename'];
                $setting->source = $upload_logo['source'];
                $setting->save();
            }

            $audit_trail = new AuditTrail;
			$audit_trail->user_id = $this->data['auth']->id;
			$audit_trail->process = "UPDATE_SETTING";
			$audit_trail->ip = $this->data['ip'];
			$audit_trail->remarks = "{$this->data['auth']->name} has updated system settings.";
			$audit_trail->type = "USER_ACTION";
			$audit_trail->save();
    
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Settings updated.");
        }catch(\Exception $e){
            DB::rollback();
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        return redirect()->route('portal.cms.settings.index');
    }
}