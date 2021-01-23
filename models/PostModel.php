<?php


namespace app\models;


use app\core\ActiveRecord;
use app\core\Database;

class PostModel extends ActiveRecord
{
    public array $posts = [];
    public ?object $post = null;

    public function getAllPosts()
    {
        $sql = "SELECT p.post_id, p.user_id, p.title, 
                p.body, p.created_at, u.firstname, u.lastname FROM posts as p
                JOIN users as u ON p.user_id=u.id
                ORDER BY p.created_at DESC";
        $statement = Database::prepare($sql);
        $statement->execute();
        $this->posts = $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getPost($id)
    {
        $sql = "SELECT p.post_id, p.user_id, p.title, 
                p.body, p.created_at, u.firstname, u.lastname FROM posts as p
                JOIN users as u ON p.user_id=u.id
                WHERE p.post_id=:id";
        $statement = Database::prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $this->post = $statement->fetchObject();
    }
    public static function tableName(): string
    {
        return 'posts';
    }

    public static function primaryKey(): string
    {
        return 'post_id';
    }
}