<?php

function logger($msg, $path)
{
  error_log(date('D d-M-Y H:i:s e | ') . $msg . PHP_EOL, 3, $path);
}
