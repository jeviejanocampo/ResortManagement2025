// Generate Data
function generateData(e, t, a) {
    for (var r = 0, o = []; r < t;) {
        var n = Math.floor(750 * Math.random()) + 1
            , l = Math.floor(Math.random() * (a.max - a.min + 1)) + a.min
            , m = Math.floor(61 * Math.random()) + 15;
        o.push([n, l, m]),
            r++
    }
    return o
}

//
// Basic Bubble Charts
//

import ApexCharts from 'apexcharts';
window.ApexCharts = ApexCharts;

var options = {
    series: [{
        name: 'Bubble1',
        data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
            min: 10,
            max: 60
        })
    },
    {
        name: 'Bubble2',
        data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
            min: 10,
            max: 60
        })
    },
    {
        name: 'Bubble3',
        data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
            min: 10,
            max: 60
        })
    },
    {
        name: 'Bubble4',
        data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
            min: 10,
            max: 60
        })
    }],
    chart: {
        height: 350,
        type: 'bubble',
        parentHeightOffset: 0,
    },
    colors: ["#2786f1", "#963b68", "#ec344c", "#287F71"],
    dataLabels: {
        enabled: false
    },
    fill: {
        opacity: 0.8
    },
    title: {
        text: 'Simple Bubble Chart'
    },
    xaxis: {
        tickAmount: 12,
        type: 'category',
    },
    yaxis: {
        max: 70
    }
};

var chart = new ApexCharts(document.querySelector("#simple_bubble_chart"), options);
chart.render();


// 
// 3D Bubble Chart
// 
var options = {
    series: [{
        name: 'Product1',
        data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
            min: 10,
            max: 60
        })
    },
    {
        name: 'Product2',
        data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
            min: 10,
            max: 60
        })
    },
    {
        name: 'Product3',
        data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
            min: 10,
            max: 60
        })
    },
    {
        name: 'Product4',
        data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
            min: 10,
            max: 60
        })
    }],
    chart: {
        height: 350,
        type: 'bubble',
        parentHeightOffset: 0,
    },
    dataLabels: {
        enabled: false
    },
    fill: {
        type: 'gradient',
    },
    title: {
        text: '3D Bubble Chart'
    },
    xaxis: {
        tickAmount: 12,
        type: 'datetime',
        labels: {
            rotate: 0,
        }
    },
    colors: ["#2786f1", "#963b68", "#f59440", "#73bbe2"],
    yaxis: {
        max: 70
    },
    theme: {
        palette: 'palette2'
    }
};
var chart = new ApexCharts(document.querySelector("#animation_bubble_chart"), options);
chart.render();