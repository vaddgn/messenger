<?php
namespace app\controllers;
use yii\web\Controller;
use app\models\User;
use app\models\InfoUser;
use app\models\searchUser;
use app\models\Chat;
use app\models\Conversation;
use yii\web\UploadedFile;
use Yii;

class ProfileController extends BaseController 
{
    public $layout = 'main';


    public function actionIndex()
    {
        $this->getUser();
        $model = new Chat();
        $recipient = [];
        if (Yii::$app->request->isGet) {
            $getId = Yii::$app->request->get('id');
            $recipient = User::findOne(['user_id' => $getId]);
    
        }

        return $this->render('index', ['model' => $model, 'recipient' => $recipient]);
    }


    public function actionNews() {
        $this->getUser();
        return $this->render('news');
    }


    public function actionInfo()
{
    $user = $this->getUser();
    $model = new InfoUser($user);

    if (Yii::$app->request->isPost) {
        $action = Yii::$app->request->post('action');

        if ($action === 'updatePhoto') {
            $model->scenario = 'updatePhoto';
            $model->avatarFile = UploadedFile::getInstance($model, 'avatarFile');

            if ($model->uploadAvatar()) {
                Yii::$app->session->setFlash('success', 'Аватарка успешно обновлена!');
            } else {
                Yii::$app->session->setFlash('error', 'Вы не выбрали фотографию.');
            }
        } elseif ($action === 'deletePhoto') {
            if ($model->deleteAvatar()) {
                Yii::$app->session->setFlash('success', 'Аватарка успешно удалена!');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при удалении аватарки.');
            }
        }
        elseif ($action === 'updateInfo') {
            $model->scenario = 'updateProfile';
            $model->load(Yii::$app->request->post());

            if ($model->updateUser()) {
                Yii::$app->session->setFlash('success', 'Данные успешно обновлены!');
            } else {
                Yii::$app->session->setFlash('error', 'Произошла ошибка при обновлении данных. Возможно такой ID или email занят.');
            }
        }
        elseif($action === 'exitUser') {
            $cookie = Yii::$app->response->cookies;
            $cookie->remove('access_token');
            return $this->redirect(['authorization/login']);
        }

        return $this->refresh();
    }

    return $this->render('info', ['model' => $model]);
}



    public function actionSearch() {
        $user = $this->getUser();
        $model = new searchUser();
        $users = [];
        $userInfo = [];


        if (Yii::$app->request->isPost) {
            $action = Yii::$app->request->post('action');
            $userSearch = Yii::$app->request->post('userInfo');
            if ($action === 'searchUser') {
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    Yii::$app->session->set('request', $model->userId);
                    $users = User::find()->where(['like', 'user_id', $model->userId])->all();
                }
        
        
            }


            if (!empty($userSearch)) {
                $userInfo = User::findOne(['user_id' => $userSearch]);
                $users = User::find()->where(['like', 'user_id', Yii::$app->session->get('request')])->all();
            }

        }
        return $this->render('search', ['model' => $model, 'users' => $users, 'userInfo' => $userInfo]);



    }










    /**
     * 
     *
     * @return \app\models\User|null
     */
    private function getUser() {
        $user = Yii::$app->user->identity;
        $this->view->params['user'] = $user;
        return $user;
    }

}
