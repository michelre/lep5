<?php
namespace App\Service;
use Firebase\JWT\JWT;
class AuthentificationService
{
      private $key = "zarco_lep5";
      public function createToken($id)
      {
          $token = array(
              "userId" => $id,
              "exp" => time() + 1200
          );
          return JWT::encode($token, $this->key);
      }
      public function isAuthenticated($token)
      {
          try {
              $decoded = JWT::decode($token, $this->key, array('HS256'));
              return $decoded;
          } catch (\Exception $e){
              return false;
          }
      }
      public function disconnect(){
          setcookie('p5_token');
      }
}