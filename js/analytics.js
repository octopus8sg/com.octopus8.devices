var ctx = document.getElementById('timechart').getContext('2d');
const labels = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
];
const data = {
    labels: labels,
    datasets: [{
        label: 'Health Monitoring Chart',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [0, 20, 35, 32, 40, 30, 35],
        fill: false,
        tension: 0.1
    }]
};
const config = {
    type: 'line',
    data
};
var myChart = new Chart(
    ctx,
    config
);