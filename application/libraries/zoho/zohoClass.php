<?php
/*
* Date : 21 Nov 2019
* Zoho Class
*/
class zohoClass{
	public function generateAccessTokenByRefreshToken($refresh_token,$client_id,$client_secret,$redirect_uri)
	{
		$param = "refresh_token=$refresh_token&client_id=$client_id&client_secret=$client_secret&redirect_uri=$redirect_uri&grant_type=refresh_token";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://accounts.zoho.com.au/oauth/v2/token');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		$result = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($result);
		$created_date = date('Y-m-d H:i:s');
		/* $data = array(
               'access_token' => $response->access_token,
               'created_time' =>$created_date,
               'expiry_time' => $response->expiry_time,
            );

			$this->db->where('id', 1);
			$this->db->update('zoho_access', $data); */
		
		return $access_token = $response->access_token;
	}
	
	public function generateAccessToken($client_id,$client_secret,$redirect_uri)
	{
	    $param = "client_id=$client_id&client_secret=$client_secret&redirect_uri=$redirect_uri&grant_type=authorization_code&code=1000.d98fd1ac6e1dc372d097c39a1f2ef74f.211798f5a5be1b17730a107928d68be3";
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, 'https://accounts.zoho.com.au/oauth/v2/token');
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
	    $result = curl_exec($ch);
	    curl_close($ch);
	    $response = json_decode($result);
	    $created_date = date('Y-m-d H:i:s');
	    /* $data = array(
	     'access_token' => $response->access_token,
	     'created_time' =>$created_date,
	     'expiry_time' => $response->expiry_time,
	     );
	    
	     $this->db->where('id', 1);
	     $this->db->update('zoho_access', $data); */
	    return $response;
	}
	
	public function getAllmodules($access_token)
	{
	    $apiUrl = "https://www.zohoapis.com.au/crm/v2/settings/modules";
	    $headers = array(
	        'Content-Type: application/json',
	        'Authorization: Zoho-oauthtoken '.$access_token
	    );
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $apiUrl);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	    $result = curl_exec($ch);
	    $response = json_decode($result);
	    curl_close($ch);
	    return $response; 
	}
	
	public function searchModule($access_token, $module, $criteria)
	{
	    $apiUrl = "https://www.zohoapis.com.au/crm/v2/$module/search?criteria=$criteria";
	    
	    $headers = array(
	        'Content-Type: application/json',
	        'Authorization: Zoho-oauthtoken '.$access_token
	    );
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $apiUrl);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	    $result = curl_exec($ch);
	    $response = json_decode($result);
	    curl_close($ch);
	    return $response;
	}
	
	public function queryModule($access_token, $query)
	{
	    $apiUrl = "https://www.zohoapis.com.au/crm/v2/coql";
	    
	    $headers = array(
	        'Content-Type: application/x-www-form-urlencoded',
	        'Content-Length: ' .strlen($query),
	        sprintf('Authorization: Zoho-oauthtoken %s', $access_token)
	    );
	    
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $apiUrl);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    $result = curl_exec($ch);
	    $response = json_decode($result);
	    curl_close($ch);
	    return $response;
	}
	
	public function getModuleRecord($access_token, $module, $id)
	{
	    $apiUrl = "https://www.zohoapis.com.au/crm/v2/$module/$id";
	    
	    $headers = array(
	        'Content-Type: application/json',
	        'Authorization: Zoho-oauthtoken '.$access_token
	    );
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $apiUrl);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	    $result = curl_exec($ch);
	    $response = json_decode($result);
	    curl_close($ch);
	    return $response;
	}
	
	public function listModuleData($access_token, $module)
	{
	    $apiUrl = "https://www.zohoapis.com.au/crm/v2/$module";
	    
	    $headers = array(
	        'Content-Type: application/json',
	        'Authorization: Zoho-oauthtoken '.$access_token
	    );
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $apiUrl);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	    $result = curl_exec($ch);
	    $response = json_decode($result);
	    curl_close($ch);
	    return $response;
	}
}
?>