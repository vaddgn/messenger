<?php
namespace app\models;
use yii\base\Model;

class Chat extends Model
{
    public $submitChat;

    public function rules()
    {
        return [
            [['submitChat'], 'required', 'message' => ''],
        ];
    }
    public function attributeLabels()
    {
        return [
            'submitChat' => 'Ввод',
        ];
    }
}
