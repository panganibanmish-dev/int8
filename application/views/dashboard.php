<style>
.pagination {
  display: inline-block;
}

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
  border: 1px solid #ddd;
}

.header-img{
    width: 100% !important;
}

.pagination a:hover:not(.active) {background-color: #ddd;}
</style>
<?php $base_url =  base_url();  ?>
    <section class="banner1 container-fluid ">
        <div>
            <img class="header-img" src="<?= $base_url ?>assets/img/LandHub_Header.jpg">
        </div>
    </section>

    <section class="container content01">
        <div class="row">
            <div class="col-12 col-md-4 Box01">
                <a class="common_link_inheritence" href="<?php echo base_url(); ?>#dealsTable">
                <div>
                    <i><img src="<?= $base_url ?>assets/img/icon07.svg" alt=""></i>
                    <p>
                        <small>Check the progress of</small>
                        My Lot
                    </p>
                </div>
                </a>
            </div>

            <div class="col-12 col-md-4 Box01">
                <a class="common_link_inheritence" href="<?= $base_url ?>user/developerApproval">
                    <div>
                        <i><img src="<?= $base_url ?>assets/img/icon08.svg" alt=""></i>
                        <p>
                            <small>Submit plans for</small>
                            Developer Approval
                        </p>
                    </div>
                </a>
            </div><div class="col-12 col-md-4 Box01">
                <a class="common_link_inheritence" href="<?= $base_url ?>editOld/<?php echo $this->session->userdata('userId'); ?>">
                <div>
                    
                    <i><img src="<?= $base_url ?>assets/img/icon09.svg" alt=""></i>
                    <p>
                        <small>Update</small>
                        My Details
                    </p>
                    
                </div>
                </a>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row content02">
            <div class="col-12">
                <h2>
                
                    <?php if($isBuildContractAdmin){ ?> 
                            Activity
                        <?php 
                    } else { ?>     
                            Activity  
                        <?php } ?>
                    </h2>

                <?php if (0 < count($deals)) { ?>
                   
                <div id = 'dealsTable' class="Table01">
                    <table>
                        <thead>
                            <tr>
                            <?php if($isBuildContractAdmin){ ?> 
                                <th>Estate</th>
                                <th>Stage</th>
                                <th>Street Address</th>
                                <th>Construction</th>
                                <th></th>
                                <?php } else { ?>
                                <th>Estate</th>
                                <th>Lot</th>
                                <th>Stage</th>
                                <th>Street Address</th>
                                <th>Developer Approval Required </th>
                                <th>Transaction Status</th>
                                <th>Construction</th>
                                <th></th>
                            <?php } ?>
                            </tr>      
                        </thead>
                        <tbody>
                      
                        <?php foreach ($deals as $deal) { 
                            
                            // calculate completion percentage
                            $complete_percentage = 10;
                            ?>
                            <tr>
                             <?php if($isBuildContractAdmin){ ?> 
                                <?php if (isset($deal->lot->{"INTEGRA_PROJECTS.Name"})) { ?>
                                <td> <?php echo $deal->lot->{"INTEGRA_PROJECTS.Name"}; ?></td>
                                <?php } else { ?>
                                <td><?php echo $deal->lot->INTEGRA_PROJECTS->name; ?></td>
                                <?php } ?>                     
                                <td> <?php echo $deal->lot->Lot_Stage; ?></td>
                                <td> <?php echo $deal->lot->Street_Address; ?></td>      
                                <td class="color02">In Progress 
                                <?php 
                                if(isset($isStandardUser)) { ?>
                                    <?php echo (isset($deal->progress)) ? '<br/> ('.$deal->progress->completion.'<i class="fa fa-percent"></i>)' : ''?>
                                <?php } ?>
                                </td>
                                <td>
                                    <a 
                                    class="ArrowButton01"
                                    href = "<?php echo base_url(); ?>stage/showStatus/<?php echo $deal->lot->id; ?>"></a>
                                </td>
                            
                            <?php } else {?>
                                <?php if (isset($deal->lot->{"INTEGRA_PROJECTS.Name"})) { ?>
                                <td> <?php echo $deal->lot->{"INTEGRA_PROJECTS.Name"}; ?></td>
                                <?php } else { ?>
                                <td><?php echo $deal->lot->INTEGRA_PROJECTS->name; ?></td>
                                <?php } ?>
                                <td> <?php echo $deal->lot->Lot_No; ?></td>
                                <td> <?php echo $deal->lot->Lot_Stage; ?></td>
                                <td> <?php echo $deal->lot->Street_Address; ?></td>
                                <td>
                                    <?php if (!empty($deal->lot->Developer_Approval_Required) && ($deal->lot->Developer_Approval_Required == 'Yes')) { ?>
                                    Yes
                                    <?php } else if(!$isBuildContractAdmin) { ?>
                                    No
                                    <?php } ?>
                                </td>   
                                <td class="color01"><?php echo $deal->Stage; ?> </td>
                                <td class="color02">In Progress 
                                <?php if(isset($isStandardUser)) { ?>
                                    <?php echo (isset($deal->progress)) ? '<br/> ('.$deal->progress->completion.'<i class="fa fa-percent"></i>)' : ''?>
                                <?php } ?>
                                </td>
                                <td>
                                    <a 
                                    class="ArrowButton01"
                                    href = "<?php echo base_url(); ?>stage/showStatus/<?php echo $deal->lot->id; ?>"></a>
                                </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="clearfix"></div>
                <div class="box-footer clearfix" style="float: right;padding-right: 15px;">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
                    <?php } else { ?>
                        <div style="text-align: center;"><h4> No Registered Lot </h4></div>
                    <?php } ?>
                </div>
            </div>
        </div>
