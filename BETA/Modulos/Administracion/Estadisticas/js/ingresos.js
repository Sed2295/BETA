$(document).ready( () => {
    var ctx = document.getElementById("grafica");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                label: 'Open Pay',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: 'rgba(232, 130, 22, 0.8)',                        
                borderColor: 'rgba(255, 131, 0, 1)',
                borderWidth: 1
            },{
                label: 'Conekta',
                data: [10, 11, 3, 1, 5, 8],
                backgroundColor: 'rgba(233, 30, 227, 0.8)',                        
                borderColor: 'rgba(203, 17, 198, 1)',
                borderWidth: 1
            },{
                label: 'Pay Pal',
                data: [2, 1, 8, 0, 7, 1],
                backgroundColor: 'rgba(40, 117, 228, 0.8)',                        
                borderColor: 'rgba(0, 91, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });

    var ctx = document.getElementById("IngresosPastel");
    var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            datasets: [{data: [10, 20, 30]}],
            labels: ['OpenPay','Conekta','Pay Pal']
        }
       
    });


});












