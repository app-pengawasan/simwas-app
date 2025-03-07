$(function () {
    let table;

    if ($("#changelogs").length) {
        table = $("#changelogs")
            .dataTable({
                dom: "Bfrtip",
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                pageLength: 25,
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
            "Cari"
        );
        // add padding x 10px to .dataTables_filter input
        $(".dataTables_filter input").css("padding", "0 10px");
        $(".dt-buttons").appendTo("#download-button");
    }

    $("#changelogs").on("search.dt", function () {
        table
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    });
});

$(".submit-btn").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");    
    let id_judulchangelog = $("#create-id_judulchangelog").val();
    let isi = $("#create-isi").val();    

    $.ajax({
        url: `/admin/changelogisi/simpan`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            id_judulchangelog: id_judulchangelog,
            isi: isi,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {     
            console.log(id_judulchangelog);
            console.log(isi);
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = `${value}`;
            });
            // console.log(errors);
        },
    });
});

$(".edit-btn").on("click", function () {
    let dataId = $(this).attr("data-id");    
    $("#error-edit-id_judulchangelog").text("");
    $("#error-edit-isi").text("");
    $.ajax({
        url: `/admin/changelogisi/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            $("#edit-id_isichangelog").val(response.data[0].id_isichangelog);
            $("#edit-versi").val(response.data[0].versi);
            $("#edit-isi").val(response.data[0].isi);
        },
    });
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");
    let id_objek = $("#edit-id_isichangelog").val();
    let isi = $("#edit-isi").val();

    $.ajax({
        url: `/admin/changelogisi/${id_objek}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            isi: isi,
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
            // console.log(error);
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
                url: `/admin/changelogisi/${dataId}`,
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
