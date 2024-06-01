$(function () {
    let table;

    if ($("#tim-kerja").length) {
        table = $("#tim-kerja")
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
                            columns: [0, 1, 2, 3, 4, 5, 6],
                        },
                    },
                    {
                        extend: "pdf",
                        className: "btn-danger",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6],
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

        $(".dataTables_filter input").attr("placeholder", "Cari rencana kerja");
        // add padding x 10px to .dataTables_filter input
        $(".dataTables_filter input").css("padding", "0 10px");
        $(".dt-buttons").appendTo("#download-button");
    }

    $("#tim-kerja").on("search.dt", function () {
        table
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    });

    function filterTable() {
        let filterUnitKerja = $("#filter-unit-kerja").val();

        if (filterUnitKerja == "Semua") {
            filterUnitKerja = "";
        }

        if (filterUnitKerja !== "") {
            table
                .column(2)
                .search("^" + filterUnitKerja + "$", true, false)
                .draw();
        } else {
            table.column(2).search(filterUnitKerja, true, false).draw();
        }
        // reset numbering in table first column
        table
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    }
    $("#filter-unit-kerja").on("change", function () {
        filterTable();
    });
});

$("#create-btn").on("click", function () {
    $("#error-tahun").text("");
    $("#error-unitkerja").text("");
    $("#error-iku").text("");
    $("#error-nama").text("");
    $("#error-ketua").text("");
});

$("#create-iku").on("change", function () {
    let idsasaran = $("#create-iku option:selected").data("idsasaran");
    $("#create-id_sasaran").val(idsasaran);
    let idtujuan = $("#create-id_sasaran option:selected").data("idtujuan");
    $("#create-id_tujuan").val(idtujuan);
});

$(".submit-btn").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");

    let tahun = $("#create-tahun").val();
    let unitkerja = $("#create-unitkerja").val();
    let iku = $("#create-iku").val();
    let nama = $("#create-nama").val();
    let ketua = $("#create-ketua").val();
    let operator = $("#create-operator").val();

    // Reset invalid message while modal open
    $("#error-tahun").text("");
    $("#error-unitkerja").text("");
    $("#error-iku").text("");
    $("#error-nama").text("");
    $("#error-ketua").text("");

    // return alert([tahun, unitkerja, iku, nama, ketua]);

    $.ajax({
        url: `/admin/tim-kerja`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            tahun: tahun,
            unitkerja: unitkerja,
            iku: iku,
            nama: nama,
            ketua: ketua,
            operator: operator,
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

$("#id_sasaran").on("change", function () {
    let idtujuan = $("#id_sasaran option:selected").data("idtujuan");
    $("#id_tujuan").val(idtujuan);
});

$("#edit-id_sasaran").on("change", function () {
    let id_tujuan = $("#edit-id_sasaran option:selected").data("idtujuan");
    $("#edit-id_tujuan").val(id_tujuan);
});

$(".edit-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
    $.ajax({
        url: `/admin/master-iku/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            console.log(response);
            $("#edit-id_iku").val(response.data[0].id_iku);
            $("#edit-id_sasaran").val(response.data[0].id_sasaran);
            let idtujuan = $("#edit-id_sasaran option:selected").data(
                "idtujuan"
            );
            $("#edit-id_tujuan").val(idtujuan);
            $("#edit-iku").val(response.data[0].iku);
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");

    let id_tujuan = $("#edit-id_tujuan").val();
    let id_sasaran = $("#edit-id_sasaran").val();
    let id_iku = $("#edit-id_iku").val();
    // let tujuan      = $("#edit-id_tujuan option:selected").val();
    // let tahun_mulai = $("#edit-tahun_mulai").val();
    // let tahun_selesai = $("#edit-tahun_selesai").val();
    let iku = $("#edit-iku").val();

    $.ajax({
        url: `/admin/master-iku/${id_iku}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            id_iku: id_iku,
            id_sasaran: id_sasaran,
            iku: iku,
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

            $("#modal-edit-masteriku").modal("hide");
            setTimeout(location.reload(), 1000);
            console.log(response.data[0]);
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
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/tim-kerja/${dataId}`,
                type: "DELETE",
                cache: false,
                data: {
                    _token: token,
                },
                success: function (response) {
                    location.reload();
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});
$("#yearSelect").on("change", function () {
    let year = $(this).val();
    $("#yearForm").attr("action", `?year=${year}`);
    $("#yearForm").find('[name="_token"]').remove();
    $("#yearForm").trigger("submit");
});

$(".btn-edit-timkerja").on("click", function () {
    let dataId = $(this).attr("data-id");
    $.ajax({
        url: `/admin/tim-kerja/detail/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            $("#edit-id-timkerja").val(response.data.id_timkerja);
            $("#edit-tahun").select2("trigger", "select", {
                data: { id: response.data.tahun, text: response.data.tahun },
            });
            $("#edit-unitkerja").select2("trigger", "select", {
                data: {
                    id: response.data.unitkerja,
                    text: response.data.unitkerja,
                },
            });
            $("#edit-iku").select2("trigger", "select", {
                data: { id: response.data.id_iku, text: response.data.id_iku },
            });

            $("#edit-nama").val(response.data.nama);
            $("#edit-ketua").select2("trigger", "select", {
                data: {
                    id: response.data.id_ketua,
                    text: response.data.id_ketua,
                },
            });
            $("#edit-operator").select2("trigger", "select", {
                data: {
                    id: response.data.id_operator,
                    text: response.data.id_operator,
                },
            });
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$("#edit-iku").on("change", function () {
    let idIKU = $(this).val();
    $.ajax({
        url: `/admin/master-iku/${idIKU}`,
        type: "GET",
        cache: false,
        success: function (response) {
            console.log(response);
            $("#edit-id_iku").val(response.data[0].id_iku);
            $("#edit-id_sasaran").val(response.data[0].id_sasaran);
            let idtujuan = $("#edit-id_sasaran option:selected").data(
                "idtujuan"
            );
            $("#edit-id_tujuan").val(idtujuan);
            // $("#edit-iku").val(response.data[0].iku);
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$("#submit-edit-btn").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");

    let id_timkerja = $("#edit-id-timkerja").val();
    let tahun = $("#edit-tahun").val();
    let unitkerja = $("#edit-unitkerja").val();
    let iku = $("#edit-iku").val();
    let nama = $("#edit-nama").val();
    let ketua = $("#edit-ketua").val();
    let operator = $("#edit-operator").val();

    $.ajax({
        url: `/admin/tim-kerja/update/${id_timkerja}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            id_timkerja: id_timkerja,
            tahun: tahun,
            unitkerja: unitkerja,
            iku: iku,
            nama: nama,
            ketua: ketua,
            operator: operator,
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

            $("#modal-edit-timkerja").modal("hide");
            setTimeout(location.reload(), 3000);
            console.log(response.data[0]);
        },
        error: function (error) {
            Swal.fire({
                type: "error",
                icon: "error",
                title: "Gagal!",
                text: `${error.message}`,
                showConfirmButton: false,
                timer: 3000,
            });
        },
    });
});
