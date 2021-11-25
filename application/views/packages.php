<?php $timestamp = time(); ?>
<section class="container content02">
        <div class="row">
            <div class="Head01 col-11 m-auto">            
                <h1>HOUSE + LAND PACKAGES</h1>
            </div>
        </div>
        <div class="col-sm-12 text-center">
        <?php                       
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
        <p class="text-center">Please fill in the details below and click submit, you can upload five at a time. <br>
                    our packages will be live within 2 business days.</p>
        <div class="clearfix"></div>
        <div class="col-sm-12 upload_pdfs_button">
            <a href="javascript:void(0);" class="SiteButton01 add_new_package">Upload</a>
        </div>
        <div class="clearfix"></div>
        <div class="col-12">
            <div class="Table01">
                <table>
                    <thead>
                        <tr>
                            <th>Estate</th>
                            <th>Lot</th>
                            <th>House Name</th>
                            <th>Bed</th>
                            <th>Car</th>
                            <th>Bath</th>
                            <th>Price</th>
                            <th>PDF</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="selected_uploads">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="Form col-11 m-auto final_submit_button" style="display: none;">
            <div class="row Form01">                    
                <div class="col-12 text-center ButtonOuter01">
                    <a class="SiteButton01" href="<?php echo base_url().'package/sendAdminMail/'.$timestamp; ?>">Submit</a>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function(){
            $('.add_new_package').click(function(){
                $('#add_new_package_form').modal('show');
            });
        });
    </script>
