<!-- app/Resources/views/base.html.php -->
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php $view['slots']->output('title', 'Test Application') ?></title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
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
<!--						<li><a href="#">Link</a></li>-->
<!--						<li><a href="#">Link</a></li>-->
					</ul>
				</div><!-- /.navbar-collapse -->
			</div>
		</nav>
	<?php endif; ?>
</div>

<div id="content">
	<?php $view['slots']->output('body') ?>
<!--	<div>Hello --><?//= $name ?><!--</div>-->
	<h1>Report table</h1>
	<div class="table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>#</th>
					<th>Single Reports</th>
					<th>Group Reports</th>
				</tr>
			</thead>
			<tbody>
			<? $max = (count($reports['single']) >= count($reports['groups'])) ? count($reports['single']) : count($reports['groups']); ?>
			<? for($i = 0; $i < $max; $i++ ) : ?>
				<tr>
					<td><?= $i+1 ?></td>

					<!--singleReports-->
					<?php if (isset($reports['single'][$i])): ?>
						<? $metricName = $reports['single'][$i];?>
						<td><a href="/web/app_dev.php/watcher/show/chart/single/<?= $metricName;?>"><?= $metricName;?></a></td>
					<?php else: ?>
						<td></td>
					<?php endif; ?>

					<!--groupReports-->
					<?php if (isset($reports['groups'][$i])): ?>
						<? $groupName = $reports['groups'][$i];?>
						<td><a href="/web/app_dev.php/watcher/show/chart/groups/<?= $groupName;?>"><?= $groupName;?></a></td>
					<?php else: ?>
						<td></td>
					<?php endif; ?>
				</tr>
			<? endfor; ?>
			</tbody>
		</table>
	</div>

</div>
</body>
</html>













<!-- src/Acme/BlogBundle/Resources/views/Default/index.html.php -->
<?php //$view->extend(':base.html.php') ?>

<?php //$view['slots']->set('title', 'My cool blog posts') ?>
<!---->
<?php //$view['slots']->start('body') ?>
<?php //foreach ($blog_entries as $entry): ?>
<!--	<h2>--><?php //echo $entry->getTitle() ?><!--</h2>-->
<!--	<p>--><?php //echo $entry->getBody() ?><!--</p>-->
<?php //endforeach; ?>

<!--Hello --><?//= $name ?><!--! Done.-->
<!---->
<?php //$view['slots']->stop() ?>


