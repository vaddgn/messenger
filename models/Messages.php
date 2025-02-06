<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $conversation_id
 * @property string $sender_id
 * @property string $content
 * @property string $created_at
 * @property int $is_read
 * @property int $receiver_id
 *
 * @property Conversations $conversation
 * @property Conversations $conversation0
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['conversation_id', 'sender_id', 'content', 'receiver_id'], 'required'],
            [['conversation_id', 'is_read', 'receiver_id'], 'integer'],
            [['content'], 'string'],
            [['created_at'], 'safe'],
            [['sender_id'], 'string', 'max' => 50],
            [['conversation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conversations::class, 'targetAttribute' => ['conversation_id' => 'id']],
            [['conversation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conversations::class, 'targetAttribute' => ['conversation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conversation_id' => 'Conversation ID',
            'sender_id' => 'Sender ID',
            'content' => 'Content',
            'created_at' => 'Created At',
            'is_read' => 'Is Read',
            'receiver_id' => 'Receiver ID',
        ];
    }

    /**
     * Gets query for [[Conversation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConversation()
    {
        return $this->hasOne(Conversations::class, ['id' => 'conversation_id']);
    }

    /**
     * Gets query for [[Conversation0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConversation0()
    {
        return $this->hasOne(Conversations::class, ['id' => 'conversation_id']);
    }
}
