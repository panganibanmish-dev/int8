<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class News_model extends CI_Model
{
    //www.lucasballarat.com.au/post/rss.xml
	//www.integragroup.com.au/post/rss.xml

	public function GetAllNews(){
    	
        
    }

    public function GetlucasBallaratNews()
    {
        require_once(FCPATH.'application/libraries/rss_feed/RSSFeed.php');
        $RSSFeedV = new RSSFeed();
        $url="www.lucasballarat.com.au/post/rss.xml";
        $responseBallarat=$RSSFeedV->GetlucasBallaraNews($url);
        if(isset($responseBallarat['channel']['item'])){
        	return $responseBallarat['channel']['item'];
        }else{
        	return "";
        }
    }

    public function GetIntegraGroupNews()
    {
        require_once(FCPATH.'application/libraries/rss_feed/RSSFeed.php');
        $RSSFeedV = new RSSFeed();
        $url="www.integragroup.com.au/post/rss.xml";
        $responseIntegra=$RSSFeedV->GetIntegraNews($url);
        if(isset($responseIntegra['channel']['item'])){
        	return $responseIntegra['channel']['item'];
        }else{
        	return "";
        }
    }

   
}