<?php
namespace Jimm\lib;

use Jimm\lib\Router;
use Jimm\lib\Config;
use Jimm\lib\Controller;
use Jimm\lib\DB;
use Jimm\lib\Session;
use Jimm\lib\View;

use Exception;

class App
{
    protected static $router;

    public static $db;

    public static function getRouter()
    {
        return self::$router;
    }

    public static function run($uri)
    {


        self::$router = new Router($uri);

        //создадим объект класса DB
        self::$db = new DB(Config::get('db.host'), Config::get('db.user'), Config::get('db.password'), Config::get('db.db_name'));

        //записываем имя контроллера полученное из адресной строки
        $controller_class = 'Jimm\controllers\\' . ucfirst(self::$router->getController()) . 'Controller';


        //записываем имя акшена полученное из адресной строки
        $controller_method = strtolower(self::$router->getAction());

        $layout = self::$router->getRoute();


        //Проверка доступа в админ-панель
        if(self::$router->getController() == 'admin' && Session::get('role') !='admin')
        {
            if ($controller_method != 'login')
            {
                Router::redirect('/users/login');
            }
        }


        //создаем объект контроллера
        $controller_object = new $controller_class();

        if (method_exists($controller_object, $controller_method)) {
            // рендрим вьюху вложенную в body
            $view_path = $controller_object->$controller_method();
            $view_object = new View($controller_object->getData(), $view_path);
            $content = $view_object->render();
        } else {
            throw new Exception('Method ' . $controller_method . ' of class ' . $controller_class . ' does not exist.');
        }

        //рентдим основную вьюху с вложенным рендренгом содержимого body
        $layout_path = VIEWS_PATH . DS . 'default.html';
        $layout_view_object = new View(compact('content'), $layout_path);
        echo $layout_view_object->render();

    }
}