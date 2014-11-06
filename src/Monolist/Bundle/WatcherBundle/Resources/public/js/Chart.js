var Monolist = Monolist || {};
Monolist.Watcher = Monolist.Watcher || {};
Monolist.Watcher.Chart = Monolist.Watcher.Chart || {};

Monolist.Watcher.Chart.drawTimeBased = function (container, metricData) {
	"use strict";

	var metricName,
		dataArray,
		defaultTickFormatter,
		flotrXaxisDefaultOpt,
		flotrYaxisDefaultOpt,
		flotrChartDefaultoptions,
		flotrXaxisSelectedAreaOpt,
		flotrYaxisSelectedAreaOpt,
		flotrChartSelectedAreaOptions,
		that = this;

	metricName = metricData['metricName'];
	dataArray = metricData['dataArray'];

	defaultTickFormatter = function (x) {
		"use strict";

		var parsedX, myDate, hour, min, result;

		parsedX = parseInt(x);
		myDate = new Date(parsedX*1000);
		hour = (myDate.getHours() > 9) ? myDate.getHours() : '0' + myDate.getHours();
		min = (myDate.getMinutes() > 9) ? myDate.getMinutes() : '0' + myDate.getMinutes();
		result = myDate.getDate() + ' - ' + hour + ':' + min;
		return result;
	};

	flotrXaxisDefaultOpt = {
		mode : 'time',
		labelsAngle : 45,
		noTicks: 15,
		tickFormatter: defaultTickFormatter,
		timeMode:'local'        // => For UTC time ('local' for local time).
	};

	flotrYaxisDefaultOpt = {
		min: null,              // => min. value to show, null means set automatically
		max: 100,             // => max. value to show, null means set automatically
		autoscale: true      // => Turns autoscaling on with true
	};

	flotrChartDefaultoptions = {
		xaxis : flotrXaxisDefaultOpt,
		selection : {
			mode : 'x'
		},
		yaxis: flotrYaxisDefaultOpt,
		HtmlText : false,
		title : metricName
	};

	// Deep copy
	flotrXaxisSelectedAreaOpt = jQuery.extend(true, {}, flotrXaxisDefaultOpt);
	flotrYaxisSelectedAreaOpt = jQuery.extend(true, {}, flotrYaxisDefaultOpt);
	flotrChartSelectedAreaOptions = jQuery.extend(true, {}, flotrChartDefaultoptions);

	if (Flotr) {
		Flotr.draw(container, dataArray, flotrChartDefaultoptions);

		Flotr.EventAdapter.observe(container, 'flotr:select', function(area){

			jQuery.extend(flotrXaxisSelectedAreaOpt, { min : area.x1, max : area.x2, mode : 'time', labelsAngle : 45 });
			jQuery.extend(flotrYaxisSelectedAreaOpt, { min : area.y1, max : area.y2 });

			jQuery.extend(flotrChartSelectedAreaOptions, {
				xaxis : flotrXaxisSelectedAreaOpt, yaxis : flotrYaxisSelectedAreaOpt
			});

			// Draw selected area
			Flotr.draw(container, dataArray, flotrChartSelectedAreaOptions);
		});

		// When graph is clicked, draw the graph with default area.
		Flotr.EventAdapter.observe(container, 'flotr:click', function() {Flotr.draw(container, dataArray, flotrChartDefaultoptions)});
	} else {
		throw new Exception('Flotr.js library was not included.');
	}
};
