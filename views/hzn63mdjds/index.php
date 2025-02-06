<?php

use app\models\Conversation;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ConversationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
use app\assets\AdminAsset;
AdminAsset::register($this);
$this->title = 'Админ панель: чаты';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="defaultContainer">
    <div class="content">



    <div class="conversation-index">

<h1><?= Html::encode($this->title) ?></h1>
<div class="adminInfo">
        <img src="\messenger\web\<?=$user->profile_photo?>">
        <div>
        <p>ID: @<?= $user->user_id?></p>
        <p>name: <?= $user->username?></p>
        </div>
    </div>
    <div class="adminButton">
    <p>
        <?= Html::a('Создать чат', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::a('Пользователи', ['/hzn62mdjds'], ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
        <?= Html::a('Чаты', ['/hzn63mdjds'], ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
        <?= Html::a('Сообщения', ['/hzn64mdjds'], ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
    <?= Html::a('Выход', ['logout'], ['class' => 'btn btn-danger', 'id' => 'exitAdmin']) ?>

    </p>

    </div>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'participant_one_id',
        'participant_two_id',
        'created_at',
        [
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, Conversation $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
             }
        ],
    ],
]); ?>


</div>


    </div>
</div>

