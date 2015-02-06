<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="keywords" content="Designers, fashion enthusiasts, fashionists">
	<meta name="description" content="Apparel gives creative designers the spotlight to promote their brand.">
	<meta property="og:description" content="Apparel gives creative designers the spotlight to promote their brand.">
	<meta property="og:title" content="Apparel">
	<meta property="og:url" content="apparel.www.myfirebook.com/">
	<meta property="og:image" content="<?php echo base_url('assets/images/logo.png'); ?>" alt="Apparel logo">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="Apparel">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	
	<?php if($CSS == "SIGNUP") { ?>
	<title>Apparel | SignUp</title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/apparel.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/signup.css">
	
	<?php }?>
	<?php if($CSS == "LOGIN") { ?>
	<title>Apparel | Login</title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/apparel.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/signin.css">
	
	<?php }?>
</head>