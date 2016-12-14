<?php
namespace Jimm\lib;

class AjaxResult
{
    private $result = false;
    private $error;
    private $content;
    private $redirect;
    private $contentName = "inline";   //дополнительная метка какие данные вернулись с сервера
    private $message;       //дополнительное сообщение которое будет показано пользователю
    private $data;          //поле для передачи каких либо данных в json формате

    public function jsonEncode()
    {
        return json_encode(
            array(
                'result'      => $this->result,
                'error'       => $this->error,
                'content'     => $this->content,
                'redirect'    => $this->redirect,
                'contentName' => $this->contentName,
                'message'     => $this->message,
                'data'        => $this->data
            )
        );
    }

    /**
     * @return boolean
     */
    public function isResult()
    {
        return $this->result;
    }

    /**
     * @param boolean $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * @param mixed $redirect
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * @return string
     */
    public function getContentName()
    {
        return $this->contentName;
    }

    /**
     * @param string $contentName
     */
    public function setContentName($contentName)
    {
        $this->contentName = $contentName;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

}