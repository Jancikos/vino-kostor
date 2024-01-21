import ApexCharts from "apexcharts";

const chartUnpackedproducts = () => {
    const chartWrapper = $("#chart-unpackedproducts-wrapper");

    // default options
    const chartOptions = {
        series: [65, 34, 45, 12],
        chart: {
            type: "donut",
            width: 380,
        },
        colors: ["#3C50E0", "#6577F3", "#8FD0EF", "#0FADCF"],
        labels: ["Desktop", "Tablet", "Mobile", "Unknown"],
        legend: {
            show: false,
            position: "bottom",
        },

        plotOptions: {
            pie: {
                donut: {
                    size: "65%",
                    background: "transparent",
                },
            },
        },

        dataLabels: {
            enabled: false,
        },
        responsive: [
            {
                breakpoint: 500,
                options: {
                    chart: {
                        width: 200,
                    },
                },
            },
        ]
    };

    showLoader();
    $.ajax({
        url: chartWrapper.data('url'),
        type: 'POST',
        data: {

        },
        success: function (data) {
            if (data.series.length === 0) {
                chartWrapper.find("#no-product-msg").show();
                return;
            }
            // // zapis sumare
            // chartWrapper.find('.total-revenue').text(data.sums.revenue);
            // chartWrapper.find('.total-orders').text(data.sums.orders);

            // // nastav data do grafu
            chartOptions.series = data.series;
            chartOptions.labels = data.labels;
            chartOptions.colors = data.colors;

            // set chart items
            const itemsWrapper = chartWrapper.find('#chart-unpackedproducts-items-wrapper');
            const itemTemplate = chartWrapper.find('#chart-unpackedproducts-item-template');
            console.log(itemTemplate);
            // add items
            itemsWrapper.empty();
            let i = 0;
            data.series.forEach((serie) => {
                console.log(serie);
                const itemClone = itemTemplate.clone();
                itemClone
                    .removeAttr('id')
                    .removeClass('hidden');
                
                itemClone.find('.dot').css('background-color', data.colors[i]);
                itemClone.find('.title').text(data.labels[i]);
                itemClone.find('.value').text(data.series[i] + " ks");

                itemsWrapper.append(itemClone);
                i++;
            });


            // zobraz graf
            const chartSelector = document.querySelectorAll("#chart-unpackedproducts");
            if (chartSelector.length) {
                const chartUnpackedproducts = new ApexCharts(
                    document.querySelector("#chart-unpackedproducts"),
                    chartOptions
                );
                chartUnpackedproducts.render();
            }
        },
        error: function (data) {
            chartWrapper.text('Graf sa unpackedproducts sa nepodarilo načítať.');
        },
        complete: function (data) {
            hideLoader();
        },
    });
};

export default chartUnpackedproducts;
