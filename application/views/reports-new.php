    <!-- Content Header (Page header) -->
<div class="loading" style="display: none;">Loading&#8230;</div>
<section class="content">
    <section class="content-header">
	       <div class="row">
            <div class="col-xs-12">
    				  <h1>
    				      Reports
    				  </h1>
			     </div>
			   </div>
    </section>
		<div class="report-filter-div">
      <div class="row" style="padding: 0 20px;">
        <div class="col-sm-6 col-lg-3 filter-box">
          <div class="boxshadow">
            <h4 class="dark-blue"><img src="assets/images/proecticon.png">Project</h4>
              <div class="projectValues value-box">
                <p><label for="all_projects">All Projects</label><input type="checkbox" class='floatCheck integraProjects' id="all_projects" value="all_projects"></p>
                  <?php if(isset($integraProjects->data) && !empty($integraProjects->data)){
                    ?>
                    <?php
                      foreach($integraProjects->data as $int_project)
                    { ?>
                <p><label for="proj_<?php echo $int_project->Name ?>"><?php echo $int_project->Name ?></label><input type="checkbox" name="integraProjects[]" class='floatCheck integraProjects' id="proj_<?php echo $int_project->Name ?>" value="<?php echo $int_project->Name."_".$int_project->id ?>"></p>
                    <?php }
                  } ?>
              </div>
				</div>	
      </div>
        <div class="col-sm-6 col-lg-3 filter-box">
    			<div class="boxshadow">
                <h4  class="light-blue"><img src="assets/images/proecticon.png">Precinct<img class="precintLoader" width="30" src="<?php echo base_url() ?>assets/images/ajax-loader_2.gif" style='display: none;'></h4>
              <div class="precintValues value-box">
                <p><label for="all_precints">All Precincts</label><input type="checkbox" class='floatCheck precints' id="all_precints" value="all_precints"></p>
              </div>
          </div>
        </div>
      <div class="col-sm-6 col-lg-3 filter-box">
			   <div class="boxshadow">
            <h4 class="light-green"><img src="assets/images/proecticon.png">Stage<img class="stageLoader" width="30" src="<?php echo base_url() ?>assets/images/ajax-loader_2.gif" style='display: none;'></h4>
                <div class="stageValues value-box">
                <p><label for="all_stages">All Stages</label><input type="checkbox" class='floatCheck stages' id="all_stages" value="all_stages"></p>
                  
                </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 filter-box">
			<div class="boxshadow">
                <h4 class="light-yellow"><img src="assets/images/proecticon.png">Status<img class="statusLoader" width="30" src="<?php echo base_url() ?>assets/images/ajax-loader_2.gif" style='display: none;'></h4>
				<div class="statusValues value-box">
                <p><label for="all_statuses">All Statuses</label><input type="checkbox" class='floatCheck statuses' id="all_statuses" value="all_statuses"></p>
                
                  <p><label for="stat_available">Available</label><input type="checkbox" name="statuses[]" class="floatCheck statuses" id="stat_available" data-color="#DEB887" data-border="#CDA776" value="Available"></p>
                  <p><label for="stat_on_hold">On Hold</label><input type="checkbox" name="statuses[]" class="floatCheck statuses" id="stat_on_hold" data-color="#A9A9A9" data-border="#989898" value="On Hold"></p>
                  <p><label for="stat_contracts_out">Contracts Out</label><input type="checkbox" name="statuses[]" class="floatCheck statuses" id="stat_contracts_out" data-color="#DC143C" data-border="#CB252B" value="Contracts Out"></p>
                  <p><label for="stat_contracted">Contracted</label><input type="checkbox" name="statuses[]" class="floatCheck statuses" id="stat_contracted" data-color="#F4A460" data-border="#E39371" value="Contracted"></p>
                  <p><label for="stat_settled">Settled</label><input type="checkbox" name="statuses[]" class="floatCheck statuses" id="stat_settled" data-color="#2E8B57" data-border="#1D7A46" value="Settled"></p>
                  <p><label for="stat_cancelled">Cancelled</label><input type="checkbox" name="statuses[]" class="floatCheck statuses" id="stat_cancelled" data-color="#1D7A46" data-border="#F4A460" value="Cancelled"></p>
                </div>
            </div>
            </div>
            <div class="col-xs-5 text-right" style="float: right;">
              <div class="row">
                <div class="col-md-5 col-lg-5">
                    <input type="date" id="start" type="text" class="input-sm form-control" name="start" placeholder="Start Date"  value="" />
                    </div>
                    <div class="col-md-2 col-lg-2">
                    <div class="text-center">
                    <span> to </span>
                    </div>
                    </div>
                    <div class=" col-md-5 col-lg-5">
                    <input type="date" id="end" type="text" class="input-sm form-control" name="end" placeholder="End Date" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <a class="btn btn-primary filter-btn" href="javascript:void(0)"> Filter</a>
                </div>
            </div>
        </div>
		</div>
		<div class="report-decs-div">
        <div class="row" style="padding: 0 20px;">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Reports</h3>
                    <div class="box-tools" style="display: none;">
                        <label for="list_view" class="active"> <i class="fa fa-list"></i> List</label>
                        <input type="checkbox" name="view" id="list_view" value="list" style="display:none;" checked>
                        <label for="bar_view"><i class="fa fa-bar-chart"></i>  Bar</label>
                        <input type="checkbox" name="view" id="bar_view" value="bar" style="display:none;">
                        <label for="pie_view"><i class="fa fa-pie-chart"></i> Pie</label>
                        <input type="checkbox" name="view" id="pie_view" value="pie" style="display:none;">
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding report-content">
                  <img class="reportLoader" width="100" src="<?php echo base_url() ?>assets/images/ajax-loader_2.gif" style='display: none;'>
                  
                </div><!-- /.box-body -->
                <div class="bar-container" style="display: none;">
                  <div class="bar-chart-container">
                    <div id="chartContainer" style="height: 370px; width: 100%;display: inline-block;"></div>
                  </div>
                </div>
                <div class="pie-container" style="display: none;">
                  <div class="pie-chart-container">
                    <div id="chartpie" style="width: 100%; height: 370px;display: inline-block;"></div>
                  </div>
                </div>
                <div class="box-footer clearfix">
                    <?php //echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
        </div>
    </section>

 <style type="text/css">
  /*.filter-box {
      padding: 0;
	 box-shadow: 0px 0px 9px 0px #d6d6d6;
  } */
  .filter-box h4{
    padding: 0 10px;
  }
  .value-box {
      overflow: auto;
      max-height: 280px;
  }
  .box-tools input {
      position: relative;
      top: 2px;
      margin: 0 5px;
  }
  .loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
    background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

  background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 150ms infinite linear;
  -moz-animation: spinner 150ms infinite linear;
  -ms-animation: spinner 150ms infinite linear;
  -o-animation: spinner 150ms infinite linear;
  animation: spinner 150ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/jQueryUI/jquery-ui.min.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>assets/plugins/canvas-js/canvasjs.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jQueryUI/jquery-ui.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $("#all_projects").change(function(){
          $(".integraProjects").prop('checked', $(this).prop('checked'));
        })

        $(".filter-box").on("change","#all_precints",function(){
          $(".precints").prop('checked', $(this).prop('checked'));
        })

        $(".filter-box").on("change","#all_stages",function(){
          $(".stages").prop('checked', $(this).prop('checked'));
        })

        $(".filter-box").on("change","#all_statuses",function(){
          $(".statuses").prop('checked', $(this).prop('checked'));
        })

        $(".integraProjects").change(function(){
          $(".precintLoader").show();
          var projectValues = [];
          $(".integraProjects:checked").each(function(){
            projectValues.push($(this).val());
          })
          $.ajax({
            type: "post",
            url: "<?php echo base_url() ?>report/filter_projects",
            data: {projectValues:projectValues},
            success: function(response){
              $(".precintLoader").hide();
              var responseA = JSON.parse(response);
              if(responseA.status=="success"){
                $(".precintValues").html(responseA.html);
              }else{
                alert(responseA.msg);
                $(".precintValues").html(responseA.html);
              }
            }
          })
        })

        $(".filter-box").on("change",".precints",function(){
          $(".stageLoader").show();
          var precinctValues = [];
          $(".precints:checked").each(function(){
            precinctValues.push($(this).val());
          })
          $.ajax({
          type: "post",
          url: "<?php echo base_url() ?>report/filter_precincts",
          data: {precinctValues:precinctValues},
          success: function(response){
            $(".stageLoader").hide();
            var responseA = JSON.parse(response);
            if(responseA.status=="success"){
              $(".stageValues").html(responseA.html);
            }else{
              alert(responseA.msg);
              $(".stageValues").html(responseA.html);
            }
          }
        })
      })

        $(".row").on("click",".filter-btn",function(){
          $(".loading").show();
          var projectValues = [];
          $(".integraProjects:checked").each(function(){
            projectValues.push($(this).val());
          })
          var precinctValues = [];
          $(".precints:checked").each(function(){
            precinctValues.push($(this).val());
          })
          var stageValues = [];
          $(".stages:checked").each(function(){
            stageValues.push($(this).val());
          })
          var statusValues = [];
          $(".statuses:checked").each(function(){
            statusValues.push($(this).val());
          })
          var colorValues = [];
          $(".statuses:checked").each(function(){
            colorValues.push($(this).data('color'));
          })
          var borderValues = [];
          $(".statuses:checked").each(function(){
            borderValues.push($(this).data('border'));
          })
          var start_date = $("#start").val();
          var end_date = $("#end").val();
          $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>reportnew/display_reports",
            data: {stageValues:stageValues,statusValues:statusValues,precinctValues:precinctValues,projectValues:projectValues,colorValues:colorValues,borderValues:borderValues,start_date:start_date,end_date:end_date},
            success : function(response){
             // alert(response);
              $(".loading").hide();
              var responseA = JSON.parse(response);
              if(responseA.status=="success"){
                  $(".report-content").html(responseA.html);
                  $(".box-tools").show();
                 //alert(responseA.ctx_inner);
                  var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    theme: "light2",
                    width: 1000,
                    title:{
                      text: "Number of Lots"
                    },
                    legend:{
                      cursor: "pointer",
                      verticalAlign: "center",
                      horizontalAlign: "right",
                      itemclick: toggleDataSeries
                    },
                    data: responseA.ctx_inner
                  });
                  chart.render();
                   
                  function toggleDataSeries(e){
                    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                      e.dataSeries.visible = false;
                    }
                    else{
                      e.dataSeries.visible = true;
                    }
                    chart.render();
                  }

                  var chart2 = new CanvasJS.Chart("chartpie", {
                        theme: "light2",
                        width: 1000,
                        animationEnabled: true,
                        title: {
                          text: "Number of Lots"
                        },
                        data: responseA.pie_chart
                      });

                  chart2.render();

                  
              }else{
                alert(responseA.msg);
              }
            }
          })
        })

        $(".box-tools input:checkbox").on('click', function() {
          // in the handler, 'this' refers to the box clicked on
          var $box = $(this);
          if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = ".box-tools input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
          } else {
            $box.prop("checked", false);
          }
        });

        $(".box-tools input:checkbox").change(function(){
          if($(".box-tools input:checked").val() == "bar"){
            $(".report-content").hide();
            $(".pie-container").hide();
            $(".bar-container").show();
          }
          else if($(".box-tools input:checked").val() == "list"){
            $(".bar-container").hide();
            $(".pie-container").hide();
            $(".report-content").show();
          }
          else if($(".box-tools input:checked").val() == "pie"){
            $(".bar-container").hide();
            $(".report-content").hide();
            $(".pie-container").show();
          }
        })
		
		
    
    $('.box-tools label').click(function() {
        $(this).siblings('label').removeClass('active');
        $(this).addClass('active');
    });
    $("#start").datepicker({
        orientation: "auto left",
        dateFormat: 'yy-mm-dd',
        showOtherMonths: true,
        selectOtherMonths: true,
        numberOfMonths: 1,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
        }
    });
    $("#end").datepicker({
        orientation: "auto left",
        dateFormat: 'yy-mm-dd',
        showOtherMonths: true,
        selectOtherMonths: true,
        numberOfMonths: 1,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 1);
        }
    });
    });
</script>
