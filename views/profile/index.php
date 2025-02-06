<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\ProfileAsset;
ProfileAsset::register($this);
$this->title = 'Чаты';
?>


<div class="defaultContainer">

<h1 class="titlePage"><?= Html::encode($this->title) ?></h1>
<div class="contentInfo ">
<?php $form = ActiveForm::begin(['options' => ['class' => 'formInfo', 'id' => 'messInputForm'],]); ?>

<div class="chats" id="chatList">
</div>

<div class="chatPassive"></div>
<div class="chatActive">

    <?php if($recipient):?>

        <div class="recipientInfo">
            <img src="\messenger\web\<?=$recipient->profile_photo?>" class="imguserFiled">
            <div class="userFieldInfo">
                <p><?=$recipient->username?></p>
                <p class="userFieldInfoId">@<?=$recipient->user_id?></p>
            </div>
        </div>
    <?php endif;?>

    <div class="chatMesseng" id="chatMesseng">

    </div>

    <div class="chatInput">
            <?= $form->field($model, 'submitChat')->textInput(['placeholder' => 'Введите сообщение', 'style' => 'height:55px;', 'id' => 'messageInput'])->label(false)?>
            <?= Html::submitButton('', ['class' => 'btn btn-primary submitChatButton buttonmy', 'id' => 'submitChatButton'])?>    
    </div>
</div>

<div id="conversationId" style="display: none;">{conversation_id}</div>

<?php ActiveForm::end(); ?>
</div>
</div>