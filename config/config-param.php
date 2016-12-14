<?php

use Jimm\lib\Config;

Config::set('site name', 'Test task for BeeJee ');

Config::set('routes', array(
    'default' => '',
    'test' => 'test_',
));

Config::set('default_route', 'default');
Config::set('default_controller', 'messages');
Config::set('default_action', 'index');

Config::set('db.host', 'localhost');
Config::set('db.user', 'root');
Config::set('db.password', 'php');
Config::set('db.db_name', 'beejee_task');

Config::set('salt', 'fhajkhdfa323sad');


