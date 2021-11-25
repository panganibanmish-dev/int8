<?php $base_url =  base_url();  ?>
<link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/d-din" type="text/css"/>
<div class="LoginFormOuter m-auto">
            <div class="col-12 p-0 Logo02 text-center">
                <img src="<?= $base_url ?>assets/img/Integra_LandHub_Logo.png" alt="">
            </div>
            <div class="col-12 p-0">
                <h1 class="Heading01">Member Login</h1>
            </div>
            <?php $this->load->helper('form'); ?>
            <div class="row">
                <div class="col-md-12">
                    <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                </div>
            </div>
            <?php
                $this->load->helper('form');
                $error = $this->session->flashdata('error');
            if($error)
            {?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $error; ?>                    
                </div>
            <?php }
                $success = $this->session->flashdata('success');
            if($success){
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $success; ?>                    
                </div>
            <?php } ?>
            <form action="<?= $base_url ?>loginMe" class="col-12 p-0 Form03" method="post">            
                <div class="col-12 FieldOuter01">
                    <label for="Email">Email address</label>
                    <input name="email" type="email" class="TextField01" placeholder="Enter Email address" required />
                </div>        
                <div class="col-12 FieldOuter01">
                    <label for="Password">Password</label>
                    <input type="password" class="TextField01" placeholder="Enter Password" name="password" required />
                </div>
                <div class="col-12 text-center M01 p-0">                        
                    <input type="submit" value="Log in" class="SiteButton01">
                </div>
                <div class="col-12 text-center LoginText01">
                    <!--  <span><a href="<?php //print site_url();?>forgotPassword">Forgot Password</a></span> -->
                    <span><a href="<?php echo base_url('resetPasswordUser') ?>">Forgot Password</a></span>
                   <!--  <span><a href="<?php //echo base_url('resetPasswordUser') ?>">Forgot Password</a></span> -->
                   <!--  <span>Not a member?  <a href="<?php //echo base_url('signup') ?>">Sign up</a></span> -->
                </div>
            </form>
</div>
