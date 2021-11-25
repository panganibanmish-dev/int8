<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    /**
     * This function is used to get the all the users
     * @param string $searchText : This is optional search text
     * @return array : Array of users
     */
    function userListingAll($searchText = '')
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        
        $this->db->where('BaseTbl.deleted_at', null);
        $this->db->where('BaseTbl.roleId !=', ROLE_ADMIN);
        $query = $this->db->get();
        
        return $query->result();
    }

    function getUsers(){
        $this->db->select('tu.userId, tu.name, tu.email');
        $this->db->from('tbl_users as tu');
        $this->db->where('roleId !=', 1);
        $this->db->where('deleted_at', null);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to get the client type users (Purchaser, Contractor)
     * @param string $searchText : This is optional search text
     * @return array : Array of User Entity
     */
    function userListingClientTypes($searchText = '')
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        
        $this->db->where('BaseTbl.deleted_at', null);
        $this->db->where_in('BaseTbl.roleId', [ROLE_PURCHASER, ROLE_CONTRACTOR]);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to get the builder type users (Builders)
     * @param string $searchText : This is optional search text
     * @return array : Array of User Entity
     */
    function userListingBuilderTypes($searchText = '')
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        
        $this->db->where('BaseTbl.deleted_at', null);
        $this->db->where_in('BaseTbl.roleId', [ROLE_BUILDER, ROLE_CONTRACTOR]);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function userListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        
        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        
        $this->db->where('BaseTbl.deleted_at', null);
        $this->db->where('BaseTbl.roleId !=', 1);
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    /**
     * Gets all the Super Admin, Client Admin and Builder Admin
     * @return array $result : This is result
     */
    function adminUsers()
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where_in('roleId', 1);
        $this->db->where('deleted_at', null);
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }
    
    /**
     * Gets all the Client
     * @return array $result : This is result
     */
    function getUserRolesByManagement($role=null)
    {
        if (!empty($role)) {
            $this->db->select('roleId, role');
            $this->db->from('tbl_roles');
            
            // switch ($role) {
            //     case ROLE_ADMIN:
            //     default:
            //         $this->db->where('roleId !=', ROLE_ADMIN);
            //         break;
            // }
            
            $query = $this->db->get();
            return $query->result();
        }
        
        return false;
    }
    
    public function getSearchedUser($name)
    {  
        $this->db->select('*');
        $this->db->from('tbl_users');
        
        if (!empty($name)) {
            $likeCriteria = "(name  LIKE '%".$name."%')";
            $this->db->where($likeCriteria);
        }
    
        $query = $this->db->get();
        return $query->result();
    }
    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getMessageReceiversByRole($role=null)
    {
        if (!empty($role)) {
            $this->db->select('*');
            $this->db->from('tbl_users');
            
            switch ($role) {
                case ROLE_ADMIN:
                    $this->db->where_in('roleId', [ROLE_ADMIN]);
                    break;
                
                case ROLE_PURCHASER:
                    $this->db->where_in('roleId', [ROLE_ADMIN]);
                    break;
                    
                case ROLE_BUILDER:
                    $this->db->where_in('roleId', [ROLE_ADMIN]);
                    break;
                    
                case ROLE_CONTRACTOR:
                    $this->db->where_in('roleId', [ROLE_ADMIN]);
                    break;

                default:
                    $this->db->where_in('roleId', [ROLE_ADMIN]);
                    break;
            }
            
            $this->db->where('deleted_at', null);
            $query = $this->db->get();
            
            return $query->result();
        }
        
        return false;
        
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("tbl_users");
        $this->db->where("email", $email);   
        $this->db->where('deleted_at', null);
        
        if  ($userId != 0) {
            $this->db->where("userId !=", $userId);
        }
        
        $query = $this->db->get();

        return $query->result();
    }
    
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId, company');
        $this->db->from('tbl_users');
        $this->db->where('deleted_at', null);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);        
        $this->db->where('deleted_at', null);
        $query = $this->db->get('tbl_users');
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('deleted_at', null);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }


    function getBuilders()
    {

        $this->db->select('BaseTbl.userId, BaseTbl.name');
        $this->db->from('tbl_users as BaseTbl');
       
        $this->db->where('BaseTbl.roleId =', ROLE_BUILDER);
        $this->db->where('deleted_at', null);
        $query = $this->db->get();
        
        return $query->result();

    }


    function getMainAdmins()
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('roleId =', ROLE_ADMIN);
        $this->db->where('deleted_at', null);
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }

    /**
     * Gets Zoho desk user Id
     * @return array $result : This is result
     */
    function getZohoDeskUserId($userId=null)
    {
        if (!empty($userId)) {
            $this->db->select('zoho_user_id,email,name,mobile');
            $this->db->from('tbl_users');
            $this->db->where('userId', $userId );
            $query = $this->db->get();
            $userInfo=$query->result();
            return json_decode(json_encode($userInfo),true);
        }
        return false;
    }

    
}

  