<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Driver Management</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">

	<!-- css -->

	<link rel="stylesheet" href="<?= base_url('assets/css/reset.css') ?>"> <!-- CSS reset -->
	<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/style-shopify.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
	
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
 <style>

.timeline-box {
  margin-top: 190px;
}

ol {
  position: relative;
  display: block;
  margin: 100px;
  height: 4px;
  background: #9b2;
}
ol::before,
ol::after {
  content: "";
  position: absolute;
  top: -8px;
  display: block;
  width: 0;
  height: 0;
 /* border-radius: 10px;
  border: 10px solid #9b2;*/
  
}
ol::before {
  left: -5px;
}
ol::after {
  right: -10px;
  border: 10px solid transparent;
  border-right: 0;
  border-left: 20px solid #9b2;
  border-radius: 3px;
}

/* ---- Timeline elements ---- */

li {
  position: relative;
  top: -77px;
  display: inline-block;
  float: left;
  width: 150px;
  transform: rotate(-45deg);
  font: bold 14px arial;
}
li::before {
  content: "";
  position: absolute;
  top: 3px;
  left: -33px;
  display: block;
  width: 6px;
  height: 6px;
  border: 10px solid #9b2;
  border-radius: 10px;
  background: #eee;
}

/* ---- Details ---- */

.details {
  display: none;

  position: absolute;
  left: -85px;
  top: 60px;
  padding: 15px;
  border-radius: 3px;
  border-right: 2px solid rgba(0,0,0,.1);
  border-bottom: 2px solid rgba(0,0,0,.1);
  transform: rotate(45deg);
  font: 12px arial;
  background: #fff;
}
.details::before {
  content: "";
  position: absolute;
  left: 10px;
  top: -9px;
  display: block;
  width: 0;
  height: 0;
  border: 10px solid transparent;
  border-bottom-color: #fff;
  border-top: 0;
}

/* ---- Hover effects ---- */

ol > .active {
  color: #9b2;
  border-radius: 5px;
  border: 5px solid #9b2;
}

li:hover {
  cursor: pointer;
  color: #28e;
}
li:hover::before {
  top: 1px;
  left: -31px;
  width: 8px;
  height: 8px;
  border-width: 5px;
  border-color: #28e;
}
li:hover .details {
  display: block;
  color: #444;
}
</style>




</head>
<body>

	<header id="site-header">
		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					
					<!-- <a class="navbar-brand" href="<?= base_url() ?>">Driver Management</a> -->
						<?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) : 
				echo anchor('order/index', 'Orders Management', 'class="navbar-brand"');  endif; ?>
					
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) : ?>
							<li><a href="<?= base_url('logout') ?>">Logout</a></li>
						<?php else : ?>
							<!--li><a href="<?= base_url('register') ?>">Register</a></li-->
							<!--li><a href="<?= base_url('login') ?>">Login</a></li-->
						<?php endif; ?>
					</ul>
				</div><!-- .navbar-collapse -->
			</div><!-- .container-fluid -->
		</nav><!-- .navbar -->
	</header><!-- #site-header -->

	<main id="site-content" role="main">
		
		<?php if (isset($_SESSION)) : ?>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						
					
		<?php endif; ?>
		
