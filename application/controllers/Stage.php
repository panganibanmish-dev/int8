<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Mailbox (UserController)
 * Class that processes /mailbox/ URIs
 * @author : Ruffy Collado
 * @version : 1.1
 * @since : 31 August 2020
 */
class Stage extends BaseController
{
    /***
     * Document upload path
     * 
     */
     protected $document_upload_path = 'uploads/documents/';
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->isLoggedIn();
    }
    public function showStatus($lotID)
    {
        require_once(FCPATH.'application/libraries/zoho/config.php');
        require_once(FCPATH.'application/libraries/zoho/zohoClass.php');

        $this->load->model('Zoho_access');
        $this->load->model('lotupload_model');
        $this->load->model('doclabel_model');
        
        $zohoAuth = new zohoClass();
        $access_token = $this->Zoho_access->generate_access_token();
        $lot = $zohoAuth->getModuleRecord($access_token, 'LOTS', $lotID);
        $stageID = $lot->data[0]->Lot_Stage;
        
        $getStageQuery = "SELECT Name, Actual_Start_Date, Anticipated_Titles_Public, Drainage_Completed, Sewer_Completed, Stage_ID,
            Water_Gas_Completed, Power_NBN_Completed,
            Pavements_Completed, Concrete_Works_Completed,
            Topsoiling_Completed, Linemarking_Signage_Completed,
            Earthworks_Completed, Registration_Date, Received_Date,
            PRECINCT.Name, INTEGRA_PROJECTS.Name
            FROM STAGES WHERE Name = '".$lot->data[0]->Lot_Stage."'";
        
        $postData['select_query'] = $getStageQuery;
        $stage = $zohoAuth->queryModule($access_token, json_encode($postData));
        //$stage = $zohoAuth->getModuleRecord($access_token, 'STAGES', $stageID);
        
        $progress['concreteWorks'] = $this->getConstructionProgress($stage->data[0]->Concrete_Works_Completed);
        $progress['pavements'] = $this->getConstructionProgress($stage->data[0]->Pavements_Completed);
        $progress['power'] = $this->getConstructionProgress($stage->data[0]->Power_NBN_Completed);
        $progress['topsoiling'] = $this->getConstructionProgress($stage->data[0]->Topsoiling_Completed);
        $progress['drainage'] = $this->getConstructionProgress($stage->data[0]->Drainage_Completed);
        $progress['waterGas'] = $this->getConstructionProgress($stage->data[0]->Water_Gas_Completed);
        $progress['sewer'] = $this->getConstructionProgress($stage->data[0]->Sewer_Completed);
        $progress['earthworks'] = $this->getConstructionProgress($stage->data[0]->Earthworks_Completed);
        $progress['linemarking'] = $this->getConstructionProgress($stage->data[0]->Linemarking_Signage_Completed);
        $progress['startDate'] = $this->getConstructionProgress($stage->data[0]->Actual_Start_Date);
        $progress['receivedDate'] = $this->getConstructionProgress($stage->data[0]->Received_Date);
        $progress['registrationDate'] = $this->getConstructionProgress($stage->data[0]->Registration_Date);

        $progress['concreteWorksClass'] = $this->getConstructionProgressClass($stage->data[0]->Concrete_Works_Completed);
        $progress['pavementsClass'] = $this->getConstructionProgressClass($stage->data[0]->Pavements_Completed);
        $progress['powerClass'] = $this->getConstructionProgressClass($stage->data[0]->Power_NBN_Completed);
        $progress['topsoilingClass'] = $this->getConstructionProgressClass($stage->data[0]->Topsoiling_Completed);
        $progress['drainageClass'] = $this->getConstructionProgressClass($stage->data[0]->Drainage_Completed);
        $progress['waterGasClass'] = $this->getConstructionProgressClass($stage->data[0]->Water_Gas_Completed);
        $progress['sewerClass'] = $this->getConstructionProgressClass($stage->data[0]->Sewer_Completed);
        $progress['earthworksClass'] = $this->getConstructionProgressClass($stage->data[0]->Earthworks_Completed);
        $progress['linemarkingClass'] = $this->getConstructionProgressClass($stage->data[0]->Linemarking_Signage_Completed);
        $progress['startDateClass'] = $this->getConstructionProgressClass($stage->data[0]->Actual_Start_Date);
        $progress['receivedDateClass'] = $this->getConstructionProgressClass($stage->data[0]->Received_Date);
        $progress['registrationDateClass'] = $this->getConstructionProgressClass($stage->data[0]->Registration_Date);
        
        $this->global['pageTitle'] = 'LANDHUB PORTAL : '.$stage->data[0]->Name;

        // get the lot documents
        $lot_documents = $this->lotupload_model->getLotDocuments($lotID);
        $retrieved_labels = json_decode(json_encode($this->doclabel_model->getAllDocNames()), true);
        $lot_doc_labels = array_column($retrieved_labels, 'docName', 'docId');

        $this->loadViews("lot/stage", $this->global, [
            'stage' => $stage->data[0],
            'lot' => $lot->data[0],
            'progress' => $progress,
            'lot_documents'=>$lot_documents,
            'lot_doc_labels'=>$lot_doc_labels,
            'isBuilderOrContractor'=>$this->isBuilderOrContractor(),
            'document_upload_path'=>$this->document_upload_path,
            ],
            NULL
        );
    }
    private function getConstructionProgress($task)
    {
        if (empty($task)) { 
            return 'Not started';
        }
        if (date('Y-m-d') >= date('Y-m-d', strtotime($task))) {
            return 'Completed';
        }
        return 'Ongoing';
    }
    private function getConstructionProgressClass($task)
    {
        if (empty($task)) { 
            return 'Icon03';
        }
        
        if (date('Y-m-d') >= date('Y-m-d', strtotime($task))) {
            return 'Icon01';
        }
        return 'Icon02';
    }
    /***
     * Save the lot documents into the database
     * 
     */
   public function saveLotDocument( $lotId )
   {
            $this->load->helper('url', 'form');

            $config['upload_path'] = './'.$this->document_upload_path;
            $config['allowed_types'] = '*';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('attachment'))
            {
                // $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error','File Upload Failed!');
                redirect(base_url().'stage/showStatus/'.$lotId.'#file_upload_section_main');  
            } 
            else
            {
                // Save to database.
                $chosen_document_id = $_POST['chosen_document_id'];
                $this->load->model('lotupload_model');
                $retrieved_labels = array();
                $organizedDocs = array();

                $selectExistingDoc = $this->lotupload_model->getLotDocuments($lotId);        
                $retrieved_labels =  json_decode(json_encode($selectExistingDoc), true);
                $organizedDocs = array_column($retrieved_labels, 'doc_label_id');
                if(!empty($organizedDocs)){
                   foreach($organizedDocs as $od)
                   {
                        if($chosen_document_id == $od)
                        {
                            $this->session->set_flashdata('error','Upload Failed. Label already in use!');
                            redirect(base_url().'stage/showStatus/'.$lotId.'#file_upload_section_main'); 
                        } 
                        else 
                        { 
                            $user_data = $this->session->get_userdata();
                            $file_data = $this->upload->data();  
    
                            $file_data = array(
                                'user_id'=> $user_data['userId'],
                                'lot' => $lotId,
                                'doc_label_id' => $chosen_document_id,
                                'document'=>$file_data['file_name']
                        );
                            $result = $this->lotupload_model->saveNewFile($file_data);
                        if( $result == 1)
                        {
                            $this->session->set_flashdata('success','File Saved Successfully !');
                            redirect(base_url().'stage/showStatus/'.$lotId.'#file_upload_section_main'); 
    
                        }
                        else
                        {
                            $this->session->set_flashdata('error','An error occurred while saving the file!');
                            redirect(base_url().'stage/showStatus/'.$lotId.'#file_upload_section_main'); 
                        }
                    }
                    }
                } else {
                     $user_data = $this->session->get_userdata();
                        $file_data = $this->upload->data();  

                        $file_data = array(
                            'user_id'=> $user_data['userId'],
                            'lot' => $lotId,
                            'doc_label_id' => $chosen_document_id,
                            'document'=>$file_data['file_name']
                    );
                        $result = $this->lotupload_model->saveNewFile($file_data);
                    if( $result == 1)
                    {
                        $this->session->set_flashdata('success','File Saved Successfully !');
                        redirect(base_url().'stage/showStatus/'.$lotId.'#file_upload_section_main'); 

                    }
                    else
                    {
                        $this->session->set_flashdata('error','An error occurred while saving the file!');
                        redirect(base_url().'stage/showStatus/'.$lotId.'#file_upload_section_main'); 
                    }
            }
        }
    }

     /***
     * Delete the lot documents from the database
     * 
     */
     public function deleteDocument($uploadId)
     {
        $userId = $this->session->userdata ( 'userId' );
        $this->load->model('lotupload_model');

        $document = $this->lotupload_model->getDocument($uploadId);
        $lotId = $document->lot;

        if( $document->user_id == $userId )
        {
            $file_path =  $_SERVER['DOCUMENT_ROOT'].'/'.$this->document_upload_path.$document->document;
                if( file_exists($file_path))
                {
                    unlink($file_path);
                }
            $result = $this->lotupload_model->deleteDocument($uploadId);
            if( $result )
            {
                // delete file
                
                $this->session->set_flashdata('success','File successfully deleted !');
                redirect('stage/showStatus/'.$lotId.'#file_upload_section_main'); 
            }else
            {
                $this->session->set_flashdata('error','File deletion failed!');
                redirect('stage/showStatus/'.$lotId.'#file_upload_section_main'); 
            }
        } 
        $this->session->set_flashdata('error','An error occurred while deleting the file !');
        redirect('stage/showStatus/'.$uploadId.'#file_upload_section_main'); 
    }

    public function downloadDoc($docId)
    {
        $this->load->helper('download');
        $this->load->model('lotupload_model');

        $document = $this->lotupload_model->getDocument($docId);
        $pth    =   file_get_contents(base_url().$this->document_upload_path.$document->document);
        $nme    =   $document->document;
        force_download($nme, $pth);
    }
    public function lotsActivity()
    {
        switch ($this->session->userdata('role')) 
        {
            case ROLE_ADMIN:
                $this->adminActivity();
                break;
            default:
                $this->userActivity();
                break;
        }
    }

    public function adminActivity()
    {
        $this->global['pageTitle'] = 'Activity';
        
        require_once(FCPATH.'application/libraries/zoho/config.php');
        require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
        $this->load->model('Zoho_access');
        
        $zohoAuth = new zohoClass();
        $access_token = $this->Zoho_access->generate_access_token();
        
        $dealsList = array();
        $userName = $this->session->userdata('name');
        $getDealsQuery = "select Lots, Stage, Individual_Names FROM Deals WHERE Individual_Names is not null AND Stage != 'Settled'";
        $postData['select_query'] = $getDealsQuery;
        $deals = $zohoAuth->queryModule($access_token, json_encode($postData));
        
        if (!empty($deals)) 
        {
            foreach ($deals->data as $deal) 
            {
                $dealLots = explode(',', $deal->Lots);
                foreach ($dealLots as $dealLot) 
                {
                    $getLotQuery = "select INTEGRA_PROJECTS.Name AS Estate, Street_Address, Lot_No, Lot_Stage FROM LOTS WHERE Name = '".$dealLot."'";
                    $postData['select_query'] = $getLotQuery;
                    $lot = $zohoAuth->queryModule($access_token, json_encode($postData));
                    
                    if (!empty($lot))
                    {
                        $deal->lot = $lot->data[0];
                        $dealsList[] = $deal;
                    }
                }
            }
        }
        $isBuildContractAdmin = $this->isBuildContractAdmin();
        
        $this->loadViews("lot/lotActivity", $this->global,[
            'deals' => $dealsList,
            'isBuildContractAdmin'=>$isBuildContractAdmin
            ],NULL
        );
    }

    public function userActivity()
    {
        $this->global['pageTitle'] = 'Activity';
        
        require_once(FCPATH.'application/libraries/zoho/config.php');
        require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
        $this->load->model('Zoho_access');
        
        $zohoAuth = new zohoClass();
        $access_token = $this->Zoho_access->generate_access_token();
        
        $dealsList = array();
        $userName = $this->session->userdata('name');
        $getDealsQuery = "select Lots, Stage, Individual_Names FROM Deals WHERE Individual_Names like '%$userName%' AND Stage != 'Settled'";
        $postData['select_query'] = $getDealsQuery;
        $deals = $zohoAuth->queryModule($access_token, json_encode($postData));

        if (!empty($deals) and $deals->code != 'AUTHENTICATION_FAILURE')
        {
            foreach ($deals->data as $deal) 
            {
                $dealLots = explode(',', $deal->Lots);
                
                foreach ($dealLots as $dealLot) {
                    $getLotQuery = "select INTEGRA_PROJECTS.Name AS Estate, Street_Address, Lot_No, Lot_Stage FROM LOTS WHERE Name = '".$dealLot."'";
                    $postData['select_query'] = $getLotQuery;
                    $lot = $zohoAuth->queryModule($access_token, json_encode($postData));
                    
                    if (!empty($lot)) 
                    {
                        $getStageQuery = "SELECT Actual_Start_Date,
                            Drainage_Completed, Sewer_Completed,
                            Water_Gas_Completed, Power_NBN_Completed,
                            Pavements_Completed, Concrete_Works_Completed,
                            Topsoiling_Completed, Linemarking_Signage_Completed,
                            Earthworks_Completed, Registration_Date
                            FROM STAGES WHERE Name = '".$lot->data[0]->Lot_Stage."'";
                        
                        $postData['select_query'] = $getStageQuery;
                        $stage = $zohoAuth->queryModule($access_token, json_encode($postData));
                        
                        if (!empty($stage)) 
                        {
                            $deal->lot = $lot->data[0];
                            $deal->stage = $stage->data[0];
                            
                            $progress = new stdClass();
                            $progress->concreteWorks = $this->getConstructionProgress($stage->data[0]->Concrete_Works_Completed);
                            $progress->pavements = $this->getConstructionProgress($stage->data[0]->Pavements_Completed);
                            $progress->power = $this->getConstructionProgress($stage->data[0]->Power_NBN_Completed);
                            $progress->topsoiling = $this->getConstructionProgress($stage->data[0]->Topsoiling_Completed);
                            $progress->drainage = $this->getConstructionProgress($stage->data[0]->Drainage_Completed);
                            $progress->waterGas = $this->getConstructionProgress($stage->data[0]->Water_Gas_Completed);
                            $progress->sewer = $this->getConstructionProgress($stage->data[0]->Sewer_Completed);
                            $progress->earthworks = $this->getConstructionProgress($stage->data[0]->Earthworks_Completed);
                            $progress->linemarking = $this->getConstructionProgress($stage->data[0]->Linemarking_Signage_Completed);
                            $progress->startDate = $this->getConstructionProgress($stage->data[0]->Actual_Start_Date);
                            
                            $progress->completion = 100 * ((
                                $progress->concreteWorks + $progress->pavements + $progress->power + $progress->topsoiling + $progress->drainage
                                + $progress->waterGas + $progress->sewer + $progress->earthworks + $progress->linemarking + $progress->startDate) / 100);
                
                            $deal->progress = $progress;
                            $dealsList[] = $deal;
                        }
                    }
                }
            }
        }
        $isBuildContractAdmin = $this->isBuildContractAdmin();

        $this->loadViews("lot/lotActivity", $this->global, [
                'deals' => $dealsList,
                'isBuildContractAdmin' => $isBuildContractAdmin
            ],NULL
        );
    }
}