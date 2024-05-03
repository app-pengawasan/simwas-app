$("#tugas").prop("disabled", true); //disable pilihan tugas
$("#proyek").prop("disabled", true); //disable pilihan proyek
$('.disabled').show(); //show pilihan "Pilih Tugas" dan "Pilih Proyek"
$('.disabled').prop("selected", true);
if ($('#status').val() != '1') $('.status_change').hide(); //sembunyikan kegiatan dan capaian jika status belum selesai
if ($('#status').val() != '2') $('.status_change_2').hide(); 
$("#aktivitas tbody tr").hide();

//hide clockpicker saat discroll
// $(document).on("scroll", function (e) {
//     clockpicker.clockpicker('hide');
//     $('.clockpicker input').trigger('blur');
// });

$("#tim").on("change", function () {
    $("#tugas option").hide(); //hide option" tugas
    $("#tugas").prop("disabled", true); //disable pilihan tugas
    $("#proyek option").hide(); //hide option" proyek
    $('.proyek-dis').show(); //show pilihan "Pilih Proyek"
    $('.proyek-dis').prop("selected", true);
    $("#kegiatan").val(''); //clear kegiatan
    $("#capaian").val(''); //clear capaian
    $("#proyek").prop("disabled", false); //enable pilihan proyek
    $(`#proyek option[data-tim="${$(this).val()}"]`).show(); //show option proyek sesuai tim yang dipilih
});

$("#proyek").on("change", function () {
    $("#tugas option").hide(); //hide option" tugas
    $('.tugas-dis').show(); //show pilihan "Pilih Tugas"
    $('.tugas-dis').prop("selected", true);
    $("#tugas").prop("disabled", false); //enable pilihan tugas
    $(`#tugas option[data-proyek="${$(this).val()}"]`).show(); //show option proyek sesuai tim yang dipilih
});

$("#tugas").on("change", function () {
    $("#aktivitas tbody tr").hide();
    let hasil_kerja = $(this).find(":selected").attr('data-hasil');
    $("#kegiatan").val('Menyusun ' + hasil_kerja);
    $("#kegiatan").removeClass('is-invalid');
    $("#error-kegiatan").text("");
    $("#kegiatan").closest('.form-group').addClass('was-validated');
    $("#capaian").val(hasil_kerja + ' sebanyak 1 dokumen');
    $("#capaian").removeClass('is-invalid');
    $("#error-capaian").text("");
    $("#capaian").closest('.form-group').addClass('was-validated');
    $(`#aktivitas tr[data-tugas="${$(this).val()}"]`).show();

    let i = 0;
    $(`#aktivitas tr[data-tugas="${$(this).val()}"] .jam`).each(function() {
        i = i + +$(this).text();
    });
    $('#jam').text(i + ' jam');
});

$("#status").on("change", function () {
    if ($(this).val() == '1') {
        let hasil_kerja = $('#tugas').find(":selected").attr('data-hasil');

        // $('#catatan').prop("required", false);
        $('#alasan').prop("required", false);
        $('.status_change').show();
        $('.status_change_2').hide();

        $('#kegiatan').prop("required", true);
        $("#kegiatan").val('Menyusun ' + hasil_kerja);
        $("#kegiatan").removeClass('is-invalid');
        $("#error-kegiatan").text("");
        $("#kegiatan").closest('.form-group').addClass('was-validated');

        $('#capaian').prop("required", true);
        $("#capaian").val(hasil_kerja + ' sebanyak 1 dokumen');
        $("#capaian").removeClass('is-invalid');
        $("#error-capaian").text("");
        $("#capaian").closest('.form-group').addClass('was-validated');
    } 
    else {
        // $('#catatan').prop("required", true);
        $('#alasan').prop("required", true);
        $('.status_change').hide();
        $('.status_change_2').show();
        $('#kegiatan').prop("required", false);
        $('#capaian').prop("required", false);
    } 
});

// $("#link").on("input", function () {
//     if ($(this).val() != '') {
//         $("#file").prop("disabled", true);
//         $('#file').prop("required", false);
//         $(`#file`).removeClass('is-invalid');
//     }
//     else {
//         $("#file").prop("disabled", false);
//         $('#file').prop("required", true);
//     }
// });

// $("#edit-link").on("input", function () {
//     if ($(this).val() != '') {
//         $("#edit-file").prop("disabled", true);
//         $(`#edit-file`).removeClass('is-invalid');
//     }
//     else {
//         $("#edit-file").prop("disabled", false);
//     }
// });

// $("#file").on("change", function () {
//     if ($(this).val() != '') {
//         $("#link").prop("disabled", true);
//         $('#link').prop("required", false);
//         $(`#link`).removeClass('is-invalid');
//     } 
//     else {
//         $("#link").prop("disabled", false);
//         $('#link').prop("required", true);
//     }
// });

