@extends('pages.theme.main')
@section('title', 'Terms & Condition')
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
                                        <h3 class="title">Terms and Conditions for Aspire Scan</h3>
                                    </div>
                                </div>
                                <div class="content-page pb--50">
                                    <div class="chat-box-list">
                                        <div class="content">
                                            <h4>Last Updated: 1st September 2025</h4>
                                            <p>This document is an electronic record in terms of the Information Technology Act, 2000. By using the Aspire Scan web application, you signify your agreement to be bound by these Terms and Conditions.</p>
                                            <p>The Aspire Scan web application (the "Service") is a product owned and operated by <b>Potenzials Education</b> ("Company," "we," "us," or "our").</p>

                                            <h4>1. The Service</h4>
                                            <p>Aspire Scan is an AI-powered web application that allows users to upload their handwritten UPSC Mains answer sheets in PDF format. The Service processes these documents to provide automated evaluation, scoring, and detailed feedback ("Evaluation Reports").</p>
                                            
                                            <h4>2. User Account</h4>
                                            <p>You must register for an account to use the Service. You are responsible for maintaining the confidentiality of your account password and for all activities that occur under your account. You agree to provide accurate and complete information during registration.</p>

                                            <h4>3. Wallet, Payments, and Refunds</h4>
                                            <ul>
                                                <li><b>Wallet System:</b> The Service operates on a digital wallet system. To use the evaluation services, you must have a positive balance in your Aspire Scan wallet.</li>
                                                <li><b>Recharges:</b> You can add funds to your wallet by purchasing one of the available recharge packs. All payments will be processed through our third-party payment gateway, Razorpay.</li>
                                                <li><b>Deduction of Charges:</b> Your wallet will be debited at a rate of <b>₹1.20 (One Rupee and Twenty Paise)</b> for every page of the PDF document you upload for evaluation. The total cost will be calculated and deducted from your wallet before the evaluation report is generated. You must have sufficient balance to process the entire document.</li>
                                                <li><b>No Refund Policy: All wallet recharges are final, non-refundable, and non-transferable.</b> The balance in your wallet does not expire and can be used at any time. We will not provide any refunds for partially used or unused wallet balances.</li>
                                            </ul>


                                            <h4>4. User Conduct and Responsibilities</h4>
                                            <ul>
                                                <li>You agree to use the Service only for its intended purpose of practicing and improving your answer writing skills.</li>
                                                <li>You are solely responsible for the content you upload. You shall not upload any material that is unlawful, harmful, or infringes on any third-party rights.</li>
                                                <li>You agree not to use any automated means, such as bots or scripts, to access or interact with the Service.</li>
                                            </ul>

                                            <h4>5. Intellectual Property Rights</h4>
                                            <ul>
                                                <li><b>User Content: </b> You retain full ownership and all intellectual property rights to the original handwritten content in the PDF files you upload.</li>
                                                <li><b>Company IP: </b> We retain all rights, title, and interest in and to the Service, including the AI models, the software, and the format of the "Evaluation Reports" generated. You are granted a limited, non-exclusive license to use the reports for your personal, non-commercial educational purposes.</li>
                                            </ul>
                                            
                                            
                                            <h4>6. Termination</h4>
                                            <p>We may suspend or terminate your access to the Service at any time, without prior notice, for conduct that we believe violates these Terms and Conditions or is otherwise harmful to other users or our business interests.</p>
                                            
                                            <h4>7. Limitation of Liability</h4>
                                            <p>In no event shall Potenzials Education be liable for any indirect, incidental, or consequential damages arising out of the use or inability to use the Service. Our total liability to you for any damages shall not exceed the amount of the last wallet recharge you made.</p>

                                            <h4>8. Governing Law and Jurisdiction</h4>
                                            <p>These Terms and Conditions shall be governed by the laws of India. Any disputes arising in relation hereto shall be subject to the exclusive jurisdiction of the courts at <b>Pune, Maharashtra.</b></p>

                                            <h4>9. Contact Us</h4>
                                            <p>For any questions about these Terms, please contact us at <b>support@aspirescan.com</b></p>
                                        
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