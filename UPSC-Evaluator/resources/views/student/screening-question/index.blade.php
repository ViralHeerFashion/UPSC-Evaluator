@extends('student.template.main')
@section('title', 'Dashboard')
@section('style')
<style>
    .p-25{padding: 25px;}
    .screening-question-container .button-group input[type="radio"] {display: none!important;}
    .screening-question-container .button-group {display: flex;flex-wrap: wrap;justify-content: flex-start;gap: 10px;margin: 0;}
    .screening-question-container .button-group label {display: inline-block;padding: 10px 20px;cursor: pointer;border: 1px solid #2b426d;background-color: #385c7e;color: white;border-radius: 15px;transition: all ease 0.2s;text-align: center;flex-grow: 1;flex-basis: 0;font-size: 15px;margin: 5px;box-shadow: 0px 0px 50px -15px #000000;word-break: break-word;}
    .screening-question-container .button-group input[type="radio"]:checked + label {background-color: white;color: #02375a;border: 1px solid #2b426d;}
    .screening-question-container fieldset {border: 0;display: flex;flex-direction: column;gap: 10px;}
    @media screen and (max-width: 768px) {
        .screening-question-container .button-group {flex-direction: column;}
        .screening-question-container .button-group label {flex: none;width: 100%;text-align: center;font-size: 16px;padding: 12px;}
        .screening-question-container fieldset {padding: 0 10px;}
    }
    .screening-question-container input[type=radio] ~ label::before{display: none;}
    .question-container{display: none;}
    .form-control, .form-control:hover, .form-control:focus{background-color: #2c2b2b;}
    .form-control{color: white!important;font-size: 15px;}
    .btn-lg{width: 100px;font-size: 15px;padding: 5px;}
    .error{color: #c52d2d;display: none;font-size: 15px;}
</style>
@endsection
@section('content')
    <div class="modal fade" id="screen-question-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content bg-dark text-white border-secondary">
                <form action="{{ route('student.attempt-question.attempt') }}" method="post">
                    @csrf
                    <div class="modal-header border-secondary justify-content-center">
                        <h2 class="modal-title fs-3 fw-semibold text-light" id="exampleModalLabel">
                            ✨ Screen Questions
                        </h2>
                    </div>
                    <div class="modal-body border-secondary p-25 screening-question-container">
                        @php($i = 1)
                        @foreach($screen_questions as $question)
                        <div class="question-container" id="question-{{$i}}" @if($i == 1) style="display: block;" @endif data-question_type="{{$question->question_type}}" data-element-name="question[{{$question->id}}]">
                            <h5>{{ $i }}) {{ $question->question }}</h5>
                            @if($question->question_type == 1)
                                @php($options = json_decode($question->options))
                                <fieldset>
                                @foreach($options as $o)
                                <div class="button-group">
                                    <input type="radio" id="{{ $o }}" name="question[{{$question->id}}]" value="{{ $o }}" required />
                                    <label for="{{ $o }}">{{ $o }}</label>
                                </div>
                                @endforeach
                                </fieldset>
                            @else
                                <textarea class="form-control" name="question[{{$question->id}}]" rows="5" required></textarea>
                            @endif
                            <span class="error question-{{$i}}-error">This field is required</span>
                        </div>
                        @php($i++)
                        @endforeach
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-lg btn-outline-light" id="prev-btn" disabled data-pre="0">Prev</button>
                        <button type="button" class="btn btn-lg btn-primary" id="next-btn" data-next="2">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        let last_question_number = parseInt("{{$question->count()}}")
        $("#screen-question-modal").modal('show');
        $(document).on('click', "#next-btn", function(){
            let next_question = parseInt($(this).attr('data-next'));
            let current_question = next_question - 1;
            if (Number.isNaN(current_question)) {
                current_question = last_question_number;
            }            
            if ($("#question-"+current_question).data("question_type") == 1) {
                let input_name = $("#question-"+current_question).data("element-name");
                if (!$('input[name="'+input_name+'"]:checked').length) {
                    $(".question-"+current_question+"-error").show();
                    return false;
                } else {
                    $(".question-"+current_question+"-error").hide();
                }
            } else {
                if ($("#question-"+current_question).find('textarea').val().trim() == "") {
                    $(".question-"+current_question+"-error").show();
                    return false;
                } else {
                    $(".question-"+current_question+"-error").hide();
                }
            }
            let button_type = Number.isNaN(next_question) ? 'submit' : 'button';
            $(this).attr('type', button_type);
            if (button_type == 'button') {
                $(".question-container").hide();
                $("#question-"+next_question).show();
                if (next_question == last_question_number) {
                    $(this).attr('data-next', "")   
                    $("#prev-btn").attr('data-pre', last_question_number - 1);
                    $(this).text('Submit');
                } else {
                    $(this).text('Next');
                    $(this).attr('data-next', next_question + 1);
                    $("#prev-btn").attr('data-pre', next_question - 1);
                    if ((next_question - 1) == 0) {
                        $("#prev-btn").attr('disabled', true);
                    } else {
                        $("#prev-btn").attr('disabled', false);
                    }
                }
            }         
        });
        $(document).on('click', "#prev-btn", function(){
            let pre_question = parseInt($(this).attr('data-pre'));
            if (pre_question > 0) {
                $(this).attr('disabled', false);
                $(".question-container").hide();
                $("#question-"+pre_question).show();
                $(this).attr('data-pre', pre_question - 1);
                if ((pre_question - 1) == 0) {
                    $(this).attr('disabled', true);
                    $("#next-btn").attr('data-next', 2);
                } else {
                    $(this).attr('disabled', false);
                    $("#next-btn").attr('data-next', pre_question);
                }
            } else {
                $(this).attr('disabled', true);
            }
            $("#next-btn").text("Next");      
        });
    });
</script>
@endsection