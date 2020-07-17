var myHorizontalBar = null;
function loadBarChart(labels, label, data, cavas_id, title, type='bar', redraw=false) {

    var color = Chart.helpers.color;
    var barChartData = {
        labels: labels,
        datasets: [{
            label: label,
            borderWidth: 1,
            data: data
        }]

    };

    var ctx = document.getElementById(cavas_id).getContext('2d');
    myHorizontalBar = new Chart(ctx, {
        type: type,
        data: barChartData,
        options: {
            // Elements options apply to all of the options unless overridden in a dataset
            // In this case, we are setting the border of each horizontal bar to be 2px wide
            elements: {
                rectangle: {
                    borderWidth: 2,
                }
            },
            responsive: true,
            legend: {
                position: 'right',
            },
            title: {
                display: true,
                text: title
            }
        }
    });

}