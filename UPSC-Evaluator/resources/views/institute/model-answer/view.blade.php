@extends('admin.layout.main')
@section('title', 'Institute - Model Answer')
@section('styles')
<style>
    .paper{max-width:900px;margin:40px auto;padding:42px 48px;background:linear-gradient(to bottom, #ffffff 0%, #fbfbfb 100%);border:1px solid #d4d4d4;outline:1px solid #efefef;outline-offset:-6px;box-shadow:0 2px 3px rgba(0,0,0,.04),0 12px 30px rgba(0,0,0,.18);font-family:"Cambria","Charter","Nimbus Roman","Times New Roman",serif;font-size:15px;line-height:1.65;color:#111;letter-spacing:.25px;word-spacing:.45px;}
    .paper .header{text-align:center;padding-bottom:12px;margin-bottom:22px;position:relative;}
    .paper .header::after{content:"";display:block;height:2px;width:100%;margin-top:10px;background:linear-gradient(to right,#000,#888,#000);}
    .paper .header h1{font-size:19px;font-weight:600;letter-spacing:.6px;text-transform:uppercase;}
    .paper .meta{margin-top:8px;display:flex;justify-content:space-between;font-size:13.2px;color:#333;}
    .paper .section{margin:28px 0 12px;font-size:15.5px;font-weight:600;text-transform:uppercase;letter-spacing:.6px;color:#000;position:relative;}
    .paper .section::after{content:"";position:absolute;left:0;bottom:-4px;width:60px;height:2px;background:#000;}
    .paper .question{display:grid;grid-template-columns: auto 1fr auto;gap:10px;margin-top:14px;align-items:start;}
    .paper .qno{font-weight:600;font-size:15px;color:#000;}
    .paper .qtext{font-size:15px;}
    .paper .marks{font-size:13.5px;color:#444;}
    .paper .answer-para{margin:8px 0 14px 34px;padding-left:10px;border-left:3px solid #e2e2e2;text-align:justify;}
    .paper .answer-list{margin-left:36px;margin-top:6px;}
    .paper .answer-list ul{padding-left:20px;}
    .paper .answer-list li{margin-bottom:10px;}
    .paper .point-heading{font-weight:600;}
    .paper .example{margin-top:4px;margin-left:14px;font-size:14.4px;color:#333;}
    .paper table{width:100%;margin:14px 0;border-collapse:collapse;font-size:14.4px;}
    .paper th,
    .paper td{border:1px solid #000;padding:7px 10px;}
    .paper th{background:#f3f3f3;font-weight:600;text-align:center;}
    .paper .footer{margin-top:48px;padding-top:10px;font-size:12.6px;display:flex;justify-content:space-between;color:#333;border-top:1px solid #aaa;}
    @media print{
        body{background:#fff !important;}
        .paper{margin:0;box-shadow:none;outline:none;border:none;padding:32px 38px;}
    }
</style>
@endsection
@php($model_answer = json_decode($institute_model_answer->model_answer)->result)
@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Model Answer</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route('institute.model-answer') }}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{ route('institute.model-answer') }}">Model Answer</a></li>
					<li class="breadcrumb-item active">{{ $institute_model_answer->file_name }}</li>
				</ol>
			</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-primary card-outline">
				<div class="card-header">
					<div class="card-title">
						{{$institute_model_answer->file_name}}
					</div>
				</div>
				<div class="card-body">
                    <div class="paper">
                        @foreach($model_answer->qa_structured as $question)
                            <div class="question">
                                <div class="qno">Q{{$question->number}}.</div>
                                <div class="qtext">
                                    {{$question->question}}
                                </div>
                                <div class="marks">({{$question->marks}})</div>
                            </div>
                            @foreach($question->answer_structured as $answer)
                                @if($answer->type == 'paragraph')
                                <div class="answer-para">{{$answer->text}}</div>
                                @elseif($answer->type == 'table')
                                <div class="qtext">
                                    {{$answer->caption}}
                                    <table>
                                        <tr>
                                            @foreach($answer->headers as $heading)
                                            <th>{{$heading}}</th>
                                            @endforeach
                                        </tr>
                                        @foreach($answer->rows as $row)
                                        <tr>
                                            @foreach($row as $r_value)
                                            <td>{{$r_value}}</td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                @elseif($answer->type == 'heading')
                                <h4>{{$answer->text}}</h4>
                                @elseif($answer->type == 'list' && $answer->style == 'bullet')
                                    <div class="answer-list">
                                        <ul>
                                        @foreach($answer->items as $item)
                                        <li>
                                            @if(isset($item->heading))
                                            <span class="point-heading">{{$item->heading}}</span>
                                            @endif
                                            @if(isset($item->text))
                                            <span class="point-text">{{$item->text}}</span>
                                            @endif
                                            @if(isset($item->examples) && is_array($item->examples))
                                            <div class="example">
                                                <strong>Example:</strong>
                                                @foreach($item->examples as $ex)
                                                {{$ex}}
                                                @endforeach
                                            </div>
                                            @endif
                                        </li>
                                        @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="{{asset('public/js/plugins/validate/jquery.validate.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $(".model-answer-link").addClass('active');
    });
</script>
@endsection