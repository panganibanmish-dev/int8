<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (PackageController)
 * Package Class to control all house and land package related operations.
 */
class Package extends BaseController
{

    protected $package_upload_path = 'uploads/new-packages/';

    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();   
    }

    /*****
     * 
     * Upload packages main page
     */
   
    public function index(){

        require_once(FCPATH.'application/libraries/zoho/config.php');
        require_once(FCPATH.'application/libraries/zoho/zohoClass.php');

        $this->load->model('Zoho_access');
        $this->load->model('user_model');
        
        $zohoAuth = new zohoClass();
        $access_token = $this->Zoho_access->generate_access_token();

        $estates = $zohoAuth->listModuleData($access_token, 'INTEGRA_PROJECTS');
        $user = $this->user_model->getUserInfo($this->session->userdata('userId'));
        $builder_obj = $this->user_model->getBuilders($this->session->userdata('userId'));

        $builders = [];

        foreach( $builder_obj as $each_builder ){
            $builders[$each_builder->name] = $each_builder->name;
        }

        if( !is_array($estates->data) ){
            $estates->data = [];
        }

        $this->loadViews("packages", $this->global,[
            'estates' => $estates->data,
            'builders'=>$builders,
            'user' => $user[0]
        ],
        NULL);

    }


    /****
     *  save and send email for uploads
     * 
     */

     public function addNewPackage( $time ){
   
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name','Name','required|xss_clean');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('house_name','House Name','trim|required|xss_clean');
        $this->form_validation->set_rules('price','Price','trim|required|numeric|xss_clean');
        
        $data = [];
       
        if ($this->form_validation->run() == FALSE) {
           
            // send back errors
            $errors = validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');

            $data['status'] = 'error';

            if( $errors != '' ){
                $data['errors'] = $errors;
            } else {
                $data['errors'] = '<div class="alert alert-danger alert-dismissable">An error occurred while uploading! <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>';
            }

        } else {
            
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $builder = $this->input->post('builder');
            $estate = $this->input->post('estate');
            $house_name = $this->input->post('house_name');
            $lot_number = $this->input->post('lot_number');
            $bed = $this->input->post('bed');
            $car = $this->input->post('car');
            $bath = $this->input->post('bath');
            $price = $this->input->post('price');

            $config['upload_path'] = './'.$this->package_upload_path.'/'.$time;
            $config['allowed_types'] = 'pdf|PDF';

            if( !file_exists($config['upload_path']) ){
                mkdir($config['upload_path']);
            }

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('attachment')) {

                $data['status'] = 'error';

                $data['errors'] = $this->upload->display_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');

            } else {

                $new_file_data = $this->upload->data(); 
                
                $packages = $this->session->userdata("file_data_".$time);
              
                if( !$packages ){
                    $packages = [];
                }

                $file_data = [
                    'uid'=>uniqid(),
                    'name'=>$name,
                    'email'=>$email,
                    'builder'=>$builder,
                    'estate'=>$estate,
                    'house_name'=>$house_name,
                    'lot_number'=>$lot_number,
                    'bed'=>$bed,
                    'car'=>$car,
                    'bath'=>$bath,
                    'price'=>$price,
                    'pdf'=>$new_file_data['file_name'],
                    'pdf_path'=>base_url().$this->package_upload_path.'/'.$time.'/'.$new_file_data['file_name'],
                ];

                if( count($packages) < 5 ){ // take only upto five
                    $packages[] = $file_data;
                }

                $data['count'] = count($packages);
                
                $this->session->set_userdata("file_data_".$time,$packages);

                $data['status'] = 'success';
                $data['row'] = $file_data;
                $data['message'] = 'Uploaded Successfully';

            }

        }

        echo json_encode($data);exit;

     }


     public function sendAdminMail( $timestamp ){

        $packages = $this->session->userdata("file_data_".$timestamp);

        if( count($packages) > 0 ){

            $this->load->model('user_model');

            $users = $this->user_model->getMainAdmins();
            
            if( count($users) > 0 ){

                $user = $users[0];

                $this->load->library('email');
                $this->email->from('noreply@integragroup.com.au', 'INTEGRA');
                $this->email->to('adam@integragroup.com.au');

                $loggedUser = $this->user_model->getUserInfo($this->session->userdata('userId'));

                $loggedUser = $loggedUser[0];

                $htmlBody = "<div style='font-family: Century Gothic;'><p>Dear ".$user->name.",</p>
                                <p>Details of the new Home + Land Package is attached with this mail </p>";

                $htmlBody .= "<div style='width:100%;margin:30px 0px;'>";
                $htmlBody .= "<p><b>Package Uploaded by: ".$loggedUser->name."</b></p>";
                $htmlBody .= "<p><b>User Email: ".$loggedUser->email."</b></p>";
                $htmlBody .= "</div>";
                
                foreach($packages as $key => $package){

                    $htmlBody .= "<div style='width:100%;margin-top:30px;'>";
                    $htmlBody .= "<p><b style='font-size:20px;'>Package: ".($key+1)."</b></p>";
                    $htmlBody .= "</div>";
                    
                    $htmlBody .= "<div style='width:100%;margin:10px 0px;'>";

                    $htmlBody .= "<p><b>Builder:</b> ".$package['builder']."</p>";
                    $htmlBody .= "<p><b>Estate: </b>".$package['estate']."</p>";
                    $htmlBody .= "<p><b>Lot Number: </b>".$package['lot_number']."</p>";
                    $htmlBody .= "<p><b>House Name: </b>".$package['house_name']."</p>";
                    $htmlBody .= "<p><b>Bed: </b>".$package['bed']."</p>";
                    $htmlBody .= "<p><b>Car: </b>".$package['car']."</p>";
                    $htmlBody .= "<p><b>Bath: </b>".$package['bath']."</p>";
                    $htmlBody .= "<p><b>Price: </b>".$package['price']."</p>";
                    $htmlBody .= "<p><b>Pdf File: </b>".$package['pdf']." ( Attached with this email )</p>";

                    $htmlBody .= "</div>";

                    $htmlBody .= "<div style='width:100%;margin-bottom:30px;'>";
                    $htmlBody .= "</div>";

                    //$this->email->attach(FCPATH.$this->package_upload_path.'/'.$timestamp.'/'.$package['pdf']);            

                }

                $htmlBody .= "</div>";
                
                $this->email->subject('New Home + Land Package');
                $this->email->set_mailtype("html");
                $this->email->message($htmlBody);

                // remove from session

                $this->session->set_userdata("file_data_".$timestamp, false);

                if($this->email->send()){
                    $this->session->set_flashdata('success', 'The Packages has been submitted successfully');
                } else {
                    $this->session->set_flashdata('error', 'An error occurred while submitting the package');
                }

                redirect('package');

            }

        }
              

     }


     
     public function deletePackage( $time, $uid ){

        $packages = $this->session->userdata("file_data_".$time);

        if( count($packages) > 0 ){

            foreach( $packages as $key => $package ){
                
                if( $packages[$key]['uid'] == $uid ){

                    unset($packages[$key]);

                    // delete file

                    $file_path = './'.$this->package_upload_path.$time.'/'.$package['pdf'];
                    
                    if( file_exists($file_path) ){

                        unlink($file_path);
                        
                        if( count($packages) == 0 ){
                            rmdir('./'.$this->package_upload_path.$time);
                        }

                    }

                    $this->session->set_userdata("file_data_".$time,$packages);

                }

            }

        }

        echo json_encode(['status'=>'success']);
        exit;

    }

    
}


?>