<?php
namespace  App\Dao;
use App\Model\Article;
use App\Dao\BaseDao;
use App\Dao\CommentDao;
use PDO;
class CommentDao extends BaseDao
 {
    public function insert($articleId, $author, $comment)
    {
     $result = $this->db->prepare('INSERT INTO comments( article_id, author, comment, comment_date) VALUES(:article_id, :author, :comment, NOW())');                
     $result->execute(['article_id'=>$articleId,'author' => $author,'comment'=> $comment ]);
    }
    public function getComments($articleId)
    {
        $query = $this->db->prepare('SELECT * FROM comments WHERE article_id=? ORDER BY comment_date DESC');
        $query->execute( [$articleId]);
        $query->setFetchMode(PDO::FETCH_CLASS, Comment::class);                
        return  $query->fetchAll();
    }
    public function regroup()
    {
        $result = $this->db->prepare('SELECT comments.id as c_id , comment,  article_id, articles.id AS a_id, articles.title AS a_title  FROM comments INNER JOIN articles  ON articles.id=article_id ORDER BY article_id'); 
        $result->execute();    
        return  $result->fetchAll();      
    }
    public function delete($id)
    {
        $query = $this->db->prepare('DELETE  FROM comments WHERE id=?');
        $query->execute([$id]);
        return ;
    }
}
