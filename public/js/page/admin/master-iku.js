$(function () {
    let table;
    if ($("#master-iku").length) {
        table = $("#master-iku")
            .dataTable({
                dom: "Bfrtip",
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: [
                    {
                        extend: "excel",
                        className: "btn-success",
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                        },
                    },
                    {
                        extend: "pdf",
                        className: "btn-danger",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                        },
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
            "Cari berdasarkan tujuan, sasaran, atau IKU..."
        );
        // add padding x 10px to .dataTables_filter input
        $(".dataTables_filter input").css("padding", "0 10px");
        $(".dt-buttons").appendTo("#download-button");
    }
    // restart numbering if data table is filter input is changed
    $("#master-iku").on("search.dt", function () {
        table
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    });
});

$("#create-btn").on("click", function (e) {

    $("#error-sasaran").text("");
    $("#error-iku").text("");
});

$("#create-sasaran").on("change", function () {
    let idtujuan = $("#create-sasaran option:selected").data("idtujuan");
    $("#create-id_tujuan").val(idtujuan);
});

$(".submit-btn").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");

    let sasaran = $("#create-sasaran").val();
    let iku = $("#create-iku").val();


    Swal.fire({
        title: "Menyimpan Data",
        html: "Mohon tunggu sebentar",
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: () => !Swal.isLoading(),
    });

    $.ajax({
        url: `/admin/master-iku`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            sasaran: sasaran,
            iku: iku,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = `${value}`;
            });
            Swal.close();
        },
    });
});

$("#edit-sasaran").on("change", function () {
    let id_tujuan = $("#edit-sasaran option:selected").data("idtujuan");
    $("#edit-tujuan").val(id_tujuan);
});

$(".edit-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
    // Reset invalid message while modal open
    $("#error-edit-sasaran").text("");
    $("#error-edit-iku").text("");
    $.ajax({
        url: `/admin/master-iku/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            console.log(response);
            $("#edit-id_iku").val(response.data[0].id_iku);
            $("#edit-sasaran").val(response.data[0].id_sasaran);
            let idtujuan = $("#edit-sasaran option:selected").data("idtujuan");
            $("#edit-tujuan").val(idtujuan);
            $("#edit-iku").val(response.data[0].iku);
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");

    let sasaran = $("#edit-sasaran").val();
    let id_iku = $("#edit-id_iku").val();
    let iku = $("#edit-iku").val();

    $.ajax({
        url: `/admin/master-iku/${id_iku}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            id_iku: id_iku,
            sasaran: sasaran,
            iku: iku,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                if (key != "id_iku") {
                    let errorMessage = document.getElementById(
                        `error-edit-${key}`
                    );
                    errorMessage.innerText = `${value}`;
                }
            });
        },
    });
});

// Delete Data
$(".delete-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
    let token = $("meta[name='csrf-token']").attr("content");

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
            $.ajax({
                url: `/admin/master-iku/${dataId}`,
                type: "DELETE",
                cache: false,
                data: {
                    _token: token,
                },
                success: function (response) {
                    location.reload();
                },
                error: function (error) {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Data masih terhubung dengan data lain!",
                        icon: "error",
                        confirmButtonColor: "var(--primary)",
                    });
                },
            });
        }
    });
});
