@extends('frontend.dashboard')
@section('frontend_title', 'Privacy Policy')
@section('frontend_contents')

    {{-- Breadcrumb --}}
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})"></div>
        <div class="container">
            <div class="page-header__inner">
                <h2>Privacy Policy</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><span>//</span></li>
                    <li>Privacy Policy</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Privacy Policy Area --}}
    <section class="privacy-section container section" style="margin-top: 90px; margin-bottom: 90px;">
        <h2 class="section__title">Privacy Policy</h2>

        <p>
            At <strong>Semiconductor</strong>, we are committed to protecting your privacy and safeguarding your personal information. This Privacy Policy explains how we collect, use, and protect information when you access our website and semiconductor-related services.
        </p>
        <br>

        <h3>1. Information We Collect</h3>
        <ul>
            <li>Personal details such as name, email address, phone number, and company information.</li>
            <li>Account credentials if you create an account with us.</li>
            <li>Order, inquiry, and transaction-related information.</li>
            <li>Technical data including IP address, browser type, device information, cookies, and usage analytics.</li>
        </ul>
        <br>

        <h3>2. How We Use Your Information</h3>
        <ul>
            <li>To process component inquiries, orders, and service requests.</li>
            <li>To communicate technical updates, order status, and customer support responses.</li>
            <li>To improve website performance, security, and user experience.</li>
            <li>To comply with legal, regulatory, and industry requirements.</li>
            <li>To send product updates or marketing communications, where permitted.</li>
        </ul>
        <br>

        <h3>3. Information Sharing</h3>
        <p>
            We do not sell or rent your personal data. Information may be shared only with trusted third parties, including:
        </p>
        <ul>
            <li>Payment service providers for secure transactions.</li>
            <li>Logistics and delivery partners for order fulfillment.</li>
            <li>Technology and analytics providers to improve our services.</li>
            <li>Regulatory or legal authorities when required by law.</li>
        </ul>
        <br>

        <h3>4. Cookies and Tracking Technologies</h3>
        <p>
            We use cookies and similar technologies to enhance website functionality, analyze traffic, and understand user behavior. You may manage or disable cookies through your browser settings.
        </p>
        <br>

        <h3>5. Data Security</h3>
        <p>
            We apply industry-standard technical and organizational security measures to protect your information. While we strive to secure all data, no online system can guarantee absolute security.
        </p>
        <br>

        <h3>6. Your Rights</h3>
        <p>
            You have the right to access, correct, or request deletion of your personal data. You may also opt out of marketing communications at any time.
        </p>
        <br>

        <h3>7. Policy Updates</h3>
        <p>
            This Privacy Policy may be updated periodically to reflect changes in legal requirements or our business practices. The latest version will always be available on this page.
        </p>
        <br>

        <p>
            If you have any questions regarding this Privacy Policy, please <a href="{{ route('contact') }}">contact us</a>.
        </p>
    </section>


    <style>
        .privacy-section p {
            text-align: justify !important;
        }
    </style>

@endsection
