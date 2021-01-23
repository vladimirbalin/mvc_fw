<?php


namespace app\core;


abstract class ActiveRecord extends Model
{
    abstract public static function tableName(): string;

    abstract public static function primaryKey(): string;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $attributesStr = implode(',', $this->attributes());
        $values = implode(',', array_map(fn($a) => ":$a", $attributes));
        $statement = Database::prepare("INSERT INTO $tableName ($attributesStr)
                                        VALUES ($values)");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        return $statement->execute();
    }

    public static function findOne($where) //["email" => $this->email, "login" => $this->login]
    {
        $tableName = static::tableName();
        $conditionsList = array_map(fn($parameter) => "$parameter = :$parameter", array_keys($where));
        $conditions = implode(' AND ', $conditionsList);
        $sql = "SELECT * FROM $tableName WHERE $conditions";
        $statement = Database::prepare($sql);
        foreach ($where as $parameter => $value) {
            $statement->bindValue(":$parameter", $value);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }



}