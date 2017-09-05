<?php

namespace App\Transformers\Traits;

use Carbon\Carbon;

trait CarbonTrait
{
  public function carbonTrans($date)
  {
    if ($date instanceof Carbon) {
      return $date->toDateTimeString();
    }

    return $date;
  }

  public function diffForHumans(Carbon $date)
  {
    // $now = Carbon::now();
    return $date->diffForHumans();
  }
}
