<div class="mobile-nav__wrapper">

    <div class="mobile-nav__overlay mobile-nav__toggler"></div>

    <div class="mobile-nav__content">

        <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>

        <div class="logo-box">
            <a href="{{ route('index') }}" aria-label="logo image">
                <img src="{{ asset(GlobalSiteSettings()->site_footer_logo) }}" width="143" alt="" />
            </a>
        </div>

        <div class="mobile-nav__container"></div>

        <ul class="mobile-nav__contact list-unstyled">
            <li>
                <i class="fa fa-envelope"></i>
                <a href="mailto:{{ GlobalSiteSettings()->site_email }}">{{ GlobalSiteSettings()->site_email }}</a>
            </li>
            <li>
                <i class="fa fa-phone-alt"></i>
                <a href="tel:{{ GlobalSiteSettings()->site_phone }}">{{ GlobalSiteSettings()->site_phone }}</a>
            </li>
        </ul>

        <div class="mobile-nav__top">
            <div class="mobile-nav__social">
                <a href="#!" class="fab fa-twitter"></a>
                <a href="#!" class="fab fa-facebook-square"></a>
                <a href="#!" class="fab fa-pinterest-p"></a>
                <a href="#!" class="fab fa-instagram"></a>
            </div>
        </div>

    </div>

</div>
