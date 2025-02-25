localStorage.setItem("mini-sidebar", "true");

let colnums, tgl_mulai;
if ($('#role').val() == 'analis sdm') {
    colnums = [0, 1, 2, 3, 4, 13, 14, 15, 16, 10, 20, 17, 18, 19, 7, 8];
    tgl_mulai = 5;
}
else {
    colnums = [0, 1, 2, 3, 9, 10, 11, 12, 13, 17, 14, 15, 16, 6, 7];
    tgl_mulai = 4;
}

let table = $("#table-kompetensi")
    .dataTable({
        dom: "Bfrtip",
        responsive: false,
        lengthChange: true,
        autoWidth: false,
        order: [[tgl_mulai, "desc"]],
        pageLength: 25,
        buttons: [
            {
                extend: "excel",
                className: "btn-success",
                text: '<i class="fas fa-file-excel"></i> Excel',
                exportOptions: {
                    columns: colnums,
                },
            },
            {
                extend: "pdf",
                className: "btn-danger",
                text: '<i class="fas fa-file-pdf"></i> Pdf',
                orientation: 'landscape',
                pageSize: 'TABLOID',
                exportOptions: {
                    columns: colnums,
                },
                customize: function(doc) {
                    doc.pageMargins = [ 10, 20, 10, 20 ];
                }
            },
        ],
    })
    .api();

if ($('#role').val() == 'analis sdm') {
    document.forms['filterForm'].reset();

    $('#filterUnitKerja').on("change", function () {
        table.draw();
    });

    $('#filterKat').on("change", function () {
        table.draw();
    });

    $.fn.dataTableExt.afnFiltering.push(
        function (setting, data, index) {
            var selectedUnit = $('select#filterUnitKerja option:selected').val();
            var selectedKat = $('select#filterKat option:selected').val();
            if ((data[11] == selectedUnit || selectedUnit == 'all') &&
                (data[12] == selectedKat || selectedKat == 'all')) return true;
            else return false;
        }
    );
}

$('#table-kompetensi_wrapper').css('overflow', 'scroll');

// let tabled = $("#table-dashboard-analis").dataTable({
//     dom: "Bfrtip",
//     responsive: true,
//     lengthChange: false,
//     autoWidth: false,
//     buttons: [
//         {
//             extend: "excel",
//             className: "btn-success",
//             text: '<i class="fas fa-file-excel"></i> Excel',
//             exportOptions: {
//                 columns: [0, 1, 4],
//             },
//             messageTop: function () {
//                 return 'Pegawai: ' + $(":selected", '#filterPegawai').text();
//             },
//         },
//         {
//             extend: "pdf",
//             className: "btn-danger",
//             text: '<i class="fas fa-file-pdf"></i> PDF',
//             exportOptions: {
//                 columns: [0, 1, 4],
//             },
//             messageTop: function () {
//                 return 'Pegawai: ' + $(":selected", '#filterPegawai').text();
//             },
//         },
//     ],
// }).api()

// $('#filterPegawai').on("change", function () {
//     tabled.draw();

//     $('#sertifikasi').html(0);
//     $('#jenjang').html(0);
//     $('#teknis').html(0);

//     let countArr = count[$(this).val()];

//     $('#sertifikasi').html(countArr['1']);
//     $('#jenjang').html(countArr['2']);
//     $('#teknis').html(countArr['3']);
// });

// $('#filterJenis').on("change", function () {
//     tabled.draw();
// });

// let allowFilter = ['table-dashboard-analis'];

// $.fn.dataTableExt.afnFiltering.push(
//     function (setting, data, index) {
//         // check if current table is part of the allow list
//         if ( $.inArray( setting.nTable.getAttribute('id'), allowFilter ) == -1 ) {
//             // if not table should be ignored
//             return true;
//         }

//         var selected = $('select#filterPegawai option:selected').val();
//         var selectedJenis = $('select#filterJenis option:selected').val();
//         if (data[3] == selected && (data[5] == selectedJenis || selectedJenis == 'all')) {
//             return true;
//         }
//         else return false;
//     }
// );

// tabled.draw();

