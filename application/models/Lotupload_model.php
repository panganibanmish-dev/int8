<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Lotupload_model extends CI_Model
{
    /**
     * This function is used to get the all the lot documents
     * @param string $lotId : Is required
     * @return array : Array of documents
     */
    public function getLotDocuments( $lotId )   
    {
        $this->db->select('BaseTbl.id, BaseTbl.user_id, BaseTbl.doc_label_id,
        DocTbl.docName, BaseTbl.document');
        $this->db->join('tbl_doc_labels as DocTbl', 'DocTbl.docId = BaseTbl.doc_label_id', 'left');
        $this->db->from('lot_uploads as BaseTbl');

        $this->db->where('BaseTbl.lot =', $lotId);

        $query = $this->db->get();

        return $query->result();

    }

    /**
     * This function is used to get the all the lot documents
     * @param string $lotId : Is required
     * @return array : Array of documents
     */
    public function getAllLotDocuments()
    {
        $this->db->select('BaseTbl.id,BaseTbl.user_id, BaseTbl.lot, BaseTbl.doc_label_id, BaseTbl.document, 
        DocTbl.docName, Users.name');
        $this->db->from('lot_uploads as BaseTbl');
        $this->db->join('tbl_users as Users', 'Users.userId = BaseTbl.user_id', 'left');
        $this->db->join('tbl_doc_labels as DocTbl', 'DocTbl.docId = BaseTbl.doc_label_id', 'left');
        $query = $this->db->get();

        return $query->result();

    }

    public function getLots()
    {  
        $this->db->select('tul.lot_no');
        $this->db->from('tbl_lots as tul');

        $query = $this->db->get();
        return $query->result();
    }

    public function getEstates()
    {  
        $this->db->select('tet.id, tet.estate_name');
        $this->db->from('tbl_estates as tet');
    
        $query = $this->db->get();
        return $query->result();
    }

    public function getEstate($estId)
    {  
        $this->db->select('tet.id, tet.estate_name');
        $this->db->from('tbl_estates as tet');
        $this->db->where('tet.id', $estId);
    
        $query = $this->db->get();
        return $query->result();
    }

    public function getExistingLots($matchLot, $matchId)
    {  
        $this->db->select('tul.id, tul.lot_id, tul.lot_no');
        $this->db->from('tbl_user_lots as tul');
        $this->db->where('tul.lot_no =', $matchLot);
        $this->db->where('tul.lot_id =', $matchId);
    
        $query = $this->db->get();
        return $query->result();
    }

    public function getUserLots($userId)
    {  
        $this->db->select('tul.id, tul.lot_id, tul.lot_no, tul.lot_estate, tul.lot_stage');
        $this->db->from('tbl_user_lots as tul');
        $this->db->where('tul.lot_id =', $userId);
    
        $query = $this->db->get();
        return $query->result();
    }

    public function getThisUser($userId)
    {  
        $this->db->select('tu.userId');
        $this->db->from('tbl_users as tu');
        $this->db->where('tu.userId =', $userId);
    
        $query = $this->db->get();
        return $query->result();
    }

    public function getSearchedLot($lot_no, $estName)
    {  

        $likeCriteria = "(tul.lot_estate LIKE '%".$estName."%')";

        $this->db->select('tul.id, tul.lot_no, tul.lot_estate, tul.lot_stage');
        $this->db->from('tbl_lots as tul');
        $this->db->where('tul.lot_no', $lot_no);  
        $this->db->where($likeCriteria);
    
        $query = $this->db->get();
        return $query->result();
    }

    public function getLotEstMatch($estName)
    {  

        $likeCriteria = "(tul.lot_estate LIKE '%".$estName."%')";

        $this->db->select('tul.id, tul.lot_no, tul.lot_estate, tul.lot_stage');
        $this->db->from('tbl_lots as tul');
        $this->db->where($likeCriteria);
    
        $query = $this->db->get();
        return $query->result();
    }

    public function getAssignedLots($lotId)
    {  
        $this->db->select('UserLotTbl.id, UserLotTbl.lot_id,
        UserLotTbl.lot_no, UserLotTbl.lot_estate, UserLotTbl.lot_stage');
        $this->db->from('tbl_user_lots as UserLotTbl');
    
        $this->db->where('UserLotTbl.lot_id =', $lotId);
        $query = $this->db->get();
        return $query->result();
    }

    public function saveLotAssignment($assignInfo)
    {
        $this->db->trans_start();
        $result = $this->db->insert('tbl_user_lots', $assignInfo);
        
        //$insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
       // return $insert_id;
       if($result){
            return 1;
        } else {
            return 0;
        }
    }

    public function removeLotAssignment($lot_id)
    {
        
        // $this->db->select('*');
        // $this->db->from('tbl_user_lots');
        // $this->db->where('id', $lot_id);

        $this->db->delete('tbl_user_lots', array('id'=>$lot_id));
        //return $query->result();
    }

    /**
     * This function is used to get document based on ID
     * @param string $docId : Is required, its the primary key
     * @return array : document row
     */
    

    public function getDocument( $docId )
    {
        $this->db->select('BaseTbl.id,BaseTbl.user_id, BaseTbl.lot, BaseTbl.doc_label_id,
        DocTbl.docName, BaseTbl.document');
        $this->db->join('tbl_doc_labels as DocTbl', 'DocTbl.docId = BaseTbl.doc_label_id', 'left');
        $this->db->from('lot_uploads as BaseTbl');

        $this->db->where('BaseTbl.id =', $docId);

        $query = $this->db->get();

        return $query->row();

    }

    /**
     * This function is used to save a new document
     * @param string $data : required info of documents
     * @return array : Inserted Id
     */

    public function saveNewFile( $data ){

        $this->db->trans_start();
        $this->db->insert('lot_uploads', $data);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;

    }

        /**
     * This function is used to delete a  document
     * @param string $docId : required, document id
     * @return array : boolean
     */


    public function deleteDocument($docId){

        $this->db->where('id', $docId);
        return $this->db->delete('lot_uploads');

    }
    
   
}

  