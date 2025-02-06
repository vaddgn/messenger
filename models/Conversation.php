<?php

namespace app\models;
use Yii;

/**
 * This is the model class for table "conversations".
 *
 * @property int $id
 * @property string $participant_one_id
 * @property string $participant_two_id
 * @property string $created_at
 *
 * @property Messages[] $messages
 * @property Messages[] $messages0
 */
class Conversation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conversations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['participant_one_id', 'participant_two_id'], 'required'],
            [['created_at'], 'safe'],
            [['participant_one_id', 'participant_two_id'], 'string', 'max' => 50],
            [['participant_one_id', 'participant_two_id'], 'unique', 'targetAttribute' => ['participant_one_id', 'participant_two_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'participant_one_id' => 'Participant One ID',
            'participant_two_id' => 'Participant Two ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::class, ['conversation_id' => 'id']);
    }

    /**
     * Gets query for [[Messages0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Messages::class, ['conversation_id' => 'id']);
    }

    static public function getCurrentConversationId($participant_one_id, $participant_two_id) {
        return Conversation::findOne(['participant_one_id' => $participant_one_id, 'participant_two_id' => $participant_two_id]);
    }

}
