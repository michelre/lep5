<?php
namespace App\Service;
use App\Model\Article;
use App\Dao\BaseDao;
use PDO;

class FileService
{
       public function chargeImage()
        {
            $file = $files->get('image');
            $target_dir = "public/uploads/";
            $extensions = [  
               'image/jpeg'=>'.jpg',
               'image/png'=>'.png'
            ];
            
           $imageName = uniqid().$extensions[$file['type']];
             move_uploaded_file($file["tmp_name"], $target_dir.$imageName);  
        }
        public function supprimImage($id)
        {
            $re = '/uploads\/(.*)$/m';
               preg_match($re, $article->getImage(), $matches);                                             
                  unlink("public/uploads/".$matches[1]); 
        }

}
