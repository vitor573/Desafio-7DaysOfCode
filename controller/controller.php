<?php

class Controller
{
  private $view;
  private $crud;
  private $validate;

  public function __construct()
  {
    $this->view = new View();
    $this->crud = new Crud();
    $this->validate = new Validate();
  }

  public function do_register()
  {
    if (isset($_POST["person"])) {
      $mensages = $this->validate->validateRegister($_POST["person"]);
      if ($mensages["success"]) {
        $this->crud->crud_create($_POST["person"]);
        $this->view->render_view('login',$mensages);
      }else{
        $this->view->render_view('register', $mensages);
      }
    } else {
      $this->view->render_view('register');
    }
  }

  public function do_login()
  {
    if (isset($_POST["person"])) {
      $this->view->render_view('home');
    } else {
      $this->view->render_view('login');
    }
  }

  public function do_not_found()
  {
    $this->view->render_view('not_found');
  }
  public function do_forget_password()
  {
    $this->view->render_view('forget_password');
  }
  public function do_change_password()
  {
    $this->view->render_view('change_password');
  }
}
