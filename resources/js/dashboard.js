const TOKEN = import.meta.env.VITE_TOKEN;
const rootUrl = "/akuna/public/";
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        url: rootUrl + 'api/statistic/ig',
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
            url: rootUrl + 'api/statistic',
            method: 'GET',
            headers: {
                Authorization: "Bearer " + TOKEN,
            },
            success: function (response) {
                $('#total_tx').text(Number(response.total_transaction).toLocaleString());
                $('#total_product').text(Number(response.total_products).toLocaleString());
                $('#total_member').text(Number(response.total_member).toLocaleString());
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
                $('.db_health').text('N/A');
            }
        });
    }

    getData();
    setInterval(getData, 10000);
});
