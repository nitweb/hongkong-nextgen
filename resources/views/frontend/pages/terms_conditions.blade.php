@extends('frontend.dashboard')
@section('frontend_title', 'Terms & Conditions')
@section('frontend_contents')

    {{-- Breadcrumb --}}
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})"></div>
        <div class="container">
            <div class="page-header__inner">
                <h2>Terms & Conditions</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><span>//</span></li>
                    <li>Terms & Conditions</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Terms & Conditions Area --}}
    <section class="terms-section container section" style="margin-top: 90px; margin-bottom: 90px;">
        <h2 class="section__title">Terms & Conditions</h2>

        <p>
            Welcome to <strong>Semiconductor</strong>. By accessing or using our website, products, and semiconductor-related services, you agree to comply with the following Terms & Conditions. Please read them carefully before using our platform.
        </p>
        <br>

        <h3>1. General Use</h3>
        <p>
            This website provides information, sourcing support, and services related to semiconductor components and electronic solutions. All use of this platform is subject to applicable laws, industry regulations, and these terms.
        </p>
        <br>

        <h3>2. Account Responsibilities</h3>
        <ul>
            <li>You must provide accurate, current, and complete information when creating an account.</li>
            <li>You are responsible for maintaining the confidentiality of your login credentials.</li>
            <li>All activities performed under your account are your responsibility.</li>
        </ul>
        <br>

        <h3>3. Orders, Inquiries, and Payments</h3>
        <ul>
            <li>All product inquiries and orders are subject to availability and confirmation.</li>
            <li>Prices, specifications, and lead times may change without prior notice.</li>
            <li>Payments are processed through secure and authorized payment providers.</li>
            <li>We are not responsible for delays caused by manufacturing, customs clearance, or third-party logistics providers.</li>
        </ul>
        <br>

        <h3>4. Product Information & Compliance</h3>
        <p>
            Product descriptions, specifications, and technical data are provided for reference purposes only. Users are responsible for verifying product suitability, compatibility, and regulatory compliance for their intended application.
        </p>
        <br>

        <h3>5. Intellectual Property</h3>
        <p>
            All website content, including text, graphics, logos, designs, and software, is the property of ASE Semiconductor or its licensors. Unauthorized reproduction, modification, or distribution of any content is strictly prohibited.
        </p>
        <br>

        <h3>6. User Conduct</h3>
        <ul>
            <li>You agree not to use the platform for unlawful, fraudulent, or harmful activities.</li>
            <li>You must not interfere with the website’s security, performance, or data integrity.</li>
            <li>Any misuse may result in suspension of access or legal action.</li>
        </ul>
        <br>

        <h3>7. Limitation of Liability</h3>
        <p>
            ASE Semiconductor acts as a platform facilitating access to semiconductor products and services. We shall not be liable for any direct, indirect, incidental, or consequential damages arising from the use of this website or reliance on third-party suppliers.
        </p>
        <br>

        <h3>8. Changes to Terms</h3>
        <p>
            We reserve the right to update or modify these Terms & Conditions at any time. Continued use of the website constitutes acceptance of the revised terms.
        </p>
        <br>

        <p>
            If you have any questions regarding these Terms & Conditions, please <a href="{{ route('contact') }}">contact us</a>.
        </p>
    </section>


    <style>
        .terms-section p {
            text-align: justify !important;
        }
    </style>

@endsection
