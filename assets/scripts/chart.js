$(document).ready(function() {
  $.getScript('http://www.chartjs.org/assets/Chart.js',function(){
    
      var data = {
          labels : ["January","February","March","April","May","June","July"],
          datasets : [
              
              {
                  fillColor : "rgba(151,187,205,0.5)",
                  strokeColor : "rgba(151,187,205,1)",
                  pointColor : "rgba(151,187,205,1)",
                  pointStrokeColor : "#fff",
                  data : [28,48,40,19,96,27,100]
              }
          ]
      };
  
      var options = {
        animation: true,
        responsive : false,
        tooltipTemplate: "<%= value %>",
        tooltipFillColor: "rgba(0,0,0,0)",
        tooltipFontColor: "#444",
        tooltipEvents: [],
        tooltipCaretSize: 0,
        onAnimationComplete: function()
        {
            this.showTooltip(this.datasets[0].bars, true);
        }
      };
  
      //Get the context of the canvas element we want to select
      var c = $('#myChart11');
      var ct = c.get(0).getContext('2d');
      var ctx = document.getElementById("myChart").getContext("2d");
      /*********************/
      new Chart(ctx).Bar(data,options);
      
      var d = $('#myChart111');
      var dt = d.get(0).getContext('2d');
      var dtx = document.getElementById("myChart1").getContext("2d");
      /*********************/
      new Chart(dtx).Bar(data,options);
  
  })
});