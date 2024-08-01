$(document).ready(function () {
    localStorage.setItem("mini-sidebar", "true");
    calculateTotal();
    calculateTotalTarget();
    // hide footer

    // Add Objek
    $("#add-objek").on("click", function () {
        var jumlahObjek = $("#jumlah-objek").val();
        // if jumlah objek is empty set to 1
        if (jumlahObjek === "") {
            jumlahObjek = 1;
        }
        var table = $("table tbody");
        // add row to table
        for (var i = 0; i < jumlahObjek; i++) {
            row = parseFloat(jumlahObjek) + 1;
            var html = "";
            html += "<tr id='row-" + row + "'>";
            html += '<td class="text-center align-middle">' + row + "</td>";
            html += "<td>";
            selectOption = $(
                "table tbody tr:first-child td:nth-child(2)"
            ).html();
            html += selectOption;
            html = html.replace(/-row1/g, "-row" + row);

            html += "</td>";
            html +=
                '<td><input type="number" name="nilai-y-row' +
                row +
                '" id="nilai-y-row' +
                row +
                '" class="form-control nilai-y"></td>';
            html +=
                '<td><input type="number" name="triwulan1-row' +
                row +
                '" id="triwulan1-row' +
                row +
                '" class="form-control triwulan1"></td>';
            html +=
                '<td><input type="number" name="triwulan2-row' +
                row +
                '" id="triwulan2-row' +
                row +
                '" class="form-control triwulan2"></td>';
            html +=
                '<td><input type="number" name="triwulan3-row' +
                row +
                '" id="triwulan3-row' +
                row +
                '" class="form-control triwulan3"></td>';
            html +=
                '<td><input type="number" name="triwulan4-row' +
                row +
                '" id="triwulan4-row' +
                row +
                '" class="form-control triwulan4"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan1-row' +
                row +
                '" id="target-triwulan1-row' +
                row +
                '" class="form-control target-triwulan1"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan2-row' +
                row +
                '" id="target-triwulan2-row' +
                row +
                '" class="form-control target-triwulan2"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan3-row' +
                row +
                '" id="target-triwulan3-row' +
                row +
                '" class="form-control target-triwulan3"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan4-row' +
                row +
                '" id="target-triwulan4-row' +
                row +
                '" class="form-control target-triwulan4"></td>';

            html += "</tr>";
        }
        table.append(html);

        jumlahObjek = parseFloat(jumlahObjek) + 1;
        $("#jumlah-objek").val(jumlahObjek);
    });

    // change Jumlah Objek
    $("#jumlah-objek").on("change", function () {
        var jumlahObjek = $(this).val();
        if (jumlahObjek == 0) {
            jumlahObjek = 1;
        }
        var table = $("table tbody");
        var html = "";
        for (var i = 0; i < jumlahObjek; i++) {
            row = i + 1;
            html += "<tr>";
            html += '<td class="text-center align-middle">' + (i + 1) + "</td>";
            html += "<td>";
            // copy select option from first row
            selectOption = $(
                "table tbody tr:first-child td:nth-child(2)"
            ).html();
            selectOption = selectOption.replace(/-row1/g, "-row" + row);
            html += selectOption;
            // html = html.replace(/-row1/g, "-row" + row);

            html += "</td>";
            html +=
                '<td><input type="number" name="nilai-y-row' +
                row +
                '" id="nilai-y-row' +
                row +
                '" class="form-control nilai-y"></td>';
            html +=
                '<td><input type="number" name="triwulan1-row' +
                row +
                '" id="triwulan1-row' +
                row +
                '" class="form-control triwulan1"></td>';
            html +=
                '<td><input type="number" name="triwulan2-row' +
                row +
                '" id="triwulan2-row' +
                row +
                '" class="form-control triwulan2"></td>';
            html +=
                '<td><input type="number" name="triwulan3-row' +
                row +
                '" id="triwulan3-row' +
                row +
                '" class="form-control triwulan3"></td>';
            html +=
                '<td><input type="number" name="triwulan4-row' +
                row +
                '" id="triwulan4-row' +
                row +
                '" class="form-control triwulan4"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan1-row' +
                row +
                '" id="target-triwulan1-row' +
                row +
                '" class="form-control target-triwulan1"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan2-row' +
                row +
                '" id="target-triwulan2-row' +
                row +
                '" class="form-control target-triwulan2"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan3-row' +
                row +
                '" id="target-triwulan3-row' +
                row +
                '" class="form-control target-triwulan3"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan4-row' +
                row +
                '" id="target-triwulan4-row' +
                row +
                '" class="form-control target-triwulan4"></td>';
            html += "</tr>";
        }
        table.html(html);
        $("#total-triwulan1").val(0);
        $("#total-triwulan2").val(0);
        $("#total-triwulan3").val(0);
        $("#total-triwulan4").val(0);
        $("#nilai-y").val(0);

        $("#target-total-triwulan1").val(0);
        $("#target-total-triwulan2").val(0);
        $("#target-total-triwulan3").val(0);
        $("#target-total-triwulan4").val(0);
        $("#presentase-target-triwulan1").val(0);
        $("#presentase-target-triwulan2").val(0);
        $("#presentase-target-triwulan3").val(0);
        $("#presentase-target-triwulan4").val(0);
    });

    function calculateTotal() {
        // get id of changed input
        var id = $(this).attr("id");

        var jumlahObjek = $("#jumlah-objek").val() || 1;
        var accumulatedTriwulan = 0;
        for (i = 1; i <= jumlahObjek; i++) {
            for (j = 1; j <= 4; j++) {
                var triwulan = $("#triwulan" + j + "-row" + i).val();
                accumulatedTriwulan += triwulan ? parseFloat(triwulan) : 0;
                var y = $("#nilai-y-row" + i).val();
                var targetTriwulan = (triwulan / y).toFixed(2); // Format the calculated value with two decimal places
                $("#target-triwulan" + j + "-row" + i).val(targetTriwulan);
            }
            accumulatedTriwulan = 0;
        }

        var totalTargetTriwulan1 = 0;
        var totalTargetTriwulan2 = 0;
        var totalTargetTriwulan3 = 0;
        var totalTargetTriwulan4 = 0;

        var totalTriwulan1 = 0;
        var totalTriwulan2 = 0;
        var totalTriwulan3 = 0;
        var totalTriwulan4 = 0;
        var totalNilaiY = 0;

        $("table tbody tr").each(function () {
            var triwulan1 = $(this).find(".triwulan1").val();
            triwulan1 = triwulan1 ? parseFloat(triwulan1) : 0; // Handle empty input values
            var triwulan2 = $(this).find(".triwulan2").val();
            triwulan2 = triwulan2 ? parseFloat(triwulan2) : 0; // Handle empty input values
            var triwulan3 = $(this).find(".triwulan3").val();
            triwulan3 = triwulan3 ? parseFloat(triwulan3) : 0; // Handle empty input values
            var triwulan4 = $(this).find(".triwulan4").val();
            triwulan4 = triwulan4 ? parseFloat(triwulan4) : 0; // Handle empty input values
            var nilaiY = $(this).find(".nilai-y").val();
            nilaiY = nilaiY ? parseFloat(nilaiY) : 0; // Handle empty input values
            var targetTriwulan1 = $(this).find(".target-triwulan1").val();
            targetTriwulan1 = targetTriwulan1 ? parseFloat(targetTriwulan1) : 0; // Handle empty input values
            var targetTriwulan2 = $(this).find(".target-triwulan2").val();
            targetTriwulan2 = targetTriwulan2 ? parseFloat(targetTriwulan2) : 0; // Handle empty input values
            var targetTriwulan3 = $(this).find(".target-triwulan3").val();
            targetTriwulan3 = targetTriwulan3 ? parseFloat(targetTriwulan3) : 0; // Handle empty input values
            var targetTriwulan4 = $(this).find(".target-triwulan4").val();
            targetTriwulan4 = targetTriwulan4 ? parseFloat(targetTriwulan4) : 0; // Handle empty input values

            totalTriwulan1 += triwulan1;
            totalTriwulan2 += triwulan2;
            totalTriwulan3 += triwulan3;
            totalTriwulan4 += triwulan4;
            totalNilaiY += nilaiY;

            totalTargetTriwulan1 += targetTriwulan1;
            totalTargetTriwulan2 += targetTriwulan2;
            totalTargetTriwulan3 += targetTriwulan3;
            totalTargetTriwulan4 += targetTriwulan4;
        });

        $("#target-total-triwulan1").val(totalTargetTriwulan1);
        $("#target-total-triwulan2").val(totalTargetTriwulan2);
        $("#target-total-triwulan3").val(totalTargetTriwulan3);
        $("#target-total-triwulan4").val(totalTargetTriwulan4);

        $("#total-triwulan1").val(totalTriwulan1);
        $("#total-triwulan2").val(totalTriwulan2);
        $("#total-triwulan3").val(totalTriwulan3);
        $("#total-triwulan4").val(totalTriwulan4);
        $("#total-y").val(totalNilaiY);

        $("#satuan-target-triwulan1").val(totalTargetTriwulan1);
        $("#satuan-target-triwulan2").val(
            totalTargetTriwulan1 + totalTargetTriwulan2
        );
        $("#satuan-target-triwulan3").val(
            totalTargetTriwulan1 + totalTargetTriwulan2 + totalTargetTriwulan3
        );
        $("#satuan-target-triwulan4").val(
            totalTargetTriwulan1 +
                totalTargetTriwulan2 +
                totalTargetTriwulan3 +
                totalTargetTriwulan4
        );

        $("#presentase-target-triwulan1").val(
            ((totalTargetTriwulan1 / totalNilaiY) * 100).toFixed(2).replace(/\.00$/, "") + "%"
        );
        $("#presentase-target-triwulan2").val(
            (
            ((totalTargetTriwulan1 + totalTargetTriwulan2) / totalNilaiY) *
            100
            ).toFixed(2).replace(/\.00$/, "") + "%"
        );
        $("#presentase-target-triwulan3").val(
            (
            ((totalTargetTriwulan1 +
            totalTargetTriwulan2 +
            totalTargetTriwulan3) /
            totalNilaiY) *
            100
            ).toFixed(2).replace(/\.00$/, "") + "%"
        );
        $("#presentase-target-triwulan4").val(
            (
            ((totalTargetTriwulan1 +
            totalTargetTriwulan2 +
            totalTargetTriwulan3 +
            totalTargetTriwulan4) /
            totalNilaiY) *
            100
            ).toFixed(2).replace(/\.00$/, "") + "%"
        );
    }
    function calculateTotalTarget() {
        // get id of changed input
        var id = $(this).attr("id");
        // if not ''
        // disable other input
        // if (id.includes("triwulan1")) {
        //     row = id.replace("triwulan1-row", "");
        //     // if val is empty set to enable
        //     value = parseFloat($(this).val()) || 0;
        //     if (value === 0) {
        //         $("#triwulan2-row" + row).removeAttr("disabled");
        //         $("#triwulan3-row" + row).removeAttr("disabled");
        //         $("#triwulan4-row" + row).removeAttr("disabled");
        //     } else {
        //         $("#triwulan2-row" + row).attr("disabled", "disabled");
        //         $("#triwulan3-row" + row).attr("disabled", "disabled");
        //         $("#triwulan4-row" + row).attr("disabled", "disabled");
        //     }
        // }
        // if (id.includes("triwulan2")) {
        //     row = id.replace("triwulan2-row", "");
        //     value = parseFloat($(this).val()) || 0;
        //     if (value === 0) {
        //         $("#triwulan1-row" + row).removeAttr("disabled");
        //         $("#triwulan3-row" + row).removeAttr("disabled");
        //         $("#triwulan4-row" + row).removeAttr("disabled");
        //     } else {
        //         $("#triwulan1-row" + row).attr("disabled", "disabled");
        //         $("#triwulan3-row" + row).attr("disabled", "disabled");
        //         $("#triwulan4-row" + row).attr("disabled", "disabled");
        //     }
        // }
        // if (id.includes("triwulan3")) {
        //     row = id.replace("triwulan3-row", "");
        //     value = parseFloat($(this).val()) || 0;
        //     if (value === 0) {
        //         $("#triwulan1-row" + row).removeAttr("disabled");
        //         $("#triwulan2-row" + row).removeAttr("disabled");
        //         $("#triwulan4-row" + row).removeAttr("disabled");
        //     } else {
        //         $("#triwulan1-row" + row).attr("disabled", "disabled");
        //         $("#triwulan2-row" + row).attr("disabled", "disabled");
        //         $("#triwulan4-row" + row).attr("disabled", "disabled");
        //     }
        // }
        // if (id.includes("triwulan4")) {
        //     row = id.replace("triwulan4-row", "");
        //     value = parseFloat($(this).val()) || 0;
        //     if (value === 0) {
        //         $("#triwulan1-row" + row).removeAttr("disabled");
        //         $("#triwulan2-row" + row).removeAttr("disabled");
        //         $("#triwulan3-row" + row).removeAttr("disabled");
        //     } else {
        //         $("#triwulan1-row" + row).attr("disabled", "disabled");
        //         $("#triwulan2-row" + row).attr("disabled", "disabled");
        //         $("#triwulan3-row" + row).attr("disabled", "disabled");
        //     }
        // }

        var jumlahObjek = $("#jumlah-objek").val() || 1;
        var accumulatedTriwulan = 0;
        // console.log("jumlahObjek", jumlahObjek);
        for (i = 1; i <= jumlahObjek; i++) {
            for (j = 1; j <= 4; j++) {
                var triwulan = $("#tgt-triwulan" + j + "-row" + i).val();
                accumulatedTriwulan += triwulan ? parseFloat(triwulan) : 0;
                $("#tgt-target-triwulan" + j + "-row" + i).val(
                    accumulatedTriwulan
                );
                // console.log(
                //     "triwulan",
                //     j,
                //     "-row" + i + " = ",
                //     accumulatedTriwulan
                // );
            }
            accumulatedTriwulan = 0;
        }

        var totalTargetTriwulan1 = 0;
        var totalTargetTriwulan2 = 0;
        var totalTargetTriwulan3 = 0;
        var totalTargetTriwulan4 = 0;

        var totalTriwulan1 = 0;
        var totalTriwulan2 = 0;
        var totalTriwulan3 = 0;
        var totalTriwulan4 = 0;
        var totalNilaiY = 0;

        $("table tbody tr").each(function () {
            var triwulan1 = $(this).find(".tgt-triwulan1").val();
            triwulan1 = triwulan1 ? parseFloat(triwulan1) : 0; // Handle empty input values
            var triwulan2 = $(this).find(".tgt-triwulan2").val();
            triwulan2 = triwulan2 ? parseFloat(triwulan2) : 0; // Handle empty input values
            var triwulan3 = $(this).find(".tgt-triwulan3").val();
            triwulan3 = triwulan3 ? parseFloat(triwulan3) : 0; // Handle empty input values
            var triwulan4 = $(this).find(".tgt-triwulan4").val();
            triwulan4 = triwulan4 ? parseFloat(triwulan4) : 0; // Handle empty input values
            var nilaiY = $(this).find(".tgt-nilai-y").val();
            nilaiY = nilaiY ? parseFloat(nilaiY) : 0; // Handle empty input values

            var targetTriwulan1 = $(this).find(".tgt-target-triwulan1").val();
            targetTriwulan1 = targetTriwulan1 ? parseFloat(targetTriwulan1) : 0; // Handle empty input values
            var targetTriwulan2 = $(this).find(".tgt-target-triwulan2").val();
            targetTriwulan2 = targetTriwulan2 ? parseFloat(targetTriwulan2) : 0; // Handle empty input values
            var targetTriwulan3 = $(this).find(".tgt-target-triwulan3").val();
            targetTriwulan3 = targetTriwulan3 ? parseFloat(targetTriwulan3) : 0; // Handle empty input values
            var targetTriwulan4 = $(this).find(".tgt-target-triwulan4").val();
            targetTriwulan4 = targetTriwulan4 ? parseFloat(targetTriwulan4) : 0; // Handle empty input values

            totalTriwulan1 += triwulan1;
            totalTriwulan2 += triwulan2;
            totalTriwulan3 += triwulan3;
            totalTriwulan4 += triwulan4;
            totalNilaiY += nilaiY;

            totalTargetTriwulan1 += targetTriwulan1;
            totalTargetTriwulan2 += targetTriwulan2;
            totalTargetTriwulan3 += targetTriwulan3;
            totalTargetTriwulan4 += targetTriwulan4;

        });

        $("#tgt-target-total-triwulan1").val(totalTargetTriwulan1);
        $("#tgt-target-total-triwulan2").val(totalTargetTriwulan2);
        $("#tgt-target-total-triwulan3").val(totalTargetTriwulan3);
        $("#tgt-target-total-triwulan4").val(totalTargetTriwulan4);

        $("#tgt-total-triwulan1").val(totalTriwulan1);
        $("#tgt-total-triwulan2").val(totalTriwulan2);
        $("#tgt-total-triwulan3").val(totalTriwulan3);
        $("#tgt-total-triwulan4").val(totalTriwulan4);
        $("#tgt-total-y").val(totalNilaiY);

        $("#tgt-presentase-target-triwulan1").val(
            ((totalTargetTriwulan1 / totalNilaiY) * 100)
                .toFixed(2)
                .replace(/\.00$/, "") + "%"
        );
        $("#tgt-presentase-target-triwulan2").val(
            ((totalTargetTriwulan2 / totalNilaiY) * 100)
                .toFixed(2)
                .replace(/\.00$/, "") + "%"
        );
        $("#tgt-presentase-target-triwulan3").val(
            ((totalTargetTriwulan3 / totalNilaiY) * 100)
                .toFixed(2)
                .replace(/\.00$/, "") + "%"
        );
        $("#tgt-presentase-target-triwulan4").val(
            ((totalTargetTriwulan4 / totalNilaiY) * 100)
                .toFixed(2)
                .replace(/\.00$/, "") + "%"
        );
    }

    // change total every change in triwulan
    $("table tbody").on("change", "input", function () {
        calculateTotal();
    });
});
