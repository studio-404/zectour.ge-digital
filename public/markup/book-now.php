<?php 
date_default_timezone_set('Asia/Tbilisi');
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Zec Tour</title>
    <link href="public/css/bootstrap.min.css" rel="stylesheet" />
    <link href="public/css/full-slider.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="public/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="public/css/bootstrap.datepicker.css" />
    <link href="public/css/style.css" rel="stylesheet" type="text/css" />

  </head>

  <body>

   <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000000">
      
      <div class="container">
        
        <a class="navbar-brand" href="index.html" style="width:120px;">
          <object id="svg1" data="public/img/zec.svg" type="image/svg+xml" style="width:100%"></object>
        </a>


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.html">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                Services <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                <li><a href="service.html" class="active">Ship</a></li>
                <li><a href="service.html">Buss</a></li>
                <li><a href="service.html">Car</a></li>
                <li><a href="service.html">Entertain / Cure</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contact</a>
            </li>
          </ul>
        </div>

      </div>
    </nav>




    <header class="service-header">
      <h3><span>Booking</span></h3>
    </header>

    <main>
     <section class="container">
        <section class="row">
          <section class="col-md-6">
            <img src="public/filemanager/slider/image1.jpg" width="100%" />
          </section>

          <section class="col-md-6 desc">
            <p class="data">Super Tour</p>
            
            <section class="long-description">
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit...</p>

              <p class="data">Price: <i class="fa fa-user" aria-hidden="true"></i>  350 <span>$</span></p>
              <p class="data">Total Price: <i class="fa fa-money" aria-hidden="true"></i>  <b>350</b> <span>$</span></p>
              
              <section style="clear:both"></section>
              <form action="" method="post">

              <label>Date:</label>
              <section class="dateBox">
                <input type="text" class="form-control date" name="date" autocomplete="off" value="<?=date("m/d/Y")?>" readonly="readonly"> 
              </section>

              <label>Time:</label>
              <select class="form-control time">
                <?php 
                for($i=8; $i<=20; $i++):
                  $num = sprintf('%02d', $i);
                ?>
                  <option value="<?=$num?>:00"><?=$num?>:00</option>
                  <?php if($num<20): ?>
                  <option value="<?=$num?>:30"><?=$num?>:30</option>
                  <?php endif;?>
                <?php
                endfor;
                ?>
              </select>

              
              <label>Adult:</label>
              <input type="number" class="form-control" name="adult" autocomplete="off" value="1" min="1" />
              
              <label>Child:</label>
              <input type="number" class="form-control" name="child" autocomplete="off" value="0" min="0" />

              <label>Name:</label>
              <input type="text" class="form-control" name="name" autocomplete="off" value="" />

              <label>Phone/Mobile:</label>
              <input type="text" class="form-control" name="phone" autocomplete="off" value="" />

              <label>Address: ( Where We can pick you up )</label>
              <textarea class="form-control" name="address"></textarea>

              <label>Any Questions...</label>
              <textarea class="form-control" name="questions"></textarea>

              <p>
                <a href="javascript:alert('Under Construction !'); return false;" class="btn btn-primary" role="button">Book Now</a> 
              </p>
            </form>
            </section>
            

          </section>
        </section>
      </section>
    </main>


    <footer class="py-5 footer">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Zec Tour 2017</p>
      </div>
    </footer>

    
    <!-- Bootstrap core JavaScript -->
    <script src="public/js/jquery.min.js"></script>
    <script src="public/js/popper.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/bootstrap.datepicker.js"></script>
    <script src="public/js/script.js"></script>
    <script type="text/javascript">
    $(".date").datepicker();
    </script>
    
  </body>

</html>