const clearError = () => {
    $("#error-pegawai_id").text("");
    $("#error-teknis_id").text("");
    $("#error-nama_pelatihan").text("");
    $("#error-tgl_mulai").text("");
    $("#error-tgl_selesai").text("");
    $("#error-durasi").text("");
    $("#error-tgl_sertifikat").text("");
    $("#error-create-sertifikat").text("");
    $("#error-penyelenggara").text("");
    $("#error-jumlah_peserta").text("");
    $("#error-ranking").text("");

    $("#error-edit-pegawai").text("");
    $("#error-edit-teknis_id").text("");
    $("#error-edit-nama_pelatihan").text("");
    $("#error-edit-tgl_mulai").text("");
    $("#error-edit-tgl_selesai").text("");
    $("#error-edit-durasi").text("");
    $("#error-edit-tgl_sertifikat").text("");
    $("#error-edit-sertifikat").text("");
    $("#error-edit-penyelenggara").text("");
    $("#error-edit-jumlah_peserta").text("");
    $("#error-edit-ranking").text("");
}

document.forms['myform'].reset();

$("#create-btn").on("click", function () {
    document.forms['myform'].reset();
    $(".jenis").prop("disabled", true);
    $(".teknis").prop("disabled", true);
});

const populateJenis = (kat_id) => {
    $.ajax({
        url: `/pegawai/kompetensi/search-jenis/${kat_id}`,
        type: "GET",
        async: false,
        success: function (data) {
            // if data not 0
            if (data.data.length > 0) {
                $(".jenis").prop("disabled", false);
                // fill option with data.data
                $(".jenis").empty();
                $(".jenis").append(
                    '<option value="" disabled selected>Pilih Jenis</option>'
                );
                $.each(data.data, function (key, value) {
                    $(".jenis").append(
                        '<option value="' +
                            value.id +
                            '">' +
                            value.nama +
                            "</option>"
                    );
                });
            } else {
                $(".jenis").prop("disabled", true);
            }
        },
        error: function (data) {
        },
    });
}

$(".kategori").on("change", function () {
    let kat_id = $(this).val();
    populateJenis(kat_id);
});

const populateTeknis = (jenis_id) => {
    $.ajax({
        url: `/pegawai/kompetensi/search-teknis/${jenis_id}`,
        type: "GET",
        async: false,
        success: function (data) {
            // if data not 0
            if (data.data.length > 0) {
                $(".teknis").prop("disabled", false);
                // fill option with data.data
                $(".teknis").empty();
                $(".teknis").append(
                    '<option value="" disabled selected>Pilih Teknis</option>'
                );
                $.each(data.data, function (key, value) {
                    $(".teknis").append(
                        '<option value="' +
                            value.id +
                            '">' +
                            value.nama +
                            "</option>"
                    );
                });
            } else {
                $(".teknis").prop("disabled", true);
            }
        },
        error: function (data) {
        },
    });
}

$(".jenis").on("change", function () {
    let jenis_id = $(this).val();
    populateTeknis(jenis_id);
});

$(".submit-btn").on("click", function (e) {
    e.preventDefault();
    let data = new FormData($('#myform')[0]);
    let token = $("meta[name='csrf-token']").attr("content");
    data.append('_token', token);

    let url;
    if ($('#role').val() == 'analis sdm') url = `/analis-sdm/kelola-kompetensi`;
    else url = `/pegawai/kompetensi`;

    // Reset invalid message while modal open
    clearError();

    Swal.fire({
        title: "Menyimpan Data",
        html: "Mohon tunggu sebentar",
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: () => !Swal.isLoading(),
    });

    $.ajax({
        url: url,
        contentType: false,
        processData: false,
        type: "POST",
        cache: false,
        data: data,
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

            Swal.close();
        },
    });
});

