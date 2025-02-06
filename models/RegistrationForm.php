<?php

namespace app\models;
use app\models\User;
use yii\base\Model;

class RegistrationForm extends Model
{
    public $username;
    public $userId;
    public $email;
    public $password;
    public $passwordConfirm;

    public function rules()
    {
        return [
            [['username','email', 'password', 'passwordConfirm'], 'required', 'message' => 'Поле "{attribute}" не может быть пустым.'],
            [['userId'], 'required', 'message' => 'Поле "Уникальный ID" не может быть пустым'],
            ['username', 'string', 'max' => 24, 'tooLong' => 'Поле "{attribute}" должно содержать не более 24 символов.'],
            ['username', 'filter', 'filter' => 'trim'], 
            ['username', 'filter', 'filter' => 'strip_tags'],

            ['userId', 'match', 'pattern' => '/^[a-z0-9_]{5,}$/i', 'message' => 'Поле "Уникальный ID" должно содержать минимум 5 символов и может включать только a-z, 0-9, _.'],
      
            ['email', 'email', 'message' => 'Введите корректный адрес электронной почты.'],

            ['password', 'string', 'min' => 6, 'tooShort' => 'Пароль должен содержать минимум 6 символов.'],
            ['password', 'filter', 'filter' => 'strip_tags', 'message' => 'Вы ввели некорректные символы.'],

            ['passwordConfirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли должны совпадать.'],
            [['username', 'userId', 'email', 'password'], 'match', 
                'pattern' => '/^(?!.*(https?:\/\/|www\.)).*$/i', 
                'message' => 'Поле не должно содержать ссылки.'],
            ['email', 'validateEmailExists'], // Проверка уникальности email
            ['userId', 'validateUserIdExists'], // Проверка уникальности userId
        ];
    }


    public function validateEmailExists($attribute, $params)
    {
        if (User::findOne(['email' => $this->$attribute])) {
            $this->addError($attribute, 'Этот email уже зарегистрирован.');
        }
    }

    /**
     * Проверяет, существует ли пользователь с таким userId.
     */
    public function validateUserIdExists($attribute, $params)
    {
        if (User::findOne(['user_id' => $this->$attribute])) {
            $this->addError($attribute, 'Этот уникальный ID уже используется.');
        }
    }
    
    public function attributeLabels()
    {
        return [
            'username' => 'Ваше имя:',
            'userId' => 'Ваш уникальный ID, другие пользователи смогут найти вас по этому ID, можно использовать только символы a-z, 0-9 и _ минимальная длинна 5 символов: ',
            'email' => 'Электронная почта:',
            'password' => 'Пароль:',
            'passwordConfirm' => 'Введите пароль повторно :',
        ];
    }
}
