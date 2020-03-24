<?php
namespace Model;

use Core\Drivers\MySqliDriver;
use Core\Helpers\Crypt;

/**
 * Example Model
 */
class UserModel extends MySqliDriver
{
    private $_rs;
    private $_params;

    public function __construct()
    {
        parent::__construct();
    }

    protected function recoverUser($user)
    {
        $username = $this->dataRequest($user->username);
        $password = $this->dataRequest($user->password);
        $query = "SELECT u.* FROM users u WHERE u.email = '$username'";
        $this->_rs = $this->loadObjectList($query);
        return $this->_rs;
    }

    protected function setToken($token, $user)
    {
        $query = "UPDATE users SET token = '$token' WHERE id = {$user->id}";
        if ($this->dbquery($query)) {
            return true;
        } else {
            return false;
        }
    }

    protected function validateToken($request)
    {
        $token = $this->dataRequest($request->token);
        $query = "SELECT u.* FROM users u WHERE u.token = '$token'";
        return $this->loadObjectList($query);
    }

    protected function getUserbyIdentifications($request)
    {
        $identification = $this->dataRequest($request->identification);
        $query = "SELECT * FROM users WHERE identification = $identification";
        return $this->loadObjectList($query);
    }
    
    protected function getUserbyEmails($request)
    {
        $email = $this->dataRequest($request->email);
        $query = "SELECT * FROM users WHERE email = $email";
        return $this->loadObjectList($query);
    }

    protected function createUsers($request)
    {
        $crypt = new Crypt();

        $id_type = $this->dataRequest($request->identification_type);
        $identification = $this->dataRequest($request->identification);
        $name = $this->dataRequest($request->name);
        $second_last_name = $this->dataRequest($request->second_last_name);
        $last_name = $this->dataRequest($request->last_name);
        $second_name = $this->dataRequest($request->second_name);
        $email = $this->dataRequest($request->email);
        $password = $this->dataRequest($request->password);
        $sex = $this->dataRequest($request->sex);
        $address = $this->dataRequest($request->address);
        $phone = $this->dataRequest($request->phone);
        $fax = $this->dataRequest($request->fax);
        $civil_status = $this->dataRequest($request->civil_status);
        $study_level = $this->dataRequest($request->study_level);
        $birth_date = $this->dataRequest($request->birth_date);
        $city_id = $this->dataRequest($request->city);
        $birth_zone = $this->dataRequest($request->birth_zone);

        $password = $crypt->cryptPassword($password);
        
        $query = "INSERT INTO users SET name = '$name', second_name = '$second_name',
            last_name = '$last_name', second_last_name = '$second_last_name', identification_type = '$id_type', 
            identification = '$identification', email = '$email', password = '$password', sex = '$sex', address = '$address', 
            phone = '$phone', fax = '$fax', civil_status_id = '$civil_status', study_level_id = '$study_level',
            birth_date = '$birth_date', city_id = $city_id, birth_zone = '$birth_zone'";
        return $this->dbquery($query);
    }

    protected function getUsersDataSociodemographic($request, $data)
    {
        $users_array = [];
        foreach ($data as $user) {
            $answers_query = "SELECT ans.*, q.name as question_name, q.reference as reference  FROM answers ans 
            LEFT JOIN questions q ON ans.question_id = q.id
            WHERE ans.aplication_id = (SELECT id FROM aplications WHERE user_id = $user->id AND evaluation_id = 9 ORDER BY id DESC limit 1)";
            $anwers_data = $this->loadObjectList($answers_query);
            if ($anwers_data) {
                foreach ($anwers_data as $answer) {
                    if ($answer->texted) {
                        $user->{"$answer->question_id"} = $answer->texted;
                    } else {
                        if ($answer->reference) {
                            $reference = $answer->reference;
                        } else {
                            $reference = "options";
                        }
                        $question_query = "SELECT name FROM $reference WHERE id = $answer->option_id";
                        $question_data = $this->loadObjectList($question_query);
                        $user->{"$answer->question_id"} = $question_data[0]->name;
                    }
                }
            }
            array_push($users_array, $user);
        }
        return $users_array;
    }

    protected function getUserByIds($request, $user_id)
    {
        $query = "SELECT * FROM users WHERE id = $user_id";
        return $this->loadObjectList($query);
    }

    protected function getAllUserRoles($request, $user_id) 
    {
        $query = "SELECT r.id FROM roles r LEFT JOIN access_company ac ON ac.rol_id = r.id LEFT JOIN users u ON u.id = ac.user_id WHERE u.id = $user_id";
        return $this->loadObjectList($query);
    }

    protected function getPsychologists($request, $company_id) 
    {
        $query = "SELECT u.* FROM users u LEFT JOIN access_company ac ON u.id = ac.user_id WHERE ac.company_id = $company_id and ac.rol_id = 2";
        return $this->loadObjectList($query);
    }
}
