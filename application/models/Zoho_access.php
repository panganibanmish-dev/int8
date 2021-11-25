<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Zoho_access extends CI_Model
{

    function __construct() 
    { 
          
         parent::__construct(); 
         
    } 

   	public function generate_access_token($token_type='crm')
    {
        require_once(FCPATH.'application/libraries/zoho/config.php');
        require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
        $zohoAuth = new zohoClass();
        $this->db->select('*');
        $this->db->from('zoho_access');
        $this->db->where('token_type',$token_type);
        $query = $this->db->get();
      	$result = $query->result();
        $current_time = date("Y-m-d H:i:s");
        if(!empty($result)){
            if(strtotime($current_time) < strtotime($result[0]->expiry_time)){
                $access_token = $result[0]->access_token;
            }else{
                $access_token = $zohoAuth->generateAccessTokenByRefreshToken($result[0]->refresh_token,CLIENT_ID,CLIENT_SECRET,REDIRECT_URI);
                $this->db->update("zoho_access",array('token_type'=>$token_type,'access_token'=>$access_token,'created_time'=>$current_time,'expiry_time'=>date("Y-m-d H:i:s",strtotime('+1 hour',strtotime($current_time)))),array('id'=>$result[0]->id));
            }
        }else{
            $access_token = $zohoAuth->generateAccessToken(CLIENT_ID,CLIENT_SECRET,REDIRECT_URI);
            $this->db->insert("zoho_access",array('token_type'=>$token_type,'access_token'=>$access_token->access_token,'refresh_token'=>$access_token->refresh_token,'created_time'=>$current_time,'expiry_time'=>date("Y-m-d H:i:s",strtotime('+1 hour',strtotime($current_time)))));
        }
        return $access_token;
    }
}