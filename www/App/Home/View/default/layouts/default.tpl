<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />      
<meta name="keywords" content="?>" />
<meta name="description" content=" <?php __('meta_description')?>" />
<meta name="generator" content="Yunframework 1.0" />
<meta name="author" content="" />
<meta name="copyright" content="2016-2017 Yunframework.com" />
    <?php Html::css('css/style.css') ?>
    <?php Html::css('css/yun.css') ?>
    <?php Html::script('js/jquery-1.11.1.min.js') ?>

<title><?php echo $page_title ?><?php ___('page title suffix') ?></title>
</head>
<body class="yf-page home">
	<div class="yf-wrap">
	<?php $this->element('header') ?>

	<?php $this->tpl() ?>

	<?php $this->element('footer') ?>
	</div>

</body>

</html> 