// $("#edit-file").on("change", function () {
//     if ($(this).val() != '') {
//         $("#edit-link").prop("disabled", true);
//         $(`#edit-link`).removeClass('is-invalid');
//     } 
//     else {
//         $("#edit-link").prop("disabled", false);
//     }
// });

// $("#clear").on("click", function () {
//     $(`#file`).removeClass('is-invalid');
//     $('#file').val('');
//     $("#link").prop("disabled", false);
//     $('#link').prop("required", true);
// });

// $("#edit-clear").on("click", function () {
//     $(`#edit-file`).removeClass('is-invalid');
//     $('#edit-file').val('');
//     $("#edit-link").prop("disabled", false);
// });

const clearError = () => {
    $("#error-tgl").text("");
    $("#error-start").text("");
    $("#error-end").text("");
    $("#error-tugas").text("");
    $("#error-status").text("");
    $("#error-kegiatan").text("");
    $("#error-capaian").text("");
    $("#error-catatan").text("");
}

$("#myform").on("submit", function (e) {
    e.preventDefault();

    let data = new FormData($('#myform')[0]);
    let token = $("meta[name='csrf-token']").attr("content");

    data.append('_token', token);

    // Reset invalid message while modal open
    clearError();
    $("#error-hasil_kerja").text("");
    $("#error-file").text("");

    $.ajax({
        url: `/pegawai/realisasi`,
        contentType: false,
        processData: false,
        type: "POST",
        cache: false,
        data: data,
        success: function (response) {
            window.location.href = "/pegawai/realisasi";
        },
        error: function (error) {
            $('form').removeClass('was-validated');
            $('.form-group').addClass('was-validated');
            
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);
            
            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = value.join('\n');
                $(`#${key}`).addClass('is-invalid');
                $(`#${key}`).closest('.form-group').removeClass('was-validated');
                $(`#${key}`).on("input", function () {
                    $(this).closest('.form-group').addClass('was-validated');
                    $(`#error-${key}`).text("");
                });
                $(`#${key}`).on("change", function () {
                    $(this).closest('.form-group').addClass('was-validated');
                    $(`#error-${key}`).text("");
                });
            });
            
        },
    });
});

$("#myeditform").on("submit", function (e) {
    e.preventDefault();

    let data = new FormData($('#myeditform')[0]);
    let token = $("meta[name='csrf-token']").attr("content");
    let id = $("#id").val();

    data.append('_token', token);
    data.append('_method', "PUT");

    // Reset invalid message while modal open
    clearError();
    $("#error-edit-link").text("");
    $("#error-edit-file").text("");

    $.ajax({
        url: `/pegawai/realisasi/${id}`,
        headers: { 'X-CSRF-Token': token },
        contentType: false,
        processData: false,
        type: "POST",
        cache: false,
        data: data,
        success: function (response) {
            window.location.href = "/pegawai/realisasi";
        },
        error: function (error) {
            $('form').removeClass('was-validated');
            $('.form-group').addClass('was-validated');
            
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);
            
            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = value.join('\n');
                $(`#${key}`).addClass('is-invalid');
                $(`#${key}`).closest('.form-group').removeClass('was-validated');
                $(`#${key}`).on("input", function () {
                    $(this).closest('.form-group').addClass('was-validated');
                    $(`#error-${key}`).text("");
                });
                $(`#${key}`).on("change", function () {
                    $(this).closest('.form-group').addClass('was-validated');
                    $(`#error-${key}`).text("");
                });
            });
            
        },
    });
});

$(".delete-btn").on("click", function (e) {
    e.preventDefault();
    let dataId = $(this).attr("data-id");
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Data yang dihapus tidak dapat dipulihkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/pegawai/realisasi/${dataId}`,
                method: "DELETE",
                cache: false,
                data: {
                    _token: token,
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
                    setTimeout(window.location.href = "/pegawai/realisasi", 1500);
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});

let table = $("#table-realisasi")
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
                    columns: [0, 1, 2, 3, 4, 6, 8],
                },
                messageTop: function () {
                    return 'Bulan: ' + $(":selected", '#filterBulan').text();
                },
            },
            {
                extend: "pdf",
                className: "btn-danger",
                text: '<i class="fas fa-file-pdf"></i> Pdf',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 6, 8],
                },
                messageTop: function () {
                    return 'Bulan: ' + $(":selected", '#filterBulan').text();
                },
            },
        ],
        order: [[9, 'desc']]
    }).api();

let today = new Date(); 
$('#filterTahun').val(today.getFullYear());

$('#filterBulan').on("change", function () {
    table.draw();
});

$('#filterTahun').on("change", function () {
    table.draw();
});

$.fn.dataTableExt.afnFiltering.push(
    function (setting, data, index) {
        var selectedBulan = $('select#filterBulan option:selected').val();
        var selectedTahun = $('select#filterTahun option:selected').val();
        if ((data[3].substr(5, 2) == selectedBulan || selectedBulan == 'all') 
            && data[3].substr(0, 4) == selectedTahun) return true;
        else return false;
    }
);

table.draw();