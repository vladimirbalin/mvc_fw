<?php


namespace app\core;


abstract class ActiveRecord extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

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
        $statement->execute();
        return true;

    }

}