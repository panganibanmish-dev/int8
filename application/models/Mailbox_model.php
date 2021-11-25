<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mailbox_model extends CI_Model
{
    public function userConversation($sender, $user)
    {
        $this->db->select("user_mailbox.*, sender.name AS senderName, sender.userId AS senderId");
        $this->db->from("user_mailbox");
        $this->db->join('tbl_users sender', 'sender.userId = user_mailbox.sender', 'left');
        $this->db->where("(user_mailbox.sender = $sender AND user_mailbox.receiver = $user) OR (user_mailbox.sender = $user AND user_mailbox.receiver = $sender)");
        $this->db->where("user_mailbox.box", 'inbox');
        $this->db->where('user_mailbox.deleted_at', null);
        $this->db->order_by('user_mailbox.date_added', 'ASC');
        
        $query = $this->db->get();
        
        return $query->result();
    }
    
    public function addConversation($conversation)
    {
        $this->db->trans_start();
        $this->db->insert('user_mailbox', $conversation);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    public function deleteMessage($id)
    {
        $this->db->delete('user_mailbox', array('id'=>$id));
    }
}