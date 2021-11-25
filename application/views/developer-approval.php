<section class="container content02">
        <div class="row">
            <div class="Head01 col-12 col-md-10 m-auto">            
                <h1>DEVELOPER APPROVALS</h1>
                <p class="text-center">Please fill in the details below and click submit.  The approvals team will be in touch within 2 business days.</p>
            </div>
            <div class="Form col-12 col-md-10 m-auto">
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
                <form role="form" id="addUser" enctype="multipart/form-data" action="<?php echo base_url() ?>user/postDeveloperApproval" method="post" role="form" class="row Form01">
                    <div class="col-12 col-sm-6 FieldOuter01">
                        <label for="estate">Estate</label>
                        <?php if ((ROLE_PURCHASER != $this->session->userdata('role')) && (ROLE_BUILDER != $this->session->userdata('role')) && (ROLE_CONTRACTOR != $this->session->userdata('role'))) { ?>
                        <select id = 'estate' name = 'estate' class = 'SelectField01'>
                            <option value = ''> Choose one </option>
                            <?php foreach ($estates as $estate) { ?>
                            <option data-estate-id = '<?php echo $estate->id; ?>' value = '<?php echo $estate->Name; ?>'><?php echo $estate->Name; ?> </option>
                            <?php } ?>
                        </select>
                        <?php } else { ?>
                        <select id = 'estate' name = 'estate' class = 'SelectField01'>
                            <option value = ''> Choose one </option>
                            <?php foreach ($estates as $estate) { ?>
                            <option value = '<?php echo $estate; ?>'><?php echo $estate; ?> </option>
                            <?php } ?>
                        </select>
                        <?php } ?>
                    </div>
                    <div class="col-12 col-sm-6 FieldOuter01">
                        <label for="email">Lot Number</label>
                        <select id = 'lot_number' name = 'lot_number' class = 'TextField01'>
                            <option value = ''> Choose one </option>
                        </select>
                    </div>                    
                    <div class="col-12 col-sm-6 FieldOuter01">
                        <label for="fname">Full Name</label>
                        <div>
                        	<?php echo $user->name; ?>
                        </div>
                        <input type="hidden" id="fname" name="fname" value="<?php echo $user->name; ?>" maxlength="128">
                    </div>
                    <div class="col-12 col-sm-6 FieldOuter01">
                        <label for="email">Email address</label>
                        <div>
                        	<?php echo $user->email; ?>
                        </div>
                        <input type="hidden" id="email"  name="email" value="<?php echo $user->email; ?>" maxlength="128">
                    </div>
                    <div class="col-12 col-sm-6 FieldOuter01">
                        <label for="Attachments">Attachments</label>
                        <div class="FileField01">
                            <input type="file" id="attachment" name="attachment" class="Filed2121212">
                            <div class="FilePlace">
                                <a href="javascript:;">Click Here</a> &nbsp;
                                <span class="NamePlace">to attach files</span>
                                <a href="javascript:;" class="ArrowButton01 ml-auto">Action</a>
                            </div>
                        </div>                      
                    </div> 
                    <div class="col-12 text-center ButtonOuter01">                        
                        <input type="submit" value="Submit" class="SiteButton01">
                    </div>
                </form>
            </div>
        </div>
    </section>
<script>
	$(document).ready(function() {
        <?php if ((ROLE_PURCHASER != $this->session->userdata('role')) && (ROLE_BUILDER != $this->session->userdata('role')) && (ROLE_CONTRACTOR != $this->session->userdata('role'))) { ?>
		$(document).on('change', '#estate', function() {
			var selected = $(this).find('option:selected');
			var url = '/user/estateLotsSelection/'+selected.data('estate-id');
			$('#lot_number').load(url);
		});
		<?php } else { ?>
		$(document).on('change', '#estate', function() {
			var estate = $(this).val();
			var lotList = <?php echo json_encode($lots); ?>;
			var lots = lotList.filter(function(lot){
				return lot.Estate = estate;
			});
			var selectLots = "<option value = ''>Choose one </option>";
			lots.forEach(function(lot, index){
				selectLots += "<option value = '"+lot.Name+"'>"+lot.Name+"</option>";
			});

			$('#lot_number').empty();
			$('#lot_number').html(selectLots);			  
		});
		<?php } ?>
	});
</script>