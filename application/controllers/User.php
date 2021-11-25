<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User extends BaseController
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
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        switch ($this->session->userdata('role')) {
            case ROLE_ADMIN:
                $this->adminDashboard();
                break;
            
            //DO NOT REMOVE: THIS IS FOR TESTING ZOHO LIVE DATA
            // case ROLE_PURCHASER:
            // case ROLE_CONTRACTOR:
            // case ROLE_BUILDER:
                // $this->userDashboard();
                // break;

            default:
                $this->userDashboard();
                //$this->testShit();
                break;
        }
    }
    
    public function goBacktotheVoid()
    {
        return 'Error!';
    }

    public function testShit()
    {
        $this->global['pageTitle'] = 'LANDHUB PORTAL : Dashboard';
        
        require_once(FCPATH.'application/libraries/zoho/config.php');
        require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
        $this->load->model('Zoho_access');
        
        $zohoAuth = new zohoClass();
        $access_token = $this->Zoho_access->generate_access_token();
        
        $dealsList = array();
        $userNames = ['fakeemail1@projects.humanpixel.com.au', 'fakeemail2@projects.humanpixel.com.au'];
        $userName = $this->session->userdata('email');
        echo 'USERNAME:'.$userName;
        $getDealsQuery = "select Lots, Stage, Individual_Names FROM Deals WHERE Individual_Names like '%$userName%' AND Stage != 'Settled'";
        $getDealsQuery = "select Lot, Estate, Lot_Stage, Stage, Individual_Names
            FROM Deals
            WHERE (Individuals_Sinle_Lookup.Email = '$userName' OR Individual_2_Name.Email = '$userName')
            AND (Stage != 'Settled'
            AND Stage != 'Opportunity Lost')";
        $postData['select_query'] = $getDealsQuery;
        $deals = $zohoAuth->queryModule($access_token, json_encode($postData));
        
        echo "<pre>";
        print_r($deals);
        echo "</pre>";
        
    }
    
    public function testShit2()
    {
        $this->global['pageTitle'] = 'LANDHUB PORTAL : Dashboard';
        
        require_once(FCPATH.'application/libraries/zoho/config.php');
        require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
        $this->load->model('Zoho_access');
        
        $zohoAuth = new zohoClass();
        $access_token = $this->Zoho_access->generate_access_token();
        
        $dealsList = array();
        $userName = $this->session->userdata('email');
        $getDealsQuery = "select Lots.Name, Stage, Individual_Names FROM Deals WHERE Individual_Names LIKE '%$userName%' AND Stage != 'Settled'";
        $postData['select_query'] = $getDealsQuery;
        //$deals = $zohoAuth->listModuleData($access_token, 'Deals/12710000001330112/');
        $deals = $zohoAuth->listModuleData($access_token, 'Deals');
        
        echo "<pre>";
        print_r($deals);
        echo "</pre>";
        
    }
    
    private function getConstructionProgress($task)
    {
        if (empty($task)) {
            return 0;
        }
        
        if (date('Y-m-d') >= date('Y-m-d', strtotime($task))) {
            return 10;
        }
        
        return 0;
    }
    
    public function filterArrayByKeys(array $input, array $column_keys)
    {
        $result      = array();
        $column_keys = array_flip($column_keys); // getting keys as values
        foreach ($input as $key => $val) {
            // getting only those key value pairs, which matches $column_keys
            $result[$key] = array_intersect_key($val, $column_keys);
        }
        return $result;
    }

    public function getUsersData(){

        $this->load->model('user_model');
        $receivedUsers = $this->user_model->getUsers(); 

        $selections1 = array();

        foreach ($receivedUsers as $key => $value) {
                $selections1[$key]['label'] = $value->name;
                $selections1[$key]['theValue'] = $value->userId;
                $selections1[$key]['theEmail'] = $value->email; 
        }

        echo json_encode($selections1);
    }

    public function getSearchedUserData(){
        $name = $_GET['name'];

        $this->load->library('user_model');
        $receivedUsers = $this->user_model->getSearchedUser($name); 

        $selections1 = array();

        foreach ($receivedUsers as $key => $value) {
            $selections1[$key]['label'] = $value->name;
            $selections1[$key]['theValue'] = $value->userId;
            $selections1[$key]['theEmail'] = $value->email; 
    }

        echo json_encode($selections1);
    }

    public function getUserLots(){
        $lotId = $this->input->post('lotId');

        $this->load->model('lotupload_model');
        $result = $this->lotupload_model->getAssignedLots($lotId);
        echo json_encode($result);
    }

    public function userDashboard()
    {
        $this->global['pageTitle'] = 'LANDHUB PORTAL : Dashboard';

        require_once(FCPATH.'application/libraries/zoho/config.php');
        require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
        $this->load->model('Zoho_access');
        $this->load->library('pagination');
        
        $zohoAuth = new zohoClass();
        $access_token = $this->Zoho_access->generate_access_token();
        
        $config=[
            'base_url' => base_url('user/userDashboard'),
            'per_page' =>10,
            'total_rows' => 1000,
            'first_link' => False,
            'last_link' => False,
            'display_pages' => False,
            'full_tag_open'=>"<ul class='pagination'>",
            'full_tag_close'=>"</ul>",
            'cur_tag_open' =>"<a>",
            'cur_tag_close' =>"</a>"
        ];
        
        $offset='';
        if($this->uri->segment(3)==''){
            $offset=0;
        }else{
            $offset=$this->uri->segment(3);
        }

        $dealsList = array();
        $userName = $this->session->userdata('email');
        $getDealsQuery = "select Lot, Estate, Lot_Stage, Stage, Individual_Names
            FROM Deals
            WHERE (Individual_2_Name.Email = '$userName')
            AND (Stage != 'Settled'
            AND Stage != 'Opportunity Lost')
            LIMIT ".$offset.",".$config['per_page'];

        $postData['select_query'] = $getDealsQuery;
        $deals = $zohoAuth->queryModule($access_token, json_encode($postData));

        if (!empty($deals)) {
            foreach ($deals->data as $deal) {
                
                $lot = $zohoAuth->getModuleRecord($access_token, 'Lots', $deal->Lot->id);
                    
                if (!empty($lot)) {
                    $getStageQuery = "SELECT Actual_Start_Date,
                        Drainage_Completed, Sewer_Completed,
                        Water_Gas_Completed, Power_NBN_Completed,
                        Pavements_Completed, Concrete_Works_Completed,
                        Topsoiling_Completed, Linemarking_Signage_Completed,
                        Earthworks_Completed, Registration_Date
                        FROM STAGES WHERE Name = '".$lot->data[0]->Lot_Stage."'";
                    
                    $postData['select_query'] = $getStageQuery;
                    $stage = $zohoAuth->queryModule($access_token, json_encode($postData));
                    
                    if (!empty($stage)) {
                        $deal->lot = $lot->data[0];
                        $deal->stage = $stage->data[0];
                        
                        $progress = new stdClass();
                        $progress->concreteWorks = $this->getConstructionProgress($stage->data[0]->Concrete_Works_Completed);
                        $progress->pavements = $this->getConstructionProgress($stage->data[0]->Pavements_Completed);
                        $progress->power = $this->getConstructionProgress($stage->data[0]->Power_NBN_Completed);
                        $progress->topsoiling = $this->getConstructionProgress($stage->data[0]->Topsoiling_Completed);
                        $progress->drainage = $this->getConstructionProgress($stage->data[0]->Drainage_Completed);
                        $progress->waterGas = $this->getConstructionProgress($stage->data[0]->Water_Gas_Completed);
                        $progress->sewer = $this->getConstructionProgress($stage->data[0]->Sewer_Completed);
                        $progress->earthworks = $this->getConstructionProgress($stage->data[0]->Earthworks_Completed);
                        $progress->linemarking = $this->getConstructionProgress($stage->data[0]->Linemarking_Signage_Completed);
                        $progress->startDate = $this->getConstructionProgress($stage->data[0]->Actual_Start_Date);
                        
                        $progress->completion = 100 * ((
                            $progress->concreteWorks + $progress->pavements + $progress->power + $progress->topsoiling + $progress->drainage
                            + $progress->waterGas + $progress->sewer + $progress->earthworks + $progress->linemarking + $progress->startDate) / 100);
                        
                        $deal->progress = $progress;
                        
                        $dealsList[] = $deal;
                    }
                }
            }
        }
        
        if (count($dealsList) < $config['per_page']) {
            $config['total_rows'] = $offset;
        }
        
        $this->pagination->initialize($config);

        $isBuildContractAdmin = $this->isBuildContractAdmin();
        $isStandardUser = $this->isStandardUser();
        
        $this->loadViews("dashboard", $this->global, [
                'deals' => $dealsList,
                'isBuildContractAdmin' => $isBuildContractAdmin,
                'isStandardUser' => $isStandardUser,
            ],
            NULL
        );
    }
    
    public function adminDashboard()
    {
        $this->load->library('pagination');
        $config=[
                'base_url' => base_url('user/adminDashboard'),
                'per_page' =>10,
                'total_rows' => 1000,
                'first_link' => False,
                'last_link' => False,
                'full_tag_open'=>"<ul class='pagination'>",
                'full_tag_close'=>"</ul>",        
                'cur_tag_open' =>"<a>",
                'cur_tag_close' =>"</a>"
        ];
        
        $offset='';
        if($this->uri->segment(3)==''){
            $offset=0;
        }else{
            $offset=$this->uri->segment(3);
        }
        
        $this->global['pageTitle'] = 'LANDHUB PORTAL : Dashboard';
        
        require_once(FCPATH.'application/libraries/zoho/config.php');
        require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
        $this->load->model('Zoho_access');
        
        $zohoAuth = new zohoClass();
        $access_token = $this->Zoho_access->generate_access_token();
      
        $dealsList = array();
        $userName = $this->session->userdata('name');
        
        $getDealsQuery = "select Lots, Stage, Individual_Names FROM Deals WHERE Individual_Names is not null AND (Stage != 'Settled' AND Stage != 'Opportunity Lost') LIMIT ".$offset.",".$config['per_page'];
        $postData['select_query'] = $getDealsQuery;
        $deals = $zohoAuth->queryModule($access_token, json_encode($postData));
        //file_put_contents("debug_coql_11_11_2020.txt","\n".print_r($deals ,true),FILE_APPEND);
        /*echo "<pre>";
        print_r($deals);
        die;*/
        if (!empty($deals)) {
            foreach ($deals->data as $deal) {
                
                $dealLots = explode(',', $deal->Lots);
                
                foreach ($dealLots as $dealLot) {
                    $getLotQuery = "select INTEGRA_PROJECTS.Name AS Estate, Developer_Approval_Required, Street_Address, Lot_No, Lot_Stage FROM LOTS WHERE Name = '".$dealLot."'";
                    $postData['select_query'] = $getLotQuery;
                    $lot = $zohoAuth->queryModule($access_token, json_encode($postData));
                    
                    if (!empty($lot)) {
                        $deal->lot = $lot->data[0];
                        $dealsList[] = $deal;
                    }
                }
            }
        }
        
        $this->pagination->initialize($config);
        $isBuildContractAdmin = $this->isBuildContractAdmin();

        $this->loadViews("dashboard", $this->global, [
            'deals' => $dealsList,
            'isBuildContractAdmin' => $isBuildContractAdmin
            ],
            NULL
        );
    }
    
    /**
     * This function is used to load the user list
     */
    function userListing()
    {
        if (($this->isAdmin() == False) && ($this->isManager() == False)) {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $this->load->library('pagination');
           
            $data['searchText'] = '';
            
            if (!empty($this->input->post('searchText'))) {
                $data['searchText'] = $this->input->post('searchText');
            }
           
            switch ($this->session->userdata('role')) {
                case ROLE_ADMIN:
                    $data['userRecords'] = $this->user_model->userListingAll();
                    break;
                    
            }
            
            $this->global['pageTitle'] = 'LANDHUB PORTAL : User Listing';
            
            $this->loadViews("users", $this->global, $data, NULL);
        }
    }

    function getLotsData() 
    {
        $est = $_GET['est'];

        $this->load->model('lotupload_model');
        $retrievedEstate = $this->lotupload_model->getEstate($est);
        
        foreach($retrievedEstate as $value){
            $estName = $value->estate_name;
        }

        $retrievedLots = $this->lotupload_model->getLotEstMatch($estName);
        $lotsArray = array();


        foreach($retrievedLots as $key => $value){
            $lotsArray[$key]['label'] = $value->lot_no;
            //$lotsArray[$key]['theValue'] = $value->id;
            $lotsArray[$key]['theValue'] = $value->lot_no;
         }

        echo json_encode($lotsArray);        


    }

    function getEstatesData() 
    {
        $this->load->model('lotupload_model');
        $retrievedEstates = $this->lotupload_model->getEstates();
        echo json_encode($retrievedEstates);
    }

    function getAllMyLots(){
        $userId = $_GET['userId'];
        $this->load->model('lotupload_model');
        $retrievedOwns = $this->lotupload_model->getUserLots($userId);

        $ownsArray = array();
        foreach($retrievedOwns as $key => $value){
                $ownsArray[$key]['id'] = $value->id;
                  $ownsArray[$key]['Lot_Id'] = $value->lot_id;
                  $ownsArray[$key]['Lot_No'] = $value->lot_no; 
                  $ownsArray[$key]['Estate'] = $value->lot_estate; 
                   $ownsArray[$key]['Lot_Stage'] = $value->lot_stage;   
        }
        echo json_encode($ownsArray);
    }

    function getSelectedLotData() 
    {
        $lot_no = $_GET['lot_no'];
        $estId = $_GET['estId'];
        $userId = $_GET['userId'];
       
       $this->load->model('lotupload_model');
        $retrievedEstate = $this->lotupload_model->getEstate($estId);
        
        foreach($retrievedEstate as $value){
            $estName = $value->estate_name;
        }

      $retrievedLots = $this->lotupload_model->getSearchedLot($lot_no, $estName);

        $lotsArray = array();

        foreach($retrievedLots as $key => $value){
                $lotsArray[$key]['id'] = $value->id;
                $lotsArray[$key]['Lot_No'] = $value->lot_no; 
                $lotsArray[$key]['Estate'] = $value->lot_estate; 
                $lotsArray[$key]['Lot_Stage'] = $value->lot_stage;   

                 $getMatch = $this->lotupload_model->getExistingLots($value->lot_no, $userId);
                 $getUsers = $this->lotupload_model->getThisUser($userId);
                 if(empty($getMatch)){
                    //$lotsArray[$key]['User_ID'] = $value->lot_id;
                        foreach($getUsers as $gu){
                            $lotsArray[$key]['User_ID'] = $gu->userId;
                            $lotsArray[$key]['Available_Lot'] = 0;
                        }
                 } else {
                     foreach($getMatch as $value){
                        foreach($getUsers as $gu){
                            $lotsArray[$key]['User_ID'] = $gu->userId;
                            $lotsArray[$key]['Unassign_Id'] = $value->id;
                            $lotsArray[$key]['Available_Lot'] = 1;
                        }
                     }
                 }   
        }
            //echo json_encode($retrievedLots);
        echo json_encode($lotsArray);
    
    }

    

    function assignLotToUser(){
        if (($this->isAdmin() == False) && ($this->isManager() == False)) {
            $this->loadThis();
        } else {
            $lot_id = $this->input->post('lot_id');
            $lot_no = $this->input->post('lot_no');
            $lot_estate = $this->input->post('lot_estate');
            $lot_stage = $this->input->post('lot_stage');
                
                $assignInfo = array('lot_id'=>$lot_id, 'lot_no'=>$lot_no, 'lot_estate'=>$lot_estate, 'lot_stage'=>$lot_stage);
                $this->load->model('lotupload_model');
                $result = $this->lotupload_model->saveLotAssignment($assignInfo);
                
            redirect('userListing');
        }
    }

    function deleteLotfromUser()
    {
        $lot_id = $this->input->post('lot_id');

            $this->load->model('lotupload_model');
           //$assignInfo = array('lot_id'=>$lot_id, 'lot_no'=>$lot_no, 'lot_estate'=>$lot_estate, 'lot_stage'=>$lot_stage);
          // $result = $this->lotupload_model->removeLotAssignment($lot_id, $assignInfo);
          $result = $this->lotupload_model->removeLotAssignment($lot_id);
      
    }
    
   
    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        $this->load->helper('form');
        
        if (($this->isAdmin() == False) && ($this->isManager() == False)) {
            $this->loadThis();
        }
        else {
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRolesByManagement($this->session->userdata('role'));
            
            $this->global['pageTitle'] = 'LANDHUB PORTAL : Add New User';

            $this->loadViews("addNew", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
        if (($this->isAdmin() == False) && ($this->isManager() == False)) {
            $this->loadThis();
        }
        else {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Contact Number','min_length[10]|xss_clean');
            $this->form_validation->set_rules('company','Company','trim|max_length[128]|xss_clean');
            
            if (!empty($this->user_model->checkEmailExists($this->input->post('email')))) {
                $this->session->set_flashdata('error', 'Email already taken');
                redirect('userListing');
                return;
            }
            
            if($this->form_validation->run() == FALSE) {
                $this->addNew();
            }
            else {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');
                $company = $this->input->post('company');
                
                if ((ROLE_PURCHASER == $roleId ) || (ROLE_BUILDER == $roleId) || (ROLE_CONTRACTOR == $roleId)) {
                    require_once(FCPATH.'application/libraries/zoho/config.php');
                    require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
                    $this->load->model('Zoho_access');
                    $zohoAuth = new zohoClass();
                    
                    $access_token = $this->Zoho_access->generate_access_token();
                    $user = $zohoAuth->searchModule($access_token, 'Contacts', "(Email:equals:$email)");
                    
                    if (empty($user)) {
                        $this->session->set_flashdata('error', 'For client and builders, please create a user in Zoho first.');
                        $this->addNew();
                        return;
                    }
                }
                
                $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId, 'name'=> $name,
                    'mobile'=>$mobile,'company'=>$company,'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                
                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);
                
                if ($result > 0) {
                   $userInfo["password"] = $password;
                    $this->sendNotificationEmail($userInfo);
                    
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else {
                    $this->session->set_flashdata('error', 'User creation failed');
                }
                
                redirect('userListing');
            }
        }
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = null)
    {
        if (($this->isAdmin() == False) && ($this->isManager() == False)) {
            $this->loadThis();
        }
        else {
            if ($userId == null) {
                $userId = $this->session->userdata('userId');
            }
            
            $data['roles'] = $this->user_model->getUserRolesByManagement($this->session->userdata('role'));
            $data['userInfo'] = $this->user_model->getUserInfo($userId);
            
            $this->global['pageTitle'] = 'LANDHUB PORTAL : Edit User';
            
            $this->loadViews("editOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        if (($this->isAdmin() == False) && ($this->isManager() == False)) {
            $this->loadThis();
        }
        else {
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]|xss_clean');
            $this->form_validation->set_rules('company','Company','trim|max_length[128]|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('fname')));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');
                $company = $this->input->post('company');
                
                $userInfo = array();
                
                if(empty($password))
                {
                    $userInfo = array('roleId'=>$roleId, 'name'=>$name,
                                    'mobile'=>$mobile, 'company'=>$company, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                    
                    $result = $this->user_model->editUser($userInfo, $userId);
                }
                else
                {
                    $userInfo = array('password'=>getHashedPassword($password), 'roleId'=>$roleId,
                        'name'=>ucwords($name), 'mobile'=>$mobile, 'company'=>$company, 'updatedBy'=>$this->vendorId, 
                        'updatedDtm'=>date('Y-m-d H:i:s'));
                    
                    $result = $this->user_model->editUser($userInfo, $userId);
                    
                    $userInfo["password"] = $password;
                    $this->sendNotificationEmail($userInfo);
                }
                
                if ($result == true) {
                    $this->session->set_userdata('name',$name);
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
                
                switch ($this->session->role) {
                    case ROLE_ADMIN:
                        redirect('userListing');
                        break;
                    
                    default:
                        redirect("editOld/$userId");
                        break;
                }
            }
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        if (($this->isAdmin() == False) && ($this->isManager() == False)) {
            echo(json_encode(array('status'=>'access')));
        }
        else {
            $userId = $this->input->post('userId');
            $userInfo = array(
                'deleted_at'=>date('Y-m-d H:i:s'),
                'updatedBy'=>$this->vendorId,
                'updatedDtm'=>date('Y-m-d H:i:s')
            );
            
            $result = $this->user_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = 'LANDHUB PORTAL : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
    
    private function sendNotificationEmail($user)
    {
        if (ENVIRONMENT == 'development') {
            return true;
        }
        
        $this->load->library('email');
        $this->email->from('noreply@integragroup.com.au', 'INTEGRA');
        $this->email->to($user['email']);
        
        $type = $this->getRoleTitle($user['roleId']);
        
        $this->email->subject('Your Landhub Account');
        $this->email->set_mailtype("html");
        $htmlBody = "<div style='font-family: Century Gothic;'><p>Dear ".$user["name"].",</p>
                <p>Your have been registered as a $type </p>
                <br/>
                <strong><u>Your Login Credentials</u></strong>
                    <p>
                        Login URL: ".base_url()."<br/>
                        Username: ".$user["email"]."<br/>
                        Password: ".$user["password"]."<br/>
                    </p>
                <br>
                </div>";
        
        $this->email->message($htmlBody);
        
        return $this->email->send();
    }
    
    private function getRoleTitle($roleID)
    {
        $type = '';
        
        switch ($roleID) {
            case ROLE_ADMIN:
                $type = "Administrator";
                break;
            case ROLE_PURCHASER:
                $type = "Purchaser";
                break;
            case ROLE_CONTRACTOR:
                $type = "Contractor";
                break;
            case ROLE_BUILDER:
                $type = "Builder";
                break;
        }
        
        return $type;
    }
    
    public function developerApproval()
    {
        if ((ROLE_PURCHASER != $this->session->userdata('role')) && (ROLE_BUILDER != $this->session->userdata('role')) && (ROLE_CONTRACTOR != $this->session->userdata('role'))){
            $this->builderDeveloperApproval();
        } else {
            $this->purchaseDeveloperApproval();
        }
    }
    
    public function builderDeveloperApproval()
    {
        require_once(FCPATH.'application/libraries/zoho/config.php');
        require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
        $this->load->model('Zoho_access');
        
        $zohoAuth = new zohoClass();
        $access_token = $this->Zoho_access->generate_access_token();
        
        $estates = $zohoAuth->listModuleData($access_token, 'INTEGRA_PROJECTS?sort_by=Name');
        $user = $this->user_model->getUserInfo($this->session->userdata('userId'));
        
        $this->global['pageTitle'] = 'LANDHUB PORTAL : Developer Approval Form';
        
        $this->loadViews("developer-approval", $this->global,
            array(
                'estates' => $estates->data,
                'user' => $user[0]
            ),
            NULL
            );
        
        /*
         echo '<pre>';
         print_r($estates);
         echo '</pre>';
         */
    }
    
    public function purchaseDeveloperApproval()
    {
        $this->global['pageTitle'] = 'LANDHUB PORTAL : Dashboard';
        
        require_once(FCPATH.'application/libraries/zoho/config.php');
        require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
        $this->load->model('Zoho_access');
        
        $zohoAuth = new zohoClass();
        $access_token = $this->Zoho_access->generate_access_token();
        
        $estateList = array();
        $lotList = array();
        
        $userName = $this->session->userdata('email');
        $getDealsQuery = "select Lot, Estate, Lot_Stage, Stage, Individual_Names
            FROM Deals
            WHERE (Individuals_Sinle_Lookup.Email = '$userName' OR Individual_2_Name.Email = '$userName')
            AND (Stage != 'Settled'
            AND Stage != 'Opportunity Lost')";
        
        $postData['select_query'] = $getDealsQuery;
        $deals = $zohoAuth->queryModule($access_token, json_encode($postData));
        
        if (!empty($deals)) {
            foreach ($deals->data as $deal) {
                $getLotQuery = "select INTEGRA_PROJECTS.Name AS Estate, Lot_Stage, Name FROM LOTS WHERE id = '".$deal->Lot->id."'";
                $postData['select_query'] = $getLotQuery;
                $lot = $zohoAuth->getModuleRecord($access_token, 'LOTS', $deal->Lot->id);
                
                if (!empty($lot)) {
                    if (!in_array($lot->data[0]->INTEGRA_PROJECTS->name, $estateList)) {
                        $estateList[] = $lot->data[0]->INTEGRA_PROJECTS->name;
                    }
                    
                    $ownedLot = new stdClass();
                    $ownedLot->id = $lot->data[0]->id;
                    $ownedLot->Name = $lot->data[0]->Name;
                    $ownedLot->Estate = $lot->data[0]->INTEGRA_PROJECTS->name;
                    $lotList[] = $ownedLot;
                }
            }
        }
        
        $user = $this->user_model->getUserInfo($this->session->userdata('userId'));
        $this->global['pageTitle'] = 'LANDHUB PORTAL : Developer Approval Form';
        
        $this->loadViews("developer-approval", $this->global,
            array(
                'estates' => $estateList,
                'lots' => $lotList,
                'user' => $user[0]
            ),
            NULL
        );
        
        /*
         echo '<pre>';
         print_r([$estateList, $lotList]);
         echo '</pre>';
         */
    }
    //this is the function for the developer approval estate to lot dropdown effect
    public function estateLotsSelection($estateID)
    {
        require_once(FCPATH.'application/libraries/zoho/config.php');
        require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
        $this->load->model('Zoho_access');
        
        $zohoAuth = new zohoClass();
        $access_token = $this->Zoho_access->generate_access_token();
        $lots = $zohoAuth->listModuleData($access_token, "INTEGRA_PROJECTS/$estateID/Lots?sort_by=Name");
        
        $selections = "<option value = ''> Choose one </option>";
        
        foreach ($lots->data as $lot) {
            $selections .= "<option data-lot-id = '".$lot->id."' value = '".$lot->Name."'>".$lot->Name."</option>";
        }
        
        echo $selections;
    }
    
    
    public function postDeveloperApproval()
    {
        $this->load->library('form_validation');
        
        $userId = $this->input->post('userId');
        
        $this->form_validation->set_rules('estate','Estate','required|xss_clean');
        $this->form_validation->set_rules('lot_number','Lot','required|xss_clean');
        $this->form_validation->set_rules('fname','Full Name','trim|required|xss_clean');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean');
        
        if ($this->form_validation->run() == FALSE) {
            $this->developerApproval();
        }
        else
        {
            $name = ucwords(strtolower($this->input->post('fname')));
            $email = $this->input->post('email');
            $estate = $this->input->post('estate');
            $lot = $this->input->post('lot_number');
            
            if (ENVIRONMENT != 'development') {
                
                
                $this->load->library('email');
                $this->email->from('noreply@integragroup.com.au', 'INTEGRA');
                $this->email->to('adam@integragroup.com.au');
                
                $htmlBody = "<div style='font-family: Century Gothic;'><p>Dear Admin,</p>
                    <p>Approval for the following has been requested </p>
                    <br/>
                    <strong><u>The following information has been submitted</u></strong>
                        <p>
                            <strong>Estate:</strong> $estate<br/>
                            <strong>Lot:</strong> $lot<br/>
                            <strong>Role:</strong> ".$this->getRoleTitle($this->session->userdata('role'))."<br/>
                            <strong>Name:</strong> $name<br/>
                            <strong>Email:</strong> $email<br/>
                        </p>
                    <br>
                    </div>";
                
                $this->email->subject('Developer Approval Request');
                $this->email->set_mailtype("html");
                $this->email->message($htmlBody);
                
                if (isset($_FILES['attachment'])) {
                    $uploadConfig['upload_path'] = './uploads/developer_approvals/';
                    $uploadConfig['allowed_types'] = '*';
                    
                    if (!file_exists($uploadConfig['upload_path'])) {
                        mkdir($uploadConfig['upload_path']);
                    }
                    
                    $this->load->library('upload', $uploadConfig);
                    
                    if ($this->upload->do_upload('attachment')) {
                        $fileData = $this->upload->data();
                        $this->email->attach($fileData['full_path']);
                    }
                    
                }
                
                $this->email->send();
            }
            
            
            $this->session->set_flashdata('success', 'Request has been sent');
            redirect('user/developerApproval');
        }
    }


    public function construction()
    {

        $this->loadViews("construction", $this->global,NULL,
        NULL
    );

    }

   
}


?>