<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Admin\{
	ProcessFileExport
};
use App\Models\{
    Institute,
    InstituteUploadFile
};

class BulkPDFProcessController extends Controller
{
    public function index(Request $request)
    {
        $filter_from = date("Y-m-d", strtotime("first day of this month"));
        $filter_to = date("Y-m-d", strtotime("last day of this month"));
        if ($request->filled('filter_from') && $request->filled('filter_to')) {
            $filter_from = $request->filter_from;
            $filter_to = $request->filter_to;
        }
        $institutes = Institute::select('id', 'name')->get();
        $institute_upload_files = InstituteUploadFile::select('id', 'institute_upload_batch_id', 'file_name', 'no_of_pages')
                                                    ->with([
                                                        'upload_batch' => function($query){
                                                            $query->select('id', 'created_at', 'institute_id')
                                                                ->with([
                                                                    'institute' => function($query){
                                                                        $query->select('id', 'name');
                                                                    }
                                                                ]);
                                                        }
                                                    ])
                                                    ->where('status', 1)
                                                    ->whereHas('upload_batch', function($query) use($filter_from, $filter_to){
                                                        $query->whereDate('created_at', '>=', $filter_from)
                                                            ->whereDate('created_at', '<=', $filter_to);
                                                    })
                                                    ->where(function($query) use($request){
                                                        if ($request->filled('institute_id')) {
                                                            $query->whereHas('upload_batch', function($query) use($request){
                                                                $query->where('institute_id', $request->institute_id);
                                                            });
                                                        }
                                                    })
                                                    ->orderByDesc('id');

        if ($request->filled('download')) {
			$institute_upload_files = $institute_upload_files->get();

			return Excel::download(
				new ProcessFileExport($institute_upload_files),
				date("d-m-Y h:i A").".xlsx"
			);
		}

        $institute_upload_files = $institute_upload_files->paginate(100);
        
        return view('admin.bulk_pdf_process.index', compact(
            'filter_from',
            'filter_to',
            'institutes',
            'institute_upload_files'
        ));
    }
}
