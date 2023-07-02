let table = $("#master-iku");

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
                        columns: [0, 1, 2, 3],
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                    },
                },
            ],
        })
        .buttons()
        .container()
        .appendTo("#master-iku_wrapper .col-md-6:eq(0)");
});

$("#create-btn").on("click", function (e) {
    console.log("modal open");
    // Reset invalid message while modal open
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
            });
        }
    });
});
