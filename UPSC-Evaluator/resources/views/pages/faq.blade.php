@extends('pages.theme.main')
@section('title', 'FAQ')
@section('styles')
<style>
    .custom-margin-top{
        margin-top: 20px!important;
    }
    @media only screen and (max-width: 425px) {
        .custom-margin-top{
            margin-top: 55px!important;
        }
    }
</style>
@endsection
@section('content')
<div class="rainbow-cta-area rainbow-section-gap rainbow-section-gapBottom-big">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="content-page pb--50 mt-3">
                    <div class="chat-box-list">
                        <div class="content">
                            <div class="rainbow-accordion-style accordion rainbow-section-gapBottom">
                                <div class="banner-area custom-margin-top">
                                    <div class="settings-area">
                                        <h3 class="title">FAQ</h3>
                                    </div>
                                </div>
                                <div class="accordion" id="accordionExamplea">
                                    <div class="accordion-item card ">
                                        <h2 class="accordion-header card-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                What is the UPSC AI Evaluator?
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                The UPSC AI Evaluator is an intelligent web application that uses advanced Artificial Intelligence to automatically evaluate handwritten UPSC Mains answer sheets. It provides instant, objective scoring and detailed feedback, including a micro-marking grid, gap analysis, corrective actions, and model answers to help you improve your performance.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item card ">
                                        <h2 class="accordion-header card-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Who is this platform for?
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                Our platform is designed for all UPSC Civil Services aspirants who are serious about improving their Mains answer writing skills. It is also a valuable tool for coaching institutes looking for a scalable and efficient evaluation solution.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item card ">
                                        <h2 class="accordion-header card-header" id="headingThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                How is this different from manual evaluation?
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                Our AI provides instant, unbiased, and consistent feedback available 24/7. While human mentorship is invaluable, our platform acts as a powerful practice tool that gives you immediate, data-driven insights. It helps you identify patterns in your mistakes and fix them with a speed that manual evaluation cannot match.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item card ">
                                        <h2 class="accordion-header card-header" id="headingfour">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                How does the AI evaluation work?
                                            </button>
                                        </h2>
                                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingfour" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                Once you upload your answer sheet PDF, our AI reads your handwriting, identifies the questions you've answered, and then analyzes your answers based on a vast dataset of high-quality information and UPSC evaluation benchmarks. It assesses your answer for structure, content, keyword usage, and adherence to the question's core demands.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item card ">
                                        <h2 class="accordion-header card-header" id="headingfive">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                How accurate is the AI? Can I trust the scores?
                                            </button>
                                        </h2>
                                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingfive" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                Our AI has been trained extensively on UPSC-specific data to be highly accurate. The score should be seen as a powerful diagnostic metric to gauge your performance and track improvement. The most valuable part is the detailed qualitative feedback—the Gap Analysis and Corrective Actions—which provides a clear roadmap for improvement.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item card ">
                                        <h2 class="accordion-header card-header" id="headingsix">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                Can the AI understand my handwriting?
                                            </button>
                                        </h2>
                                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingsix" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                Our system is trained to read a wide variety of handwritten styles. For the best results, we recommend writing legibly and ensuring your PDF is created from clear, high-quality scans of your answer sheets.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item card ">
                                        <h2 class="accordion-header card-header" id="headingseven">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                                How long does a full evaluation take?
                                            </button>
                                        </h2>
                                        <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingseven" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                A full-length General Studies paper (around 55-60 pages) is typically processed and evaluated within 120 seconds. The exact time may vary slightly depending on the server load.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item card ">
                                        <h2 class="accordion-header card-header" id="headingeight">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                                How does the pricing work?
                                            </button>
                                        </h2>
                                        <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingeight" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                Our platform uses a simple and flexible wallet system. You start with a free ₹15 wallet balance to try our service. To continue, you recharge your wallet with one of our packs. The larger the recharge pack you choose, the more bonus balance you receive, giving you the best value.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item card ">
                                        <h2 class="accordion-header card-header" id="headingnine">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                                How is my wallet balance used? What are the charges?
                                            </button>
                                        </h2>
                                        <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingnine" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                Our pricing is simple and transparent. Your wallet is charged a flat rate of ₹1.20 for every page in the PDF you upload for evaluation. For example, evaluating a 20-page answer sheet will cost exactly ₹24 (20 pages x ₹1.20). This per-page model encourages concise answer writing, a crucial skill for the Mains exam.    
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item card ">
                                        <h2 class="accordion-header card-header" id="headingten">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                                Does my wallet balance ever expire?
                                            </button>
                                        </h2>
                                        <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingten" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                No. Your wallet balance never expires. You can use it anytime throughout your preparation.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item card ">
                                        <h2 class="accordion-header card-header" id="headingeleven">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                                                What payment methods do you accept?
                                            </button>
                                        </h2>
                                        <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingeleven" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                We accept all major payment methods, including UPI, Credit Cards, Debit Cards, and Net Banking, through our secure payment gateway.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item card ">
                                        <h2 class="accordion-header card-header" id="headingtwel">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwel" aria-expanded="false" aria-controls="collapseTwel">
                                                What format should I upload my answer sheet in?
                                            </button>
                                        </h2>
                                        <div id="collapseTwel" class="accordion-collapse collapse" aria-labelledby="headingtwel" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                We exclusively accept uploads in the PDF format. Please ensure all your handwritten answer pages are scanned and combined into a single PDF file before uploading. You can use a physical scanner or free mobile apps like Adobe Scan or Microsoft Lens to create a PDF.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item card ">
                                        <h2 class="accordion-header card-header" id="headingthirtin">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThirty" aria-expanded="false" aria-controls="collapseThirty">
                                                What are some tips for getting the best evaluation results?
                                            </button>
                                        </h2>
                                        <div id="collapseThirty" class="accordion-collapse collapse" aria-labelledby="headingthirtin" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                For the highest accuracy, please ensure:
                                                <ul>
                                                    <li>
                                                        <b>Create a High-Quality PDF:</b> Use clear, well-lit, and non-blurry scans of your pages.
                                                    </li>
                                                    <li>
                                                        <b>Write Legibly:</b> The clearer your handwriting, the better our AI can analyze your content.
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item card ">
                                        <h2 class="accordion-header card-header" id="headingforteen">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseforteen" aria-expanded="false" aria-controls="collapseforteen">
                                                What if I face an issue with my upload or evaluation?
                                            </button>
                                        </h2>
                                        <div id="collapseforteen" class="accordion-collapse collapse" aria-labelledby="headingforteen" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                If you encounter any technical problems or have questions about your evaluation report, please contact our support team immediately at support@aspirescan.com
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item card ">
                                        <h2 class="accordion-header card-header" id="headingfiftin">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiftin" aria-expanded="false" aria-controls="collapseFiftin">
                                                Is my data and my answer sheets kept private?
                                            </button>
                                        </h2>
                                        <div id="collapseFiftin" class="accordion-collapse collapse" aria-labelledby="headingfiftin" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                Absolutely. We take your privacy and data security very seriously. Your uploaded answer sheets are used solely for the purpose of providing you with an evaluation and are not shared with any third parties.
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection