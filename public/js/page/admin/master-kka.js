$(function () {
    let table;
    if ($("#master-kka").length) {
        table = $("#master-kka")
            .dataTable({
                dom: "Bfrtip",
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                pageLength: 25,
                buttons: [
                    {
                        extend: "excel",
                        exportOptions: {
                            columns: [0, 1, 2],
                        },
                        className: "btn-success",
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        filename: "Master Kode Klasifikasi Arsip",
                    },
                    {
                        extend: "pdf",
                        exportOptions: {
                            columns: [0, 1, 2],
                        },
                        className: "btn-danger",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        filename: "Master Kode Klasifikasi Arsip",
                    },
                ],
                oLanguage: {
                    sSearch: "Cari:",
                    sZeroRecords: "Data tidak ditemukan",
                    sEmptyTable: "Data tidak ditemukan",
                    sInfo: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    sInfoEmpty: "Menampilkan 0 - 0 dari 0 data",
                    sInfoFiltered: "(disaring dari _MAX_ data)",
                    sLengthMenu: "Tampilkan _MENU_ data",
                    oPaginate: {
                        sPrevious: "Sebelumnya",
                        sNext: "Selanjutnya",
                    },
                },
            })
            .api();

        $(".dt-buttons").appendTo("#download-button");
        $(".dt-buttons").appendTo("#download-button");
        $(".dataTables_filter").appendTo("#filter-search-wrapper");
        $(".dataTables_filter").find("input").addClass("form-control");
        $(".dataTables_filter").css("width", "100%");
        $(".dataTables_filter label").css("width", "100%");
        $(".dataTables_filter input").css("height", "35px");
        $(".dataTables_filter label").css("font-weight", "bold");
        $(".dataTables_filter label").css("margin-bottom", "0");
        $(".dataTables_filter input").attr(
            "placeholder",
            "Cari Kode Klasifikasi Arsip..."
        );
        $(".dataTables_filter input").css("padding", "0 10px");
        $(".dt-buttons").appendTo("#download-button");
    }
    // restart numbering if data table is filter input is changed
    $("#table-master-pegawai").on("search.dt", function () {
        table
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    });
});

// function when edit-button class clicked
$(document).on("click", ".edit-button", function () {
    var id = $(this).data("id");
    var kode = $(this).data("kode");
    var uraian = $(this).data("uraian");

    $("#edit-kode-kka").val(kode);
    $("#edit-uraian-kka").val(uraian);

    $("#edit-form").attr(
        "action",
        "/admin/master-kode-klasifikasi-arsip/" + id
    );
});

$(".submit-btn").click(function () {
    if ($("#kode-kka").val() == "") {
        $("#error-kode-kka").text("Kode Klasifikasi Arsip tidak boleh kosong");
        $("#kode-kka").addClass("is-invalid");
        return false;
    }
    if ($("#uraian-kka").val() == "") {
        $("#error-uraian-kka").text(
            "Uraian Klasifikasi Arsip tidak boleh kosong"
        );
        $("#uraian-kka").addClass("is-invalid");
        return false;
    }
    $(this).attr("disabled", true);
    $(this).closest("form").submit();
});

$(".submit-edit-btn").click(function () {
    if ($("#edit-kode-kka").val() == "") {
        $("#edit-error-kode-kka").text(
            "Kode Klasifikasi Arsip tidak boleh kosong"
        );
        $("#edit-kode-kka").addClass("is-invalid");
        return false;
    }
    if ($("#edit-uraian-kka").val() == "") {
        $("#edit-error-uraian-kka").text(
            "Uraian Klasifikasi Arsip tidak boleh kosong"
        );
        $("#edit-uraian-kka").addClass("is-invalid");
        return false;
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
            // console.log("#form-" + id);
        }
    });
});
$(document).on("change", "[name^='status-']", function () {
    var id = $(this).attr("name").split("-")[1];

    $.ajax({
        url: "/admin/master-kode-klasifikasi-arsip/edit-status/" + id,
        type: "GET",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            Swal.fire({
                icon: "success",
                title: "Berhasil",
                text: "Status berhasil diubah",
                timer: 1000,
            });
        },
        error: function (data) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Terjadi kesalahan!",
            });
        },
    });
});
