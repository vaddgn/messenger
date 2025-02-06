<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest && Yii::$app->controller->id !== 'authorization') {
            return $this->redirect(['/authorization/login'])->send();
        }

        return parent::beforeAction($action);
    }
}
