<?php
namespace Jimm\models;

use Jimm\lib\Model;

class Admin extends Model
{
    /*
     * Получить список сообщений с сортировкой по заданным атрибутам и порядку
     */
    public function getMListWithSort($message_agreed, $sortOrder = "DESC")
    {

         /*
         Проверяем введенный в GET порядок сортировки,
         по-умолчанию: показывать все сообщения по id в обратном порядке,
         опционально только Согласованные или только Отклоненные.
         */
        switch ($message_agreed) {
            case "agreed":
                $wereVal = "`message_agreed` = 1";
                break;
            case "rejected":
                $wereVal = "`message_agreed` = 0";
                break;
            default: //all
                $wereVal = 1;
        }


        $sql = "select * from messages WHERE {$wereVal} ORDER BY `id` DESC";
        return $this->db->query_db($sql);
    }

    /*
     * Записать отредактированное сообщение updateMsgText($msgId, $msgText);
     */
    public function updateMsgText($id, $message)
           {

              $values = array(
                  ':id'     => $id,
                  ':message' => $message,
                  ':message_changed' => 1,
              );

              $sql = "
                      UPDATE `messages`
                      SET
                        `message` = :message,
                        `message_changed` = :message_changed
                      WHERE
                           `id`   = :id
                  ";

              $this->db->execute_db($sql, $values);
              return true;

           }

    /*
    * Прочитать отредактированное сообщение
    */
    public function getMsgById($id)
        {
            $sql = "select * from messages WHERE `id`= $id";
            return $this->db->query_db($sql, 1);
        }

    /*
    * Записать изменение статуса сообщения и изображения
    */
    public function updateMsgStatus($id, $type, $status)
       {
           $values = array(
               ':id'     => $id,
               ':status' => $status,
           );

           //выбираем атрибут в зависимости $type
           if ($type == "txt") {
               $subject = "`message_agreed`";
           } elseif ($type == "img") {
               $subject = "`img_agreed`";
           } else {
               return false;
           }

           $sql = "
                   UPDATE `messages`
                   SET
                     {$subject} = :status
                   WHERE
                        `id`   = :id
               ";

           $this->db->execute_db($sql, $values);
           return true;
       }

}