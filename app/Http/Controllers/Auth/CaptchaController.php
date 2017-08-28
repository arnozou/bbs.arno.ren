<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\CaptchaSendMobile;
use App\Http\Controllers\ApiController;
use App\Repositories\Interfaces\AuthcodeInterface;
use App\Utils\AliyunSms;

class CaptchaController extends ApiController
{

  public function sendToMobile(CaptchaSendMobile $request, AuthcodeInterface $authcodeRepository, AliyunSms $sms)
  {
    
    $mobile = $request->input('mobile');
    $ip = $request->ip();
    $authcodes = $authcodeRepository->getRecords($mobile, $ip, 360);

    if (count($authcodes) > 6) {
      return $this->response->errorForbidden('申请频率过高');
    }

    $codes = array_column($authcodes->toArray(), 'code');
    do {
      $code = mt_rand(100000, 999999);
    } while (in_array($code, $codes));

    if ($authcodeRepository->newRecord($mobile, $ip, 3600, $code)) {
      $response = $sms->sendSms(
          "arno邹", // 短信签名
          "SMS_89085006", // 短信模板编号
          "13424463876", // 短信接收者
          Array(  // 短信模板中字段的值
              "code"=>$code,
              // "product"=>"dsd"
          )
          // "123"
      );
      logger(print_r($response, 1));

      return $this->response->created('验证码已经发送');
    } else {
      logger()->error('fail in newRecord Authcode');

      return $this->response->errorInternal();
    }
  }
}
