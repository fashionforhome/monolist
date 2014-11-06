var Monolist = Monolist || {};
Monolist.Watcher = Monolist.Watcher || {};
Monolist.Watcher.Metric = Monolist.Watcher.Metric || {};
Monolist.Watcher.Metric.Requestor = Monolist.Watcher.Metric.Requestor || {};

Monolist.Watcher.Metric.Requestor.requestSingleMetricData = function(metricName) {
	"use strict";

	var metricData;

	$.ajaxSetup({
		async: false
	});
	$.getJSON( "/web/app_dev.php/watcher/api/metric/single/" + metricName, function(data) {
		metricData = data;
	});

	$.ajaxSetup({
		async: true
	});

	return metricData;
};