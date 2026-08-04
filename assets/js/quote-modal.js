// Quote Request Modal Handler
(function() {
    'use strict';
    
    let smtpConfig = null;
    
    // Load SMTP config from backend
    async function loadSMTPConfig() {
        try {
            // First try to get from localStorage (set by dashboard)
            const localConfig = localStorage.getItem('smtp_config');
            if (localConfig) {
                smtpConfig = JSON.parse(localConfig);
                return smtpConfig;
            }
            
            // Try to get from backend API
            const response = await fetch('api/get-smtp-config.php');
            const data = await response.json();
            
            if (data.success && data.config) {
                smtpConfig = data.config;
                // Save to localStorage for future use
                localStorage.setItem('smtp_config', JSON.stringify(smtpConfig));
                return smtpConfig;
            }
        } catch (error) {
            console.error('Error loading SMTP config:', error);
        }
        return null;
    }
    
    // Create modal HTML
    function createModalHTML() {
        return `
            <div id="quoteRequestModal" class="quote-modal" style="display: none;">
                <div class="quote-modal-overlay"></div>
                <div class="quote-modal-content">
                    <div class="quote-modal-header">
                        <h2>Request a Quote</h2>
                        <button class="quote-modal-close" onclick="closeQuoteModal()">&times;</button>
                    </div>
                    <form id="quoteRequestForm" class="quote-modal-form">
                        <input type="hidden" id="quote-product-name" name="product_name" value="">
                        <input type="hidden" id="quote-product-url" name="product_url" value="">
                        
                        <div class="form-group">
                            <label for="quote-name">Full Name *</label>
                            <input type="text" id="quote-name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="quote-email">Email Address *</label>
                            <input type="email" id="quote-email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="quote-phone">Phone Number *</label>
                            <input type="tel" id="quote-phone" name="phone" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="quote-company">Company Name</label>
                            <input type="text" id="quote-company" name="company">
                        </div>
                        
                        <div class="form-group">
                            <label for="quote-quantity">Quantity</label>
                            <input type="number" id="quote-quantity" name="quantity" min="1" value="1">
                        </div>
                        
                        <div class="form-group">
                            <label for="quote-message">Additional Requirements / Message</label>
                            <textarea id="quote-message" name="message" rows="4"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="quote-submit-btn">
                                <span class="btn-text">Submit Request</span>
                                <span class="btn-loader" style="display: none;">Sending...</span>
                            </button>
                        </div>
                        
                        <div id="quote-form-message" class="quote-form-message" style="display: none;"></div>
                    </form>
                </div>
            </div>
        `;
    }
    
    // Create modal CSS
    function createModalCSS() {
        const style = document.createElement('style');
        style.textContent = `
            .quote-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 100000;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .quote-modal-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(4px);
            }
            
            .quote-modal-content {
                position: relative;
                background: #ffffff;
                border-radius: 16px;
                width: 90%;
                max-width: 600px;
                max-height: 90vh;
                overflow-y: auto;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                z-index: 100001;
                animation: modalSlideIn 0.3s ease-out;
            }
            
            @keyframes modalSlideIn {
                from {
                    opacity: 0;
                    transform: translateY(-50px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .quote-modal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 24px 30px;
                border-bottom: 2px solid #e5e5e5;
                background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
                border-radius: 16px 16px 0 0;
            }
            
            .quote-modal-header h2 {
                color: #ffffff;
                font-size: 24px;
                font-weight: 700;
                margin: 0;
            }
            
            .quote-modal-close {
                background: rgba(255, 255, 255, 0.2);
                border: none;
                color: #ffffff;
                font-size: 32px;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
                line-height: 1;
                padding: 0;
            }
            
            .quote-modal-close:hover {
                background: rgba(255, 255, 255, 0.3);
                transform: rotate(90deg);
            }
            
            .quote-modal-form {
                padding: 30px;
            }
            
            .quote-modal-form .form-group {
                margin-bottom: 20px;
            }
            
            .quote-modal-form label {
                display: block;
                margin-bottom: 8px;
                font-weight: 600;
                color: #333;
                font-size: 14px;
            }
            
            .quote-modal-form input,
            .quote-modal-form textarea {
                width: 100%;
                padding: 12px 16px;
                border: 2px solid #e5e5e5;
                border-radius: 8px;
                font-size: 15px;
                transition: all 0.3s ease;
                font-family: inherit;
            }
            
            .quote-modal-form input:focus,
            .quote-modal-form textarea:focus {
                outline: none;
                border-color: #4CAF50;
                box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
            }
            
            .quote-submit-btn {
                width: 100%;
                padding: 16px;
                background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
                color: #ffffff;
                border: none;
                border-radius: 8px;
                font-size: 16px;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
            }
            
            .quote-submit-btn:hover:not(:disabled) {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
            }
            
            .quote-submit-btn:disabled {
                opacity: 0.7;
                cursor: not-allowed;
            }
            
            .quote-form-message {
                margin-top: 16px;
                padding: 12px 16px;
                border-radius: 8px;
                font-size: 14px;
            }
            
            .quote-form-message.success {
                background: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }
            
            .quote-form-message.error {
                background: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }
            
            @media (max-width: 768px) {
                .quote-modal-content {
                    width: 95%;
                    max-height: 95vh;
                }
                
                .quote-modal-header {
                    padding: 20px;
                }
                
                .quote-modal-form {
                    padding: 20px;
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    // Open modal
    window.openQuoteModal = function(productName = '', productUrl = '') {
        const modal = document.getElementById('quoteRequestModal');
        if (!modal) {
            // Create modal if it doesn't exist
            document.body.insertAdjacentHTML('beforeend', createModalHTML());
            createModalCSS();
        }
        
        const modalElement = document.getElementById('quoteRequestModal');
        const productNameInput = document.getElementById('quote-product-name');
        const productUrlInput = document.getElementById('quote-product-url');
        
        if (productNameInput) productNameInput.value = productName;
        if (productUrlInput) productUrlInput.value = productUrl;
        
        modalElement.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Load SMTP config
        loadSMTPConfig();
    };
    
    // Close modal
    window.closeQuoteModal = function() {
        const modal = document.getElementById('quoteRequestModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
            // Reset form
            const form = document.getElementById('quoteRequestForm');
            if (form) {
                form.reset();
                const messageDiv = document.getElementById('quote-form-message');
                if (messageDiv) {
                    messageDiv.style.display = 'none';
                    messageDiv.className = 'quote-form-message';
                }
            }
        }
    };
    
    // Handle form submission
    function handleFormSubmit(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('.quote-submit-btn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoader = submitBtn.querySelector('.btn-loader');
        const messageDiv = document.getElementById('quote-form-message');
        
        // Disable submit button
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoader.style.display = 'inline-block';
        messageDiv.style.display = 'none';
        
        // Get form data — submitted to backend (saved + email via server SMTP)
        const formData = new FormData(form);
        const payload = {
            name: formData.get('name'),
            email: formData.get('email'),
            phone: formData.get('phone'),
            company: formData.get('company') || '',
            quantity: formData.get('quantity') || '1',
            message: formData.get('message') || '',
            product_name: formData.get('product_name') || '',
            product_url: formData.get('product_url') || window.location.href,
            source: 'quote_modal'
        };

        fetch('api/quote-requests.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    const msg = result.email && result.email.sent === false
                        ? 'Thank you! Your request was received. Our team will contact you soon.'
                        : 'Thank you! Your quote request has been submitted successfully. We will contact you soon.';
                    showMessage('success', msg);
                    form.reset();
                    setTimeout(() => closeQuoteModal(), 2000);
                } else {
                    showMessage('error', result.message || 'Failed to submit quote request. Please try again or contact us directly.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred. Please try again later or call +91 90310 86082.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                btnText.style.display = 'inline-block';
                btnLoader.style.display = 'none';
            });
    }
    
    function showMessage(type, message) {
        const messageDiv = document.getElementById('quote-form-message');
        if (messageDiv) {
            messageDiv.textContent = message;
            messageDiv.className = `quote-form-message ${type}`;
            messageDiv.style.display = 'block';
        }
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    function init() {
        // Create modal HTML and CSS
        document.body.insertAdjacentHTML('beforeend', createModalHTML());
        createModalCSS();
        
        // Attach form handler
        const form = document.getElementById('quoteRequestForm');
        if (form) {
            form.addEventListener('submit', handleFormSubmit);
        }
        
        // Close modal on overlay click
        const overlay = document.querySelector('.quote-modal-overlay');
        if (overlay) {
            overlay.addEventListener('click', closeQuoteModal);
        }
        
        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('quoteRequestModal');
                if (modal && modal.style.display !== 'none') {
                    closeQuoteModal();
                }
            }
        });
    }
})();

