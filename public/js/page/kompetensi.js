let table = $("#table-kompetensi")
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
                    columns: [0, 1, 2, 6, 4, 5],
                },
            },
            {
                extend: "pdf",
                className: "btn-danger",
                text: '<i class="fas fa-file-pdf"></i> Pdf',
                exportOptions: {
                    columns: [0, 1, 2, 6, 4, 5],
                },
            },
        ],
    }).api();

if ($('#role').val() == 'analis sdm') {
    $('#filterUnitKerja').on("change", function () {
        table.draw();
    });

    $('#filterJenis').on("change", function () {
        table.draw();
    });

    $.fn.dataTableExt.afnFiltering.push(
        function (setting, data, index) {
            var selectedUnit = $('select#filterUnitKerja option:selected').val();
            var selectedJenis = $('select#filterJenis option:selected').val();
            if ((data[7] == selectedUnit || selectedUnit == 'all') &&
                (data[8] == selectedJenis || selectedJenis == 'all')) return true;
            else return false;
        }
    );
}

let tabled = $("#table-dashboard-analis").dataTable({
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
                columns: [0, 1, 4],
            },
            messageTop: function () {
                return 'Pegawai: ' + $(":selected", '#filterPegawai').text();
            },
        },
        {
            extend: "pdf",
            className: "btn-danger",
            text: '<i class="fas fa-file-pdf"></i> PDF',
            exportOptions: {
                columns: [0, 1, 4],
            },
            messageTop: function () {
                return 'Pegawai: ' + $(":selected", '#filterPegawai').text();
            },
        },
    ],
}).api()

$('#filterPegawai').on("change", function () {
    tabled.draw();

    $('#sertifikasi').html(0);
    $('#jenjang').html(0);
    $('#teknis').html(0);

    let countArr = count[$(this).val()];

    $('#sertifikasi').html(countArr['1']);
    $('#jenjang').html(countArr['2']);
    $('#teknis').html(countArr['3']);
});

$('#filterJenis').on("change", function () {
    tabled.draw();
});

let allowFilter = ['table-dashboard-analis'];

$.fn.dataTableExt.afnFiltering.push(
    function (setting, data, index) {
        // check if current table is part of the allow list
        if ( $.inArray( setting.nTable.getAttribute('id'), allowFilter ) == -1 ) {
            // if not table should be ignored
            return true;
        }

        var selected = $('select#filterPegawai option:selected').val();
        var selectedJenis = $('select#filterJenis option:selected').val();
        if (data[3] == selected && (data[5] == selectedJenis || selectedJenis == 'all')) {
            return true;
        }
        else return false;
    }
);

tabled.draw();

const clearError = () => {
    $("#error-pegawai_id").text("");
    $("#error-pp").text("");
    $("#error-pp_id").text("");
    $("#error-pp_lain").text("");
    $("#error-nama_pp").text("");
    $("#error-nama_pp_id").text("");
    $("#error-nama_pp_lain").text("");
    $("#error-edit-pp").text("");
    $("#error-edit-pp_lain").text("");
    $("#error-edit-nama_pp").text("");
    $("#error-edit-nama_pp_lain").text("");
    $("#error-create-sertifikat").text("");
    $("#error-edit-sertifikat").text("");
}

const showOtherPp = () => {
    $(".div_create_pp").addClass("mb-2");
    $(".form-other-pp").addClass("mt-3 form-group");
    $(".form-other-pp, .form-other-pp label, .form-other-pp input").show();
    $('.pp_lain').prop("required", true);
};

const showPeserta = () => {
    $(".div_create_peserta").addClass("mb-3");
    $(".div_create_peserta").show();
    $('.peserta').prop("required", true);
};

const hidePeserta = () => {
    $(".div_create_peserta").removeClass("mb-3");
    $(".div_create_peserta").hide();
    $('.peserta').prop("required", false);
};

const showOtherNamapp= () => {
    $(".div_create_namapp").addClass("mb-2");
    $(".form-other-namepp").addClass("mt-3 form-group");
    $(".form-other-namepp, .form-other-namepp label, .form-other-namepp input").show();
    $('.nama_pp_lain').prop("required", true);
};

const hideOtherPp = () => {
    $(".div_create_pp").removeClass("mb-2");
    $(".form-other-pp").removeClass("mt-3 form-group");
    $('.pp_lain').prop("required", false);
    $(".form-other-pp, .form-other-pp label, .form-other-pp input").hide();
};

const hideOtherNamapp = () => {
    $(".div_create_namapp").removeClass("mb-2");
    $(".form-other-namepp").removeClass("mt-3 form-group");
    $(".form-other-namepp, .form-other-namepp label, .form-other-namepp input").hide();
    $('.nama_pp_lain').prop("required", false);
};

const hideOthers = () => {
    $(".form-one-line").removeClass("mt-3 form-group");
    $(".form-one-line, .form-one-line label, .form-one-line input").hide();
    $('.form-one-line input').prop("required", false);
    $(".div_create_namapp").removeClass("mb-2");
    $(".div_create_pp").removeClass("mb-2");
}

const enableNamapp = (pp) => {
    $(".nama_pp_id option").hide();
    $('.disabled').show();
    $('.disabled').prop("selected", true);
    $(`.nama_pp_id option[data-pp="${pp}"]`).show();
    $(".nama_pp_id").prop("disabled", false);
}

