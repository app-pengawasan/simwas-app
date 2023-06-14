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
        .appendTo("#master-tujuan_wrapper .col-md-6:eq(0)");
});

$(".edit-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
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
            Swal.fire({
                type: "success",
                icon: "success",
                title: "Berhasil!",
                text: `${response.message}`,
                showConfirmButton: false,
                timer: 3000,
            });

            let tujuan = `
                <tr id="index_${response.data[0].id_tujuan}">
                    <td>${response.data[0].tahun_mulai} - ${response.data[0].tahun_selesai}</td>
                    <td>${response.data[0].tujuan}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-warning edit-btn"
                            data-id="${response.data[0].id_tujuan}" style="width: 42px"
                            data-toggle="modal" data-target="#modal-edit-mastertujuan">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn btn-danger delete-btn"
                            data-id="${response.data[0].id_tujuan}" style="width: 42px">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            `;

            $(`#index_${response.data[0].id_tujuan}`).replaceWith(tujuan);
            $("#modal-edit-mastertujuan").modal("hide");
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
                url: `/admin/master-tujuan/${dataId}`,
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
                    $(`#index_${dataId}`).remove();
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});
