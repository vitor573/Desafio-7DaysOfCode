<?php

Class validate {
  public function emailExists($user)
  {
    $file = file_get_contents("data/users.json");
    $file = json_decode($file, true);
    $emailExists = false;
    for ($i = 0; $i < count($file); $i++) {
      if ($file[$i]["email"] == $user["person"]["email"]) {
        $emailExists = true;
        break;
      }
    }
    return $emailExists;
  }

  public function validatePassword($user)
  {
    $file = file_get_contents("data/users.json");
    $file = json_decode($file, true);
  }

  public function validateEmail()
  {
    
  }
  
}