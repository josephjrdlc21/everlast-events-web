<?php

namespace App\Laravel\Controllers\Portal;

use App\Laravel\Models\AuditTrail;

use App\Laravel\Requests\PageRequest;

use Rap2hpoutre\FastExcel\FastExcel;

use Carbon,DB,Str,SnappyPDF,Helper;

class AuditTrailController extends Controller{
    protected $data;

    public function __construct(){
        parent::__construct();
        array_merge($this->data?:[], parent::get_data());
        $this->data['page_title'] .= " - Audit Trail";
        $this->per_page = env("DEFAULT_PER_PAGE", 10);
    }

    public function index(PageRequest $request){
        $this->data['page_title'] .= "- List of Audit Trail";

        $this->data['keyword'] = strtolower($request->get('keyword'));

        $first_record = AuditTrail::orderBy('created_at', 'ASC')->first();
        $start_date = $request->get('start_date', now()->startOfMonth());
        if ($first_record) {
            $start_date = $request->get('start_date', $first_record->created_at->format("Y-m-d"));
        }

        $this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
        $this->data['end_date'] = Carbon::parse($request->get('end_date', now()))->format("Y-m-d");

        $this->data['record'] = AuditTrail::where(function ($query) {
            if (strlen($this->data['keyword']) > 0) {
                return $query
                    ->whereRaw("LOWER(remarks) LIKE '%{$this->data['keyword']}%'");
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

        return view('portal.audit-trail.index', $this->data);
    }

    public function export(PageRequest $request){
        $this->data['keyword'] = strtolower($request->get('keyword'));
        $this->data['start_date'] = Carbon::parse($request->get('start_date'))->format("Y-m-d");
        $this->data['end_date'] = Carbon::parse($request->get('end_date', now()))->format("Y-m-d");

        $this->data['record'] = AuditTrail::where(function ($query) {
            if (strlen($this->data['keyword']) > 0) {
                return $query
                    ->whereRaw("LOWER(remarks) LIKE '%{$this->data['keyword']}%'");
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
        ->get();

        switch(Str::lower($request->get('type'))){
            case "pdf":
                $pdf = SnappyPDF::loadView('portal.pdf.audit-trail', $this->data)
                    ->setPaper('a4')
                    ->setOrientation('portrait')
                    ->setOption('enable-local-file-access', true);
            
                    return $pdf->download("audit-trail.pdf");

            break;

            case "excel":
                return (new FastExcel($this->data['record']))->download('audit-trail.csv', function ($audit_trail) {
                    return [
                        'Name' => $audit_trail->user->name ?? '',
                        'Role' => Helper::capitalize_text($audit_trail->user->roles->pluck('name')->implode(',')) ?? '',
                        'IP Address' => $audit_trail->ip ?? '',
                        'Remarks' => $audit_trail->remarks ?? '',
                        'Date' => Carbon::parse($audit_trail->created_at)->format('m/d/Y h:i A') ?? ''
                    ];
                });
        
            break;
        }
    }
}