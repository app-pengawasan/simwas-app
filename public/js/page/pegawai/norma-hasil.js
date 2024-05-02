$('#rencana_id').on('change', function () {
    console.log('change');
    let rencana_id = $(this).val();
    $.ajax({
        url: "/objek-pengawasan-search/",
        type: "GET",
        data: {
            rencana_id: rencana_id,
        },
        success: function (data) {
            // if data not 0
            if (data.data.length > 0) {
                $('#objek_kegiatan').prop('disabled', false);
                // fill option with data.data
                $('#objek_kegiatan').empty();
                $('#objek_kegiatan').append(
                    '<option value="">Pilih Objek Pengawasan</option>'
                );
                $.each(data.data, function (key, value) {
                    $('#objek_kegiatan').append(
                        '<option value="' + value.id_objek + '">' + value.nama + '</option>'
                    );
                });
            } else {
                $('#objek_kegiatan').prop('disabled', true);
            }
        },
        error: function (data) {
            console.log(data);
        },
    });

});

$('#objek_kegiatan').select2({
    placeholder: "Pilih Objek Pengawasan",
    allowClear: true
});
