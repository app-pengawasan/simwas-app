let table = $("#master-wilayah-kerja");

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
        .appendTo("#master-wilayah-kerja_wrapper .col-md-6:eq(0)");
});

$(".submit-btn").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");
    let kode_wilayah = $("#create-kode_wilayah").val();
    let nama = $("#create-nama").val();

    $.ajax({
        url: `/admin/master-wilayah-kerja`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            kode_wilayah: kode_wilayah,
            nama: nama,
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
    $("#error-edit-kode_wilayah").text("");
    $("#error-edit-nama").text("");
    $.ajax({
        url: `/admin/master-wilayah-kerja/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            $("#edit-idobjek").val(response.data[0].id_objek);
            $("#edit-kode-wilayah").val(response.data[0].kode_wilayah);
            $("#edit-kode-wilayahkerja").val(
                response.data[0].kode_wilayahkerja
            );
            $("#edit-nama").val(response.data[0].nama);
        },
    });
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");
    let id_objek = $("#edit-idobjek").val();
    let kode_wilayah = $("#edit-kode-wilayah").val();
    let nama = $("#edit-nama").val();

    $.ajax({
        url: `/admin/master-wilayah-kerja/${id_objek}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            kode_wilayah: kode_wilayah,
            nama: nama,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-edit-${key}`);
                errorMessage.innerText = `${value}`;
            });
            console.log(error);
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
                url: `/admin/master-wilayah-kerja/${dataId}`,
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
