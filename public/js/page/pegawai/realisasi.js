$("#tugas").prop("disabled", true); //disable pilihan tugas
$("#proyek").prop("disabled", true); //disable pilihan proyek
$("#objek").prop("disabled", true); //disable pilihan objek
$("#bulan").prop("disabled", true); //disable pilihan bulan
$('.disabled').show(); //show pilihan "Pilih Tugas" dan "Pilih Proyek"
$('.disabled').prop("selected", true);
$("#aktivitas tbody tr").hide();

//hide clockpicker saat discroll
// $(document).on("scroll", function (e) {
//     clockpicker.clockpicker('hide');
//     $('.clockpicker input').trigger('blur');
// });

$("#tim").on("change", function () {
    $("#aktivitas tbody tr").hide();
    $("#tugas option").hide(); //hide option" tugas
    $("#tugas").prop("disabled", true); //disable pilihan tugas
    $("#proyek option").hide(); //hide option" proyek
    $('.proyek-dis').show(); //show pilihan "Pilih Proyek"
    $('.proyek-dis').prop("selected", true);
    $('.bulan-dis').prop("selected", true);
    $("#bulan").prop("disabled", true); //disable pilihan bulan
    $('.objek-dis').prop("selected", true);
    $("#objek").prop("disabled", true); //disable pilihan objek
    $("#kegiatan").val(''); //clear kegiatan
    $("#capaian").val(''); //clear capaian
    $("#proyek").prop("disabled", false); //enable pilihan proyek
    $(`#proyek option[data-tim="${$(this).val()}"]`).show(); //show option proyek sesuai tim yang dipilih
});

$("#proyek").on("change", function () {
    $("#aktivitas tbody tr").hide();
    $("#tugas option").hide(); //hide option" tugas
    $('.tugas-dis').show(); //show pilihan "Pilih Tugas"
    $('.tugas-dis').prop("selected", true);
    $("#tugas").prop("disabled", false); //enable pilihan tugas
    $(`#tugas option[data-proyek="${$(this).val()}"]`).show(); //show option proyek sesuai tim yang dipilih
    $('.bulan-dis').prop("selected", true);
    $("#bulan").prop("disabled", true); //disable pilihan bulan
    $('.objek-dis').prop("selected", true);
    $("#objek").prop("disabled", true); //disable pilihan objek
});

$("#tugas").on("change", function () {
    $("#aktivitas tbody tr").hide();

    let data = $(this).find(":selected");
    $("#hasil").text(data.attr('data-hasil-kerja'));
    $("#rencana_kerja").val(data.attr('data-rencana-kinerja'));
    $("#iki").val(data.attr('data-iki'));
    $("#kegiatan").val(data.attr('data-kegiatan'));
    $("#capaian").val(data.attr('data-capaian'));
    let jabatanPelaksana = ['Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim', 'PJ Kegiatan'];
    $('#peran').text(jabatanPelaksana[$(this).find(":selected").attr('data-peran') - 1]);

    $("#objek option").hide(); //hide option" objek
    $('.objek-dis').show(); //show pilihan "Pilih Objek"
    $('.objek-dis').prop("selected", true);
    $("#objek").prop("disabled", false); //enable pilihan objek
    $(`#objek option[data-rencana="${$(this).find(":selected").attr('data-rencana')}"]`).show(); //show option objek sesuai tugas yang dipilih

    $('.bulan-dis').prop("selected", true);
    $("#bulan").prop("disabled", true); //disable pilihan bulan
});

$("#objek").on("change", function () {
    $("#aktivitas tbody tr").hide();
    $("#bulan option").hide(); //hide option" bulan
    $('.bulan-dis').show(); //show pilihan "Pilih Bulan"
    $('.bulan-dis').prop("selected", true);
    $("#bulan").prop("disabled", false); //enable pilihan bulan
    $(`#bulan option[data-objek="${$(this).val()}"]`).show(); //show option bulan sesuai objek yang dipilih
});

$("#bulan").on("change", function () {
    $("#aktivitas tbody tr").hide();
    $(`#aktivitas tr[data-bulan="${$(this).val()}"]`).show();

    let i = 0;
    $(`#aktivitas tr[data-bulan="${$(this).val()}"] .jam`).each(function() {
        i = i + +$(this).text();
    });
    $('#jam').text(i + ' jam');
});

$("#status").on("change", function () {
    if ($(this).val() == '1') {
        $('#catatan').prop("required", false);
    }
    else {
        $('#catatan').prop("required", true);
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
    $("#error-rencana_kerja").text("");
    $("#error-iki").text("");
    $("#error-kegiatan").text("");
    $("#error-capaian").text("");
    $("#error-catatan").text("");
}

$("#myform").on("submit", function (e) {
    e.preventDefault();

    if (($('#jam').text() == '0 jam') && $('#status').val() == '1') {
        Swal.fire({
            title: "Laporkan aktivitas tugas ini!",
            text: "Jam realisasi 0 jam, Anda tidak bisa mengisi realisasi tugas ini.",
            icon: "error",
            confirmButtonColor: "var(--danger)",
            confirmButtonText: "Tutup",
          });
        e.preventDefault();
    } else {
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
    }
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
                    columns: [0, 1, 2, 3, 4, 5, 9, 7],
                },
                messageTop: function () {
                    return 'Bulan: ' + $(":selected", '#filterBulan').text() + '; Tahun: ' +
                            $(":selected", '#filterTahun').text();
                },
            },
            {
                extend: "pdf",
                className: "btn-danger",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 9, 7],
                },
                messageTop: function () {
                    return 'Bulan: ' + $(":selected", '#filterBulan').text() + '; Tahun: ' +
                            $(":selected", '#filterTahun').text();
                },
            },
        ],
        order: [[10, 'desc']]
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
        if ((data[12] == selectedBulan || selectedBulan == 'all')
            && data[11] == selectedTahun) return true;
        else return false;
    }
);

table.draw();
