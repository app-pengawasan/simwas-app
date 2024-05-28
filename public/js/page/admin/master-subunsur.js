$(function () {
    // function when edit-button class clicked
    let table;
    if ($("#master-subunsur").length) {
        table = $("#master-subunsur")
            .dataTable({
                dom: "Bfrtip",
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                // filter: false,
                buttons: [
                    {
                        extend: "excel",
                        className: "btn-success",
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        filename: "Master Subunsur",
                    },
                    {
                        extend: "pdf",
                        className: "btn-danger",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        filename: "Master Subunsur",
                    },
                ],
            })
            .api();

        // move datatable button to inside download button
        $(".dt-buttons").appendTo("#download-button");
        $(".dt-buttons").appendTo("#download-button");
        $(".dataTables_filter").appendTo("#filter-search-wrapper");
        $(".dataTables_filter").find("input").addClass("form-control");
        // .dataTables_filter width 100%
        $(".dataTables_filter").css("width", "100%");
        // .dataTables_filter label width 100%
        $(".dataTables_filter label").css("width", "100%");
        // input height 35px
        $(".dataTables_filter input").css("height", "35px");
        // make label text bold and black
        $(".dataTables_filter label").css("font-weight", "bold");
        // remove bottom margin from .dataTables_filter
        $(".dataTables_filter label").css("margin-bottom", "0");

        $(".dataTables_filter input").attr(
            "placeholder",
            "Cari berdasarkan unsur atau subunsur"
        );
        // add padding x 10px to .dataTables_filter input
        $(".dataTables_filter input").css("padding", "0 10px");
        $(".dt-buttons").appendTo("#download-button");
    }
    // restart numbering if data table is filter input is changed
    $("#master-subunsur").on("search.dt", function () {
        table
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    });
});

$(document).on("click", ".edit-button", function () {
    var id = $(this).data("id");
    var nama = $(this).data("nama");
    var idUnsur = $(this).data("id-unsur");
    $('input[name="editId"]').val(id);
    $('input[name="editNamaSubUnsur"]').val(nama);
    $("#editMasterUnsurId").val(idUnsur);
    $("#edit-form").attr("action", "/admin/master-subunsur/" + id);
});

$(".submit-btn").click(function () {
    if (
        $('input[name="namaSubUnsur"]').val() == "" ||
        $("#masterUnsurId").val() == ""
    ) {
        return;
    }
    $(this).attr("disabled", true);
    $(this).closest("form").submit();
});

$(document).on("click", ".hapus-button", function () {
    var id = $(this).data("id");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Data tidak dapat dipulihkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $("#form-" + id).trigger("submit");
        }
    });
});
