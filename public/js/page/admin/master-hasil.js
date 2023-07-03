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
                    exportOptions: {
                        columns: [0, 1],
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    exportOptions: {
                        columns: [0, 1],
                    },
                },
            ],
        })
        .buttons()
        .container()
        .appendTo("#master-iku_wrapper .col-md-6:eq(0)");
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
            console.log(e);
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
            Swal.fire({
                type: "success",
                icon: "success",
                title: "Berhasil!",
                text: `${response.message}`,
                showConfirmButton: false,
                timer: 3000,
            });

            $("#modal-edit-masterhasil").modal("hide");
            setTimeout(location.reload(), 1000);
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
        confirmButtonColor: "#394eea",
        cancelButtonColor: "#fc544b",
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
                    Swal.fire({
                        type: "success",
                        icon: "success",
                        title: "Berhasil!",
                        text: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    setTimeout(location.reload(), 1000);
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});
