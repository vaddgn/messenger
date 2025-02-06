<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Message extends ActiveRecord
{
    public static function tableName()
    {
        return 'messages';
    }

    public function rules()
    {
        return [
            [['conversation_id', 'sender_id', 'content', 'created_at'], 'required'],
            [['conversation_id'], 'integer'],
            [['sender_id'], 'string', 'max' => 255],
            [['content'], 'string'],
            [['created_at'], 'safe'],
            [['is_read'], 'boolean'],
        ];
    }


    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'receiver_id',
        ]);
    }

}
