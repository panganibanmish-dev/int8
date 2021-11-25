<?php $base_url =  base_url();  ?>
<div class="LoginFormOuter RegisterFormOuter m-auto">
            <div class="col-12 p-0 Logo02 text-center">
                <img src="<?= $base_url ?>assets/img/logo02.svg" alt="">
            </div>
            <div class="col-12 p-0">
                <h1 class="Heading01">REGISTER FOR LAND HUB</h1>
            </div>

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
            <form action="<?php echo base_url() ?>registerSelfAction?deal=<?php echo $_GET['deal']; ?>&email=<?php echo $_GET['email']?>" method="post" role="form" class="col-12 row p-0 Form03">   
                <div class="col-12 FieldOuter01 MB10 text-center">                              
                    <label class="RadioOuter">                        
                        <input type="radio" name="role" value="4" checked class="Radio01">
                        <span class="RadioPlace01"></span>
                        Purchaser
                    </label>                    
                    <label class="RadioOuter">           
                        <input type="radio" name="role" value="5" class="Radio01">
                        <span class="RadioPlace01"></span>
                        Contractor
                    </label>                    
                    <label class="RadioOuter">    
                        <input type="radio" name="role" value="6" class="Radio01">
                        <span class="RadioPlace01"></span>
                        New Home Builder
                    </label>
                </div> 
                <div class="col-12 col-sm-6 FieldOuter01">
                    <input type="text" class="TextField01 BorderColor02 required" id="fname" name="fname" maxlength="128" placeholder="Name" value = "<?php echo $user->Full_Name; ?>" readonly>
                </div>        
                <div class="col-12 col-sm-6 FieldOuter01">
                    <input type="text" class="TextField01 BorderColor02 required email" id="email"  name="email" maxlength="128" placeholder="Email Address" value = "<?php echo $user->Email; ?>"readonly>
                </div>     
                <div class="col-12 col-sm-6 FieldOuter01">
                    <input type="password" class="TextField01 BorderColor02 required" id="password"  name="password" placeholder="Password">
                </div>        
                <div class="col-12 col-sm-6 FieldOuter01">
                    <input type="password" class="TextField01 BorderColor02 required" id="confirm_password"  name="confirm_password" placeholder="Confirm Password">
                </div>
                <div class="col-12 col-sm-6 FieldOuter01">
                    <input type="text" class="TextField01 BorderColor02" id="contact_number"  name="contact_number" value = "<?php echo $user->Phone; ?>" placeholder="Contact Number">
                </div>
                <div class="col-12 col-sm-6 FieldOuter01">
                    <input type="text" class="TextField01 BorderColor02" id="company"  name="company" placeholder="Company">
                </div>
                <div class="col-12 text-center M02">                        
                    <button class="SiteButton01">Submit &nbsp;&nbsp;</button>
                </div>
            </form>
        </div>
        <script>
    		$(document).ready(function() {
    			$('.client-field').show();
    			$('.builder-field').hide();
    			$('input[name="role"]').change(function() {
    				var chosenRole = $(this).val();
    				switch (chosenRole) {
    					case '5':
    					case '6':
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
</div>