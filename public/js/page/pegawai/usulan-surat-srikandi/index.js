$(function () {
    let table = $("#table-usulan-surat-srikandi")
        .dataTable({
            dom: "Bfrtip",
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            // filter: false,
            pageLength: 25,
            buttons: [
                {
                    extend: "excel",
                    className: "btn-success",
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
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

    function filterTable() {
        let filterStatus = $("#filter-status").val();
        let filterSurat = $("#filter-surat").val();
        let filterSearch = $("#filter-search").val();

        if (filterStatus === "Semua") {
            filterStatus = "";
        }
        if (filterSurat === "Semua") {
            filterSurat = "";
        }

        table
            .column(2)
            .search(filterSearch, true, false)
            .column(3)
            .search(filterSurat, true, false)
            .column(4)
            .search(filterStatus, true, false)
            .draw();

        // reset numbering in table first column
        table
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    }

    $("#filter-status, #filter-surat").on("change", function () {
        filterTable();
    });
    $("#filter-search").on("keyup", function () {
        filterTable();
    });
    filterTable();

    $(".dataTables_filter").hide();
});

$("#yearSelect").on("change", function () {
    let year = $(this).val();
    $("#yearForm").attr("action", `?year=${year}`);
    $("#yearForm").find('[name="_token"]').remove();
    $("#yearForm").trigger("submit");
});
