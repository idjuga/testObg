<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'My Yii Application';
?>

<div class="site-index">
    <div class="center">
        <?php 
        if (Yii::$app->user->isGuest) {
            if (Yii::$app->session->hasFlash('sendUserMail') && isset($message)){ ?>
                <div class="alert alert-success">
                        <?=$message?>
                </div>
            <?php }else{ 
                echo Html::beginForm ( ['/site/usermail'], 'post');?>
                <label>
                    Введіть Електронну адресу:
                    <?= Html::input('email', 'usermail',null, ['required'=>true]);
                    ?>
                </label>
                <?=Html::submitButton ( 'Відправити');?>
                <?= Html::endForm();
            }
        }
    else{
        echo 'Привіт!';
    }
    ?>
    </div>
    
</div>
