<div class="qa-container">
	@foreach($user_attempted_questions as $q)
	<div class="qa-card p-4 mb-3 bg-white rounded">
        <div class="question">{{ $q->screening_questions->question }}</div>
        <div class="answer">{{ $q->answer }}</div>
    </div>
	@endforeach
</div>