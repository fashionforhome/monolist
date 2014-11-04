<!-- app/Resources/views/base.html.php -->
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php $view['slots']->output('title', 'Test Application') ?></title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="http://humblesoftware.com/static/js/hsd-flotr2.js"></script>
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
		var monolist = monolist || {};
		monolist.metric = monolist.metric || {};
		monolist.metric.current = monolist.metric.current || {};
		monolist.metric.current.name = '<?= $metricName;?>' || {};

		(function basic_time(container) {

			function getMetricJson() {
				var metricData;
				$.ajaxSetup({
					async: false
				});
				$.getJSON( "/web/app_dev.php/watcher/api/metric/single/" + monolist.metric.current.name, function( data ) {
					metricData = data;
				});

				$.ajaxSetup({
					async: true
				});

				return metricData;
			}
//			console.log(getMetricJson());
			var metricData = getMetricJson();

			var
				d1    = [],
				start = new Date().getTime() - 60*60*24*3,
				options,
				graph,
				i, x, o;

			for (i = 0; i < 100; i++) {
				x = start+(i*1000*3600*24*36.5);
				d1.push([x, i+Math.random()*30+Math.sin(i/20+Math.random()*2)*20+Math.sin(i/10+Math.random())*10]);
			}

			options = {
				xaxis : {
					mode : 'time',
					labelsAngle : 45,
					noTicks: 15,
					tickFormatter: function(x){
						var x = parseInt(x);
						var myDate = new Date(x*1000);
						var hour = (myDate.getHours() > 9) ? myDate.getHours() : '0' + myDate.getHours();
						var min = (myDate.getMinutes() > 9) ? myDate.getMinutes() : '0' + myDate.getMinutes();
						var month = (myDate.getMonth() > 9) ? myDate.getMonth() : '0' + myDate.getMonth();
						string = myDate.getDate() + ' - ' + myDate.getHours() + ':' + min;
						result = string;
						return string;
					},
					timeMode:'UTC'        // => For UTC time ('local' for local time).
				},
				selection : {
					mode : 'x'
				},
				HtmlText : false,
				title : 'Time'
			};

			// Draw graph with default options, overwriting with passed options
			function drawGraph (opts) {

				// Clone the options, so the 'options' variable always keeps intact.
				o = Flotr._.extend(Flotr._.clone(options), opts || {});

				// Return a new graph.
				return Flotr.draw(
					container,
//					[
//						{ data : d1, label : 'Comedy' },
//						{ data : d2, label : 'Action' }
//					],
					metricData,
					o
				);
			}



			graph = drawGraph();

			Flotr.EventAdapter.observe(container, 'flotr:select', function(area){
				// Draw selected area
				graph = drawGraph({
					xaxis : { min : area.x1, max : area.x2, mode : 'time', labelsAngle : 45 },
					yaxis : { min : area.y1, max : area.y2 }
				});
			});

			// When graph is clicked, draw the graph with default area.
			Flotr.EventAdapter.observe(container, 'flotr:click', function () { graph = drawGraph(); });

			//update the chat every minute
			setInterval(function() {
				metricData = getMetricJson();
				graph = drawGraph();
			}, 1000*60);

		})(document.getElementById("editor-render-0"));
	</script>

</div>
</body>
</html>


