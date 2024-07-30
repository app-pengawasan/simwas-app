let table = $("#master-hasil");

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
        })
        .buttons()
        .container()
        .appendTo("#master-hasil_wrapper .col-md-6:eq(0)");
});

$("#create-btn").on("click", function (e) {
    // console.log("modal open");
    // Reset invalid message while modal open
    $("#error-unsur").text("");
    $("#error-subunsur1").text("");
    $("#error-subunsur2").text("");
    $("#error-kategori_hasilkerja").text("");
    $("#error-kategori_pelaksana").text("");
});

$(".submit-btn").on("click", function (e) {
    e.preventDefault();
    // Reset error message
    $("#error-unsur").text("");
    $("#error-subunsur1").text("");
    $("#error-subunsur2").text("");
    $("#error-kategori_hasilkerja").text("");
    $("#error-kategori_pelaksana").text("");

    let token = $("meta[name='csrf-token']").attr("content");
    let unsur = $("#create-unsur").val();
    let subunsur1 = $("#create-subunsur1").val();
    let subunsur2 = $("#create-subunsur2").val();
    let kategori_hasilkerja = $("#create-kategori_hasilkerja").val();
    let kategori_pelaksana = $("#create-kategori_pelaksana").val();

    $.ajax({
        url: `/admin/master-hasil`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            unsur: unsur,
            subunsur1: subunsur1,
            subunsur2: subunsur2,
            kategori_hasilkerja: kategori_hasilkerja,
            kategori_pelaksana: kategori_pelaksana,
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
            // console.log(errors);
        },
    });
});

$(".edit-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
    $.ajax({
        url: `/admin/master-hasil/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            $("#edit-id_master_hasil").val(response.data[0].id_master_hasil);
            $("#edit-unsur").val(response.data[0].unsur);
            $("#edit-subunsur1").val(response.data[0].subunsur1);
            $("#edit-subunsur2").val(response.data[0].subunsur2);
            $("#edit-kategori_hasilkerja").val(
                response.data[0].kategori_hasilkerja
            );
            $("#edit-kategori_pelaksana").val(
                response.data[0].kategori_pelaksana
            );
        },
        error: function (e) {
            // console.log(e);
        },
    });
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");
    let id_master_hasil = $("#edit-id_master_hasil").val();
    let unsur = $("#edit-unsur").val();
    let subunsur1 = $("#edit-subunsur1").val();
    let subunsur2 = $("#edit-subunsur2").val();
    let kategori_hasilkerja = $("#edit-kategori_hasilkerja").val();
    let kategori_pelaksana = $("#edit-kategori_pelaksana").val();

    $.ajax({
        url: `/admin/master-hasil/${id_master_hasil}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            id_master_hasil: id_master_hasil,
            unsur: unsur,
            subunsur1: subunsur1,
            subunsur2: subunsur2,
            kategori_hasilkerja: kategori_hasilkerja,
            kategori_pelaksana: kategori_pelaksana,
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
                url: `/admin/master-hasil/${dataId}`,
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
