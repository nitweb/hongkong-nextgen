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
                        <i data-feather="file-text"></i>
                        <span>Slider Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.slider.list') }}"><span>List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span>About Company</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.about_company.list') }}"><span>List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span>Mission/Vision/Values</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.mission_vision.list') }}"><span>List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span>Product Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.product_categories.list') }}"><span>Category List</span></a></li>
                        <li><a href="{{ route('backend.product_subcategories.list') }}"><span>SubCategory List</span></a></li>
                        <li><a href="{{ route('age_group.list') }}"><span>Age Group List</span></a></li>
                        <li><a href="{{ route('backend.products.list') }}"><span>Product List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span>Product Review Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('product_review.list') }}"><span>Review List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span>Order Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.bulk_order.list') }}"><span>List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span>Blog</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.blog_categories.list') }}"><span>Blog Category List</span></a></li>
                        <li><a href="{{ route('backend.blog.list') }}"><span>Blog List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span>Contact Form</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.contact_form.list') }}"><span>List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.site_settings.font_awesome') }}"><span>Font Awesome</span></a></li>
                        <li><a href="{{ route('backend.site_settings') }}"><span>Site Settings</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ url('/analytics') }}" target="_blank">
                        <i class="fas fa-chart-bar"></i>
                        <span>Site Analytics</span>
                    </a>
                </li>

            </ul>

        </div>

    </div>

</div>
