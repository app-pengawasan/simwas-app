// const { concat } = require("lodash");

let table = $("#table-master-pegawai");
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
        .appendTo("#table-master-pegawai_wrapper .col-md-6:eq(0)");
});

let deleteData = (id) => {
    console.log(token);
    console.log(base_url);
    console.log(id);
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
