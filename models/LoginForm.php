<?php
namespace app\models;

use yii\base\Model;
use app\models\User; // Подключаем модель User

class LoginForm extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password'], 'required', 'message' => 'Поле "{attribute}" не может быть пустым.'],
            ['email', 'email', 'message' => 'Введите корректный адрес электронной почты.'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Пароль должен содержать минимум 6 символов.'],
            [['email', 'password'], 'filter', 'filter' => 'strip_tags', 'message' => 'Вы ввели не корректные символы'],
            [['email', 'password'], 'match',
                'pattern' => '/^(?!.*(https?:\/\/|www\.)).*$/i',
                'message' => 'Поле не должно содержать ссылки.',
            ],
            ['password', 'validateUserLogin'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта:',
            'password' => 'Пароль:',
        ];
    }
    public function beforeValidate()
    {
        $this->email = strip_tags($this->email);
        $this->password = strip_tags($this->password);
        return parent::beforeValidate();
    }

    public function validateUserLogin($attribute, $params)
    {
        $user = User::findOne(['email' => $this->email]);

        if (!$user) {
            $this->addError('email', 'Пользователь с таким email не найден.');
            return;
        }

        if (!\Yii::$app->security->validatePassword($this->password, $user->user_password)) {
            $this->addError('password', 'Неверный пароль.');
            return;
        }

        if ($this->hasErrors()) {
            return;
        }

        \Yii::$app->user->login($user);
    }
}

?>