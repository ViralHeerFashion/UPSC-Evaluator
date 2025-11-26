<div id="answersheet-upload-modal" class="modal rbt-modal-box like-modal fade" tabindex="-1">
    <form action="{{ route('student.mains-evaluation.make-evaluate') }}" method="post" id="evaluate-form">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content wrapper">
                <h6 class="theme-gradient">General Studies</h6>
                  <div class="mb-3">
                    <label for="language" class="form-label">Select Language</label>
                    <select name="language" id="language" class="form-control">
                        <option value="1">English</option>
                        <option value="2">Hindi</option>
                        <option value="3">Marathi</option>
                    </select>
                </div>
                <div class="chat-form">
                    <div class="premium-upload-container">
                        <input type="file" id="answer_sheet" class="premium-upload-input" name="answer_sheet" accept=".pdf">
                        <label for="answer_sheet" class="premium-upload-label">
                            <div class="upload-icon-wrapper">
                                <svg class="upload-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 15V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V15" stroke="#805AF5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M17 8L12 3L7 8" stroke="#805AF5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 3V15" stroke="#805AF5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="upload-text-content">
                                <h3 class="upload-title">Upload Your Answersheet</h3>
                                <p class="upload-subtitle">Drag & drop files here or click to browse</p>
                            </div>
                            <button type="button" class="btn btn-default change-answersheet-btn">Change</button>
                            <div class="upload-details">
                                <span class="detail-item">Max 15MB</span>
                                <span class="detail-separator">•</span>
                                <span class="detail-item">Only PDF allowed</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-6">
                        <a href="{{ asset('public/samples/Sample_GS_Answer_Sheet.pdf') }}" class="btn btn-default download-sample-btn" download="Sample_GS_Answer_Sheet.pdf">Download sample</a>
                    </div>
                    <div class="col-md-6 col-6">
                        <p class="i-love-pdf">
                            You can compress your pdf: <a href="https://www.ilovepdf.com/compress_pdf" target="_blank">Click Here</a>
                        </p>  
                    </div>
                </div>
                <div class="bottom-btn mt--20 text-right">
                    <button type="submit" class="btn-default btn-small round">Start Evaluation</button>
                </div>
                <button type="button" class="close-button" data-bs-dismiss="modal">
                    <i class="fa-sharp fa-regular fa-x"></i>
                </button>
            </div>
        </div>
    </form>
</div>