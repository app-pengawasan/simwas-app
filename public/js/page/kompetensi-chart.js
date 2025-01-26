var opt = {
    legend: {
        display: false
    },
    tooltips: {
        enabled: false
    },
    scales: {
        yAxes: [{
        gridLines: {
            display: false,
            drawBorder: false,
        },
        ticks: {
            stepSize: 150
        }
        }],
        xAxes: [{
        gridLines: {
            color: '#fbfbfb',
            lineWidth: 2
        }
        }]
    },
    animation: {
        duration: 500,
        onComplete: function () {
            //menampilkan nilai
            var ctx = this.chart.ctx;
            ctx.font = Chart.helpers.fontString(14, 'normal', Chart.defaults.global.defaultFontFamily);
            ctx.fillStyle = this.chart.config.options.defaultFontColor;
            ctx.textAlign = 'center';
            ctx.textBaseline = 'bottom';
            this.data.datasets.forEach(function (dataset) {
                for (var i = 0; i < dataset.data.length; i++) {
                    var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                    ctx.fillText(dataset.data[i], model.x, model.y - 5);
                }
            });
        }
    },
    hover: {
        animationDuration: 0
    }
};

var diklat_chart = document.getElementById("diklatChart").getContext('2d');

var myChart = new Chart(diklat_chart, {
    type: 'bar',
    data: {
        labels: years,
        datasets: [
            {
                data: [],
                borderWidth: 3,
                borderColor: 'rgba(0, 105, 217, 1)',
                backgroundColor: 'rgba(0, 105, 217, 0.4)',
                // pointBorderColor: '#6777ef',
                // pointRadius: 4
            }
        ]
    },
    options: opt
});

var jp_chart = document.getElementById("JPChart").getContext('2d');

var myChart2 = new Chart(jp_chart, {
    type: 'bar',
    data: {
        labels: years,
        datasets: [
            {
                data: [],
                borderWidth: 3,
                borderColor: 'rgb(217, 83, 0)',
                backgroundColor: 'rgba(217, 83, 0, 0.4)',
                // pointBorderColor: '#6777ef',
                // pointRadius: 4
            }
        ]
    },
    options: opt
});

$('#filterPegawai').on("change", function () {
    //jumlah diklat
    diklat = diklat_count[$(this).val()];
    let max = 0;
    if (diklat) { //jika data pegawai ada
        myChart.data.labels = Object.keys(diklat);
        myChart.data.datasets[0].data = Object.values(diklat);
        max = Math.max(...Object.values(diklat)) + 1;
    } else {
        myChart.data.labels = years;
        myChart.data.datasets[0].data = [];
    }
    myChart.options.scales.yAxes[0].ticks.max = max;
    myChart.update();

    //total jp
    jp = jp_count[$(this).val()];
    max = 0;
    if (jp) { //jika data pegawai ada
        myChart2.data.labels = Object.keys(jp);
        myChart2.data.datasets[0].data = Object.values(jp);
        max = Math.max(...Object.values(jp)) + 30;
    } else {
        myChart2.data.labels = years;
        myChart2.data.datasets[0].data = [];
    }
    myChart2.options.scales.yAxes[0].ticks.max = max;
    myChart2.update();
});