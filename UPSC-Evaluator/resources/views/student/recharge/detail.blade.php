<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <style>
        :root {
            --primary: #805AF5;
            --primary-light: #CD99FF;
            --success: #00b894;
            --error: #ff4757;
            --dark-bg: #0E0C15;
            --card-bg: #16181E;
            --text-light: #f1f1f1;
            --text-muted: #b8b8b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--dark-bg);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .status-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            width: 100%;
            max-width: 420px;
            padding: 32px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .status-card:hover {
            transform: translateY(-5px);
        }

        .status-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 24px;
            position: relative;
        }

        /* Success Icon Styles */
        .success-icon {
            background-color: rgba(0, 184, 148, 0.1);
        }

        .success-icon::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid var(--success);
            animation: ripple 1.5s infinite;
        }

        .success-icon svg {
            width: 40px;
            height: 40px;
            fill: var(--success);
        }

        /* Failure Icon Styles */
        .failure-icon {
            background-color: rgba(255, 71, 87, 0.1);
        }

        .failure-icon::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid var(--error);
            animation: pulse 1.5s infinite;
        }

        .failure-icon svg {
            width: 40px;
            height: 40px;
            fill: var(--error);
        }

        .status-title {
            color: var(--text-light);
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .status-message {
            color: var(--text-muted);
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 24px;
        }

        .payment-details {
            background-color: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 32px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            color: var(--text-muted);
            font-size: 14px;
        }

        .detail-value {
            color: var(--text-light);
            font-size: 14px;
            font-weight: 500;
        }

        .total-amount {
            font-size: 18px;
            font-weight: 600;
        }

        .success-amount {
            color: var(--success);
        }

        .error-amount {
            color: var(--error);
        }

        .action-btn {
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            color: white;
            border: none;
            border-radius: 8px;
            padding: 14px 24px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
            text-decoration: none;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, var(--primary-light), var(--primary));
            opacity: 0;
            z-index: -1;
            transition: opacity 0.3s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(128, 90, 245, 0.4);
        }

        .action-btn:hover::before {
            opacity: 1;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            opacity: 0;
        }

        @keyframes ripple {
            0% {
                transform: scale(0.8);
                opacity: 0.5;
            }
            100% {
                transform: scale(1.3);
                opacity: 0;
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 71, 87, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(255, 71, 87, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(255, 71, 87, 0);
            }
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            10%, 30%, 50%, 70%, 90% {
                transform: translateX(-5px);
            }
            20%, 40%, 60%, 80% {
                transform: translateX(5px);
            }
        }

        .shake {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .status-card {
                padding: 24px;
            }
            
            .status-title {
                font-size: 20px;
            }
            
            .status-message {
                font-size: 14px;
            }
        }

        /* Toggle switch */
        .toggle-container {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.1);
            padding: 8px 12px;
            border-radius: 30px;
            z-index: 100;
        }

        .toggle-label {
            color: var(--text-light);
            margin-right: 10px;
            font-size: 14px;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--error);
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--success);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }
    </style>
</head>
<body>

    <div class="status-card" id="successCard">
        @if($recharge->payment_status == 1)
        <div class="status-icon success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
            </svg>
        </div>
        <h1 class="status-title">Payment Successful!</h1>
        <p class="status-message">Your payment has been processed successfully. Please check your wallet for transaction history.</p>
        @else
        <div class="status-icon failure-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
            </svg>
        </div>
        <h1 class="status-title">Payment Failed!</h1>
        <p class="status-message">We couldn't process your payment. Please try again or use a different payment method.</p>
        @endif
        <div class="payment-details">
            <div class="detail-row">
                <span class="detail-label">Date</span>
                <span class="detail-value">{{ date("F d, Y h:i A", strtotime($recharge->created_at)) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment ID</span>
                <span class="detail-value">#{{ $recharge->razorpay_payment_id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Amount</span>
                <span class="detail-value total-amount success-amount">₹{{ number_format($recharge->amount) }}</span>
            </div>
        </div>
        
        <a href="javascript:void(0);" class="action-btn">Go to Wallet</a>
    </div>

    <script>
        // Toggle between success and failure states
        document.getElementById('statusToggle').addEventListener('change', function() {
            const successCard = document.getElementById('successCard');
            const failureCard = document.getElementById('failureCard');
            
            if (this.checked) {
                successCard.style.display = 'block';
                failureCard.style.display = 'none';
                createConfetti(true);
            } else {
                successCard.style.display = 'none';
                failureCard.style.display = 'block';
                createConfetti(false);
                // Add shake animation to failure card
                failureCard.classList.add('shake');
                setTimeout(() => {
                    failureCard.classList.remove('shake');
                }, 500);
            }
        });

        // Button actions
        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const isSuccess = this.closest('.status-card').id === 'successCard';
                alert(isSuccess ? 'Navigating back to dashboard...' : 'Retrying payment...');
            });
        });

        // Create confetti elements
        function createConfetti(isSuccess) {
            // Clear existing confetti
            document.querySelectorAll('.confetti').forEach(el => el.remove());
            
            const colors = isSuccess 
                ? ['#00b894', '#805AF5', '#CD99FF', '#fdcb6e', '#e17055']
                : ['#ff4757', '#ff6b81', '#ff6348', '#ffa502', '#e17055'];
            
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                document.querySelector('.status-card:not([style*="none"])').appendChild(confetti);
                
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                
                // Random properties
                const size = Math.random() * 10 + 5;
                const posX = Math.random() * 100;
                const delay = Math.random() * 3;
                const duration = Math.random() * 3 + 2;
                const rotation = Math.random() * 720;
                
                // Apply styles
                confetti.style.width = `${size}px`;
                confetti.style.height = `${size}px`;
                confetti.style.backgroundColor = randomColor;
                confetti.style.left = `${posX}%`;
                confetti.style.top = '-10px';
                confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
                
                // Animation
                const animationName = isSuccess ? 'fall' : 'fallFast';
                confetti.style.animation = `${animationName} ${duration}s ease-in ${delay}s infinite`;
                
                // Add keyframes dynamically
                const style = document.createElement('style');
                style.innerHTML = `
                    @keyframes fall {
                        to {
                            transform: translateY(calc(100vh + 20px)) rotate(${rotation}deg);
                            opacity: 0;
                        }
                    }
                    @keyframes fallFast {
                        to {
                            transform: translateY(calc(100vh + 20px)) rotate(${rotation}deg) scale(1.5);
                            opacity: 0;
                        }
                    }
                `;
                document.head.appendChild(style);
            }
        }

        // Initial confetti for success state
        createConfetti(true);
    </script>
</body>
</html>