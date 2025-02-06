<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class InfoUser extends Model
{
    public $avatarFile;
    public $profile_photo;
    public $username;
    public $user_id;
    public $email;
    public $user_password;
    public $new_password;
    public $confirm_password;
    private $user;

    public function __construct($user, $config = [])
    {
        $this->user = $user;
        $this->username = $user->username;
        $this->user_id = $user->user_id;
        $this->email = $user->email;
        $this->profile_photo = $user->profile_photo;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['avatarFile', 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024, 'on' => 'updatePhoto'],
            ['avatarFile', 'required', 'message' => 'Вы не выбрали фото', 'on' => 'updatePhoto'],
            [['username', 'user_id', 'email'], 'required'],
            ['username', 'string', 'min' => 1, 'message' => 'Имя не может быть пустым'],
            ['user_id', 'match', 'pattern' => '/^[a-z0-9_]{5,}$/', 'message' => 'ID должен быть не менее 5 символов и содержать только буквы, цифры и _'],
            ['email', 'email', 'message' => 'Некорректный формат email'],
            ['user_id', 'validateUserId', 'on' => 'updateProfile'],
            ['email', 'validateEmail', 'on' => 'updateProfile'],
            ['new_password', 'string', 'min' => 6, 'message' => 'Пароль должен быть не менее 6 символов', 'when' => function ($model) {
                return $model->new_password !== null;
            }],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password', 'message' => 'Пароли не совпадают', 'when' => function ($model) {
                return $model->new_password !== null;
            }],
        ];
    }


    public function validateUserId($attribute, $params)
    {
        Yii::error("Validate UserId triggered. Current user ID: {$this->user->user_id}, New user ID: {$this->user_id}", __METHOD__);
        if ($this->user_id != $this->user->user_id) { 
            $userWithSameId = User::find()->where(['user_id' => $this->user_id])->one();
            if ($userWithSameId) {
                $this->addError($attribute, 'Этот ID уже используется');
            }
        }
    }


    public function validateEmail($attribute, $params)
    {
        Yii::error("Validate Email triggered. Current email: {$this->user->email}, New email: {$this->email}", __METHOD__);
        if ($this->email != $this->user->email) {
            $userWithSameEmail = User::find()->where(['email' => $this->email])->one();
            if ($userWithSameEmail) {
                $this->addError($attribute, 'Этот email уже используется');
            }
        }
    }

    public function uploadAvatar()
    {
        if ($this->validate('avatarFile')) {
            $fileName = Yii::$app->security->generateRandomString() . '.' . $this->avatarFile->extension;
            $filePath = Yii::getAlias('@webroot/img/') . $fileName;

            if ($this->profile_photo && file_exists(Yii::getAlias('@webroot') . $this->profile_photo) && $this->profile_photo != '/img/avatar404.png') {
                unlink(Yii::getAlias('@webroot') . $this->profile_photo);
            }

            if ($this->avatarFile->saveAs($filePath)) {
                $this->profile_photo = '/img/' . $fileName;
                $this->user->profile_photo = $this->profile_photo;
                return $this->user->save(false);
            }
        }
        return false;
    }

    public function deleteAvatar()
    {
        if ($this->profile_photo != '/img/avatar404.png' && file_exists(Yii::getAlias('@webroot') . $this->profile_photo)) {
            unlink(Yii::getAlias('@webroot') . $this->profile_photo);
        }

        $this->profile_photo = '/img/avatar404.png';
        $this->user->profile_photo = $this->profile_photo;
        return $this->user->save(false);
    }

    public function updateUser()
    {
        if ($this->validate()) {
            $this->user->username = $this->username;
            $this->user->user_id = $this->user_id;
            $this->user->email = $this->email;

            if ($this->new_password) {
                $this->user->user_password = Yii::$app->security->generatePasswordHash($this->new_password);
            }

            return $this->user->save();
        }

        return false;
    }
}
