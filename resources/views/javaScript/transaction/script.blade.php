<script>
    $(document).ready(function() {
        getDataTransaction()
    });

    function getDataTransaction() {
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('transaction.dataTable') }}",
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
                    data: 'invoice',
                    name: 'invoice',
                    fixedColumns: true,
                    defaultContent: '-',
                    className: 'text-left',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'totalPrice',
                    name: 'totalPrice',
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
</script>
