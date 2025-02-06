<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $username
 * @property string $profile_photo
 * @property string|null $user_id
 * @property string|null $email
 * @property string|null $user_password
 * @property string $user_token
 * @property int $is_admin
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['updatePhoto'] = ['avatarFile'];
        return $scenarios;
    }
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_token'], 'required'],
            [['is_admin'], 'integer'],
            [['username'], 'string', 'max' => 24],
            [['profile_photo', 'user_id', 'email', 'user_password'], 'string', 'max' => 255],
            [['user_token'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'profile_photo' => 'Profile Photo',
            'user_id' => 'User ID',
            'email' => 'Email',
            'user_password' => 'User Password',
            'user_token' => 'User Token',
            'is_admin' => 'Is Admin',
        ];
    }


    public static function addUser($username, $userId, $email, $password, $user_token)
    {
        $user = new self();
        $user->username = $username;
        $user->user_id = $userId;
        $user->email = $email;
        $user->user_password = Yii::$app->security->generatePasswordHash($password);
        $user->user_token = $user_token;

        if (!$user->save()) {
            Yii::error('Ошибка при сохранении пользователя: ' . json_encode($user->errors), __METHOD__);
            return false;
        }

        return true;
    }

    

    public static function generateUniqueToken()
    {
        do {
            $token = Yii::$app->security->generateRandomString(32);
        } while (self::findOne(['user_token' => $token]) !== null);

        return $token;
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['user_token' => $token]);
    }

    
    public static function setsTokenCookie($access_token)
{
    $cookies = Yii::$app->response->cookies;
    $cookies->add(new \yii\web\Cookie([
        'name' => 'access_token',
        'value' => $access_token,
        'expire' => time() + 3600 * 24 * 7,
        'httpOnly' => true,
        'secure' => true,
        'sameSite' => \yii\web\Cookie::SAME_SITE_LAX,
    ]));
}


    public function getId()
    {
        return $this->id;
    }


    public function getAuthKey()
    {
        return $this->user_token; 
    }


    public function validateAuthKey($user_token)
    {
        return $this->user_token === $user_token;
    }

    public static function updateUserToken($email, $newToken)
    {
        $user = self::findOne(['email' => $email]);

        if ($user) {
            $user->user_token = $newToken;
            if ($user->save(false)) {
                return true;
            }
    
        } else {
            \Yii::error("Пользователь с email {$email} не найден.", __METHOD__);
        }
    
        return false;
    }




}
