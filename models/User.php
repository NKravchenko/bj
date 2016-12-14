<?php
namespace Jimm\models;

use Jimm\lib\Model;
use Jimm\lib\Config;

class User extends Model
{
    public function getByLogin($login)
    {
        $sql = "select * from users where login = '{$login}' limit 1";
        $result = $this->db->query_db($sql);
        if (isset($result[0]))
        {
            return $result[0];
        }
        return false;
    }

    public function setAdmin($login, $psw)
    {

        $values = array(
            ':login'    => $login,
            ':password' => md5(Config::get('salt') . $psw),
            ':isactive' => 1,
            ':role'     => "admin"
        );

        $sql = "
                        insert into users
                        set login    = :login,
                            password   = :password,
                            isactive = :isactive,
                            role     = :role
                    ";

        $this->db->execute_db($sql, $values);

        return true;
    }

}
