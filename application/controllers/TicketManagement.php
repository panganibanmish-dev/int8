<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Mailbox (UserController)
 * Class that processes /mailbox/ URIs
 * @author : Ruffy Collado
 * @version : 1.1
 * @since : 31 August 2020
 */
class TicketManagement extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ticket_model');
        $this->isLoggedIn();
    }
    
    public function index()
    {
        $deskAccessToken=$this->Ticket_model->GenrateAccessToken();
        $this->load->model('user_model');
        $userDetailsInfo= $this->user_model->getZohoDeskUserId($this->session->userdata('userId'));

        //here we will get all ticket details
        $getAllTicket=$this->Ticket_model->GetAllTicketsUsingContactId($deskAccessToken,$userDetailsInfo[0]['zoho_user_id']);
        $this->global['pageTitle'] = 'LANDHUB PORTAL : Dashboard';
        $this->loadViews("ticket/ticket-list", $this->global,['tickets'=>$getAllTicket],NULL);
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
            
            $this->global['pageTitle'] = 'LANDHUB PORTAL : Add New Ticket';
            $this->loadViews("ticket/new-ticket", $this->global);
        }
    }

    public function CreateTicketInDesk(){
        
        $this->load->model('user_model');
        $userDetailsInfo= $this->user_model->getZohoDeskUserId($this->session->userdata('userId'));
        
        //here we will get department details
        $deskAccessToken=$this->Ticket_model->GenrateAccessToken();
       
        $departments=$this->GetListOfDepartment($deskAccessToken);
        
        if (($this->isAdmin() == False) && ($this->isManager() == False)) {
            $this->loadThis();
        }
        else {

            $this->load->library('form_validation');
            $this->form_validation->set_rules('subject','Subject','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('description','Message','trim|required|xss_clean');

            if($this->form_validation->run() == FALSE) {
                $this->addNew();
            }else {
               
                $TicketInfo = array(
                    'subCategory'=>"Sub General", 
                    'departmentId'=>$departments[0]['id'], 
                    'assigneeId' =>"", 
                    'subject'=> $this->input->post('subject'),
                    'channel'=>"Web",
                    'description'=>$this->input->post('description'),
                    'language'=>"English", 
                    'priority'=>"Medium", 
                    'classification'=>$this->input->post('classifications'), 
                    'phone'=> $userDetailsInfo[0]['mobile'],  
                    'category'=>"general",   
                    'email'=>$userDetailsInfo[0]['email'],  
                    'status'=>"Open",
                    );
            
                    //search contact by email
                    $zohoDeskContactId=$this->Ticket_model->SearchContactByEmail($deskAccessToken,$userDetailsInfo[0]['email']);
                
                    if($zohoDeskContactId==""){
                        $name=explode(' ',$userDetailsInfo[0]['name'],2);
                    if(isset($name[0])){
                        $firstName=$name[0];
                    }if(isset($name[1])){
                        $lastName=$name[1];
                    }if($lastName==""){
                        $lastName=$firstName;
                        $firstName="";
                    }
                    $contactInfoArr=Array(
                        'lastName'=>$lastName, 
                        'ownerId'=>$userDetailsInfo[0]['zoho_user_id'], 
                        'title'=>"The contact",
                        'firstName'=> $firstName,
                        'email'=> $userDetailsInfo[0]['email'],
                    );
                    $zohoDeskContactId=$this->Ticket_model->CreateContactIfNotFound($deskAccessToken,$contactInfoArr);
                    $TicketInfo['contactId']=$zohoDeskContactId; 
                }else{
                    $TicketInfo['contactId']=$zohoDeskContactId; 
                }
                $deskAccessToken=$this->Ticket_model->GenrateAccessToken();
    
                $result = $this->Ticket_model->CreateNewTicketInZohoDesk($TicketInfo,$deskAccessToken);
                
                if (isset(json_decode($result,true)['id'])) {
                    $this->session->set_flashdata('success', 'New Ticket created successfully');
                }else {
                   
                    $this->session->set_flashdata('error', 'Ticket creation failed');
                }              
                redirect('list-ticket');
            }
        }
    }

    //this function will return all department id from zoho desk
    public function GetListOfDepartment($deskAccessToken){
            $this->load->model('Ticket_model');
            return $this->Ticket_model->ListOfDepartment($deskAccessToken);
    }
     //this function will return ticket from zoho desk
    public function ViewTicket($Id){
            $deskAccessToken=$this->Ticket_model->GenrateAccessToken();
            $ticketData=$this->Ticket_model->ViewTicketById($deskAccessToken,$Id);
            $viewTicketcommentsdata=$this->Ticket_model->ViewTicketCommentsById($deskAccessToken,$Id);
           
            $commentsData=$viewTicketcommentsdata['data'];
           /* echo "<pre>";
            print_r($commentsData);
            die;*/
            $this->loadViews("ticket/view-ticket", $this->global,['ticketdata'=>$ticketData,'ticketcomments'=>$commentsData]);
    }
    
    //this function will return all department id from zoho desk
    public function AddCommentInTicket(){
        
            $deskAccessToken=$this->Ticket_model->GenrateAccessToken();
            $ticket_Id=$this->input->post('ticket_Id');
            
            $this->load->model('user_model');
            $userDetailsInfo= $this->user_model->getZohoDeskUserId($this->session->userdata('userId'));
            
            $content="From:".$userDetailsInfo[0]['name']."<br>".$this->input->post('description');
            
            $commentsBody='{
                            "isPublic" : "true",
                            "attachmentIds" : [],
                            "contentType" : "html",
                            "content" : "'.$content.'"
                        }';
            
            $addCommRes=$this->Ticket_model->AddCommentsById($deskAccessToken,$ticket_Id,$commentsBody);

            if (isset($addCommRes['id'])) {
                    $this->session->set_flashdata('success', 'Comments added successfully');
            }else {
                    $this->session->set_flashdata('error', 'Comments creation failed');
            }
            redirect("TicketManagement/ViewTicket/$ticket_Id");
    }

}