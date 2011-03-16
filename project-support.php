<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0
Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <?php include('include/menu.php'); ?>
    <head>
    <title><?php getpagetitle(); ?></title>
    <META NAME="Author" CONTENT="Arend Zwaneveld Copyright 2009 ">
    <?php include('htmlheader.inc'); ?>
</head>
<body>
<div class="full_page">
<div id="bg"><img id="background" src="images/shadow_gray.png" >
<div class="cornerBox">

<!-- <img style="float:right; display: inline; z-index: 2; border: 0px solid blue;" src="images/circle-aenm_transp.png" /> -->

<?php echo $html['topdiv']; ?>
<?php echo $html['head']; ?>

<div class="menu_blok"> 
  <?php	 buildmenu($_SERVER['PHP_SELF']); ?>
</div>


<div id="inhoud">
   <?php $contents = getpagecontent(); ?>
</div> <!-- inhoud -->


<?php echo $html['bottomdiv']; ?>


</div> <!-- full_page -->
</div> <!-- cornerbox -->
</div> <!-- bg -->
</body>
</html>

<!-- http://www.auburn.edu/oit/help_support/webpages/ts_change_default_page.php -->