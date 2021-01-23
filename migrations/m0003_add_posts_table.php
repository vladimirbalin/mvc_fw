<?php

namespace app\migrations;

use \app\core\Application;
use app\core\Database;

class m0003_add_posts_table
{
    private Database $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }

    public function up()
    {
        $sql = "CREATE TABLE posts ( 
                    `post_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `user_id` INT NOT NULL, 
                    `title` VARCHAR(255) NOT NULL, 
                    `body` TEXT NOT NULL, 
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE = INNODB;";
        $this->db->pdo->exec($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE posts;";
        $this->db->pdo->exec($sql);
    }
}