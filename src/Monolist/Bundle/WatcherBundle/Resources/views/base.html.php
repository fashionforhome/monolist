<!-- app/Resources/views/base.html.php -->
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php $view['slots']->output('title', 'Test Application') ?></title>
</head>
<body>
<div id="sidebar">
	<?php if ($view['slots']->has('sidebar')): ?>
		<?php $view['slots']->output('sidebar') ?>
	<?php else: ?>
		<ul>
			<li><a href="/">Home</a></li>
			<li><a href="/blog">Blog</a></li>
		</ul>
	<?php endif; ?>
</div>

<div id="content">
	<?php $view['slots']->output('body') ?>
</div>
</body>
</html>


