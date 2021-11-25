<?php
/*
* Date : 21 Nov 2019
* Zoho Class
*/
class ZohoDeskClass{

	public function generateAccessTokenByRefreshToken($refresh_token,$client_id,$client_secret,$redirect_uri,$scope,$grant_type)
	{
		   $url="https://accounts.zoho.com.au/oauth/v2/token?refresh_token=$refresh_token&client_id=$client_id&client_secret=$client_secret&redirect_uri=$redirect_uri&grant_type=$grant_type&scope=$scope";
			$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_TIMEOUT,30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            $curlCallResponse = curl_exec($ch);           
			$created_date = date('Y-m-d H:i:s');
			if(isset(json_decode($curlCallResponse,true)['access_token'])){
				return json_decode($curlCallResponse,true)['access_token'];
			}else{
				return "";
			}
			
	}
	
	public function GetAllTickets($access_token,$apiUrl)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch,CURLOPT_HTTPHEADER, array(
		"Authorization: "."Zoho-oauthtoken ".$access_token));
		$result = curl_exec($ch);
		return $result; 
	}
	public function GetTicketsByUserId($access_token,$apiUrl)
	{
	   $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch,CURLOPT_HTTPHEADER, array(
		"Authorization: "."Zoho-oauthtoken ".$access_token));
		$result = curl_exec($ch);
		return $result; 
	}

	public function CreateTicketsByUserId($access_token,$apiUrl,$ticketBody)
	{

	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL,$apiUrl);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
       curl_setopt($ch, CURLOPT_TIMEOUT,30);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($ticketBody));
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
       curl_setopt($ch,CURLOPT_HTTPHEADER, array(
       "Authorization: "."Zoho-oauthtoken ".$access_token));
       $response = curl_exec($ch);
       return $response;
	}
	public function UpdateTicketsByUserId($access_token,$apiUrl)
	{
	    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch,CURLOPT_HTTPHEADER, array(
		"Authorization: "."Zoho-oauthtoken ".$access_token));
		$result = curl_exec($ch);
		return $result; 
	}

	public function GetListOfDepartment($access_token,$apiUrl){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch,CURLOPT_HTTPHEADER, array(
		"Authorization: "."Zoho-oauthtoken ".$access_token));
		$departmentRes = curl_exec($ch);
		return $departmentRes; 
	}
	
	public function SearchContactUsingEmail($access_token,$apiUrl){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch,CURLOPT_HTTPHEADER, array(
		"Authorization: "."Zoho-oauthtoken ".$access_token));
		$contactRes = curl_exec($ch);
		return $contactRes; 
	}
	
	public function CreateContactIfNotFoundInZohoDesk($access_token,$apiUrl,$ticketBody){
		$ch = curl_init();
       curl_setopt($ch, CURLOPT_URL,$apiUrl);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
       curl_setopt($ch, CURLOPT_TIMEOUT,30);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($ticketBody));
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
       curl_setopt($ch,CURLOPT_HTTPHEADER, array(
       "Authorization: "."Zoho-oauthtoken ".$access_token));
       $createContactRes = curl_exec($ch);
       return $createContactRes;
	}
	
	public function AddAgentInZohoDesk($access_token,$apiUrl,$ticketBody){
	    
	    $apiUrl="https://desk.zoho.com.au/api/v1/agents";
		$ch = curl_init();
       curl_setopt($ch, CURLOPT_URL,$apiUrl);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
       curl_setopt($ch, CURLOPT_TIMEOUT,30);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS,$ticketBody);
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
       "Authorization: "."Zoho-oauthtoken ".$access_token));
       $createAgentRes = curl_exec($ch);
/*       echo "<pre>=======Afgent Res===";
       print_r($createAgentRes);*/
       return $createAgentRes;
	}
	
	public function GetTicketById($access_token,$apiUrl){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch,CURLOPT_HTTPHEADER, array(
		"Authorization: "."Zoho-oauthtoken ".$access_token));
		$contactRes = curl_exec($ch);
		return $contactRes; 
	}
	public function GetContactList($access_token,$apiUrl){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch,CURLOPT_HTTPHEADER, array(
		"Authorization: "."Zoho-oauthtoken ".$access_token));
		$contactRes = curl_exec($ch);
		return $contactRes; 
	}
	
	//add comments
	public function AddCommentsByIdInZohoDesk($access_token,$apiUrl,$ticketBody){
	    
	    
		$ch = curl_init();
       curl_setopt($ch, CURLOPT_URL,$apiUrl);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
       curl_setopt($ch, CURLOPT_TIMEOUT,30);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS,$ticketBody);
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
       "Authorization: "."Zoho-oauthtoken ".$access_token));
       $addCommentRes = curl_exec($ch);
       return $addCommentRes;
	}
	
	
}
?>