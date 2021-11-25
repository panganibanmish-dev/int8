<?php  $base_url =  base_url();  ?>
<section class="container content02">
        <div class="col-11 m-auto construction_head">            
            <h1>CONSTRUCTION</h1>
        </div>
        <div class="row">
            <div class="content03 col-12">
                <div class="row">
                    <div class="col-12 col-md-4 SideBarOuter">
                        <div class="SideBar">
                            
                            <ul class="List01">
                                <?php if(!$isBuilderOrContractor){ ?> 
                                    <li>
                                        <span>Your Lot Number:</span>
                                        <strong><?php echo $lot->Lot_No; ?></strong>
                                    </li>
                                <?php } ?>
                                <li>
                                    <span>Estate:</span>
                                    <strong><?php echo $stage->{'INTEGRA_PROJECTS.Name'}; ?></strong>
                                </li>
                                <li>
                                    <span>Stage:</span>
                                    <strong><?php echo $stage->Stage_ID; ?></strong>
                                </li>
                                <li>
                                    <span>Neighbourhood:</span>
                                    <strong><?php echo $stage->{'PRECINCT.Name'}; ?></strong>
                                </li>
                                <li>
                                    <span>Anticipated Title Date:</span>
                                    <strong><?php echo $stage->Anticipated_Titles_Public; ?></strong>
                                </li>
                            </ul>
                            <div class="Chart01 col-12">
                                <div class="col-12 m-auto ChartSize">
                                    <div id="chartdiv">
                                        <div class="ChartText01">
                                            <span>0&#37;</span>
                                            Completed
                                        </div>
                                    </div>
                                </div>
                                <div id="pie_legend">
                                    <h3>Keys</h3>
                                    <ul>
                                        <li>
                                            <i class="completeL"><img src="<?= $base_url ?>assets/img/complete.svg" alt=""></i>
                                            Complete
                                        </li>
                                        <li>
                                            <i class="progressL"><img src="<?= $base_url ?>assets/img/progress.svg" alt=""></i>
                                            In Progess
                                        </li>
                                        <li>
                                            <i class="notStartedL"><img src="<?= $base_url ?>assets/img/not-started.svg" alt=""></i>
                                            Not yet started
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 SideBarBottom">
                            <p>Due to the nature of construction, anticipated titles forecast is indicitave only and is subject to change at any time.</p>
                        </div>
                    </div> 
                    
                    <div class="col-12 col-md-8 RightContent01">
                        <div class="row m-0">
                            <div class="Sec01 col-12">                    
                                <div class="col-12 col-sm-6 p-0">
                                    
                                    <h3 class="LeftCorner">Construction Phase</h3>
                                    
                                    <ul class="List02">
                                        <li class="<?php echo $progress['startDateClass']; ?>">Construction started</li>
                                        <li class="<?php echo $progress['drainageClass']; ?>">Drainage</li>
                                        <li class="<?php echo $progress['sewerClass']; ?>">Sewer</li>
                                        <li class="<?php echo $progress['waterGasClass']; ?>">Water/gas</li>
                                        <li class="<?php echo $progress['powerClass']; ?>">Power/NBN</li>
                                        <li class="<?php echo $progress['pavementsClass']; ?>">Pavements</li>
                                        <li class="<?php echo $progress['concreteWorksClass']; ?>">Concrete works</li>
                                        <li class="<?php echo $progress['topsoilingClass']; ?>">Topsoiling</li>
                                        <li class="<?php echo $progress['linemarkingClass']; ?>">Linemarking/signage</li>
                                        <li class="<?php echo $progress['earthworksClass']; ?>">Earthworks</li>
                                    </ul>
                                        
                                </div>
                                <div class="col-12 col-sm-6 p-0">
                                    <h3 class="RightCorner">Registration Phase</h3>
                                    <ul class="List02">
                                        <li class="<?php echo $progress['registrationDateClass']; ?>">Statement of Compliance</li>
                                        <li class="<?php echo $progress['receivedDateClass']; ?>">Plan Registration </li>
                                    </ul>
                                </div>
                            </div>
                        </div>      

                        <!-- Upload lot documents -->
                        <div id="file_upload_section_main" class="row m-0">  
                            <div class="Sec01 col-12">                        
                                <div class="col-12 p-0">
                                    <h3 class="Corner">Stage Resources</h3>
                                </div>

                                <div class="col-12 file_upload_section">

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

                                    <div>

                                        <?php
                                        
                                        if( count($lot_documents) > 0 ){ ?> 
                                            <div class="bottom_margin_adjust">
                                                <ul class="List01">
                                                
                                                    <?php foreach( $lot_documents as $key => $each_doc)
                                                    { 
                                                        ?>
                                                          
                                                        <li id="each_document_<?php echo $each_doc->id; ?>">
                                                            <?php if(!$isBuilderOrContractor){ ?> 
                                                            <?php //$gatherId = $each_doc->id; ?>
                                                            <a target="_blank"
                                                                href="<?php echo base_url().'stage/downloadDoc/'.$each_doc->id; ?>" 
                                                                class="Icon04">
                                                                <img src="<?= $base_url ?>assets/img/icon15.svg" alt="Download">
                                                            </a>&nbsp;
                                                            
                                                            <a 
                                                                data-id="<?php echo $each_doc->id; ?>" 
                                                                data-title="<?php echo $each_doc->document; ?>" 
                                                                data-path="<?php echo base_url().'stage/deleteDocument'; ?>" 
                                                                class="text-danger common_delete_confirm common_delete_confirm_style" href="javascript:void(0);">&times;</a>&nbsp;
                                                            <!-- <button onclick="confirmDel(key)">Delete</button> -->
                                                            <?php } ?>
                                                            <span>&nbsp;&nbsp;
                                                                <?php 
                                                                echo $each_doc->docName; 
                                                                    ?>&nbsp;
                                                                    <?php if(!$isBuilderOrContractor) { ?>
                                                                      <a href="#" onclick="window.open('<?php echo base_url().'uploads/documents/'.$each_doc->document; ?>', '_blank', 'fullscreen=yes'); return false;">
                                                                    <?php } ?>
                                                            <?php echo 'uploads/documents/'.$each_doc->document; ?>
                                                            </a>
                                                            </span>                
                                                        </li>

                                                      
                                                        
                                                    <?php } ?>  
                                                    <div class="col-12 text-right ButtonOuter01">                        
                                                            <a id="upload_new_lot_doc" class="SiteButton01" href="javascript:void(0);">
                                                            Upload
                                                             </a>
                                                        <div class="clearfix"></div>
                                                        </div>                    
                                                </ul>

                                            </div>

                                        <?php } else { ?> 
                                            
                                            <div class="col-sm-12 bottom_margin_adjust">
                                                <p>No Documents Available</p>
                                            </div>
                                            <div class="col-12 text-right ButtonOuter01">                        
                                                <a id="upload_new_lot_doc" class="SiteButton01" href="javascript:void(0);">
                                                    Upload
                                                </a>
                                                <div class="clearfix"></div>
                                    </div>
                                        <?php } ?>

                                    </div>

                                  
                                    <div class="clearfix"></div>
                                </div>

                            </div>
                        </div>
                         <!-- END Upload lot documents -->

                    </div>
                </div>
            </div>    
        </div>  
    </section> 
    <script src="<?php echo base_url(); ?>assets/js/core.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/charts.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/animated.js"></script>    
    <script>
        function confirmDel(val1){
            console.log(val1);
        }
        $(document).ready(function(){

            $('#upload_new_lot_doc').click(function(){

                $('#document_upload_modal').modal('show');
               
            });
            
            $('.common_delete_confirm').click(function(){

                var id = $(this).attr('data-id');
                var document = $(this).attr('data-title');
                var path = $(this).attr('data-path');
                console.log(id);
                console.log(document);
                console.log(path);
                

                $('#removal_title_text').html(document);

                $('#confirm_delete_button').data('id',id);
                $('#confirm_delete_button').data('path',path);

                $('#delete_common_modal').modal('show');

            });

            $('#confirm_delete_button').click(function(){

                var id = $(this).data('id');
                var path = $(this).data('path');

                var url = path+'/'+id;

                $('.alert-dismissable').hide();

                $('#delete_common_modal').modal('hide');

                $.get(url,function(data){

                    if( data == 'success' ){
                        $('#each_document_'+id).fadeOut('medium');
                    }else{
                        window.location.reload();
                    }
                    // 
                });
            });
            // $('#confirmDel').click(function(){
            //     var confirmedData = $(this).data('id');
            //     console.log(confimedData);
            // });


        });

        var phases = {};
        phases.concreteWorks = '<?php echo $progress['concreteWorks'] ?>';
        phases.pavements = '<?php echo $progress['pavements'] ?>';
        phases.power = '<?php echo $progress['power'] ?>';
        phases.topSoiling = '<?php echo $progress['topsoiling'] ?>';
        phases.drainage = '<?php echo $progress['drainage'] ?>';
        phases.waterGas = '<?php echo $progress['waterGas'] ?>';
        phases.sewer = '<?php echo $progress['sewer'] ?>';
        phases.earthworks = '<?php echo $progress['earthworks'] ?>';
        phases.lineMarking = '<?php echo $progress['linemarking'] ?>';
        phases.startDate = '<?php echo $progress['startDate'] ?>';

        var completed = 0;
        var ongoing = 0;
        var not_started = 0;

        var total = 0;
        
        for (phase in phases) {

            total += 10;
            
            switch(phases[phase]) {

                case 'Completed':
                    completed += 10
                    break;
                case 'Ongoing':
                    ongoing += 10;
                    break;
                case 'Not started':
                    not_started += 10;
                    break;
            }

        }

        // percentages 

        var percent_completed = Math.floor((completed/total)*100);
        var percent_ongoing = Math.floor((ongoing/total)*100);
        var percent_not_started = Math.floor((not_started/total)*100);

        // ChartJs


        am4core.ready(function() {
            am4core.useTheme(am4themes_animated);
            var chart = am4core.create("chartdiv", am4charts.PieChart);
            var pieSeries = chart.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "value";
            pieSeries.dataFields.category = "label";
            chart.innerRadius = am4core.percent(45);
            pieSeries.slices.template.stroke = am4core.color("#fff");
            pieSeries.slices.template.strokeWidth = 2;
            pieSeries.slices.template.strokeOpacity = 1;
            pieSeries.slices.template
            .cursorOverStyle = [
                {
                    "property": "cursor",
                    "value": "pointer"
                }
            ];
            pieSeries.labels.template.text = "";
            pieSeries.alignLabels = false;
            pieSeries.labels.template.bent = true;
            pieSeries.labels.template.radius = 3;
            pieSeries.labels.template.padding(0,0,0,0);
            pieSeries.ticks.template.disabled = true;
            var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
            shadow.opacity = 0;
            var hoverState = pieSeries.slices.template.states.getKey("hover");
            chart.data = [{
                "label": "Not yet started",
                "value": percent_not_started,
                },
                {
                "label": "In Progess",
                "value": percent_ongoing
                },
                {
                "label": "Complete",
                "value": percent_completed,
                } 
            ];
            pieSeries.colors.list = [
                am4core.color("#FF9051"),
                am4core.color("#FFC422"),
                am4core.color("#78B82A"),
            ];

            $("g").each(function(){
                var attr = $(this).attr('filter');
                if (typeof attr !== typeof undefined && attr !== false) {
                    $(this).remove();
                }
            });
            $("#chartdiv").append("<div class='ChartText01'><span>"+percent_completed+"%</span> Completed</div>");
        });
    </script>
