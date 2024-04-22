<?php
require 'controller/controller.php';
require 'view/view.php';
require 'crud.class.php';

$controller = new Controller();

$page = $_GET['page'] ?? 'not_found';

switch ($page) {
  case 'register':
      $controller->do_register();
      break;
  case 'login':
      $controller->do_login();
      break;
  case 'forget-password':
      $controller->do_forget_password();
      break;
  case 'change_password':
      $controller->do_change_password();
      break;
  default:
      $controller->do_not_found();
      break;
}