<?php

  // ini_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);

  if($argc < 2) die("no args");

  include("resources/php/classes/slide.class.php");

  $action = $argv[1];

  if($action === "get" && $argc >= 4)
  {
    $id = $argv[2];
    $main = $argv[3];

    $slide = new Slide($id);

    $slide->generate($main);
  }

?>
