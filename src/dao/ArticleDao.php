<?php
namespace  App\Dao;

use App\Model\Article;
use App\Dao\BaseDao;
use PDO;

class ArticleDao extends BaseDao
 {
  
      public function count()
      {
        $req = $this->db->prepare('SELECT COUNT(*) AS nbarticles FROM articles');
        $req->execute([]);
        return (int)$req->fetch()['nbarticles'];

      }

    public function artPage($offset,$limit)
    {
       $conditionLimit=(isset($offset))?" LIMIT {$offset},{$limit}":"";
        $req = $this->db->prepare('SELECT * FROM articles ORDER BY id'.$conditionLimit);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_CLASS, Article::class); 
        
    }
    public function findAll()
    {
       
        $req = $this->db->prepare('SELECT * FROM articles ORDER BY id');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_CLASS, Article::class); 
        
    }
    public function lastArticle()
    {
       
        $req = $this->db->prepare('SELECT * FROM articles ORDER BY id DESC LIMIT 1');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_CLASS, Article::class); 
        
    }  
    public function find($id)
    {           
        $req = $this->db->prepare('SELECT * FROM articles WHERE id=?');
        $req->setFetchMode(PDO::FETCH_CLASS, Article::class);
        $req->execute([$id]);
        return $req->fetch();        
    }
    public function delete($id)
    {
        $query = $this->db->prepare('DELETE FROM articles WHERE id=?');
        $query->execute([$id]);
        return;
    }

    public function update($id, $title, $content,$image,$legend)
    {
       $query = $this->db->prepare('UPDATE articles SET title=:title , content=:content, image=:image,legend=:legend  WHERE id=:id');
       $query->execute(['id'=>$id,'title'=>$title,'content'=>$content,'image'=>$image, 'legend'=>$legend]);       
       return;
    }

    public function insert($id, $title, $content,$image,$legend)
    {
     $result = $this->db->prepare('INSERT INTO articles(id, title, content,image, legend, creation_date) VALUES(:id, :title, :content, :image, :legend, NOW())');    
              
        $result->execute(['id'=>$id,'title' => $title,'content'=> $content, 'image'=>$image, 'legend'=>$legend]);
    }


}

