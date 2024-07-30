$("#tim_kerja").on("change", function () {
    let tim_kerja = $(this).val();
    $.ajax({
        url: "/tugas-list",
        type: "GET",
        data: {
            timkerja_id: tim_kerja,
        },
        success: function (data) {
            // if data not 0
            if (data.data.length > 0) {
                // remove disabled
                $("#rencana_id").prop("disabled", false);
                $("#rencana_id").empty();
                $("#rencana_id").append(
                    '<option value="">Pilih Rencana Pengawasan</option>'
                );
                $.each(data.data, function (key, value) {
                    $("#rencana_id").append(
                        '<option value="' +
                            value.id_rencanakerja +
                            '">' +
                            value.tugas +
                            "</option>"
                    );
                });
            } else {
                $("#rencana_id").prop("disabled", true);
            }
        },
        error: function (data) {
            // console.log(data);
        },
    });
});

$("#rencana_id").on("change", function () {
    let rencana_id = $(this).val();
    $.ajax({
        url: "/objek-pengawasan-search",
        type: "GET",
        data: {
            rencana_id: rencana_id,
        },
        success: function (data) {
            // if data not 0
            if (data.data.length > 0) {
                // remove disabled
                $("#objek_kegiatan").prop("disabled", false);
                $("#objek_kegiatan").empty();
                $("#objek_kegiatan").append(
                    '<option value="">Pilih Objek Pengawasan</option>'
                );
                $.each(data.data, function (key, value) {
                    $("#objek_kegiatan").append(
                        '<option value="' +
                            value.id_objek +
                            '" data-pengawasan="' +
                            value.id_opengawasan +
                            '">' +
                            value.nama +
                            "</option>"
                    );
                });
            } else {
                $("#objek_kegiatan").prop("disabled", true);
            }
        },
        error: function (data) {
            // console.log(data);
        },
    });
});
$("#objek_kegiatan").on("change", function () {
    let month = {
        1: "Januari",
        2: "Februari",
        3: "Maret",
        4: "April",
        5: "Mei",
        6: "Juni",
        7: "Juli",
        8: "Agustus",
        9: "September",
        10: "Oktober",
        11: "November",
        12: "Desember",
    };
    let id_opengawasan = $(this).find(":selected").data("pengawasan");
    $.ajax({
        url: `/objek-pengawasan/laporan/${id_opengawasan}`,
        type: "GET",
        data: {
            id_objek: id_opengawasan,
        },
        success: function (data) {
            // if data not 0
            $("#bulan_pelaporan").empty();
            if (data.data.length > 0) {
                $("#nama_dokumen").val(
                    data.data[0].objek_pengawasan.nama_laporan
                );

                $("#bulan_pelaporan").prop("disabled", false);
                // fill option with data.data
                $("#bulan_pelaporan").append(
                    '<option value="">Pilih Bulan Pelaporan</option>'
                );
                $.each(data.data, function (key, value) {
                    if (value.status == 0) {
                        return;
                    }
                    $("#bulan_pelaporan").append(
                        '<option value="' +
                            value.id +
                            '">' +
                            month[value.month] +
                            "</option>"
                    );
                });
            } else {
                $("#objek_kegiatan_detail").empty();
            }
        },
        error: function (data) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Terjadi kesalahan saat mengambil data",
            });
        },
    });
});
