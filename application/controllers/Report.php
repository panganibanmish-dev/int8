<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Report (UserController)
 * Report Class to display reports.
 * @author : Human Pixel
 * @version : 1.1
 * @since : 08 May 2020
 */
class Report extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->isLoggedIn();   
    }

    public function index()
    {
    	if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
        	require_once(FCPATH.'application/libraries/zoho/config.php');
        	require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
        	$zohoAuth = new zohoClass();
	        // Load Zoho Access model
	        $this->load->model('Zoho_access');
	        $access_token = $this->Zoho_access->generate_access_token();
	        $integraProjects = $zohoAuth->getModuleDetails("INTEGRA_PROJECTS",$access_token);
	        //echo "<pre>";print_r($integraProjects);echo "</pre>";
            
            $data['integraProjects'] = $integraProjects;
            
            $this->global['pageTitle'] = 'Report';
            
            $this->loadViews("reports", $this->global, $data, NULL);
        }
    }

    public function filter_projects()
    {
    	if(!isset($_POST['projectValues']) || empty($_POST['projectValues']))
    	{
    		echo json_encode(array("status"=>"error","msg"=>"Please select atleast one project","html"=>'<p><label for="all_precints">All Precincts</label><input type="checkbox" class="floatCheck precints" id="all_precints" value="all_precints"></p>'));
    		die;
    	}
    	require_once(FCPATH.'application/libraries/zoho/config.php');
    	require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
    	$zohoAuth = new zohoClass();
        // Load Zoho Access model
        $this->load->model('Zoho_access');
        $access_token = $this->Zoho_access->generate_access_token();
    	$projectValues = $_POST['projectValues'];
		$pp_html = '<p><label for="all_precints">All Precincts</label><input type="checkbox" class="floatCheck precints" id="all_precints" value="all_precints"></p>';
    	foreach($projectValues as $project_value)
    	{
    		$projectExpl = explode("_", $project_value);
    		$project_name = isset($projectExpl[0]) ? $projectExpl[0] : "";
    		$int_project_id = isset($projectExpl[1]) ? $projectExpl[1] : "";
    		$project_precints = $zohoAuth->getModuleRelatedRecords("INTEGRA_PROJECTS",$int_project_id,"PRECINCT",$access_token);
    		if(isset($project_precints->data) && !empty($project_precints->data))
    		{
    			foreach($project_precints->data as $projectPrecintValue)
    			{
    				$pp_html .= '<p><label for="prec_'.$projectPrecintValue->Name.'">'.$projectPrecintValue->Name.'</label><input type="checkbox" name="precints[]" class="floatCheck precints" id="prec_'.$projectPrecintValue->Name.'" value="'.$projectPrecintValue->Name."_".$projectPrecintValue->id.'"></p>';
    			}
    		}
    	}
    	echo json_encode(array("status"=>"success","msg"=>"Success!","html"=>$pp_html));
    	die;
    }

    public function filter_precincts()
    {
    	if(!isset($_POST['precinctValues']) || empty($_POST['precinctValues']))
    	{
    		echo json_encode(array("status"=>"error","msg"=>"Please select atleast one precinct","html"=>'<p><label for="all_stages">All Stages</label><input type="checkbox" class="floatCheck stages" id="all_stages" value="all_stages"></p>'));
    		die;
    	}
    	require_once(FCPATH.'application/libraries/zoho/config.php');
    	require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
    	$zohoAuth = new zohoClass();
        // Load Zoho Access model
        $this->load->model('Zoho_access');
        $access_token = $this->Zoho_access->generate_access_token();
    	$precinctValues = $_POST['precinctValues'];
		$ps_html = '<p><label for="all_stages">All Stages</label><input type="checkbox" name="stages[]" class="floatCheck stages" id="all_stages" value="all_stages"></p>';
    	foreach($precinctValues as $precinct_value)
    	{
    		$precinctExpl = explode("_", $precinct_value);
    		$precinct_name = isset($precinctExpl[0]) ? $precinctExpl[0] : "";
    		$precinct_id = isset($precinctExpl[1]) ? $precinctExpl[1] : "";

    		$precinct_stages = $zohoAuth->getModuleRelatedRecords("PRECINCT",$precinct_id,"STAGES",$access_token);
    		//print_r($precinct_stages);
    		if(isset($precinct_stages->data) && !empty($precinct_stages->data))
    		{
    			foreach($precinct_stages->data as $precinctStageValue)
    			{
    				if(strpos($precinctStageValue->Name, $precinct_name) !== false){
	    				$ps_html .= '<p><label for="stag_'.$precinctStageValue->Name.'">'.$precinctStageValue->Name.'</label><input type="checkbox" name="stages[]" class="floatCheck stages" id="stag_'.$precinctStageValue->Name.'" value="'.$precinctStageValue->Name."_".$precinctStageValue->id.'"></p>';
	    			}
    			}
    		}
    	}
    	echo json_encode(array("status"=>"success","msg"=>"Success!","html"=>$ps_html));
    	die;
    }

    public function display_reports()
    {
        $report_html = '<img class="reportLoader" width="100" src="'.base_url().'assets/images/ajax-loader_2.gif" style="display: none;">';
    	if((!isset($_POST['projectValues']) || empty($_POST['projectValues'])) && (!isset($_POST['statusValues']) || empty($_POST['statusValues'])))
    	{
    		echo json_encode(array("status"=>"error","msg"=>"Please select atleast one project or one status","html"=>$report_html));
    		die;
    	}
        if((isset($_POST['projectValues']) && !empty($_POST['projectValues'])) && (!isset($_POST['statusValues']) || empty($_POST['statusValues'])))
        {
            echo json_encode(array("status"=>"error","msg"=>"Please select atleast one status","html"=>$report_html));
            die;
        }
    	// if(!isset($_POST['precinctValues']) || empty($_POST['precinctValues']))
    	// {
    	// 	echo json_encode(array("status"=>"error","msg"=>"Please select atleast one precint","html"=>""));
    	// 	die;
    	// }
    	// if(!isset($_POST['stageValues']) || empty($_POST['stageValues']))
    	// {
    	// 	echo json_encode(array("status"=>"error","msg"=>"Please select atleast one stage","html"=>""));
    	// 	die;
    	// }
    	// if(!isset($_POST['statusValues']) || empty($_POST['statusValues']))
    	// {
    	// 	echo json_encode(array("status"=>"error","msg"=>"Please select atleast one status","html"=>$report_html));
    	// 	die;
    	// }
    	require_once(FCPATH.'application/libraries/zoho/config.php');
    	require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
    	$zohoAuth = new zohoClass();
        // Load Zoho Access model
        $this->load->model('Zoho_access');
        $access_token = $this->Zoho_access->generate_access_token();
    	$stageValues = (isset($_POST['stageValues']) && !empty($_POST['stageValues'])) ? $_POST['stageValues'] : array();
    	$statusValues = $_POST['statusValues'];
        $colorValues = $_POST['colorValues'];
        $borderValues = $_POST['borderValues'];
    	$precinctValues = (isset($_POST['precinctValues']) && !empty($_POST['precinctValues'])) ? $_POST['precinctValues'] : array();
    	$projectValues = (isset($_POST['projectValues']) && !empty($_POST['projectValues'])) ? $_POST['projectValues'] : array();
    	
        if(!empty($stageValues)){
            $report_html .= '<table class="table table-hover">
                            <tr>
                              <th>Stage</th>
                              <th>Status</th>
                              <th>No. of Lots</th>
                            </tr>';
        }
        elseif(!empty($precinctValues) && empty($stageValues)){
            $report_html .= '<table class="table table-hover">
                            <tr>
                              <th>Precinct</th>
                              <th>Status</th>
                              <th>No. of Lots</th>
                            </tr>';
        }elseif(!empty($projectValues) && empty($precinctValues) && empty($stageValues)){
            $report_html .= '<table class="table table-hover">
                            <tr>
                              <th>Project</th>
                              <th>Status</th>
                              <th>No. of Lots</th>
                            </tr>';
        }elseif(!empty($statusValues) && empty($projectValues) && empty($precinctValues) && empty($stageValues)){
            $report_html .= '<table class="table table-hover">
                            <tr>
                              <th>Status</th>
                              <th>No. of Lots</th>
                            </tr>';
        }else{
            echo json_encode(array("status"=>"error","msg"=>"There is something wrong in combination","html"=>""));
            die;
        }
        $chart_data = array();
        if(!empty($stageValues))
        {
            $chart_type = "mixed";
            foreach($stageValues as $stage_value)
            {
                if($stage_value!="all_stages")
                {
                    $stageExpl = explode("_", $stage_value);
                    $stage_name = isset($stageExpl[0]) ? rawurlencode($stageExpl[0]) : "";
                    $stage_id = isset($stageExpl[1]) ? $stageExpl[1] : "";
                    $status_r_name = '';
                    $total_lots = '';
                    $statusKey=0;
                    foreach($statusValues as $s => $status_value)
                    {
                        if($status_value!="all_statuses"){
                            $status_value = rawurlencode($status_value);
                            
                            $statusHtml = "Status:equals:$status_value";
                            $searched_lots = $zohoAuth->searchModuleRecords("LOTS","?criteria=(Name:starts_with:$stage_name)and($statusHtml)",$access_token);
                            if(isset($searched_lots->info)){
                                $total_lots .= "<li>".$searched_lots->info->count."</li>";
                                $count_lots = $searched_lots->info->count;
                            }else{
                                $total_lots .= "<li>0</li>";
                                $count_lots = 0;
                            }
                            $status_r_name .= "<li>".rawurldecode($status_value)."</li>";
                            $ctx_inner[$statusKey]['label'] = rawurldecode($status_value);
                            $ctx_inner[$statusKey]['data'][] = $count_lots;
                            $ctx_inner[$statusKey]['backgroundColor'][] = $colorValues[$s];
                            $ctx_inner[$statusKey]['borderColor'][] = $borderValues[$s];
                            $ctx_inner[$statusKey]['borderWidth'][] = 1;
                            $statusKey++;
                        }
                    }
                    if($statusKey==1)
                    {
                        $chart_type='single';
                    }
                    $report_html .= "<tr>
                                    <td>".rawurldecode($stage_name)."</td>
                                    <td>".$status_r_name."</td>
                                    <td>".$total_lots."</td>
                                </tr>";
                    $chart_data['label'][] = rawurldecode($stage_name);
                    $chart_data['data'][] = $count_lots;
                    $chart_data['title'] = "No. of Lots (".rawurldecode($status_value).")";
                }
            }
        }
        elseif(!empty($precinctValues) && empty($stageValues))
        {
            $chart_type = "mixed";
            foreach($precinctValues as $precinct_value)
            {
                if($precinct_value!="all_precints"){
                    $precinctExpl = explode("_", $precinct_value);
                    $precinct_name = isset($precinctExpl[0]) ? $precinctExpl[0] : "";
                    $precinct_name = rawurlencode($precinct_name);
                    $precinct_id = isset($precinctExpl[1]) ? $precinctExpl[1] : "";
                    $status_r_name = '';
                    $total_lots = '';
                    $statusKey = 0;
                    foreach($statusValues as $s => $status_value)
                    {
                        if($status_value!="all_statuses"){
                            $status_value = rawurlencode($status_value);
                            
                            $statusHtml = "Status:equals:$status_value";
                            $searched_lots = $zohoAuth->searchModuleRecords("LOTS","?criteria=(Name:starts_with:$precinct_name)and($statusHtml)",$access_token);
                            
                            if(isset($searched_lots->info)){
                                $total_lots .= "<li>".$searched_lots->info->count."</li>";
                                $count_lots = $searched_lots->info->count;
                            }else{
                                $total_lots .= "<li>0</li>";
                                $count_lots = 0;
                            }
                            $status_r_name .= "<li>".rawurldecode($status_value)."</li>";
                            $ctx_inner[$statusKey]['label'] = rawurldecode($status_value);
                            $ctx_inner[$statusKey]['data'][] = $count_lots;
                            $ctx_inner[$statusKey]['backgroundColor'][] = $colorValues[$s];
                            $ctx_inner[$statusKey]['borderColor'][] = $borderValues[$s];
                            $ctx_inner[$statusKey]['borderWidth'][] = 1;
                            $statusKey++;
                        }
                    }
                    if($statusKey==1)
                    {
                        $chart_type='single';
                    }
                    $report_html .= "<tr>
                                        <td>".rawurldecode($precinct_name)."</td>
                                        <td>".$status_r_name."</td>
                                        <td>".$total_lots."</td>
                                    </tr>";
                    $chart_data['label'][] = rawurldecode($precinct_name);
                    $chart_data['data'][] = $count_lots;
                    $chart_data['title'] = "No. of Lots (".rawurldecode($status_value).")";
                }
            }
        }
        elseif(!empty($projectValues) && empty($precinctValues) && empty($stageValues))
        {
            $chart_type = "mixed";
            foreach($projectValues as $project_value)
            {
                if($project_value!="all_projects") 
                {
                    $projectExpl = explode("_", $project_value);
                    $project_name = isset($projectExpl[0]) ? $projectExpl[0] : "";
                    $project_id = isset($projectExpl[1]) ? $projectExpl[1] : "";
                    $status_r_name = '';
                    $total_lots = '';
                    $statusKey = 0;
                    foreach($statusValues as $s => $status_value)
                    {
                        if($status_value!="all_statuses"){
                            $status_value = rawurlencode($status_value);
                            
                            $statusHtml = "Status:equals:$status_value";
                            $project_lots = $zohoAuth->getAllModuleRelatedRecords("INTEGRA_PROJECTS",$project_id,"LOTS",$access_token);
                            $count_lots = 0;
                            if(!empty($project_lots))
                            {
                                foreach($project_lots as $project_lot)
                                {
                                    if($project_lot->Status==rawurldecode($status_value))
                                    {
                                        $count_lots++;
                                    }
                                }
                            }
                            $total_lots .= "<li>".$count_lots."</li>";
                            $status_r_name .= "<li>".rawurldecode($status_value)."</li>";
                            $ctx_inner[$statusKey]['label'] = rawurldecode($status_value);
                            $ctx_inner[$statusKey]['data'][] = $count_lots;
                            $ctx_inner[$statusKey]['backgroundColor'][] = $colorValues[$s];
                            $ctx_inner[$statusKey]['borderColor'][] = $borderValues[$s];
                            $ctx_inner[$statusKey]['borderWidth'][] = 1;
                            $statusKey++;
                        }
                    }
                    if($statusKey==1)
                    {
                        $chart_type='single';
                    }
                    $report_html .= "<tr>
                                        <td>".rawurldecode($project_name)."</td>
                                        <td>".$status_r_name."</td>
                                        <td>".$total_lots."</td>
                                    </tr>";
                    $chart_data['label'][] = rawurldecode($project_name); 
                    $chart_data['data'][] = $count_lots;
                    $chart_data['title'] = "No. of Lots (".rawurldecode($status_value).")"; 
                }
            }
        }
        elseif(!empty($statusValues) && empty($projectValues) && empty($precinctValues) && empty($stageValues))
        {
            $chart_type = "single";
            $statusKey = 0;
            foreach($statusValues as $s => $status_value)
            {
                if($status_value!="all_statuses")
                {
                    $search_status = rawurlencode($status_value);
                    $lots = $zohoAuth->searchModuleRecords("LOTS","?criteria=(Status:equals:$search_status)",$access_token);
                    if(isset($lots->info)){
                        $count_lots = $lots->info->count;
                    }else{
                        $count_lots = 0;
                    }
                    $report_html .= "<tr>
                                        <td>".$status_value."</td>
                                        <td>".$count_lots."</td>
                                    </tr>"; 
                    $chart_data['label'][] = $status_value;
                    $chart_data['data'][] = $count_lots;
                    $chart_data['title'] = "No. of Lots (".$status_value.")";
                    $ctx_inner[$statusKey]['label'][] = $status_value;
                    $ctx_inner[$statusKey]['data'][] = $count_lots;
                    $ctx_inner[$statusKey]['backgroundColor'][] = $colorValues[$s];
                    $ctx_inner[$statusKey]['borderColor'][] = $borderValues[$s];
                    $ctx_inner[$statusKey]['borderWidth'][] = 1;
                    $statusKey++;
                }
            }
        }
    	// foreach($precinctValues as $precinct_value)
    	// {
    	// 	if($precinct_value!="all_precints"){
	    // 		$precinctExpl = explode("_", $precinct_value);
	    // 		$precinct_name = isset($precinctExpl[0]) ? $precinctExpl[0] : "";
	    // 		$precinct_id = isset($precinctExpl[1]) ? $precinctExpl[1] : "";
	    // 		$total_lots = 0;
	    // 		$stage_r_name = '';
		   //  	foreach($stageValues as $stage_value)
		   //  	{
		   //  		$stageExpl = explode("_", $stage_value);
		   //  		$stage_name = isset($stageExpl[0]) ? rawurlencode($stageExpl[0]) : "";
		   //  		$stage_id = isset($stageExpl[1]) ? $stageExpl[1] : "";
		   //  		if(strpos($stage_name, $precinct_name) !== false){
			  //   		$statusHtml = '';
			  //   		foreach($statusValues as $s => $status_value)
			  //   		{
			  //   			if($status_value!="all_statuses"){
				 //    			$status_value = rawurlencode($status_value);
				 //    			if($s!=0)
				 //    			{
				 //    				$statusHtml .= "or";
				 //    			}
				 //    			$statusHtml .= "(Status:equals:$status_value)";

				 //    		}
			  //   		}
			  //   		$searched_lots = $zohoAuth->searchModuleRecords("LOTS","?criteria=(Name:starts_with:$stage_name)and($statusHtml)",$access_token);
			  //   		//print_r($searched_lots);
			  //   		if(isset($searched_lots->info)){
			  //   			$total_lots += $searched_lots->info->count;
			  //   		}
			  //   	$stage_r_name .= "<li>".rawurldecode($stage_name)."</li>";
			  //   	}
		   //  	}
	    // 		$report_html .= "<tr>
	    // 							<td>".$precinct_name."</td>
	    // 							<td>".$stage_r_name."</td>
	    // 							<td>".$status_r_name."</td>
	    // 							<td>".$total_lots."</td>
	    // 						</tr>";
	    // 	}
    	// }
    	echo json_encode(array("status"=>"success","msg"=>"Success!","html"=>$report_html,"chart_data"=>$chart_data,"ctx_inner"=>$ctx_inner,"chart_type"=>$chart_type));
    	die;
    }
}