let table = $("#table-pengelolaan-dokumen-pegawai");

$(function () {
    table
        .DataTable({
            dom: "Bfrtip",
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: [],
            pageLength: 25,
            columnDefs: [
                {
                    targets: 0,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).text(row + 1);
                    },
                },
            ],
        })
        .buttons()
        .container()
        .appendTo("#table-pengelolaan-dokumen-pegawai_wrapper .col-md-6:eq(0)");
});

$('#myeditform')[0].reset();
$('#formNHtim')[0].reset();

$('.edit-btn').on("click", function () {
    $('#km_id').val($(this).attr('data-id'));
});

$('#edit-submit').on("click", function (e) {
    e.preventDefault();
    let data = new FormData($('#myeditform')[0]);
    let token = $("meta[name='csrf-token']").attr("content");
    let id = $('#km_id').val();
    data.append('_token', token);
    data.append('_method', "PUT");

    $("#error-edit-file").text("");
    $("#error-edit-link").text("");

    if ($('#edit-file').val() != '' && $('#edit-file')[0].files[0].size / 1024 > 5120) {
        $('#error-edit-file').text('Ukuran file maksimal 5MB');
        return false;
    }

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
        url: `/pegawai/tim/kendali-mutu/${id}`,
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
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = value.join('\n');
            });

            Swal.close();
        },
    });
});

$(".link").on("input", function () {
    if ($(this).val() != '') {
        $(".file").prop("disabled", true);
        $('.file').prop("required", false);
        $(`.file`).removeClass('is-invalid');
    }
    else {
        $(".file").prop("disabled", false);
        $('.file').prop("required", true);
    }
});

$(".file").on("change", function () {
    if ($(this).val() != '') {
        $(".link").prop("disabled", true);
        $('.link').prop("required", false);
        $(`.link`).removeClass('is-invalid');
    }
    else {
        $(".link").prop("disabled", false);
        $('.link').prop("required", true);
    }
});

$(".clear").on("click", function () {
    $(`.file`).removeClass('is-invalid');
    $('.file').val('');
    $(".link").prop("disabled", false);
    $('.link').prop("required", true);
});

$(".submit-btn").on("click", function (e) {
    e.preventDefault();
    let data = new FormData($('#formNHtim')[0]);
    let token = $("meta[name='csrf-token']").attr("content");

    data.append('_token', token);

    // Reset invalid message while modal open
    $("#error-tugas").text("");
    $("#error-file").text("");
    $("#error-link").text("");
    $("#error-objek").text("");
    $("#error-bulan").text("");
    $("#error-catatan").text("");

    if ($('#file').val() != '' && $('#file')[0].files[0].size / 1024 > 5120) {
        $('#error-file').text('Ukuran file maksimal 5MB');
        return false;
    }

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
        url: '/pegawai/tim/kendali-mutu',
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

$('.form-tidak').hide();
$(document).on("change", "[name='is_ada']", function () {
    if ($(this).val() == '1') {
        $('.form-ada').show();
        $('.form-tidak').hide();
    } else {
        $('.form-ada').hide();
        $('.form-tidak').show();
    }
});

$("#objek").prop('disabled', true);
$("#bulan").prop('disabled', true);

$("#tugas").on("change", function (e) {
    $('#bulan').val('');
    $('#objek').val('');
    $("#bulan").prop('disabled', true);

    $("#objek option").hide(); //hide option" objek
    $('#objek-dis').show(); //show pilihan "Pilih Objek"
    $('#objek-dis').prop("selected", true);
    $("#objek").prop("disabled", false); //enable pilihan objek
    $(`#objek option[data-tugas="${$(this).val()}"]`).show(); //show option objek sesuai tugas yang dipilih
});

$("#objek").on("change", function (e) {
    $('#bulan').val('');
    $("#bulan option").hide(); //hide option" bulan
    $('#bulan-dis').show(); //show pilihan "Pilih Bulan"
    $('#bulan-dis').prop("selected", true);
    $("#bulan").prop("disabled", false); //enable pilihan bulan
    $(`#bulan option[data-objek="${$(this).val()}"]`).show(); //show option bulan sesuai objek yang dipilih
});
