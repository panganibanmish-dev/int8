
<section class="container content02">

    <div class="row">
        <div class="Head01 col-11 m-auto">            
            <h1>Help and Questions</h1>
        </div>
    </div>

    <div class='row'>
        <div class = 'col-md-12'>
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
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-12">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>TicketManagement/CreateTicketInDesk"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="box">

                <!--<div class="col-12">
                    <div class="box-header">
                        <h3 class="box-title">Tickets</h3>
                        
                    </div>
                </div>--><!-- /.box-header -->

                <div class="clearfix"></div>

                <div class="col-12">
                    <div class="Table01 user_table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Conversation Number</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <!--<th>Due Date</th>-->
                                    <th>Date Created</th>
                                     <th></th>
                                    <!--<th class="text-center">Actions</th>-->
                                </tr>
                            </thead>
                            <tbody>
                        <?php
                       
                        if(!empty($tickets))
                        {
                            foreach($tickets as $record)
                            {   
                               
                        ?>
                            <tr>
                                <td><?php echo $record['ticketNumber']; ?></td>
                                <td><a href="<?php echo base_url(); ?>TicketManagement/ViewTicket/<?php echo $record['id']; ?>"><?php echo $record['subject']; ?></a></td>
                                <td><?php echo $record['status']; ?></td>
                                <!--<td><?php //echo date("d M Y H:i",strtotime($record['dueDate'])); ?></td>-->
                                <td><?php echo date("d M Y H:i",strtotime($record['createdTime'])); ?></td>
                                <td></td>
                            </tr>
                        <?php
                            }
                        }
                        ?>
                        </tbody>
                        </table>
                    </div>
                </div>

                <div class="clearfix"></div>
                <!-- <div class="box-footer clearfix">
                    <?php //echo $this->pagination->create_links(); ?>
                </div> -->
            </div><!-- /.box -->
        </div>
    </div>

    <script type="text/javascript">

        jQuery(document).ready(function(){
            jQuery('ul.pagination li a').click(function (e) {
                e.preventDefault();            
                var link = jQuery(this).get(0).href;            
                var value = link.substring(link.lastIndexOf('/') + 1);
                jQuery("#searchList").attr("action", baseURL + "userListing/" + value);
                jQuery("#searchList").submit();
            });
        });
    </script>

</section>
