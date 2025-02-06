<?php

namespace app\models;
use yii\base\Model;

class searchUser extends Model
{
    public $userId;

    public function rules()
    {
        return [
            [['userId'], 'required', 'message' => 'Поле "Уникальный ID" не может быть пустым'],
            ['userId', 'match', 'pattern' => '/^[a-z0-9_]{1,}$/i', 'message' => 'Для поиска используются только символы a-z, 0-9, _.'],

        ];
    }
    public function attributeLabels()
    {
        return [
            'userId' => 'Ваш уникальный ID, другие пользователи смогут найти вас по этому ID, можно использовать только символы a-z, 0-9 и _ минимальная длинна 5 символов: ',
        ];
    }
}
