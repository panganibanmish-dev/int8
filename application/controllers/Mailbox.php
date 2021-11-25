<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Mailbox (UserController)
 * Class that processes /mailbox/ URIs
 * @author : Ruffy Collado
 * @version : 1.1
 * @since : 31 August 2020
 */
class Mailbox extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mailbox_model');
        $this->isLoggedIn();
    }
    
    public function index()
    {
        $this->load->model('User_model');
        
        $this->data['receivers'] = $this->User_model->getMessageReceiversByRole($this->session->userdata('role'));
        $this->data['messages'] = $this->Mailbox_model->userConversation($this->session->userdata('userId'), 7);
        
        $this->global['pageTitle'] = 'LANDHUB PORTAL : Dashboard';
        
        $this->loadViews("mailbox/mail-list", $this->global, $this->data , NULL);
    }
    
    public function getConversation($user, $sender)
    {
        $this->data['sender'] = $sender;
        $this->data['messages'] = $this->Mailbox_model->userConversation($this->session->userdata('userId'), $sender);
        $this->load->view("mailbox/user-conversation", $this->data);
    }
    
    public function sendMessage()
    {
        $receiver = $this->input->post('receiver');
        $sender = $this->input->post('sender');
        $content = $this->input->post('content');
        
        if (empty($content)) {
            return false;
        }
        
        $conversation = array(
            'receiver' => $receiver,
            'sender' => $sender,
            'content' => $content,
            'date_added' => date('Y-m-d H:i:s')
        );
        
        return $this->Mailbox_model->addConversation($conversation);
    }
    
    public function deleteMessage($id)
    {
        return $this->Mailbox_model->deleteMessage($id);
    }
}