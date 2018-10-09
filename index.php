<?php

//INCLUDE THE FILES NEEDED...
require_once 'view/LoginView.php';
require_once 'view/DateTimeView.php';
require_once 'view/LayoutView.php';
require_once 'view/RegisterView.php';
require_once 'controller/LoginController.php';
require_once 'controller/RegisterController.php';
require_once 'controller/MainController.php';
require_once 'model/LoginModel.php';
require_once 'model/RegisterModel.php';
require_once 'model/Credentials.php';
require_once 'model/StatusMessage.php';
require_once 'model/Database.php';
require_once 'model/Cookies.php';
require_once 'config.php';

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
$dtv = new DateTimeView();
$lv = new LayoutView();
$lm = new LoginModel();
$rv = new RegisterView();
$mc = new MainController($v, $dtv, $lv, $lm, $rv);

$mc->render();
