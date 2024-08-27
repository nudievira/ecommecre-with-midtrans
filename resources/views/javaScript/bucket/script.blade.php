<script>
    $(document).ready(function() {
        // Handle 'Select All' checkbox
        $('#selectAll').on('click', function() {
            $('.item-checkbox').not(':disabled').prop('checked', this.checked);
        });


        // Handle form submission
        $('#bucketForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Collect selected item IDs
            var selectedIds = [];
            $('.item-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });
            if (selectedIds.length == 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'select your product',
                    customClass: {
                        confirmButton: 'btn btn-outline-primary',
                    },
                    buttonsStyling: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                })

                return false
            }
            swalProcess();

            // Send selected IDs to the server via AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    selected_ids: selectedIds,
                },
                success: function(response) {
                    // Handle the response
                    Swal.fire({
                        icon: 'success',
                        title: response.success,
                        customClass: {
                            confirmButton: 'btn btn-outline-primary',
                        },
                        buttonsStyling: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    })
                    setTimeout(function() {
                        location.reload();
                    }, 1500);


                },
                error: function(error) {
                    // console.log(error.responseJSON.error);

                    Swal.fire({
                        icon: 'info',
                        title: error.responseJSON.error,
                        customClass: {
                            confirmButton: 'btn btn-outline-primary',
                        },
                        buttonsStyling: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    })


                    // Handle any errors
                    // console.log(error);
                }
            });
        });

    });

    function inputQty(qty, idBucket) {
        // var price = $('#price_' + idBucket).val()
        // var stock = $('#stock_' + idBucket).val()
        var price = parseInt($('#price_' + idBucket).val());
        var stock = parseInt($('#stock_' + idBucket).val());
        qty = parseInt(qty);
        
        if (qty > stock) {
            Swal.fire({
                icon: 'info',
                title: 'product maximum ' + stock + ' qty',
                customClass: {
                    confirmButton: 'btn btn-outline-primary',
                },
                buttonsStyling: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
            })
            var stock = $('#qty_' + idBucket).val(stock)

            return false

        }
        var total_price = price * qty
        var grand_total = $('#total_price_' + idBucket).val(total_price)
        $.ajax({
            type: "POST",
            url: "{{ route('cart.updateQty') }}",
            data: {
                idBucket: idBucket,
                qty: qty
            },
            dataType: "JSON",
            success: function(res) {

            },
            error: function(xhr, status, error) {
                console.error(error);
            },
        });



    }
</script>
