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
    diklat = diklat_count[$(this).val()];
    diklat_arr = [];
    if (diklat) {
        years.forEach((tahun) => {
                if (diklat[tahun]) diklat_arr.push(diklat[tahun]);
                else diklat_arr.push(0);
            }
        )
    }
    myChart.data.datasets[0].data = diklat_arr;
    myChart.update();

    jp = jp_count[$(this).val()];
    jp_arr = [];
    if (jp) {
        years.forEach((tahun) => {
                if (jp[tahun]) jp_arr.push(jp[tahun]);
                else jp_arr.push(0);
            }
        )
    }
    myChart2.data.datasets[0].data = jp_arr;
    myChart2.update();
});