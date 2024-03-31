let table = $("#table-usulan-surat-srikandi")
    .dataTable({
        dom: "Bfrtip",
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        // filter: false,
        buttons: [
            // {
            //     extend: "excel",
            //     className: "btn-success",
            //     text: '<i class="fas fa-file-excel"></i> Excel',
            //     exportOptions: {
            //         columns: [0, 1, 2, 3],
            //     },
            // },
            // {
            //     extend: "pdf",
            //     className: "btn-danger",
            //     text: '<i class="fas fa-file-pdf"></i> PDF',
            //     exportOptions: {
            //         columns: [0, 1, 2, 3],
            //     },
            // },
        ],
    })
    .api();

function filterTable() {
    let filterYear = $("#filter-year").val();
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
        .column(1)
        .search(filterYear, true, false)
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

$("#filter-year, #filter-status, #filter-surat").on("change", function () {
    filterTable();
});
$("#filter-search").on("keyup", function () {
    filterTable();
});
filterTable();

$(".dataTables_filter").hide();
