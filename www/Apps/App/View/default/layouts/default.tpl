<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />      
<meta name="keywords" content="Yunframework" />
<meta name="description" content="Yunframework" />
<meta name="generator" content="Yunframework 1.0" />
<meta name="author" content="Yunframework Team" />
<meta name="copyright" content="2013-2016 Yunframework Inc." />
<!--<link rel="stylesheet" type="text/css" href="<?php echo $webroot ?>css/yun.css" />-->
<?php Html::css('css/yun.css')?>
<?php Html::script('js/jquery-1.7.1.min.js')?>
<title><?php echo $page_title ?></title>
</head>
<body class="yun-page app">
<div class="yun-wrap">
<?php $this->element('header') ?>

<?php $this->tpl() ?>

<?php $this->element('footer') ?>
</div>

</body>

</html> 