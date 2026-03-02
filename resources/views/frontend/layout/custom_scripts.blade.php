<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session()->has('message'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "{{ session('alert-type', 'success') }}",
                title: "{{ session('alert-type') == 'success' ? 'Success!' : 'Oops!' }}",
                text: @json(session('message')),
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Validation Error!",
                text: "Please fix the highlighted fields and try again.",
                confirmButtonText: "OK"
            });
        });
    </script>
@endif

<script>
    // =============================================
    // ALL SCRIPTS CONSOLIDATED FOR PRODUCTS PAGE
    // =============================================

    // 1. Header Search Script (for dropdown results only)
    document.addEventListener("DOMContentLoaded", function() {
        let delayTimer = null;
        document.addEventListener("keyup", function(e) {
            const input = e.target.closest(".custom-header-search .js-ajax-search-input");
            if (!input) return;
            const wrapper = input.closest(".custom-header-search");
            const resultBox = wrapper.querySelector(".js-ajax-search-result");
            const query = input.value.trim();
            clearTimeout(delayTimer);
            if (query.length < 2) {
                resultBox.style.display = "none";
                resultBox.innerHTML = "";
                return;
            }
            delayTimer = setTimeout(() => {
                fetch("{{ route('ajax.search') }}?query=" + encodeURIComponent(query))
                    .then(res => res.json())
                    .then(data => {
                        resultBox.innerHTML = data.html;
                        resultBox.style.display = "block";
                    });
            }, 300);
        });

        document.addEventListener("click", function(e) {
            document.querySelectorAll(".custom-header-search").forEach(searchBox => {
                if (!searchBox.contains(e.target)) {
                    const result = searchBox.querySelector(".js-ajax-search-result");
                    result.style.display = "none";
                }
            });
        });
    });

    // 2. Product Price Filter (if enabled)
    $(function() {
        if (!$('#priceRangeSlider').length) return;
        let minPrice = 0;
        let maxPrice = 5000;
        let filterTimer;
        $("#priceRangeSlider").slider({
            range: true,
            min: 0,
            max: 5000,
            values: [minPrice, maxPrice],
            slide: function(event, ui) {
                $('.js-price-min').val('$' + ui.values[0]);
                $('.js-price-max').val('$' + ui.values[1]);
                clearTimeout(filterTimer);
                filterTimer = setTimeout(applyFilters, 400);
            }
        });
        $('.js-price-min').val('$' + minPrice);
        $('.js-price-max').val('$' + maxPrice);
    });

    // Main AJAX function to apply filters and update product list
    function applyFilters() {
        let categories = [];
        let brands = [];

        // Get selected categories
        $('.js-filter-category:checked').each(function() {
            categories.push($(this).val());
        });

        // Get selected brands
        $('.js-filter-brand:checked').each(function() {
            brands.push($(this).val());
        });

        let searchQuery = $('.custom-sidebar-search .js-ajax-search-input').val().trim();

        // Debug output
        console.log('Applying filters:', {
            categories: categories,
            brands: brands,
            query: searchQuery
        });

        // Show loading state
        $('#product-list-wrapper').css('opacity', '0.4');

        $.ajax({
            url: "{{ route('ajax.products') }}",
            type: 'GET',
            data: {
                categories: categories,
                brands: brands,
                query: searchQuery,
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(res) {
                $('#product-list-wrapper').html(res.html).css('opacity', '1');
                $('#product-showing-text').text(res.showing_text);
                checkFilters();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                console.error("Response:", xhr.responseText);
                $('#product-list-wrapper').css('opacity', '1');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while filtering products. Please try again.',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    // Check if any filter is active
    function checkFilters() {
        const hasCategory = $('.js-filter-category:checked').length > 0;
        const hasBrand = $('.js-filter-brand:checked').length > 0;
        const hasSearch = $('.custom-sidebar-search .js-ajax-search-input').val().trim().length >= 2;

        if (hasCategory || hasBrand || hasSearch) {
            $('#clear-all-filters').show();
            $('#clear-all-placeholder').hide();
        } else {
            $('#clear-all-filters').hide();
            $('#clear-all-placeholder').show();
        }
    }

    // Initialize everything when DOM is ready
    $(document).ready(function() {
        // Sidebar search input
        $(document).on('keyup', '.custom-sidebar-search .js-ajax-search-input', function() {
            clearTimeout($.data(this, 'timer'));
            $.data(this, 'timer', setTimeout(applyFilters, 300));
        });

        // Checkbox change for categories and brands
        $(document).on('change', '.js-filter-category, .js-filter-brand', applyFilters);

        // Clear All Filters
        $(document).on('click', '#clear-all-filters', function(e) {
            e.preventDefault();
            $('.js-filter-category, .js-filter-brand').prop('checked', false);
            $('.custom-sidebar-search .js-ajax-search-input').val('');
            applyFilters();
        });

        // Initial check for filters
        checkFilters();

        // Debug: Log current brand selections
        console.log("Current brand selections:", $('.js-filter-brand:checked').map(function() {
            return $(this).val();
        }).get());
    });
</script>
