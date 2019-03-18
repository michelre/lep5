<?php

namespace App\Controller;

use App\Dao\EventDao;
use App\Dao\ArticleDao;
use App\Dao\CommentDao;
use App\Dao\UserDao;
use App\Dao\BaseDao;
use App\Model\User;
use App\Service\AuthentificationService;
use App\Service\FileService;


try{
class BackendController
{
    private $eventDao;
    private $articleDao;
    private $commentDao;
    private $userDao;
    private $twig;
    private $authentificationService;
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
        $this->authentificationService = new AuthentificationService();
        $this->twig = $twig;
    }


    public function admin()
    {       
            $articles = $this->articleDao->findAll();
            $events = $this->eventDao->findEvents();
            $result = $this->commentDao->regroup();
            return $this->twig->render('backend/home.html.twig',['result'=>$result, 'events'=>$events,'articles'=>$articles]);       
    }


           public function disconnect(){
           $this->authentificationService->disconnect();
           header('Location: /connect');
           die();
           }
   
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

               $imageNameDb = $article->getImage(); 
            
               if($files->get('image')['tmp_name']!='') {   
              $re = '/uploads\/(.*)$/m';
               preg_match($re, $article->getImage(), $matches);                                             
                  unlink("public/uploads/".$matches[1]);

                  $file = $files->get('image');
                 
                  $target_dir = "public/uploads/";
                  $extensions = [  
                     'image/jpeg'=>'.jpg',
                     'image/png'=>'.png'
                  ];
                 
                  $imageName = uniqid().$extensions[$file['type']];             
                  move_uploaded_file($file["tmp_name"], $target_dir.$imageName);
                  $imageNameDb = '/public/uploads/'.$imageName;
               }
                                   
            $this->articleDao->update($id,$formData->get("title"),$formData->get("content"),$imageNameDb, $formData->get("legend"));
                       
            header('location: /admin');
            die();                 
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
                 
                 $this->articleDao->insert($formData->get("id"),$formData->get("title"),$formData->get("content"),'/public/uploads/'.$imageName, $formData->get("legend"));
               
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

                   public function changeEvent($id,$formData,$files)
                   {
                     
                      $events = $this->eventDao->findEvents();
                      $event = $this->eventDao->find($id);

                      $imageNameDb = $event->getImage(); 
            
                      if($files->get('image')['tmp_name']!='') {   
                        $re = '/uploads\/(.*)$/m';
                         preg_match($re, $event->getImage(), $matches);                                             
                            unlink("public/uploads/".$matches[1]);
          
                            $file = $files->get('image');
                           
                            $target_dir = "public/uploads/";
                            $extensions = [  
                               'image/jpeg'=>'.jpg',
                               'image/png'=>'.png'
                            ];
                           
                            $imageName = uniqid().$extensions[$file['type']];             
                            move_uploaded_file($file["tmp_name"], $target_dir.$imageName);
                            $imageNameDb = '/public/uploads/'.$imageName;
                         }

                      $this->eventDao->update($id,$formData->get("title"),$formData->get("states"),$imageNameDb, $formData->get("legend"));
                      header('location: /admin');
                      die();
                     
                   }
                   
                public function supprimEvent($id)
               {
                  $event = $this->eventDao->find($id);
                  
                  $supprim = $this->eventDao->delete($id);
                  $re = '/uploads\/(.*)$/m';
                  preg_match($re, $event->getImage(), $matches);                    
                  unlink("public/uploads/".$matches[1]);
                  header('location: /admin');
                  die();  
              
               }

              public function addEvent($formData,$files)
              {
              
                $events = $this->eventDao->findEvents();
            
               $file = $files->get('eimage');
               $target_dir = 'public/uploads/';
               $extensions = [  
                  'image/jpeg'=>'.jpg',
                  'image/png'=>'.png'
               ];
               
               $imageName = uniqid().$extensions[$file['type']];
                   move_uploaded_file($file["tmp_name"], $target_dir.$imageName);
                
                $this->eventDao->insert($formData->get("id"),$formData->get("title"),$formData->get("states"),'/public/uploads/'.$imageName, $formData->get("legend"));
               
                 header('location: /admin');
                 die(); 
               
              }

              /**
     * @param array $payload
     */
    public function loginAction($payload)
    {
        /** @var User $user */
        $user = $this->userDao->select($payload['login'], $payload['password']);
        $isPasswordCorrect = password_verify($payload['password'], $user->getPass());
        if($isPasswordCorrect){
            $token = $this->authentificationService->createToken($user->getId());
            return json_encode(['status' => 'ok', 'token' => $token]);
        }
        return json_encode(['status' => 'ko']);
    }
                       
      }
   }
catch (\Exception $e) {
   var_dump($e->getMessage("mais dis donc! il y a une erreur là!"));
  }
