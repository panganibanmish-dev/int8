<?php
/*
* Date : 21 Nov 2019
* Zoho Class
*/
class RSSFeed{

	
	
	public function CallForAllNews($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		return $result; 

	}
	public function GetIntegraNews($url)
	{
	    $curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_SSL_VERIFYPEER=> FALSE,
		  CURLOPT_SSL_VERIFYHOST=> FALSE,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		));

		$response=curl_exec($curl);
		curl_close($curl);
		$replace1=str_replace('<media:content url="',"<imageLink>",$response);
		$replace2=str_replace('" medium="image"/>',"</imageLink>",$replace1);
		$xml =simplexml_load_string($replace2);
		$json = json_encode($xml);
		
		return json_decode($json,TRUE);
		
	}

	public function GetlucasBallaraNews($url)
	{
	    $curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_SSL_VERIFYPEER=> FALSE,
		  CURLOPT_SSL_VERIFYHOST=> FALSE,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		));

		$response=curl_exec($curl);
		curl_close($curl);
		$replace1=str_replace('<media:content url="',"<imageLink>",$response);
		$replace2=str_replace('" medium="image"/>',"</imageLink>",$replace1);
		$xml = simplexml_load_string($replace2);
		$json = json_encode($xml);
		return json_decode($json,TRUE);
		
	}
	
	
}
?>