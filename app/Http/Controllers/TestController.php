<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\AliyunSms;
use App\Repositories\Interfaces\UserInterface;
use App\User;
use Faker\Generator as Faker;

class TestController extends ApiController
{
    public function test(UserInterface $userRepository, Faker $faker)
    {
      // $this->testSms($sms);
      $user = new User();
      $user->mobile = mt_rand(1000000,50000000);

      $userRepository->CreateWithEmail($faker->email, 1234);

    }

    public function testSms(AliyunSms $sms)
    {
      $response = $sms->sendSms(
          "arno邹", // 短信签名
          "SMS_89085006", // 短信模板编号
          "13424463876", // 短信接收者
          Array(  // 短信模板中字段的值
              "code"=>"12345",
              // "product"=>"dsd"
          )
          // "123"
      );

      print_r($response);
    }
}
