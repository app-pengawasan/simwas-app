$(document).ready(function () {
    var jumlahObjek = $("#jumlah-objek").text() || $("#jumlah-objek").val();
    let totalNilaiY = 0;
    let totalTriwulan1 = 0;
    let totalTriwulan2 = 0;
    let totalTriwulan3 = 0;
    let totalTriwulan4 = 0;
    let totalRealisasi1 = 0;
    let totalRealisasi2 = 0;
    let totalRealisasi3 = 0;
    let totalRealisasi4 = 0;
    for (var i = 1; i <= jumlahObjek; i++) {
        var nilaiY = $("#nilai-y-row" + i).val();
        var triwulan1 = $("#triwulan1-row" + i).val();
        var triwulan2 = $("#triwulan2-row" + i).val();
        var triwulan3 = $("#triwulan3-row" + i).val();
        var triwulan4 = $("#triwulan4-row" + i).val();
        var realisasi1 = $("#real-triwulan1-row" + i).val();
        var realisasi2 = $("#real-triwulan2-row" + i).val();
        var realisasi3 = $("#real-triwulan3-row" + i).val();
        var realisasi4 = $("#real-triwulan4-row" + i).val();
        for (var j = 1; j <= 4; j++) {
            var nilaiTarget = $("#triwulan" + j + "-row" + i).val();
            var nilaiRealisasi = $("#real-triwulan" + j + "-row" + i).val();
            var nilaiCapaian = (nilaiRealisasi / nilaiTarget) * 100;
            $("#capaian" + j + "-row" + i).val(
                nilaiCapaian
                    .toFixed(2)
                    .replace(/\.?0+$/, "")
            );
            // add percentage sign
        }
        totalNilaiY += parseFloat(nilaiY);
        totalTriwulan1 += parseFloat(triwulan1);
        totalTriwulan2 += parseFloat(triwulan2);
        totalTriwulan3 += parseFloat(triwulan3);
        totalTriwulan4 += parseFloat(triwulan4);
        totalRealisasi1 += parseFloat(realisasi1);
        totalRealisasi2 += parseFloat(realisasi2);
        totalRealisasi3 += parseFloat(realisasi3);
        totalRealisasi4 += parseFloat(realisasi4);
    }
    $("#total-y").val(totalNilaiY);
    $("#total-target-triwulan1").val(totalTriwulan1);
    $("#total-target-triwulan2").val(totalTriwulan2);
    $("#total-target-triwulan3").val(totalTriwulan3);
    $("#total-target-triwulan4").val(totalTriwulan4);
    $("#total-realisasi-triwulan1").val(totalRealisasi1);
    $("#total-realisasi-triwulan2").val(totalRealisasi2);
    $("#total-realisasi-triwulan3").val(totalRealisasi3);
    $("#total-realisasi-triwulan4").val(totalRealisasi4);
    $("#total-capaian-triwulan1").val(
        ((totalRealisasi1 / totalTriwulan1) * 100)
            .toFixed(2)
            .replace(/\.?0+$/, "")
    );
    $("#total-capaian-triwulan2").val(
        ((totalRealisasi2 / totalTriwulan2) * 100)
            .toFixed(2)
            .replace(/\.?0+$/, "")
    );
    $("#total-capaian-triwulan3").val(
        ((totalRealisasi3 / totalTriwulan3) * 100)
            .toFixed(2)
            .replace(/\.?0+$/, "")
    );
    $("#total-capaian-triwulan4").val(
        ((totalRealisasi4 / totalTriwulan4) * 100)
            .toFixed(2)
            .replace(/\.?0+$/, "")
    );

    $("#persentase-target-triwulan1").val(
        ((totalTriwulan1 / totalNilaiY) * 100).toFixed(2).replace(/\.?0+$/, "")
    );
    $("#persentase-target-triwulan2").val(
        ((totalTriwulan2 / totalNilaiY) * 100).toFixed(2).replace(/\.?0+$/, "")
    );
    $("#persentase-target-triwulan3").val(
        ((totalTriwulan3 / totalNilaiY) * 100).toFixed(2).replace(/\.?0+$/, "")
    );
    $("#persentase-target-triwulan4").val(
        ((totalTriwulan4 / totalNilaiY) * 100).toFixed(2).replace(/\.?0+$/, "")
    );
    $("#persentase-realisasi-triwulan1").val(
        ((totalRealisasi1 / totalNilaiY) * 100).toFixed(2).replace(/\.?0+$/, "")
    );
    $("#persentase-realisasi-triwulan2").val(
        ((totalRealisasi2 / totalNilaiY) * 100).toFixed(2).replace(/\.?0+$/, "")
    );
    $("#persentase-realisasi-triwulan3").val(
        ((totalRealisasi3 / totalNilaiY) * 100).toFixed(2).replace(/\.?0+$/, "")
    );
    $("#persentase-realisasi-triwulan4").val(
        ((totalRealisasi4 / totalNilaiY) * 100).toFixed(2).replace(/\.?0+$/, "")
    );
    $("#persentase-capaian-triwulan1").val(
        ((totalRealisasi1 / totalTriwulan1) * 100).toFixed(2).replace(/\.?0+$/, "")
    );
    $("#persentase-capaian-triwulan2").val(
        ((totalRealisasi2 / totalTriwulan2) * 100).toFixed(2).replace(/\.?0+$/, "")
    );
    $("#persentase-capaian-triwulan3").val(
        ((totalRealisasi3 / totalTriwulan3) * 100).toFixed(2).replace(/\.?0+$/, "")
    );
    $("#persentase-capaian-triwulan4").val(
        ((totalRealisasi4 / totalTriwulan4) * 100).toFixed(2).replace(/\.?0+$/, "")
    );
    // add percentage sign
    $(".percentage").each(function () {
        $(this).val($(this).val() + "%");
    });
});
