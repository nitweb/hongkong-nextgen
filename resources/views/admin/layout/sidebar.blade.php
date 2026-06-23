<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <div id="sidebar-menu">

            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i data-feather="home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="image"></i>
                        <span>Slider Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.slider.list') }}"><span>List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="info"></i>
                        <span>About Company</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.about_company.list') }}"><span>List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="target"></i>
                        <span>Mission/Vision/Values</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.mission_vision.list') }}"><span>List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="award"></i>
                        <span>Qualification Certificate</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.certificate.list') }}"><span>List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="box"></i>
                        <span>Product Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.product_brand.list') }}"><span>Brand List</span></a></li>
                        <li><a href="{{ route('backend.product_categories.list') }}"><span>Category List</span></a></li>
                        <li><a href="{{ route('backend.it_categories.list') }}"><span>IT Category List</span></a></li>
                        <li><a href="{{ route('backend.products.list') }}"><span>Product List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="battery-charging"></i>
                        <span>Battery Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.battery_category.list') }}"><span>Battery Category List</span></a></li>
                        <li><a href="{{ route('backend.battery.ad.list') }}"><span>Battery Ad List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="shopping-cart"></i>
                        <span>Order Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.bulk_order.list') }}"><span>List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="edit-3"></i>
                        <span>Blog</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.blog_categories.list') }}"><span>Blog Category List</span></a></li>
                        <li><a href="{{ route('backend.blog.list') }}"><span>Blog List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span>Contact Form</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.contact_form.list') }}"><span>List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="settings"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.site_settings.font_awesome') }}"><span>Font Awesome</span></a></li>
                        <li><a href="{{ route('backend.site_settings') }}"><span>Site Settings</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ url('/analytics') }}" target="_blank">
                        <i data-feather="bar-chart-2"></i>
                        <span>Site Analytics</span>
                    </a>
                </li>

            </ul>

        </div>

    </div>

</div>
