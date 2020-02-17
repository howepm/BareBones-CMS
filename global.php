<?php

  define('GLOBAL_CWD', getcwd() . '/');

  require_once('config.php');

  require_once(GLOBAL_CWD . 'Engine/Class/Page.php');
  require_once(GLOBAL_CWD . 'Engine/Class/Module.php');

  require_once(GLOBAL_CWD . 'Engine/Class/Theme.php');
  require_once(GLOBAL_CWD . 'Engine/Class/Template.php');

  require_once(GLOBAL_CWD . 'Engine/Class/Database.php');
  require_once(GLOBAL_CWD . 'Engine/Class/Database/MySQLi.php');

  $Page = new Page($Config);
?>