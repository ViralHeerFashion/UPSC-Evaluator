@extends('student.template.main')
@section('title', 'Evaluate Mains Answer')
@section('style')
<style>
    .content-page, .rbt-static-bar{max-width: 1000px!important;width: 1000px!important;}
    :root {
        --bg-color: #0E0C15;
        --card-color: #16181E;
        --primary-accent: #805AF5;
        --secondary-accent: #CD99FF;
        --text-primary: #F5F5F7;
        --text-secondary: #A1A1A6;
        --border-color: rgba(255, 255, 255, 0.1);
        --success-color: #30D158;
        --warning-color: #FF9F0A;
        --error-color: #FF453A;
        --highlight-color: rgba(128, 90, 245, 0.15);
    }
    #chatContainer{max-height: unset!important;}
    .tool-header {display: flex;justify-content: space-between;align-items: center;margin-bottom: 2.5rem;padding-bottom: 1.5rem;border-bottom: 1px dashed var(--border-color);}
    .tool-title {font-size: 1.75rem;font-weight: 600;letter-spacing: -0.5px;color: var(--text-primary);position: relative;padding-left: 1.5rem;}
    .tool-title:before {content: "";position: absolute;left: 0;top: 0;height: 100%;width: 4px;background: linear-gradient(to bottom, var(--primary-accent), var(--secondary-accent));border-radius: 2px;}
    .evaluation-summary {display: flex;align-items: center;gap: 1.5rem;}
    .total-score {background: rgba(25, 25, 35, 0.6);border-radius: 8px;padding: 0.75rem 1.25rem;border: 1px dashed var(--primary-accent);text-align: center;min-width: 100px;}
    .score-value {font-size: 1.5rem;font-weight: 700;margin-bottom: 0.25rem;background: linear-gradient(to right, var(--primary-accent), var(--secondary-accent));-webkit-background-clip: text;-webkit-text-fill-color: transparent;}
    .score-label {font-size: 0.75rem;color: var(--text-secondary);font-weight: 500;text-transform: uppercase;letter-spacing: 0.5px;}
    .evaluation-section {margin-bottom: 2.5rem;position: relative;}
    .section-header {display: flex;align-items: center;margin-bottom: 1.5rem;}
    .section-number {width: 35px;height: 35px;background: var(--highlight-color);border-radius: 50%;display: flex;align-items: center;justify-content: center;margin-right: 1rem;font-size: 1.875rem;font-weight: 600;color: var(--primary-accent);border: 1px dashed var(--primary-accent);}
    .section-title {font-size: 1.25rem;font-weight: 600;color: var(--text-primary);}
    .section-content {color: var(--text-secondary);font-size: 0.9375rem;padding-left: 3rem;border-left: 1px dashed var(--border-color);margin-left: 16px;padding-bottom: 1.5rem;}
    .section-content p {margin-bottom: 1rem;}
    .marking-grid-container {border: 1px dashed var(--border-color);border-radius: 8px;overflow: hidden;margin-top: 1.5rem;}
    .marking-grid {width: 100%;border-collapse: collapse;margin: unset;}
    .marking-grid thead th {background: rgba(22, 24, 30, 0.8);color: var(--text-secondary);font-weight: 500;font-size: 14px;text-transform: uppercase;letter-spacing: 0.5px;padding: 0.75rem 1rem;text-align: left;border-bottom: 1px dashed var(--border-color);}
    .marking-grid tbody tr {transition: background 0.2s ease;}
    .marking-grid tbody tr:hover {background: var(--highlight-color);}
    .marking-grid td {padding: 1rem;font-size: 14px;border-bottom: 1px dashed var(--border-color);}
    .component-name {font-weight: 500;color: var(--text-primary);}
    .score-cell {font-weight: 500;}
    .full-score {color: var(--success-color);}
    .partial-score {color: var(--warning-color);}
    .zero-score {color: var(--error-color);}
    .evaluation-list {list-style-type: none;margin-top: 1rem;margin-bottom: 5px!important;}
    .evaluation-list li {position: relative;padding-left: 1.75rem;margin-bottom: 0.75rem;font-size: 15px;}
    .strengths-list li:before {content: "";position: absolute;left: 0;top: 0.6rem;width: 10px;height: 10px;background-color: var(--success-color);border-radius: 2px;}
    .improvement-list li:before {content: "";position: absolute;left: 0;top: 0.5rem;width: 8px;height: 8px;background-color: var(--warning-color);border-radius: 2px;}
    .evaluation-footer {margin-top: 3rem;padding-top: 1.5rem;border-top: 1px dashed var(--border-color);text-align: center;color: var(--text-secondary);font-size: 0.875rem;}
    @media (max-width: 768px) {
        .evaluation-container {padding: 1.5rem;}
        .tool-header {flex-direction: column;align-items: flex-start;gap: 1.5rem;}
        .evaluation-summary {width: 100%;justify-content: space-between;}
        .marking-grid {display: block;overflow-x: auto;white-space: nowrap;}
    }
    @media (max-width: 480px) {
        body {padding: 1rem;}
        .evaluation-container {padding: 1.25rem;}
        .section-content {padding-left: 1.5rem;margin-left: 8px;}
    }
    .gap-analysis-container {font-family: 'Inter', system-ui, sans-serif;max-width: 680px;margin: 0 auto;}
    .gap-analysis-card {background: var(--card-color);border-radius: 20px;border: 1px solid var(--border-color);box-shadow: 0 12px 32px rgba(0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.03);overflow: hidden;position: relative;}
    .card-header {position: relative;padding: 24px;overflow: hidden;border-bottom: 1px solid var(--border-color);}
    .header-glow {position: absolute;top: -50%;left: -50%;width: 200%;height: 200%;background: radial-gradient(circle at center, rgba(128, 90, 245, 0.15) 0%, rgba(128, 90, 245, 0) 70%);z-index: 0;}
    .header-content {display: flex;gap: 16px;align-items: center;position: relative;z-index: 1;}
    .header-icon {flex-shrink: 0;width: 40px;height: 40px;}
    .header-text h3 {margin: 0;font-size: 20px;font-weight: 600;color: var(--text-primary);letter-spacing: -0.25px;}
    .gap-count {font-size: 14px;color: var(--secondary-accent);margin-top: 4px;}
    .gap-items-container {display: flex;flex-direction: column;gap: 24px;}
    .gap-item {background: rgba(255, 255, 255, 0.03);border-radius: 12px;border: 1px solid var(--border-color);padding: 20px;}
    .gap-title {display: flex;align-items: center;gap: 12px;margin-bottom: 18px;position: relative;}
    .gap-number {width: 28px;height: 28px;background: var(--primary-accent);color: white;border-radius: 8px;display: flex;align-items: center;justify-content: center;font-weight: 600;font-size: 14px;flex-shrink: 0;}
    .gap-title h4 {margin: 0;font-size: 16px;font-weight: 600;color: var(--text-primary);flex-grow: 1;}
    .gap-severity {font-size: 12px;font-weight: 600;padding: 4px 10px;border-radius: 20px;text-transform: uppercase;}
    .gap-severity.critical {background: rgba(255, 69, 58, 0.15);color: var(--error-color);}
    .gap-severity.important {background: rgba(255, 159, 10, 0.15);color: var(--warning-color);}
    .gap-severity.moderate {background: rgba(0, 122, 255, 0.15);color: var(--info-color);}
    .analysis-section {margin-bottom: 20px;}
    .analysis-section:last-child {margin-bottom: 0;}
    .section-header {display: flex;align-items: center;gap: 12px;margin-bottom: 12px;}
    .section-header h5 {margin: 0;font-size: 14px;font-weight: 500;color: var(--text-primary);}
    .section-dot {width: 8px;height: 8px;border-radius: 50%;background: var(--primary-accent);flex-shrink: 0;}
    .section-text {margin: 0;font-size: 14px;line-height: 1.7;color: var(--text-primary);padding-left: 20px;}
    .solution-list {margin: 0;padding-left: 20px;list-style: none;}
    .solution-list li {position: relative;padding-left: 28px;margin-bottom: 10px;color: var(--text-primary);line-height: 1.6;font-size: 14px;}
    .solution-list li:last-child {margin-bottom: 0;}
    .list-icon {position: absolute;left: 0;color: var(--success-color);font-weight: 700;}
    .gap-items-container::-webkit-scrollbar {width: 6px;}
    .gap-items-container::-webkit-scrollbar-track {background: transparent;}
    .gap-items-container::-webkit-scrollbar-thumb {background: var(--border-color);border-radius: 3px;}
    .gap-items-container::-webkit-scrollbar-thumb:hover {background: var(--primary-accent);}
    @media (max-width: 640px) {
        .gap-items-container {padding: 16px;}
        .gap-item {padding: 16px;}
    }
    .question-container{background-color: #17151f;padding: 15px;border-radius: 10px;}
    .mark-container{background: #805af5;border-radius: 25px;padding: 5px;border: 1px dashed;color: #0e0c15;}
    .text-right{text-align: right;margin-top: 15px!important;}
    .upload-file-btn{width: 100%;height: 55px;background-color: #805af5;border: 2px solid #805af5;color: var(--text-primary);line-height: 22px;padding: 16px 130px 16px 60px;font-size: 20px;}
    .premium-upload-container {width: 100%;box-sizing: border-box;font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;}
    .premium-upload-input {display: none;}
    .premium-upload-label {width: 100%;min-height: 160px;display: flex;flex-direction: column;align-items: center;justify-content: center;gap: 12px;padding: 24px;border: 2px dashed var(--border-color);border-radius: 12px;background-color: var(--card-color);cursor: pointer;transition: all 0.3s ease;box-sizing: border-box;}
    .upload-icon-wrapper {width: 60px;height: 60px;display: flex;align-items: center;justify-content: center;background: rgba(128, 90, 245, 0.1);border-radius: 50%;}
    .upload-icon {width: 24px;height: 24px;}
    .upload-text-content {text-align: center;display: flex;flex-direction: column;gap: 6px;}
    .upload-title {margin: 0;font-size: 16px;font-weight: 600;color: var(--text-primary);}
    .upload-subtitle {margin: 0;font-size: 13px;color: var(--text-secondary);font-weight: 400;}
    .upload-details {display: flex;align-items: center;gap: 8px;margin-top: 8px;flex-wrap: wrap;justify-content: center;}
    .detail-item {font-size: 11px;color: var(--text-secondary);background: rgba(255, 255, 255, 0.05);padding: 4px 8px;border-radius: 12px;font-weight: 500;}
    .detail-separator {color: var(--text-secondary);opacity: 0.3;}
    .premium-upload-label:hover {border-color: var(--primary-accent);background: rgba(128, 90, 245, 0.05);}
    @media (max-width: 480px) {
        .premium-upload-label {padding: 20px 16px;min-height: 140px;}
        .upload-icon-wrapper {width: 50px;height: 50px;}
        .upload-title {font-size: 15px;}
        .upload-subtitle {font-size: 12px;}
        .upload-details {gap: 6px;}
        .detail-item {font-size: 10px;padding: 3px 6px;}
    }
    #evaluate-form .change-answersheet-btn{
        padding: 5px;
    line-height: normal;
    margin: 0;
    height: auto;
    display: none;
    }
    

    
    .model-answer-container .model-answer-card {
                background: var(--card-color);
                border-radius: 12px;
                border: 1px solid var(--border-color);
                padding: 1.5rem;
                margin-bottom: 15px;
            }
            
            .model-answer-container .model-title-wrapper {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 1rem;
            }
            
            .model-answer-container .model-icon {
                width: 32px;
                height: 32px;
                background: var(--highlight-color);
                border-radius: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            
            .model-answer-container .model-icon i {
                color: var(--primary-accent);
                font-size: 15px;
            }
            
            .model-answer-container .model-title {
                font-size: 15px;
                font-weight: 600;
                color: var(--text-primary);
                margin: 0;
            }
            
            .model-answer-container .model-description {
                color: var(--text-secondary);
                line-height: 1.6;
                padding-left: 44px; /* Match icon width + gap */
            }
            
            @media (max-width: 768px) {
                .model-answer-container .model-answer-container {
                    padding: 1rem;
                }
                
                .model-answer-container .model-description {
                    padding-left: 0;
                }
            }
</style>
@endsection
@section('tab-name')
<div class="banner-area">
    <div class="settings-area">
        <h3 class="title">Evaluate Mains Answer</h3>
    </div>
</div>
@endsection
@section('content')
<div class="content-page">

    <div class="chat-box-section">
        <div class="chat-top-bar">
            <div class="section-title">
                <!-- <div class="icon">
                    <img src="images/document-file.png" alt="">
                </div> -->
                <h6 class="title">Welcome {{ auth()->user()->name }}</h6>
            </div>
            <div class="dropdown history-box-dropdown">
                <button type="button" class="more-info-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true">
                    <i class="fa-regular fa-ellipsis"></i>
                </button>
                <ul class="dropdown-menu style-one" data-popper-placement="bottom-end" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-177px, 32px);">
                    <li><a class="dropdown-item" href="#"><i class="fa-sharp fa-solid fa-arrows-rotate"></i> Regenerate</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fa-sharp fa-solid fa-tag"></i> Pin Chat</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-file-lines"></i> Rename</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-share-nodes"></i> Share</a></li>
                    <li><a class="dropdown-item delete-item" href="#"><i class="fa-solid fa-trash-can"></i> Delete Chat</a></li>
                </ul>
            </div>
        </div>

        <div class="chat-box-list pt--30" id="chatContainer">
            <div class="chat-box author-speech">
                <div class="inner">
                    <div class="chat-section">
                        <div class="author">
                            <img class="w-100" src="{{ asset('images/user-profile.jpg') }}" alt="Author">
                        </div>
                        <div class="chat-content">
                            <h6 class="title">You</h6>
                            <p>
                                <i class="fa-solid fa-file-pdf"></i> <span class="pdf-name">answer.pdf</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat-box ai-speech">
                <div class="inner">
                    <div class="answers-container">
                        <div class="answer-container">
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
                                    <div class="section-content model-answer-container">
                                        @foreach($question->model_answer as $model_answer)
                                        <div class="model-answer-card">
                                            <div class="model-title-wrapper">
                                                <div class="model-icon">
                                                    <i class="fas fa-brain"></i>
                                                </div>
                                                <h5 class="model-title">{{ $model_answer->title }}</h5>
                                            </div>
                                            <p class="model-description">{{ $model_answer->description }}</p>
                                        </div>
                                        @endforeach
                                    </div>
                                </section>
                            </div>
                            @php($i++)
                            @endforeach


                            {{--
                            <div class="chat-content">
                                <div class="evaluation-section">
                                    <p style="text-align: right;">
                                        <a href="" class="btn-default"><i class="fa-solid fa-download"></i>&nbsp; Export</a>
                                    </p>
                                </div>
                            </div>
                            --}}
                        </div>
                    </div>
                </div>
            </div> 
        </div>

        <div class="rbt-static-bar" style="display: block;">
            <form class="new-chat-form border-gradient">
                <button type="button" class="upload-file-btn"><i class="fa-solid fa-upload"></i>&nbsp; Ask Test</button>                
            </form>
            <p class="b3 small-text">AiWave can make mistakes. Consider checking important information.</p>
        </div>
    </div>
</div>
@include('student.mains-evaluation.partials.modals')
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $(".answer-evaluation").addClass('active');
        $.validator.addMethod("pdfValidation", function(value, element) {
            if (!element.files || element.files.length === 0) {
                return this.optional(element);
            }
            
            const file = element.files[0];
            const fileName = file.name.toLowerCase();
            const fileType = file.type;
            
            return (fileName.endsWith('.pdf') && (fileType === 'application/pdf' || fileType === 'application/x-pdf'));
        }, "Please upload a valid PDF file");

        $("#evaluate-form").validate({
            ignore: ":hidden:not(#answer_sheet)",
            rules: {
                answer_sheet: {
                    required: true,
                    pdfValidation: true
                }
            },
            messages: {

            },
            submitHandler: function(form){
                
                let url = "{{ route('student.mains-evaluation.make-evaluate') }}";
                var file = $("#answer_sheet")[0].files[0];
                
                var formData = new FormData();
                formData.append('answer_sheet', file);
                formData.append('_token', '{{ csrf_token() }}');
                console.log(formData);
                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){

                    },
                    success: function(response) {
                        $(".answers-container").last().html(response);
                    }
                });

                console.log("This is a run");return false;

                return false;
            }
        });
        $(".upload-file-btn").on('click', function(){
            $("#answersheet-upload-modal").modal('show');return false;
        });
        $("#answer_sheet").on('change', function(){
            let file = $("#answer_sheet")[0].files[0];
            if (file != undefined) {
                $("#evaluate-form .upload-title").text(file.name);
                $("#evaluate-form .upload-subtitle").text("Uploaded successfully...");
                $("#evaluate-form .change-answersheet-btn").show();
            } else {
                $("#evaluate-form .upload-title").text("Upload Your Answersheet");
                $("#evaluate-form .upload-subtitle").text("Drag & drop files here or click to browse");
                $("#evaluate-form .change-answersheet-btn").hide();
            }
        });
        $("#evaluate-form .change-answersheet-btn").on('click', function(){
            $("#answer_sheet").trigger('click');
        });
    });
</script>
@endsection