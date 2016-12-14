<?php
namespace Jimm\lib;

use PDO;
use PDOException;

class DB
{

    protected $pdo;

    public function __construct($host, $user, $password, $db_name)
    {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec('SET NAMES "utf8"');
            $this->pdo22 = 'pdo22';
        } catch (PDOException $e) {
            $error = 'Невозможно подключиться к серверу БД / Could not connect to DB';
            $this->drop_error($error);
        }
    }

    public function query_db($sql, $column = false) //исли True - получаем единственное значение
    {
        try {
            $result = $this->pdo->query($sql);
        } catch (PDOException $e) {
            $error = 'Ошибка при чтении данных. <br/>' . $e->getMessage();
//            $this->drop_error($error);
        }

        //если результат был булевый, то вернуть его в будевом виде
        if (is_bool($result)) {
            return $result;
        }

        if ($column) {
            //переносим результат запроса в массив $data
            $data = $result->fetch(PDO::FETCH_ASSOC);
        } else {

            //переносим результат запроса в двумерный массив $data
            $data = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {   //PDO::FETCH_NAMED - только ассоциативные ключи
                $data[] = $row;
            }
        }

        return $data;
    }


    public function execute_db($sql, $values = array())
    {
        try {
            $s = $this->pdo->prepare($sql);
            foreach ($values as $key => $value)
            {
                $s->bindValue($key, $value);
            }
            $s->execute();
        } catch (PDOException $e) {
            $error = 'Ошибка при записи данных. <br/>' . $e->getMessage();
            $this->drop_error($error);
        }
    }

    public function drop_error($error)
    {
        //Временное решение
        include '../views/error.php';
        exit();
        //Router::redirect('/error.php');
    }

}
