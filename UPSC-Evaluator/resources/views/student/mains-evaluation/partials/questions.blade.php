@foreach($student_answer_sheet->student_answer_evaluation as $question)
<div class="chat-content">
    <section class="evaluation-section">
        <p class="question-container">{{ $question->question_no }})&nbsp; {{ $question->question }}</p>
    </section>
</div>
<div class="chat-content">
    <section class="evaluation-section">
        <div class="section-header">
            <div>
                <img src="{{ asset('images/icons/qd.svg') }}" class="w35">
            </div>
            <h6 class="title">Question Deconstruction</h6>
        </div>
        <div class="section-content">
            <p>{{ $question->deconstruction }}</p>
        </div>
    </section>
</div>
<div class="chat-content">
    <section class="evaluation-section">
        <div class="section-header">
            <div>
                <img src="{{ asset('images/icons/gt.svg') }}" class="w35">
            </div>
            <h6 class="title">Micro-Marking Grid</h6>
        </div>
        <div class="section-content">
            <div class="marking-grid-container">
                <table class="marking-grid table-striped text-center">
                    <thead>
                        <tr>
                            <th>Component</th>
                            <th>Weight</th>
                            <th>Max</th>
                            <th>Given</th>
                            <th>Justification</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($question->micro_marking_grid as $marking_grid)
                        <tr>
                            <td class="component-name">{{ $marking_grid->component }}</td>
                            <td>{{ $marking_grid->weight }}%</td>
                            <td>{{ $marking_grid->max_marks }}</td>
                            <td>{{ $marking_grid->marks_awarded }}</td>
                            <td>{{ $marking_grid->justifications }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<div class="chat-content">
    <section class="evaluation-section">
        <div class="section-header">
            <div>
                <img src="{{ asset('images/icons/st.svg') }}" class="w35">
            </div>
            <h6 class="title">Strengths Snapshot</h6>
        </div>
        <div class="section-content">
            <ul class="strength-snapshot-list">
                @foreach($question->strength_snapshot as $snapshot)
                <li>
                    <img src="{{ asset('images/icons/li.svg') }}" class="w35">
                    {{ $snapshot->snapshot }}
                </li>
                @endforeach
            </ul>
        </div>
    </section>
</div>
<div class="chat-content">
    <section class="evaluation-section">
        <div class="section-header">
            <div>
                <img src="{{ asset('images/icons/ga.svg') }}" class="w35">
            </div>
            <h6 class="title">Gap Analysis & Priority Fixes</h6>
        </div>
        <div class="section-content">
            <div class="gap-items-container">
                @php($j = 1)
                @foreach($question->gap_analysis_priority_fix as $gap_analysis_priority_fix)
                <div class="gap-item">
                    <div class="gap-title">
                        <div class="gap-number-">
                            <img src="{{ asset('images/icons/gat.svg') }}" class="w20">
                        </div>
                        <h4>{{ $gap_analysis_priority_fix->gap }}</h4>
                    </div>
                    
                    <div class="analysis-section">
                        <div class="section-header">
                            <div class="section-dot-" style="">
                                <img src="{{ asset('images/icons/gai.svg') }}" class="w20">
                            </div>
                            <h5>Impact Analysis</h5>
                        </div>
                        <p class="section-text ml-10px">{{ $gap_analysis_priority_fix->impact }}</p>
                    </div>

                    <div class="analysis-section">
                        <div class="section-header">
                            <div class="section-dot-" style="">
                                <img src="{{ asset('images/icons/gas.svg') }}" class="w20">
                            </div>
                            <h5>Optimal Solution</h5>
                        </div>
                        <p class="section-text ml-10px">{{ $gap_analysis_priority_fix->correct_action }}</p>
                    </div>
                </div>
                @php($j++)
                @endforeach
            </div>
        </div>
    </section>
</div>
<div class="chat-content">
    <section class="evaluation-section">
        <div class="section-header">
            <div>
                <img src="{{ asset('images/icons/ma.svg') }}" class="w35">
            </div>
            <h6 class="title">Model Answer</h6>
        </div>
        <div class="section-content model-answer-container">
            <div class="model-answer-card">
                @if(!empty($question->model_answer_intro))
                <p class="p-3 m-auto mb-3">{{ $question->model_answer_intro }}</p>
                @endif
                @foreach($question->model_answer as $model_answer)
                <div class="model-title-wrapper">
                    <div class="model-icon">
                        <img src="{{ asset('images/icons/mat.svg') }}" class="w35">
                    </div>
                    <h5 class="model-title">{{ $model_answer->title }}</h5>
                </div>
                <p class="model-description">{{ $model_answer->description }}</p>
                @endforeach
                @if(!empty($question->model_answer_conclusion))
                <p class="p-3 m-auto mb-3">{{ $question->model_answer_conclusion }}</p>
                @endif
            </div>
        </div>
    </section>
</div>
<div class="chat-content custom-margin-bottom">
    <section class="evaluation-section">
        <div class="section-header">
            <div>
                <img src="{{ asset('images/icons/mb.svg') }}" class="w35">
            </div>
            <h6 class="title">Marks Breakdown</h6>
        </div>
        <div class="section-content">
            <div class="dashboard" data-score="{{ $question->marks_awarded }}" data-total="{{ $question->max_marks }}">
                <div class="progress-container">
                    <div class="score-section">
                        <div class="emoji-container"></div>
                        <div class="score-display">
                            <div class="score-value"></div>
                            <div class="score-label">Marks Scored</div>
                        </div>
                    </div>
                    
                    <div class="progress-section">
                        <div class="position-indicator">You are here</div>
                        <div class="progress-bar">
                            <div class="progress-fill"></div>
                        </div>
                        
                        <div class="markers"></div>
                    </div>
                    
                    <div class="message-section">
                        <div class="message-title"></div>
                        <div class="message-content"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endforeach