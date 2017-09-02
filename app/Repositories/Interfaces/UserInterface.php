<?php namespace App\Repositories\Interfaces;

Interface UserInterface
{
   public function findOrCreateWithMobile($mobile);

   public function createWithInfo($datas);

   // public function resetPassword();
}