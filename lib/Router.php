<?php
namespace Jimm\lib;

use Jimm\lib\Config;

class Router
{

    protected $uri;
    protected $controller;
    protected $action;
    protected $params;

    protected $route;
    protected $method_prefix;

    public function __construct($uri)
       {
           $this->uri = urldecode(trim($uri, '/'));

           //Задаем значения по-умолчанию из класса Config
           $routes = Config::get('routes');
           $this->route = Config::get('default_route');
           $this->method_prefix = '';
//           $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
           $this->controller = Config::get('default_controller');
           $this->action = Config::get('default_action');

           //все что после "?" в ячейку $uri_parts[1];
           $uri_parts = explode('?', $this->uri);

           //получаем массив из ссылку типа /lng/controller/action/param1/param2
           $path = $uri_parts[0];
           $path_parts = explode('/', $path);


           //если $path_parts содержит элементы, то
           if (count($path_parts)) {

               /*
                * определяем контроллер
                */
               //Get controller - next element of array
               if (current($path_parts)) {
                   $this->controller = strtolower(current($path_parts));
                   array_shift($path_parts);
               }

               //Get action
               if (current($path_parts)) {
                   $this->action = strtolower(current($path_parts));
                   array_shift($path_parts);
               }

               //Get params - all the rest
               $this->params = $path_parts;
           }
       }


       public static function redirect($location)
       {
           header("Location: $location");
       }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return mixed
     */
    public function getMethodPrefix()
    {
        return $this->method_prefix;
    }



}