<?php
namespace App\Router;

use App\Controller\FrontendController;
use App\Controller\BackendController;
use Klein\Klein;

class Router
{
    private $klein;
    private $frontendController;
    private $backendController;

    public function __construct($twig)
    {
        $this->klein = new Klein();
        $this->frontendController = new FrontendController($twig);
        $this->backendController = new BackendController($twig);
    }

        public function run()
        {
            $this->klein->respond('GET', '/', function () {
                return $this->frontendController->home();
            });

            $this->klein->respond('GET', '/les_articles', function ($request) {
                return $this->frontendController->pageArticles($request->param('offset'),$request->param('limit'));
            });

            $this->klein->respond('GET', '/les_events', function ($request) {
                return $this->frontendController->pageEvents($request->param('offset'),$request->param('limit'));
            });
            
            $this->klein->respond('GET', '/events', function(){
            return $this->frontendController->findEvents();
            });

            $this->klein->respond('GET', '/event/[:id]', function($request){
                return $this->frontendController->findEvent($request->id);
            });

                $this->klein->respond('/public/[*]', function($request, $response, $service, $app) {
                $file = __DIR__ . '/../..' .  $request->pathname();
                $type = \MimeType\MimeType::getType($file); // returns "application/pdf"
                $response->header('content-type',$type);
                return file_get_contents($file);
               });

                $this->klein->respond('GET', '/articles', function(){
                return $this->frontendController->findAll();
                });

                $this->klein->respond('GET', '/article/[:id]', function($request){
                return $this->frontendController->findArticle($request->id);
                });

                $this->klein->respond('GET', '/admin', function(){
                    return $this->frontendController->admin();   
                });

                $this->klein->respond('GET', '/contact', function(){
                    return $this->frontendController->contact();   
                });

                $this->klein->respond('POST', '/addComment/[:article_id]', function($request){
                    return $this->frontendController->addComment($request->article_id, $request->paramsPost());
                    });
    
                $this->klein->respond('GET', '/connect', function(){
                        return $this->frontendController->connect();   
                    });
    
                    $this->klein->respond('GET', '/driveComment', function($request){
                        return $this->backendController->driveComment($request->article_id);   
                    });

                    $this->klein->respond('GET', '/driveComment/[:id]', function($request){
                        return $this->backendController->destroy($request->id);   
                    });

                    $this->klein->respond('GET', '/modifyArticle/[:id]', function($request){
                        return $this->backendController->modifyArticle($request->id);   
                    });

                    $this->klein->respond('POST', '/changeArticle/[:id]', function($request){
                        return $this->backendController->changeArticle($request->id,$request->paramsPost());   
                    });

                    $this->klein->respond('POST', '/addArticle', function($request){
                        return $this->backendController->addArticle( $request->paramsPost(),$request->files());
                     });


                    $this->klein->respond('POST', '/supprimArticle/[:id]', function($request){
                        return $this->backendController->supprimArticle($request->id);   
                    });

                    $this->klein->respond('GET', '/modifyEvent/[:id]', function($request){
                        return $this->backendController->modifyEvent($request->id);   
                    });

                    $this->klein->respond('POST', '/changeEvent/[:id]', function($request){
                        return $this->backendController->changeEvent($request->id,$request->paramsPost());   
                    });



                    $this->klein->respond('POST', '/supprimEvent/[:id]', function($request){
                        return $this->backendController->supprimEvent($request->id);   
                    });


                    $this->klein->respond('POST', '/addEvent', function($request){
                        return $this->backendController->addEvent( $request->paramsPost());
                        });

                    $this->klein->respond('POST', '/contact/', function($request){
                        return $this->frontendController->postContact($request->paramsPost());
                        });

                    $this->klein->respond('POST', '/connection/', function($request){
                        return $this->backendController->verify($request->name,$request->pass);
                        });  
    
                    /* $this->klein->respond('POST', '/upload', function($files){
                            return $this->backendController->uploadImage($files->name);
                            }); */    


                   $this->klein->dispatch();
        }
   
}
