let today = new Date();
$('#filterBulan').val(("0" + (today.getMonth() + 1)).slice(-2));
$('#filterTahun').val(today.getFullYear());

$(".nilai-btn").on("click", function () {
    document.forms['myform'].reset();
    let id_pegawai = $(this).attr("data-pegawai");
    let bulan = $(this).attr("data-bulan");
    let tahun = $(this).attr("data-tahun");
    $('#id_pegawai').val(id_pegawai);
    $('#bulan').val(bulan);
    $('#tahun').val(tahun);
});

$(".edit-btn").on("click", function (e) {
    e.preventDefault();

    let id_pegawai = $(this).attr("data-pegawai");
    let bulan = $(this).attr("data-bulan");
    let tahun = $(this).attr("data-tahun");
    $('#edit-id-pegawai').val(id_pegawai);
    $('#edit-bulan').val(bulan);
    $('#edit-tahun').val(tahun);
    $('#error-edit-nilai').text('');

    $.ajax({
        url: `/inspektur/penilaian-kinerja/nilai/${id_pegawai}/${bulan}/${tahun}`,
        type: "GET",
        cache: false,
        success: function (response) {
            document.forms['myeditform'].reset();
            $("#edit-id").val(response.data[0].id);
            $("#edit-nilai").val(response.data[0].nilai);
            $("#edit-catatan").val(response.data[0].catatan);
        },
    });
});

$('.submit-btn').on("click", function (e) {
    e.preventDefault();
    $('#error-nilai').text('');

    let token = $("meta[name='csrf-token']").attr("content");
    let id_pegawai = $('#id_pegawai').val();
    let bulan = $('#bulan').val();
    let tahun = $('#tahun').val();
    let nilai = $("#nilai").val();
    let catatan = $("#catatan").val();
    $.ajax({
        url: `/inspektur/penilaian-kinerja`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            nilai: nilai,
            catatan: catatan,
            id_pegawai: id_pegawai,
            bulan: bulan,
            tahun: tahun
        },
        success: function (response) {
            location.reload();
            $('#filterBulan').val(bulan);
        },
        error: function (error) {
            $('form').removeClass('was-validated');
            $('.form-group').addClass('was-validated');

            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = `${value}`;
            });
        },
    });
});

