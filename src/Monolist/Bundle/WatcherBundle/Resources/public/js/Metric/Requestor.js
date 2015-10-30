/**
 * @author Tino Stöckel <tino.stoeckel@fashionforhome.de>
 *
 * @copyright (c) 2014 by fashion4home GmbH <www.fashionforhome.de>
 * @license GPL-3.0
 * @license http://opensource.org/licenses/GPL-3.0 GNU GENERAL PUBLIC LICENSE
 *
 * @version 1.0.0
 */
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