<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="توضيحي درباره سايت">
    <meta name="author" content="نويسنده سايت يا مدير">
    <title><?=$title;?></title>
  <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/bootstrap-rtl.min.css');?>" rel="stylesheet">
  <?php
  if(isset($style) && $style != '') {
    echo $style;
  }
  ?>
  <link href="<?php echo base_url('assets/css/custom.css');?>" rel="stylesheet">

</head>
<body>
<?php 
if($nav != "false") { ?>
  <nav class="navbar-default navbarCustom">
    <div class="container">
      <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      
      <div class="collapse navbar-collapse">
       <ul class="nav navbar-nav">
              <li><a href="#">داشبورد</a></li>
             <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">مدیریت محتوا <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?=base_url('tg-admin/addPost/');?>">افزودن</a></li>
                  <li><a href="<?=base_url('tg-admin/managePosts/');?>">مدیریت نوشته ها</a></li>
                  <li><a href="<?=base_url('tg-admin/addCat');?>">مدیریت دسته بندی</a></li>
                  
                </ul>
              </li>
             
              <li class="dropdown"><a href="#about" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">تنظیمات <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#about">مدیریت کاربران</a></li>
          <li><a href="#about">مدیریت مدیران</a></li>
          <li><a href="#about">تنظیمات سایت</a></li>
        </ul>
        </li>
            <li><a href="<?=base_url();?>" style="color:blue;" target="_blank">مشاهده سایت</a></li>
            <li><a href="<?=base_url('logout');?>" style="color:red;">خروج</a></li>
            
              
            </ul>

      </div>
    </div>
  </nav>
<?php } ?>