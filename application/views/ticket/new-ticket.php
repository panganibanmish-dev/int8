
<section class="container content02">

    <div class="row">
        <div class="Head01 col-11 m-auto">            
            <h1>Add New Ticket</h1>
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
                            <h3 class="box-title">Enter Ticket Details</h3>
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
                
                        <form role="form" id="addTicket" action="<?php echo base_url() ?>TicketManagement/CreateTicketInDesk" class="row Form01" method="post" role="form">

                            
                           <!-- <div class="col-12 col-sm-6 FieldOuter01">
                                <label for="duedate">Due Date</label>
                                <input type="date" class="TextField01 required" id="duedate" name="duedate" value="<?php //echo set_value('duedate'); ?>">
                            </div>-->

                          

                            <div class="col-12 col-sm-6 FieldOuter01">
                                <label for="subject">Subject</label>
                                <input type="text" class="TextField01 required" id="subject" name="subject" value="<?php echo set_value('subject'); ?>" maxlength="128">
                            </div>

                           

                            

                            <div class="col-12 col-sm-6 FieldOuter01">
                                <label for="classifications">Ticket Type</label>
                                <select id = 'classifications' name = 'classifications' class = 'TextField01 required' value="<?php echo set_select('classifications'); ?>">
                                    <option value="Question">Question</option>
                                    <option value="Problem">Problem</option>
                                    <option value="Feature">Feature</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <!--<div class="col-12 col-sm-6 FieldOuter01">
                                <label for="priority">Priority</label>
                                <select id = 'priority' name = 'priority' class = 'TextField01 required' value="<?php echo set_select('priority'); ?>">
                                    <option value="">Select Priority</option>
                                    <option value="Meduim">Meduim</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>-->
                            
                            
                             <div class="col-12 col-sm-12 FieldOuter01">
                                <label for="description">Enter your Question or Problem</label>
                                <textarea type="text" class="TextField01 required" id="description" name="description" style="height:100%;"><?php echo set_value('description'); ?></textarea>
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

<script>$('#duedate').datepicker({ dateFormat: 'yy-mm-dd' }).val();</script>


