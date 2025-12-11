/*$(document).ready(function() {
    var options = {
    chart: {
        height: 350,
        type: 'line',
        toolbar: {
        show: false,
        },
    },
    colors: ['var(--bs-primary)', 'var(--bs-primary-bg-subtle)'],
    series: [{
        name: 'Registrations',
        type: 'column',
        data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
    }, {
        name: 'Orders',
        type: 'line',
        data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
    }],
    stroke: {
        width: [0, 4]
    },
    labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
    xaxis: {
        type: 'datetime'
    },
    yaxis: [{
        title: {
        text: 'Registrations',
        },
    }, {
        opposite: true,
        title: {
        text: 'Orders'
        }
    }]
    }
    var chart = new ApexCharts(document.querySelector("#apex-chart-line-column"), options);
    chart.render();
});*/
$(function(){
    "use strict"

    $.getJSON('/ajax/chart/regorder', function (response) {
        console.log(response);
        var options = {
        chart: {
            height: 350,
            type: 'line',
            toolbar: {
            show: false,
            },
        },
        colors: ['var(--bs-primary)', 'var(--bs-primary-bg-subtle)', 'var(--bs-success)'],
        series: [
            {
            name: 'Registrations',
            type: 'column',
            data: [response.registrations[0].rcount, response.registrations[1].rcount, response.registrations[2].rcount, response.registrations[3].rcount, response.registrations[4].rcount, response.registrations[5].rcount, response.registrations[6].rcount, response.registrations[7].rcount, response.registrations[8].rcount, response.registrations[9].rcount, response.registrations[10].rcount, response.registrations[11].rcount]
        }, 
        {
            name: 'Orders',
            type: 'line',
            data: [response.orders[0].ocount, response.orders[1].ocount, response.orders[2].ocount, response.orders[3].ocount, response.orders[4].ocount, response.orders[5].ocount, response.orders[6].ocount, response.orders[7].ocount, response.orders[8].ocount, response.orders[9].ocount, response.orders[10].ocount, response.orders[11].ocount]
        },
        {
            name: 'Delivered',
            type: 'line',
            data: [response.orders[0].dcount, response.orders[1].dcount, response.orders[2].dcount, response.orders[3].dcount, response.orders[4].dcount, response.orders[5].dcount, response.orders[6].dcount, response.orders[7].dcount, response.orders[8].dcount, response.orders[9].dcount, response.orders[10].dcount, response.orders[11].dcount]
        }
    ],
        stroke: {
            width: [0, 4]
        },
        labels: [
            response.registrations[0].month,
              response.registrations[1].month,
              response.registrations[2].month,
              response.registrations[3].month,
              response.registrations[4].month,
              response.registrations[5].month,
              response.registrations[6].month,
              response.registrations[7].month,
              response.registrations[8].month,
              response.registrations[9].month,
              response.registrations[10].month,
              response.registrations[11].month
            ],
        xaxis: {
            type: 'string'
        },
        yaxis: [{
            title: {
            text: 'Registrations',
            },
        }, {
            opposite: true,
            title: {
            text: 'Orders & Delivered'
            }
        }]
        }
    var chart = new ApexCharts(document.querySelector("#apex-chart-line-column"), options);
    chart.render();
    });
})