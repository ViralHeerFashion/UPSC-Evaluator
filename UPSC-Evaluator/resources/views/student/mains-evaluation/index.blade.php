@extends('student.template.main')
@section('title', 'Evaluate Mains Answer')
@section('style')
<style>
    .content-page, .rbt-static-bar{max-width: 1000px!important;width: 1000px!important;}
    :root {
        --bg-color: #0E0C15;
        --card-color: #18191c;
        --primary-accent: #020202ff;
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
    .score-value {font-size: 1.5rem;font-weight: 700;margin-bottom: 0.25rem;background: linear-gradient(356deg, #a89d9d, var(--secondary-accent));-webkit-background-clip: text;-webkit-text-fill-color: transparent;}
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
    .upload-file-btn, .refresh-btn{width: 100%;height: 55px;background-color: #805af5;border: 2px solid #805af5;color: var(--text-primary);line-height: 22px;padding: 16px 130px 16px 60px;font-size: 20px;}
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
    .dashboard::before {content: '';position: absolute;top: 0;left: 0;right: 0;height: 5px;background: linear-gradient(182deg, var(--primary-accent), var(--secondary-accent));}
    .progress-container {display: flex;align-items: center;justify-content: space-between;gap: 20px;}
    .score-section {display: flex;align-items: center;gap: 15px;}
    .emoji-container {font-size: 40px;animation: bounce 1.5s ease infinite alternate;min-width: 50px;}
    .score-display {display: flex;flex-direction: column;}
    .score-value {font-size: 36px;font-weight: 800;background: linear-gradient(356deg, #a89d9d, var(--secondary-accent));-webkit-background-clip: text;-webkit-text-fill-color: transparent;background-clip: text;line-height: 1;}
    .score-label {font-size: 14px;color: var(--text-secondary);margin-top: 4px;}
    .progress-section {flex: 1;position: relative;padding: 15px 0;}
    .position-indicator {position: absolute;top: 0;left: var(--progress-percent);transform: translateX(-50%);background: rgba(128, 90, 245, 0.2);padding: 5px 15px;border-radius: 20px;font-weight: 600;color: var(--secondary-accent);border: 1px solid var(--primary-accent);font-size: 14px;box-shadow: 0 4px 10px rgba(128, 90, 245, 0.3);animation: fadeIn 1s ease-out;white-space: nowrap;}
    .position-indicator::after {content: '';position: absolute;bottom: -8px;left: 50%;transform: translateX(-50%);border-left: 8px solid transparent;border-right: 8px solid transparent;border-top: 8px solid var(--primary-accent);}
    .progress-bar {height: 8px;background: rgba(255, 255, 255, 0.1);border-radius: 4px;overflow: hidden;margin-top: 25px;position: relative;}
    .progress-fill {height: 100%;width: 0;border-radius: 4px;background: linear-gradient(90deg, #c9baba, var(--secondary-accent));animation: fillProgress 1.5s cubic-bezier(0.22, 1, 0.36, 1) forwards;box-shadow: 0 0 10px rgba(128, 90, 245, 0.5);}
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
    .user-size-pdf-container{display: none;}
    .i-love-pdf{margin-top: 10px;text-align: right;}
    .i-love-pdf a{color: #805af5;}
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
    .section-content{padding-bottom: 0!important;}
    .custom-margin-bottom{margin-bottom: 50px!important;border-bottom: 2px dashed grey;padding-bottom: 25px;}
    .w35{width: 35px!important;}
    .w20{width: 20px!important;}
    .chat-loader-container{display: none;}
    .loader-container {width: 100%;background-color: var(--card-color);border-radius: 20px;padding: 30px;box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);border: 1px solid var(--border-color);}
    .loader-container h1 {text-align: center;margin-bottom: 20px;color: var(--text-primary);font-weight: 600;background: linear-gradient(90deg, var(--secondary-accent), #8A63D2);-webkit-background-clip: text;-webkit-text-fill-color: transparent;font-size: 20px;}
    .loader {width: 100%;height: 22px;background: var(--bg-color);border-radius: 15px;overflow: hidden;position: relative;border: 1px solid var(--border-color);box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.2);margin: 10px 0;}
    .loader-progress {height: 100%;width: 0%;background: linear-gradient(90deg, var(--secondary-accent), #8A63D2);border-radius: 15px;transition: width 0.3s ease;position: relative;overflow: hidden;}
    .loader-progress::after {content: '';position: absolute;top: 0;left: 0;bottom: 0;right: 0;background-image: linear-gradient( -45deg,  rgba(255, 255, 255, 0.2) 25%,  transparent 25%,  transparent 50%,  rgba(255, 255, 255, 0.2) 50%,  rgba(255, 255, 255, 0.2) 75%,  transparent 75%,  transparent);z-index: 1;background-size: 30px 30px;animation: move 1s linear infinite;border-radius: 15px;overflow: hidden;}
    @keyframes move {
        0% {background-position: 0 0;}
        100% {background-position: 30px 30px;}
    }
    .percentage {position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);color: var(--text-primary);font-size: 12px;font-weight: 600;z-index: 3;text-shadow: 0 0 4px rgba(0, 0, 0, 0.8);}
    .loader-info {display: flex;justify-content: space-between;width: 100%;color: var(--text-secondary);font-size: 14px;margin-bottom: 20px;}
    .decoration {position: absolute;width: 200px;height: 200px;background: radial-gradient(circle, var(--highlight-color) 0%, transparent 70%);border-radius: 50%;z-index: -1;}
    .decoration-1 {top: -100px;right: -100px;}
    .decoration-2 {bottom: -100px;left: -100px;}
    .place-item-center{place-items: center;}
    .font-20px{font-size: 20px!important;}    
    .first-loader-container .loader-wrapper {position: relative;display: flex;align-items: center;justify-content: center;width: 100px;height: 100px;font-family: "Inter", sans-serif;font-size: 1.2em;font-weight: 300;color: white;border-radius: 50%;background-color: transparent;user-select: none;}
    .first-loader-container .first-loader {position: absolute;top: 0;left: 0;width: 100%;aspect-ratio: 1 / 1;border-radius: 50%;background-color: transparent;animation: loader-rotate 2s linear infinite;z-index: 0;}
    @keyframes loader-rotate {
        0% {transform: rotate(90deg);box-shadow: 0 10px 20px 0 #fff inset, 0 20px 30px 0 #ad5fff inset, 0 60px 60px 0 #471eec inset;}
        50% {transform: rotate(270deg);box-shadow: 0 10px 20px 0 #fff inset, 0 20px 10px 0 #d60a47 inset, 0 40px 60px 0 #311e80 inset;}
        100% {transform: rotate(450deg);box-shadow: 0 10px 20px 0 #fff inset, 0 20px 30px 0 #ad5fff inset, 0 60px 60px 0 #471eec inset;}
    }
    .first-loader-container .loader-letter {display: inline-block;opacity: 0.4;transform: translateY(0);animation: loader-letter-anim 2s infinite;z-index: 1;border-radius: 50ch;border: none;}
    .first-loader-container .loader-letter:nth-child(1) {animation-delay: 0s;}
    .first-loader-container .loader-letter:nth-child(2) {animation-delay: 0.1s;}
    .first-loader-container .loader-letter:nth-child(3) {animation-delay: 0.2s;}
    .first-loader-container .loader-letter:nth-child(4) {animation-delay: 0.3s;}
    .first-loader-container .loader-letter:nth-child(5) {animation-delay: 0.4s;}
    .first-loader-container .loader-letter:nth-child(6) {animation-delay: 0.5s;}
    .first-loader-container .loader-letter:nth-child(7) {animation-delay: 0.6s;}
    .first-loader-container .loader-letter:nth-child(8) {animation-delay: 0.7s;}
    .first-loader-container .loader-letter:nth-child(9) {animation-delay: 0.8s;}
    .first-loader-container .loader-letter:nth-child(10) {animation-delay: 0.9s;}
    @keyframes loader-letter-anim {
        0%, 100% {opacity: 0.4;transform: translateY(0);}
        20% {opacity: 1;transform: scale(1.15);}
        40% {opacity: 0.7;transform: translateY(0);}
    }
    @media (max-width: 640px) {
        .content-page{width: 100%!important;max-width: 100%!important;}
        .rbt-static-bar{width: 86%!important;}
        .refresh-btn{height: auto!important;padding: 10px!important;}
        .upload-file-btn{padding: 20px!important;}
        .gap-items-container{padding: 0!important;}
        .chat-content {
            max-width: calc(100% - 10px)!important;
        }
    }
    .download-sample-btn{padding: 11px!important;height: 25px!important;margin-top: 10px!important;font-size: 12px!important;line-height: 3px!important;}
    .text-note{background: linear-gradient(90deg, #805AF5 0%, #CE99FF 100%);text-transform: capitalize;-webkit-background-clip: text;background-clip: text;-webkit-text-fill-color: transparent;}
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
            {{-- 
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
            --}}
        </div>

        <div class="chat-box-list pt--30" id="chatContainer">
            <div class="chat-box author-speech user-size-pdf-container" @if(!is_null($student_answer_sheet)) style="display: block;" @endif>
                <div class="inner">
                    <div class="chat-section">
                        <div class="author">
                            <img class="w-100" src="{{ asset('public/images/user-profile.jpg') }}" alt="Author">
                        </div>
                        <div class="chat-content user-content">
                            @if(!is_null($student_answer_sheet))
                            <h6 class="title">You</h6>
                            <p class="mt-5px">
                                <i class="fa-solid fa-file-pdf"></i> <span class="pdf-name">{{ $student_answer_sheet->file_name }}</span>
                            </p>
                            @endif
                            <!-- <h6 class="title">You</h6>
                            <p class="mt-5px">
                                <i class="fa-solid fa-file-pdf"></i> <span class="pdf-name">answer.pdf</span>
                            </p> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat-box ai-speech">
                <div class="inner">
                    <div class="answers-container" id="answers-container">
                        @if(!is_null($student_answer_sheet))
                            @include('student.mains-evaluation.partials.questions')
                        @else
                            <img src="{{ asset('public\images\chat-img.png') }}?v=1" alt="Upload your PDF to get instant, detailed feedback.">
                        @endif
                    </div>
                </div>
            </div> 
        </div>

        <div class="rbt-static-bar" style="display: block;">
            <form class="new-chat-form border-gradient">
                @if(!is_null($student_answer_sheet))
                <button type="button" class="refresh-btn"><i class="fa-solid fa-arrows-rotate"></i>&nbsp; New Evaluation</button>
                @else
                <button type="button" class="upload-file-btn"><i class="fa-solid fa-upload"></i>&nbsp; Start Evaluation</button>
                @endif
            </form>
            <p class="b3 small-text">Upload your PDF to get instant, detailed feedback.</p>
        </div>
    </div>
</div>
@include('student.mains-evaluation.partials.modals')
@endsection
@section('script')
<script>
    function renderDashboardAnimations() {
        const dashboards = document.querySelectorAll('.dashboard');
        
        dashboards.forEach(dashboard => {
            
            const score = dashboard.getAttribute('data-score');
            const total = parseInt(dashboard.getAttribute('data-total'));
            
            var percentage = (score / total) * 100;
            percentage = percentage.toFixed(2);            
            
            const emoji = dashboard.querySelector('.emoji-container');
            const scoreValue = dashboard.querySelector('.score-value');
            const progressFill = dashboard.querySelector('.progress-fill');
            const positionIndicator = dashboard.querySelector('.position-indicator');
            const markersContainer = dashboard.querySelector('.markers');
            const messageTitle = dashboard.querySelector('.message-title');
            const messageContent = dashboard.querySelector('.message-content');
            
            scoreValue.innerHTML = `${score}<span>/${total}</span>`;
            
            progressFill.style.setProperty('--progress-percent', `${percentage}%`);
            positionIndicator.style.setProperty('--progress-percent', `${percentage}%`);
            positionIndicator.textContent = `${score}`;
            
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
            
            const markerPoints = dashboard.querySelectorAll('.marker-point');
            markerPoints.forEach((point, index) => {
                setTimeout(() => {
                    point.style.animation = `pulse 1.5s ease ${index * 0.2}s`;
                }, 500);
            });
        });
    }
    var audio = new Audio('{{ asset("public/audio/loading-sound.mp3") }}');
    $(document).ready(function(){
        
        @if(!is_null($student_answer_sheet))
        renderDashboardAnimations();
        $(".refresh-btn").on('click', function(){
            let refresh_page = "{{ route('student.mains-evaluation') }}";
            window.location.href = refresh_page;
        });
        @endif

        let progress = 0;
        let loadTime = 120;
        let interval;

        $("#answer-container").html('<div class="chat-section generate-section"><div class="author"><img src="assets/images/icons/loader-one.gif" alt="Loader Images"></div><div class="chat-content"><h6 class="title color-text-off mb--0">Generating answers for you…</h6></div></div>');
        $("#answer-container").show();

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
        $.validator.addMethod('filesizeMB', function(value, element, maxMB) {
            if (element.files.length === 0) {
                return true;
            }

            if (!window.File || !window.FileList || !window.FileReader) {
                return true;
            }

            var maxBytes = parseFloat(maxMB) * 1024 * 1024; // convert MB to bytes
            for (var i = 0; i < element.files.length; i++) {
                if (element.files[i].size > maxBytes) {
                    return false;
                }
            }
            return true;
        }, function(params, element) {
            return 'File must be ' + params + ' MB or smaller.';
        });

        $("#evaluate-form").validate({
            ignore: ":hidden:not(#answer_sheet)",
            rules: {
                answer_sheet: {
                    required: true,
                    pdfValidation: true,
                    filesizeMB: 15
                }
            },
            messages: {

            },
            submitHandler: function(form){

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                var url = "{{ route('student.mains-evaluation.generate-task') }}";
                var file = $("#answer_sheet")[0].files[0];
                
                var formData = new FormData();
                formData.append('answer_sheet', file);
                formData.append('_token', '{{ csrf_token() }}');
                
                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $(".user-content .pdf-name").text(file.name);
                        $("#answersheet-upload-modal").modal('hide');
                        $(".user-content").html('<h6 class="title">You</h6><p class="mt-5px"><i class="fa-solid fa-file-pdf"></i> <span class="pdf-name">'+file.name+'</span></p>');
                        $(".user-size-pdf-container").show();
                        $("#answers-container").html(`
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="first-loader-container">
                                    <div class="loader-wrapper">
                                        <span class="loader-letter">G</span>
                                        <span class="loader-letter">e</span>
                                        <span class="loader-letter">n</span>
                                        <span class="loader-letter">e</span>
                                        <span class="loader-letter">r</span>
                                        <span class="loader-letter">a</span>
                                        <span class="loader-letter">t</span>
                                        <span class="loader-letter">i</span>
                                        <span class="loader-letter">n</span>
                                        <span class="loader-letter">g</span>
                                        <div class="first-loader"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h2 class="font-20px">We are generating response for you...</h2>
                            </div>
                        </div>
                        `);
                        audio.play();
                    }
                }).then(function(response) {
                    
                    if (response.success) {
                        audio.pause();
                        $("#answers-container").html(`
                        <div class="decoration decoration-1"></div>
                            <div class="decoration decoration-2"></div>
                            
                            <div class="loader-container">                                
                                <div class="loader-info">
                                    <span><i class="fas fa-hourglass-start"></i> 0%</span>
                                    <span id="remainingTime">3.0s remaining</span>
                                    <span><i class="fas fa-flag-checkered"></i> 100%</span>
                                </div>
                                <div class="loader">
                                    <div class="loader-progress" id="loaderProgress">
                                        <div class="percentage" id="percentage">0%</div>
                                    </div>
                                </div>        
                            </div>
                        </div>
                        `);
                        
                        $("#answers-container").show();
                        function startLoader(duration) {
                            $('#completionMessage').css('opacity', '0');
                            
                            progress = 0;
                            $('#loaderProgress').css('width', '0%');
                            $('#percentage').text('0%');
                            $('#remainingTime').text(duration.toFixed(1) + 's remaining');
                            
                            if (interval) {
                                clearInterval(interval);
                            }
                            
                            const intervalTime = 100 / (duration * 10);
                            let elapsedTime = 0;
                            
                            interval = setInterval(function() {
                                progress += intervalTime;
                                elapsedTime += 0.1;
                                
                                if (progress >= 100) {
                                    progress = 100;
                                    clearInterval(interval);
                                    
                                    $('#completionMessage').css('opacity', '1');
                                }
                                
                                $('#loaderProgress').css('width', progress + '%');
                                $('#percentage').text(Math.round(progress) + '%');
                                
                                const remaining = (duration * (100 - progress) / 100).toFixed(1);
                                // const remaining = duration - 1;
                                $('#remainingTime').text(remaining + ' remaining');
                            }, 500);
                        }
                        startLoader(response.loader_second);

                        let task_id = response.task_id;
                        let process_url = "{{ route('student.mains-evaluation.process-task', ':task_id') }}".replace(':task_id', task_id);

                        return $.ajax({
                            url: process_url,
                            type: "POST",
                            data: { _token: '{{ csrf_token() }}' },
                            processData: false,
                            contentType: false,
                            timeout: 1200000
                        });
                    } else {
                        audio.pause();
                        $("#answers-container").html('');
                        if("server_busy" in response) {
                            toastr.info(response.message, 'Info');
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                        return $.Deferred().resolve().promise();
                    }

                }).then(function(response) {
                    if(response != undefined) {
                        if (!response.success) {
                            toastr.error(response.message, 'Error');
                        } else {
                            toastr.success(response.message, 'Success');
                            typeWriterHTML(response.view, "answers-container", 0.003, renderDashboardAnimations);
                        }
                    }

                }).fail(function(err) {
                    toastr.error("Something went wrong please support our team.", 'Error');
                });

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
    /*function typeWriterHTML(html, elementId, speed = 50, callback = null) {
        const element = document.getElementById(elementId);
        element.innerHTML = "";

        let i = 0;
        let current = "";

        const instantTags = ["svg", "table", "pre", "code", "img", "video", "h6", "h4", "h5"];

        const instantBlocks = [
            '<div class="chat-content custom-margin-bottom">',
            '<div class="dashboard'
        ];

        function typing() {
            if (i >= html.length) {
                if (typeof callback === "function") {
                    callback();
                }
                return;
            }

            let inserted = false;

            for (let block of instantBlocks) {
                if (html.slice(i).toLowerCase().startsWith(block.toLowerCase())) {
                    let depth = 0;
                    let j = i;

                    while (j < html.length) {
                        if (html.slice(j, j + 5).toLowerCase() === "<div") {
                            depth++;
                        } else if (html.slice(j, j + 6).toLowerCase() === "</div>") {
                            depth--;
                            if (depth === 0) {
                                j += 6;
                                break;
                            }
                        }
                        j++;
                    }

                    current += html.slice(i, j);
                    element.innerHTML = current;
                    i = j;
                    inserted = true;
                    break;
                }
            }

            // Handle instant tags (svg, table, etc.)
            if (!inserted && html[i] === "<") {
                for (let tagName of instantTags) {
                    if (html.slice(i).toLowerCase().startsWith("<" + tagName)) {
                        let endTag = "</" + tagName + ">";
                        let endIndex = html.toLowerCase().indexOf(endTag, i);

                        if (endIndex !== -1) {
                            endIndex += endTag.length;
                        } else {
                            endIndex = html.indexOf(">", i) + 1;
                        }

                        current += html.slice(i, endIndex);
                        element.innerHTML = current;
                        i = endIndex;
                        inserted = true;
                        break;
                    }
                }
            }

            // 🚀 FIX: instantly render any tag (not just instantTags)
            if (!inserted && html[i] === "<") {
                let endIndex = html.indexOf(">", i) + 1;
                current += html.slice(i, endIndex);
                element.innerHTML = current;
                i = endIndex;
                inserted = true;
            }

            // Type character-by-character ONLY for text content
            if (!inserted) {
                current += html[i];
                element.innerHTML = current;
                i++;
            }

            // Continue
            if (i < html.length) {
                setTimeout(typing, inserted ? 0 : speed);
            } else {
                if (typeof callback === "function") {
                    callback();
                }
            }
        }

        typing();
    }*/
    function typeWriterHTML(html, elementId, speed = 50, callback = null) {
        const element = document.getElementById(elementId);
        element.innerHTML = "";

        let i = 0;
        let current = "";

        const instantTags = ["svg", "table", "pre", "code", "img", "video", "h6", "h4", "h5"];
        const instantBlocks = [
            '<div class="chat-content custom-margin-bottom">',
            '<div class="dashboard'
        ];

        function typing() {
            if (i >= html.length) {
                if (typeof callback === "function") callback();
                return;
            }

            let inserted = false;

            // Handle instant blocks
            for (let block of instantBlocks) {
                if (html.slice(i).toLowerCase().startsWith(block.toLowerCase())) {
                    let depth = 0;
                    let j = i;
                    while (j < html.length) {
                        if (html.slice(j, j + 5).toLowerCase() === "<div") {
                            depth++;
                        } else if (html.slice(j, j + 6).toLowerCase() === "</div>") {
                            depth--;
                            if (depth === 0) {
                                j += 6;
                                break;
                            }
                        }
                        j++;
                    }

                    current += html.slice(i, j);
                    element.innerHTML = current;
                    window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" }); // 🔹 Scroll page
                    i = j;
                    inserted = true;
                    break;
                }
            }

            // Handle instant tags
            if (!inserted && html[i] === "<") {
                for (let tagName of instantTags) {
                    if (html.slice(i).toLowerCase().startsWith("<" + tagName)) {
                        let endTag = "</" + tagName + ">";
                        let endIndex = html.toLowerCase().indexOf(endTag, i);

                        if (endIndex !== -1) {
                            endIndex += endTag.length;
                        } else {
                            endIndex = html.indexOf(">", i) + 1;
                        }

                        current += html.slice(i, endIndex);
                        element.innerHTML = current;
                        window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" }); // 🔹 Scroll page
                        i = endIndex;
                        inserted = true;
                        break;
                    }
                }
            }

            // Instantly render unknown tags
            if (!inserted && html[i] === "<") {
                let endIndex = html.indexOf(">", i) + 1;
                current += html.slice(i, endIndex);
                element.innerHTML = current;
                window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" }); // 🔹 Scroll page
                i = endIndex;
                inserted = true;
            }

            // Word-by-word typing
            if (!inserted) {
                let nextSpace = html.indexOf(" ", i);
                if (nextSpace === -1) nextSpace = html.length;
                current += html.slice(i, nextSpace + 1);
                element.innerHTML = current;
                window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" }); // 🔹 Scroll page
                i = nextSpace + 1;
            }

            // Continue typing
            if (i < html.length) {
                setTimeout(typing, speed);
            } else {
                if (typeof callback === "function") callback();
            }
        }

        typing();
    }
</script>
@endsection