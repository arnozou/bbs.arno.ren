<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\AliyunSms;
use App\Repositories\Interfaces\UserInterface;
use App\User;
use Faker\Generator as Faker;
use Bouncer;
use Validator;
class TestController extends ApiController
{
    public function test(UserInterface $userRepository, Faker $faker)
    {
      // $this->testSms($sms);
      /*$user = new User();
      $user->mobile = mt_rand(1000000,50000000);

      $userRepository->CreateWithEmail($faker->email, 1234);*/
      echo 'test\n';
      $this->testBouncer();
      // $this->testValidator();
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

    public function testBouncer()
    {
      // $a = Bouncer::allow('admin')->to('ban-users');
      // print_r($a);
      $user = \App\User::find(1);
      var_dump($user->toArray());
      $topic = \App\Topic::find(1);
      var_dump($topic->toArray());
      var_dump(\Gate::forUser($user)->allows('edit-topic', $topic));
      echo 1;
    }

    public function testValidator()
    {
      $a = new Validator();
      print_r($a);
      $c = $a::make(['a' => 1], [
        'a' => 'string',
      ]);

      var_dump($c instanceOf \Illuminate\Validation\Validator );
      $b = Validator::make(['a' => 1], [
        'a' => 'string',
      ]);

      // print_r($b);
    }
}
