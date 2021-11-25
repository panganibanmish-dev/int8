<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Doclabel_model extends CI_Model
{
    /**
     * This function is used to get the all the lot documents
     * @param string $docId : Is required
     * @return array : Array of documents
     */

    public function getAllDocNames()
    {
        $this->db->select('DocTbl.docId, DocTbl.docName');
        $this->db->from('tbl_doc_labels as DocTbl');

        $query = $this->db->get();

        return $query->result();

    }

    public function getDocNames( $docId )
    {
        $this->db->select('DocTbl.docId, DocTbl.docName');
        $this->db->from('tbl_doc_labels as DocTbl');

        $this->db->where('DocTbl.docId =', $docId);

        $query = $this->db->get();

        return $query->result();
    }


} 

?>