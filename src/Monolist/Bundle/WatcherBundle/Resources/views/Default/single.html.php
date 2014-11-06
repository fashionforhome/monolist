<!-- app/Resources/views/base.html.php -->
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php $view['slots']->output('title', 'Test Application') ?></title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="http://humblesoftware.com/static/js/hsd-flotr2.js"></script>
	<script type="text/javascript" src="/web/bundles/monolistwatcher/js/Chart.js"></script>
	<script type="text/javascript" src="/web/bundles/monolistwatcher/js/Metric/Requestor.js"></script>
	<style type="text/css">
		body {
			margin: 0px;
			padding: 0px;
		}
		#container {
			width : 600px;
			height: 400px;
			margin: 8px auto;
		}

		.render {
			width: 1500px;
			height: 600px;
			margin: 12px auto 18px auto;
		}
	</style>
</head>
<body>
<div id="sidebar">
	<?php if ($view['slots']->has('sidebar')): ?>
		<?php $view['slots']->output('sidebar') ?>
	<?php else: ?>
<!--		<ul>-->
<!--			<li><a href="/web/app_dev.php/overview">Overview</a></li>-->
<!--<!--			<li><a href="/blog">Blog</a></li>-->
<!--		</ul>-->

		<nav class="navbar navbar-default" role="navigation">
			<!-- We use the fluid option here to avoid overriding the fixed width of a normal container within the narrow content columns. -->
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-6">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Monolist</a>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-6">
					<ul class="nav navbar-nav">
						<li class="active"><a href="/web/app_dev.php/watcher/overview">Overview</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div>
		</nav>
	<?php endif; ?>
</div>

<div id="content">
	<?php $view['slots']->output('body') ?>

		<h1><?= $metricName ?></h1>

	<div class="render" id="editor-render-0" style="position: relative;">
	<script>
//		var monolist = monolist || {};
//		monolist.metric = monolist.metric || {};
//		monolist.metric.current = monolist.metric.current || {};
//		monolist.metric.current.name = '<?//= $metricName;?>//' || {};

		(function() {
			"use strict";
			var container, metricName, metricDataArray, metricData;

			container = document.getElementById('editor-render-0');
			metricName = '<?= $metricName;?>';
			metricDataArray = Monolist.Watcher.Metric.Requestor.requestSingleMetricData(metricName);
			metricData = { 'metricName':metricName, 'dataArray': metricDataArray };

			Monolist.Watcher.Chart.drawTimeBased(container, metricData);

			//update the chat every minute
			setInterval(function() {
				metricDataArray = Monolist.Watcher.Metric.Requestor.requestSingleMetricData(metricName);
				metricData = { 'metricName':metricName, 'dataArray': metricDataArray };
				Monolist.Watcher.Chart.drawTimeBased(container, metricData);
			}, 1000*60);
		})();
	</script>

</div>
</body>
</html>


