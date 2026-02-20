<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session()->has('message'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "{{ session('alert-type', 'success') }}", // success | error | warning | info | question
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


{{-- Search Script --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {

        let delayTimer = null;

        document.addEventListener("keyup", function(e) {

            const input = e.target.closest(".js-ajax-search-input");
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
</script>

{{-- Product Sidebar Search Scripts --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {

        let delayTimer = null;

        document.addEventListener("keyup", function(e) {

            const input = e.target.closest(".js-ajax-search-input");
            if (!input) return;

            const wrapper = input.closest(".custom-header-search, .custom-sidebar-search");
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
            document.querySelectorAll(".custom-header-search, .custom-sidebar-search")
                .forEach(box => {
                    if (!box.contains(e.target)) {
                        const result = box.querySelector(".js-ajax-search-result");
                        if (result) result.style.display = "none";
                    }
                });
        });

    });
</script>

{{-- Product Price Filter --}}
<script>
    $(function() {
        if (!$('#priceRangeSlider').length) return;

        let urlParams = new URLSearchParams(window.location.search);
        let minPrice = parseInt(urlParams.get('min_price')) || 0;
        let maxPrice = parseInt(urlParams.get('max_price')) || 5000;
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
                filterTimer = setTimeout(function() {
                    doFilter(ui.values[0], ui.values[1]);
                }, 400);
            }
        });

        $('.js-price-min').val('$' + $("#priceRangeSlider").slider("values", 0));
        $('.js-price-max').val('$' + $("#priceRangeSlider").slider("values", 1));

        function doFilter(min, max) {
            $('#product-list-wrapper').css('opacity', '0.4');

            $.ajax({
                // ✅ Current page er URL-e filter kore - brand/category/products sob page e kaj korbe
                url: window.location.pathname,
                type: 'GET',
                data: {
                    min_price: min,
                    max_price: max,
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#product-list-wrapper').html(response.html).css('opacity', '1');
                    $('#product-showing-text').text(response.showing_text);

                    urlParams.set('min_price', min);
                    urlParams.set('max_price', max);
                    window.history.pushState({}, '', '?' + urlParams.toString());
                },
                error: function() {
                    $('#product-list-wrapper').css('opacity', '1');
                }
            });
        }
    });
</script>
