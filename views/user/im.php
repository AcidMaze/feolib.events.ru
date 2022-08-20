<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;
    use yii\widgets\LinkPager;
    $this->title = 'Мои сообщения';
?>
<?php if ($message > 0) { ?>
    <div class = "container mt-5 mb-5">
        <div class = "row gutters-sm">
            <div class = "card-im-2 col-md-7 mx-auto">
                <div class = "card-im-2-title">
                    <p class = "p_style-15 pt-4">
                        Сообщение от <?=$message->UsernameSender?>
                    </p>
                </div>
                <div class = 'row my-auto mx-auto im-2-message'>
                    <div class = 'col-md-12 mx-auto'>
                        <p class = "p_style-16">
                            Тема: <?=$message->title?>
                        </p>
                        <p class = "p_style-6">
                            <?=$message->message?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php return; } ?>  

<div class = "container mt-5 mb-5">
    <div class = "row gutters-sm">
        <div class = "card-im col-10 mx-auto">
            <div class = "card-im-title">
                <p class = "p_style-11 pt-4">
                    Мои сообщения
                </p>
            </div>
            <?php
                $base = Yii::$app->request->baseUrl;
                foreach ($models as $model) {
                    $userUrl = Url::to(['user/profile', 'id' => $model->id_sender]);
                    $messageUrl = Url::to(['user/im', 'sel' => $model->id]);
                    if($model->UserimageSender == null) $img = "$base/images/default_profile.png";
                    else  $img = 'data:image/jpg;base64,'.base64_encode($model->UserimageSender);
                    echo
                    "
                        <div class = 'row my-auto mx-auto im-message'>
                            <div class = 'col-md-1 mx-auto'>
                                <a href = '$userUrl'>
                                    <div class = 'circle-image-user-3'>
                                        <img src = '$img'>
                                    </div>
                                    <div class ='pt-1'>
                                        <p class = 'p_style-12'>$model->UsernameSender</p>
                                    </div>
                                </a>
                            </div>
                            <div class = 'col-md-4 my-auto mx-auto'>
                                <p class = 'p_style-13'> $model->title</p>
                            </div>
                            <div class = 'col-md-3 my-auto mx-auto'>
                                <p class = 'p_style-13'>$model->message</p>
                            </div>
                            <div class = 'col-md-2 my-auto mx-auto'>
                                <p class = 'p_style-13'>$model->date</p>
                            </div>
                            <div class = 'col-md-1 my-auto mx-auto btn-read'>
                            <a href = '$messageUrl' class = 'bi bi-chat-text'>
                            </a>
                            </div>
                            
                        </div>
                    ";
                }
            ?>
            <div class="mx-auto pt-3 col-1">
                <h2>
                    <?=  
                        LinkPager::widget([
                            'pagination' => $pages,
                        ]);
                    ?>
                </h2>
            </div>
        </div>
    </div>
</div>

