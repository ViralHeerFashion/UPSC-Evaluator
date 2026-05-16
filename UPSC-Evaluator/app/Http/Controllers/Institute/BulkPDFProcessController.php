<?php

namespace App\Http\Controllers\Institute;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Smalot\PdfParser\Parser;
use App\Jobs\Institute\ProcessPDFJob;
use App\Models\{
    InstituteUploadBatch,
    InstituteUploadFile,
    Language
};

class BulkPDFProcessController extends Controller
{
    public function __construct()
    {
        $permission = json_decode(Auth::guard('institute')->user()->permissions);
        if (is_null($permission) || !in_array("bulk_pdf_process", $permission)) {
            abort(403);
        }
    }

    public function index()
    {
        $languages = Language::all();
        return view('institute.bulk_pdf_process.index', compact(
            'languages'
        ));
    }

    public function uploadFiles(Request $request)
    {
        if (!$request->hasFile('pdf_file')) {
            return response()->json([
                'success' => false,
                'message' => "Please upload the files"
            ]);
        }

        $file = $request->file('pdf_file');
        $file_size = round($file->getSize() / 1048576, 2);
        if ($file_size > 15) {
            return response()->json([
                'success' => false,
                'message' => "The file could not be processed because it exceeds the maximum allowed size of 15 MB."
            ]);
        }

        if ($request->filled('institute_upload_batch_id')) {
            $institute_upload_batch = InstituteUploadBatch::find($request->institute_upload_batch_id);
            if (is_null($institute_upload_batch) || $institute_upload_batch->institute_id != Auth::guard('institute')->id()) {
                $institute_upload_batch = new InstituteUploadBatch;
                $institute_upload_batch->institute_id = Auth::guard('institute')->id();
                $institute_upload_batch->language_id = $request->language_id;
                $institute_upload_batch->subject_id = 1;
                $institute_upload_batch->created_at = date("Y-m-d H:i:s");
                $institute_upload_batch->save();
            }
        } else {
            $institute_upload_batch = new InstituteUploadBatch;
            $institute_upload_batch->institute_id = Auth::guard('institute')->id();
            $institute_upload_batch->language_id = $request->language_id;
            $institute_upload_batch->subject_id = 1;
            $institute_upload_batch->created_at = date("Y-m-d H:i:s");
            $institute_upload_batch->save();
        }

        $parser = new Parser();
        $pdf = $parser->parseFile($request->file('pdf_file')->getPathname());
        $total_page_available_in_pdf = count($pdf->getPages());

        $institute_upload_files = new InstituteUploadFile;
        $institute_upload_files->institute_upload_batch_id = $institute_upload_batch->id;
        $institute_upload_files->file_name = $request->file('pdf_file')->getClientOriginalName();
        $institute_upload_files->file_path = $request->file('pdf_file')->store('institute_bulk_answer_sheets');
        $institute_upload_files->no_of_pages = $total_page_available_in_pdf;
        $institute_upload_files->save();

        ProcessPDFJob::dispatch($institute_upload_files->id)->onQueue('institute_pdf_process');

        return response()->json([
            'success' => true,
            'institute_upload_batch_id' => $institute_upload_batch->id
        ]);
    }

    public function download(Request $request)
    {
        $institute_upload_batch = InstituteUploadBatch::with([
            'language',
            'subject',
            'files' => function($query){
                $query->select('id', 'institute_upload_batch_id', 'file_name', 'no_of_pages', 'status', 'success_file_path', 'api_response');
            }
        ])
        ->withCount([
            'files as success_count' => function($query){
                $query->where('status', 1);
            },
            'files as fail_count' => function($query){
                $query->where('status', 2);
            }
        ])
        ->withSum([
            'files as total_pages' => function($query){
                $query->where('status', 1);
            }
        ], 'no_of_pages')
        ->whereRaw("TIMESTAMPDIFF(HOUR, created_at, CURRENT_TIMESTAMP) <= 72")
        ->where('is_proccesed', 1)
        ->where('institute_id', Auth::guard('institute')->id())
        ->orderByDesc('id')
        ->paginate(100);

        return view('institute.bulk_pdf_process.download', compact(
            'institute_upload_batch'
        ));
    }

    public function history(Request $request)
    {
        $filter_from = date("Y-m-d", strtotime("first day of this month"));
        $filter_to = date("Y-m-d", strtotime("last day of this month"));
        if ($request->filled('filter_from') && $request->filled('filter_to')) {
            $filter_from = $request->filter_from;
            $filter_to = $request->filter_to;
        }
        $institute_upload_batch = InstituteUploadBatch::with([
            'language',
            'subject',
            'files' => function($query){
                $query->select('id', 'institute_upload_batch_id', 'file_name', 'no_of_pages', 'status', 'success_file_path', 'api_response');
            }
        ])
        ->withCount([
            'files as success_count' => function($query){
                $query->where('status', 1);
            },
            'files as fail_count' => function($query){
                $query->where('status', 2);
            }
        ])
        ->withSum([
            'files as total_pages' => function($query){
                $query->where('status', 1);
            }
        ], 'no_of_pages')
        ->whereDate('created_at', '>=', $filter_from)
        ->whereDate('created_at', '<=', $filter_to)
        // ->whereRaw("TIMESTAMPDIFF(HOUR, created_at, CURRENT_TIMESTAMP) > 72")
        ->where('is_proccesed', 1)
        ->where('institute_id', Auth::guard('institute')->id())
        ->orderByDesc('id')
        ->paginate(100);

        return view('institute.bulk_pdf_process.history', compact(
            'filter_from',
            'filter_to',
            'institute_upload_batch'
        ));
    }
}