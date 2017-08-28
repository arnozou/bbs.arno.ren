<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authcode extends Model
{
  protected $casts = [
    'is_used' => 'boolean',
    'expire_at' => 'timestamp',
  ];
  protected $dates = ['created_at', 'updated_at', 'expire_at'];

  public function getIpAttribute($intip)
  {
    return long2ip($intip);
  }

  public function setIpAttribute($ip)
  {
    $this->attributes['ip'] = ip2long($ip);
  }
}
