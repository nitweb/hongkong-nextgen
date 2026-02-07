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
