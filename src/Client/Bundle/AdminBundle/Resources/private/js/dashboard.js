var createChart = function($el, tooltipTemplateValue)
{
    var pieChartCanvas = $el.get(0).getContext("2d");

    var myChart = new Chart(pieChartCanvas, {
        type: 'doughnut',
        data: {
            labels: ["Facebook", "Twitter"],
            datasets: [
            {
                data: [$el.data('facebookTotals'), $el.data('twitterTotals')],
                backgroundColor: [
                    "#0073b7",
                    "#d2d6de"
                ],
                hoverBackgroundColor: [
                    "#FF6384",
                    "#36A2EB",
                    "#FFCE56"
                ]
            }]
        }
    });
};

$(function () {

    'use strict';

    createChart($("#participacionesSocialNetwork"), "<%=value %> participaciones en <%=label%>");
    createChart($("#participantsSocialNetwork"), "<%=value %> participantes en <%=label%>");
});