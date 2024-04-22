<?php

class View{

  public function render_view($template)
  {
    include "view/{$template}.view";
  }
}