<section class="container content02">
    <div class="row">
        <div class="Head01 col-11 m-auto">            
            <h1>Add New User</h1>
        </div>
    </div>
    <div class="row">
        <!-- left column -->
        <div class="col-sm-12">
            <!-- general form elements -->
            <div class="box box-primary">
               <!-- /.box-header -->
                <!-- form start -->
                <div class="Form col-12 col-md-10 m-auto">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <h3 class="box-title">Enter User Details</h3>
                        </div>
                    </div>
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
                        <form role="form" id="addUser" action="<?php echo base_url() ?>addNewUser" class="row Form01" method="post" role="form">
                            <!-- New Section -->
                            <div class="col-12 col-sm-6 FieldOuter01">
                                <label for="fname">Full Name</label>
                                <input type="text" class="TextField01 required" id="fname" name="fname" value="<?php echo set_value('fname'); ?>" maxlength="128">
                            </div>
                            <div class="col-12 col-sm-6 FieldOuter01">
                                <label for="email">Email Address</label>
                                <input type="text" class="TextField01 required" id="email" name="email" value="<?php echo set_value('email'); ?>" maxlength="128">
                            </div>
                            <div class="col-12 col-sm-6 FieldOuter01">
                                <label for="password">Password</label>
                                <input type="password" class="TextField01 required" id="password" name="password" value="<?php echo set_value('password'); ?>" maxlength="128">
                            </div>
                            <div class="col-12 col-sm-6 FieldOuter01">
                                <label for="cpassword">Confirm Password</label>
                                <input type="password" class="TextField01 required" id="cpassword" name="cpassword" value="<?php echo set_value('cpasssword'); ?>" maxlength="128">
                            </div>
                            <div class="col-12 col-sm-6 FieldOuter01">
                                <label for="mobile">Contact Number</label>
                                <input type="text" class="TextField01 required" id="mobile" name="mobile" value="<?php echo set_value('mobile'); ?>" maxlength="128">
                            </div>
                            <div class="col-12 col-sm-6 FieldOuter01">
                                <label for="role">Role</label>
                                <select id = 'role' name = 'role' class = 'TextField01 required' value="<?php echo set_select('role'); ?>">
                                    <option value="0">Select Role</option>
                                        <?php
                                        if(!empty($roles))
                                        {
                                            foreach ($roles as $rl)
                                            {
                                                ?>
                                                <option value="<?php echo $rl->roleId ?>" <?php echo set_select('role', $rl->roleId); ?>><?php echo $rl->role ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6 FieldOuter01">
                                <label for="company">Company</label>
                                <input type="text" class="TextField01" id="company" name="company" value="" maxlength="128">
                            </div>
                            <div class="col-12 text-center ButtonOuter01">          
                                <input type="submit" class="SiteButton01" value="Submit" />
                                <input type="reset" class="btn btn-default" value="Reset" />
                            </div>
                        <!-- New Section -->
                    </form>
                </div>
            </div>
        </div>
    </div> 
</section>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('.client-field').show();
        $('.builder-field').hide();
        $('select[name="role"]').change(function() {
            console.log($(this).val());
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


