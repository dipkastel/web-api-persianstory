<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>404 - یافت نشد</title>

<link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/bootstrap-rtl.min.css');?>" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/404.css');?>">
</head>
<body class="error404">

  <div class="container">
    <main class="main">
      <header>
        <h2>صفحه مورد نظر یافت نشد!</h2>
        <h6>404</h6>
      </header>
      <div class="search_box">
        <form action="<?=base_url('search');?>/" method="GET">
          <input name="s" type="text" placeholder="جستجو">
          <button><i class="icon-search"></i></button>
        </form>
      </div><!-- search_box -->
      <div class="rock">
        <img src="<?php echo base_url('assets/images/404_rock.png');?>" alt="">
        <img src="<?php echo base_url('assets/images/404_alien.png');?>" class="alien_right" alt="">
        <img src="<?php echo base_url('assets/assets/images/404_alien.png');?>" class="alien_left" alt="">
      </div>
      <div class="return"><a href="" class="hwp_btn">بازگشت</a></div>
    </main>
  </div><!-- container -->
  
</body>
</html>