CRM.$(function ($) {
    var ctx = document.getElementById('ChartLine').getContext('2d');
    var json_url = CRM.vars.ajax_url[0];
    var contact_id = CRM.vars.ajax_url[1];

    json_url = json_url.toString().replace(/&amp;/g, '&');
    var labels = [];
    var heart_rate = [];
    var temperature = [];
    // var labels = CRM.vars.labels;
    // var heart_rate = CRM.vars.heart_rate;
    // var temperature = CRM.vars.temperature;
    var colors = [{
        "name": "Ming",
        "hex": "416b70",
        "rgb": [65, 107, 112],
        "cmyk": [42, 4, 0, 56],
        "hsb": [186, 42, 44],
        "hsl": [186, 27, 35],
        "lab": [42, -13, -7]
    }, {
        "name": "French Sky Blue",
        "hex": "73abf4",
        "rgb": [115, 171, 244],
        "cmyk": [53, 30, 0, 4],
        "hsb": [214, 53, 96],
        "hsl": [214, 85, 70],
        "lab": [69, 2, -42]
    }, {
        "name": "Cornflower Blue",
        "hex": "8791ff",
        "rgb": [135, 145, 255],
        "cmyk": [47, 43, 0, 0],
        "hsb": [235, 47, 100],
        "hsl": [235, 100, 76],
        "lab": [64, 25, -56]
    }, {
        "name": "Blue Violet",
        "hex": "7b43c4",
        "rgb": [123, 67, 196],
        "cmyk": [37, 66, 0, 23],
        "hsb": [266, 66, 77],
        "hsl": [266, 52, 52],
        "lab": [42, 50, -59]
    }, {
        "name": "Palatinate Purple",
        "hex": "4e1a4e",
        "rgb": [78, 26, 78],
        "cmyk": [0, 67, 0, 69],
        "hsb": [300, 67, 31],
        "hsl": [300, 50, 20],
        "lab": [20, 32, -21]
    }, {
        "name": "French Lilac",
        "hex": "805d93",
        "rgb": [128, 93, 147],
        "cmyk": [13, 37, 0, 42],
        "hsb": [279, 37, 58],
        "hsl": [279, 22, 47],
        "lab": [45, 25, -24]
    }, {
        "name": "Amaranth Pink",
        "hex": "f49fbc",
        "rgb": [244, 159, 188],
        "cmyk": [0, 35, 23, 4],
        "hsb": [340, 35, 96],
        "hsl": [340, 79, 79],
        "lab": [75, 35, -2]
    }, {
        "name": "Apricot",
        "hex": "ffd3ba",
        "rgb": [255, 211, 186],
        "cmyk": [0, 17, 27, 0],
        "hsb": [22, 27, 100],
        "hsl": [22, 100, 86],
        "lab": [88, 12, 18]
    }, {
        "name": "Olivine",
        "hex": "9ebd6e",
        "rgb": [158, 189, 110],
        "cmyk": [16, 0, 42, 26],
        "hsb": [84, 42, 74],
        "hsl": [84, 37, 59],
        "lab": [73, -24, 36]
    }, {
        "name": "Paolo Veronese Green",
        "hex": "169873",
        "rgb": [22, 152, 115],
        "cmyk": [86, 0, 24, 40],
        "hsb": [163, 86, 60],
        "hsl": [163, 75, 34],
        "lab": [56, -42, 10]
    }];
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: "Value",
                data: [],
                backgroundColor: 'rgb(' + colors[0]['rgb'][0] + ',' + colors[0]['rgb'][1] + ',' + colors[0]['rgb'][1] + ', 0.2)',
                borderColor: 'rgb(' + colors[0]['rgb'][0] + ',' + colors[0]['rgb'][1] + ',' + colors[0]['rgb'][1] + ')'
            }]
        },
        options: {
            responsive: true,
            title:
                {
                    display: true,
                    text:
                        'Data Values'
                }
            ,
            tooltips: {
                mode: 'index',
                intersect:
                    false,
            }
            ,
            hover: {
                mode: 'nearest',
                intersect:
                    true
            }
            ,
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Days'
                    }
                }],
                yAxes:
                    [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Values'
                        }
                    }]
            },
                maintainAspectRatio: false,
        }
    });

    var newdata = {};
    newdata["sensor_id"] = 1;
    newdata["contact_id"] = contact_id;
    ajax_chart(myChart, json_url, newdata);

    $('.chart-filter :input').change(function () {

        var newdata = {};


        newdata["dateselect_from"] = $('#chart_dateselect_from').val();

        
        newdata["dateselect_to"] = $('#chart_dateselect_to').val();

        newdata["device_type_id"] = $('#chart_device_type_id').val();

        newdata["sensor_id"] = $('#chart_sensor_id').val();
        newdata["contact_id"] = contact_id;

        // alert(newdata["dateselect_from"] );
        // alert(newdata["dateselect_to"] );
        // alert(newdata["device_type_id"] );
        // alert(newdata["sensor_id"] );
        ajax_chart(myChart, json_url, newdata);
    });


    // function to update our chart
    function ajax_chart(chart, url, data) {
        url = url.toString().replace(/&amp;/g, '&');
        // alert('done4');

        var data = data || {};

        $.post(url, data, function (response) {
            chart.data.labels = response.labels;
            var datasets = response.datasets;
            var i = 0;
            var c = 0;
            chart.data.datasets.length = 0;
            Array.from(datasets).forEach(function (item) {
                if (Array.from(item.data).length !== 0) {
                    chart.data.datasets.push({
                        label: item.label,
                        data: item.data,
                        backgroundColor: 'rgb(' + colors[c]['rgb'][0] + ',' + colors[c]['rgb'][1] + ',' + colors[c]['rgb'][1] + ', 0.2)',
                        borderColor: 'rgb(' + colors[c]['rgb'][0] + ',' + colors[c]['rgb'][1] + ',' + colors[c]['rgb'][1] + ')'
                    });
                    c++;
                }
                i++;
            });

            chart.update(); // finally update our chart
        }, "json");

        // $.getJSON(url, data).done(function(response) {
        //     chart.data.labels = response.labels;
        //     chart.data.datasets[0].data = response.heart_rate; // or you can iterate for multiple datasets
        //     chart.data.datasets[1].data = response.temperature; // or you can iterate for multiple datasets
        //     chart.update(); // finally update our chart
        // });

    }


});