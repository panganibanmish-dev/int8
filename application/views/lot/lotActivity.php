<section class="container content02">
	<div class="row">
		<div class="Head01 col-11 m-auto">            
			<h1> 
            <?php if($isBuilderContractor){ ?> 
                        Stage Status Updates
                    <?php } else { ?> 
                        Activity
                    <?php } ?>
            </h1>
		</div>
    </div>
    <div class="row ">
        <div class="col-12">
            <?php if (0 < count($deals)) { ?>
                <div class="Table01" style="height: calc(100% + 2px);">
                    <table>
                        <thead>
                            <tr>
                                <th>Estate</th>
                                <th>Lot</th>
                                <th>Stage</th>
                                <th>Street Address</th>
                                <th>Transaction Status</th>
                                <th>Construction</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($deals as $deal) { 
                            // calculate completion percentage
                            $complete_percentage = 10;
                            ?>
                            <tr>
                                <td> <?php echo $deal->lot->{"INTEGRA_PROJECTS.Name"}; ?></td>
                                <td> <?php echo $deal->lot->Lot_No; ?></td>
                                <td> <?php echo $deal->lot->Lot_Stage; ?></td>
                                <td> <?php echo $deal->lot->Street_Address; ?></td>
                                <td class="color01"><?php echo $deal->Stage; ?> </td>
                                <td class="color02">In Progress 
                                <?php if($isBuilderContractor){ ?>
                                    <?php echo (isset($deal->progress)) ? ' ('.$deal->progress->completion.'<i class="fa fa-percent percentage_font" aria-hidden="true"></i>)' : ''?>
                                <?php } ?>
                                </td>
                                <td>
                                    <a 
                                    class="ArrowButton01"
                                    href = "<?php echo base_url(); ?>stage/showStatus/<?php echo $deal->lot->id; ?>"></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="clearfix"></div>
                </div>
                <?php } else { ?>
                    <div><h4> No registered Lot </h4></div>
                <?php } ?>
        </div>
    </div>
</section>