$(function() {

 if($.plot){
 			var plot = $.plot($("#mws-dashboard-chart"), data, {
                  series: {
                      lines: {
                          show: true
                      },
                      points: {
                          show: true
                      }
                  },
                  grid: {
                      hoverable: true,
                      borderWidth: 0
                  }
              });
			  
			var d1 = [];
            for (var i = 0; i <= 31; i += 1)
            d1.push([i, parseInt(Math.random() * 30)]);

            var d2 = [];
            for (var i = 0; i <= 31; i += 1)
            d2.push([i, parseInt(Math.random() * 30)]);

            var d3 = [];
            for (var i = 0; i <= 31; i += 1)
            d3.push([i, parseInt(Math.random() * 30)]);

            var stack = 0,
                bars = true,
                lines = false,
                steps = false;

            $.plot($("#mws-bar-chart"), [d1, d2, d3], {
                series: {
                    stack: stack,
                    lines: {
                        show: lines,
                        fill: false,
                        steps: steps
                    },
                    bars: {
                        show: bars,
                        barWidth: 0.4
                    }
                }, 
                grid: {
					hoverable:true,
                    borderWidth: 0
                },
            });
		 }  
	});