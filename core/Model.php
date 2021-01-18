<?php


namespace app\core;


abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public array $errors = [];

    public function loadData($data)
    {
        foreach ($data as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                if (is_array($rule)) {
                    $ruleName = $rule[0];
                } else {
                    $ruleName = $rule;
                }

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();

                    $sql = "SELECT * FROM $tableName WHERE $uniqueAttr = '$value'";
                    $stmt = Database::prepare($sql);
                    $stmt->execute();
                    $record = $stmt->fetchObject();
                    if ($record) {
                        $this->addError($attribute, self::RULE_UNIQUE, ['unique' => $attribute]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    public function addError(string $attribute, string $ruleName, array $params = [])
    {
        $message = $this->errorMessages()[$ruleName] ?? '';
        if ($params) {
            $message = str_replace("{{$ruleName}}", $params[$ruleName], $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'The field value is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => "Min length of this field must be {min}",
            self::RULE_MAX => "Max length of this field must be {max}",
            self::RULE_MATCH => "This field must be the same as {match}",
            self::RULE_UNIQUE => "This {unique} already exists"
        ];
    }

    public function hasError(string $attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError(string $attribute)
    {
        return $this->errors[$attribute][0];
    }

}