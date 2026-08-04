// Chatbot functionality
(function() {
    'use strict';

    // Chatbot configuration
    const chatbotConfig = {
        welcomeMessage: "Hello! 👋 Welcome to Ligen Power®. I'm your intelligent assistant with comprehensive information about all our products, services, and company details. I can help you with:\n\n• Product information (Inverters, BMS, Batteries, Solar Solutions, E-Cycles)\n• Specifications and models\n• Pricing and quotations\n• Contact information\n• Warranty registration\n• Working hours\n• Dealer programs\n• Website and social media links\n• External information access\n• And much more!\n\nWhat would you like to know?",
        placeholder: "Ask me anything or request web information...",
        companyName: "Ligen Power®",
        supportEmail: "info@ligenpower.com",
        supportPhone: "+91-9031086082"
    };

    // Comprehensive product and company information
    const productInfo = {
        powerInverters: {
            name: "Power Inverters",
            description: "Pure Sine Wave Inverters with integrated Li-Ion Battery technology",
            models: [
                "Ligen Power®-300 (300VA)",
                "Ligen Power®-600 (600VA)",
                "Ligen Power®-600s (600VA)",
                "Ligen Power®-850 (850VA)",
                "Ligen Power®-1000 (1000VA)",
                "Ligen Power®-1500 (1500VA)",
                "Ligen Power®-2000 (2000VA)",
                "Ligen Power®-3500 (3500VA)",
                "Ligen Power®-5000 (5000VA)"
            ],
            features: "Pure sine wave output, Li-Ion battery integrated, high efficiency, compact design, patented technology"
        },
        bms: {
            name: "Battery Management System (BMS)",
            description: "Advanced BMS for Lithium-ion batteries ensuring safety, longevity, and optimal performance",
            models: [
                "BMS 1S",
                "BMS 2S",
                "BMS 3S",
                "BMS 4S",
                "BMS 8S",
                "BMS 10S",
                "BMS 12S",
                "BMS 16S"
            ],
            features: "Cell balancing, overcharge/over-discharge protection, temperature monitoring, short circuit protection, patented technology"
        },
        powerBatteries: {
            name: "Power Batteries",
            description: "Lithium Iron Phosphate (LFP) batteries for various applications",
            models: [
                "12V 100Ah LFP Battery",
                "24V 30Ah LFP Battery",
                "36V 15Ah LFP Battery",
                "48V 50Ah LFP Battery",
                "48V 100Ah LFP Battery"
            ],
            features: "Long cycle life, high energy density, safe operation, fast charging, maintenance-free"
        },
        solarPCU: {
            name: "Solar PCU (MPPT)",
            description: "Maximum Power Point Tracking Solar PCU for efficient solar energy conversion",
            models: [
                "Solar PCU MPPT 2000VA 24V",
                "Solar PCU MPPT 3500VA 48V",
                "Solar PCU MPPT 5000VA 96V"
            ],
            features: "MPPT technology, high efficiency, grid-tie capability, battery charging, load management"
        },
        pwmPCU: {
            name: "PWM PCU",
            description: "Pulse Width Modulation Solar PCU for cost-effective solar solutions",
            models: [
                "Solar PWM PCU 300VA",
                "LIGEN INV 600S PWM",
                "LIGEN INV 850 PWM",
                "LIGEN INV 1000 PWM",
                "LIGEN INV 1500 PWM",
                "LIGEN INV 2000 PWM PCU"
            ],
            features: "Cost-effective, reliable performance, battery charging, load management, easy installation"
        },
        solarStreetLights: {
            name: "Solar Street Lights",
            description: "Hybrid solar street lighting solutions",
            models: [
                "24W Hybrid Street Light",
                "48W Hybrid Street Light"
            ],
            features: "Solar + Grid hybrid, automatic operation, weatherproof, long-lasting LED, motion sensor options"
        },
        eCycle: {
            name: "Electric Cycle (E-Cycle)",
            description: "Electric bicycles powered by Ligen Power® battery technology",
            features: "Long range, powerful motor, removable battery, eco-friendly, smart display"
        }
    };

    const companyInfo = {
        name: "Ligen Power®",
        tagline: "Deep-Tech Powering Sustainability",
        about: "A Deep-Tech Start-up pioneering indigenous technologies to redefine the future of energy. We develop patented Li-Ion Battery Integrated Inverters and BMS, creating innovations in battery safety, longevity, and efficiency.",
        specialties: "BMS, Solar Street Lights, E-Bicycles, Power Back-up Solutions, Solar Power Back-up Solutions, Li-Ion Battery Integrated Inverters, Lithium Battery Packs, and Energy Storage Solutions",
        registeredOffice: "Amossys Portable Power LLP, Shed No-B4-05(FF), B4-06(FF), B4-07(FF) & B4-08(FF), BIADA Industrial Area, Sikandarpur, Bihta, Patna, Bihar - 801103",
        rdCenter: "Amossys Portable Power LLP, 1st Floor, Incubation Center, Indian Institute of Technology, Patna, Amhara Road, BIHTA - 801106, Patna, Bihar",
        workingHours: {
            weekdays: "Monday - Friday: 9:30 am to 6:00 pm",
            saturday: "Bi-weekly (First & Third Saturday): 9:30 am to 6:00 pm",
            sunday: "Closed",
            techSupport: "Technical Support: 9:30 am to 6:00 pm"
        },
        contact: {
            sales: "+91-9031086082",
            support: "+91-9031086083",
            email: "info@ligenpower.com",
            grievances: "grievances@ligenpower.com"
        },
        website: "http://ligenpower.com",
        warranty: "https://warranty.ligenpower.com",
        founded: "2024",
        employees: "11-50 employees"
    };

    // External information sources and APIs
    const externalSources = {
        linkedin: "https://www.linkedin.com/company/ligen-power/",
        facebook: "https://www.facebook.com/ligenpower/",
        instagram: "https://www.instagram.com/ligenpower/",
        youtube: "https://www.youtube.com/watch?v=MJ8viEaiVl0",
        website: "http://ligenpower.com",
        warranty: "https://warranty.ligenpower.com"
    };

    // Get information from external websites
    function getWebInformation(source) {
        const sources = {
            'linkedin': {
                name: 'LinkedIn',
                url: externalSources.linkedin,
                info: 'Our LinkedIn company page with updates, news, and company information. Follow us for latest updates!'
            },
            'facebook': {
                name: 'Facebook',
                url: externalSources.facebook,
                info: 'Our Facebook page with product updates, news, and community engagement.'
            },
            'instagram': {
                name: 'Instagram',
                url: externalSources.instagram,
                info: 'Our Instagram account showcasing our products, behind-the-scenes, and company culture.'
            },
            'youtube': {
                name: 'YouTube',
                url: externalSources.youtube,
                info: 'Our YouTube channel with product demonstrations, tutorials, and company videos.'
            },
            'website': {
                name: 'Official Website',
                url: externalSources.website,
                info: 'Our official website with complete product catalog, specifications, and company information.'
            },
            'warranty': {
                name: 'Warranty Portal',
                url: externalSources.warranty,
                info: 'Register your product warranty and access warranty services online.'
            }
        };

        const sourceInfo = sources[source.toLowerCase()];
        if (sourceInfo) {
            return Promise.resolve({
                name: sourceInfo.name,
                url: sourceInfo.url,
                info: sourceInfo.info,
                available: true
            });
        }
        return Promise.resolve(null);
    }

    // Predefined responses based on keywords
    const responses = {
        greeting: [
            "Hello! 👋 Welcome to Ligen Power®. I'm here to help you with information about our products, services, and company. What would you like to know?",
            "Hi there! I can provide detailed information about our Power Inverters, BMS, Batteries, Solar Solutions, and more. How can I assist you?",
            "Welcome to Ligen Power®! 🚀 I have comprehensive information about all our products and services. What interests you today?"
        ],
        product: [
            `We offer a comprehensive range of energy solutions:

🔋 **Power Inverters**: Pure Sine Wave Inverters (300VA to 5000VA) with integrated Li-Ion technology
⚡ **BMS**: Battery Management Systems (1S to 16S) for optimal battery performance
🔋 **Power Batteries**: LFP Batteries (12V to 48V, various capacities)
☀️ **Solar PCU**: MPPT Solar PCU (2000VA to 5000VA)
⚙️ **PWM PCU**: Cost-effective PWM Solar PCU solutions
💡 **Solar Street Lights**: Hybrid 24W and 48W solutions
🚲 **E-Cycles**: Electric bicycles with Ligen Power® technology

Which product would you like detailed information about?`,
            `Our product portfolio includes:

• **Power Inverters** - 9 models from 300VA to 5000VA
• **BMS** - 8 models from 1S to 16S configurations
• **Power Batteries** - 5 LFP battery models
• **Solar PCU** - 3 MPPT models
• **PWM PCU** - 6 PWM models
• **Solar Street Lights** - 2 hybrid models
• **E-Cycles** - Electric bicycles

All products feature our patented technology. Which one interests you?`
        ],
        powerInverter: [
            `**Power Inverters** - Pure Sine Wave Inverters with Integrated Li-Ion Battery Technology

**Available Models:**
${productInfo.powerInverters.models.map(m => `• ${m}`).join('\n')}

**Key Features:**
• Pure sine wave output for sensitive electronics
• Integrated Li-Ion battery technology
• High efficiency and reliability
• Compact and space-saving design
• Patented indigenous technology

For detailed specifications and datasheets, visit our Resources section or contact sales at ${companyInfo.contact.sales}`,
            `Our **Power Inverters** range from 300VA to 5000VA capacity. They feature:
- Pure sine wave output
- Integrated Li-Ion battery
- High efficiency
- Compact design
- Patented technology

Models available: ${productInfo.powerInverters.models.join(', ')}`
        ],
        bms: [
            `**Battery Management System (BMS)** - Advanced protection and optimization for Lithium-ion batteries

**Available Models:**
${productInfo.bms.models.map(m => `• ${m}`).join('\n')}

**Key Features:**
• Cell balancing for optimal performance
• Overcharge and over-discharge protection
• Temperature monitoring
• Short circuit protection
• Patented indigenous technology

BMS ensures safety, longevity, and optimal performance of your battery packs.`,
            `Our **BMS** systems come in configurations from 1S to 16S. They provide:
- Cell balancing
- Safety protection
- Temperature monitoring
- Optimal battery performance
- Patented technology

Available models: ${productInfo.bms.models.join(', ')}`
        ],
        battery: [
            `**Power Batteries** - Lithium Iron Phosphate (LFP) Batteries

**Available Models:**
${productInfo.powerBatteries.models.map(m => `• ${m}`).join('\n')}

**Key Features:**
• Long cycle life (2000+ cycles)
• High energy density
• Safe operation
• Fast charging capability
• Maintenance-free operation

LFP batteries offer superior safety and longevity compared to traditional lead-acid batteries.`,
            `Our **Power Batteries** are LFP (Lithium Iron Phosphate) type, available in:
- 12V, 24V, 36V, and 48V configurations
- Various capacities from 15Ah to 100Ah
- Long cycle life and high safety
- Fast charging

Models: ${productInfo.powerBatteries.models.join(', ')}`
        ],
        solar: [
            `**Solar Solutions** - Complete solar power backup systems

**Solar PCU (MPPT):**
${productInfo.solarPCU.models.map(m => `• ${m}`).join('\n')}

**PWM PCU:**
${productInfo.pwmPCU.models.map(m => `• ${m}`).join('\n')}

**Solar Street Lights:**
${productInfo.solarStreetLights.models.map(m => `• ${m}`).join('\n')}

**Features:**
• MPPT technology for maximum efficiency
• Grid-tie capability
• Battery charging and load management
• Hybrid operation (Solar + Grid)
• Weatherproof and durable

Which solar solution are you interested in?`,
            `We offer comprehensive **Solar Solutions**:
- MPPT Solar PCU (2000VA to 5000VA)
- PWM Solar PCU (300VA to 2000VA)
- Hybrid Solar Street Lights (24W and 48W)

All feature efficient energy conversion and reliable operation.`
        ],
        ecycle: [
            `**Electric Cycle (E-Cycle)** - Powered by Ligen Power® Battery Technology

**Features:**
• Long range per charge
• Powerful motor for easy riding
• Removable battery for convenient charging
• Eco-friendly transportation
• Smart display for battery and speed monitoring

Experience green mobility with our E-Cycles powered by our advanced battery technology.`,
            `Our **E-Cycles** feature:
- Long battery range
- Powerful motor
- Removable battery
- Eco-friendly design
- Smart display

Powered by Ligen Power®'s advanced battery technology.`
        ],
        price: [
            `For detailed pricing information, please contact our sales team:
📞 Sales: ${companyInfo.contact.sales}
📧 Email: ${companyInfo.contact.email}

We offer competitive pricing and can provide quotes based on your specific requirements.`,
            `To get the best pricing for our products, please reach out to our sales department:
• Phone: ${companyInfo.contact.sales}
• Email: ${companyInfo.contact.email}

We'll provide customized quotes based on your needs.`
        ],
        warranty: [
            `**Warranty Registration:**
Register your product warranty at: ${companyInfo.warranty}

Our products come with comprehensive warranty coverage. Register your product to ensure full warranty benefits.`,
            `You can register your product warranty online at:
🔗 ${companyInfo.warranty}

This ensures you receive full warranty coverage and support.`
        ],
        contact: [
            `**Contact Information:**

📞 **Sales:** ${companyInfo.contact.sales}
📞 **Support:** ${companyInfo.contact.support}
📧 **Email:** ${companyInfo.contact.email}
📧 **Grievances:** ${companyInfo.contact.grievances}

**Registered Office:**
${companyInfo.registeredOffice}

**R&D Center:**
${companyInfo.rdCenter}

**Working Hours:**
${companyInfo.workingHours.weekdays}
${companyInfo.workingHours.saturday}
${companyInfo.workingHours.sunday}
${companyInfo.workingHours.techSupport}`,
            `**Reach Us:**
• Sales: ${companyInfo.contact.sales}
• Support: ${companyInfo.contact.support}
• Email: ${companyInfo.contact.email}
• Address: ${companyInfo.registeredOffice}`
        ],
        dealer: [
            `**Dealer & Distributor Program:**

We're looking for partners to expand our reach! Benefits include:
• Competitive margins
• Marketing support
• Technical training
• Product support

Contact our sales team:
📞 ${companyInfo.contact.sales}
📧 ${companyInfo.contact.email}`,
            `Join our **Dealer/Distributor Network**:
- Competitive pricing
- Marketing support
- Training programs
- Technical assistance

Contact: ${companyInfo.contact.sales} or ${companyInfo.contact.email}`
        ],
        about: [
            `**About Ligen Power®:**

${companyInfo.about}

**Specialties:**
${companyInfo.specialties}

**Founded:** ${companyInfo.founded}
**Company Size:** ${companyInfo.employees}
**Tagline:** ${companyInfo.tagline}

We are committed to creating a greener and more secure energy landscape through indigenous innovation.`,
            `**Ligen Power®** is a Deep-Tech Start-up focused on:
- Indigenous energy technologies
- Patented Li-Ion Battery Integrated Inverters
- Advanced BMS systems
- Sustainable energy solutions

Founded in ${companyInfo.founded}, we're part of Start-Up India, Self-Reliant India, and Make in India initiatives.`
        ],
        workingHours: [
            `**Working Hours:**

${companyInfo.workingHours.weekdays}
${companyInfo.workingHours.saturday}
${companyInfo.workingHours.sunday}

**Technical Support:**
${companyInfo.workingHours.techSupport}`,
            `**Office Hours:**
Monday-Friday: 9:30 am to 6:00 pm
Saturday: Bi-weekly (1st & 3rd), 9:30 am to 6:00 pm
Sunday: Closed

**Tech Support:** 9:30 am to 6:00 pm`
        ],
        grievances: [
            `**Grievance Redressal:**

📧 Email: ${companyInfo.contact.grievances}
📞 Phone: ${companyInfo.contact.support}

**Response Time:** Within 48 hours

**Grievance Officer:**
${companyInfo.registeredOffice}

We are committed to resolving all customer grievances promptly and fairly.`,
            `For **Grievances**, contact:
• Email: ${companyInfo.contact.grievances}
• Phone: ${companyInfo.contact.support}
• Response: Within 48 hours`
        ],
        datasheet: [
            `**Datasheets & Resources:**

You can find detailed datasheets for all our products in the Resources section:
• Power Inverter datasheets
• BMS specifications
• Power Battery datasheets
• Solar PCU datasheets
• PWM PCU datasheets
• Solar Street Light datasheets

Visit our Resources menu or contact us for specific product datasheets.`,
            `**Product Datasheets** are available for:
- All Power Inverter models
- All BMS models
- All Battery models
- All Solar PCU models
- All PWM PCU models
- Solar Street Lights

Check the Resources section on our website.`
        ],
        default: [
            `I'm here to help! I have comprehensive information about:
• All our products (Inverters, BMS, Batteries, Solar Solutions, E-Cycles)
• Company information
• Contact details
• Warranty information
• Dealer programs

For more specific assistance, contact:
📞 ${companyInfo.contact.support}
📧 ${companyInfo.contact.email}`,
            `That's a great question! I can help with product information, specifications, pricing, warranty, and more.

For detailed assistance:
• Support: ${companyInfo.contact.support}
• Email: ${companyInfo.contact.email}`
        ]
    };

    // Create chatbot HTML structure
    function createChatbotHTML() {
        const chatbotHTML = `
            <div id="ligen-chatbot" class="ligen-chatbot-container">
                <div id="ligen-chatbot-button" class="ligen-chatbot-button">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span class="ligen-chatbot-badge">1</span>
                </div>
                <div id="ligen-chatbot-window" class="ligen-chatbot-window">
                    <div class="ligen-chatbot-header">
                        <div class="ligen-chatbot-header-content">
                            <div class="ligen-chatbot-avatar">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="ligen-chatbot-header-text">
                                <h3>${chatbotConfig.companyName}</h3>
                                <span class="ligen-chatbot-status">Online</span>
                            </div>
                        </div>
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <button id="ligen-chatbot-theme-toggle" class="ligen-chatbot-theme-toggle" title="Toggle Dark Mode">
                                <svg id="ligen-chatbot-theme-icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                                    <circle cx="12" cy="12" r="5"></circle>
                                    <line x1="12" y1="1" x2="12" y2="3"></line>
                                    <line x1="12" y1="21" x2="12" y2="23"></line>
                                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                                    <line x1="1" y1="12" x2="3" y2="12"></line>
                                    <line x1="21" y1="12" x2="23" y2="12"></line>
                                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                                    <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                                </svg>
                                <svg id="ligen-chatbot-theme-icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                                </svg>
                            </button>
                            <button id="ligen-chatbot-close" class="ligen-chatbot-close">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div id="ligen-chatbot-messages" class="ligen-chatbot-messages">
                        <div class="ligen-chatbot-message ligen-chatbot-message-bot">
                            <div class="ligen-chatbot-message-content">
                                ${chatbotConfig.welcomeMessage}
                            </div>
                            <div class="ligen-chatbot-message-time">Just now</div>
                        </div>
                    </div>
                    <div class="ligen-chatbot-input-container">
                        <input type="text" id="ligen-chatbot-input" class="ligen-chatbot-input" placeholder="${chatbotConfig.placeholder}">
                        <button id="ligen-chatbot-send" class="ligen-chatbot-send">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', chatbotHTML);
    }

    // Add chatbot CSS
    function addChatbotCSS() {
        const style = document.createElement('style');
        style.textContent = `
            .ligen-chatbot-container {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 9998;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            }

            .ligen-chatbot-button {
                width: 60px;
                height: 60px;
                background: linear-gradient(135deg, #00a651 0%, #008a43 100%);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 4px 12px rgba(0, 166, 81, 0.4);
                transition: all 0.3s ease;
                color: white;
                position: relative;
            }

            .ligen-chatbot-button:hover {
                transform: scale(1.1);
                box-shadow: 0 6px 16px rgba(0, 166, 81, 0.5);
            }

            .ligen-chatbot-badge {
                position: absolute;
                top: -5px;
                right: -5px;
                background: #ff4444;
                color: white;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 11px;
                font-weight: bold;
                border: 2px solid white;
            }

            .ligen-chatbot-window {
                position: absolute;
                bottom: 80px;
                right: 0;
                width: 380px;
                max-width: calc(100vw - 40px);
                height: 600px;
                max-height: calc(100vh - 100px);
                background: white;
                border-radius: 16px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
                display: none;
                flex-direction: column;
                overflow: hidden;
            }

            .ligen-chatbot-window.active {
                display: flex;
            }

            .ligen-chatbot-header {
                background: linear-gradient(135deg, #00a651 0%, #008a43 100%);
                color: white;
                padding: 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .ligen-chatbot-header-content {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .ligen-chatbot-avatar {
                width: 40px;
                height: 40px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .ligen-chatbot-header-text h3 {
                margin: 0;
                font-size: 16px;
                font-weight: 600;
            }

            .ligen-chatbot-status {
                font-size: 12px;
                opacity: 0.9;
            }

            .ligen-chatbot-close {
                background: none;
                border: none;
                color: white;
                cursor: pointer;
                padding: 5px;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0.8;
                transition: opacity 0.2s;
            }

            .ligen-chatbot-close:hover {
                opacity: 1;
            }

            .ligen-chatbot-theme-toggle {
                background: rgba(255, 255, 255, 0.2);
                border: none;
                color: white;
                cursor: pointer;
                padding: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 6px;
                opacity: 0.8;
                transition: all 0.2s;
            }

            .ligen-chatbot-theme-toggle:hover {
                opacity: 1;
                background: rgba(255, 255, 255, 0.3);
            }

            /* Dark Mode Styles */
            .ligen-chatbot-container.dark-mode .ligen-chatbot-window {
                background: #1e1e1e;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-messages {
                background: #1a1a1a;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-message-bot .ligen-chatbot-message-content {
                background: #2d2d2d;
                color: #e0e0e0;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-message-time {
                color: #999;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-input-container {
                background: #1e1e1e;
                border-top-color: #333;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-input {
                background: #2d2d2d;
                border-color: #444;
                color: #e0e0e0;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-input::placeholder {
                color: #888;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-input:focus {
                border-color: #00a651;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-quick-replies {
                background: #1a1a1a;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-quick-reply {
                background: #2d2d2d;
                border-color: #444;
                color: #e0e0e0;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-quick-reply:hover {
                background: #00a651;
                color: white;
                border-color: #00a651;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-typing-indicator {
                background: #2d2d2d;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-action-buttons {
                background: transparent;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-action-button {
                background: #2d2d2d;
                border-color: #444;
                color: #e0e0e0;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-action-button:hover {
                background: #00a651;
                border-color: #00a651;
                color: white;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-message-content strong {
                color: #e0e0e0;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-message-content a {
                color: #4ade80;
            }

            .ligen-chatbot-container.dark-mode .ligen-chatbot-message-content a:hover {
                color: #00a651;
            }

            .ligen-chatbot-messages {
                flex: 1;
                overflow-y: auto;
                padding: 20px;
                background: #f8f9fa;
                display: flex;
                flex-direction: column;
                gap: 16px;
            }

            .ligen-chatbot-message {
                display: flex;
                flex-direction: column;
                max-width: 80%;
                animation: fadeIn 0.3s ease;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .ligen-chatbot-message-user {
                align-self: flex-end;
            }

            .ligen-chatbot-message-bot {
                align-self: flex-start;
            }

            .ligen-chatbot-message-content {
                padding: 12px 16px;
                border-radius: 12px;
                font-size: 14px;
                line-height: 1.5;
                word-wrap: break-word;
            }

            .ligen-chatbot-message-user .ligen-chatbot-message-content {
                background: linear-gradient(135deg, #00a651 0%, #008a43 100%);
                color: white;
                border-bottom-right-radius: 4px;
            }

            .ligen-chatbot-message-bot .ligen-chatbot-message-content {
                background: white;
                color: #333;
                border-bottom-left-radius: 4px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .ligen-chatbot-message-time {
                font-size: 11px;
                color: #999;
                margin-top: 4px;
                padding: 0 4px;
            }

            .ligen-chatbot-input-container {
                display: flex;
                padding: 16px;
                background: white;
                border-top: 1px solid #e5e5e5;
                gap: 10px;
            }

            .ligen-chatbot-input {
                flex: 1;
                border: 1px solid #e5e5e5;
                border-radius: 24px;
                padding: 12px 16px;
                font-size: 14px;
                outline: none;
                transition: border-color 0.2s;
            }

            .ligen-chatbot-input:focus {
                border-color: #00a651;
            }

            .ligen-chatbot-send {
                width: 44px;
                height: 44px;
                background: linear-gradient(135deg, #00a651 0%, #008a43 100%);
                border: none;
                border-radius: 50%;
                color: white;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: transform 0.2s;
            }

            .ligen-chatbot-send:hover {
                transform: scale(1.1);
            }

            .ligen-chatbot-send:active {
                transform: scale(0.95);
            }

            /* Quick reply buttons */
            .ligen-chatbot-quick-replies {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                padding: 0 20px 12px;
                background: #f8f9fa;
            }

            .ligen-chatbot-quick-reply {
                padding: 10px 16px;
                background: white;
                border: 1px solid #e5e5e5;
                border-radius: 20px;
                font-size: 12px;
                cursor: pointer;
                transition: all 0.2s;
                color: #333;
                display: flex;
                align-items: center;
                gap: 6px;
                font-weight: 500;
            }

            .ligen-chatbot-quick-reply span {
                font-size: 14px;
            }

            .ligen-chatbot-quick-reply:hover {
                background: #00a651;
                color: white;
                border-color: #00a651;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 166, 81, 0.2);
            }

            .ligen-chatbot-quick-reply:active {
                transform: translateY(0);
            }

            /* Typing indicator */
            .ligen-chatbot-typing-indicator {
                display: flex;
                gap: 4px;
                padding: 12px 16px;
                background: white;
                border-radius: 12px;
                border-bottom-left-radius: 4px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .ligen-chatbot-typing-indicator span {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: #00a651;
                animation: typing 1.4s infinite;
            }

            .ligen-chatbot-typing-indicator span:nth-child(2) {
                animation-delay: 0.2s;
            }

            .ligen-chatbot-typing-indicator span:nth-child(3) {
                animation-delay: 0.4s;
            }

            @keyframes typing {
                0%, 60%, 100% {
                    transform: translateY(0);
                    opacity: 0.7;
                }
                30% {
                    transform: translateY(-10px);
                    opacity: 1;
                }
            }

            /* Action buttons */
            .ligen-chatbot-action-buttons {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-top: 12px;
            }

            .ligen-chatbot-action-button {
                padding: 8px 16px;
                background: rgba(0, 166, 81, 0.1);
                border: 1px solid #00a651;
                border-radius: 20px;
                font-size: 12px;
                cursor: pointer;
                transition: all 0.2s;
                color: #00a651;
                font-weight: 500;
            }

            .ligen-chatbot-action-button:hover {
                background: #00a651;
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 166, 81, 0.3);
            }

            .ligen-chatbot-action-button:active {
                transform: translateY(0);
            }

            /* Enhanced message content */
            .ligen-chatbot-message-content a {
                color: #00a651;
                text-decoration: underline;
                transition: color 0.2s;
            }

            .ligen-chatbot-message-content a:hover {
                color: #008a43;
            }

            .ligen-chatbot-message-content strong {
                color: #333;
                font-weight: 600;
            }

            /* Pulse animation for button */
            @keyframes pulse {
                0%, 100% {
                    transform: scale(1);
                }
                50% {
                    transform: scale(1.05);
                }
            }

            .ligen-chatbot-button.new-message {
                animation: pulse 2s infinite;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .ligen-chatbot-window {
                    width: calc(100vw - 20px);
                    height: calc(100vh - 100px);
                    bottom: 80px;
                    right: 10px;
                }

                .ligen-chatbot-container {
                    bottom: 15px;
                    right: 15px;
                }

                .ligen-chatbot-action-buttons {
                    flex-direction: column;
                }

                .ligen-chatbot-action-button {
                    width: 100%;
                }
            }
        `;
        document.head.appendChild(style);
    }

    // Get response based on user input with comprehensive keyword matching
    function getResponse(userInput) {
        const input = userInput.toLowerCase().trim();

        // Check for greetings
        if (input.match(/^(hi|hello|hey|good morning|good afternoon|good evening|greetings|namaste)/)) {
            return responses.greeting[Math.floor(Math.random() * responses.greeting.length)];
        }

        // Check for specific product: Power Inverter
        if (input.match(/(power inverter|inverter|Ligen Power®|pure sine|sine wave|300|600|850|1000|1500|2000|3500|5000|va)/)) {
            if (input.match(/(price|cost|buy|purchase|rate|quotation|quote)/)) {
                return responses.price[Math.floor(Math.random() * responses.price.length)];
            }
            return responses.powerInverter[Math.floor(Math.random() * responses.powerInverter.length)];
        }

        // Check for specific product: BMS
        if (input.match(/(bms|battery management|cell balancing|1s|2s|3s|4s|8s|10s|12s|16s)/)) {
            if (input.match(/(price|cost|buy|purchase|rate|quotation|quote)/)) {
                return responses.price[Math.floor(Math.random() * responses.price.length)];
            }
            return responses.bms[Math.floor(Math.random() * responses.bms.length)];
        }

        // Check for specific product: Battery
        if (input.match(/(battery|batteries|lfp|lithium|12v|24v|36v|48v|100ah|50ah|30ah|15ah)/)) {
            if (input.match(/(price|cost|buy|purchase|rate|quotation|quote)/)) {
                return responses.price[Math.floor(Math.random() * responses.price.length)];
            }
            return responses.battery[Math.floor(Math.random() * responses.battery.length)];
        }

        // Check for specific product: Solar
        if (input.match(/(solar|pcu|mppt|pwm|street light|streetlight|hybrid|24w|48w|2000va|3500va|5000va)/)) {
            if (input.match(/(price|cost|buy|purchase|rate|quotation|quote)/)) {
                return responses.price[Math.floor(Math.random() * responses.price.length)];
            }
            return responses.solar[Math.floor(Math.random() * responses.solar.length)];
        }

        // Check for specific product: E-Cycle
        if (input.match(/(e-cycle|electric cycle|electric bicycle|e-bike|ebike|mobility)/)) {
            if (input.match(/(price|cost|buy|purchase|rate|quotation|quote)/)) {
                return responses.price[Math.floor(Math.random() * responses.price.length)];
            }
            return responses.ecycle[Math.floor(Math.random() * responses.ecycle.length)];
        }

        // Check for general product inquiries
        if (input.match(/(product|products|what do you|what does|offer|sell|manufacture|make)/)) {
            if (input.match(/(price|cost|buy|purchase|rate|quotation|quote)/)) {
                return responses.price[Math.floor(Math.random() * responses.price.length)];
            }
            return responses.product[Math.floor(Math.random() * responses.product.length)];
        }

        // Check for pricing inquiries
        if (input.match(/(price|pricing|cost|buy|purchase|rate|quotation|quote|how much|expensive|cheap|affordable)/)) {
            return responses.price[Math.floor(Math.random() * responses.price.length)];
        }

        // Check for warranty
        if (input.match(/(warranty|warrant|guarantee|register|registration|warranty registration)/)) {
            return responses.warranty[Math.floor(Math.random() * responses.warranty.length)];
        }

        // Check for contact information
        if (input.match(/(contact|email|phone|address|location|where|reach|call|phone number|mobile|telephone|office|headquarters)/)) {
            return responses.contact[Math.floor(Math.random() * responses.contact.length)];
        }

        // Check for working hours
        if (input.match(/(working hours|office hours|open|closed|timing|time|available|when|schedule|business hours)/)) {
            return responses.workingHours[Math.floor(Math.random() * responses.workingHours.length)];
        }

        // Check for dealer/distributor
        if (input.match(/(dealer|distributor|partner|reseller|business|partnership|become|join|network|opportunity)/)) {
            return responses.dealer[Math.floor(Math.random() * responses.dealer.length)];
        }

        // Check for about/company information
        if (input.match(/(about|company|who|what is|information|details|background|history|founded|startup)/)) {
            return responses.about[Math.floor(Math.random() * responses.about.length)];
        }

        // Check for grievances
        if (input.match(/(grievance|grievances|complaint|complaints|issue|problem|help|support|resolve)/)) {
            return responses.grievances[Math.floor(Math.random() * responses.grievances.length)];
        }

        // Check for datasheet/resources
        if (input.match(/(datasheet|data sheet|specification|spec|manual|documentation|pdf|download|resource|resources)/)) {
            return responses.datasheet[Math.floor(Math.random() * responses.datasheet.length)];
        }

        // Check for technical support
        if (input.match(/(technical|tech|support|help|assistance|service|repair|maintenance|troubleshoot|problem|issue)/)) {
            return `For **Technical Support**, contact us:
📞 ${companyInfo.contact.support}
📧 ${companyInfo.contact.email}

**Support Hours:** ${companyInfo.workingHours.techSupport}

Our technical team is available to assist you with any product-related queries or issues.`;
        }

        // Check for career/jobs
        if (input.match(/(career|job|jobs|employment|hire|hiring|recruitment|vacancy|position|opportunity)/)) {
            return `For **Career Opportunities**, visit our Career page or contact:
📧 ${companyInfo.contact.email}

We're always looking for talented individuals to join our team of innovators!`;
        }

        // Check for certifications
        if (input.match(/(certificate|certification|certified|quality|iso|standard|compliance)/)) {
            return `For information about our **Certifications**, visit our Certificates page or contact:
📧 ${companyInfo.contact.email}

We maintain high quality standards and certifications for all our products.`;
        }

        // Check for web/website/external information requests
        if (input.match(/(website|web|online|internet|url|link|social media|social|facebook|instagram|linkedin|youtube)/)) {
            if (input.match(/(linkedin|linked in)/)) {
                return `**LinkedIn:**
🔗 ${externalSources.linkedin}

Follow us on LinkedIn for company updates, news, and professional networking.`;
            } else if (input.match(/(facebook|fb)/)) {
                return `**Facebook:**
🔗 ${externalSources.facebook}

Like and follow our Facebook page for product updates and community engagement.`;
            } else if (input.match(/(instagram|insta|ig)/)) {
                return `**Instagram:**
🔗 ${externalSources.instagram}

Follow us on Instagram for visual content, product showcases, and behind-the-scenes.`;
            } else if (input.match(/(youtube|yt|video)/)) {
                return `**YouTube:**
🔗 ${externalSources.youtube}

Subscribe to our YouTube channel for product demonstrations, tutorials, and company videos.`;
            } else if (input.match(/(website|site|web|official)/)) {
                return `**Official Website:**
🔗 ${externalSources.website}

Visit our official website for complete product catalog, specifications, datasheets, and detailed company information.`;
            }
            return `**Our Online Presence:**

🌐 **Website:** ${externalSources.website}
💼 **LinkedIn:** ${externalSources.linkedin}
📘 **Facebook:** ${externalSources.facebook}
📷 **Instagram:** ${externalSources.instagram}
▶️ **YouTube:** ${externalSources.youtube}
🛡️ **Warranty Portal:** ${externalSources.warranty}

Which platform would you like to know more about?`;
        }

        // Check for fetch/get information requests
        if (input.match(/(fetch|get|retrieve|access|load|open|visit|go to|check|see|view)/)) {
            const urlMatch = input.match(/(https?:\/\/[^\s]+|www\.[^\s]+)/);
            if (urlMatch) {
                return `I can help you access that URL. However, for security reasons, I'll provide you with the link:\n\n🔗 ${urlMatch[0]}\n\nYou can click the link above or copy it to visit the page.`;
            }
        }

        // Default response
        return responses.default[Math.floor(Math.random() * responses.default.length)];
    }

    // Enhanced response function with web access
    async function getResponseWithWebAccess(userInput) {
        try {
            const input = userInput.toLowerCase().trim();
            
            // Check if user wants to access web information
            if (input.match(/(fetch|get|access|load|open|visit|check|see|view|website|web|url)/)) {
                // Check for specific sources
                const sources = ['linkedin', 'facebook', 'instagram', 'youtube', 'website', 'warranty'];
                for (const source of sources) {
                    if (input.includes(source)) {
                        try {
                            const webInfo = await getWebInformation(source);
                            if (webInfo && webInfo.url) {
                                return {
                                    response: `**${webInfo.name}:**\n\n${webInfo.info}\n\n🔗 ${webInfo.url}\n\nWould you like me to open this link for you?`,
                                    options: [
                                        { text: 'Open Link', action: webInfo.url },
                                        { text: 'More Info', action: `tell me more about ${source}` }
                                    ]
                                };
                            }
                        } catch (error) {
                            console.error('Error getting web information:', error);
                        }
                    }
                }
            }

            // Regular response - ensure it always returns an object
            const responseData = getResponseWithOptions(userInput);
            if (responseData && typeof responseData === 'object' && responseData.response) {
                return responseData;
            } else if (typeof responseData === 'string') {
                return { response: responseData, options: null };
            } else {
                return { response: responseData || 'I\'m here to help! What would you like to know?', options: null };
            }
        } catch (error) {
            console.error('Error in getResponseWithWebAccess:', error);
            return {
                response: 'I apologize, but I encountered an error. Please try asking your question again.',
                options: null
            };
        }
    }

    // Show typing indicator
    function showTypingIndicator() {
        const messagesContainer = document.getElementById('ligen-chatbot-messages');
        const typingDiv = document.createElement('div');
        typingDiv.id = 'ligen-chatbot-typing';
        typingDiv.className = 'ligen-chatbot-message ligen-chatbot-message-bot';
        typingDiv.innerHTML = `
            <div class="ligen-chatbot-message-content ligen-chatbot-typing-indicator">
                <span></span>
                <span></span>
                <span></span>
            </div>
        `;
        messagesContainer.appendChild(typingDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Remove typing indicator
    function removeTypingIndicator() {
        const typingIndicator = document.getElementById('ligen-chatbot-typing');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }

    // Add message to chat with interactive elements
    function addMessage(content, isUser = false, options = null) {
        const messagesContainer = document.getElementById('ligen-chatbot-messages');
        removeTypingIndicator();
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `ligen-chatbot-message ${isUser ? 'ligen-chatbot-message-user' : 'ligen-chatbot-message-bot'}`;
        
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        
        // Format content with markdown-like formatting
        let formattedContent = formatMessage(content);
        
        // Add interactive buttons if options provided
        let buttonsHTML = '';
        if (options && options.length > 0) {
            buttonsHTML = '<div class="ligen-chatbot-action-buttons">';
            options.forEach(option => {
                buttonsHTML += `<button class="ligen-chatbot-action-button" data-action="${option.action || option.text}">${option.text}</button>`;
            });
            buttonsHTML += '</div>';
        }
        
        messageDiv.innerHTML = `
            <div class="ligen-chatbot-message-content">${formattedContent}</div>
            ${buttonsHTML}
            <div class="ligen-chatbot-message-time">${timeString}</div>
        `;
        
        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        
        // Add click handlers for action buttons
        if (options && options.length > 0) {
            messageDiv.querySelectorAll('.ligen-chatbot-action-button').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const action = btn.getAttribute('data-action');
                    // Visual feedback
                    btn.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        btn.style.transform = '';
                    }, 150);
                    handleActionButton(action);
                });
            });
        }
    }

    // Format message with markdown-like syntax
    function formatMessage(text) {
        // Bold text **text**
        text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        // Links [text](url)
        text = text.replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2" target="_blank" style="color: #00a651; text-decoration: underline;">$1</a>');
        // Line breaks
        text = text.replace(/\n/g, '<br>');
        // Bullet points
        text = text.replace(/^•\s(.+)$/gm, '<span style="display: block; margin: 4px 0;">• $1</span>');
        // Emojis (already supported)
        return text;
    }

    // Handle action button clicks
    function handleActionButton(action) {
        // Handle special actions (tel:, mailto:, http:)
        if (action.startsWith('tel:') || action.startsWith('mailto:') || action.startsWith('http')) {
            window.open(action, '_blank');
            return;
        }
        
        const input = document.getElementById('ligen-chatbot-input');
        input.value = action;
        sendMessage();
    }

    // Get response with follow-up options
    function getResponseWithOptions(userInput) {
        try {
            const input = userInput.toLowerCase().trim();
            const response = getResponse(userInput);
            
            // Ensure response is a string
            if (!response || typeof response !== 'string') {
                return {
                    response: 'I\'m here to help! Could you please rephrase your question?',
                    options: null
                };
            }
            
            let options = null;

            // Add follow-up options based on context
            if (input.match(/(product|inverter|bms|battery|solar|cycle)/)) {
                options = [
                    { text: 'View Pricing', action: 'pricing' },
                    { text: 'Get Datasheet', action: 'datasheet' },
                    { text: 'Visit Website', action: externalSources.website },
                    { text: 'Contact Sales', action: 'contact sales' }
                ];
            } else if (input.match(/(price|pricing|cost|buy|purchase)/)) {
                options = [
                    { text: 'Contact Sales', action: 'contact sales' },
                    { text: 'View Products', action: 'products' },
                    { text: 'Visit Website', action: externalSources.website },
                    { text: 'Become Dealer', action: 'dealer' }
                ];
            } else if (input.match(/(contact|email|phone|address)/)) {
                options = [
                    { text: 'Call Now', action: `tel:${companyInfo.contact.sales}` },
                    { text: 'Send Email', action: `mailto:${companyInfo.contact.email}` },
                    { text: 'Visit Website', action: externalSources.website },
                    { text: 'Working Hours', action: 'working hours' }
                ];
            } else if (input.match(/(warranty|warrant)/)) {
                options = [
                    { text: 'Register Warranty', action: companyInfo.warranty },
                    { text: 'Visit Website', action: externalSources.website },
                    { text: 'Contact Support', action: 'contact support' }
                ];
            } else if (input.match(/(website|web|online|social|linkedin|facebook|instagram|youtube)/)) {
                options = [
                    { text: 'Open Website', action: externalSources.website },
                    { text: 'LinkedIn', action: externalSources.linkedin },
                    { text: 'Facebook', action: externalSources.facebook },
                    { text: 'Instagram', action: externalSources.instagram }
                ];
            }

            return { response: response || 'I\'m here to help! What would you like to know?', options: options };
        } catch (error) {
            console.error('Error in getResponseWithOptions:', error);
            return {
                response: 'I encountered an error processing your request. Please try again.',
                options: null
            };
        }
    }

    // Initialize chatbot
    function initChatbot() {
        createChatbotHTML();
        addChatbotCSS();

        // Wait a bit for DOM to be ready
        setTimeout(() => {
            const button = document.getElementById('ligen-chatbot-button');
            const window = document.getElementById('ligen-chatbot-window');
            const closeBtn = document.getElementById('ligen-chatbot-close');
            const sendBtn = document.getElementById('ligen-chatbot-send');
            const input = document.getElementById('ligen-chatbot-input');
            const badge = document.querySelector('.ligen-chatbot-badge');
            const themeToggle = document.getElementById('ligen-chatbot-theme-toggle');
            const themeIconSun = document.getElementById('ligen-chatbot-theme-icon-sun');
            const themeIconMoon = document.getElementById('ligen-chatbot-theme-icon-moon');
            const container = document.getElementById('ligen-chatbot');

            // Check if elements exist
            if (!button || !window || !closeBtn || !sendBtn || !input) {
                console.error('Chatbot elements not found:', {
                    button: !!button,
                    window: !!window,
                    closeBtn: !!closeBtn,
                    sendBtn: !!sendBtn,
                    input: !!input
                });
                return;
            }

        // Load dark mode preference
        const isDarkMode = localStorage.getItem('ligen-chatbot-dark-mode') === 'true';
        if (isDarkMode) {
            container.classList.add('dark-mode');
            themeIconSun.style.display = 'block';
            themeIconMoon.style.display = 'none';
        } else {
            themeIconSun.style.display = 'none';
            themeIconMoon.style.display = 'block';
        }

        // Toggle dark mode
        themeToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            const isDark = container.classList.toggle('dark-mode');
            localStorage.setItem('ligen-chatbot-dark-mode', isDark.toString());
            
            if (isDark) {
                themeIconSun.style.display = 'block';
                themeIconMoon.style.display = 'none';
            } else {
                themeIconSun.style.display = 'none';
                themeIconMoon.style.display = 'block';
            }
        });

        // Toggle chatbot window
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            console.log('Chatbot button clicked');
            window.classList.toggle('active');
            console.log('Window active state:', window.classList.contains('active'));
            if (window.classList.contains('active')) {
                if (badge) badge.style.display = 'none';
                input.focus();
            }
        });

        // Close chatbot
        closeBtn.addEventListener('click', () => {
            window.classList.remove('active');
        });

        // Send message with typing indicator and web access
        async function sendMessage() {
            const userInput = input.value.trim();
            if (!userInput) return;

            addMessage(userInput, true);
            input.value = '';

            // Show typing indicator
            showTypingIndicator();

            try {
                // Get response with web access capability
                let responseData;
                try {
                    responseData = await getResponseWithWebAccess(userInput);
                } catch (getResponseError) {
                    console.error('Error getting response:', getResponseError);
                    throw getResponseError;
                }
                
                // Ensure responseData has the correct structure
                if (!responseData) {
                    throw new Error('No response received');
                }

                // Handle both object and string responses
                let responseText;
                let responseOptions = null;
                
                if (typeof responseData === 'string') {
                    responseText = responseData;
                } else if (typeof responseData === 'object' && responseData.response) {
                    responseText = responseData.response;
                    responseOptions = responseData.options || null;
                } else {
                    throw new Error('Invalid response format');
                }

                // Ensure we have a valid response text
                if (!responseText || typeof responseText !== 'string') {
                    responseText = 'I\'m here to help! Could you please rephrase your question?';
                }
                
                // Simulate realistic typing delay
                const typingDelay = Math.min(800 + Math.random() * 700, 2000);

                setTimeout(() => {
                    removeTypingIndicator();
                    addMessage(responseText, false, responseOptions);
                }, typingDelay);
            } catch (error) {
                console.error('Chatbot error:', error);
                removeTypingIndicator();
                const errorMessage = error && error.message 
                    ? `I encountered an error: ${error.message}. Please try again or contact our support team at ${companyInfo.contact.support}.`
                    : `I encountered an error while processing your request. Please try again or contact our support team at ${companyInfo.contact.support}.`;
                addMessage(errorMessage, false);
            }
        }

        sendBtn.addEventListener('click', sendMessage);
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // Quick replies removed as per user request

        const messagesContainer = document.getElementById('ligen-chatbot-messages');
        
        // Add smooth scroll behavior
        if (messagesContainer) {
            messagesContainer.style.scrollBehavior = 'smooth';

            // Show welcome message with interactive options after a delay
            setTimeout(() => {
                if (messagesContainer.children.length === 1) {
                    addMessage("You can ask me about any of our products, services, company information, or access our websites and online resources. Try clicking the buttons below or type your question!", false, [
                        { text: 'View All Products', action: 'products' },
                        { text: 'Get Contact Info', action: 'contact' },
                        { text: 'Visit Our Website', action: externalSources.website },
                        { text: 'Social Media Links', action: 'social media' }
                    ]);
                }
            }, 2000);
        }
        }, 100); // Small delay to ensure DOM is ready
    }

    // Initialize when DOM is ready
    function initializeChatbot() {
        // Check if chatbot already exists
        if (document.getElementById('ligen-chatbot') !== null) {
            console.log('Chatbot already initialized');
            return;
        }

        // Ensure body exists
        if (!document.body) {
            console.log('Waiting for body to be ready...');
            setTimeout(initializeChatbot, 100);
            return;
        }

        try {
            console.log('Initializing chatbot...');
            initChatbot();
            console.log('Chatbot initialized successfully');
        } catch (error) {
            console.error('Chatbot initialization error:', error);
            // Retry after a short delay
            setTimeout(() => {
                try {
                    console.log('Retrying chatbot initialization...');
                    initChatbot();
                } catch (retryError) {
                    console.error('Chatbot retry failed:', retryError);
                }
            }, 500);
        }
    }

    // Check if DOM is already loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initializeChatbot, 200);
        });
    } else {
        // DOM is already loaded, but wait a bit for dynamic content (like footer)
        setTimeout(initializeChatbot, 300);
    }
})();

