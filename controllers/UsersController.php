<?php
namespace Jimm\Controllers;

use Jimm\lib\Controller;
use Jimm\lib\Session;
use Jimm\lib\Router;
use Jimm\lib\Config;
use Jimm\models\User;

class UsersController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new User();
    }

    public function login()
    {
        if ($_POST && isset($_POST['login']) && isset($_POST['password'])) {
            $user = $this->model->getByLogin($_POST['login']);
            $hash = md5(Config::get('salt') . $_POST['password']);
            if ($user && $user['isactive'] && $hash == $user['password']) {
                Session::set('login', $user['login']);
                Session::set('role', $user['role']);
            }
            Router::redirect('/admin');
        }
    }

    public function logout()
    {
        Session::destroy();
        Router::redirect('/users/login');
    }

    /*
     * админ учетка для тестов
     */
//    public function addAdmin()
//        {
//            $this->model->setAdmin("admin", 123);
//
//            echo "ок!";
//            die();
//        }
}