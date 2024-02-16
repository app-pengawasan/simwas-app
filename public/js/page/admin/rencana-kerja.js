let table = $("#tim-kerja");

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
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                    },
                },
            ],
        })
        .buttons()
        .container()
        .appendTo("#tim-kerja_wrapper .col-md-6:eq(0)");
});

$("#create-btn").on("click", function () {
    $("#error-tahun").text("");
    $("#error-unitkerja").text("");
    $("#error-iku").text("");
    $("#error-nama").text("");
    $("#error-ketua").text("");
});

$("#create-iku").on("change", function () {
    let idsasaran = $("#create-iku option:selected").data("idsasaran");
    $("#create-id_sasaran").val(idsasaran);
    let idtujuan = $("#create-id_sasaran option:selected").data("idtujuan");
    $("#create-id_tujuan").val(idtujuan);
});

$(".submit-btn").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");

    let tahun = $("#create-tahun").val();
    let unitkerja = $("#create-unitkerja").val();
    let iku = $("#create-iku").val();
    let nama = $("#create-nama").val();
    let ketua = $("#create-ketua").val();
    let operator = $("#create-operator").val();

    // Reset invalid message while modal open
    $("#error-tahun").text("");
    $("#error-unitkerja").text("");
    $("#error-iku").text("");
    $("#error-nama").text("");
    $("#error-ketua").text("");

    // return alert([tahun, unitkerja, iku, nama, ketua]);

    $.ajax({
        url: `/admin/tim-kerja`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            tahun: tahun,
            unitkerja: unitkerja,
            iku: iku,
            nama: nama,
            ketua: ketua,
            operator: operator,
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
            console.log(errors);
        },
    });
});

$("#id_sasaran").on("change", function () {
    let idtujuan = $("#id_sasaran option:selected").data("idtujuan");
    $("#id_tujuan").val(idtujuan);
});

$("#edit-id_sasaran").on("change", function () {
    let id_tujuan = $("#edit-id_sasaran option:selected").data("idtujuan");
    $("#edit-id_tujuan").val(id_tujuan);
});

$(".edit-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
    $.ajax({
        url: `/admin/master-iku/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            console.log(response);
            $("#edit-id_iku").val(response.data[0].id_iku);
            $("#edit-id_sasaran").val(response.data[0].id_sasaran);
            let idtujuan = $("#edit-id_sasaran option:selected").data(
                "idtujuan"
            );
            $("#edit-id_tujuan").val(idtujuan);
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

    let id_tujuan = $("#edit-id_tujuan").val();
    let id_sasaran = $("#edit-id_sasaran").val();
    let id_iku = $("#edit-id_iku").val();
    // let tujuan      = $("#edit-id_tujuan option:selected").val();
    // let tahun_mulai = $("#edit-tahun_mulai").val();
    // let tahun_selesai = $("#edit-tahun_selesai").val();
    let iku = $("#edit-iku").val();

    $.ajax({
        url: `/admin/master-iku/${id_iku}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            id_iku: id_iku,
            id_sasaran: id_sasaran,
            iku: iku,
        },
        success: function (response) {
            Swal.fire({
                type: "success",
                icon: "success",
                title: "Berhasil!",
                text: `${response.message}`,
                showConfirmButton: false,
                timer: 3000,
            });

            $("#modal-edit-masteriku").modal("hide");
            setTimeout(location.reload(), 1000);
            console.log(response.data[0]);
        },
        error: function (error) {
            console.log(error.responseJSON);
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
                url: `/admin/tim-kerja/${dataId}`,
                type: "DELETE",
                cache: false,
                data: {
                    _token: token,
                },
                success: function (response) {
                    location.reload();
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});