$("#table-kompetensi").on("click", ".edit-btn", function () {
    clearError();
    let dataId = $(this).attr("data-id");
    let url;
    if ($('#role').val() == 'analis sdm') url = `/analis-sdm/kelola-kompetensi/getData/${dataId}`;
    else url = `/pegawai/kompetensi/getData/${dataId}`;

    Swal.fire({
        title: "Mengambil Data",
        html: "Mohon tunggu sebentar",
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: () => !Swal.isLoading(),
    });

    $.ajax({
        url: url,
        type: "GET",
        cache: false,
        success: function (response) {
            document.forms['myeditform'].reset();
            $("#edit-id").val(response.data[0].id);
            $("#edit-pegawai").val(response.data[0].pegawai_id);
            $("#edit-kat").val(response.kategori).trigger('change');
            populateJenis(response.kategori);
            $("#edit-jenis").val(response.data[0].teknis.jenis_id).trigger('change');
            populateTeknis(response.data[0].teknis.jenis_id);
            $("#edit-teknis_id").val(response.data[0].teknis_id).trigger('change');
            $("#edit-nama_pelatihan").val(response.data[0].nama_pelatihan);
            $("#edit-catatan").val(response.data[0].catatan);
            $("#edit-peserta").val(response.peserta);
            $("#edit-tgl_mulai").val(response.data[0].tgl_mulai);
            $("#edit-tgl_selesai").val(response.data[0].tgl_selesai);
            $("#edit-durasi").val(response.data[0].durasi);
            $("#edit-tgl_sertifikat").val(response.data[0].tgl_sertifikat);
            $("#edit-penyelenggara").val(response.penyelenggara).trigger('change');
            $("#edit-jumlah_peserta").val(response.data[0].jumlah_peserta);
            $("#edit-ranking").val(response.data[0].ranking);
            Swal.close();
        },
    });
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();
    clearError();
    let data = new FormData($('#myeditform')[0]);
    let token = $("meta[name='csrf-token']").attr("content");
    let id = $("#edit-id").val();

    let url;
    if ($('#role').val() == 'analis sdm') url = `/analis-sdm/kelola-kompetensi/${id}`;
    else url = `/pegawai/kompetensi/${id}`;

    if (!data.get("edit-nama_pp")) data.append('edit-nama_pp', $("#edit-nama_pp").val());
    if (data.get("edit-nama_pp") == 'null') data.delete('edit-nama_pp');
    if (data.get("edit-pp_lain") == '') data.delete('edit-pp_lain');
    if (data.get("edit-nama_pp_lain") == '') data.delete('edit-nama_pp_lain');
    data.append('_token', token);
    data.append('_method', "PUT");

    Swal.fire({
        title: "Menyimpan Data",
        html: "Mohon tunggu sebentar",
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: () => !Swal.isLoading(),
    });

    $.ajax({
        url: url,
        headers: { 'X-CSRF-Token': token },
        contentType: false,
        processData: false,
        type: "POST",
        cache: false,
        data: data,
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                // console.log(key);
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = `${value}`;
            });

            Swal.close();
        },
    });
});

$("#table-kompetensi").on("click", '.delete-btn', function () {
    let dataId = $(this).attr("data-id");
    let token = $("meta[name='csrf-token']").attr("content");
    let url;

    if ($('#role').val() == 'analis sdm') url = `/analis-sdm/kelola-kompetensi/${dataId}`;
    else url = `/pegawai/kompetensi/${dataId}`;

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
                url: url,
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

$("#table-kompetensi").on("click", '.setuju-btn', function () {
    let dataId = $(this).attr("data-id");
    let token = $("meta[name='csrf-token']").attr("content");

    $.ajax({
        url: `/analis-sdm/kelola-kompetensi/${dataId}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            terima: true
        },
        success: function (response) {
            location.reload();
        },
    });
});

$("#table-kompetensi").on("click", '.tolak-btn', function () {
    let dataId = $(this).attr("data-id");
    $('#data-id').val(dataId);
});

$('#tolak-submit').on("click", function () {
    let dataId = $('#data-id').val();
    let catatan = $('#catatan').val();
    let token = $("meta[name='csrf-token']").attr("content");

    $.ajax({
        url: `/analis-sdm/kelola-kompetensi/${dataId}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            tolak: true,
            catatan: catatan
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                // console.log(key);
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = `${value}`;
            });
        },
    });
});
