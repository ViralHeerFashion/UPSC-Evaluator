@extends('student.template.main')
@section('title', 'Evaluate Mains Answer')
@section('style')
<style>
	
    .content-page, .rbt-static-bar{max-width: 1000px!important;width: 1000px!important;}
    :root {
        --bg-color: #0E0C15;
        --card-color: #18191c;
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
    .marking-grid thead th {text-align: center;background: rgba(22, 24, 30, 0.8);color: #f7f7ff;font-weight: 500;font-size: 14px;text-transform: uppercase;letter-spacing: 0.5px;padding: 0.75rem 1rem;text-align: left;border-bottom: 1px dashed var(--border-color);}
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
    /* .strengths-list li:before {content: "";position: absolute;left: 0;top: 0.6rem;width: 10px;height: 10px;background-color: var(--success-color);border-radius: 2px;} */
    /* .improvement-list li:before {content: "";position: absolute;left: 0;top: 0.5rem;width: 8px;height: 8px;background-color: var(--warning-color);border-radius: 2px;} */
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
    .gap-item {background: var(--card-color);border-radius: 12px;border: 2px dashed var(--border-color);padding: 20px;}
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
    .mark-container{background: #805af5;border-radius: 25px;padding: 5px;border: 1px dashed #0e0c15;color: #fff;}
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
    @media (max-width: 480px) {.premium-upload-label {padding: 20px 16px;min-height: 140px;}.upload-icon-wrapper {width: 50px;height: 50px;}.upload-title {font-size: 15px;}.upload-subtitle {font-size: 12px;}.upload-details {gap: 6px;}.detail-item {font-size: 10px;padding: 3px 6px;}}
    #evaluate-form .change-answersheet-btn{padding: 5px;line-height: normal;margin: 0;height: auto;display: none;}    
    .model-answer-container .model-answer-card {background: var(--card-color);border-radius: 12px;border: 1px solid var(--border-color);padding: 1.5rem;margin-bottom: 15px;}
    .model-answer-container .model-title-wrapper {display: flex;align-items: center;gap: 12px;margin-bottom: 1rem;}
    .model-answer-container .model-icon {width: 32px;height: 32px;background: var(--highlight-color);border-radius: 6px;display: flex;align-items: center;justify-content: center;flex-shrink: 0;}
    .model-answer-container .model-icon i {color: var(--primary-accent);font-size: 15px;}
    .model-answer-container .model-title {font-size: 15px;font-weight: 600;color: var(--text-primary);margin: 0;}
    .model-answer-container .model-description {color: var(--text-secondary);line-height: 1.6;padding-left: 44px;margin-bottom: 15px;}
    @media (max-width: 768px) {
        .model-answer-container .model-answer-container {padding: 1rem;}
        .model-answer-container .model-description {padding-left: 0;}
    }
    .dashboard {max-width: 900px;width: 100%;background: var(--card-color);border-radius: 20px;padding: 25px 30px;border: 1px solid var(--border-color);box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);position: relative;overflow: hidden;}
    .dashboard::before {content: '';position: absolute;top: 0;left: 0;right: 0;height: 5px;background: linear-gradient(90deg, var(--primary-accent), var(--secondary-accent));}
    .progress-container {display: flex;align-items: center;justify-content: space-between;gap: 20px;}
    .score-section {display: flex;align-items: center;gap: 15px;}
    .emoji-container {font-size: 40px;animation: bounce 1.5s ease infinite alternate;min-width: 50px;}
    .score-display {display: flex;flex-direction: column;}
    .score-value {font-size: 36px;font-weight: 800;background: linear-gradient(135deg, var(--primary-accent), var(--secondary-accent));-webkit-background-clip: text;-webkit-text-fill-color: transparent;background-clip: text;line-height: 1;}
    .score-label {font-size: 14px;color: var(--text-secondary);margin-top: 4px;}
    .progress-section {flex: 1;position: relative;padding: 15px 0;}
    .position-indicator {position: absolute;top: 0;left: var(--progress-percent);transform: translateX(-50%);background: rgba(128, 90, 245, 0.2);padding: 5px 15px;border-radius: 20px;font-weight: 600;color: var(--secondary-accent);border: 1px solid var(--primary-accent);font-size: 14px;box-shadow: 0 4px 10px rgba(128, 90, 245, 0.3);animation: fadeIn 1s ease-out;white-space: nowrap;}
    .position-indicator::after {content: '';position: absolute;bottom: -8px;left: 50%;transform: translateX(-50%);border-left: 8px solid transparent;border-right: 8px solid transparent;border-top: 8px solid var(--primary-accent);}
    .progress-bar {height: 8px;background: rgba(255, 255, 255, 0.1);border-radius: 4px;overflow: hidden;margin-top: 25px;position: relative;}
    .progress-fill {height: 100%;width: 0;border-radius: 4px;background: linear-gradient(90deg, var(--primary-accent), var(--secondary-accent));animation: fillProgress 1.5s cubic-bezier(0.22, 1, 0.36, 1) forwards;box-shadow: 0 0 10px rgba(128, 90, 245, 0.5);}
    .markers {display: flex;justify-content: space-between;position: relative;margin-top: 10px;}
    .marker {position: relative;display: flex;flex-direction: column;align-items: center;}
    .marker-point {width: 12px;height: 12px;border-radius: 50%;background: var(--card-color);border: 2px solid var(--text-secondary);margin-bottom: 5px;transition: all 0.3s ease;}
    .marker.active .marker-point {background: var(--secondary-accent);border-color: var(--primary-accent);box-shadow: 0 0 10px var(--primary-accent);transform: scale(1.3);}
    .marker-label {font-size: 14px;font-weight: 600;color: var(--text-secondary);}
    .marker.active .marker-label {color: var(--text-primary);font-weight: 700;}
    .message-section {min-width: 200px;text-align: right;display: flex;flex-direction: column;align-items: flex-end;}
    .message-title {font-size: 18px;font-weight: 700;margin-bottom: 5px;color: var(--secondary-accent);white-space: nowrap;}
    .message-content {font-size: 14px;color: var(--text-secondary);white-space: nowrap;}
    .action-button {background: linear-gradient(90deg, var(--primary-accent), var(--secondary-accent));color: white;border: none;padding: 10px 20px;border-radius: 50px;font-size: 14px;font-weight: 600;cursor: pointer;transition: all 0.3s ease;box-shadow: 0 4px 12px rgba(128, 90, 245, 0.4);margin-top: 10px;display: flex;align-items: center;gap: 8px;white-space: nowrap;}
    .action-button:hover {transform: translateY(-3px);box-shadow: 0 6px 18px rgba(128, 90, 245, 0.6);}
    @keyframes fillProgress {
        to {width: var(--progress-percent);}
    }
    @keyframes bounce {
        0% { transform: translateY(0); }
        100% { transform: translateY(-5px); }
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(128, 90, 245, 0.6); }
        70% { box-shadow: 0 0 0 10px rgba(128, 90, 245, 0); }
        100% { box-shadow: 0 0 0 0 rgba(128, 90, 245, 0); }
    }
    @media (max-width: 768px) {
        .progress-container {flex-direction: column;align-items: stretch;gap: 15px;}
        .score-section {justify-content: center;}
        .message-section {text-align: center;align-items: center;}
    }

    .strength-snapshot-list{list-style-type: none;padding-left: 0;}
    .strength-snapshot-list li{background-color: var(--card-color);padding: 7px;border-radius: 10px;color: #d7d7d7;border: 1px dashed #7e7474;}
    .gap-title{border-bottom: 1px dashed #565151;padding-bottom: 10px;}
    .ml-10px{margin-left: 10px!important;}
    .mt-5px{margin-top: 4px!important;}
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
                            <p class="mt-5px">
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
                                    {{-- 
                                    <p class="text-right">
                                        <span class="mark-container">{{ $question->marks_awarded }} / {{ $question->max_marks }} Marks</span>
                                    </p>
                                    --}}
                                </section>
                            </div>
                            <div class="chat-content">
                                <section class="evaluation-section">
                                    <div class="section-header">
                                        <div class="section-number-">
                                            <!-- 1 -->
                                            <!-- <svg width="35px" height="35px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M768 938.666667H170.666667V170.666667h426.666666l170.666667 170.666666z" fill="#53626e"></path><path d="M853.333333 853.333333H256V85.333333h426.666667l170.666666 170.666667z" fill="#86c2f4"></path><path d="M821.333333 277.333333H661.333333V117.333333z" fill="#306882"></path><path d="M522.666667 603.733333c0-100.266667 76.8-93.866667 76.8-153.6 0-14.933333-4.266667-44.8-42.666667-44.8-42.666667 0-44.8 34.133333-44.8 42.666667h-57.6c0-14.933333 6.4-89.6 102.4-89.6 98.133333 0 100.266667 76.8 100.266667 91.733333 0 74.666667-81.066667 85.333333-81.066667 155.733334h-53.333333z m-4.266667 74.666667c0-4.266667 0-32 32-32 29.866667 0 32 27.733333 32 32 0 8.533333-4.266667 29.866667-32 29.866667s-32-21.333333-32-29.866667z" fill="#2a5783"></path></g></svg> -->
                                            <svg width="35px" height="35px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M215.412 747.654c0 20.425 16.557 36.983 36.983 36.983h30.761-30.761c-20.425 0-36.983 16.558-36.983 36.983v30.761-30.761c0-20.425-16.558-36.983-36.983-36.983h-30.761 30.761c20.424-0.001 36.983-16.558 36.983-36.983v-30.761 30.761z" fill="#ED8F27"></path><path d="M227.99 852.377h-25.154v-30.755c0-13.462-10.948-24.409-24.41-24.409h-30.763v-25.154h30.763c13.462 0 24.41-10.948 24.41-24.41v-30.754h25.154v30.754c0 13.462 10.947 24.41 24.4 24.41v25.154c-13.453 0-24.4 10.947-24.4 24.409v30.755z m-16.606-67.741a49.398 49.398 0 0 1 4.029 4.028 47.603 47.603 0 0 1 4.02-4.028 47.764 47.764 0 0 1-4.02-4.029 49.094 49.094 0 0 1-4.029 4.029z m71.77 12.577H252.39v-25.154h30.764v25.154z" fill="#ED8F27"></path><path d="M721.536 134.403c0 22.309 18.084 40.393 40.393 40.393h33.598-33.598c-22.309 0-40.393 18.085-40.393 40.394v33.598-33.598c0-22.309-18.085-40.394-40.394-40.394h-33.598 33.598c22.309 0 40.394-18.084 40.394-40.393v-33.598 33.598z" fill="#ED8F27"></path><path d="M735.275 248.784h-27.474v-33.591c0-14.703-11.958-26.66-26.661-26.66h-33.6v-27.474h33.6c14.703 0 26.661-11.958 26.661-26.661v-33.59h27.474v33.59c0 14.703 11.957 26.661 26.651 26.661v27.474c-14.694 0-26.651 11.957-26.651 26.66v33.591z m-18.138-73.988a53.875 53.875 0 0 1 4.4 4.399 52.217 52.217 0 0 1 4.39-4.399 52.08 52.08 0 0 1-4.39-4.4 53.888 53.888 0 0 1-4.4 4.4z m78.389 13.737h-33.6v-27.474h33.6v27.474z" fill="#ED8F27"></path><path d="M488.445 842.076h39.783v29.79h-39.783zM746.417 256.375h104.96v29.79h-104.96zM879.543 256.375h35.335v29.79h-35.335zM566.969 842.076h23.449v29.79h-23.449zM433.533 842.076h23.449v29.79h-23.449z" fill="#300604"></path><path d="M911.405 372.591v339.597l-102.581-0.632S704.592 833.938 705.788 833.75c1.196-0.188 0-123.314 0-123.314l-269.809 1.751V372.591h475.426z" fill="#FCE3C3"></path><path d="M699.002 722.731H423.641V361.913h498.444v360.818H813.782L699.002 855.4V722.731z m201.725-339.46H444.999v318.101H720.36v96.697l83.66-96.697h96.707V383.271z" fill="#300604"></path><path d="M696.574 861.92V725.159H421.212V359.484h503.302v365.675H814.892L696.574 861.92zM426.07 720.302h275.361v128.579l111.24-128.579h106.985v-355.96H426.07v355.96z m291.862 84.287V703.801H442.571V380.843h460.585v322.958h-98.025l-87.199 100.788zM447.428 698.943h275.361v92.606l80.121-92.606h95.388V385.7h-450.87v313.243z" fill="#300604"></path><path d="M658.299 372.903V245.987H110.875v344.052h87.393l88.483 100.92-1.169-100.92h147.937V372.903z" fill="#228E9D"></path><path d="M289.99 706.907L187.59 600.72h-87.394V235.306h568.781v148.278h-224.78V600.72H290.464l-0.474 106.187zM121.555 579.362h75.819l74.253 77.834 0.228-77.834h150.983V362.226h224.781V256.664H121.555v322.698z" fill="#300604"></path><path d="M292.392 712.896L186.559 603.148H97.768V232.877h573.639v153.136H446.625v217.136H292.882l-0.49 109.747zM102.625 598.291h85.997l98.966 102.627 0.458-102.627h153.721V381.155h224.781V237.734H102.625v360.557z m171.413 64.95l-77.703-81.451h-77.208V254.235h530.922v110.419H425.267V581.79H274.276l-0.238 81.451z m-150.055-86.308h74.43l70.802 74.217 0.218-74.217H420.41V359.797h224.78V259.093H123.983v317.84z" fill="#300604"></path><path d="M320.956 450.316c3.896 2.639 8.151 5.2 12.767 7.688 4.615 2.487 7.671 4.466 9.17 5.934 1.498 1.47 2.248 3.552 2.248 6.249 0 1.917-0.885 3.835-2.652 5.754-1.769 1.917-3.911 2.877-6.428 2.877-2.039 0-4.511-0.66-7.417-1.979-2.908-1.318-6.324-3.236-10.25-5.754-3.926-2.518-8.227-5.453-12.902-8.811-8.691 4.435-19.361 6.653-32.007 6.653-10.25 0-19.436-1.634-27.557-4.9-8.123-3.267-14.94-7.971-20.454-14.115-5.515-6.144-9.665-13.441-12.452-21.893s-4.181-17.651-4.181-27.602c0-10.129 1.453-19.421 4.36-27.872s7.117-15.644 12.632-21.578c5.514-5.934 12.228-10.474 20.139-13.621 7.912-3.146 16.903-4.72 26.973-4.72 13.666 0 25.399 2.773 35.199 8.316 9.8 5.545 17.217 13.428 22.252 23.646 5.035 10.221 7.552 22.223 7.552 36.009 0 20.92-5.664 37.492-16.992 49.719z m-20.949-14.565c3.716-4.255 6.458-9.29 8.227-15.104 1.768-5.812 2.652-12.556 2.652-20.229 0-9.65-1.559-18.012-4.675-25.085-3.117-7.071-7.567-12.421-13.351-16.048-5.785-3.626-12.423-5.439-19.915-5.439-5.335 0-10.265 1.004-14.79 3.012-4.526 2.009-8.422 4.931-11.688 8.766-3.268 3.837-5.844 8.736-7.732 14.7-1.888 5.965-2.832 12.663-2.832 20.095 0 15.164 3.536 26.837 10.609 35.019 7.072 8.182 16.004 12.272 26.792 12.272 4.435 0 8.991-0.929 13.666-2.787-2.818-2.098-6.338-4.194-10.564-6.294-4.226-2.097-7.118-3.715-8.676-4.854-1.559-1.138-2.337-2.756-2.337-4.855 0-1.798 0.749-3.385 2.248-4.765 1.498-1.378 3.147-2.068 4.945-2.068 5.453-0.002 14.594 4.555 27.421 13.664z" fill="#ED8F27"></path><path d="M336.06 481.246c-2.409 0-5.164-0.718-8.421-2.195-3-1.36-6.552-3.353-10.557-5.922-3.621-2.321-7.593-5.021-11.822-8.034-8.756 4.156-19.437 6.262-31.775 6.262-10.513 0-20.089-1.708-28.463-5.076-8.433-3.391-15.618-8.353-21.355-14.746-5.713-6.364-10.071-14.02-12.951-22.754-2.855-8.657-4.303-18.2-4.303-28.362 0-10.354 1.511-19.998 4.493-28.662 3.004-8.734 7.428-16.285 13.149-22.441 5.734-6.171 12.807-10.957 21.021-14.225 8.163-3.246 17.539-4.892 27.871-4.892 14.024 0 26.269 2.904 36.395 8.631 10.186 5.764 18.003 14.068 23.235 24.687 5.177 10.51 7.802 22.986 7.802 37.082 0 20.268-5.297 36.813-15.753 49.233a151.194 151.194 0 0 0 10.25 6.035c4.859 2.619 8.038 4.691 9.718 6.336 1.976 1.939 2.977 4.625 2.977 7.984 0 2.536-1.108 5.026-3.294 7.399-2.243 2.429-5.007 3.66-8.217 3.66z m-30.354-21.808l1.202 0.863c4.605 3.307 8.91 6.247 12.796 8.738 3.809 2.443 7.154 4.323 9.941 5.587 2.578 1.169 4.736 1.762 6.415 1.762 1.849 0 3.324-0.666 4.643-2.095 1.333-1.447 2.009-2.829 2.009-4.107 0-2.035-0.497-3.512-1.52-4.516-0.913-0.895-3.152-2.581-8.622-5.529-4.671-2.517-9.038-5.146-12.977-7.814l-2.342-1.586 1.922-2.075c10.846-11.707 16.346-27.88 16.346-48.068 0-13.345-2.457-25.099-7.302-34.936-4.793-9.726-11.949-17.331-21.27-22.604-9.387-5.31-20.827-8.002-34.003-8.002-9.714 0-18.487 1.53-26.075 4.548-7.539 2.999-14.018 7.379-19.257 13.018-5.257 5.656-9.333 12.626-12.115 20.715-2.806 8.154-4.229 17.267-4.229 27.082 0 9.645 1.365 18.675 4.059 26.841 2.669 8.093 6.69 15.169 11.953 21.031 5.237 5.836 11.816 10.372 19.553 13.484 7.795 3.135 16.762 4.725 26.651 4.725 12.198 0 22.595-2.149 30.903-6.388l1.319-0.674z m-32.402-9.3c-11.477 0-21.109-4.412-28.63-13.113-7.432-8.596-11.2-20.912-11.2-36.606 0-7.646 0.991-14.654 2.945-20.828 1.978-6.247 4.736-11.477 8.198-15.541 3.489-4.098 7.712-7.264 12.552-9.411 4.816-2.137 10.124-3.221 15.775-3.221 7.919 0 15.053 1.955 21.205 5.811 6.175 3.872 10.981 9.635 14.283 17.126 3.239 7.353 4.882 16.122 4.882 26.064 0 7.875-0.928 14.918-2.757 20.936-1.861 6.118-4.795 11.5-8.721 15.995l-1.444 1.654-1.791-1.271c-15.383-10.925-22.638-13.218-26.016-13.218-1.177 0-2.257 0.467-3.3 1.427-0.998 0.919-1.463 1.865-1.463 2.978 0 1.325 0.414 2.217 1.34 2.894 1.44 1.054 4.24 2.614 8.324 4.641 4.339 2.156 8.018 4.351 10.935 6.521l3.49 2.598-4.043 1.607c-4.94 1.962-9.84 2.957-14.564 2.957z m-0.359-93.864c-4.969 0-9.613 0.943-13.805 2.803-4.169 1.851-7.811 4.583-10.824 8.121-3.04 3.568-5.484 8.231-7.266 13.858-1.804 5.698-2.719 12.213-2.719 19.361 0 14.494 3.371 25.741 10.018 33.43 6.649 7.693 14.812 11.433 24.955 11.433 2.662 0 5.403-0.37 8.191-1.103a82.858 82.858 0 0 0-6.17-3.375c-4.391-2.179-7.345-3.837-9.03-5.069-2.179-1.59-3.332-3.947-3.332-6.815 0-2.496 1.02-4.7 3.031-6.552 1.955-1.798 4.172-2.71 6.59-2.71 5.743 0 14.578 4.194 26.975 12.812 2.786-3.618 4.918-7.822 6.35-12.529 1.69-5.558 2.547-12.126 2.547-19.521 0-9.265-1.503-17.375-4.469-24.105-2.903-6.586-7.082-11.623-12.419-14.97-5.364-3.364-11.631-5.069-18.623-5.069z" fill="#ED8F27"></path><path d="M624.43 637.357l-33.173-14.077 87.555-206.489 86.981 206.536-33.222 13.983-53.876-127.944z" fill="#B12800"></path><path d="M632.618 552.594h88.915v36.036h-88.915z" fill="#B12800"></path></g></svg>
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
                                        <div class="section-number-">
                                            <!-- 2 -->
                                            <!-- <svg width="35px" height="35px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 459.997 459.997" xml:space="preserve" width="64px" height="64px" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="XMLID_782_"> <path id="XMLID_783_" style="fill:#FC5A37;" d="M392.639,67.366c-89.821-89.821-235.448-89.821-325.269,0 s-89.821,235.448,0,325.269c23.99,23.99,51.963,41.567,81.788,52.742l298.896-288.654 C437.108,124.067,418.647,93.375,392.639,67.366z"></path> <path id="XMLID_37_" style="fill:#DB3916;" d="M66.337,362.556l82.822,82.822c81.844,30.665,177.65,13.088,243.481-52.742 c63.812-63.812,82.273-155.788,55.416-235.912l-44.102-44.102L66.337,362.556z"></path> <polygon id="XMLID_36_" style="fill:#FFAE46;" points="253.72,319.423 419.183,139.817 403.953,112.621 211.293,291.138 "></polygon> <polygon id="XMLID_35_" style="fill:#FFFFFF;" points="168.867,248.712 347.384,56.053 320.188,40.822 140.583,206.285 "></polygon> <rect id="XMLID_34_" x="151.648" y="137.131" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -42.3972 251.9045)" style="fill:#FFE278;" width="262.458" height="79.999"></rect> <polygon id="XMLID_33_" style="fill:#FFE278;" points="128.562,362.556 142.704,348.414 111.591,317.301 66.337,362.556 "></polygon> <path id="XMLID_32_" style="fill:#1D54BD;" d="M122.905,223.963c8.432,32.147-0.075,67.957-25.456,93.338l45.255,45.255 c25.381-25.381,61.191-33.887,93.338-25.456l-49.497-63.64L122.905,223.963z"></path> <rect id="XMLID_3_" x="108.313" y="259.189" transform="matrix(-0.7071 -0.7071 0.7071 -0.7071 129.3561 596.9596)" style="fill:#12398F;" width="159.998" height="25"></rect> </g> </g></svg> -->
                                            <!-- <svg width="35px" height="35px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M877.387 523.945c-1.663 198.958-163.571 360.868-362.532 362.531-198.991 1.661-360.885-166.07-362.526-362.531-0.697-83.354-130.015-83.42-129.318 0 1.064 127.401 49.851 247.752 136.97 340.531 86.427 92.047 208.144 143.457 333.116 150.77 127.267 7.454 251.374-40.885 347.279-122.774 96.086-82.04 150.659-201.304 164.166-325.296 1.565-14.352 2.04-28.805 2.16-43.23 0.697-83.421-128.618-83.355-129.315-0.001z" fill="#4A5699"></path><path d="M152.329 500.646c1.662-198.965 163.563-360.875 362.526-362.537 83.354-0.697 83.419-130.013 0-129.317-129.524 1.081-252.396 51.567-345.385 141.68C75.465 241.564 24.097 370.538 23.011 500.646c-0.697 83.421 128.62 83.349 129.318 0z" fill="#C45FA0"></path><path d="M400.998 617.112c-54.167-72.265-46.168-154.096 21.221-212.268 63.03-54.412 156.255-33.802 209.578 32.46 22.13 27.497 68.54 22.901 91.441 0 26.914-26.917 22.073-64.009 0-91.44-89.215-110.859-259.653-132.629-373.618-47.204-118.817 89.062-151.202 262.422-60.284 383.718 21.095 28.142 55.432 42.548 88.465 23.196 27.799-16.282 44.387-60.192 23.197-88.462z" fill="#E5594F"></path><path d="M628.723 433.281c30.673 40.924 38.604 71.548 34.179 119.265 0.715-5.845 0.408-4.79-0.924 3.173-1.3 6.769-3.259 13.386-5.207 19.983-4.113 13.896-2.982 9.9-9.75 22.736-11.978 22.716-23.474 34.203-45.271 51.746-27.499 22.131-22.904 68.538 0 91.441 26.914 26.913 64.011 22.075 91.439 0 110.85-89.224 132.613-259.649 47.193-373.614-21.092-28.142-55.431-42.546-88.466-23.196-27.799 16.287-44.384 60.193-23.193 88.466z" fill="#F39A2B"></path></g></svg> -->
                                            <svg width="35px" height="35px" viewBox="0 0 32 32" data-name="Layer 1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16,29a1.5,1.5,0,0,1-1.5-1.5v-2a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,16,29Z" fill="#ffba00"></path><path d="M4.5,18.5A1.5,1.5,0,0,1,3,17V15a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,4.5,18.5Z" fill="#0066da"></path><path d="M27.5,18.5A1.5,1.5,0,0,1,26,17V15a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,27.5,18.5Z" fill="#4285f4"></path><path d="M16,8a1.5,1.5,0,0,1-1.5-1.5v-2a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,16,8Z" fill="#ffba00"></path><path d="M10.25,24.5A1.5,1.5,0,0,1,8.75,23V21a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,10.25,24.5Z" fill="#ea4435"></path><path d="M10.25,17a1.5,1.5,0,0,1-1.5-1.5v-6a1.5,1.5,0,0,1,3,0v6A1.5,1.5,0,0,1,10.25,17Z" fill="#ea4435"></path><path d="M16,22a1.5,1.5,0,0,1-1.5-1.5v-9a1.5,1.5,0,0,1,3,0v9A1.5,1.5,0,0,1,16,22Z" fill="#ffba00"></path><path d="M21.75,12.75a1.5,1.5,0,0,1-1.5-1.5v-2a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,21.75,12.75Z" fill="#00ac47"></path><path d="M21.75,24.25a1.5,1.5,0,0,1-1.5-1.5v-6a1.5,1.5,0,0,1,3,0v6A1.5,1.5,0,0,1,21.75,24.25Z" fill="#00ac47"></path></g></svg>
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
                                        <div class="section-number-">
                                            <!-- 3 -->
                                            <!-- <svg width="35px" height="35px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M510.5 958.5c247.2 0 447.5-200.4 447.5-447.5S757.7 63.5 510.5 63.5 63 263.8 63 511s200.4 447.5 447.5 447.5z" fill="#050505"></path><path d="M510.5 902.6c-216.3 0-391.6-175.3-391.6-391.6S294.2 119.4 510.5 119.4s391.6 175.3 391.6 391.6-175.3 391.6-391.6 391.6z" fill="#805af5"></path><path d="M405.8 558.9h-2c-31 0-43-21.4-27-47.8L524 269.2c33.5-55.1 44.2-50.2 24 11l-45.1 136.1c-9.7 29.4 7.5 52.9 38.4 52.9H628l-0.4 0.4h2c31 0 43 21.4 27 47.8L515.7 749c-36.9 60.7-48.8 55.3-26.4-12.3l41.3-124.5c9.7-29.4-7.5-52.9-38.4-52.9h-86.7l0.3-0.4z" fill="#050505"></path></g></svg> -->
                                            <svg height="35px" width="35px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-66.17 -66.17 573.45 573.45" xml:space="preserve" fill="#ffffff" transform="rotate(180)matrix(1, 0, 0, 1, 0, 0)" stroke="#ffffff" stroke-width="2.20554"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="10.586592"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#D60949;" d="M441.108,417.477c0,13.044-10.587,23.631-23.631,23.631H23.631C10.587,441.108,0,430.521,0,417.477 V23.631C0,10.571,10.587,0,23.631,0h393.846c13.044,0,23.631,10.571,23.631,23.631V417.477z"></path> <path style="fill:#B70243;" d="M0,23.631C0,10.571,10.587,0,23.631,0h393.846c13.044,0,23.631,10.571,23.631,23.631v393.846 c0,13.044-10.587,23.631-23.631,23.631"></path> <polygon style="fill:#FFD31A;" points="314.415,99.769 230.4,99.769 126.692,252.062 187.479,252.062 126.692,341.323 210.708,341.323 314.415,189.046 253.629,189.046 "></polygon> <polygon style="fill:#FF9E1D;" points="230.4,99.769 167.904,191.535 254.054,277.677 314.415,189.046 253.629,189.046 314.415,99.769 "></polygon> </g></svg>
                                        </div>
                                        <h6 class="title">Strengths Snapshot</h6>
                                    </div>
                                    <div class="section-content">
                                        <ul class="evaluation-list- -strengths-list strength-snapshot-list">
                                            @foreach($question->strength_snapshot as $snapshot)
                                            <li>
                                                <svg width="30px" height="30px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <defs> <path id="check-a" d="M4.29289322,0.292893219 C4.68341751,-0.0976310729 5.31658249,-0.0976310729 5.70710678,0.292893219 C6.09763107,0.683417511 6.09763107,1.31658249 5.70710678,1.70710678 L1.90917969,5.46118164 C1.5186554,5.85170593 0.885490417,5.85170593 0.494966125,5.46118164 C0.104441833,5.07065735 0.104441833,4.43749237 0.494966125,4.04696808 L4.29289322,0.292893219 Z"></path> <path id="check-c" d="M10.7071068,13.2928932 C11.0976311,13.6834175 11.0976311,14.3165825 10.7071068,14.7071068 C10.3165825,15.0976311 9.68341751,15.0976311 9.29289322,14.7071068 L0.292893219,5.70710678 C-0.0976310729,5.31658249 -0.0976310729,4.68341751 0.292893219,4.29289322 L4.29289322,0.292893219 C4.68341751,-0.0976310729 5.31658249,-0.0976310729 5.70710678,0.292893219 C6.09763107,0.683417511 6.09763107,1.31658249 5.70710678,1.70710678 L2.41421356,5 L10.7071068,13.2928932 Z"></path> </defs> <g fill="none" fill-rule="evenodd" transform="rotate(-90 11 7)"> <g transform="translate(1 1)"> <mask id="check-b" fill="#ffffff"> <use xlink:href="#check-a"></use> </mask> <use fill="#D8D8D8" fill-rule="nonzero" xlink:href="#check-a"></use> <g fill="#FFA0A0" mask="url(#check-b)"> <rect width="24" height="24" transform="translate(-7 -5)"></rect> </g> </g> <mask id="check-d" fill="#ffffff"> <use xlink:href="#check-c"></use> </mask> <use fill="#000000" fill-rule="nonzero" xlink:href="#check-c"></use> <g fill="#7600FF" mask="url(#check-d)"> <rect width="24" height="24" transform="translate(-6 -4)"></rect> </g> </g> </g></svg>
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
                                        <div class="section-number-">
                                            <!-- 5 -->
                                            <!-- <svg width="27px" height="27px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" width="64px" height="64px" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <polygon style="fill:#B5E45F;" points="512,159.485 512,126.093 434.863,126.093 434.863,77.137 385.907,77.137 385.907,0 352.515,0 352.515,77.137 310.432,77.137 310.432,0 277.041,0 277.041,77.137 234.959,77.137 234.959,0 201.568,0 201.568,77.137 159.485,77.137 159.485,0 126.093,0 126.093,77.137 77.137,77.137 77.137,126.093 0,126.093 0,159.485 77.137,159.485 77.137,201.568 0,201.568 0,234.959 77.137,234.959 77.137,277.041 0,277.041 0,310.432 77.137,310.432 77.137,352.515 0,352.515 0,385.907 77.137,385.907 77.137,434.863 126.093,434.863 126.093,512 159.485,512 159.485,434.863 201.568,434.863 201.568,512 234.959,512 234.959,434.863 277.041,434.863 277.041,512 310.432,512 310.432,434.863 352.515,434.863 352.515,512 385.907,512 385.907,434.863 434.863,434.863 434.863,385.907 512,385.907 512,352.515 434.863,352.515 434.863,310.432 512,310.432 512,277.041 434.863,277.041 434.863,234.959 512,234.959 512,201.568 434.863,201.568 434.863,159.485 "></polygon> <g> <polygon style="fill:#7DBB4E;" points="512,159.485 512,126.093 434.863,126.093 434.863,77.137 385.907,77.137 385.907,0 352.515,0 352.515,77.137 310.432,77.137 310.432,0 277.041,0 277.041,77.137 256,77.137 256,434.863 277.041,434.863 277.041,512 310.432,512 310.432,434.863 352.515,434.863 352.515,512 385.907,512 385.907,434.863 434.863,434.863 434.863,385.907 512,385.907 512,352.515 434.863,352.515 434.863,310.432 512,310.432 512,277.041 434.863,277.041 434.863,234.959 512,234.959 512,201.568 434.863,201.568 434.863,159.485 "></polygon> <rect x="110.525" y="110.525" style="fill:#7DBB4E;" width="290.938" height="290.938"></rect> </g> <rect x="256" y="110.525" style="fill:#588D3F;" width="145.475" height="290.938"></rect> <path style="fill:#EEBF70;" d="M342.486,256.072c6.115-6.477,9.87-15.204,9.87-24.814c0-18.792-14.335-34.225-32.664-35.987 c0.292-1.011,0.545-3.572,0.545-9.452c0-17.739-14.381-32.119-32.119-32.119s-32.119,14.381-32.119,32.119 c0-17.739-14.381-32.119-32.119-32.119s-32.119,14.381-32.119,32.119c0,5.88,0.255,8.441,0.545,9.452 c-18.33,1.762-32.664,17.195-32.664,35.987c0,9.61,3.755,18.337,9.87,24.814l-0.08-0.073c-6.072,6.469-9.79,15.172-9.79,24.744 c0,19.079,14.778,34.697,33.509,36.057l-0.002,0.01c-0.903,2.965-1.389,6.112-1.389,9.372c0,17.739,14.381,32.119,32.119,32.119 s32.119-14.381,32.119-32.119c0,17.739,14.381,32.119,32.119,32.119s32.119-14.381,32.119-32.119c0-3.26-0.486-6.407-1.389-9.372 l-0.002-0.01c18.731-1.361,33.509-16.978,33.509-36.057c0-9.572-3.719-18.275-9.79-24.744L342.486,256.072z"></path> <path style="fill:#E79C25;" d="M342.486,256.072c6.115-6.477,9.87-15.204,9.87-24.814c0-19.081-14.778-34.711-33.513-36.069 c0,0,1.394,4.399,1.394-9.371c0-17.739-14.381-32.119-32.119-32.119s-32.119,14.381-32.119,32.119v140.364 c0,17.739,14.381,32.119,32.119,32.119c17.739,0,32.119-14.381,32.119-32.119c0-3.26-0.486-6.407-1.389-9.372l-0.002-0.01 c18.731-1.361,33.509-16.978,33.509-36.057c0-9.572-3.719-18.275-9.79-24.744L342.486,256.072z"></path> <path style="fill:#F3D49D;" d="M369.052,231.258c0-21.634-13.254-40.546-32.236-48.652c-1.662-25.423-22.862-45.601-48.698-45.601 c-12.291,0-23.527,4.577-32.118,12.102c-8.592-7.525-19.827-12.102-32.118-12.102c-25.836,0-47.036,20.178-48.698,45.601 c-18.982,8.106-32.236,27.018-32.236,48.652c0,8.929,2.234,17.342,6.158,24.725c-4.013,7.555-6.158,16.019-6.158,24.76 c0,21.835,13.308,40.617,32.237,48.669c1.67,25.415,22.866,45.585,48.697,45.585c12.291,0,23.528-4.576,32.118-12.102 c8.592,7.525,19.827,12.102,32.118,12.102c25.83,0,47.026-20.169,48.697-45.585c18.93-8.052,32.237-26.834,32.237-48.669 c0-8.741-2.146-17.204-6.158-24.76C366.818,248.599,369.052,240.186,369.052,231.258z M223.882,341.605 c-6.527,0-12.107-4.082-14.355-9.822c9.716-2.618,18.6-7.979,25.469-15.564l-24.75-22.416c-3.741,4.132-8.869,6.407-14.436,6.407 c-10.736,0-19.469-8.734-19.469-19.469c0-0.117,0.014-0.233,0.017-0.349c6.026,2.394,12.585,3.725,19.453,3.725v-33.391 c-10.736,0-19.469-8.734-19.469-19.469c0-6.647,3.405-12.582,8.583-16.105c5.473,7.279,12.966,13.059,21.817,16.38l11.728-31.264 c-5.987-2.246-10.008-8.053-10.008-14.45c0-8.505,6.92-15.423,15.423-15.423c8.504,0,15.421,6.92,15.421,15.423v140.364 C239.304,334.687,232.386,341.605,223.882,341.605z M288.118,341.605c-8.505,0-15.422-6.919-15.422-15.422V185.818 c0-8.505,6.919-15.423,15.422-15.423s15.423,6.919,15.423,15.423c0,6.398-4.021,12.205-10.008,14.45l11.728,31.264 c8.851-3.32,16.344-9.1,21.817-16.38c5.178,3.523,8.583,9.458,8.583,16.105c0,10.735-8.734,19.469-19.469,19.469v33.391 c6.869,0,13.428-1.331,19.454-3.725c0.002,0.117,0.017,0.232,0.017,0.349c0,10.735-8.734,19.469-19.469,19.469 c-5.567,0-10.694-2.275-14.436-6.407l-24.75,22.416c6.869,7.583,15.753,12.946,25.469,15.564 C300.226,337.523,294.645,341.605,288.118,341.605z"></path> <path style="fill:#EEBF70;" d="M369.052,231.258c0-21.634-13.254-40.546-32.236-48.652c-1.662-25.423-22.862-45.601-48.698-45.601 c-12.291,0-23.527,4.577-32.118,12.102c0,31.269,0,186.687,0,213.789c8.592,7.525,19.827,12.102,32.118,12.102 c25.83,0,47.026-20.169,48.697-45.585c18.93-8.052,32.237-26.834,32.237-48.669c0-8.741-2.146-17.204-6.158-24.76 C366.818,248.599,369.052,240.186,369.052,231.258z M288.118,341.605c-8.505,0-15.422-6.919-15.422-15.422V185.818 c0-8.505,6.919-15.423,15.422-15.423s15.423,6.919,15.423,15.423c0,6.398-4.021,12.205-10.008,14.45l11.728,31.264 c8.851-3.32,16.344-9.1,21.817-16.38c5.178,3.523,8.583,9.458,8.583,16.105c0,10.735-8.734,19.469-19.469,19.469v33.391 c6.869,0,13.428-1.331,19.454-3.725c0.002,0.117,0.017,0.232,0.017,0.349c0,10.735-8.734,19.469-19.469,19.469 c-5.567,0-10.694-2.275-14.436-6.407l-24.75,22.416c6.869,7.583,15.753,12.946,25.469,15.564 C300.226,337.523,294.645,341.605,288.118,341.605z"></path> </g></svg> -->
                                            <!-- <svg width="30px" height="30px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M38.31021 15.962588h946.58145c12.77007 0 22.347623 10.375682 22.347623 22.347622v946.58145c0 12.77007-10.375682 22.347623-22.347623 22.347623H38.31021c-12.77007 0-22.347623-10.375682-22.347622-22.347623V38.31021C15.962588 26.33827 26.33827 15.962588 38.31021 15.962588z" fill="#7CB0F1"></path><path d="M984.89166 1024H38.31021c-21.549493 0-38.31021-17.558846-38.31021-38.31021V38.31021C0 17.558846 17.558846 0 38.31021 0h946.58145c21.549493 0 38.31021 17.558846 38.310211 38.31021v946.58145c0.798129 21.549493-16.760717 39.10834-38.310211 39.10834zM38.31021 31.925175c-3.192518 0-6.385035 3.192518-6.385035 6.385035v946.58145c0 3.990647 3.192518 6.385035 6.385035 6.385035h946.58145c3.990647 0 6.385035-3.192518 6.385035-6.385035V38.31021c0-3.990647-3.192518-6.385035-6.385035-6.385035H38.31021z" fill="#131313"></path><path d="M79.812938 77.41855h865.970382v865.970382H79.812938z" fill="#585555"></path><path d="M945.78332 960.149649H79.812938c-8.779423 0-15.962588-7.183164-15.962587-15.962587V77.41855c0-8.779423 7.183164-15.962588 15.962587-15.962587h865.970382c8.779423 0 15.962588 7.183164 15.962588 15.962587v865.970382c0 9.577553-7.183164 16.760717-15.962588 16.760717z m-850.007794-31.925175h834.045207V93.381138H95.775526v834.843336z" fill="#131313"></path><path d="M547.516758 247.420109h-10.375682v240.236945h241.035074V478.877631c0.798129-127.700701-102.958691-231.457521-230.659392-231.457522z" fill="#FB7E7E"></path><path d="M778.974279 503.619641H537.939205c-8.779423 0-15.962588-7.183164-15.962588-15.962587V247.420109c0-8.779423 7.183164-15.962588 15.962588-15.962588h10.375682c136.480125 0 247.420109 111.738114 246.62198 248.218239v8.779423c0 7.981294-7.183164 15.164458-15.962588 15.164458z m-225.072486-31.925175h209.109898c-3.990647-113.334373-95.775526-205.119252-209.109898-208.311769v208.311769z" fill="#131313"></path><path d="M484.464536 273.758379C341.599376 280.143414 231.457521 400.660951 237.842557 542.727981c2.394388 63.052221 28.732658 123.710055 72.629773 168.4053l173.992206-173.992205v-263.382697z" fill="#7CB0F1"></path><path d="M310.47233 727.893998c-3.990647 0-8.779423-1.596259-11.173811-4.788776-47.089634-47.887763-74.226033-111.738114-77.41855-179.579111-6.385035-150.846454 110.939984-279.345284 261.786438-285.73032 4.788776 0 8.779423 1.596259 11.971941 4.788776 3.192518 3.192518 4.788776 7.183164 4.788776 11.173812v264.180826c0 3.990647-1.596259 7.981294-4.788776 11.173811L321.646142 723.105222c-2.394388 3.192518-6.385035 4.788776-11.173812 4.788776z m158.029619-436.576773C343.195635 305.683554 248.218239 414.22915 253.805144 541.929852c2.394388 54.272798 22.347623 105.353079 57.465316 146.057677l157.231489-157.231488v-239.438816z" fill="#131313"></path><path d="M495.638348 790.14809c138.874513 0 252.208885-110.141855 257.795791-248.218238H484.464536v-3.192518L310.47233 711.931411C359.158223 761.415433 425.402962 790.14809 495.638348 790.14809z" fill="#FFD28B"></path><path d="M495.638348 806.110678c-73.427903 0-145.259548-30.328917-196.339829-83.005456-6.385035-6.385035-5.586906-15.962588 0-22.347623L473.290725 526.765394c4.788776-4.788776 11.173811-5.586906 17.558846-3.192518 1.596259 0.798129 2.394388 1.596259 3.990647 2.394388h259.39205c3.990647 0 8.779423 1.596259 11.173812 4.788777s4.788776 7.183164 4.788776 11.97194c-6.385035 147.653936-126.902572 263.382697-274.556508 263.382697zM333.618083 711.133281c43.897116 39.906469 102.160561 62.254092 162.020265 63.052222 125.306313 0 227.466875-94.179267 241.035074-216.293063H487.657054L333.618083 711.133281z" fill="#131313"></path><path d="M331.223694 197.137958H178.780982c-8.779423 0-15.962588-7.183164-15.962588-15.962588s7.183164-15.962588 15.962588-15.962587h152.442712c8.779423 0 15.962588 7.183164 15.962588 15.962587s-7.183164 15.962588-15.962588 15.962588z" fill="#131313"></path><path d="M331.223694 263.382697H214.696804c-8.779423 0-15.962588-7.183164-15.962587-15.962588s7.183164-15.962588 15.962587-15.962588h116.52689c8.779423 0 15.962588 7.183164 15.962588 15.962588s-7.183164 15.962588-15.962588 15.962588z" fill="#131313"></path><path d="M844.420889 806.110678H682.400624c-8.779423 0-15.962588-7.183164-15.962588-15.962588s7.183164-15.962588 15.962588-15.962587h162.020265c8.779423 0 15.962588 7.183164 15.962587 15.962587s-7.183164 15.962588-15.962587 15.962588z" fill="#131313"></path><path d="M814.091972 868.36477H682.400624c-8.779423 0-15.962588-7.183164-15.962588-15.962588s7.183164-15.962588 15.962588-15.962587H814.091972c8.779423 0 15.962588 7.183164 15.962588 15.962587s-7.183164 15.962588-15.962588 15.962588z" fill="#131313"></path><path d="M856.392829 197.137958H682.400624c-8.779423 0-15.962588-7.183164-15.962588-15.962588s7.183164-15.962588 15.962588-15.962587h173.992205c8.779423 0 15.962588 7.183164 15.962588 15.962587s-7.183164 15.962588-15.962588 15.962588z" fill="#131313"></path></g></svg> -->
                                            <svg width="35px" height="35px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <style>
                                                        .cls-1{fill:#4285F4;}
                                                        .cls-2{fill:#EA4335;}
                                                        .cls-3{fill:#FBBC05;}
                                                        .cls-4{fill:#34A853;}
                                                        .cls-5{fill:#AECBFA;}
                                                        .cls-1,.cls-2,.cls-3,.cls-4,.cls-5{fill-rule:evenodd;}
                                                    </style>
                                                </defs>
                                                <g data-name="Product Icons">
                                                    <g>
                                                        <polygon class="cls-1" points="14.68 13.06 19.23 15.69 19.23 16.68 14.29 13.83 14.68 13.06"></polygon>
                                                        <polygon class="cls-1" points="12.48 12.3 12.48 16.89 16.34 14.6 16.34 10.01 12.48 12.3"></polygon>
                                                        
                                                        <polygon class="cls-2" points="9.98 13.65 4.77 16.66 4.45 15.86 9.53 12.92 9.98 13.65"></polygon>
                                                        
                                                        <rect class="cls-3" x="11.55" y="3.29" width="0.86" height="5.78"></rect>
                                                        
                                                        <path class="cls-4" d="M3.25,7V17L12,22l8.74-5V7L12,2Zm15.63,8.89L12,19.78,5.12,15.89V8.11L12,4.22l6.87,3.89v7.78Z"></path>
                                                        <polygon class="cls-4" points="11.98 11.5 15.96 9.21 11.98 6.91 8.01 9.21 11.98 11.5"></polygon>
                                                        
                                                        <polygon class="cls-5" points="11.52 12.3 7.66 10.01 7.66 14.6 11.52 16.89 11.52 12.3"></polygon>
                                                    </g>
                                                </g>
                                            </svg>
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
                                                        <!-- {{ $j }} -->
                                                        <!-- <svg width="30px" height="30px" viewBox="-13 0 282 282" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M133.941895,168.587659 L133.941895,250.817554 C137.427235,250.20232 140.782749,248.999528 143.865263,247.260501 L211.907368,208.139659 C221.878434,202.389286 228.027786,191.759507 228.042105,180.249133 L228.042105,102.229764 C228.042105,99.0634484 227.516632,95.9914484 226.607158,93.0474484 L152.656842,135.711869 C137.451789,146.463869 134.164211,156.643238 133.948632,168.587659" fill="#FFC600"> </path> <path d="M253.594947,77.4718695 L226.607158,93.0474484 C227.516632,95.9847116 228.035368,99.0634484 228.035368,102.216291 L228.035368,180.255869 C228.035368,191.728712 221.857684,202.42008 211.907368,208.146396 L143.865263,247.260501 C140.784936,249.00045 137.431861,250.205461 133.948632,250.824291 L133.948632,281.881133 C138.759872,281.18921 143.398659,279.601054 147.624421,277.199027 L235.984842,226.389764 C248.308584,219.274673 255.909547,206.13407 255.932632,191.903869 L255.932632,90.5682905 C255.915818,86.1005511 255.124888,81.6695189 253.594947,77.4718695" fill="#F6EB61"> </path> <path d="M127.744,142.745133 C131.765895,136.176712 137.761684,130.511027 146.378105,125.087869 L220.820211,82.1337642 C218.369752,78.9927133 215.345258,76.3454238 211.907368,74.332501 L143.865263,35.2183958 C133.917746,29.5190028 121.693468,29.5241315 111.750737,35.2318695 L43.9915789,74.3257642 C40.4210526,76.380501 37.4298947,79.1493431 34.9642105,82.3021852 L109.056,125.054185 C117.719579,130.511027 123.722105,136.176712 127.744,142.745133" fill="#439879"> </path> <path d="M43.9915789,74.3257642 L111.750737,35.2318695 C121.692271,29.5220445 133.91655,29.5143515 143.865263,35.2116589 L211.907368,74.3392379 C215.410526,76.3535537 218.374737,79.0550274 220.813474,82.1337642 L247.760842,66.5918695 C244.592282,62.3207216 240.582256,58.7440257 235.978105,56.0823958 L147.617684,5.27313262 C135.315731,-1.76731796 120.203123,-1.75706169 107.910737,5.30007998 L19.9073684,56.0689221 C15.2612482,58.786244 11.2195241,62.4244835 8.03031579,66.7602905 L34.9574737,82.2954484 C37.425966,79.0811451 40.4910257,76.3729132 43.9848421,74.3190274" fill="#28CDFB"> </path> <path d="M111.750737,247.240291 L43.9915789,208.146396 C34.0417992,202.392296 27.9074983,191.776619 27.8905263,180.282817 L27.8905263,102.19608 C27.8905263,99.12408 28.3957895,96.1329221 29.2446316,93.2630274 L2.24336842,77.6807116 C0.777410831,81.8062005 0.0189490093,86.1497041 0,90.5278695 L0,191.951027 C0.0212057474,206.162352 7.60552841,219.287978 19.9073684,226.403238 L107.904,277.178817 C112.080842,279.577133 116.661895,281.119869 121.539368,281.867659 L121.539368,250.790606 C118.100612,250.163993 114.791639,248.963835 111.750737,247.240291" fill="#FDD757"> </path> <path d="M102.716632,135.631027 L29.2446316,93.2562905 C28.3957895,96.1261852 27.8972632,99.1173431 27.8972632,102.189343 L27.8972632,180.27608 C27.8972632,191.742185 34.0682105,202.42008 43.9983158,208.139659 L111.744,247.240291 C114.822737,249.005343 118.137263,250.137133 121.532632,250.777133 L121.532632,168.567448 C121.317053,156.643238 118.036211,146.463869 102.709895,135.631027" fill="#EC8B00"> </path> </g> </g></svg> -->
                                                        <svg width="30px" height="30px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M502.922 790.669c-152.755-1.391-276.788-125.42-278.177-278.177-0.661-72.618 29.297-142.754 79.451-194.66 52.395-54.221 124.439-82.84 198.726-83.516 71.011-0.646 71.074-110.824 0-110.177-212.832 1.937-386.417 175.518-388.354 388.353-1.937 212.854 178.438 386.443 388.354 388.354 71.073 0.644 71.011-109.531 0-110.177z" fill="#4C5AA3"></path><path d="M521.098 234.316c152.756 1.39 276.79 125.42 278.18 278.176 0.662 72.62-29.297 142.755-79.453 194.658-52.394 54.224-124.439 82.843-198.727 83.519-71.012 0.646-71.074 110.821 0 110.177 212.834-1.937 386.42-175.52 388.357-388.354 1.936-212.856-178.442-386.441-388.357-388.353-71.074-0.647-71.012 109.532 0 110.177z" fill="#D860B5"></path><path d="M410.657 510.563c-0.041-57.184 42.743-103.075 99.009-105.283 57.153-2.242 103.141 44.402 105.284 99.008 1.178 29.998 24.167 55.089 55.088 55.089 29.14 0 56.268-25.066 55.089-55.089-4.579-116.64-97.827-209.263-215.461-209.184-116.738 0.078-209.264 101.213-209.185 215.459 0.05 71.046 110.226 71.052 110.176 0z" fill="#FD9E22"></path><path d="M613.412 516.021c-1.083 56.13-46.052 101.095-102.18 102.176-56.155 1.084-101.125-47.673-102.175-102.176-1.369-70.956-111.547-71.089-110.177 0 2.258 117.153 95.202 210.093 212.352 212.353 117.147 2.259 210.164-98.607 212.356-212.353 1.371-71.09-108.807-70.956-110.176 0z" fill="#F35A50"></path><path d="M1014.707 512.492c0 22.698-19.031 41.099-42.513 41.099H792.696c-23.479 0-42.514-18.4-42.514-41.099 0-22.696 19.035-41.095 42.514-41.095h179.499c23.481 0 42.512 18.399 42.512 41.095zM273.579 514.308c0 22.696-19.033 41.095-42.517 41.095H51.563c-23.478 0-42.511-18.398-42.511-41.095 0-22.698 19.033-41.099 42.511-41.099h179.499c23.484 0 42.517 18.401 42.517 41.099zM510.838 272.762c-22.693 0-41.094-19.029-41.094-42.513V50.75c0-23.477 18.401-42.51 41.094-42.51 22.7 0 41.1 19.033 41.1 42.51v179.499c0 23.483-18.4 42.515-41.1 42.513zM510.838 1019.117c-22.693 0-41.094-19.031-41.094-42.513v-179.5c0-23.477 18.401-42.513 41.094-42.513 22.7 0 41.1 19.036 41.1 42.513v179.501c0 23.481-18.4 42.512-41.1 42.512z" fill="#F9D73B"></path></g></svg>
                                                    </div>
                                                    <h4>{{ $gap_analysis_priority_fix->gap }}</h4>
                                                </div>
                                                
                                                <div class="analysis-section">
                                                    <div class="section-header">
                                                        <div class="section-dot-" style="">
                                                            <!-- <svg width="25px" height="25px" viewBox="0 0 32 32" data-name="Layer 1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16,29a1.5,1.5,0,0,1-1.5-1.5v-2a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,16,29Z" fill="#ffba00"></path><path d="M4.5,18.5A1.5,1.5,0,0,1,3,17V15a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,4.5,18.5Z" fill="#0066da"></path><path d="M27.5,18.5A1.5,1.5,0,0,1,26,17V15a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,27.5,18.5Z" fill="#4285f4"></path><path d="M16,8a1.5,1.5,0,0,1-1.5-1.5v-2a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,16,8Z" fill="#ffba00"></path><path d="M10.25,24.5A1.5,1.5,0,0,1,8.75,23V21a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,10.25,24.5Z" fill="#ea4435"></path><path d="M10.25,17a1.5,1.5,0,0,1-1.5-1.5v-6a1.5,1.5,0,0,1,3,0v6A1.5,1.5,0,0,1,10.25,17Z" fill="#ea4435"></path><path d="M16,22a1.5,1.5,0,0,1-1.5-1.5v-9a1.5,1.5,0,0,1,3,0v9A1.5,1.5,0,0,1,16,22Z" fill="#ffba00"></path><path d="M21.75,12.75a1.5,1.5,0,0,1-1.5-1.5v-2a1.5,1.5,0,0,1,3,0v2A1.5,1.5,0,0,1,21.75,12.75Z" fill="#00ac47"></path><path d="M21.75,24.25a1.5,1.5,0,0,1-1.5-1.5v-6a1.5,1.5,0,0,1,3,0v6A1.5,1.5,0,0,1,21.75,24.25Z" fill="#00ac47"></path></g></svg> -->
                                                            <!-- <svg width="25px" height="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 392.86 392.86" xml:space="preserve" width="64px" height="64px" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#56ACE0;" d="M21.917,173.964v86.303h93.802v-86.303c0-25.859-21.01-46.933-46.933-46.933 S21.917,148.105,21.917,173.964z"></path> <path style="fill:#56ACE0;" d="M40.406,282.053v88.695h17.519v-52.234c0-6.012,4.848-10.925,10.925-10.925 s10.925,4.848,10.925,10.925v52.234h17.519v-88.695H40.406z"></path> </g> <path style="fill:#FFC10D;" d="M68.85,21.786c-15.063,0-27.281,12.283-27.281,27.281S53.852,76.347,68.85,76.347 s27.281-12.283,27.281-27.281S83.913,21.786,68.85,21.786z"></path> <polygon style="fill:#56ACE0;" points="152.244,49.067 370.878,49.067 370.878,21.786 152.244,21.786 152.244,21.786 "></polygon> <rect x="171.896" y="70.853" style="fill:#FFC10D;" width="179.329" height="179.459"></rect> <g> <path style="fill:#194F82;" d="M381.803,0H152.309c-6.012,0-10.925,4.848-10.925,10.925s4.848,10.925,10.925,10.925h218.505v27.281 H152.309c-6.012,0-10.925,4.848-10.925,10.925c0,6.012,4.848,10.925,10.925,10.925H351.29V250.44H171.896 c-6.012,0-10.925,4.848-10.925,10.925c0,6.012,4.848,10.925,10.925,10.925h79.386l11.507,49.584H155.541 c-6.012,0-10.925,4.849-10.925,10.925c0,6.012,4.848,10.925,10.925,10.925h112.356l9.438,40.663 c1.422,5.883,7.24,9.503,13.059,8.21c5.883-1.422,9.503-7.176,8.21-13.059l-24.889-107.184h88.501 c6.012,0,10.925-4.848,10.925-10.925V70.853h8.663c6.012,0,10.925-4.848,10.925-10.925V10.861C392.664,4.848,387.816,0,381.803,0z"></path> <path style="fill:#194F82;" d="M68.85,105.244c-37.883,0-68.719,30.836-68.719,68.719v97.228c0,6.012,4.848,10.925,10.925,10.925 h7.499v99.62c0,6.012,4.848,10.925,10.925,10.925h78.739c6.012,0,10.925-4.848,10.925-10.925v-99.685h7.499 c6.012,0,10.925-4.848,10.925-10.925v-97.164C137.505,136.081,106.668,105.244,68.85,105.244z M97.23,370.747H79.711v-52.234 c0-6.012-4.848-10.925-10.925-10.925c-6.077,0-10.925,4.848-10.925,10.925v52.234H40.406v-88.695h56.889v88.695H97.23z M115.719,260.267H21.917v-86.303c0-25.859,21.01-46.933,46.933-46.933s46.933,21.01,46.933,46.933v86.303H115.719z"></path> <path style="fill:#194F82;" d="M68.85,98.198c27.022,0,49.131-22.044,49.131-49.131S95.872,0,68.85,0S19.783,22.044,19.783,49.131 S41.763,98.198,68.85,98.198z M68.85,21.786c15.063,0,27.281,12.283,27.281,27.281S83.848,76.347,68.85,76.347 S41.569,64.129,41.569,49.131S53.723,21.786,68.85,21.786z"></path> <path style="fill:#194F82;" d="M202.862,179.588l28.444-20.945l27.41,32.129c5.495,5.495,12.024,4.784,16.097,0.517l48.808-50.295 c4.202-4.331,4.073-11.184-0.259-15.451c-4.331-4.202-11.184-4.073-15.451,0.259l-40.404,41.697l-26.311-30.707 c-3.685-4.331-10.15-5.107-14.739-1.681l-36.655,26.893c-4.848,3.556-5.883,10.343-2.327,15.192 C191.161,182.044,198.014,183.143,202.862,179.588z"></path> </g> </g></svg> -->
                                                            <!-- <svg width="20px" height="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 392.598 392.598" xml:space="preserve" width="64px" height="64px" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect x="92.768" y="207.257" style="fill:#FFC10D;" width="31.806" height="163.556"></rect> <rect x="200.986" y="94.513" style="fill:#FFFFFF;" width="31.806" height="276.299"></rect> <rect x="309.139" y="37.689" style="fill:#56ACE0;" width="31.806" height="333.123"></rect> <path style="fill:#194F82;" d="M381.673,370.812h-18.877V26.764c0-6.012-4.848-10.925-10.925-10.925h-53.657 c-6.012,0-10.925,4.848-10.925,10.925v344.048h-32.711V83.588c0-6.012-4.848-10.925-10.925-10.925h-53.721 c-6.012,0-10.925,4.848-10.925,10.925v287.224h-32.517V196.331c0-6.012-4.848-10.925-10.925-10.925H81.842 c-6.012,0-10.925,4.848-10.925,10.925v174.481H21.786V10.925C21.786,4.913,16.937,0,10.861,0S0,4.913,0,10.925v370.747 c0,6.012,4.848,10.925,10.925,10.925h370.747c6.012,0,10.925-4.848,10.925-10.925C392.533,375.661,387.685,370.812,381.673,370.812z M124.638,370.812H92.832V207.257h31.806V370.812z M232.792,370.812h-31.806V94.513h31.806V370.812z M341.01,370.812h-31.806V37.689 h31.806V370.812z"></path> </g></svg> -->
                                                            <svg width="17px" height="17px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M972.011 899.734H55.013c-25.786 0-46.682 23.455-46.682 52.39v3.743c0 28.935 20.896 52.389 46.682 52.389h916.998c25.787 0 46.684-23.454 46.684-52.389v-3.743c-0.001-28.935-20.897-52.39-46.684-52.39z" fill="#C45FA0"></path><path d="M66.007 15.343h-3.744c-28.934 0-52.389 20.589-52.389 45.994V964.75c0 25.404 23.455 45.993 52.389 45.993h3.744c28.934 0 52.389-20.589 52.389-45.993V61.336c0-25.404-23.455-45.993-52.389-45.993z" fill="#4A5699"></path><path d="M309.615 402.957h-3.743c-28.935 0-52.389 21.033-52.389 46.966v470.815c0 25.941 23.454 46.971 52.389 46.971h3.743c28.936 0 52.39-21.028 52.39-46.971V449.923c-0.001-25.933-23.455-46.966-52.39-46.966z" fill="#F0D043"></path><path d="M571.563 298.496h-3.744c-28.935 0-52.389 21.028-52.389 46.97v575.273c0 25.941 23.454 46.971 52.389 46.971h3.744c28.934 0 52.389-21.028 52.389-46.971V345.465c-0.001-25.942-23.456-46.969-52.389-46.969z" fill="#F39A2B"></path><path d="M833.508 118.95h-3.738c-28.938 0-52.393 21.028-52.393 46.97v754.818c0 25.941 23.453 46.971 52.393 46.971h3.738c28.939 0 52.39-21.028 52.39-46.971V165.92c-0.001-25.941-23.45-46.97-52.39-46.97z" fill="#E5594F"></path></g></svg>
                                                        </div>
                                                        <h5>Impact Analysis</h5>
                                                    </div>
                                                    <p class="section-text ml-10px">{{ $gap_analysis_priority_fix->impact }}</p>
                                                </div>

                                                <div class="analysis-section">
                                                    <div class="section-header">
                                                        <div class="section-dot-" style="">
                                                            <svg width="17px" height="17px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M330.147 727.583l-3.105-2.113c-23.995-16.366-56.736-10.206-73.12 13.753L120.381 934.43c-16.389 23.958-10.22 56.646 13.779 73.002l3.1 2.118c24 16.366 56.741 10.206 73.125-13.752l133.542-195.207c16.388-23.959 10.219-56.642-13.78-73.008z" fill="#E5594F"></path><path d="M457.934 727.583l-3.1-2.113c-23.999-16.366-56.74-10.206-73.129 13.753L248.168 934.43c-16.388 23.958-10.22 56.646 13.775 73.002l3.109 2.118c23.995 16.366 56.736 10.206 73.12-13.752l133.537-195.207c16.394-23.959 10.225-56.642-13.775-73.008z" fill="#F0D043"></path><path d="M895.09 934.213L761.813 740.007c-16.353-23.837-49.03-29.961-72.979-13.689l-3.101 2.108c-23.949 16.28-30.104 48.796-13.748 72.629L805.26 995.261c16.357 23.838 49.031 29.971 72.98 13.686l3.101-2.1c23.95-16.282 30.105-48.797 13.749-72.634z" fill="#E5594F"></path><path d="M767.555 934.213L634.279 740.007c-16.357-23.837-49.031-29.961-72.985-13.689l-3.096 2.108c-23.954 16.28-30.109 48.796-13.752 72.629l133.275 194.206c16.357 23.838 49.03 29.971 72.984 13.686l3.096-2.1c23.955-16.282 30.11-48.797 13.754-72.634z" fill="#F0D043"></path><path d="M712.252 364.688L577.453 338.78l-66.275-120.278-66.28 120.278-134.794 25.908 93.834 100.25-17.037 136.291 124.277-58.327 124.272 58.327-17.037-136.291z" fill="#F39A2B"></path><path d="M803.625 434.496c-1.459 160.596-131.855 290.993-292.452 292.453-76.346 0.693-150.076-30.799-204.647-83.529-56.995-55.073-87.084-130.821-87.796-208.923-0.676-74.35-116.033-74.415-115.355 0 2.034 223.497 184.3 405.775 407.798 407.807 223.519 2.032 405.803-187.375 407.808-407.807 0.675-74.416-114.679-74.351-115.356-0.001z" fill="#4A5699"></path><path d="M218.73 415.399c1.462-160.594 131.845-290.992 292.443-292.455 76.347-0.696 150.079 30.801 204.647 83.531 56.997 55.075 87.093 130.822 87.805 208.923 0.677 74.35 116.031 74.416 115.355 0C916.948 191.905 734.669 9.624 511.173 7.589c-223.518-2.035-405.793 187.38-407.798 407.81-0.678 74.415 114.679 74.35 115.355 0z" fill="#C45FA0"></path></g></svg>
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
                                        <div class="section-number-">
                                            <!-- 6 -->
                                            <svg width="35px" height="35px" viewBox="0 0 32 32" data-name="Layer 1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><circle cx="10.5" cy="11.5" fill="#4285f4" r="6.5"></circle><circle cx="21.5" cy="15" fill="#ea4435" r="3"></circle><circle cx="21.5" cy="24" fill="#fbc02d" r="4"></circle><circle cx="26.5" cy="11" fill="#00ac47" r="1.5"></circle></g></svg>
                                        </div>
                                        <h6 class="title">Model Answer</h6>
                                    </div>
                                    <div class="section-content model-answer-container">
                                        <div class="model-answer-card">
                                            @foreach($question->model_answer as $model_answer)
                                            <div class="model-title-wrapper">
                                                <div class="model-icon">
                                                    <!-- <i class="fas fa-brain"></i> -->
                                                    <svg width="64px" height="64px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#ffffff" transform="matrix(1, 0, 0, -1, 0, 0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M512 960c-92.8 0-160-200-160-448S419.2 64 512 64s160 200 160 448-67.2 448-160 448z m0-32c65.6 0 128-185.6 128-416S577.6 96 512 96s-128 185.6-128 416 62.4 416 128 416z" fill="#c2caff"></path><path d="M124.8 736c-48-80 92.8-238.4 307.2-363.2S852.8 208 899.2 288 806.4 526.4 592 651.2 171.2 816 124.8 736z m27.2-16c33.6 57.6 225.6 17.6 424-97.6S905.6 361.6 872 304 646.4 286.4 448 401.6 118.4 662.4 152 720z" fill="#c2caff"></path><path d="M899.2 736c-46.4 80-254.4 38.4-467.2-84.8S76.8 368 124.8 288s254.4-38.4 467.2 84.8S947.2 656 899.2 736z m-27.2-16c33.6-57.6-97.6-203.2-296-318.4S184 246.4 152 304 249.6 507.2 448 622.4s392 155.2 424 97.6z" fill="#c2caff"></path><path d="M512 592c-44.8 0-80-35.2-80-80s35.2-80 80-80 80 35.2 80 80-35.2 80-80 80zM272 312c-27.2 0-48-20.8-48-48s20.8-48 48-48 48 20.8 48 48-20.8 48-48 48zM416 880c-27.2 0-48-20.8-48-48s20.8-48 48-48 48 20.8 48 48-20.8 48-48 48z m448-432c-27.2 0-48-20.8-48-48s20.8-48 48-48 48 20.8 48 48-20.8 48-48 48z" fill="#8192fd"></path></g></svg>
                                                </div>
                                                <h5 class="model-title">{{ $model_answer->title }}</h5>
                                            </div>
                                            <p class="model-description">{{ $model_answer->description }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="chat-content">
                                <section class="evaluation-section">
                                    <div class="section-header">
                                        <div class="section-number-">
                                            <!-- 7 -->
                                            <svg width="35px" height="35px" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle fill="#F0C419" cx="50" cy="50" r="50"></circle> <clipPath id="a"> <circle cx="50" cy="50" r="50"></circle> </clipPath> <g fill-rule="evenodd" clip-rule="evenodd" clip-path="url(#a)"> <path fill="#FCF062" d="M7.619 21.663L49.999 50 21.689 7.594 7.619 21.663zm84.775.019L78.329 7.607 50 50 .005 40.039 0 59.94 50 50 7.606 78.319l14.065 14.075L50 50.001l-9.958 50.01 19.895.004L50 50.001l28.31 42.406 14.071-14.07L50 50l42.394-28.318zM100 40.061L50 50l49.996 9.962.004-19.901zM40.063-.014L50 49.999 59.958-.01 40.063-.014z"></path> <path fill="#FCF062" stroke="#F29C1F" stroke-width="4" stroke-miterlimit="10" d="M60 93H40c0-7.575-3.487-17.565-7.99-21.324A28.114 28.114 0 0 1 22 50.125C22 34.592 34.536 22 50 22s28 12.592 28 28.125c0 8.667-4.156 16.13-10.04 21.576C63.191 76.47 60 85.466 60 93z"></path> <path fill="#F29C1F" d="M53 95a1 1 0 0 1-1-1V61h-4v33a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V61h-2.5c-3.584 0-6.5-2.916-6.5-6.5s2.916-6.5 6.5-6.5a6.46 6.46 0 0 1 6.446 5.684A.949.949 0 0 1 48 54v3h4v-3c0-.115.02-.226.056-.329A6.46 6.46 0 0 1 58.5 48c3.584 0 6.5 2.916 6.5 6.5S62.084 61 58.5 61H56v33a1 1 0 0 1-1 1h-2zm5.5-38c1.379 0 2.5-1.121 2.5-2.5s-1.121-2.501-2.5-2.501a2.504 2.504 0 0 0-2.459 2.144l-.041.173V57h2.5zm-17-5.001c-1.378 0-2.5 1.122-2.5 2.501s1.122 2.5 2.5 2.5H44v-2.692l-.04-.165a2.505 2.505 0 0 0-2.46-2.144z"></path> <path fill="#E57E25" d="M38 91h24v9H38v-9zm6-27h4v-3h-4v3zm8-3v3h4v-3h-4z"></path> </g> </g></svg>
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
                                                    <!-- <button class="action-button">
                                                        <i class="fas fa-arrow-right"></i> Continue Learning
                                                    </button> -->
                                                </div>
                                            </div>
                                        </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
            // Process all dashboards on the page
        const dashboards = document.querySelectorAll('.dashboard');
        
        dashboards.forEach(dashboard => {
            // Get data attributes for this dashboard
            const score = parseInt(dashboard.getAttribute('data-score'));
            const total = parseInt(dashboard.getAttribute('data-total'));
            const percentage = Math.round((score / total) * 100);
            
            // Get DOM elements within this dashboard
            const emoji = dashboard.querySelector('.emoji-container');
            const scoreValue = dashboard.querySelector('.score-value');
            const progressFill = dashboard.querySelector('.progress-fill');
            const positionIndicator = dashboard.querySelector('.position-indicator');
            const markersContainer = dashboard.querySelector('.markers');
            const messageTitle = dashboard.querySelector('.message-title');
            const messageContent = dashboard.querySelector('.message-content');
            
            // Set score display
            scoreValue.innerHTML = `${score}<span>/${total}</span>`;
            
            // Set progress values
            progressFill.style.setProperty('--progress-percent', `${percentage}%`);
            positionIndicator.style.setProperty('--progress-percent', `${percentage}%`);
            positionIndicator.textContent = `${score}`;
            
            // Create markers dynamically (3-4 markers based on total)
            const markerCount = Math.min(4, total);
            const markerStep = total / (markerCount - 1);
            
            for (let i = 0; i < markerCount; i++) {
                const markerValue = Math.round(i * markerStep);
                const marker = document.createElement('div');
                marker.className = `marker ${markerValue === score ? 'active' : ''}`;
                marker.innerHTML = `
                    <div class="marker-point"></div>
                    <div class="marker-label">${markerValue}</div>
                `;
                markersContainer.appendChild(marker);
            }
            
            // Set emoji and message based on performance
            if (percentage >= 80) {
                emoji.textContent = '🎉';
                messageTitle.textContent = 'Excellent Work!';
                messageContent.textContent = 'You\'re mastering this subject!';
            } else if (percentage >= 50) {
                emoji.textContent = '🎯';
                messageTitle.textContent = 'Good Progress!';
                messageContent.textContent = 'Keep up the good work!';
            } else {
                emoji.textContent = '💪';
                messageTitle.textContent = 'Keep Practicing!';
                messageContent.textContent = 'You\'ll improve with more study!';
            }
            
            // Animate marker points
            const markerPoints = dashboard.querySelectorAll('.marker-point');
            markerPoints.forEach((point, index) => {
                setTimeout(() => {
                    point.style.animation = `pulse 1.5s ease ${index * 0.2}s`;
                }, 500);
            });
        });
    });
</script>
@endsection