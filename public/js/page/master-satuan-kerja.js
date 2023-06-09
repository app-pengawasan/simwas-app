let table = $("#master-satuan-kerja");

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
        .appendTo("#master-satuan-kerja_wrapper .col-md-6:eq(0)");
});

$(".edit-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
    $.ajax({
        url: `/admin/master-satuan-kerja/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            $("#edit-idobjek").val(response.data[0].id_objek);
            $("#edit-kode-wilayah").val(response.data[0].kode_wilayah);
            $("#edit-kode-satuankerja").val(response.data[0].kode_satuankerja);
            $("#edit-nama").val(response.data[0].nama);
        },
    });
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");
    let id_objek = $("#edit-idobjek").val();
    let kode_wilayah = $("#edit-kode-wilayah").val();
    let kode_satuankerja = $("#edit-kode-satuankerja").val();
    let nama = $("#edit-nama").val();

    $.ajax({
        url: `/admin/master-satuan-kerja/${id_objek}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            kode_wilayah: kode_wilayah,
            kode_satuankerja: kode_satuankerja,
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

            let satuankerja = `
                <tr id="index_${response.data[0].id_objek}">
                    <td>${response.data[0].kode_wilayah}</td>
                    <td>${response.data[0].kode_satuankerja}</td>
                    <td>${response.data[0].nama}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-warning edit-btn"
                            data-id="${response.data[0].id_objek}" style="width: 42px"
                            data-toggle="modal" data-target="#modal-edit-satuankerja">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn btn-danger delete-btn"
                            data-id="${response.data[0].id_objek}" style="width: 42px">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            `;

            $(`#index_${response.data[0].id_objek}`).replaceWith(satuankerja);
            $("#modal-edit-satuankerja").modal("hide");
        },
        error: function (error) {
            // $("#modal-edit-satuankerja").modal("hide");
            // if (error.responseJSON.kode_satuankerja[0]) {
            //     //show alert
            //     $("#alert-kode-satuan-kerja-edit").removeClass("d-none");
            //     $("#alert-kode-satuan-kerja-edit").addClass("d-block");

            //     //add message to alert
            //     $("#alert-kode-satuan-kerja-edit").html(
            //         error.responseJSON.kode_satuankerja[0]
            //     );
            // }

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
                url: `/admin/master-satuan-kerja/${dataId}`,
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
