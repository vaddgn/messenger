<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;

class DefaultController extends BaseController 
{

    
    public function actionError()
    {
        $user = Yii::$app->user->identity;
        $this->view->params['user'] = $user;
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
    



}
