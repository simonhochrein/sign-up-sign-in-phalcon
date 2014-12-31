<!DOCTYPE html>
<html>
	<head>
		<?php echo $this->tag->stylesheetLink('css/bootstrap.min.css'); ?>
		<?php echo $this->tag->stylesheetLink('css/mystyle.min.css'); ?>
		<title>Login for phalcon!</title>
	</head>
	<body>
		<?php echo $this->getContent(); ?>

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<?php echo $this->tag->javascriptInclude('public/js/bootstrap.min.js'); ?>
	</body>
</html>