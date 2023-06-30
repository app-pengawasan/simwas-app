let table = $("#table-pagu-anggaran");
let rupiah = document.getElementsByClassName("rupiah");

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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    },
                },
            ],
        })
        .buttons()
        .container()
        .appendTo("#table-master-anggaran_wrapper .col-md-6:eq(0)");
});

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
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/pagu-anggaran/${dataId}`,
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
                    setTimeout(location.reload(), 3000);
                },
                error: function (e) {
                    Swal.fire({
                        type: "error",
                        icon: "error",
                        title: "Gagal",
                        text: "Gagal menghapus data, silahkan hubungi tim TI",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    console.log(e);
                },
            });
        }
    });
});

for (i = 0; i <= rupiah.length; i++) {
    let tmp = rupiah[i].innerText;
    rupiah[i].innerText = formatRupiah(tmp, "Rp. ");
}