<div class="modal doc_custom_modal" id="add_new_package_form" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload Package</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-sm-12">
            <form role="form" 
                id="upload_new_package_from" 
                enctype="multipart/form-data" 
                action="<?php echo base_url() ?>package/addNewPackage/<?php echo $timestamp; ?>" 
                method="post" 
                role="form" 
                class="row Form01">
                <div class="Form col-12 col-md-12 m-auto nopaddingboth">
                    <div class="row Form01 MB01">
                        <div id="package_pop_errors_area" class="col-12 col-sm-12 FieldOuter01">
                        </div>
                        <div class="col-12 col-sm-6 FieldOuter01">
                            <label for="Name">Name</label>
                            <input  name = 'name'  type="text" class="TextField01" placeholder="Your Name" readonly value="<?php echo $user->name; ?>" maxlength="128">
                        </div>
                        <div class="col-12 col-sm-6 FieldOuter01">
                            <label for="Email">Email Address</label>
                            <input name = 'email' type="email" class="TextField01" placeholder="Your email address" readonly value="<?php echo $user->email; ?>" maxlength="128">
                        </div>
                        <div class="col-12 col-sm-6 FieldOuter01">
                            <label for="builder">Builder</label>
                            <select id = 'builder' name = 'builder' required class = 'TextField01'>
                            <option value = ''> Choose one </option>
                            <?php foreach ($builders as $builder) { ?>
                                <option value = '<?php echo $builder; ?>'><?php echo $builder; ?> </option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 FieldOuter01">
                                <label for="Name">Estate</label>
                                <?php if ($this->session->userdata('role') != ROLE_PURCHASER) { ?>
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
                            <label for="lot_number">Lot Number</label>
                            <select id = 'lot_number' name = 'lot_number' class = 'TextField01'>
                                <option value = ''> Choose one </option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 FieldOuter01">
                            <label for="house_name">House Name</label>
                            <input id="house_name" name="house_name" type="text" class="TextField01" required placeholder="House Name">
                        </div>
                        <div class="col-12 col-sm-6 FieldOuter01">
                            <label for="bed">Bed</label>
                            <!--<input id="bed_id" name="bed" type="text" class="TextField01" placeholder="Bed">-->
                            <input id="bed_id" name="bed" type="number" class="TextField01" placeholder="No. of Bedrooms" min="0">
                        </div>
                        <div class="col-12 col-sm-6 FieldOuter01">
                            <label for="car">Car</label>
                            <!--<input id="car_id" name="car" type="text" class="TextField01" placeholder="Car">-->
                            <input id="car_id" name="car" type="number" class="TextField01" placeholder="No. of Vehicles" min="0">
                        </div>
                        <div class="col-12 col-sm-6 FieldOuter01">
                            <label for="bath">Bath</label>
                            <!--<input id="bath_id" name="bath" type="text" class="TextField01" placeholder="Bath">-->
                            <input id="bath_id" name="bath" type="number" class="TextField01" placeholder="No. of Bathrooms" min="0">
                        </div>
                        <div class="col-12 col-sm-6 FieldOuter01">
                            <label for="price">Price</label>
                            <input id="price_id" name="price" step=".01" type="number" required class="TextField01" placeholder="Price" min="0">
                        </div>
                        <div class="col-12 col-sm-12 FieldOuter01">
                            <label for="attachments">Select Pdf File</label>
                            <div class="FileField01">
                                <input accept=".pdf,.PDF" type="file" id="attachment" name="attachment" class="Filed2121212" required>
                                <div class="FilePlace">
                                    <a href="javascript:;">Click Here</a> &nbsp;
                                    <span class="NamePlace"></span>
                                    <a href="javascript:;" class="ArrowButton01 ml-auto">Action</a>
                                </div>
                            </div>              
                        </div>
                        <div id="" class="col-12 col-sm-12 FieldOuter01 text-center" >
                            <!--<input type="submit" value="Upload" class="SiteButton01">-->
                            <input type="button" value="Upload" class="SiteButton01" id="form_submit">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$("#form_submit").click(function(){
    var attach = $("#attachment").val();
    if(attach == ''){
        $(".NamePlace").text("");
        $("#upload_new_package_from").submit();
    }else{
        $("#upload_new_package_from").submit();
    }
});
    $(document).ready(function(){
        $('#upload_new_package_from').on('submit',function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $('#package_pop_errors_area').html('');
            $.ajax({
                url: $('#upload_new_package_from').attr('action'),
                type: 'POST',
                data: formData,
                dataType:'json',
                success: function (data) {
                    if( data.status == 'success' ){
                        var row = data.row;
                        // process and add to table
                        $('#add_new_package_form').modal('hide');
                        var html = '<tr class="package_rows" id="row_'+row.uid+'">'+
                        '<td>'+row.estate+'</td>'+
                        '<td>'+row.lot_number+'</td>'+
                        '<td>'+row.house_name+'</td>'+
                        '<td>'+row.bed+'</td>'+
                        '<td>'+row.car+'</td>'+
                        '<td>'+row.bath+'</td>'+
                        '<td>$'+row.price+'</td>'+
                        '<td> <a target="_blank" href="'+row.pdf_path+'" class="ArrowButton01">Action</a></td>'+
                        '</tr>';
                        $('#selected_uploads').append(html);
                        // empty fields.
                        $('#builder').val('');
                        $('#estate').val('');
                        $('#lot_number').val('');
                        $('#house_name').val('');
                        $('#bed_id').val('');
                        $('#car_id').val('');
                        $('#bath_id').val('');
                        $('#price_id').val('');
                        $('#attachment').val('');
                        $('.NamePlace').html('');
                        refresh_submit_area();
                    } else {
                        if( data.status == 'error' ){
                            process_pop_up_errors(data.errors, '#package_pop_errors_area', '#add_new_package_form');
                        }
                    }
                },
                error : function(jqXHR, textStatus, errorThrown){
                    console.log(jqXHR);
                },       
                cache: false,
                contentType: false,
                processData: false
            });
        });
    });
    $(document).on('click','.remove_pdf_upload',function(){
        var time = $(this).data('time');
        var uid = $(this).data('uid');
        $.ajax({
            url: '<?php echo base_url().'package/delete-package/'.$timestamp.'/'; ?>'+uid,
            type: 'GET',
            dataType:'json',
            success: function (data) {
                if( data.status == 'success' ){
                    $('#row_'+uid).remove();
                    refresh_submit_area();
                }
            },
            error : function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
            },       
            cache: false,
            contentType: false,
            processData: false
        });
    });
    $(document).ready(function() {
        <?php if ($this->session->userdata('role') != ROLE_PURCHASER) { ?>
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
    function refresh_submit_area(){
        var package_row_count = $('.package_rows').length;
        if( package_row_count >= 5 ){
            $('.upload_pdfs_button').hide();
        } else {
            $('.upload_pdfs_button').show();
        }
        if( package_row_count > 0 ){
            $('.final_submit_button').show();
        } else {
            $('.final_submit_button').hide();
        }
    }
</script>