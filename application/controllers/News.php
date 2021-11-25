<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Mailbox (UserController)
 * Class that processes /mailbox/ URIs
 * @author : Ruffy Collado
 * @version : 1.1
 * @since : 31 August 2020
 */
class News extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('News_model');
        $this->isLoggedIn();
    }
    
    public function index()
    {	
        $lucasBallaratNews=$this->News_model->GetlucasBallaratNews();
        $lucasIntegraNews=$this->News_model->GetIntegraGroupNews();
       	$AllNews=array_merge($lucasBallaratNews,$lucasIntegraNews);
       	/*echo "<pre>";
       	print_r($lucasBallaratNews);
       	echo "<pre>";
       	print_r($lucasIntegraNews);
       	echo "<pre>";
       	print_r(array_merge($lucasBallaratNews,$lucasIntegraNews));*/
        //die;
        $this->global['pageTitle'] = 'LANDHUB PORTAL : Dashboard';
        $this->loadViews("news/news", $this->global,[
                'all_news' => array_merge($lucasBallaratNews,$lucasIntegraNews),
                'lucasBallaratNews' => $lucasBallaratNews,
                'lucasIntegraNews' => $lucasIntegraNews,
            ]);
    }
}