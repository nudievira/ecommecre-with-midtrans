<script>
    $(document).ready(function() {
        getDataProduct()
    });

    function getDataProduct() {
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('product.dataTable') }}",
            },
            responsive: true,
            pageLength: 10,
            lengthChange: true,
            lengthMenu: [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, "All"]
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'index',
                    fixedColumns: true,
                    width: '5%',
                    defaultContent: '-',
                    className: 'text-center',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name',
                    fixedColumns: true,
                    defaultContent: '-',
                    className: 'text-left',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'stock',
                    name: 'stock',
                    fixedColumns: true,
                    defaultContent: '-',
                    className: 'text-left',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'status',
                    name: 'status',
                    fixedColumns: true,
                    defaultContent: '-',
                    className: 'text-left',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'price',
                    name: 'price',
                    fixedColumns: true,
                    defaultContent: '-',
                    className: 'text-left',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    fixedColumns: true,
                    width: '20%',
                    defaultContent: '-',
                    className: 'text-center',
                    orderable: true,
                    searchable: false
                },
            ],
        });

        $('#date_production').change(function() {

            $('#datatable').DataTable().ajax.reload();
        });

    }

    function validateInput(input) {
        // Hapus karakter "-" dan non-angka lainnya dari nilai input
        input.value = input.value.replace(/[^0-9]/g, '');

        // Hapus angka "0" pertama jika ada, kecuali jika itu adalah satu-satunya angka
        input.value = input.value.replace(/^0+(?=\d)/, '');

        // Jika nilai input kosong atau tidak valid, set nilai ke 0
        if (input.value === '' || parseInt(input.value) < 0) {
            input.value = 0;
        }
    }

    function show(param) {
        $.ajax({
            url: "{{ route('product.show') }}",
            type: "get",
            data: {
                id: param,
            },
            success: function(data) {
                $('#showModal .modal-body').html(`
                <p><strong>Name:</strong> ${data.name}</p>
                <p><strong>Description:</strong> ${data.description}</p>
                <p><strong>Price:</strong> ${data.formatPrice}</p>
                <p><strong>Status:</strong> ${data.statusProduct}</p>
                <p><strong>Stock:</strong> ${data.stock}</p>
                <p><strong>Created Product:</strong> ${data.productCreated}</p>
                <p><strong>Updated Product:</strong> ${data.productUpdated}</p>
            `);

                // Open the modal
                $('#showModal').modal('show');
            },
            error: function(xhr, status, error) {
                swalError(error);
            }
        });
    }

    function edit(param) {
        $.ajax({
            url: "{{ route('product.show') }}",
            type: "get",
            data: {
                id: param,
            },
            success: function(data) {
                // Mengisi data ke dalam modal
                $('#editModal #idProduct').val(data.id);
                $('#editModal #name').val(data.name);
                $('#editModal #stock').val(data.stock);
                $('#editModal #price').val(data.price);
                $('#editModal #status').val(data.status);
                $('#editModal #description').val(data.description);

                // Menampilkan modal
                $('#editModal').modal('show');
            },
            error: function(xhr, status, error) {
                swalError(error);
            }
        });
    }

    function inputQty(qty, idBucket) {
        var price = $('#price_' + idBucket).val()
        var stock = $('#stock_' + idBucket).val()
        
        if (parseInt(qty) > parseInt(stock)) {
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
    }

</script>
