<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\RegistrationForm;
use app\models\User;


class AuthorizationController extends BaseController 
{
    public $layout = 'login';
    
    public function actionLogin(){
        $model_login = new LoginForm();
        $model_registration = new RegistrationForm();
        if (Yii::$app->request->cookies->has('access_token')) {
            $access_token = Yii::$app->request->cookies->getValue('access_token');
            $user = User::findIdentityByAccessToken($access_token);
            if ($user) {
                Yii::$app->user->login($user);
                if ($user->is_admin == 1){
                    return $this->redirect(['hzn62mdjds/']);
                }
                else {
                    return $this->redirect(['profile/']);
                }
                
            }
        }

        if ($model_login->load(Yii::$app->request->post()) && $model_login->validate()) {
            $access_token = User::generateUniqueToken();
            User::updateUserToken($model_login->email, $access_token);
            User::setsTokenCookie($access_token);
            $user = User::findOne(['email' => $model_login->email]);
            Yii::$app->user->login($user); 
            if ($user->is_admin == 1){
                return $this->redirect(['hzn62mdjds/']);
            }
            else {
                return $this->redirect(['profile/']);
            }
        }

        if ($model_registration->load(Yii::$app->request->post()) && $model_registration->validate()) {
            $access_token = User::generateUniqueToken();
            User::addUser(
                $model_registration->username,
                $model_registration->userId,
                $model_registration->email,
                $model_registration->password,
                $access_token
            );
            User::setsTokenCookie($access_token);
            

            $user = User::findOne(['email' => $model_registration->email]);
            Yii::$app->user->login($user); 
            return $this->redirect(['profile/']);
        }
        



        return $this->render('login', ['model_login' => $model_login, 'model_registration' => $model_registration]);
    }


}
