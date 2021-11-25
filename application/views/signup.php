<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Admin System Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/adminstyle.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="register-page">
    <div class="register-box">
      <div class="login-logo">
        <a href="#">
          <img src="<?php echo base_url(); ?>assets/images/landhub.png" class="logolandhub">
        </a>
        <a href="#">
          <img src="<?php echo base_url(); ?>assets/images/integra.png" class="logointegra">
        </a>
      </div><!-- /.login-logo -->
      <div class="register-box-body">
        <p class="login-box-msg">register for land hub</p>
        <?php $this->load->helper('form'); ?>
        <div class="col-xs-12">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
        </div>
        
        <form role="form" id="" action="<?php echo base_url() ?>signup" method="post" role="form">
            <div class="box-body">
            	<div class="row">
            		<?php if (isset($_GET['deal'])) { ?>
            		<div class="col-xs-4">
            			<div class="form-group">
            				<label><input type="radio" name="userrole" value="purchaser" checked>&nbsp;Purchaser</label>
            			</div>
            		</div>
            		<?php } else { ?>
            		<div class="col-xs-4">
            			<div class="form-group">
            				<label><input type="radio" name="userrole" value="newhomebuilder" checked <?php echo (isset($_GET['deal'])) ? 'disabled' : '' ?>>&nbsp;New Home Builder</label>
            			</div>
            		</div>
            		<div class="col-xs-4">
            			<div class="form-group">
            				<label><input type="radio" name="userrole" value="contractor" <?php echo (isset($_GET['deal'])) ? 'disabled' : '' ?>>&nbsp;Contractor</label>
            			</div>
            		</div>
            		<?php } ?>
            	</div>
                <div class="row">
                    <div class="col-md-12">                                
                        <div class="form-group">
                            <input type="text" class="form-control required" id="fname" name="fname" maxlength="128" placeholder="Name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control required email" id="email"  name="email" maxlength="128" placeholder="Email Address">
                        </div>
                    </div>
                </div>
                <div class="row builder-field">
                    <div class="col-md-12">                                
                        <div class="form-group">
                            <input type="text" class="form-control" id="phone" name="phone" maxlength="128" placeholder="Phone">
                        </div>
                    </div>
                </div>
                <div class="row builder-field">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control" id="company"  name="company" maxlength="128" placeholder="Company">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
							<input type="password" class="form-control required" id="password"  name="password" maxlength="10" placeholder="Password">
                        </div>
                    </div>
                </div>
                <?php if (isset($_GET['deal'])) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control client-field" id="estate"  name="estate" maxlength="128" placeholder="Estate" readonly>
                        </div>
                    </div> 
                </div>
                <?php } else { ?>
                <div class="row ">
                    <div class="col-md-12">
                        <div class="form-group">
                            <select class="form-control">
                            	<option>Estate</option>
                            	<option value="1">test state1</option>
                            	<option value="2">test state2</option>
                            	<option value="3">test state3</option>
                            	<option value="4">test state4</option>
                            </select>
                        </div>
                    </div>  
                </div>
                <?php } ?>
                <div class="row client-field">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control required" name="lotnumber" placeholder="Lot Number" readonly>
                        </div>
                    </div>  
                </div>
            </div><!-- /.box-body -->
			<div class="row">
				<div class="col-xs-4 col-xs-offset-4 text-center">
				<button class="btn btn-primary btn-arrow-right signupbtn">submit &nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i></button>
				</div><!-- /.col -->
			</div>
        </form>
        
        <div class="row forgotpasword_singup_main">
          <div class="col-xs-6">
          </div>
          <div class="col-xs-6 text-right">
            <span><a href="<?php echo base_url() ?>">Login</a></span>
          </div>
        </div>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    
    <script>
		$(document).ready(function() {
			<?php if (isset($_GET['deal'])) { ?>
			$('.client-field').show();
			$('.builder-field').hide();
			<?php } else { ?>
			$('.client-field').hide();
			$('.builder-field').show();
			<?php } ?>
			$('input[name="userrole"]').change(function() {
				
				var chosenRole = $(this).val();
				switch (chosenRole) {
					case 'contractor':
					case 'newhomebuilder':
						$('.client-field').hide();
						$('.builder-field').show();
						break;

					default:
    					$('.client-field').show();
    					$('.builder-field').hide();
    					break;
				}
			});
		});

    </script>
    
    
  </body>
</html>


<section class="LoginOuter row">
        <div class="LoginFormOuter RegisterFormOuter m-auto">
            <div class="col-12 p-0 Logo02 text-center">
                <img src="img/logo02.svg" alt="">
            </div>
            <div class="col-12 p-0">
                <h1 class="Heading01">REGISTER FOR LAND HUB</h1>
            </div>
            <form action="" class="col-12 row p-0 Form03">   
                <div class="col-12 FieldOuter01 MB10 text-center">                                        
                    <label class="RadioOuter">                        
                        <input type="radio" name="type" class="Radio01">
                        <span class="RadioPlace01"></span>
                        Purchaser
                    </label>                    
                    <label class="RadioOuter">           
                        <input type="radio" name="type" checked class="Radio01">
                        <span class="RadioPlace01"></span>
                        Contractor
                    </label>                    
                    <label class="RadioOuter">    
                        <input type="radio" name="type" class="Radio01">
                        <span class="RadioPlace01"></span>
                        New Home Builder
                    </label>
                </div>             
                <div class="col-12 col-sm-6 FieldOuter01">
                    <input type="text" class="TextField01 BorderColor02" placeholder="Enter Name">
                </div>        
                <div class="col-12 col-sm-6 FieldOuter01">
                    <input type="email" class="TextField01 BorderColor02" placeholder="Enter Email">
                </div>     
                <div class="col-12 col-sm-6 FieldOuter01">
                    <input type="text" class="TextField01 BorderColor02" placeholder="Estate">
                </div>        
                <div class="col-12 col-sm-6 FieldOuter01">
                    <input type="text" class="TextField01 BorderColor02" placeholder="Lot Number">
                </div>
                <div class="col-12 text-center M02">                        
                    <input type="submit" value="Submit" class="SiteButton01">
                </div>
            </form>
        </div>
    </section>