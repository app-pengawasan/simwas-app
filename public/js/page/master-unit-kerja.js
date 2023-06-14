let table = $("#master-unit-kerja");

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
        .appendTo("#master-unit-kerja_wrapper .col-md-6:eq(0)");
});

$(".edit-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
    $.ajax({
        url: `/admin/master-unit-kerja/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            $("#edit-idobjek").val(response.data[0].id_objek);
            $("#edit-kode-wilayah").val(response.data[0].kode_wilayah);
            $("#edit-kode-unitkerja").val(response.data[0].kode_unitkerja);
            $("#edit-nama").val(response.data[0].nama);
        },
    });
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");
    let id_objek = $("#edit-idobjek").val();
    let kode_wilayah = $("#edit-kode-wilayah").val();
    let kode_unitkerja = $("#edit-kode-unitkerja").val();
    let nama = $("#edit-nama").val();

    $.ajax({
        url: `/admin/master-unit-kerja/${id_objek}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            kode_wilayah: kode_wilayah,
            kode_unitkerja: kode_unitkerja,
            nama: nama,
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

            let unitkerja = `
                <tr id="index_${response.data[0].id_objek}">
                    <td>${response.data[0].kode_unitkerja}</td>
                    <td>${response.data[0].nama}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-warning edit-btn"
                            data-id="${response.data[0].id_objek}" style="width: 42px"
                            data-toggle="modal" data-target="#modal-edit-unitkerja">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn btn-danger delete-btn"
                            data-id="${response.data[0].id_objek}" style="width: 42px">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            `;

            $(`#index_${response.data[0].id_objek}`).replaceWith(unitkerja);
            $("#modal-edit-unitkerja").modal("hide");
        },
        error: function (error) {
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
        confirmButtonColor: "#394eea",
        cancelButtonColor: "#fc544b",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/master-unit-kerja/${dataId}`,
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
            });
        }
    });
});
