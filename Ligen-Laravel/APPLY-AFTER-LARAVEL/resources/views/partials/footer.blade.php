<footer class="elementor elementor-location-footer" style="background-image: url('{{ asset('assets/images/foterimage.png') }}'); background-size: cover; color: #ffffff;">
    <section style="padding: 60px 0 20px 0;">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 60px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px;">
                <div>
                    <h3 style="color: #ffffff; font-size: 18px; font-weight: 700; margin-bottom: 20px;">About Us</h3>
                    <p style="color: #cccccc; font-size: 14px; line-height: 1.6;">We are a team of young, energetic entrepreneurs with a solid engineering background and extensive technological expertise. Our strong commitment lies in providing green and clean energy alternatives to the masses.</p>
                    <p style="color: #cccccc; font-size: 14px;">Mail: <a href="mailto:info@ligenpower.com" style="color: #4CAF50; text-decoration: none;">info@ligenpower.com</a></p>
                </div>
                <div>
                    <h3 style="color: #ffffff; font-size: 18px; font-weight: 700; margin-bottom: 20px;">INFORMATION</h3>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 12px;"><a href="{{ url('/') }}" style="color: #cccccc; text-decoration: none;"><span style="color: #4CAF50;">></span> Home</a></li>
                        <li style="margin-bottom: 12px;"><a href="{{ url('about-us') }}" style="color: #cccccc; text-decoration: none;"><span style="color: #4CAF50;">></span> About Us</a></li>
                        <li style="margin-bottom: 12px;"><a href="{{ url('career') }}" style="color: #cccccc; text-decoration: none;"><span style="color: #4CAF50;">></span> Career</a></li>
                        <li style="margin-bottom: 12px;"><a href="{{ url('certificates') }}" style="color: #cccccc; text-decoration: none;"><span style="color: #4CAF50;">></span> Certificates</a></li>
                        <li style="margin-bottom: 12px;"><a href="{{ route('blog.index') }}" style="color: #cccccc; text-decoration: none;"><span style="color: #4CAF50;">></span> Blogs</a></li>
                        <li style="margin-bottom: 12px;"><a href="{{ url('news-events') }}" style="color: #cccccc; text-decoration: none;"><span style="color: #4CAF50;">></span> News & Events</a></li>
                        <li style="margin-bottom: 12px;"><a href="{{ url('contact') }}" style="color: #cccccc; text-decoration: none;"><span style="color: #4CAF50;">></span> Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h3 style="color: #ffffff; font-size: 18px; font-weight: 700; margin-bottom: 20px;">CONTACT US</h3>
                    <p style="color: #cccccc; font-size: 14px;"><strong>Registered Office:</strong><br>Amossys Portable Power LLP, BIADA Industrial Area, Sikandarpur, Bihta, Patna, Bihar - 801103</p>
                    <p style="color: #cccccc; font-size: 14px;"><strong>Support:</strong> <a href="tel:+919031086083" style="color: #4CAF50;">+91-9031086083</a></p>
                    <p style="color: #cccccc; font-size: 14px;"><strong>Sales:</strong> <a href="tel:+919031086082" style="color: #4CAF50;">+91-9031086082</a></p>
                </div>
                <div>
                    <a href="https://amossysportablepower.com/" target="_blank" rel="noopener"><img src="{{ asset('assets/images/amossyslogo.png') }}" alt="AMOSSYS" style="max-width: 100%;" /></a>
                    <img src="{{ asset('assets/images/patient.png') }}" alt="Made In India" style="max-width: 100%; margin-top: 15px;" />
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2); margin: 30px 0 15px;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <p style="color: #cccccc; font-size: 14px; margin: 0;">Copyright © {{ date('Y') }}, All Rights Reserved By <a href="https://neksoftconsultancy.com/" target="_blank" rel="noopener" style="color: #4CAF50;">Neksoft Consultancy Services</a></p>
                <div style="display: flex; gap: 20px;">
                    <a href="{{ url('terms-conditions') }}" style="color: #cccccc; text-decoration: none; font-size: 14px;">Terms & Conditions</a>
                    <a href="{{ url('privacy-policy') }}" style="color: #cccccc; text-decoration: none; font-size: 14px;">Privacy Policy</a>
                    <a href="{{ url('refund-policy') }}" style="color: #cccccc; text-decoration: none; font-size: 14px;">Refund Policy</a>
                </div>
            </div>
        </div>
    </section>
</footer>
<script src="{{ asset('assets/js/quote-modal.js') }}"></script>
<script src="{{ asset('assets/js/chatbot.js') }}"></script>
