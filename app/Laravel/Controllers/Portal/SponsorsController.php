<?php

namespace App\Laravel\Controllers\Portal;

use App\Laravel\Models\Sponsor;

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Portal\SponsorRequest;

use Carbon,DB,ImageUploader,ImageRemover;

class SponsorsController extends Controller{
    protected $data;

    public function __construct(){
        parent::__construct();
        array_merge($this->data?:[], parent::get_data());
        $this->data['page_title'] .= " - Sponsors";
        $this->per_page = env("DEFAULT_PER_PAGE", 10);
    }

    public function index(PageRequest $request){
        $this->data['page_title'] .= " - List of Sponsors";

        $this->data['keyword'] = strtolower($request->get('keyword'));

        $first_record = Sponsor::orderBy('created_at', 'ASC')->first();
        $start_date = $request->get('start_date', now()->startOfMonth());
        if ($first_record) {
            $start_date = $request->get('start_date', $first_record->created_at->format("Y-m-d"));
        }
        
        $this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
        $this->data['end_date'] = Carbon::parse($request->get('end_date', now()))->format("Y-m-d");

        $this->data['record'] = Sponsor::where(function ($query) {
            if (strlen($this->data['keyword']) > 0) {
                return $query
                    ->whereRaw("LOWER(name) LIKE '%{$this->data['keyword']}%'");
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

        return view('portal.cms.sponsors.index', $this->data);
    }

    public function create(PageRequest $request){
        $this->data['page_title'] .= " - Create Sponsor";

        return view('portal.cms.sponsors.create', $this->data);
    }

    public function store(SponsorRequest $request){
        DB::beginTransaction();
        try{
            $sponsor = new Sponsor;
            $sponsor->name = $request->input('sponsor');
            $sponsor->save();

            if($request->hasFile('logo')){
                $image = $request->file('logo');
                $upload_logo = ImageUploader::upload($image, "uploads/sponsor/{$sponsor->id}");

                $sponsor->path = $upload_logo['path'];
                $sponsor->directory = $upload_logo['directory'];
                $sponsor->filename = $upload_logo['filename'];
                $sponsor->source = $upload_logo['source'];
                $sponsor->save();
            }

            DB::commit();

            session()->flash('notification-status', 'success');
            session()->flash('notification-msg', "New Sponsor has been added.");
            return redirect()->route('portal.cms.sponsors.index');
        }catch(\Exception $e){
            DB::rollback();
            
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to add sponsor.");
        return redirect()->back();
    }

    public function edit(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Edit Sponsor";
        $this->data['sponsor'] = Sponsor::find($id);

        if(!$this->data['sponsor']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.cms.sponsors.index');
        }

        return view('portal.cms.sponsors.edit', $this->data);
    }

    public function update(SponsorRequest $request,$id = null){
        $sponsor = Sponsor::find($id);

        if(!$sponsor){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.cms.sponsors.index');
        }

        DB::beginTransaction();
        try{
            $sponsor->name = $request->input('sponsor');

            if($request->hasFile('logo')) {
                ImageRemover::remove($sponsor->path);

                $image = $request->file('logo');                
                $upload_logo = ImageUploader::upload($image, "uploads/sponsor/{$sponsor->id}");

                $sponsor->path = $upload_logo['path'];
                $sponsor->directory = $upload_logo['directory'];
                $sponsor->filename = $upload_logo['filename'];
                $sponsor->source = $upload_logo['source'];
            }
            $sponsor->save();

            DB::commit();

            session()->flash('notification-status', 'success');
            session()->flash('notification-msg', "Sponsor has been modified.");
            return redirect()->route('portal.cms.sponsors.index');
        }catch(\Exception $e){
            DB::rollback();
            
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to update sponsor.");
        return redirect()->back();
    }

    public function show(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Information";
        $this->data['sponsor'] = Sponsor::find($id);

        if(!$this->data['sponsor']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.cms.sponsors.index');
        }

        return view('portal.cms.sponsors.show', $this->data);
    }

    public function destroy(PageRequest $request,$id = null){
        $sponsor = Sponsor::find($id);

        if(!$sponsor){
            session()->flash('notification-status',"failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->back();
        }

        if($sponsor->delete()){
            session()->flash('notification-status', 'success');
            session()->flash('notification-msg', "Sponsor has been deleted.");
            return redirect()->back();
        }
    }
}