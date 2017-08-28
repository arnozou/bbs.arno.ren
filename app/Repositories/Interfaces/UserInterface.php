<?php namespace App\Repositories\Interfaces;

Interface UserInterface
{
  public function findById($id);

   public function findOrCreateWithMobile($mobile);

   public function findByEmail($email);

   public function CreateWithEmail($email, $password);
}