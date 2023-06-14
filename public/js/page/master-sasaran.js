let table = $("#master-sasaran");

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
        .appendTo("#master-sasaran_wrapper .col-md-6:eq(0)");
});

$("#id_tujuan").on("change", function () {
    let tahun_mulai = $("#id_tujuan option:selected").data("mulai");
    let tahun_selesai = $("#id_tujuan option:selected").data("selesai");

    $("#tahun_mulai").val(tahun_mulai);
    $("#tahun_selesai").val(tahun_selesai);
});

$(".edit-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
    $.ajax({
        url: `/admin/master-sasaran/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            $("#edit-id_sasaran").val(response.data[0].id_sasaran);
            $("#edit-id_tujuan").val(response.data[0].id_tujuan);
            let tahun_mulai = $("#edit-id_tujuan option:selected").data(
                "mulai"
            );
            let tahun_selesai = $("#edit-id_tujuan option:selected").data(
                "selesai"
            );
            $("#edit-tahun_mulai").val(tahun_mulai);
            $("#edit-tahun_selesai").val(tahun_selesai);
            $("#edit-sasaran").val(response.data[0].sasaran);
            $("#edit-id_tujuan").on("change", function () {
                let tahun_mulai = $("#edit-id_tujuan option:selected").data(
                    "mulai"
                );
                let tahun_selesai = $("#edit-id_tujuan option:selected").data(
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
    let id_tujuan = $("#edit-id_tujuan").val();
    let tujuan = $("#edit-id_tujuan option:selected").val();
    let tahun_mulai = $("#edit-tahun_mulai").val();
    let tahun_selesai = $("#edit-tahun_selesai").val();
    let sasaran = $("#edit-sasaran").val();

    $.ajax({
        url: `/admin/master-sasaran/${id_sasaran}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            id_sasaran: id_sasaran,
            id_tujuan: id_tujuan,
            tujuan: tujuan,
            tahun_mulai: tahun_mulai,
            tahun_selesai: tahun_selesai,
            sasaran: sasaran,
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

            // let sasaran = `
            //     <tr id="index_${response.data[0].id_sasaran}">
            //         <td>${response.data[0].tahun_mulai} - ${response.data[0].tahun_selesai}</td>
            //         <td>${response.data[0].tujuan}</td>
            //         <td>
            //             <a href="javascript:void(0)" class="btn btn-warning edit-btn"
            //                 data-id="${response.data[0].id_tujuan}" style="width: 42px"
            //                 data-toggle="modal" data-target="#modal-edit-mastertujuan">
            //                 <i class="fas fa-edit"></i>
            //             </a>
            //             <a href="javascript:void(0)" class="btn btn-danger delete-btn"
            //                 data-id="${response.data[0].id_tujuan}" style="width: 42px">
            //                 <i class="fas fa-trash"></i>
            //             </a>
            //         </td>
            //     </tr>
            // `;

            console.log(response.data[0]);
            // $(`#index_${response.data[0].id_sasaran}`).replaceWith(sasaran);
            $("#modal-edit-mastersasaran").modal("hide");
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
                url: `/admin/master-sasaran/${dataId}`,
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
