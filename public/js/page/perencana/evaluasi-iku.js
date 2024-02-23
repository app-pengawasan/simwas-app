$(document).ready(function () {
    var jumlahObjek = $("#jumlah-objek").text() || $("#jumlah-objek").val();
    for (var i = 1; i <= jumlahObjek; i++) {
        for (var j = 1; j <= 4; j++) {
            var nilaiTarget = $("#triwulan" + j + "-row" + i).val();
            var nilaiRealisasi = $("#real-triwulan" + j + "-row" + i).val();
            var nilaiCapaian = (nilaiRealisasi / nilaiTarget) * 100;
            $("#capaian" + j + "-row" + i).val(nilaiCapaian.toFixed(2));
            // add percentage sign
        }
    }
});
