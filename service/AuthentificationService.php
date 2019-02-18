<?php
namespace App\Controller;

class AuthentificationService
{
    public function createCookie()
        {
        setcookie('p5_blog', 'p5_blog',time()+1200);
        }
    public function isAuthenticated()
        {
         return isset($_COOKIE['p5_blog']);
        }   
    public function clearCookie()
        {
        setcookie('p5_blog', 'p5_blog',time()-1);
        }
}
