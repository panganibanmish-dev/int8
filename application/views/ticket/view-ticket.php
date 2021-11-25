<style>
    
    .chat
{
    list-style: none;
    margin: 0;
    padding: 0;
}

.chat li
{
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
}

.chat li.left .chat-body
{
    margin-left: 60px;
}

.chat li.right .chat-body
{
    margin-right: 60px;
}


.chat li .chat-body p
{
    margin: 0;
    color: #777777;
}

.panel .slidedown .glyphicon, .chat .glyphicon
{
    margin-right: 5px;
}

.panel-body
{
    overflow-y: scroll;
    height: 250px;
}

::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

::-webkit-scrollbar
{
    width: 12px;
    background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}
.SiteButton02{
    background: url(../img/icon10_2.svg), linear-gradient(135deg, #3FABFF 0%, #006BFF 100%);
    background-repeat: no-repeat;
    color: #fff;
    font-size: 16px;
    line-height: 0px;
    font-weight: 600;
    border-radius: 6px;
    -webkit-border-radius: 6px;
    -moz-border-radius: 6px;
    border: none;
    padding: 20px 29px 19px 29px;
    font-family: 'Mont Regular';
}
.SiteButton02:hover {
    background: url(../img/icon10_2.svg), #000D22;
    background-position: 70% center;
    background-repeat: no-repeat;
    color: #fff;
}
.SiteBack02{
background: url(../img/icon10_2.svg), linear-gradient(135deg, #3FABFF 0%, #006BFF 100%);
    background-repeat: no-repeat;
    color: #fff;
    font-size: 16px;
    line-height: 0px;
    font-weight: 600;
    border-radius: 6px;
    -webkit-border-radius: 6px;
    -moz-border-radius: 6px;
    border: none;
    padding: 9px 13px 8px 13px;
    font-family: 'Mont Regular';
}
.SiteBack02:hover {
    background: url(../img/icon10_2.svg), #000D22;
    background-position: 70% center;
    background-repeat: no-repeat;
    color: #fff;
}
</style>
<section class="container content02">

    <div class="row">
        <div class="Head01 col-11 m-auto">            
            <h1>Ticket</h1>
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
                            <h3 class="box-title">Ticket Details</h3>
                        </div>
                    </div>

                        <div class="row Form01">

                           <!--  <div class="col-12 col-sm-6 FieldOuter01">
                                <label for="duedate">Due Date</label>
                                <input type="text" class="TextField01" id="duedate" name="duedate" value="<?php //echo $ticketdata['dueDate']; ?>" readonly>
                            </div> -->

                           <!-- <div class="col-12 col-sm-6 FieldOuter01">
                                <label for="duedate">Due Date</label>
                                <input type="text" class="TextField01" id="duedate" name="duedate" value="<?php echo date('Y-m-d', strtotime($ticketdata['dueDate'])); ?>" readonly>
                            </div>-->
                            <div class="col-12 col-sm-6 FieldOuter01">
                                <label for="subject">Subject</label>
                                <input type="text" class="TextField01" id="subject" name="subject" value="<?php echo $ticketdata['subject']; ?>" maxlength="128" readonly>
                            </div>

                           <div class="col-12 col-sm-6 FieldOuter01">
                                <label for="subject">Ticket Type</label>
                                <input type="text" class="TextField01" id="classifications" name="classifications" value="<?php echo $ticketdata['classification']; ?>" readonly>
                            </div>

                             <!--<div class="col-12 col-sm-6 FieldOuter01">
                                <label for="subject">Priority</label>
                                <input type="text" class="TextField01" id="priority" name="priority" value="<?php //echo $ticketdata['priority']; ?>" readonly>
                            </div>-->

                            <!--<div class="col-12 col-sm-6 FieldOuter01">
                                <label for="subject">Channel</label>
                                <input type="text" class="TextField01" id="channel" name="channel" value="<?php echo $ticketdata['channel']; ?>" readonly>
                            </div>-->

                            <!--<div class="col-12 col-sm-12 FieldOuter01">
                                <label for="description">Enter your Question or Problem</label>
                                <textarea type="text" class="TextField01" id="description" name="description" style="height:100%;"  readonly><?php echo $ticketdata['description']; ?></textarea>
                            </div>-->
                            
                            <form  id="addcomment" action="<?php echo base_url() ?>TicketManagement/AddCommentInTicket"  method="post" style="width: -webkit-fill-available;">
                                            
                            <input type="text" style="display: none;" class="TextField01" name="ticket_Id" value="<?php echo $ticketdata['id']; ?>">
                            <div class="col-md-12 col-sm-12 FieldOuter01">
                                <label for="description">Enter your Message</label>
                                <textarea type="text" class="TextField01" id="description" name="description" style="height:100%;" rows="5"  required></textarea>
                            </div>
                            <div class="col-md-12 text-center ButtonOuter01 ">   
                                <input type="submit" class="SiteButton02" value="Submit" />
                                <a class="SiteBack02" href="<?php echo base_url(); ?>TicketManagement"><i class="fa fa-arrow-left"></i> Go Back</a>
                            </div>
                            </form>
                            
                    </div>
                    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<!------ Include the above in your HEAD tag ---------->
                    <br>

                    
                    <div class="container"> </div>
                    
                    <div class="container">
                        <div class="row">
                            <p style="color: #000;font-size: 18px;font-weight: 600;font-family: 'Mont SemiBold';">Your Conversation</p>
                            <div class="col-md-12">
                               <div class="" style="margin: 0px 15px 1px -28px;border-color: #000D22;">
                                    
                 <div class="panel" id="collapseOne">
                                    
                                            <?php
                        $to="";
                        $summary="";
                        $content="";
                        $name="";
                        if(isset($ticketcomments[0])){
                        foreach($ticketcomments as $ticketcommentsdata){
                                
                                $CreatedTime ="";
                                if(isset($ticketcommentsdata['summary'])){
                                  $summary = $ticketcommentsdata['summary']; 
                                  $name = 'INTEGRA Support';
                                  
                                  if (False !== strpos($summary, 'From:'.$this->session->userdata('name'))) {
                                      $name = $this->session->userdata('name');
                                  }
                                  
                                  $CreatedTime = $ticketcommentsdata['createdTime'];
                                }
                                
                                if(isset($ticketcommentsdata['content'])){
                                  $content = $ticketcommentsdata['content'];
                                  $name = 'INTEGRA Support';
                                  
                                  $CreatedTime = $ticketcommentsdata['commentedTime'];
                                  
                                  if (False !== strpos($content, 'From:'.$this->session->userdata('name'))) {
                                      $name = $this->session->userdata('name');
                                  }
                                }

                                $to = $ticketcommentsdata['to'];
                                
                                
                                
                                
                                
                                $datetime1=new DateTime("now");
                                $datetime2=date_create($CreatedTime);
                                $diff=date_diff($datetime1, $datetime2);
                                $timemsg='';
                                if($diff->y > 0){
                                    $timemsg = $diff->y .' year'. ($diff->y > 1?"'s":'');
                            
                                }
                                else if($diff->m > 0){
                                 $timemsg = $diff->m . ' month'. ($diff->m > 1?"'s":'');
                                }
                                else if($diff->d > 0){
                                 $timemsg = $diff->d .' day'. ($diff->d > 1?"'s":'');
                                }
                                else if($diff->h > 0){
                                 $timemsg = $diff->h .' hour'.($diff->h > 1 ? "'s":'');
                                }
                                else if($diff->i > 0){
                                 $timemsg = $diff->i .' minute'. ($diff->i > 1?"'s":'');
                                }
                                else if($diff->s > 0){
                                 $timemsg = $diff->s .' second'. ($diff->s > 1?"'s":'');
                                }
                            
                            $timemsg = $timemsg.' ago';
                                
                            if(isset($ticketcommentsdata['summary'])){
                            ?>
                            
                                            
                                           
                                                <div class="chat-body clearfix" style="border-bottom: groove;padding: 15px;border-bottom-width: 1px;">
                                                    <div class="header">
                                                        <strong class="primary-font"><?php echo $name; ?></strong> <small class="pull-right text-muted">
                                                            <span class="glyphicon glyphicon-time"></span><?php echo $timemsg ?></small>
                                                    </div>
                                                    <p>
                                                    	<?php if (strpos($summary, '---- On')) {?>
                                                    	<?php echo str_replace('From:'.$this->session->userdata('name').'<br />', '', substr($summary, 0, strpos($summary, '---- On'))); ?>
                                                    	<?php } else { ?>
                                                    	<?php echo str_replace('From:'.$this->session->userdata('name').'<br />', '', $summary); ?>
                                                    	<?php }?>
                                                        
                                                    </p>
                                                </div>
                                           
                                            <?php 
                            }else{ ?>
                                          
                                            
                                                <div class="chat-body clearfix" style="border-bottom: groove;padding: 15px;border-bottom-width: 1px;">
                                                    <div class="header">
                                                        <strong class="primary-font"><?php echo $name; ?></strong> <small class="pull-right text-muted">
                                                            <span class="glyphicon glyphicon-time"></span><?php echo $timemsg ?></small>
                                                    </div>
                                                    <p>
                                                        <?php echo str_replace('From:'.$this->session->userdata('name').'<br />', '', $content); ?>
                                                    </p>
                                                </div>
                                            
                                            
                                            
                            <?php
                            }
                                }}
                                            ?>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                </div>
                            </div>
                        </div> 
                        </div>
                    </section>
                    
