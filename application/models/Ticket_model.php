<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Ticket_model extends CI_Model
{

    function __construct() 
    {  
         parent::__construct();
    } 


   	public function GenrateAccessToken($token_type='desk')
    {
    	require_once(FCPATH.'application/libraries/zohodesk/config.php');
        require_once(FCPATH.'application/libraries/zohodesk/ZohoDeskClass.php');
        $zohoDeskAuth = new ZohoDeskClass();

        $this->db->select('*');
        $this->db->from('desk_access');
        $this->db->where('token_type',$token_type);
        $query = $this->db->get();
        $result = $query->result();
        $current_time = date("Y-m-d H:i:s");

        if(!empty($result)){
            if(strtotime($current_time) < strtotime($result[0]->expiry_time)){
                $access_token = $result[0]->access_token; 
            }else{
                $access_token = $zohoDeskAuth->generateAccessTokenByRefreshToken($result[0]->refresh_token,CLIENT_ID,CLIENT_SECRET,REDIRECT_URI,SCOPE,GRANT_TYPE);
                $this->db->update("desk_access",array('token_type'=>$token_type,'access_token'=>$access_token,'created_time'=>$current_time,'expiry_time'=>date("Y-m-d H:i:s",strtotime('+1 hour',strtotime($current_time)))),array('Id'=>$result[0]->id));
            }
        }
        return $access_token;
    }

    public function GetAllTickets($deskToken){
        require_once(FCPATH.'application/libraries/zohodesk/ZohoDeskClass.php');
        $zohoDeskAuth = new ZohoDeskClass();
        $desk_url="https://desk.zoho.com.au/api/v1/tickets?include=contacts,assignee,departments,team,isRead";
        return $zohoDeskAuth->GetAllTickets($deskToken,$desk_url);
    }

    public function GetAllTicketsUsingContactId($deskAccessToken,$zohoDeskUserId){
        require_once(FCPATH.'application/libraries/zohodesk/ZohoDeskClass.php');
        $zohoDeskAuth = new ZohoDeskClass();
        //$desk_url="https://desk.zoho.com.au/api/v1/tickets?from=0&limit=1";
        $desk_url="https://desk.zoho.com.au/api/v1/tickets?from=0&limit=100";
        $res=json_decode($zohoDeskAuth->GetTicketsByUserId($deskAccessToken,$desk_url),true);
        $tictketsArrayInfo=Array();
        if(isset($res['data'][0])){
            foreach($res['data'] as $ticketsValue){
                if($zohoDeskUserId==$ticketsValue['contactId']){
                    $tickketArrayV=Array(
                            'id'=> $ticketsValue['id'], 
                            'ticketNumber'=> $ticketsValue['ticketNumber'], 
                            'email'=> $ticketsValue['email'], 
                            'phone'=> $ticketsValue['phone'], 
                            'subject'=> $ticketsValue['subject'], 
                            'createdTime'=> $ticketsValue['createdTime'], 
                            'priority'=> $ticketsValue['priority'], 
                            'departmentId'=> $ticketsValue['departmentId'], 
                            'contactId'=> $ticketsValue['contactId'], 
                            'assigneeId'=> $ticketsValue['assigneeId'], 
                            'status'=> $ticketsValue['status'], 
                    );
                    array_push($tictketsArrayInfo,$tickketArrayV);
                }
            }
        }
        return $tictketsArrayInfo;
        /*echo "<pre>";
        print_r($tictketsArrayInfo);
        die;*/
    }
    public function CreateNewTicketInZohoDesk($ticketBody,$deskToken){
        require_once(FCPATH.'application/libraries/zohodesk/ZohoDeskClass.php');
        $zohoDeskAuth = new ZohoDeskClass();
        $desk_url="https://desk.zoho.com.au/api/v1/tickets";
        return $zohoDeskAuth->CreateTicketsByUserId($deskToken,$desk_url,$ticketBody);
    }
    // get all department details.
    public function ListOfDepartment($deskToken){
        require_once(FCPATH.'application/libraries/zohodesk/ZohoDeskClass.php');
        $zohoDeskAuth = new ZohoDeskClass();
        $desk_url="https://desk.zoho.com.au/api/v1/departments?isEnabled=true&chatStatus=AVAILABLE";
        return json_decode($zohoDeskAuth->GetListOfDepartment($deskToken,$desk_url),true)['data'];
    } 

    public function SearchContactByEmail($deskToken,$email){
        require_once(FCPATH.'application/libraries/zohodesk/ZohoDeskClass.php');
        $zohoDeskAuth = new ZohoDeskClass();
        $desk_url="https://desk.zoho.com.au/api/v1/contacts/search?limit=1&email=".$email;
        $contactSearchRes=json_decode($zohoDeskAuth->SearchContactUsingEmail($deskToken,$desk_url),true);
        
        if(isset($contactSearchRes['data'][0])){
            $data = [
            'zoho_user_id' => $contactSearchRes['data'][0]['id'],
            ];
            $this->db->where('email',$contactSearchRes['data'][0]['email']);
            $this->db->update('tbl_users', $data);
           
            return $contactSearchRes['data'][0]['id'];
        }else{
            return "";
        }
    }
    
    // serch Ajent Information In Zoho desk 
    public function SearchAjentInZohoDesk($deskToken,$email){
        require_once(FCPATH.'application/libraries/zohodesk/ZohoDeskClass.php');
        $zohoDeskAuth = new ZohoDeskClass();
        $desk_url="https://desk.zoho.com.au/api/v1/agents";
        $ajentRes=json_decode($zohoDeskAuth->GetAjentList($deskToken,$desk_url),true);
        
        if(isset($ajentRes['data'][0])){
            foreach($ajentRes['data'] as $ajentValue){
                if($ajentValue['emailId']==$email){
                    return $ajentValue['id'];
                }
            }
        }
        return "";
    }
    
    public function CreateContactIfNotFound($deskToken,$ticketBody){
        require_once(FCPATH.'application/libraries/zohodesk/ZohoDeskClass.php');
        $zohoDeskAuth = new ZohoDeskClass();
        $desk_url="https://desk.zoho.com.au/api/v1/contacts";
        $contactCreateRes=json_decode($zohoDeskAuth->CreateContactIfNotFoundInZohoDesk($deskToken,$desk_url,$ticketBody),true);
       
        if(isset($contactCreateRes['id'])){
            $data = [
            'zoho_user_id' => $contactCreateRes['id'],
            ];
           /* echo "<pre>";
            print_r($data);
            die;*/
            $this->db->where('email',$contactCreateRes['email']);
            $this->db->update('tbl_users', $data);
           
            return $contactCreateRes['id'];
        }else{
            return "";
        }
    }
    
    public function ViewTicketById($deskToken,$Id){
        require_once(FCPATH.'application/libraries/zohodesk/ZohoDeskClass.php');
        $zohoDeskAuth = new ZohoDeskClass();
        $desk_url="https://desk.zoho.com.au/api/v1/tickets/".$Id."?include=contacts,products,assignee,departments,team";
        return json_decode($zohoDeskAuth->GetTicketById($deskToken,$desk_url),true);
    }
    
    //NEW CHANGES
    public function ViewTicketCommentsById($deskToken,$Id){
        
        require_once(FCPATH.'application/libraries/zohodesk/ZohoDeskClass.php');
        $zohoDeskAuth = new ZohoDeskClass();
        $desk_url="https://desk.zoho.com.au/api/v1/tickets/".$Id."/conversations";
        return json_decode($zohoDeskAuth->GetTicketById($deskToken,$desk_url),true);
    }
    
    // add comments in tickets.
    public function AddCommentsById($deskToken,$Id,$data){
        
        require_once(FCPATH.'application/libraries/zohodesk/ZohoDeskClass.php');
        $zohoDeskAuth = new ZohoDeskClass();
        $desk_url="https://desk.zoho.com.au/api/v1/tickets/".$Id."/comments";
        return json_decode($zohoDeskAuth->AddCommentsByIdInZohoDesk($deskToken,$desk_url,$data),true);
    }
    
    
    //add new user information
    //NEW CHANGES
    public function CreateAgentInZohoDesk($deskToken,$data){
        
        require_once(FCPATH.'application/libraries/zohodesk/ZohoDeskClass.php');
        $zohoDeskAuth = new ZohoDeskClass();
        $desk_url="https://desk.zoho.com.au/api/v1/agents";
        
        $agentAddRes= json_decode($zohoDeskAuth->AddAgentInZohoDesk($deskToken,$desk_url,$data),true);
        
        if(isset($agentAddRes['id'])){
          $data = [
            'zoho_user_id' => $agentAddRes['id'],
            ];
            $this->db->where('email',$agentAddRes['emailId']);
            $this->db->update('tbl_users', $data); 
            return $agentAddRes['id'];
        }else{
            return "";
        }
    }
    
    
}