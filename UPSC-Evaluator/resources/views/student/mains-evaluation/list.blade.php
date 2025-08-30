@extends('student.template.main')
@section('title', 'Past Evaluations - UPSC Evaluator')
@section('style')
<style>
    .fixed-amount-card{padding: 25px 50px;font-size: var(--font-size-b2);color: var(--color-heading);background: var(--color-dark);border-radius: var(--radius-small);}
    .mb-10px{margin-bottom: 10px;}
    .p10{padding: 25px;}
    .pdf-name{display: block;width: 100%;word-wrap: break-word;margin-top: 10px;font-size: 12px;}
    .current-date{margin: 10px;}
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
                        <span class="pdf-name">{{ $sheet->file_name }}</span>
                    </div>
                </a>
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