let table = $("#table-master-anggaran");

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
                        columns: [0, 1, 2],
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    text: '<i class="fas fa-file-pdf"></i> Pdf',
                    exportOptions: {
                        columns: [0, 1, 2],
                    },
                },
            ],
        })
        .buttons()
        .container()
        .appendTo("#table-master-anggaran_wrapper .col-md-6:eq(0)");
});

// Kembali ke Halaman sebelumnya
$("#btn-back").on("click", function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Data master anggaran belum tersimpan.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#394eea",
        cancelButtonColor: "#fc544b",
        confirmButtonText: "Yakin",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/admin/master-anggaran";
        }
    });
});

// Menghapus pegawai
$(".delete-btn").on("click", function (e) {
    e.preventDefault();
    console.log("klik");
    let dataId = $(this).attr("data-id");
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Data yang dihapus tidak dapat dipulihkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#394eea",
        cancelButtonColor: "#fc544b",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/master-anggaran/${dataId}`,
                method: "DELETE",
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
                    setTimeout(location.reload(), 1500);
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});
