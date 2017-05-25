<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>CRG Admin | Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <link rel="shortcut icon" href="favicon.ico"/>
        
        <link href="<?php echo base_url(); ?>assets/layouts/layout5/css/font.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/layouts/layout5/css/new_design.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        
    </head>
    <body>
        <div class="wrapper text-center">
            <header>
                <div class="container">
                    <a class="ir" href="#" id="logo" role="banner" title="Home">LG India</a>
                    
                    <div id="utils">
                        
                        <form class="form navbar-form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav">
                            <?php if(isset($error)) { ?>
                                <div class="login-error text-danger text-left" style="margin-top:-28px;">
                                    <i class="fa fa-ban"></i>
                                    <strong> Error ! </strong>
                                    <?php echo $error; ?>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                 <label class="sr-only" for="username">Username</label>
                                 <input type="text" id="username-login" class="form-control input-sm" value="<?php if(isset($_COOKIE['member_login'])) { echo $_COOKIE['member_login']; } ?>"
                                        placeholder="Username" name="username" required>
                            </div>
                            <div class="form-group">
                                 <label class="sr-only" for="password">Password</label>
                                 <input type="password" class="form-control input-sm" name="password" value="<?php if(isset($_COOKIE['member_password'])) { echo $_COOKIE['member_password']; } ?>"
                                        placeholder="Password" required>
                            </div>
                            <button type="submit" class="button normals" style="margin-top: -7px; padding-bottom: 1px; padding-top: 1px;">
                                Sign in
                            </button>
                            <div class="text-right">
                                <label style="margin-right: 30%;" for="remember_me">
                                    <input name="remember_me" value="checked" type="checkbox" <?php if(isset($_COOKIE['member_login'])) {
                                            echo 'checked="checked"';
                                    }
                                    else {
                                            echo '';
                                    }
                                    ?>>&nbsp;&nbsp;&nbsp;Remember Me
                                </label>
                                <a href="javascript:void(0);" id="forgot-password-login">Forgot Password?</a>
                            </div>
                        </form>
                    </div>
                    
                    <div class="page-logo-text" style="text-align: center; font-size: 20px; margin-top: 34px; color: #C80541;">ADMIN PANEL - WEBSITE LEADS</div>
                </div>
            </header>
            
            <div class="container">
                <section id="hero-area" class="hero-area tab">
                    <img src="assets/images/banner.jpg" >
                </section>
            </div>
            
            <footer>
                <div class="container">
                    <div class="legal">
                        <span class="copy">Copyright &copy; 2017 Powered By Corporate Renaissance Group. All Rights Reserved.</span>
                    </div>
                </div>
            </footer>
        </div>
        
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        
        <script>
            $('#forgot-password-login').click(function() {
                var username = $('#username-login').val();
                if(username == '') {
                    alert('Please enter username.');
                    
                    return false;
                }
                
                window.location.href = '<?php echo base_url(); ?>'+'users/forgot_password?username='+username;
            });
            
            <?php if($this->session->flashdata('alert')) {?>
                alert('<?php echo $this->session->flashdata('alert');?>');
            <?php } ?>
        </script>
    </body>
</html>