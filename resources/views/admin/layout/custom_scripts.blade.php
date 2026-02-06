{{-- #################### Toastr #################### --}}
<script>
    @if (Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}"
        switch (type) {
            case 'info':
                toastr.info(" {{ Session::get('message') }} ");
                break;

            case 'success':
                toastr.success(" {{ Session::get('message') }} ");
                break;

            case 'warning':
                toastr.warning(" {{ Session::get('message') }} ");
                break;

            case 'error':
                toastr.error(" {{ Session::get('message') }} ");
                break;
        }
    @endif
</script>

{{-- #################### Summernote #################### --}}
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300,
            placeholder: 'Write here...'
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300,
            placeholder: 'Write here...'
        });
    });
</script>


{{-- #################### Status Update #################### --}}
<script>
    $(document).ready(function() {
        $(document).on('click', '.js-update-status', function() {
            const recordId = $(this).data('id');
            const status = $(this).data('status');
            const model = $(this).data('model');
            const column = $(this).data('column');

            $.ajax({
                url: "{{ route('backend.status.update') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: recordId,
                    status: status,
                    model: model,
                    column: column
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);

                        // Escape backslashes in the model name for proper selector matching
                        const escapedModel = model.replace(/\\/g, '\\\\');
                        const badge = $(`.custom_status_badge[data-model="${escapedModel}"][data-id="${recordId}"]`);

                        if (status === 'active') {
                            badge.removeClass('text-bg-danger').addClass('text-bg-success').text('Active');
                        } else if (status === 'inactive') {
                            badge.removeClass('text-bg-success').addClass('text-bg-danger').text('Inactive');
                        }
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'An error occurred while updating the status.';
                    toastr.error(errorMessage);
                }
            });
        });
    });
</script>

{{-- #################### Tagify [blog_tags] #################### --}}
<script>
    var input = document.querySelector('input[name=blog_tags]');

    new Tagify(input, {
        duplicates: false,
        // maxTags: 5
    });
</script>
