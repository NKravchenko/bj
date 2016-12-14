<?php
namespace Jimm\models;

use Jimm\lib\Model;

class Message extends Model
{
    /*
     * Записываем получинные данные с формы
     */
    public function save($name, $email, $message, $img = null, $message_agreed = 1)
    {
        $values = array(
            ':name'    => $name,
            ':email'   => $email,
            ':message' => $message,
            ':img'     => $img,
            ':message_agreed' => $message_agreed,
        );

        $sql = "
                insert into messages
                set name    = :name,
                    email   = :email,
                    message = :message,
                    img     = :img,
                    message_agreed = :message_agreed
            ";

        $this->db->execute_db($sql, $values);
        return true;
    }

    /*
     * Получить список сообщений с сортировкой по заданным атрибутам и порядку
     */
    public function getListWithSort($sortBy, $sortOrder, $message_agreed = 1)
    {
        //$message_agreed - показывать только проверенные админом сообщения
        $sql = "select * from messages where `message_agreed` = {$message_agreed} ORDER BY {$sortBy} {$sortOrder}";
        return $this->db->query_db($sql);
    }

}