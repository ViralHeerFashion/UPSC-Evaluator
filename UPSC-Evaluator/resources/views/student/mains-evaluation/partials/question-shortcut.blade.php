@php($i = 1)
@php($url_process_id = null)
@if(isset($process_id))
@php($url_process_id = $process_id)
@endif
@foreach($questions as $q)
    <li class="history-box">
        <a href="{{ route('student.mains-evaluation', ['process_id' => $url_process_id]) }}#question-{{$i}}">{{$i}}) {{ $q['question_text'] }}</a>
    </li>
    @php($i++)
@endforeach