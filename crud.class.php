<?php

class Crud
{

  public function crud_create($user)
  {
    $file = file_get_contents("data/users.json");
    $file = json_decode($file, true);
    $file[] = $user;
    file_put_contents("data/users.json", json_encode($file, JSON_PRETTY_PRINT));
  }
}
