<?php

namespace App\Controller;

use App\Dao\EventDao;
use App\Dao\ArticleDao;
use App\Dao\CommentDao;
use App\Dao\UserDao;
use App\Dao\BaseDao;

try{
class BackendController
{
    private $eventDao;
    private $articleDao;
    private $commentDao;
    private $userDao;
    private $twig;

    /**
     * BackendController constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct($twig)
    {
        $this->eventDao = new EventDao();
        $this->articleDao = new ArticleDao();
        $this->commentDao = new CommentDao();
        $this->userDao = new UserDao();
        $this->twig = $twig;
    }

   /* public function connection()
    {
      $articles = $this->articleDao->findAll();
      $events = $this->eventDao->findEvents();
      $result = $this->commentDao->regroup();
        return $this->twig->render('backend/home.html.twig',['result'=>$result,'events'=>$events,'articles'=>$articles]);
        
    }*/
    

    public function driveComment()
    {
      $articles = $this->articleDao->findAll();
      $events = $this->eventDao->findEvents();
         $result = $this->commentDao->regroup();
         
         return $this->twig->render('backend/home.html.twig',['result'=>$result,'events'=>$events, 'articles'=>$articles]);
         
         }


    public function destroy($id)
         {
            $destroyed = $this->commentDao->delete($id);
            header('location: /admin');
            die();   
         }

         public function modifyArticle($id)
         {
            $articles = $this->articleDao->findAll();
            $events = $this->eventDao->findEvents();
            $article = $this->articleDao->find($id);
              return $this->twig->render('backend/modifyArticle.html.twig',[ 'article'=>$article,'events'=>$events,'articles'=>$articles]);
              
              }  

        public function changeArticle($id,$formData,$files)
         {
            $articles = $this->articleDao->findAll();
            $article = $this->articleDao->find($id);

            $file = $files->get('image');
                  $target_dir = "public/uploads/";
                  $extensions = [  
                     'image/jpeg'=>'.jpg',
                     'image/png'=>'png'
                  ];
                  $imageName = uniqid().$extensions[$file['type']];
                  
            if(is_file($image))
            {
            unlink('public/uploads/$imageName');
            move_uploaded_file($file["tmp_name"], $target_dir.$imageName);
            $this->articleDao->update($id,$formData->get("title"),$formData->get("content"),'/public/uploads/'.$imageName,$formData->get("legend"));
            
           
           // header('location: /admin');
           // die();
            }           
         }
         


         
            
              public function addArticle($formData,$files)
              {
                  $articles = $this->articleDao->findAll();
                  $events = $this->eventDao->findEvents();
                 
                  $file = $files->get('image');
                  $target_dir = "public/uploads/";
                  $extensions = [  
                     'image/jpeg'=>'.jpg',
                     'image/png'=>'.png'
                  ];
                  
                 $imageName = uniqid().$extensions[$file['type']];
                   move_uploaded_file($file["tmp_name"], $target_dir.$imageName);
                  
                
                 $this->articleDao->insert($formData->get("id"),$formData->get("title"),$formData->get("content"),'/public/uploads/'.$imageName,$formData->get("legend"));
               
                 header('location: /admin');
                  die();              
              }

              public function supprimArticle($id)
              {
                 $article = $this->articleDao->find($id);            
                 $supprim = $this->articleDao->delete($id);
                $re = '/uploads\/(.*)$/m';
                preg_match($re, $article->getImage(), $matches);
               
                                   
                   unlink("public/uploads/".$matches[1]);
                  
                 header('location: /admin');
               die();
                  
              }

              public function modifyEvent($id)
              {
               $events = $this->eventDao->findEvents();
               $articles = $this->articleDao->findAll();
               $event = $this->eventDao->find($id);
                   return $this->twig->render('backend/modifyEvent.html.twig',['events'=>$events,  'event'=>$event, 'article'=>$article,'articles'=>$articles]);
                  
              } 

                   public function changeEvent($id,$formData)
                   {
                      $articles = $this->articleDao->findAll();
                      $article = $this->articleDao->find($id);
                      
                      $this->eventDao->update($id,$formData->get("title"),$formData->get("states"));
                      header('location: /admin');
                      die();
                   }
                   
                public function supprimEvent($id)
               {
                  $supprim = $this->eventDao->delete($id);
                  header('location: /admin');
                  die();  
               }

              public function addEvent($formData,$files)
              {
                $articles = $this->articleDao->findAll();
                $article = $this->articleDao->find($id);
                $events = $this->eventDao->findEvents();
               
               $file = $files->get('eimage');
               $target_dir = 'public/uploads/';
               $extensions = [  
                  
                  'image/jpeg'=>'.jpg',
                  'image/png'=>'.png'
               ];
               $eimageName = uniqid().$extensions[$file['type']];
                 move_uploaded_file($file["tmp_name"], $target_dir.$eimageName);

                $this->eventDao->insert($formData->get("id"),$formData->get("title"),$formData->get("states"),'/public/uploads/'.$eimageName, $formData->get("legend"));
                
      
          // return $this->twig->render('frontend/home.html.twig',['article'=>$article,'articles'=>$articles,'events'=>$events]);
            //     die();
                 header('location: /admin');
                 die();  
              }

              public function verify($name,$pass)
              {
                $articles = $this->articleDao->findAll();
                $events = $this->eventDao->findEvents();
                $result = $this->commentDao->regroup();
                $user = $this->userDao->select($name,$pass);
               
               $isPasswordCorrect = password_verify($pass, $user->getPass()); 
                
               if ($isPasswordCorrect)                  
                  {
                     // $this->authentificationService->createCookie();                                        
                  return $this->twig->render('backend/home.html.twig',['result'=>$result,'events'=>$events, 'articles'=>$articles]);
                 }
               }
                       
      }
   }
catch (\Exception $e) {
   var_dump($e->getMessage());
  }
