<?php

namespace app\migrations;

use \app\core\Application;
use app\core\Database;

class m0001_initial
{
    private Database $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }

    public function up()
    {
        $sql = "CREATE TABLE users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    firstname VARCHAR(255) NOT NULL,
                    lastname VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    status TINYINT NOT NULL DEFAULT 0,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=INNODB;";
        $this->db->pdo->exec($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE users;";
        $this->db->pdo->exec($sql);
    }
}