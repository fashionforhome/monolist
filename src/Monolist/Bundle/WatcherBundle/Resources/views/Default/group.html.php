<!-- app/Resources/views/base.html.php -->
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php $view['slots']->output('title', 'Test Application') ?></title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="http://humblesoftware.com/static/js/hsd-flotr2.js"></script>
	<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/web/bundles/monolistwatcher/js/Chart.js"></script>
	<script type="text/javascript" src="/web/bundles/monolistwatcher/js/Metric/Requestor.js"></script>
<!--	<script src="--><?php //echo $view['assets']->getUrl('js/script.js') ?><!--" type="text/javascript"></script>-->
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

	<h1><?= $groupName ?></h1>

	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

			<ol class="carousel-indicators">
				<? $count = 0;?>
				<? foreach($groupMetrics as $val) : ?>
					<li data-target="#carousel-example-generic" data-slide-to="<?= $count ?>" <?= ($count === 0) ? 'class="active"' : 'class=""'; ?> ></li>
					<? $count++ ?>
				<? endforeach ; ?>
			</ol>

			<div class="carousel-inner" role="listbox">
				<? $count = 0;?>
				<? $groupCharts = array(); ?>
				<? foreach($groupMetrics as $metricName) : ?>
					<div <?= ($count === 0) ? 'class="item active"' : 'class="item"' ?> >
						<div class="render" id="<?= 'Chart' . $count;?>" style="position: relative;"></div>
					</div>
				<? $groupCharts[] = array('Chart'.$count, $metricName) ?>
				<? $count++ ?>
				<? endforeach ; ?>
			</div>

		<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

	<script>
		(function() {
			"use strict";

//			var container, metricName, metricDataArray, metricData;
			<? foreach($groupCharts as $groupChart) : ?>
				var container<?= $groupChart[0] ?>, metricName<?= $groupChart[0] ?>,
					metricDataArray<?= $groupChart[0] ?>, metricData<?= $groupChart[0] ?>;
			<? endforeach ; ?>

			<? foreach($groupCharts as $key => $groupChart) : ?>
				container<?= $groupChart[0] ?> = document.getElementById('<?= $groupChart[0] ?>');
				metricName<?= $groupChart[0] ?> = '<?= $groupChart[1] ?>';
				metricDataArray<?= $groupChart[0] ?> = Monolist.Watcher.Metric.Requestor.requestSingleMetricData(metricName<?= $groupChart[0] ?>);
				metricData<?= $groupChart[0] ?> = { 'metricName':metricName<?= $groupChart[0] ?>, 'dataArray': metricDataArray<?= $groupChart[0] ?> };
				<? if ($key === 0) : ?>
					Monolist.Watcher.Chart.drawTimeBased(container<?= $groupChart[0] ?>, metricData<?= $groupChart[0] ?>);
				<? endif ; ?>
				//update the chat every minute
				setInterval(function() {
					metricDataArray<?= $groupChart[0] ?> = Monolist.Watcher.Metric.Requestor.requestSingleMetricData(metricName<?= $groupChart[0] ?>);
					metricData<?= $groupChart[0] ?> = { 'metricName':metricName<?= $groupChart[0] ?>, 'dataArray': metricDataArray<?= $groupChart[0] ?> };
//					Monolist.Watcher.Chart.drawTimeBased(container<?//= $groupChart[0] ?>//, metricData<?//= $groupChart[0] ?>//);
				}, 1000*60);
			<? endforeach ; ?>

			$('#carousel-example-generic').on('slid', function() {
				<? foreach($groupCharts as $groupChart) : ?>
					Monolist.Watcher.Chart.drawTimeBased(container<?= $groupChart[0] ?>, metricData<?= $groupChart[0] ?>);
				<? endforeach ; ?>
				console.log('slide');
			});

		})();

		$('#carousel-example-generic').carousel({
			interval: 3000
		});

		$('#carousel-example-generic').on('slid', function() {

			console.log('slide:outer');
		});
	</script>

</div>
</body>
</html>


