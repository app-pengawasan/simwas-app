// const { concat } = require("lodash");

let table = $("#table-sekretaris-usulan-surat");
let base_url = $("meta[name='base-url']").attr("content");
let token = $("meta[name='csrf-token']").attr("content");

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
                        columns: [1, 2, 3, 4, 5, 6, 7],
                    },
                }
            ],
            columnDefs: [{
                "targets": 0,
                "createdCell": function (td, cellData, rowData, row, col) {
                $(td).text(row + 1);
                }
            }]
        })
        .buttons()
        .container()
        .appendTo("#table-sekretaris-usulan-surat_wrapper .col-md-6:eq(0)");
});

let deleteData = (id) => {
    // console.log(token);
    // console.log(base_url);
    // console.log(id);
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $("form").trigger("submit");

            // $.ajax({
            //     type: "DELETE",
            //     url: url,
            //     data: {
            //         _token: token,
            //     },
            //     success: () => {
            //         Swal.fire(
            //             "Deleted!",
            //             "Your file has been deleted.",
            //             "success"
            //         );
            //     },
            //     fail: function (xhr, textStatus, errorThrown) {
            //         Swal.fire(errorThrown);
            //     },
            // });
        }
    });
};