const enableNamapp3 = (peserta) => {
    $(".nama_pp_id option").hide();
    $('.disabled').show();
    $('.disabled').prop("selected", true);
    $(`.nama_pp_id option[data-peserta="${peserta}"]`).show();
    $(".nama_pp_id").prop("disabled", false);
}

const disableNamapp = () => {
    $(".nama_pp_id option").hide();
    $(".nama_pp_id").val("999");
    $(".nama_pp_id").prop("disabled", true);
}

document.forms['myform'].reset();
$("#nama_pp_id").prop("disabled", true);
hideOthers();
hidePeserta();

$("#create-btn").on("click", function () {
    document.forms['myform'].reset();
    clearError();
    hideOthers();
});

$(".pp_id").on("change", function () {
    let pp = $(this).val();
    clearError();

    if (pp === "1" || pp === "2" || pp === "3") {
        enableNamapp(pp);
        hideOthers();
    }
    else {
        if (pp === "999") {
            showOtherPp();
        } else {
            hideOtherPp();
        }
        disableNamapp();
        showOtherNamapp();
    }

    if (pp === "3") {
        showPeserta();
        disableNamapp();
        $(".nama_pp_id option").hide();
        $('.disabled').show();
        $('.disabled').prop("selected", true);
    }
    else hidePeserta();
});

$(".nama_pp_id").on("change", function () {
    let nama_pp = $(this).val();
    clearError();

    if (nama_pp === "999") {
        showOtherNamapp();
    } else {
        hideOtherNamapp();
    }
});

$(".peserta").on("change", function () {
    let peserta = $(this).val();
    enableNamapp($('#pp_id').val());
    $('.nama_pp_id option').hide();
    $('.nama_pp_id option[value="999"]').show();
    $(`.nama_pp_id option[data-peserta="${peserta}"]`).show();
    clearError();
    hideOthers();
    $('#nama_pp_other').hide();
});

$(".submit-btn").on("click", function (e) {
    e.preventDefault();
    let data = new FormData($('#myform')[0]);
    let token = $("meta[name='csrf-token']").attr("content");
    if (!data.get("nama_pp_id")) data.append('nama_pp_id', $("#nama_pp_id").val());
    if (data.get("nama_pp_id") == 'null') data.delete('nama_pp_id');
    if (data.get("pp_lain") == '') data.delete('pp_lain');
    if (data.get("nama_pp_lain") == '') data.delete('nama_pp_lain');
    data.append('_token', token);

    let url;
    if ($('#role').val() == 'analis sdm') url = `/analis-sdm/kelola-kompetensi`;
    else url = `/pegawai/kompetensi`;

    // Reset invalid message while modal open
    clearError();

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
            // console.log(errors);
        },
    });
});

$(".edit-btn").on("click", function () {
    clearError();
    let dataId = $(this).attr("data-id");
    let url;
    if ($('#role').val() == 'analis sdm') url = `/analis-sdm/kelola-kompetensi/getData/${dataId}`;
    else url = `/pegawai/kompetensi/getData/${dataId}`;
    $.ajax({
        url: url,
        type: "GET",
        cache: false,
        success: function (response) {
            document.forms['myeditform'].reset();
            hideOthers();
            let pp_id = response.data[0].pp_id;
            let nama_pp_id = response.data[0].nama_pp_id;
            let nama_pp_lain = response.data[0].nama_pp_lain;

            $("#edit-id").val(response.data[0].id);
            $("#edit-pegawai").val(response.data[0].pegawai_id);
            $("#edit-pp").val(pp_id);
            $("#edit-catatan").val(response.data[0].catatan);
            $("#edit-peserta").val(response.peserta);
            $("#edit-tgl_mulai").val(response.data[0].tgl_mulai);
            $("#edit-tgl_selesai").val(response.data[0].tgl_selesai);
            $("#edit-durasi").val(response.data[0].durasi);
            $("#edit-tgl_sertifikat").val(response.data[0].tgl_sertifikat);
            $("#edit-penyelenggara").val(response.penyelenggara);
            $("#edit-jumlah_peserta").val(response.data[0].jumlah_peserta);
            $("#edit-ranking").val(response.data[0].ranking);

            if (pp_id == 999) {
                showOtherPp();
                $('.pp_lain').val(response.data[0].pp_lain);
                disableNamapp();
                showOtherNamapp();
                $('.nama_pp_lain').val(nama_pp_lain);
            } else if (pp_id == 1 | pp_id == 2 | pp_id == 3) {
                if (pp_id == 3) {
                    showPeserta();
                    enableNamapp3(response.peserta);
                } else enableNamapp(pp_id);
                hideOthers();
                $('.nama_pp_id').val(nama_pp_id);
                if (nama_pp_id == 999) {
                    showOtherNamapp();
                    $('.nama_pp_lain').val(nama_pp_lain);
                }
            } else {
                disableNamapp();
                showOtherNamapp();
                $('.nama_pp_lain').val(nama_pp_lain);
            }
        },
    });
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();
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
        },
    });
});

$(".delete-btn").on("click", function () {
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

$("#setuju-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dibatalkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Setujui",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
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
        }
    });
});

$("#tolak-btn").on("click", function () {
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