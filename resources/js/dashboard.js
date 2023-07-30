import TOKEN from "./API_KEY";

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        url: '/api/statistic/ig',
        method: 'GET',
        headers: {
            Authorization: "Bearer " + TOKEN,
        },
        success: function (response) {
            $('#ig_followers').text(Number(response.ig_followers).toLocaleString());
        },
        error: function () {
            $('#ig_followers').text('N/A');
        }
    });

    function getData() {
        $.ajax({
            url: '/api/statistic',
            method: 'GET',
            headers: {
                Authorization: "Bearer " + TOKEN,
            },
            success: function (response) {
                var loadAvg = (response.load_avg_1min + response.load_avg_5min + response.load_avg_15min) / 3;
                $('#total_tx').text(Number(response.total_transaction).toLocaleString());
                $('#total_product').text(Number(response.total_products).toLocaleString());
                $('#total_member').text(Number(response.total_member).toLocaleString());
                $('#load_avg').text(loadAvg.toFixed(2) + " %");
                if (response.db_health_status === 'healthy') {
                    var textColor = 'text-green-400';
                } else {
                    var textColor = 'text-red-400';
                }
                $('.db_health').addClass(textColor);
                $('.db_health').text(response.db_health_status);
            },
            error: function () {
                $('#total_tx').text('N/A');
                $('#total_product').text('N/A');
                $('#total_member').text('N/A');
                $('#load_avg').text('N/A %');
                $('.db_health').text('N/A');
            }
        });
    }

    getData();
    setInterval(getData, 10000);
});
