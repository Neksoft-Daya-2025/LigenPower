<div class="top-announcement-bar" style="background-color: #33766c; color: #ffffff; padding: 18px 0; font-size: 13px; width: 100%; box-sizing: border-box; position: relative; z-index: 9999;">
    <div style="width: 100%; max-width: 100%; margin: 0 auto; padding: 0 60px; display: flex; justify-content: space-between; align-items: center; box-sizing: border-box;">
        <div style="display: flex; align-items: center; gap: 0; flex: 1; min-width: 0; overflow: hidden;">
            <div style="display: flex; align-items: center; gap: 12px; padding: 0 8px; white-space: nowrap;">
                <span style="font-weight: 800; font-size: 14px; letter-spacing: 0.5px; text-transform: uppercase; color: #ffffff;">Announcements</span>
                <marquee behavior="scroll" direction="left" scrollamount="3" style="display: inline-block; white-space: nowrap;" id="announcement-marquee">Happy Republic Day 2026! Celebrating 77 Years of Indian Democracy - Unity, Justice & Progress | Jai Hind!</marquee>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 0; flex: 0 0 auto;" id="top-links-container">
            <a href="{{ url('about-us') }}" style="color: #ffffff; text-decoration: none; display: flex; align-items: center; gap: 8px; padding: 0 12px;">About Us</a>
            <span style="border-left: 1px solid rgba(255,255,255,0.3); height: 18px; margin: 0 8px;"></span>
            <a href="{{ url('certificates') }}" style="color: #ffffff; text-decoration: none; display: flex; align-items: center; gap: 8px; padding: 0 12px;">Certifications</a>
            <span style="border-left: 1px solid rgba(255,255,255,0.3); height: 18px; margin: 0 8px;"></span>
            <a href="{{ route('blog.index') }}" style="color: #ffffff; text-decoration: none; display: flex; align-items: center; gap: 8px; padding: 0 12px;">Blog</a>
            <span style="border-left: 1px solid rgba(255,255,255,0.3); height: 18px; margin: 0 8px;"></span>
            <a href="https://merchant.ligenpower.com/" target="_blank" rel="noopener noreferrer" style="color: #ffffff; text-decoration: none; display: flex; align-items: center; gap: 8px; padding: 0 12px;">Store Locator</a>
        </div>
    </div>
</div>
<header class="elementor elementor-location-header">
    <div class="e-con-inner">
        <div class="elementor-widget-theme-etheme_site-logo">
            <a href="{{ url('/') }}">
                <img height="81" src="{{ asset('assets/images/Ligen-Registered-logo.png') }}" alt="Ligen Power®" style="width: auto; height: 81px;" />
            </a>
        </div>
        <nav class="desktop-menu-wrapper elementor-hidden-tablet elementor-hidden-mobile">
            <ul class="etheme-elementor-nav-menu horizontal">
                <li><a href="{{ url('power-inverter') }}">Power Management</a></li>
                <li><a href="{{ url('bms') }}">BMS</a></li>
                <li><a href="{{ url('solar-street-light') }}">Solar Street Light</a></li>
                <li><a href="{{ url('electric-cycle') }}">Mobility Solutions</a></li>
                <li><a href="{{ url('news-events') }}">News & Events</a></li>
                <li><a href="{{ route('blog.index') }}">Blog</a></li>
                <li><a href="{{ url('user-manual') }}">User Manual</a></li>
                <li><a href="{{ url('datasheet') }}">Datasheet</a></li>
                <li><a href="{{ url('career') }}">Career</a></li>
                <li><a href="{{ url('contact') }}">Contact Us</a></li>
            </ul>
        </nav>
        <div class="mobile-menu-wrapper elementor-hidden-desktop">
            <button class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="Toggle menu">☰</button>
            <div class="mobile-menu-panel" id="mobile-menu-panel">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ url('about-us') }}">About</a>
                <a href="{{ url('certificates') }}">Certifications</a>
                <a href="{{ route('blog.index') }}">Blog</a>
                <a href="{{ url('power-inverter') }}">Power Management</a>
                <a href="{{ url('bms') }}">BMS</a>
                <a href="{{ url('solar-street-light') }}">Solar Street Light</a>
                <a href="{{ url('electric-cycle') }}">Mobility Solutions</a>
                <a href="{{ url('news-events') }}">News & Events</a>
                <a href="{{ url('user-manual') }}">User Manual</a>
                <a href="{{ url('datasheet') }}">Datasheet</a>
                <a href="{{ url('career') }}">Career</a>
                <a href="{{ url('contact') }}">Contact</a>
            </div>
        </div>
    </div>
</header>
<script>
(function() {
    const marquee = document.getElementById('announcement-marquee');
    if (marquee) {
        fetch('{{ url("api/announcement") }}')
            .then(r => r.json())
            .then(d => { if (d.success && d.text) marquee.textContent = d.text; })
            .catch(() => {});
    }
})();
</script>
