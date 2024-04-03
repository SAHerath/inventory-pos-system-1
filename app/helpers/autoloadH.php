<?php

function autoLoadHandler($className)
{
  $filePath = "../app/libraries/{$className}.php";

  if (!file_exists($filePath)) {
    logger("Autoload not found: {$className}.php", APP_ERROR);
    exit('Error! : Controler does not exists');
    // return false;
  }
  require_once($filePath);
}
