<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Login (LoginController)
 * Login class to control to authenticate user credentials and starts user's session.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Login extends CI_Controller
{
    protected $layout = 'layouts/default';
    protected $data = [];

    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
    }
    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
    }
    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->data['view'] = 'login';
            $this->data['params'] = [];

            $this->load->view($this->layout, $this->data);
        }
        else
        {
            redirect('/dashboard');
        }
    }

    /**
     * This function used to logged in user
     */
    public function loginMe()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            
            $result = $this->login_model->loginMe($email, $password);
            
            if(count($result) > 0)
            {
                foreach ($result as $res)
                {
                    $sessionArray = array('userId'=>$res->userId,                    
                                            'role'=>$res->roleId,
                                            'roleText'=>$res->role,
                                            'name'=>$res->name,
                                            'email'=>$res->email,
                                            'isLoggedIn' => TRUE
                                        );          
                    $this->session->set_userdata($sessionArray);
                    redirect('/dashboard');
                }
            }
            else
            {
                $this->session->set_flashdata('error', 'Email or password mismatch');
                redirect('/login');
            }
        }
    }

    /**
     * This function used to load forgot password view
     */
    public function forgotPassword()
    {
        $this->load->view('forgotPassword');
    }
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser()
    {
        $status = '';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email|xss_clean');
                
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            //USER EMAILS ENTERED TO CHANGE PASSWORD
            $email = $this->input->post('login_email');
            if($this->login_model->checkEmailExist($email))
            {
                $encoded_email = urlencode($email);
                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['createdDtm'] = date('Y-m-d H:i:s');
                $data['agent'] = getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();
                
                $save = $this->login_model->resetPasswordUser($data);                
                if($save)
                {
                    $data1['reset_link'] = base_url() . "resetPasswordConfirmUser?activation_id=" . $data['activation_id'] . "&email=" . $email;
                    $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo))
                    {
                        $data1["name"] = $userInfo[0]->name;
                        $data1["email"] = $userInfo[0]->email;
                        $data1["message"] = "Reset Your Password";
                    }

                    $sendStatus = resetPasswordEmail($data1);
                    // if($sendStatus){
                    //     //print_r('Data: ' . $sendStatus); //this is also the working one, do not delete
                    //     $status = "send";
                    //     setFlashData($status, "Reset password link sent successfully, $sendStatus");
                       
                    // }
                    if($sendStatus)
                    {
                        $status = "send";
                        setFlashData($status, "We have e-mailed your password reset link!");
                    } 
                    else 
                    {
                        $status = "notsend";
                        setFlashData($status, "E-mail incorrect, please try again");
                        print_r($this->email->print_debugger());
                    }
                }
                    else
                    {
                        $status = 'unable';
                        setFlashData($status, "It seems an error while sending your details, try again.");
                    }
            }
                    else
                    {
                        $status = 'invalid';
                        setFlashData($status, "This email is not registered with us.");
                    }
                    redirect('/forgotPassword');
        }
    }
    // This function used to reset the password 
    function resetPasswordConfirmUser()
    {
        // Check activation id in database
        // Used PHP's conventional GET metod to fetch URL data
        $email = $_GET['email'];
        $activation_id = $_GET['activation_id'];
        //print_r($email . '<br>' . $activation_id);
        $is_correct = $this->login_model->checkActivationDetails($activation_id, $email);
    
        $data['email'] = $email;
        $data['activation_code'] = $activation_id;
        
        if ($is_correct)
        {
            $this->load->view('newPassword', $data);
        }
        else
        {
            redirect('/login');
        }
    }
    
    // This function used to create new password
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = $this->input->post("email");
        $activation_id = $this->input->post("activation_code");
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->resetPasswordConfirmUser();
        }
        else
        {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');
            
            // Check activation id in database
            $is_correct = $this->login_model->checkActivationDetails($activation_id, $email);
            
            if($is_correct == 1)
            {                
                $this->login_model->createPasswordUser($email, $password);
                $status = 'success';
                $message = 'Password changed successfully';
            }
            else
            {
                $status = 'error';
                $message = 'Password changed failed';
            }
            setFlashData($status, $message);
            redirect("/login");
        }
    }

    function signup()
    {
        $this->load->model('User_model');

        $data['roles'] = $this->User_model->getUserRolesByManagement();
        $data['pageTitle'] = 'Sign up';

        $this->data['view'] = 'signup';
        $this->data['params'] = $data;
        $this->load->view($this->layout, $this->data);
    }

    function addsignup()
     {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('role','Role','trim|required|numeric');
        $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
        $this->form_validation->set_rules('estate','Estate','trim|required|max_length[128]|xss_clean');
        
        if (('contractor' == $this->input->post('role')) || ('newhomebuilder' == $this->input->post('role'))) {
            $this->form_validation->set_rules('phone','Phone','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('company','Company','trim|required|max_length[128]|xss_clean');
        } else {
            $this->form_validation->set_rules('lotnumber','Lot Number','trim|required|max_length[128]|xss_clean');
        }
        
        if($this->form_validation->run() == FALSE) {
            $this->addNew();
        }
        else {
            $name = ucwords(strtolower($this->input->post('fname')));
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $roleId = $this->input->post('role');
            $mobile = $this->input->post('mobile');
            
            $userInfo = array(
                'email'=>$email, 
                'password'=>getHashedPassword($password),
                'roleId'=>$roleId,
                'name'=> $name,
                'createdBy'=>$this->vendorId,
                'createdDtm'=>date('Y-m-d H:i:s'));
            
            $this->load->model('user_model');
            $result = $this->user_model->addNewUser($userInfo);
            
            if($result > 0) {
                $this->session->set_flashdata('success', 'New User created successfully');
            }
            else {
                $this->session->set_flashdata('error', 'User creation failed');
            }
            
            redirect('addNew');
        }
    }
    
    
    function registerSelf()
    {
        require_once(FCPATH.'application/libraries/zoho/config.php');
        require_once(FCPATH.'application/libraries/zoho/zohoClass.php');
        $this->load->model('Zoho_access');
        $this->load->model('User_model');
        
        $zohoAuth = new zohoClass();
        $dealID = $this->input->get('deal');
        $email = $this->input->get('email');
        
        $roles = $this->User_model->getUserRolesByManagement();
        
        $access_token = $this->Zoho_access->generate_access_token();
        
        $deal = $zohoAuth->getModuleRecord($access_token, 'Deals', $dealID);
        $user = $zohoAuth->searchModule($access_token, 'Contacts', "(Email:equals:$email)");
        $user = $user->data[0];
        
        $this->load->model('User_model');
        $data['pageTitle'] = 'Register';

        $this->data['view'] = 'registerSelf';
        $this->data['params'] = [
            'user' => $user,
            'deal' => $deal,
            'roles' => $roles
        ];
        $this->load->view($this->layout, $this->data);
    }
    
    function registerSelfAction()
    {
        $this->load->library('form_validation');
        $this->load->model('user_model');
        
        $dealID = $this->input->get('deal');
        $email = $this->input->get('email');
        
        $this->form_validation->set_rules('role','Role','trim|required');
        $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]|is_unique[tbl_users.email]');
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('confirm_password','Confirm Password','required|max_length[20]');
        $this->form_validation->set_rules('contact_number','Contact Number','min_length[10]|xss_clean');
        $this->form_validation->set_rules('company','Company','trim|max_length[128]|xss_clean');
        
        if($this->form_validation->run() == FALSE) 
        {
            $this->registerSelf();
        }
        else 
        {
            $name = $this->input->post('fname');
            $role = $this->input->post('role');
            $email = $this->input->post('email');
            $contact_number = $this->input->post('contact_number');
            $company = $this->input->post('company');
            
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');
            
            if ($confirm_password == $password)
            {
                $usersData = array(
                    'name'=> $name,
                    'email' => $email,
                    'password' => getHashedPassword($password),
                    'roleId'=>$role,
                    'createdBy'=>1,
                    'mobile'=>$contact_number,
                    'company'=>$company,
                    'createdDtm'=>date('Y-m-d H:i:s')
                );
                $result = $this->user_model->addNewUser($usersData);
                
                if($result > 0) 
                {
                    $this->session->set_flashdata('success', 'Registration complete, you may now login.');
                }
                else 
                {
                    $this->session->set_flashdata('error', 'Registration failed');
                }
            } 
            else 
            {
                $this->session->set_flashdata('error', 'Password does not match');
            }
                $this->registerSelf();
        }
    }
} ?>