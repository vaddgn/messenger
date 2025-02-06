<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\RegistrationForm;
use app\models\User;


class Ajssad2kaw42Controller extends Controller 
{
    public $layout = 'login';


    public function actionIndex(){
        return $this->render('index');
    } 


}
