<?php


namespace app\models;


use app\core\ActiveRecord;
use app\core\Application;
use app\core\Database;

class Post extends ActiveRecord
{
    public array $posts = [];
    public ?object $post = null;
    public string $title = '';
    public string $body = '';
    public int $post_id;
    public int $user_id;


    public function labels(): array
    {
        return ['title' => 'Title', 'body' => 'Post body'];
    }

    public function rules(): array
    {
        return [
            'title' => [self::RULE_REQUIRED],
            'body' => [self::RULE_REQUIRED],
        ];
    }

    public function attributes(): array
    {
        return ['title', 'body', 'user_id'];
    }
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
        $this->post = $statement->fetchObject(static::class);
    }

    public function addPost()
    {
        $this->user_id = Application::$app->user->id;
        return $this->save();
    }

    public function updatePost($id)
    {
        $sql = "UPDATE posts SET 
                title=:title, 
                body=:body 
                WHERE post_id=:post_id";
        $statement = Database::prepare($sql);
        $statement->bindValue(":title", $this->title);
        $statement->bindValue(":body", $this->body);
        $statement->bindValue(":post_id", $id);
        return $statement->execute();
    }

    public function deletePost($id)
    {
        if((!Application::isGuest() && Application::$app->user->id === $this->post->user_id)){
            $sql = "DELETE FROM posts 
                WHERE post_id=:post_id";
            $statement = Database::prepare($sql);
            $statement->bindValue(":post_id", $id);
            return $statement->execute();
        }
        return false;
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