$('.submit-edit-btn').on("click", function (e) {
    e.preventDefault();

    let dataId = $('#edit-id').val();
    let token = $("meta[name='csrf-token']").attr("content");
    let nilai = $("#edit-nilai").val();
    let catatan = $("#edit-catatan").val();
    $.ajax({
        url: `/inspektur/penilaian-kinerja/${dataId}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            nilai: nilai,
            catatan: catatan
        },
        success: function (response) {
            location.reload();
            $('#filterBulan').val(bulan);
        },
        error: function (error) {
            $('form').removeClass('was-validated');
            $('.form-group').addClass('was-validated');

            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                // console.log(errors);
                let errorMessage = document.getElementById(`error-edit-${key}`);
                errorMessage.innerText = `${value}`;
            });
        },
    });
});

let table = $("#table-daftar-nilai")
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
                    columns: [0, 1, 2, 3, 4, 5],
                },
                messageTop: function () {
                    return $(":selected", '#filterBulan').text() + ' ' + $(":selected", '#filterTahun').text();
                },
            },
            {
                extend: "pdf",
                className: "btn-danger",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
                messageTop: function () {
                    return $(":selected", '#filterBulan').text() + ' ' + $(":selected", '#filterTahun').text();
                },
            },
        ],
    }).api();

$('#filterBulan').on("change", function () {
    if ($(this).val() == 'all') {
        table.column(5).visible(false);
        $(table.column(4).header()).text('Rata-Rata Nilai');
    } else {
        table.column(5).visible(true);
        $(table.column(4).header()).text('Hasil Penilaian');
    }
    table.draw();
});

$('#filterTahun').on("change", function () {
    table.draw();
});

let allowFilter = ['table-daftar-nilai'];

$.fn.dataTableExt.afnFiltering.push(
    function (setting, data, index) {
        // check if current table is part of the allow list
        if ( $.inArray( setting.nTable.getAttribute('id'), allowFilter ) == -1 ) {
            // if not table should be ignored
            return true;
        }
        var selectedBulan = $('select#filterBulan option:selected').val();
        var selectedTahun = $('select#filterTahun option:selected').val();
        if (data[7] == selectedBulan && data[8] == selectedTahun) return true;
        else return false;
    }
);

table.draw();

$('#filterBulan').val() == 'all' ? table.column(6).visible(false) : table.column(6).visible(true);

$("#table-nilai")
    .dataTable({
        dom: "Bfrtip",
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        buttons: [
            {
                extend: "excel",
                className: "btn-success unduh",
                text: '<i class="fas fa-file-excel"></i> Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 9, 5, 6, 7],
                },
                messageTop: function () {
                    return $('.section-header').text();
                },
            },
            {
                extend: "pdf",
                className: "btn-danger unduh",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                exportOptions: {
                    columns: [0, 1, 2, 3, 9, 5, 6, 7],
                },
                messageTop: function () {
                    return $('.section-header').text();
                },
            },
            {
                text: 'Lihat Aktivitas Pegawai',
                className: 'btn btn-primary kalender-btn',
            },
        ],
    });

$('#table-nilai_wrapper .dt-buttons').removeClass('btn-group').addClass('mb-4');
$('.unduh').wrapAll('<div class="btn-group"></div>');
$('.kalender-btn').wrapAll('<div style="float: right"></div>');
$('.kalender-btn').on("click", function () {
    $('#kalenderModal').modal('show');
});

var calendarEl = $("#calendar")[0];
var calendar = new FullCalendar.Calendar(calendarEl, {
    locale: 'id',
    aspectRatio: 2.6,
    nowIndicator: true,
    slotDuration: '01:00:00',
    eventOverlap: false,
    selectOverlap: function(event) {
        return this.calendar.currentData.currentViewType == 'dayGridMonth';
    },
    events: events,
    headerToolbar: {
        start: 'prev,next today excel',
        center: 'title',
        end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth' // user can switch between the two
    },
    allDayContent:  {
        html: '<i class="fa-regular fa-clock"></i>'
    },
    buttonText: {
        today:    'Hari ini',
        month:    'Bulan',
        week:     'Minggu',
        day:      'Hari',
        list:     'List'
    },
    customButtons: {
        excel: {
            text: 'Excel',
            click: function() {
                let bulan = moment(calendar.getDate()).format("MM");
                let tahun = moment(calendar.getDate()).format("YYYY");
                window.location.href = `/inspektur/penilaian-kinerja/export/${pegawai}/${bulan}/${tahun}`;
            }
        }
    },
    views: {
        dayGridMonth: { // name of view
            eventTimeFormat: function(date) {
                let eDate = date.start.array;
                moment.locale('en');
                if (eDate[4] === 0) return moment(eDate).format('ha');
                else return moment(eDate).format('h.ma')
            },
            selectable: true,
            select: function(selectionInfo) {
                let startDate = moment(selectionInfo.start).format("YYYY-MM-DD");
                let endDate = moment(selectionInfo.end).format("YYYY-MM-DD");
                let selisih = Date.parse(endDate) - Date.parse(startDate);
                //jika hanya memilih sehari pindah ke view day, jika memilih berhari-hari pindah ke view week
                if (selisih == 86400000) calendar.changeView('timeGridDay', startDate);
                else calendar.changeView('timeGridWeek', startDate);
            }
        },
        timeGrid: {
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit'
            }
        },
        list: {
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit'
            },
            eventDidMount: function(info) {
                document.querySelector(".fc-excel-button").style.display = "inline-block";
                // alert(JSON)
                info.el.querySelector('.fc-list-event-title a').innerHTML
                    += ` <br><table class="table-borderless"><tbody>
                        <tr><td class="pl-0 pb-0"><strong>Objek Pengawasan: </strong></td>
                            <td class="pl-0 pb-0" style="white-space: pre-line;">${
                                info.event.extendedProps.laporan_o_pengawasan.objek_pengawasan.nama
                            }
                            </td>
                        </tr>
                        <tr><td class="pl-0 pb-0"><strong>Bulan Pelaporan: </strong></td>
                            <td class="pl-0 pb-0" style="white-space: pre-line;">${
                                Intl.DateTimeFormat('id', { month: 'long' }).format(new Date(
                                    info.event.extendedProps.laporan_o_pengawasan.month.toString()
                                ))}
                            </td>
                        </tr>
                        <tr><td class="pl-0"><strong>Aktivitas: </strong></td>
                            <td class="pl-0" style="white-space: pre-line;">${info.event.extendedProps.aktivitas}</td>
                        </tr></tbody></table>`;
            },
        }
    },
    eventDidMount: function(info) {
        document.querySelector(".fc-excel-button").style.display = "none";
        moment.locale('id');
        let startdate = moment(info.event.start);
        let enddate = moment(info.event.end);
        let status; let tag;
        $(info.el).popover({
            sanitize: false,
            title: '<button id="close" class="close ml-3">&times;</button>',
            trigger: 'click',
            placement: 'right',
            html: true,
            content: '<h3>' + info.event.title + '</h3>' +
                     '<h4>Objek Pengawasan: ' + 
                                info.event.extendedProps.laporan_o_pengawasan.objek_pengawasan.nama + '</h4>' +
                     '<h4>Bulan Pelaporan: ' + Intl.DateTimeFormat('id', { month: 'long' }).format(new Date(
                                info.event.extendedProps.laporan_o_pengawasan.month.toString()
                            )) + '</h4>' +
                    startdate.format('dddd, D MMMM YYYY • HH:mm - ') + enddate.format('HH:mm')
                    + '<br><strong>Aktivitas:</strong><br>' + info.event.extendedProps.aktivitas
        });
    },
    handleWindowResize: true
});

calendar.render();

$('#kalenderModal').on('shown.bs.modal', function () {
    calendar.render();
});

if (events[0]['initialDate']) {
    calendar.gotoDate(events[0]['initialDate']);
}

//tutup popover event saat klik di luar atau buka modal
$("html").on("mouseup", function (e) {
    var l = $(e.target);
    if (l[0].className.indexOf("popover") == -1) {
        $(".popover").each(function () {
            $(this).popover("hide");
        });
    }
});
