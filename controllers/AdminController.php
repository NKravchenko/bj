<?php
namespace Jimm\controllers;

use Jimm\lib\AjaxResult;
use Jimm\lib\App;
use Jimm\lib\Controller;
use Jimm\lib\FilterData;
use Jimm\lib\View;
use Jimm\models\Admin;

class AdminController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Admin();
    }

    public function index()
    {
        $params = App::getRouter()->getParams();

        //При наличии значения, задаем фильтр сообщений
        $message_agreed = (isset($_GET['filter'])) ? $_GET['filter'] : null;

        $this->data['messages'] = $this->model->getMListWithSort($message_agreed);
    }

    public function editmessageform()
    {
        $result = new AjaxResult();

        $inputPost = $_POST;
        //получаем обновленные данные в БД по id
        $data_val = $this->model->getMsgById($_GET['dict_id']);
        print_r($data_val, 1);

        //рендерим строку таблицы c полученными данными из БД
        //        $layout_path = VIEWS_PATH . DS . 'admin' . DS . 'table_row.html';
        //        $layout_view_object = new View($data_val, $layout_path);
        //        $сontent            = $layout_view_object->render();

        $message = '';
        //рендерим строку таблицы c полученными данными из БД
        $layout_path        = VIEWS_PATH . DS . 'admin' . DS . 'message_form.html.php';
        $layout_view_object = new View($data_val, $layout_path);
        $сontent            = $layout_view_object->render();

        $result->setContentName("table");
        $result->setContent($сontent);
        $result->setMessage($message);
        echo $result->jsonEncode();
        exit();
    }

    public function editMessage()
    {
        $result = new AjaxResult();

        $inputPost = $_POST;

        //отсеиваем спец символы
        $msgId   = FilterData::strip_data($inputPost['id']);
        $msgText = FilterData::strip_data($inputPost['message']);

        //отсылаем данные в БД
        $this->model->updateMsgText($msgId, $msgText);

        //получаем обновленные данные в БД по id
        $data_val = $this->model->getMsgById($msgId);

        //рендерим строку таблицы c полученными данными из БД
        $layout_path        = VIEWS_PATH . DS . 'admin' . DS . 'line.html.php';
        $layout_view_object = new View($data_val, $layout_path);
        $сontent            = $layout_view_object->render();

        $message = '';

        $result->setContentName("table");
        $result->setContent($сontent);
        $result->setMessage($message);
        echo $result->jsonEncode();
        exit();
    }

    public function editmessagestatus()
    {
        $result = new AjaxResult();

        $inputPost = $_POST;

        //отсеиваем спец символы
        $msgId     = FilterData::strip_data($inputPost['dict_id']);
        $msgType   = FilterData::strip_data($inputPost['type']);
        $msgToggle = FilterData::strip_data($inputPost['status']);

        //отсылаем данные в БД
        $this->model->updateMsgStatus($msgId, $msgType, $msgToggle);

        //получаем обновленные данные в БД по id
        $data_val = $this->model->getMsgById($msgId);

        //рентдим строку таблицы c полученными данными из БД
        $layout_path        = VIEWS_PATH . DS . 'admin' . DS . 'line.html.php';
        $layout_view_object = new View($data_val, $layout_path);
        $сontent            = $layout_view_object->render();

        $message = '';

        $result->setContentName("table");
        $result->setContent($сontent);
        $result->setMessage($message);
        echo $result->jsonEncode();
        exit();
    }
}
