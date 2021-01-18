<?php

namespace app\migrations;

use \app\core\Application;
use app\core\Database;

class m0002_add_password_column
{
    private Database $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }

    public function up()
    {
        $sql = "ALTER TABLE users 
                ADD COLUMN password VARCHAR(512) NOT NULL;
                ";
        $this->db->pdo->exec($sql);
    }

    public function down()
    {
        $sql = "ALTER TABLE users DROP COLUMN password;";
        $this->db->pdo->exec($sql);
    }
}