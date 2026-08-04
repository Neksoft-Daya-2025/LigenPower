{{-- Emoji-based Smart Chatbot Component --}}
<div id="chatbot-container" class="chatbot-container">
    <div id="chatbot-toggle" class="chatbot-toggle">
        <div id="chatbot-emoji" class="chatbot-emoji">🤖</div>
        <div class="chatbot-pulse"></div>
    </div>
    
    <div id="chatbot-window" class="chatbot-window">
        <div class="chatbot-header">
            <div class="chatbot-title">
                <span id="chatbot-title-emoji">🤖</span>
                <span id="chatbot-title-text">Form Helper</span>
            </div>
            <button id="chatbot-close" class="chatbot-close">×</button>
        </div>
        
        <div id="chatbot-messages" class="chatbot-messages">
            <div class="chatbot-message bot-message">
                <div class="message-emoji">👋</div>
                <div class="message-content">
                    <p>Hi! I'm your form helper! I'll guide you through the dealer/distributor form step by step. Just hover over me to see my emotions! 😊</p>
                </div>
            </div>
        </div>
        
        <div class="chatbot-helper-actions">
            <button id="helper-instructions" class="helper-btn">📚 Instructions</button>
            <button id="helper-next-step" class="helper-btn">➡️ Next Step</button>
            <button id="helper-help" class="helper-btn">❓ Help</button>
        </div>
    </div>
</div>

<style>
.chatbot-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.chatbot-toggle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #8bab4c, #6b8a2e);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(139, 171, 76, 0.4);
    transition: all 0.3s ease;
    position: relative;
    border: 3px solid #fff;
}

.chatbot-toggle:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 25px rgba(139, 171, 76, 0.6);
}

.chatbot-emoji {
    font-size: 24px;
    transition: all 0.3s ease;
    animation: bounce 2s infinite;
}

.chatbot-pulse {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: rgba(139, 171, 76, 0.3);
    animation: pulse 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-5px);
    }
    60% {
        transform: translateY(-3px);
    }
}

@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    100% {
        transform: scale(1.4);
        opacity: 0;
    }
}

.chatbot-window {
    position: absolute;
    bottom: 80px;
    right: 0;
    width: 350px;
    height: 500px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    display: none;
    flex-direction: column;
    overflow: hidden;
    border: 2px solid #8bab4c;
}

