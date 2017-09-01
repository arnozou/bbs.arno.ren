<?php
namespace App\Repositories\Traits;

trait StringInputTrait
{
  public function filterString(&$strings)
  {
    if (is_array($strings)) {
      $strings = filter_var_array($strings, FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
      $strings = filter_var($strings, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    return $strings;
  }
}