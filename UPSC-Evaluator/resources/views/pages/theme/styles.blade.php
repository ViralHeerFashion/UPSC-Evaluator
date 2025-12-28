<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
<link rel="stylesheet" href="{{ asset('public/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/fontawesome-all.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/feature.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/animation.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/slick.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/prism.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/style.css') }}">
<style>
    .institute-logo{border-radius: 10px;}
</style>
<script>
    function showModal() {
        const overlay = document.createElement('div');
        overlay.style.position = 'fixed';
        overlay.style.top = '0';
        overlay.style.left = '0';
        overlay.style.width = '100vw';
        overlay.style.height = '100vh';
        overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
        overlay.style.zIndex = '9999';
        overlay.style.display = 'flex';
        overlay.style.justifyContent = 'center';
        overlay.style.alignItems = 'center';
    
        const modal = document.createElement('div');
        modal.style.width = '400px';
        modal.style.backgroundColor = '#fff';
        modal.style.borderRadius = '8px';
        modal.style.padding = '20px';
        modal.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
        modal.style.textAlign = 'center';
    
        const message = document.createElement('p');
        message.textContent = 'This page is loaded in an external iframe. For a better experience, please open it in a new tab.';
        message.style.marginBottom = '20px';
        message.style.fontSize = '16px';
        modal.appendChild(message);
    
        const buttonsContainer = document.createElement('div');
        buttonsContainer.style.display = 'flex';
        buttonsContainer.style.justifyContent = 'center';
        buttonsContainer.style.gap = '10px';
        buttonsContainer.style.marginTop = '20px';
        buttonsContainer.style.flexWrap = 'wrap';
    
        const okButton = document.createElement('button');
        okButton.textContent = 'Open in New Tab';
        okButton.style.padding = '10px 20px';
        okButton.style.backgroundColor = '#4CAF50';
        okButton.style.color = '#fff';
        okButton.style.border = 'none';
        okButton.style.borderRadius = '4px';
        okButton.style.cursor = 'pointer';
        okButton.addEventListener('click', () => {
            window.top.location = window.self.location.href;
        });
        buttonsContainer.appendChild(okButton);
    
        const cancelButton = document.createElement('button');
        cancelButton.textContent = 'Stay on this Page';
        cancelButton.style.padding = '10px 20px';
        cancelButton.style.backgroundColor = '#f44336';
        cancelButton.style.color = '#fff';
        cancelButton.style.border = 'none';
        cancelButton.style.borderRadius = '4px';
        cancelButton.style.cursor = 'pointer';
        cancelButton.addEventListener('click', () => {
            document.body.removeChild(overlay);
        });
        buttonsContainer.appendChild(cancelButton);
    
        modal.appendChild(buttonsContainer);
    
        overlay.appendChild(modal);
    
        document.body.appendChild(overlay);
    
        const style = document.createElement('style');
            style.innerHTML = `
                @media (max-width: 600px) {
                    .modal-buttons-container {
                        flex-direction: column;
                        align-items: center;
                    }
                    .modal-buttons-container button {
                        width: 100%;
                        margin-bottom: 10px;
                    }
                }
            `;
            document.head.appendChild(style);
        }
        document.addEventListener('DOMContentLoaded', () => {
            if (window.self !== window.top) {
                showModal();
            }
        });
</script>