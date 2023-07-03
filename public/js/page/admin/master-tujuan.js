let table = $("#master-tujuan");

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
                        columns: [0, 1],
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: [0, 1],
                    },
                },
            ],
        })
        .buttons()
        .container()
        .appendTo("#master-tujuan_wrapper .col-md-6:eq(0)");
});

$("#create-btn").on("click", function (e) {
    console.log("modal open");
    // Reset invalid message while modal open
    $("#error-id_tujuan").text("");
    $("#error-tahun_mulai").text("");
    $("#error-tahun_selesai").text("");
    $("#error-tujuan").text("");
});

$(".submit-btn").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");

    let tahun_mulai = $("#create-tahun_mulai").val();
    let tahun_selesai = $("#create-tahun_selesai").val();
    let tujuan = $("#create-tujuan").val();

    $.ajax({
        url: `/admin/master-tujuan`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            tahun_mulai: tahun_mulai,
            tahun_selesai: tahun_selesai,
            tujuan: tujuan,
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

$(".edit-btn").on("click", function () {
    let dataId = $(this).attr("data-id");

    // Reset invalid message while modal open
    $("#error-edit-id_tujuan").text("");
    $("#error-edit-tahun_mulai").text("");
    $("#error-edit-tahun_selesai").text("");
    $("#error-edit-tujuan").text("");

    $.ajax({
        url: `/admin/master-tujuan/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            $("#edit-id_tujuan").val(response.data[0].id_tujuan);
            $("#edit-tahun_mulai").val(response.data[0].tahun_mulai);
            $("#edit-tahun_selesai").val(response.data[0].tahun_selesai);
            $("#edit-tujuan").val(response.data[0].tujuan);
            console.log(response.data[0]);
        },
    });
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");

    let id_tujuan = $("#edit-id_tujuan").val();
    let tahun_mulai = $("#edit-tahun_mulai").val();
    let tahun_selesai = $("#edit-tahun_selesai").val();
    let tujuan = $("#edit-tujuan").val();

    $.ajax({
        url: `/admin/master-tujuan/${id_tujuan}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            tahun_mulai: tahun_mulai,
            tahun_selesai: tahun_selesai,
            tujuan: tujuan,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                if (key != "id_tujuan") {
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
                url: `/admin/master-tujuan/${dataId}`,
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
