<?php
namespace Jimm\lib;

use Jimm\lib\App;

class Model
{

    protected $db;

    public function __construct()
    {
        $this->db = App::$db;
    }

}