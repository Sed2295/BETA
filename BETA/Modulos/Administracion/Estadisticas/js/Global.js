$(document).ready(function () {
    $('#de, #hasta').datetimepicker({
        locale: 'es',
        viewMode: 'months',
        format: 'YYYY-MM-DD',
        icons: {
            previous: 'fa fa-chevron-circle-left',
            next: 'fa fa-chevron-circle-right'
        }
    })
    var date = new Date();
    $('#hasta').data("DateTimePicker").date(date);
    date.setDate(date.getDate() - 30);
    $('#de').data("DateTimePicker").date(date);
    })
