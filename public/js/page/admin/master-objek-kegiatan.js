$(function () {
    let table;

    if ($("#master-objek-kegiatan").length) {
        table = $("#master-objek-kegiatan")
            .dataTable({
                dom: "Bfrtip",
                responsive: true,
                lengthChange: false,
                pageLength: 25,
                autoWidth: false,
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
            "Cari berdasarkan Kode atau Nama Kegiatan"
        );
        // add padding x 10px to .dataTables_filter input
        $(".dataTables_filter input").css("padding", "0 10px");
        $(".dt-buttons").appendTo("#download-button");
    }

    // restart numbering if data table is filter input is changed
    $("#master-objek-kegiatan").on("search.dt", function () {
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

    let nama_unitkerja = $("#nama_unitkerja").val();
    let kode_unitkerja = $("#unit_kerja").val();
    let kode_kegiatan = $("#kode_kegiatan").val();
    let nama = $("#nama").val();

    $.ajax({
        url: `/admin/objek-kegiatan`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            nama_unitkerja: nama_unitkerja,
            unit_kerja: kode_unitkerja,
            kode_kegiatan: kode_kegiatan,
            nama: nama,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                if (key != "nama_unitkerja" || key != "unit_kerja") {
                    let errorMessage = document.getElementById(`error-${key}`);
                    errorMessage.innerText = `${value}`;
                }
                // console.log(`error-${key}`);
            });
            // console.log(error);
        },
    });
});

$("#unit_kerja").on("change", function (e) {
    e.preventDefault();
    let kodeunitkerja = $("#unit_kerja").val();

    $.ajax({
        type: "GET",
        url: `/admin/objek-kegiatan/count/${kodeunitkerja}`,
        cache: false,
        success: function (response) {
            $("#nama_unitkerja").val($("#unit_kerja option:selected").text());
            let count = response.data.count;
            let kodekegiatanvalue = $("#kode_kegiatan").val();
            if (Number(count) < 10) {
                kodekegiatanvalue = kodeunitkerja.concat("0", Number(count));
                $("#kode_kegiatan").val(kodekegiatanvalue);
            }
            // console.log(Number(count));
        },
        error: function (error) {
            // console.log(error);
        },
    });
    // console.log();
});

$(".edit-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
    $.ajax({
        url: `/admin/objek-kegiatan/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            $("#edit-nama_unitkerja").val(response.data[0].nama_unitkerja);
            $("#edit-kode_unitkerja").val(response.data[0].kode_unitkerja);
            $("#edit-kode_kegiatan").val(response.data[0].kode_kegiatan);
            $("#edit-nama").val(response.data[0].nama);

            // console.log(response.data[0]);
        },
    });
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");

    let nama_unitkerja = $("#edit-nama_unitkerja").val();
    let kode_unitkerja = $("#edit-kode_unitkerja").val();
    let kode_kegiatan = $("#edit-kode_kegiatan").val();
    let nama = $("#edit-nama").val();

    $.ajax({
        url: `/admin/objek-kegiatan/${kode_kegiatan}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            nama_unitkerja: nama_unitkerja,
            kode_unitkerja: kode_unitkerja,
            kode_kegiatan: kode_kegiatan,
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
                <tr id="index_${response.data[0].kode_kegiatan}">
                    <td>${response.data[0].kode_kegiatan}</td>
                    <td>${response.data[0].nama_unitkerja}</td>
                    <td>${response.data[0].nama}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-warning edit-btn"
                            data-id="${response.data[0].kode_kegiatan}" style="width: 42px"
                            data-toggle="modal" data-target="#modal-edit-objekkegiatan">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn btn-danger delete-btn"
                            data-id="${response.data[0].kode_kegiatan}" style="width: 42px">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            `;

            $(`#index_${response.data[0].kode_kegiatan}`).replaceWith(
                satuankerja
            );
            $("#modal-edit-objekkegiatan").modal("hide");
        },
        error: function (error) {
            // console.log(error.responseJSON);
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
                url: `/admin/objek-kegiatan/${dataId}`,
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
