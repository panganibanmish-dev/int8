<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Mailbox (UserController)
 * Class that processes /mailbox/ URIs
 * @author : Ruffy Collado
 * @version : 1.1
 * @since : 31 August 2020
 */
class Zoho extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Zoho_access');
        $this->isLoggedIn();
    }
    
    public function index()
    {
        require_once(FCPATH.'application/libraries/zoho/config.php');
        require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
        $zohoAuth = new zohoClass();
        
        //$query = "select Lots, Individual_Names, Stage from Deals where Individual_Names is not null";
        //$query = "select Lots, Stage Individual_Names FROM Deals WHERE Individual_Names like '%James%'";
        //$query = "select Lot_Stage FROM LOTS WHERE Name = 'ProjectNEW Negbour - Stage 2 - Lot 0'";
        //$query = "SELECT Actual_Start_Date, Drainage_Completed, Sewer_Completed, Water_Gas_Completed, Power_NBN_Completed, Pavements_Completed, Concrete_Works_Completed, Topsoiling_Completed, Linemarking_Signage_Completed, Earthworks_Completed, Registration_Date FROM STAGES WHERE Name = 'ProjectNEW Negbour - Stage 2'";
        $query = "SELECT Name, Actual_Start_Date, Drainage_Completed, Sewer_Completed, Stage_ID, Water_Gas_Completed, Power_NBN_Completed, Pavements_Completed, Concrete_Works_Completed, Topsoiling_Completed, Linemarking_Signage_Completed, Earthworks_Completed, Registration_Date, Received_Date, PRECINCT.Name, INTEGRA_PROJECTS.Name, INTEGRA_PROJECTS.Lot_No FROM STAGES WHERE ID = 12710000000284697";
        $postData['select_query'] = $query;
        $postData = json_encode($postData);
        $access_token = $this->Zoho_access->generate_access_token();
        print_r($access_token);
        //$integraProjects = $zohoAuth->searchModule($access_token, 'Deals', "(Individual_Names:not_equals:null)");
        //$integraProjects = $zohoAuth->getDealDetails($access_token, '12710000000336912');
        //$integraProjects = $zohoAuth->listModuleData($access_token, 'DEALS');
        //$integraProjects = $zohoAuth->queryModule($access_token, $postData);
        
        //echo "<pre>";print_r($integraProjects);echo "</pre>";
    }
    
}