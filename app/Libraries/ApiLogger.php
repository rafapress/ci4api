<?php

namespace App\Libraries;

class ApiLogger {

  public static function info(string $message) {
    log_message('info', '[API] ' . $message);
  }

  public static function error(string $message) {
    log_message('error', '[API] ' . $message);
  }

  public static function debug(string $message) {
    log_message('debug', '[API] ' . $message);
  }

}