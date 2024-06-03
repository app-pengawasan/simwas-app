$(function () {
    let table;
    if ($("#master-sasaran").length) {
        table = $("#master-sasaran")
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
                            columns: [0, 1, 2],
                        },
                    },
                    {
                        extend: "pdf",
                        className: "btn-danger",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        exportOptions: {
                            columns: [0, 1, 2],
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
            "Cari berdasarkan tujuan atau sasaran..."
        );
        $(".dataTables_filter input").css("padding", "0 10px");
        $(".dt-buttons").appendTo("#download-button");
    }
    $("#master-sasaran").on("search.dt", function () {
        table
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    });
});

$("#create-btn").on("click", function (e) {
    // Reset invalid message while modal open
    $("#error-tujuan").text("");
    $("#error-sasaran").text("");
});

$("#create-tujuan").on("change", function () {
    let tahun_mulai = $("#create-tujuan option:selected").data("mulai");
    let tahun_selesai = $("#create-tujuan option:selected").data("selesai");

    $("#create-tahun_mulai").val(tahun_mulai);
    $("#create-tahun_selesai").val(tahun_selesai);
});

$(".submit-btn").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");

    let tujuan = $("#create-tujuan option:selected").val();
    let sasaran = $("#create-sasaran").val();
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
        url: `/admin/master-sasaran`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            tujuan: tujuan,
            sasaran: sasaran,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                console.log(key);
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = `${value}`;
            });
            Swal.close();
        },
    });
});

$(".edit-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
    // Reset invalid message while modal open
    $("#error-id_tujuan").text("");
    $("#error-sasaran").text("");

    $.ajax({
        url: `/admin/master-sasaran/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            $("#edit-id_sasaran").val(response.data[0].id_sasaran);
            $("#edit-tujuan").val(response.data[0].id_tujuan);
            let tahun_mulai = $("#edit-tujuan option:selected").data("mulai");
            let tahun_selesai = $("#edit-tujuan option:selected").data(
                "selesai"
            );
            $("#edit-tahun_mulai").val(tahun_mulai);
            $("#edit-tahun_selesai").val(tahun_selesai);
            $("#edit-sasaran").val(response.data[0].sasaran);
            $("#edit-tujuan").on("change", function () {
                let tahun_mulai = $("#edit-tujuan option:selected").data(
                    "mulai"
                );
                let tahun_selesai = $("#edit-tujuan option:selected").data(
                    "selesai"
                );

                $("#edit-tahun_mulai").val(tahun_mulai);
                $("#edit-tahun_selesai").val(tahun_selesai);
            });
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");

    let id_sasaran = $("#edit-id_sasaran").val();
    let tujuan = $("#edit-tujuan").val();
    let sasaran = $("#edit-sasaran").val();

    $.ajax({
        url: `/admin/master-sasaran/${id_sasaran}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            id_sasaran: id_sasaran,
            tujuan: tujuan,
            sasaran: sasaran,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                if (key != "id_sasaran") {
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
                url: `/admin/master-sasaran/${dataId}`,
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
