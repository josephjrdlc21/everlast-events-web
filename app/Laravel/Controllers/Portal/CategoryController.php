<?php

namespace App\Laravel\Controllers\Portal;

use App\Laravel\Models\{Category,AuditTrail};

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Portal\CategoryRequest;

use Carbon,DB;

class CategoryController extends Controller{
    protected $data;

    public function __construct(){
        parent::__construct();
        array_merge($this->data?:[], parent::get_data());
        $this->data['statuses'] = ['' => "-- Select Status -- ",'active' => "Active",'inactive' => "Inactive"];
        $this->data['page_title'] .= " - Category";
        $this->per_page = env("DEFAULT_PER_PAGE", 10);
    }

    public function index(PageRequest $request){
        $this->data['page_title'] .= " - List of Category";

        $this->data['keyword'] = strtolower($request->get('keyword'));
        $this->data['selected_status'] = $request->input('status');

        $first_record = Category::orderBy('created_at', 'ASC')->first();
        $start_date = $request->get('start_date', now()->startOfMonth());
        if ($first_record) {
            $start_date = $request->get('start_date', $first_record->created_at->format("Y-m-d"));
        }

        $this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
        $this->data['end_date'] = Carbon::parse($request->get('end_date', now()))->format("Y-m-d");
        $this->data['statuses'] = ['' => "All",'active' => "Active",'inactive' => "Inactive"];

        $this->data['record'] = Category::where(function ($query) {
            if (strlen($this->data['keyword']) > 0) {
                return $query
                    ->whereRaw("LOWER(title) LIKE '%{$this->data['keyword']}%'");
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

        return view('portal.cms.category.index', $this->data);
    }

    public function create(PageRequest $request){
        $this->data['page_title'] .= " - Create Category";

        return view('portal.cms.category.create', $this->data);
    }

    public function store(CategoryRequest $request){
        DB::beginTransaction();
        try{
            $category = new Category;
            $category->title = $request->input('title');
            $category->description = $request->input('description');
            $category->status = $request->input('status');
            $category->save();

            $audit_trail = new AuditTrail;
			$audit_trail->user_id = $this->data['auth']->id;
			$audit_trail->process = "CREATE_CATEGORY";
			$audit_trail->ip = $this->data['ip'];
			$audit_trail->remarks = "{$this->data['auth']->name} has created a new event category.";
			$audit_trail->type = "USER_ACTION";
			$audit_trail->save();

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "New category has been added.");
            return redirect()->route('portal.cms.category.index');
        }catch(\Exception $e){
            DB::rollback();
            
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to add category.");
        return redirect()->back();
    }

    public function edit(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Edit Category";
        $this->data['category'] = Category::find($id);

        if(!$this->data['category']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.cms.category.index');
        }

        return view('portal.cms.category.edit', $this->data);
    }

    public function update(CategoryRequest $request,$id = null){
        $category = Category::find($id);

        if(!$category){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.cms.category.index');
        }

        DB::beginTransaction();
        try{
            $category->title = $request->input('title');
            $category->description = $request->input('description');
            $category->status = $request->input('status');
            $category->save();

            $audit_trail = new AuditTrail;
			$audit_trail->user_id = $this->data['auth']->id;
			$audit_trail->process = "UPDATE_CATEGORY";
			$audit_trail->ip = $this->data['ip'];
			$audit_trail->remarks = "{$this->data['auth']->name} has updated event category.";
			$audit_trail->type = "USER_ACTION";
			$audit_trail->save();

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Category has been modified.");
            return redirect()->route('portal.cms.category.index');
        }catch(\Exception $e){
            DB::rollback();
            
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to update category.");
        return redirect()->back();
    }

    public function update_status(PageRequest $request,$id = null){
        $category = Category::find($id);

        if(!$category){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.cms.category.index');
        }

        DB::beginTransaction();
        try{
            $category->status = $category->status === 'active' ? 'inactive' : 'active';
            $category->save();

            $audit_trail = new AuditTrail;
			$audit_trail->user_id = $this->data['auth']->id;
			$audit_trail->process = "UPDATE_CATEGORY_STATUS";
			$audit_trail->ip = $this->data['ip'];
			$audit_trail->remarks = "{$this->data['auth']->name} has updated event category status to {$category->status}.";
			$audit_trail->type = "USER_ACTION";
			$audit_trail->save();
               
            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Category status has been changed.");
            return redirect()->route('portal.cms.category.index');
        }catch(\Exception $e){
            DB::rollBack();

            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error. Please try again." . $e->getMessage());
            return redirect()->back();
        }

        session()->flash('notification-status', "warning");
        session()->flash('notification-msg', "Unable to change category status.");
        return redirect()->back();
    }

    public function show(PageRequest $request,$id = null){
        $this->data['page_title'] .= " - Information";
        $this->data['category'] = Category::find($id);

        if(!$this->data['category']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->route('portal.cms.category.index');
        }

        return view('portal.cms.category.show', $this->data);
    }

    public function destroy(PageRequest $request,$id = null){
        $category = Category::find($id);

        if(!$category){
            session()->flash('notification-status',"failed");
            session()->flash('notification-msg', "Record not found.");
            return redirect()->back();
        }

        if($category->delete()){
            $audit_trail = new AuditTrail;
			$audit_trail->user_id = $this->data['auth']->id;
			$audit_trail->process = "DELETE_CATEGORY";
			$audit_trail->ip = $this->data['ip'];
			$audit_trail->remarks = "{$this->data['auth']->name} has deleted event category.";
			$audit_trail->type = "USER_ACTION";
			$audit_trail->save();

            session()->flash('notification-status', 'success');
            session()->flash('notification-msg', "Category has been deleted.");
            return redirect()->back();
        }
    }
}