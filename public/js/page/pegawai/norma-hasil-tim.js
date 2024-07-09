$("#nomor").on("change", function () {
    let nama = $(this).find(":selected").attr('data-nama');
    let bulan = $(this).find(":selected").attr('data-bulan');
    $("#nama").val(nama);
    $('#bulan').val(bulan);
});

document.forms['formNHtim'].reset();

let table = $("#table-pengelolaan-dokumen-pegawai");

$(function () {
    table
        .DataTable({
            dom: "Bfrtip",
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: [],
            columnDefs: [{
                "targets": 0,
                "createdCell": function (td, cellData, rowData, row, col) {
                $(td).text(row + 1);
                }
            }]
        })
        .buttons()
        .container()
        .appendTo("#table-pengelolaan-dokumen-pegawai_wrapper .col-md-6:eq(0)");
});
    
$(".submit-btn").on("click", function (e) {
    e.preventDefault();
    $("#bulan").prop("disabled", false); //enable pilihan bulan

    $("#error-nomor").text("");
    $("#error-file").text("");
    $("#error-tugas").text("");
    $("#error-bulan").text("");
    $("#error-objek").text("");
    
    let data = new FormData($('#formNHtim')[0]);
    let token = $("meta[name='csrf-token']").attr("content");
    data.append('_token', token);

    $.ajax({
        url: `/pegawai/tim/norma-hasil`,
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
            console.log(errors);
        },
    });
});

$('.form-dokumen').hide();
$(document).on("change", "[name='jenis']", function () {
    $('#bulan').val('');
    $('#tugas').val('');
    $('#objek').val('');
    $('#nomor').val('');
    $('#nama').val('');
    $("#nomor").prop('disabled', true);
    $("#objek").prop('disabled', true);
    $("#bulan").prop('disabled', true);
    if ($(this).val() == '1') {
        $('.form-laporan').show();
        $('.form-dokumen').hide();
    } else {
        $('.form-laporan').hide();
        $('.form-dokumen').show();
    }
});

$("#nomor").prop('disabled', true);
$("#objek").prop('disabled', true);
$("#bulan").prop('disabled', true);

$("#tugas").on("change", function (e) {
    $('#nama').val('');
    $('#bulan').val('');
    $('#objek').val('');
    $('#file').val('');
    $("#bulan").prop('disabled', true);

    $("#nomor option").hide(); //hide option" nomor
    $('#nomor-dis').show(); //show pilihan "Pilih Nomor"
    $('#nomor-dis').prop("selected", true);
    $("#nomor").prop("disabled", false); //enable pilihan nomor
    $(`#nomor option[data-tugas="${$(this).val()}"]`).show(); //show option nomor sesuai tugas yang dipilih

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