<?php
namespace Jimm\controllers;

use Jimm\lib\AjaxResult;
use Jimm\lib\App;
use Jimm\lib\Controller;
use Jimm\lib\FilterData;
use Jimm\lib\ImageHandler;
use Jimm\lib\Session;
use Jimm\lib\SlackNotify;
use Jimm\models\Message;

class MessagesController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Message();
    }

    public function index()
    {
        $params = App::getRouter()->getParams();

        $sortBy = (isset($_GET['sort'])) ? $_GET['sort'] : null;

        /*
         Проверяем введенный в GET порядок сортировки,
         по-умолчанию сортировка по дате в обратном порядке,
         опционально по name и email по алфовиту.
         */
        if (isset($sortBy) && in_array($sortBy, ["name", "email"])) {
            $sortOrder = "ASC";
        } else {
            $sortBy    = "date_add";
            $sortOrder = "DESC";
        }

        $formId                 = uniqid('form');
        $this->data['messages'] = $this->model->getListWithSort($sortBy, $sortOrder);
        $this->data['formId']   = $formId;
        Session::set('formId', $formId);
    }

    public function addMessage()
    {
        if ($_POST) {

            $result = new AjaxResult();

            $inputPost = $_POST;

            //провевряем наличие полей
            if (!$inputPost['name'] || !$inputPost['email'] || !$inputPost['message']) {
                $result->setError("Введите все поля");
                $result->setMessage("Заполните все поля");
                echo $result->jsonEncode();
                exit();
            }

            $formId = Session::get("formId");
            $uploadedName = Session::get("upload_{$formId}");

            //отсеиваем спец символы
            $msgName    = FilterData::strip_data($inputPost['name']);
            $msgEmail   = FilterData::strip_data($inputPost['email']);
            $msgMessage = FilterData::strip_data($inputPost['message']);

            //отсылаем данные в БД
            $this->model->save($msgName, $msgEmail, $msgMessage, $uploadedName);

            SlackNotify::sendMessage("*msgName*: {$msgName}\n *msgEmail*: {$msgEmail}\n *msgMessage*: {$msgMessage}", SlackNotify::CHANNEL_BEEJEE, 'NewMessage');

            $message = 'Ваш комментарий отправлен на проверку. Спасибо. ';


            $result->setMessage($message);
            echo $result->jsonEncode();
            exit();
        }
    }

    public function addImage()
    {

        $wwwroot = __DIR__ . '/../webroot';
        $imageHandler = new ImageHandler("{$wwwroot}/uploads", "{$wwwroot}/uploads/thumbs");
        $params       = [
            'image' => ['width' => 320, 'height' => 240],
            'thumb' => ['width' => 100, 'height' => 100]
        ];

        $content = "";
        foreach ($_FILES as $uploadFile) {
            $generatedName = $imageHandler->uploadHandle($uploadFile, $params);
            $content       = "<img src='/uploads/thumbs/{$generatedName}'>";
            SlackNotify::sendMessage("upload image: http://bj.kram-dev.ru/uploads/{$generatedName}", SlackNotify::CHANNEL_BEEJEE, 'bjUpload');

            $formId = Session::get('formId');
            Session::set("upload_{$formId}", $generatedName);
        }

        echo $content;
        exit();
    }
}

