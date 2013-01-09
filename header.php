<?

header("Content-Type:text/html; charset=utf-8");
require 'locale.php';

?>
<html>
	<head>
		<title><?echo _('HF Borrow AC System')?></title>
	</head>
	<body>
		<h1><?echo _('HF Borrow AC System')?></h1>
		<p style="text-align: center">
			<a href="/?locale=en_US">English</a>
			<a href="/?locale=zh_TW">繁體中文</a>
			<a href="/?locale=zh_CN">简体中文</a>
			<a href="admin.php"><?echo _('Admin Area')?></a>
		</p>
