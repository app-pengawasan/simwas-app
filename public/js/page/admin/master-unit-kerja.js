let table;

if ($("#master-unit-kerja").length) {
    table = $("#master-unit-kerja")
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
                        columns: [0, 1 ,2],
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: [0, 1, 2],
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

        $(".dt-buttons").appendTo("#download-button");
        $(".dt-buttons").appendTo("#download-button");
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

        $(".dataTables_filter input").attr(
            "placeholder",
            "Cari berdasarkan Kode atau Nama Unit Kerja"
        );
        // add padding x 10px to .dataTables_filter input
        $(".dataTables_filter input").css("padding", "0 10px");
        $(".dt-buttons").appendTo("#download-button");
}

$(".submit-btn").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");
    let kode_wilayah = $("#create-kode_wilayah").val();
    let kode_unitkerja = $("#create-kode_unitkerja").val();
    let nama = $("#create-nama").val();
    let errorKodeWilayah = $("#error-kode_wilayah");
    let errorKodeUnitKerja = $("#error-kode_unitkerja");
    let errorNama = $("#error-nama");

    $.ajax({
        url: `/admin/master-unit-kerja`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            kode_wilayah: kode_wilayah,
            kode_unitkerja: kode_unitkerja,
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
    let errorKodeWilayah = $("#error-kode_wilayah");
    let errorKodeUnitKerja = $("#error-kode_unitkerja");
    let errorNama = $("#error-nama");

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
            location.reload();
        },
        error: function (error) {
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-edit-${key}`);
                errorMessage.innerText = `${value}`;
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
                url: `/admin/master-unit-kerja/${dataId}`,
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