.chatbot-window.show {
    display: flex;
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.chatbot-header {
    background: linear-gradient(135deg, #8bab4c, #6b8a2e);
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chatbot-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
}

.chatbot-title-emoji {
    font-size: 20px;
    transition: all 0.3s ease;
}

.chatbot-close {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.chatbot-close:hover {
    background: rgba(255, 255, 255, 0.2);
}

.chatbot-messages {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: #f8f9fa;
}

.chatbot-message {
    display: flex;
    margin-bottom: 15px;
    animation: messageSlide 0.3s ease;
}

@keyframes messageSlide {
    from {
        opacity: 0;
        transform: translateX(-10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.bot-message {
    justify-content: flex-start;
}

.user-message {
    justify-content: flex-end;
}

.message-emoji {
    font-size: 24px;
    margin-right: 10px;
    transition: all 0.3s ease;
    animation: emojiBounce 0.5s ease;
}

.user-message .message-emoji {
    margin-right: 0;
    margin-left: 10px;
    order: 2;
}

@keyframes emojiBounce {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
    }
}

.message-content {
    background: white;
    padding: 12px 16px;
    border-radius: 18px;
    max-width: 80%;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    position: relative;
}

.user-message .message-content {
    background: #8bab4c;
    color: white;
}

.message-content p {
    margin: 0;
    font-size: 14px;
    line-height: 1.4;
}

.chatbot-helper-actions {
    padding: 15px;
    background: white;
    border-top: 1px solid #e9ecef;
    display: flex;
    gap: 8px;
    justify-content: space-around;
}

.helper-btn {
    background: #8bab4c;
    color: white;
    border: none;
    border-radius: 15px;
    padding: 8px 12px;
    cursor: pointer;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    flex: 1;
    max-width: 100px;
}

.helper-btn:hover {
    background: #6b8a2e;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(139, 171, 76, 0.3);
}

.helper-btn:active {
    transform: translateY(0);
}

/* Emotion States with Advanced Animations */
.chatbot-container.happy .chatbot-emoji,
.chatbot-container.happy .chatbot-title-emoji {
    animation: happyBounce 0.6s ease-in-out;
}

.chatbot-container.sad .chatbot-emoji,
.chatbot-container.sad .chatbot-title-emoji {
    animation: sadShake 0.8s ease-in-out;
}

.chatbot-container.angry .chatbot-emoji,
.chatbot-container.angry .chatbot-title-emoji {
    animation: angryShake 0.5s ease-in-out infinite;
}

.chatbot-container.frustrated .chatbot-emoji,
.chatbot-container.frustrated .chatbot-title-emoji {
    animation: frustratedWiggle 0.4s ease-in-out infinite;
}

.chatbot-container.excited .chatbot-emoji,
.chatbot-container.excited .chatbot-title-emoji {
    animation: excitedJump 0.3s ease-in-out infinite;
}

.chatbot-container.thinking .chatbot-emoji,
.chatbot-container.thinking .chatbot-title-emoji {
    animation: thinkingRotate 2s ease-in-out infinite;
}

.chatbot-container.celebrating .chatbot-emoji,
.chatbot-container.celebrating .chatbot-title-emoji {
    animation: celebratingSpin 1s ease-in-out;
}

.chatbot-container.worried .chatbot-emoji,
.chatbot-container.worried .chatbot-title-emoji {
    animation: worriedTremble 0.3s ease-in-out infinite;
}

/* Advanced Animation Keyframes */
@keyframes happyBounce {
    0%, 100% { transform: scale(1) rotate(0deg); }
    25% { transform: scale(1.1) rotate(-5deg); }
    50% { transform: scale(1.2) rotate(0deg); }
    75% { transform: scale(1.1) rotate(5deg); }
}

@keyframes sadShake {
    0%, 100% { transform: translateX(0) rotate(0deg); }
    25% { transform: translateX(-2px) rotate(-2deg); }
    50% { transform: translateX(2px) rotate(2deg); }
    75% { transform: translateX(-1px) rotate(-1deg); }
}

@keyframes angryShake {
    0%, 100% { transform: translateX(0) scale(1); }
    25% { transform: translateX(-3px) scale(1.1); }
    50% { transform: translateX(3px) scale(1.1); }
    75% { transform: translateX(-2px) scale(1.05); }
}

@keyframes frustratedWiggle {
    0%, 100% { transform: rotate(0deg) scale(1); }
    25% { transform: rotate(-10deg) scale(1.05); }
    50% { transform: rotate(10deg) scale(1.05); }
    75% { transform: rotate(-5deg) scale(1.02); }
}

@keyframes excitedJump {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-8px) scale(1.1); }
}

@keyframes thinkingRotate {
    0% { transform: rotate(0deg) scale(1); }
    25% { transform: rotate(90deg) scale(1.05); }
    50% { transform: rotate(180deg) scale(1.1); }
    75% { transform: rotate(270deg) scale(1.05); }
    100% { transform: rotate(360deg) scale(1); }
}

@keyframes celebratingSpin {
    0% { transform: rotate(0deg) scale(1); }
    25% { transform: rotate(90deg) scale(1.2); }
    50% { transform: rotate(180deg) scale(1.3); }
    75% { transform: rotate(270deg) scale(1.2); }
    100% { transform: rotate(360deg) scale(1); }
}

@keyframes worriedTremble {
    0%, 100% { transform: translateX(0) translateY(0); }
    25% { transform: translateX(-1px) translateY(-1px); }
    50% { transform: translateX(1px) translateY(1px); }
    75% { transform: translateX(-1px) translateY(1px); }
}

/* Enhanced hover effects */
.chatbot-toggle:hover .chatbot-emoji {
    animation: hoverPulse 0.5s ease-in-out infinite;
}

@keyframes hoverPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Special effects for different emotions */
.chatbot-container.celebrating .chatbot-toggle {
    animation: celebrationGlow 1s ease-in-out;
}

@keyframes celebrationGlow {
    0%, 100% { box-shadow: 0 4px 20px rgba(139, 171, 76, 0.4); }
    50% { box-shadow: 0 8px 30px rgba(139, 171, 76, 0.8), 0 0 20px rgba(255, 215, 0, 0.5); }
}

.chatbot-container.angry .chatbot-toggle {
    animation: angryGlow 0.5s ease-in-out infinite;
}

@keyframes angryGlow {
    0%, 100% { box-shadow: 0 4px 20px rgba(220, 53, 69, 0.4); }
    50% { box-shadow: 0 6px 25px rgba(220, 53, 69, 0.8); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .chatbot-window {
        width: 300px;
        height: 400px;
    }
    
    .chatbot-container {
        bottom: 15px;
        right: 15px;
    }
}

@media (max-width: 480px) {
    .chatbot-window {
        width: calc(100vw - 30px);
        right: -10px;
    }
}
</style>

<script>
class SmartChatbot {
    constructor() {
        this.container = document.getElementById('chatbot-container');
        this.toggle = document.getElementById('chatbot-toggle');
        this.window = document.getElementById('chatbot-window');
        this.emoji = document.getElementById('chatbot-emoji');
        this.titleEmoji = document.getElementById('chatbot-title-emoji');
        this.titleText = document.getElementById('chatbot-title-text');
        this.messages = document.getElementById('chatbot-messages');
        this.closeBtn = document.getElementById('chatbot-close');
        this.instructionsBtn = document.getElementById('helper-instructions');
        this.nextStepBtn = document.getElementById('helper-next-step');
        this.helpBtn = document.getElementById('helper-help');
        
        this.currentEmotion = 'happy';
        this.isOpen = false;
        this.formFields = this.getFormFields();
        this.currentStep = 0;
        this.formSteps = this.getFormSteps();
        
        this.init();
    }
    
    init() {
        this.toggle.addEventListener('click', () => this.toggleWindow());
        this.closeBtn.addEventListener('click', () => this.closeWindow());
        this.instructionsBtn.addEventListener('click', () => this.showInstructions());
        this.nextStepBtn.addEventListener('click', () => this.guideToNextStep());
        this.helpBtn.addEventListener('click', () => this.showHelp());
        
        // Mouse hover effects
        this.toggle.addEventListener('mouseenter', () => this.onHover());
        this.toggle.addEventListener('mouseleave', () => this.onLeave());
        
        // Advanced mouse interactions
        this.toggle.addEventListener('mousemove', (e) => this.onMouseMove(e));
        this.toggle.addEventListener('click', () => this.onClick());
        
        // Monitor mouse position for emotion changes
        this.monitorMousePosition();
        
        // Form field monitoring
        this.monitorFormFields();
        
        // Start with welcome message
        this.setEmotion('happy');
        this.addMessage('bot', '👋', 'Hey there! I\'m your form helper! 🤖✨ I\'ll guide you through this dealer/distributor form step by step. Use the buttons below to get instructions, next steps, or help!');
        
        // Add proactive guidance messages
        this.addProactiveGuidance();
    }
    
    getFormFields() {
        return {
            business_name: { required: true, type: 'text', label: 'Business Name' },
            contact_person: { required: true, type: 'text', label: 'Contact Person' },
            email: { required: false, type: 'email', label: 'Email Address' },
            type: { required: true, type: 'select', label: 'Type (Dealer/Distributor)' },
            phone: { required: true, type: 'tel', label: 'Phone Number' },
            alternate_phone: { required: false, type: 'tel', label: 'Alternate Phone' },
            address: { required: true, type: 'textarea', label: 'Address' },
            state_id: { required: true, type: 'select', label: 'State' },
            district_id: { required: true, type: 'select', label: 'District/City' },
            pincode: { required: true, type: 'text', label: 'Pincode' },
            gst_number: { required: false, type: 'text', label: 'GST Number' },
            pan_number: { required: false, type: 'text', label: 'PAN Number' },
            website: { required: false, type: 'text', label: 'Website' },
            status: { required: true, type: 'select', label: 'Status' },
            business_description: { required: false, type: 'textarea', label: 'Business Description' }
        };
    }
    
    getFormSteps() {
        return [
            { fields: ['business_name', 'contact_person'], message: 'Let\'s start with the basic business information! 📝' },
            { fields: ['email', 'type'], message: 'Now let\'s add contact details and business type! 📧' },
            { fields: ['phone', 'alternate_phone'], message: 'Time for phone numbers! 📞' },
            { fields: ['address'], message: 'Where is your business located? 🏢' },
            { fields: ['state_id', 'district_id', 'pincode'], message: 'Let\'s specify the exact location! 🗺️' },
            { fields: ['gst_number', 'pan_number'], message: 'Any tax registration numbers? 💼' },
            { fields: ['website', 'status'], message: 'Almost done! Website and status! 🌐' },
            { fields: ['business_description'], message: 'Final step - tell us about your business! ✨' }
        ];
    }
    
    toggleWindow() {
        this.isOpen = !this.isOpen;
        if (this.isOpen) {
            this.window.classList.add('show');
            this.input.focus();
        } else {
            this.window.classList.remove('show');
        }
    }
    
    closeWindow() {
        this.isOpen = false;
        this.window.classList.remove('show');
    }
    
    onHover() {
        const emotions = ['happy', 'excited', 'thinking'];
        const randomEmotion = emotions[Math.floor(Math.random() * emotions.length)];
        this.setEmotion(randomEmotion);
    }
    
    onLeave() {
        this.setEmotion('happy');
    }
    
    onMouseMove(e) {
        const rect = this.toggle.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        
        const deltaX = e.clientX - centerX;
        const deltaY = e.clientY - centerY;
        const distance = Math.sqrt(deltaX * deltaX + deltaY * deltaY);
        
        // Change emotion based on mouse position relative to center
        if (distance < 15) {
            this.setEmotion('excited');
        } else if (deltaX > 0) {
            this.setEmotion('happy');
        } else {
            this.setEmotion('thinking');
        }
    }
    
    onClick() {
        this.setEmotion('celebrating');
        setTimeout(() => {
            if (!this.isOpen) {
                this.setEmotion('happy');
            }
        }, 1000);
    }
    
    monitorMousePosition() {
        let mouseX = 0;
        let mouseY = 0;
        let lastEmotionChange = 0;
        
        document.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
            
            // Only change emotion based on mouse position occasionally
            const now = Date.now();
            if (now - lastEmotionChange > 2000) { // Change every 2 seconds max
                const rect = this.toggle.getBoundingClientRect();
                const distance = Math.sqrt(
                    Math.pow(mouseX - (rect.left + rect.width / 2), 2) + 
                    Math.pow(mouseY - (rect.top + rect.height / 2), 2)
                );
                
                if (distance < 100) {
                    const emotions = ['excited', 'happy', 'thinking'];
                    const randomEmotion = emotions[Math.floor(Math.random() * emotions.length)];
                    this.setEmotion(randomEmotion);
                    lastEmotionChange = now;
                }
            }
        });
    }
    
    setEmotion(emotion) {
        this.currentEmotion = emotion;
        this.container.className = `chatbot-container ${emotion}`;
        
        const emojiMap = {
            happy: '😊',
            sad: '😢',
            angry: '😠',
            frustrated: '😤',
            excited: '🤩',
            thinking: '🤔',
            celebrating: '🎉',
            worried: '😰'
        };
        
        this.emoji.textContent = emojiMap[emotion] || '🤖';
        this.titleEmoji.textContent = emojiMap[emotion] || '🤖';
    }
    
    addMessage(sender, emoji, message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chatbot-message ${sender}-message`;
        
        messageDiv.innerHTML = `
            <div class="message-emoji">${emoji}</div>
            <div class="message-content">
                <p>${message}</p>
            </div>
        `;
        
        this.messages.appendChild(messageDiv);
        this.messages.scrollTop = this.messages.scrollHeight;
    }
    
    showHelp() {
        this.setEmotion('excited');
        this.addMessage('bot', '🤩', 'I\'m here to help you with the form! Here\'s what I can do:');
        this.addMessage('bot', '📝', '• Guide you through each step of the form');
        this.addMessage('bot', '😊', '• Explain what each field is for');
        this.addMessage('bot', '😠', '• Get dramatic if you make mistakes');
        this.addMessage('bot', '🎉', '• Celebrate when you do things right');
        this.addMessage('bot', '🤖', '• Change emotions based on your mouse');
        this.addMessage('bot', '✨', '• Provide helpful tips and instructions');
    }
    
    monitorFormFields() {
        Object.keys(this.formFields).forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field) {
                field.addEventListener('focus', () => this.onFieldFocus(fieldName));
                field.addEventListener('blur', () => this.onFieldBlur(fieldName));
                field.addEventListener('input', () => this.onFieldInput(fieldName));
                field.addEventListener('change', () => this.onFieldChange(fieldName));
            }
        });
        
        // Monitor form submission
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', (e) => this.onFormSubmit(e));
        }
        
        // Monitor validation errors
        this.monitorValidationErrors();
    }
    
    onFieldFocus(fieldName) {
        const fieldInfo = this.formFields[fieldName];
        if (fieldInfo) {
            this.setEmotion('excited');
            const focusMessages = [
                `🤩 Ooh, ${fieldInfo.label}! My favorite! ${this.getFieldHelp(fieldName)}`,
                `😊 Nice choice! ${fieldInfo.label} is a good one. ${this.getFieldHelp(fieldName)}`,
                `✨ Ah, ${fieldInfo.label}! Let me help you with this one. ${this.getFieldHelp(fieldName)}`,
                `🎯 ${fieldInfo.label} - excellent! ${this.getFieldHelp(fieldName)}`
            ];
            this.addMessage('bot', '🤩', focusMessages[Math.floor(Math.random() * focusMessages.length)]);
        }
    }
    
    onFieldBlur(fieldName) {
        const field = document.getElementById(fieldName);
        if (field && field.value.trim() === '' && this.formFields[fieldName].required) {
            this.setEmotion('worried');
            const worryMessages = [
                `😰 Wait, wait, WAIT! You forgot ${this.formFields[fieldName].label} - it's required! Don't leave me hanging!`,
                `😟 Oh no! ${this.formFields[fieldName].label} is empty! I'm getting anxious over here! Please fill it in!`,
                `😰 Hey! ${this.formFields[fieldName].label} is missing! I can't let you submit an incomplete form - I have standards!`,
                `😟 Umm... ${this.formFields[fieldName].label}? Hello? Are you there? It's required, you know!`
            ];
            this.addMessage('bot', '😰', worryMessages[Math.floor(Math.random() * worryMessages.length)]);
        }
    }
    
    onFieldInput(fieldName) {
        const field = document.getElementById(fieldName);
        if (field && field.value.trim() !== '') {
            this.setEmotion('happy');
            // Only show success message occasionally to avoid spam
            if (Math.random() < 0.3) {
                const successMessages = [
                    `😊 Nice! ${this.formFields[fieldName].label} looks good! You're doing great!`,
                    `✨ Perfect! ${this.formFields[fieldName].label} is looking fabulous!`,
                    `🎉 Excellent! ${this.formFields[fieldName].label} is spot on!`,
                    `😄 Awesome! ${this.formFields[fieldName].label} is coming along nicely!`,
                    `🤩 Great job! ${this.formFields[fieldName].label} is looking professional!`
                ];
                this.addMessage('bot', '😊', successMessages[Math.floor(Math.random() * successMessages.length)]);
            }
        }
    }
    
    onFieldChange(fieldName) {
        const field = document.getElementById(fieldName);
        if (field) {
            // Special handling for state selection
            if (fieldName === 'state_id' && field.value) {
                this.setEmotion('excited');
                this.addMessage('bot', '🤩', '🎉 Ooh, state selected! Now watch the magic happen - the district dropdown will populate like a beautiful cascade! Select your district next! ✨');
            }
            // Special handling for type selection
            else if (fieldName === 'type' && field.value) {
                const typeText = field.value === 'dealer' ? 'Dealer' : 'Distributor';
                this.setEmotion('happy');
                const typeMessages = [
                    `😊 Perfect! You've selected ${typeText}! This helps customers understand your business type - very professional!`,
                    `🎯 Excellent choice! ${typeText} it is! Now customers will know exactly what you do!`,
                    `✨ Great! ${typeText} - I love it when people know their business model!`,
                    `🤩 Awesome! ${typeText} is a solid choice! Your customers will appreciate the clarity!`
                ];
                this.addMessage('bot', '😊', typeMessages[Math.floor(Math.random() * typeMessages.length)]);
            }
        }
    }
    
    onFormSubmit(e) {
        this.setEmotion('thinking');
        this.addMessage('bot', '🤔', '🕵️‍♀️ Hold on! Let me inspect this form like a detective... *puts on magnifying glass* Checking everything looks good!');
        
        // Check for empty required fields
        const emptyRequiredFields = [];
        Object.keys(this.formFields).forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field && this.formFields[fieldName].required && !field.value.trim()) {
                emptyRequiredFields.push(this.formFields[fieldName].label);
            }
        });
        
        if (emptyRequiredFields.length > 0) {
            e.preventDefault();
            this.setEmotion('angry');
            const angryMessages = [
                `😠 STOP RIGHT THERE! You're missing: ${emptyRequiredFields.join(', ')}! I can't let you submit this incomplete form - I have a reputation to maintain!`,
                `😤 NOPE! Not happening! You forgot: ${emptyRequiredFields.join(', ')}! Fill them in first, then we'll talk about submission!`,
                `😡 Are you kidding me? ${emptyRequiredFields.join(', ')} are missing! I'm not letting this form go anywhere until it's perfect!`,
                `🤬 Hold your horses! You're missing: ${emptyRequiredFields.join(', ')}! Complete the form properly first!`
            ];
            this.addMessage('bot', '😠', angryMessages[Math.floor(Math.random() * angryMessages.length)]);
            return false;
        }
        
        this.setEmotion('celebrating');
        this.addMessage('bot', '🎉', '🎊 FANTASTIC! Everything looks perfect! Your form is being submitted! I\'m so proud of you! 🚀✨');
    }
    
    monitorValidationErrors() {
        // Check for existing validation errors on page load
        setTimeout(() => {
            const errorElements = document.querySelectorAll('.is-invalid, .invalid-feedback');
            if (errorElements.length > 0) {
                this.setEmotion('angry');
                const errorMessages = [
                    '😠 OH NO! I see red fields everywhere! There are validation errors! Let me help you fix them - click on the red fields to see what needs to be corrected!',
                    '😤 Ugh! Validation errors detected! I\'m getting frustrated just looking at them! Click on those red fields and let\'s fix this mess!',
                    '😡 Seriously? Validation errors? I thought we were better than this! Click on the red fields and let\'s get this sorted!',
                    '🤬 What is this chaos? Validation errors everywhere! Click on those red fields and let\'s clean this up!'
                ];
                this.addMessage('bot', '😠', errorMessages[Math.floor(Math.random() * errorMessages.length)]);
            }
        }, 1000);
    }
    
    getFieldHelp(fieldName) {
        const helpMessages = {
            business_name: '🏢 This is your business\'s official name - the one that appears on your business card! Make it count!',
            contact_person: '👤 Who should customers ask for? The owner? Manager? The person who actually answers the phone?',
            email: '📧 Optional but super helpful! Customers can reach you without calling. Make sure it\'s real!',
            type: '🤔 Are you a Dealer (sell to customers) or Distributor (supply to dealers)? Choose wisely!',
            phone: '📞 Your main business number - the one customers will call! Make sure it works!',
            alternate_phone: '📱 Backup phone number (optional) - for when the main one is busy!',
            address: '🏠 Complete business address - street, area, landmarks. Don\'t just say "near the big tree"!',
            state_id: '🗺️ Pick your state from the dropdown - this is important for location!',
            district_id: '🏙️ Choose your district/city (magically appears after you select state)!',
            pincode: '📮 Your area\'s postal code - helps with delivery and location!',
            gst_number: '💼 GST registration number (optional) - shows you\'re legit!',
            pan_number: '🆔 PAN card number (optional) - another way to prove you\'re real!',
            website: '🌐 Your business website (optional) - like a digital business card!',
            status: '🎯 Active = visible to customers, Inactive = hidden. Choose your visibility!',
            business_description: '📝 Tell your story! What do you do? Why should customers choose you?'
        };
        
        return helpMessages[fieldName] || '🤷‍♀️ Fill this field carefully - I\'m watching!';
    }
    
    guideToNextStep() {
        const nextStep = this.formSteps[this.currentStep];
        if (nextStep) {
            this.setEmotion('excited');
            const stepMessages = [
                `🤩 ${nextStep.message} Let's do this!`,
                `✨ ${nextStep.message} I believe in you!`,
                `🎯 ${nextStep.message} You've got this!`,
                `🚀 ${nextStep.message} Time to shine!`
            ];
            this.addMessage('bot', '🤩', stepMessages[Math.floor(Math.random() * stepMessages.length)]);
            this.addMessage('bot', '📝', `Focus on these fields: ${nextStep.fields.map(f => this.formFields[f].label).join(', ')}`);
            this.currentStep = Math.min(this.currentStep + 1, this.formSteps.length - 1);
        } else {
            this.setEmotion('celebrating');
            this.addMessage('bot', '🎉', '🎊 CONGRATULATIONS! You\'ve completed all the steps! I\'m so proud of you! Review your form and submit when ready! 🚀✨');
        }
    }
    
    helpWithCurrentField() {
        this.setEmotion('thinking');
        const helpMessages = [
            '🤔 I can help you with any field! Which specific field is giving you trouble?',
            '🤷‍♀️ Field help? I\'m your go-to expert! What field do you need assistance with?',
            '😊 Need field guidance? I\'m here to help! Which field is confusing you?',
            '🤖 Field assistance at your service! What field do you want to know about?'
        ];
        this.addMessage('bot', '🤔', helpMessages[Math.floor(Math.random() * helpMessages.length)]);
    }
    
    showInstructions() {
        this.setEmotion('excited');
        this.addMessage('bot', '📚', '📖 Here\'s how to use me like a pro:');
        this.addMessage('bot', '🎯', '1. Hover over me to see my emotions change!');
        this.addMessage('bot', '💬', '2. Ask me about any form field - I\'ll explain it!');
        this.addMessage('bot', '🤖', '3. I\'ll guide you step by step through the form!');
        this.addMessage('bot', '😠', '4. I\'ll get dramatic if you make mistakes!');
        this.addMessage('bot', '🎉', '5. I\'ll celebrate when you do things right!');
        this.addMessage('bot', '😄', '6. Ask me for jokes, compliments, or just chat!');
        this.addMessage('bot', '✨', '7. I\'m always here to help - just ask!');
    }
    
    // Method to show validation errors
    showValidationError(fieldName, errorMessage) {
        this.setEmotion('angry');
        this.addMessage('bot', '😠', `Oops! There's an issue with ${this.formFields[fieldName].label}: ${errorMessage}`);
    }
    
    // Method to celebrate successful submission
    celebrateSuccess() {
        this.setEmotion('celebrating');
        this.addMessage('bot', '🎉', 'Fantastic! Your form has been submitted successfully! Great job! 🎊');
    }
    
    // Add proactive guidance messages
    addProactiveGuidance() {
        // Give initial guidance after 3 seconds
        setTimeout(() => {
            this.addMessage('bot', '📚', 'Let me give you a quick overview of what we\'ll be filling out:');
            this.addMessage('bot', '🏢', '• Business information (name, contact person, type)');
            this.addMessage('bot', '📞', '• Contact details (phone, email, address)');
            this.addMessage('bot', '🗺️', '• Location (state, district, pincode)');
            this.addMessage('bot', '💼', '• Business details (GST, PAN, website, description)');
            this.addMessage('bot', '✨', 'Ready to start? Click "Next Step" or focus on any field!');
        }, 3000);
        
        // Add random helpful tips
        setTimeout(() => {
            if (Math.random() < 0.4) { // 40% chance
                const tips = [
                    '💡 Tip: Hover over me to see my emotions change!',
                    '🎯 Tip: I\'ll guide you step by step - just follow my messages!',
                    '😊 Tip: Don\'t worry about mistakes - I\'ll help you fix them!',
                    '🤖 Tip: I change emotions based on what you\'re doing!',
                    '✨ Tip: Use the buttons below for quick help!'
                ];
                const randomTip = tips[Math.floor(Math.random() * tips.length)];
                this.addMessage('bot', '💡', randomTip);
            }
        }, 8000);
    }
}

// Initialize chatbot when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new SmartChatbot();
});
</script>
