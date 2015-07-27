<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- <meta charset="utf-8" />-->
    <meta charset="TIS-620" />
    <title>Sign in &middot; Truck Transport</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <!-- Le styles -->
    <!-- <link href="../assets/css/bootstrap.css" rel="stylesheet">-->
    <?php echo css('bootstrap.css');?>
    
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
       /* background: #f5f5f5 url("imgs/streling-truck-wallpaper.jpg") no-repeat ;*/
        	background:url("imgs/MAN-truck.jpg") #f5f5f5 no-repeat left top;
            background-size: 100%;
        
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <!-- <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">-->
    <?php echo css('bootstrap-responsive.css')?>
    

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>

    <div class="container">
    <!-- <h1><?php echo validation_errors(); ?></h1>-->
   <?php echo form_open('verifylogin','class="form-signin"'); ?>

     <!--  <form class="form-signin" action="verifylogin"> -->
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" name="username" id="username" class="input-block-level" placeholder="User name">
        <input type="password" name="password" id="password" class="input-block-level" placeholder="Password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-large btn-block btn-primary" type="submit">Sign in</button>
        <h3><?php echo validation_errors(); ?></h3>
      <!-- </form>-- >
    <?php echo form_close();?>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
     <!-- Javascript -->
    <?php echo js('jquery-1.8.3.js');?>
    <?php echo js('bootstrap-transition.js');?>
    <?php echo js('bootstrap-alert.js');?>
    <?php echo js('bootstrap-modal.js');?>
    <?php echo js('bootstrap-dropdown.js');?>
    <?php echo js('bootstrap-scrollspy.js');?>
    <?php echo js('bootstrap-tab.js');?>
    <?php echo js('bootstrap-tooltip.js');?>
    <?php echo js('bootstrap-popover.js');?>
    <?php echo js('bootstrap-button.js');?>
    <?php echo js('bootstrap-collapse.js');?>
    <?php echo js('bootstrap-carousel.js');?>
    <?php echo js('bootstrap-typeahead.js');?>
    
    

  </body>
</html>
