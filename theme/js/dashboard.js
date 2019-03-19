$(function(){
  'use strict';



  // Responsive Mode
  new ResizeSensor($('.kt-mainpanel'), function(){
    rs1.configure({
      width: $('#rs1').width(),
      height: $('#rs1').height()
    });
    rs1.render();
  });
 

  // Responsive Mode
  new ResizeSensor($('.kt-mainpanel'), function(){
    rs2.configure({
      width: $('#rs2').width(),
      height: $('#rs2').height()
    });
    rs2.render();
  });

  var ctb4 = document.getElementById('chartBar4').getContext('2d');
  new Chart(ctb4, {
    type: 'horizontalBar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
      datasets: [{
        label: '# of Votes',
        data: [12, 39, 20, 10, 25, 18, 10, 15],
        backgroundColor: [
          '#324463',
          '#5B93D3',
          '#7CBDDF',
          '#5B93D3',
          '#324463',
          '#17A2B8',
          '#DC3545',
          '#6F42C1'
        ]
      }]
    },
    options: {
      legend: {
        display: false,
          labels: {
            display: false
          }
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero:true,
            fontSize: 10
          }
        }],
        xAxes: [{
          ticks: {
            beginAtZero:true,
            fontSize: 11,
            max: 50
          }
        }]
      }
    }
  });

});
