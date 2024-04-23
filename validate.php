<?php

class Validate
{

  public function validateRegister($user)
  {
    $errorMsg = [];
    $messages = [];
    $file = file_get_contents("data/users.json");
    $file = json_decode($file, true);

    if (strlen($user["name"]) < 3) {
      $errorMsg["error_name"] = "O nome deve ter mais que 3 caracteres";
    }

    if (strlen($user["password"]) < 10) {
      $errorMsg["error_password"] = "A senha deve possuir mais de 10 digitos";
    }

    if ($user["password"] != $user["password-confirm"]) {
      $errorMsg["error_password_confirm"] = "Confirmaçao de senha incorreta";
    }

    for ($i = 0; $i < count($file); $i++) {
      if ($file[$i]["email"] == $user["email"]) {
        $errorMsg["error_email"] = "E-mail informado já cadastrado";
        break;
      }
    }
    if (empty($errorMsg)) {
      // Se estiver vazio, adiciona uma mensagem de sucesso ao array $messages
      $messages["success"] = "Registro validado com sucesso";
    } else {
      // Se houver erros, adiciona os erros ao array $messages
      $messages["errors"] = $errorMsg;
    }

    return $messages; // Retorna o array $messages, que agora pode conter mensagens de sucesso ou erro
  }
}
