$(function () {
    let table;
    if ($("#table-pagu-anggaran").length) {
        table = $("#table-pagu-anggaran")
            .dataTable({
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
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                        },
                    },
                    {
                        extend: "pdf",
                        className: "btn-danger",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                        },
                    },
                ],
                oLanguage: {
                    sSearch: "Cari:",
                    sZeroRecords: "Data tidak ditemukan",
                    sEmptyTable: "Data tidak ditemukan",
                    sInfo: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    sInfoEmpty: "Menampilkan 0 - 0 dari 0 data",
                    sInfoFiltered: "(disaring dari _MAX_ data)",
                    sLengthMenu: "Tampilkan _MENU_ data",
                    oPaginate: {
                        sPrevious: "Sebelumnya",
                        sNext: "Selanjutnya",
                    },
                },
            })
            .api();
        $(".dataTables_filter").appendTo("#filter-search-wrapper");
        $(".dataTables_filter").find("input").addClass("form-control");
        // .dataTables_filter width 100%
        $(".dataTables_filter").css("width", "100%");
        // .dataTables_filter label width 100%
        $(".dataTables_filter label").css("width", "100%");
        // input height 35px
        $(".dataTables_filter input").css("height", "35px");
        // make label text bold and black
        $(".dataTables_filter label").css("font-weight", "bold");
        // remove bottom margin from .dataTables_filter
        $(".dataTables_filter label").css("margin-bottom", "0");

        $(".dataTables_filter input").attr("placeholder", "Lakukan Pencarian");
        // add padding x 10px to .dataTables_filter input
        $(".dataTables_filter input").css("padding", "0 10px");
        $(".dt-buttons").appendTo("#download-button");
    }

    $("#table-pagu-anggaran").on("search.dt", function () {
        table
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    });

    function filterTable() {
        let filterKomponen = $("#filter-komponen").val();
        let filterAkun = $("#filter-akun").val();

        table
            .column(3)
            .search(filterKomponen, true, false)
            .column(4)
            .search(filterAkun, true, false)
            .draw();

        // reset numbering in table first column
        table
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    }
    $("#filter-komponen, #filter-akun").on("change", function () {
        filterTable();
    });
});

let rupiah = document.getElementsByClassName("rupiah");

$(".delete-btn").on("click", function (e) {
    e.preventDefault();
    // console.log("klik");
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
                        text: `${e.responseJSON.message}`,
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    // console.log(e);
                },
            });
        }
    });
});

for (i = 0; i <= rupiah.length; i++) {
    let tmp = rupiah[i].innerText;
    rupiah[i].innerText = formatRupiah(tmp, "Rp. ");
}
