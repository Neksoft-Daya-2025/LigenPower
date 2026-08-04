// Unified Form Handler for SMTP Integration
(function() {
    'use strict';
    
    let smtpConfig = null;
    
    // Load SMTP config
    async function loadSMTPConfig() {
        try {
            // First try localStorage (set by dashboard)
            const localConfig = localStorage.getItem('smtp_config');
            if (localConfig) {
                smtpConfig = JSON.parse(localConfig);
                return smtpConfig;
            }
            
            // Try backend API
            const response = await fetch('api/get-smtp-config.php');
            const data = await response.json();
            
            if (data.success && data.config) {
                smtpConfig = data.config;
                localStorage.setItem('smtp_config', JSON.stringify(smtpConfig));
                return smtpConfig;
            }
        } catch (error) {
            console.error('Error loading SMTP config:', error);
        }
        return null;
    }
    
    // Send email via SMTP
    async function sendEmail(to, subject, message) {
        await loadSMTPConfig();
        
        if (!smtpConfig) {
            throw new Error('SMTP is not configured. Please contact the administrator.');
        }
        
        const recipientEmail = smtpConfig.recipientEmail || smtpConfig.fromEmail || 'info@ligenpower.com';
        
        const response = await fetch('api/send-email.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                to: recipientEmail,
                subject: subject,
                message: message,
                config: smtpConfig
            })
        });
        
        const result = await response.json();
        
        if (!result.success) {
            throw new Error(result.message || 'Failed to send email');
        }
        
        return result;
    }
    
    // Handle contact form
    function handleContactForm(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]') || form.querySelector('input[type="submit"]');
        const originalText = submitBtn ? submitBtn.textContent || submitBtn.value : 'Submit';
        
        if (submitBtn) {
            submitBtn.disabled = true;
            if (submitBtn.textContent !== undefined) {
                submitBtn.textContent = 'Sending...';
            } else {
                submitBtn.value = 'Sending...';
            }
        }
        
        const formData = new FormData(form);
        const data = {
            name: formData.get('name') || formData.get('contact-name') || '',
            email: formData.get('email') || formData.get('contact-email') || '',
            phone: formData.get('phone') || formData.get('contact-phone') || '',
            subject: formData.get('subject') || formData.get('contact-subject') || 'Contact Form Inquiry',
            message: formData.get('message') || formData.get('contact-message') || ''
        };
        
        const emailSubject = `Contact Form: ${data.subject}`;
        const emailBody = `
            <h2>New Contact Form Submission</h2>
            <p><strong>Name:</strong> ${data.name}</p>
            <p><strong>Email:</strong> ${data.email}</p>
            <p><strong>Phone:</strong> ${data.phone}</p>
            <p><strong>Subject:</strong> ${data.subject}</p>
            <p><strong>Message:</strong><br>${data.message.replace(/\n/g, '<br>')}</p>
            <hr>
            <p><small>Submitted on: ${new Date().toLocaleString()}</small></p>
        `;
        
        sendEmail(null, emailSubject, emailBody)
            .then(() => {
                alert('Thank you! Your message has been sent successfully. We will contact you soon.');
                form.reset();
            })
            .catch(error => {
                alert('Failed to send message: ' + error.message);
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    if (submitBtn.textContent !== undefined) {
                        submitBtn.textContent = originalText;
                    } else {
                        submitBtn.value = originalText;
                    }
                }
            });
    }
    
    // Handle suggestions/grievances form
    function handleGrievancesForm(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]') || form.querySelector('input[type="submit"]');
        const originalText = submitBtn ? submitBtn.textContent || submitBtn.value : 'Submit';
        
        if (submitBtn) {
            submitBtn.disabled = true;
            if (submitBtn.textContent !== undefined) {
                submitBtn.textContent = 'Sending...';
            } else {
                submitBtn.value = 'Sending...';
            }
        }
        
        const formData = new FormData(form);
        const data = {
            feedbackType: formData.get('feedback_type') || formData.get('feedback-type') || '',
            name: formData.get('name') || '',
            email: formData.get('email') || '',
            phone: formData.get('phone') || '',
            subject: formData.get('subject') || '',
            message: formData.get('message') || ''
        };
        
        const emailSubject = `${data.feedbackType}: ${data.subject}`;
        const emailBody = `
            <h2>New ${data.feedbackType}</h2>
            <p><strong>Type:</strong> ${data.feedbackType}</p>
            <p><strong>Name:</strong> ${data.name}</p>
            <p><strong>Email:</strong> ${data.email}</p>
            <p><strong>Phone:</strong> ${data.phone}</p>
            <p><strong>Subject:</strong> ${data.subject}</p>
            <p><strong>Message:</strong><br>${data.message.replace(/\n/g, '<br>')}</p>
            <hr>
            <p><small>Submitted on: ${new Date().toLocaleString()}</small></p>
        `;
        
        sendEmail(null, emailSubject, emailBody)
            .then(() => {
                alert('Thank you! Your ${data.feedbackType.toLowerCase()} has been submitted successfully. We will review it and get back to you soon.');
                form.reset();
            })
            .catch(error => {
                alert('Failed to submit: ' + error.message);
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    if (submitBtn.textContent !== undefined) {
                        submitBtn.textContent = originalText;
                    } else {
                        submitBtn.value = originalText;
                    }
                }
            });
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    function init() {
        // Find contact form
        const contactForm = document.querySelector('form[action*="contact"], form#contact-form, form:has(input[name="contact-name"])');
        if (contactForm && !contactForm.dataset.handlerAttached) {
            contactForm.addEventListener('submit', handleContactForm);
            contactForm.dataset.handlerAttached = 'true';
        }
        
        // Find suggestions/grievances form
        const grievancesForm = document.querySelector('form:has(select[name="feedback_type"]), form:has(select[name="feedback-type"])');
        if (grievancesForm && !grievancesForm.dataset.handlerAttached) {
            grievancesForm.addEventListener('submit', handleGrievancesForm);
            grievancesForm.dataset.handlerAttached = 'true';
        }
        
        // Find solar street light form
        const solarForm = document.querySelector('#contact-form form, section#contact-form form');
        if (solarForm && !solarForm.dataset.handlerAttached) {
            solarForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(e.target);
                const data = {
                    name: formData.get('name') || '',
                    email: formData.get('email') || '',
                    phone: formData.get('phone') || '',
                    message: formData.get('message') || ''
                };
                
                const emailSubject = 'Quote Request: Solar Street Light';
                const emailBody = `
                    <h2>New Quote Request - Solar Street Light</h2>
                    <p><strong>Name:</strong> ${data.name}</p>
                    <p><strong>Email:</strong> ${data.email}</p>
                    <p><strong>Phone:</strong> ${data.phone}</p>
                    <p><strong>Message:</strong><br>${data.message.replace(/\n/g, '<br>')}</p>
                    <hr>
                    <p><small>Submitted on: ${new Date().toLocaleString()}</small></p>
                `;
                
                sendEmail(null, emailSubject, emailBody)
                    .then(() => {
                        alert('Thank you! Your quote request has been submitted successfully. We will contact you soon.');
                        e.target.reset();
                    })
                    .catch(error => {
                        alert('Failed to send request: ' + error.message);
                    });
            });
            solarForm.dataset.handlerAttached = 'true';
        }
    }
})();

