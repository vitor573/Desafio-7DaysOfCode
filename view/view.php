<?php

class View {
    private $viewFolder;

    public function __construct($viewFolder = 'view/') {
        $this->viewFolder = $viewFolder;
    }

    public function render_view($template, $messages = []) {
        $content = $this->load_content($template, $messages);
        echo $content;
    }

    private function load_content($template, $messages) {
        $validation_errors = $messages['errors'] ?? [];
        $success_msg = $messages['success'] ?? '';
        $content = file_get_contents($this->viewFolder . "$template.view");
        $content = $this->put_error_data($content, $validation_errors);
        $content = $this->put_success_msg($content, $success_msg);
        $content = $this->put_old_values($content);
        return $content;
    }

    private function put_success_msg($content, $success_msg) {
        $success_msg = $this->success_msg_maker($success_msg);
        $content = $this->data_binding($content, ['{{success}}' => $success_msg]);
        return $content;
    }

    private function put_old_values($content) {
        $value_places = $this->get_value_places($content);
        $values = $this->prepare_old_values($value_places);
        $content = $this->data_binding($content, $values);
        return $content;
    }

    private function prepare_old_values($value_places) {
        $values = [];
        foreach ($value_places as $place) {
            $field = str_replace('{{value_', '', $place);
            $field = str_replace('}}', '', $field);
            $field = str_replace('_', '-', $field);
            $values[$place] = $_POST['person'][$field] ?? '';
        }
        return $values;
    }

    private function put_error_data($content, $validation_errors) {
        $error_places = $this->get_error_places($content);
        $errors_msg = $this->create_errors_msg($validation_errors, $error_places);
        $content = $this->data_binding($content, $errors_msg);
        return $content;
    }

    private function data_binding($content, $values) {
        foreach ($values as $place => $value) {
            $content = str_replace($place, $value, $content);
        }
        return $content;
    }

    private function create_errors_msg($validation_errors, $error_places) {
      $errors_msg = [];
      foreach ($error_places as $place) {
          $field = str_replace('{{error_', '', $place);
          $field = str_replace('}}', '', $field);
          $field = str_replace('_', '-', $field);
          $key = 'error_' . $field;
          $errors_msg[$place] = isset($validation_errors[$key]) ? $this->error_msg_maker($validation_errors[$key]) : ''; 
      }
      return $errors_msg;
  }

    private function error_msg_maker($msg) {
        $error = '<span class="mensagem-erro">' . $msg . '</span>';
        return $error;
    }

    private function success_msg_maker($msg) {
        $success = '<div class="mensagem-sucesso">
        <p>' . $msg . '</p>
    </div>';
        return $success;
    }

    private function get_error_places($content) {
        return $this->get_place_of('error', $content);
    }

    private function get_value_places($content) {
        return $this->get_place_of('value', $content);
    }

    private function get_place_of($field, $content) {
        $pattern = "/{{" . $field . "\w+}}/";
        preg_match_all($pattern, $content, $match);
        return $match[0] ?? [];
    }
}
