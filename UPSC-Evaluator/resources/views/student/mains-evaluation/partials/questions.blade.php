@php($i = 1)
@foreach($student_answer_sheet->student_answer_evaluation as $question)
<div class="chat-content">
    <section class="evaluation-section">
        <p class="question-container">{{ $i }})&nbsp; {{ $question->question }}</p>
        <p class="text-right">
            <span class="mark-container">{{ $question->marks_awarded }} / {{ $question->max_marks }} Marks</span>
        </p>
    </section>
</div>
<div class="chat-content">
    <section class="evaluation-section">
        <div class="section-header">
            <div class="section-number">1</div>
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
            <div class="section-number">2</div>
            <h6 class="title">Micro-Marking Grid</h6>
        </div>
        <div class="section-content">
            <div class="marking-grid-container">
                <table class="marking-grid">
                    <thead>
                        <tr>
                            <th>Component</th>
                            <th>Weight %</th>
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
                        <tr>
                            <td class="component-name">Introduction & Context</td>
                            <td>10%</td>
                            <td>1.0</td>
                            <td class="score-cell zero-score">0.0</td>
                            <td>No establishment of context or framing of the discussion</td>
                        </tr>
                        <tr>
                            <td class="component-name">Content Depth & Accuracy</td>
                            <td>40%</td>
                            <td>4.0</td>
                            <td class="score-cell partial-score">2.0</td>
                            <td>Basic identification of issues but lacks substantive examples or depth</td>
                        </tr>
                        <tr>
                            <td class="component-name">Critical Analysis</td>
                            <td>20%</td>
                            <td>2.0</td>
                            <td class="score-cell partial-score">1.0</td>
                            <td>Superficial examination without probing the proposal's implications</td>
                        </tr>
                        <tr>
                            <td class="component-name">Structure & Coherence</td>
                            <td>20%</td>
                            <td>2.0</td>
                            <td class="score-cell partial-score">1.0</td>
                            <td>Disjointed argument flow without clear logical progression</td>
                        </tr>
                        <tr>
                            <td class="component-name">Conclusion</td>
                            <td>10%</td>
                            <td>1.0</td>
                            <td class="score-cell zero-score">0.0</td>
                            <td>Missing synthesis or final evaluative position</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<div class="chat-content">
    <section class="evaluation-section">
        <div class="section-header">
            <div class="section-number">3</div>
            <h6 class="title">Strengths Snapshot</h6>
        </div>
        <div class="section-content">
            <ul class="evaluation-list strengths-list">
                @foreach($question->strength_snapshot as $snapshot)
                <li>{{ $snapshot->snapshot }}</li>
                @endforeach
                <li>Mentions India's non-signatory status to the NPT</li>
                <li>Touches upon the issue of nuclear technology access</li>
                <li>Gap Analysis & Priority Fixes</li>
            </ul>
        </div>
    </section>
</div>
<div class="chat-content">
    <section class="evaluation-section">
        <div class="section-header">
            <div class="section-number">5</div>
            <h6 class="title">Gap Analysis & Priority Fixes</h6>
        </div>
        <div class="section-content">
            <div class="gap-items-container">
                @php($j = 1)
                @foreach($question->gap_analysis_priority_fix as $gap_analysis_priority_fix)
                <div class="gap-item">
                    <div class="gap-title">
                        <div class="gap-number">{{ $j }}</div>
                        <h4>{{ $gap_analysis_priority_fix->gap }}</h4>
                    </div>
                    
                    <div class="analysis-section">
                        <div class="section-header">
                            <div class="section-dot" style="background: var(--warning-color);"></div>
                            <h5>Impact Analysis</h5>
                        </div>
                        <p class="section-text">{{ $gap_analysis_priority_fix->impact }}</p>
                    </div>

                    <div class="analysis-section">
                        <div class="section-header">
                            <div class="section-dot" style="background: var(--success-color);"></div>
                            <h5>Optimal Solution</h5>
                        </div>
                        <p class="section-text">{{ $gap_analysis_priority_fix->correct_action }}</p>
                    </div>
                </div>
                @php($j++)
                @endforeach

                <div class="gap-item">
                    <div class="gap-title">
                        <div class="gap-number">1</div>
                        <h4>Lack of in-depth analysis of NPT flaws</h4>
                    </div>
                    
                    <div class="analysis-section">
                        <div class="section-header">
                            <div class="section-dot" style="background: var(--warning-color);"></div>
                            <h5>Impact Analysis</h5>
                        </div>
                        <p class="section-text">The answer fails to critically examine the inherent contradictions and discriminatory nature of the NPT, particularly the unequal treatment of nuclear weapon states and non-nuclear weapon states.</p>
                    </div>

                    <div class="analysis-section">
                        <div class="section-header">
                            <div class="section-dot" style="background: var(--success-color);"></div>
                            <h5>Optimal Solution</h5>
                        </div>
                        <p class="section-text">Discuss the treaty's discriminatory aspects, such as the unequal treatment of nuclear weapon states (NWS) and non-nuclear weapon states (NNWS).  Explain the concept of nuclear apartheid and its implications for international security.</p>
                    </div>
                </div>
                <div class="gap-item">
                    <div class="gap-title">
                        <div class="gap-number">2</div>
                        <h4>Insufficient detail on India's specific concerns</h4>
                    </div>
                    
                    <div class="analysis-section">
                        <div class="section-header">
                            <div class="section-dot" style="background: var(--warning-color);"></div>
                            <h5>Impact Analysis</h5>
                        </div>
                        <p class="section-text">The answer does not adequately explain India's specific concerns regarding the NPT, such as its discriminatory nature and the lack of progress on disarmament by NWS.</p>
                    </div>

                    <div class="analysis-section">
                        <div class="section-header">
                            <div class="section-dot" style="background: var(--success-color);"></div>
                            <h5>Optimal Solution</h5>
                        </div>
                        <p class="section-text">Elaborate on India's reasons for not signing the NPT, including its opposition to the discriminatory nature of the treaty and its call for complete nuclear disarmament by NWS. Mention India's commitment to a minimum credible deterrence policy.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="chat-content">
    <section class="evaluation-section">
        <div class="section-header">
            <div class="section-number">6</div>
            <h6 class="title">Model Answer</h6>
        </div>
        <div class="section-content">
            <div class="gap-items-container">
                <div class="gap-item">
                    <div class="analysis-section">
                        <p class="section-text">The Nuclear Non-Proliferation Treaty (NPT), while widely ratified, suffers from inherent flaws, particularly concerning its discriminatory nature. India's refusal to sign stems from this inherent inequity. The treaty grants nuclear weapon states (NWS) – the US, Russia, China, France, and UK – unfettered possession, while denying the same to non-NWS, creating a double standard. This is exemplified by the continued nuclear arsenal expansion of NWS despite NPT obligations for disarmament. India's specific concerns include the NPT's failure to address the security threats posed by Pakistan's nuclear arsenal, acquired without adhering to the treaty's stipulations. Furthermore, the discriminatory application of sanctions against countries pursuing nuclear technology, even for peaceful purposes, as seen with India's nuclear program pre-2000, highlights the treaty's biased implementation. India's pursuit of a nuclear doctrine based on minimum deterrence, coupled with its commitment to non-proliferation through robust export controls, underscores its responsible approach despite its non-signatory status. In conclusion, this answer addresses the key aspects of the question as per UPSC standards.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@php($i++)
@endforeach