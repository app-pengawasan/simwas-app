let table = $("#table-master-anggaran");

$(function () {
    table
        .DataTable({
            dom: "Bfrtip",
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: [
                {
                    extend: "excel",
                    className: "btn-success",
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                    },
                },
            ],
        })
        .buttons()
        .container()
        .appendTo("#table-master-anggaran_wrapper .col-md-6:eq(0)");
});