<div class="modal doc_custom_modal" id="document_upload_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload Stage Resources</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    
        <div class="col-sm-12">

            <form role="form" 
                id="upload_new_lot_doc_from" 
                enctype="multipart/form-data" 
                action="<?php echo base_url() ?>stage/saveLotDocument/<?php echo $lot->id; ?>" 
                method="post" 
                role="form" 
                class="row Form01"
            >

                <div class="col-12 col-sm-12 FieldOuter01">
                    <label for="doc_label_menu">Label</label>
                    <select id = 'chosen_document_id' name = 'chosen_document_id' class = 'SelectField01'>
                            <option value = ''> Choose one </option>
                            <?php foreach ($lot_doc_labels as $ldl_key => $ldl_val) { ?>
                            <option id = '<?php echo $ldl_key; ?>' value = '<?php echo $ldl_key; ?>'><?php echo $ldl_val; ?> </option>
                            <?php } ?>
                    </select>
                </div>
                
                <div class="col-12 col-sm-12 FieldOuter01">
                    <label for="Attachments">Attachments</label>
                    <div class="FileField01">
                        <input type="file" id="attachment" name="attachment" class="Filed2121212" required>
                        <div class="FilePlace">
                            <a href="javascript:;">Click Here</a> &nbsp;
                            <span class="NamePlace"></span>
                            <a href="javascript:;" class="ArrowButton01 ml-auto">Action</a>
                        </div>
                    </div>              
                </div>

                <div class="col-12 col-sm-12 FieldOuter01 text-center">
                    <input type="submit" value="Save" class="SiteButton01">
                </div>

                <div class="clearfix"></div>

            </form>

        </div>

      </div>
      
    </div>
  </div>
</div>


<div class="modal doc_custom_modal" id="delete_common_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body delete-main-style">

            <div class="col-sm-12 delete_main_space delete_main_margin">
                <h5>Confirm Removal of</h5>
                <span id="removal_title_text"></span>
            </div>

            <div class="col-sm-12 delete_main_margin" >
                <button id="confirm_delete_button" type="button" class="btn btn-primary ">Confirm</button>
                &nbsp;&nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>

      </div>
    </div>
  </div>
</div>