@extends('student.template.main')
@section('title', 'Past Evaluations - UPSC Evaluator')
@section('style')
<style>
    .fixed-amount-card{padding: 25px 50px;font-size: var(--font-size-b2);color: var(--color-heading);background: var(--color-dark);border-radius: var(--radius-small);}
    .mb-10px{margin-bottom: 10px;}
    .p10{padding: 25px;}
    .pdf-name{display: block;width: 100%;word-wrap: break-word;margin-top: 10px;font-size: 12px;}
    .current-date{margin: 10px;}
    .download-btn{width: 100%!important;padding: 0 15px!important;}
    @media (max-width: 640px) {
        .download-btn{padding: 0px!important;font-size: 14px!important;}
    }
</style>
@endsection
@section('tab-name')
<div class="banner-area">
    <div class="settings-area">
        <h3 class="title">Past Evaluations</h3>
    </div>
</div>
@endsection
@section('content')
<div class="container">

    <div class="contact-details-box">
        <h3 class="title">GS</h3>
        @foreach($student_answer_sheets as $date => $sheets)
        <h4 class="current-date">{{$date}}</h4>
        <div class="row">
            @foreach($sheets as $sheet)
            <div class="col-md-3 col-sm-6 col-6">
                <a href="{{ route('student.mains-evaluation', ['process_id' => $sheet->task_id]) }}">
                    <div class="fixed-amount-card mb-10px p10 text-center">
                        <img src="{{ asset('public/images/pdf.svg') }}" class="img-fluid">
                        <span class="pdf-name">
                            @if(strlen($sheet->file_name) > 20)
                            {{ substr($sheet->file_name, 0, 20) }}..
                            @else
                            {{ $sheet->file_name }}
                            @endif
                        </span>
                    </div>
                </a>
                <a href="{{ route('student.mains-evaluation.download-evaluation', ['task_id' => $sheet->task_id]) }}" class="btn btn-default download-btn"><i class="fa fa-download" aria-hidden="true"></i> <span>Download</span></a>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $(".past-evaluation").addClass('active');
    });
</script>
@endsection