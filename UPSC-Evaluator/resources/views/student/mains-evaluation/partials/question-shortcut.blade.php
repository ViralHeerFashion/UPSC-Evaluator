@php($i = 1)
@php($url_process_id = null)
@if(isset($process_id))
@php($url_process_id = $process_id)
@endif
@php($total_marks = $marks_awarded = 0)
@foreach($questions as $q)
    <li class="history-box">
        <a href="{{ route('student.mains-evaluation', ['process_id' => $url_process_id]) }}#question-{{$i}}" class="w-100">
            <div class="question-shortcut">
                <div class="margin-right-auto">Q{{$i}}</div>
                <div class="dropdown history-box-dropdown">{{ $q['marks_awarded'] }} / {{ $q['max_marks'] }}</div>
            </div>
        </a>
    </li>
    @php($marks_awarded += $q['marks_awarded'])
    @php($total_marks += $q['max_marks'])
    @php($i++)
@endforeach
<li class="history-box active">
    <a href="javascript:void(0);" class="w-100">
        <div class="question-shortcut">
            <div class="margin-right-auto">Total</div>
            <div class="dropdown history-box-dropdown">{{ $marks_awarded }} / {{ $total_marks }}</div>
        </div>
    </a>
</li>