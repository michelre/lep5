<?php
namespace  App\Dao;

use App\Model\User;
use App\Dao\BaseDao;
use PDO;
try{
class UserDao extends BaseDao
 {
    public function select($name)
    {
        $query = $this->db->prepare('SELECT name, pass FROM user WHERE name=?')or die(print_r($bdd->errorInfo()));
        $query ->setFetchMode(PDO::FETCH_CLASS, User::class);
        $query->execute(array($name));
         return $query->fetch();
    }  

}
} catch (\Exception $e) {
    var_dump($e->getMessage());
   }