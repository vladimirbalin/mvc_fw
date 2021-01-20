<?php


namespace app\models;


use app\core\Application;
use app\core\Model;

class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array
    {
        return [
            'email' => 'E-mail',
            'password' => 'Password',
        ];
    }

    public function login()
    {
        $foundUser = User::findOne(["email" => $this->email]);
        if ($foundUser && password_verify($this->password, $foundUser->password)) {
            Application::$app->login($foundUser);
            return true;
        }
        $this->addError('password', 'Email or Password is incorrect');
        $this->addError('email', 'Email or Password is incorrect');
        $this->password = '';
        return false;
    }
}