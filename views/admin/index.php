<?php
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\grid\GridView;
    $this->title = 'Панель администратора';
?>
<div class="container mt-5 mb-5 col-lg-11">
    <div class="row main-title-block">
        <div class="col-md-6 my-auto">
            <div class="float-left">
                <h1 class = "h1_style-1">
                    Панель администратора
                </h1>
            </div>
        </div>
        <div class="col-md-6 my-auto">
            <img width = "425px" class="img-fluid float-right" src="/images/admin.svg" alt="Контакты">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 my-auto">
            <div class="float-left">
                <a class = "btn btn-primary" href="<?=Url::to(['add']);?>">Добавить мероприятие</a>
                <a class = "btn btn-green" href="<?=Url::to(['userlist']);?>">Все пользователи</a>
            </div>
        </div>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                'id',
                'columns' => [            
                    'label'=>'Фото',
                    'format' => 'image',    
                    'value' => function($dataProvider) {
                        return 'data:image/jpeg;charset=utf-8;base64,' . base64_encode($dataProvider->title_img);
                    },  
                    'format' => ['image',['width'=>'300px','height'=>'200px']],    
                ],
                'title:ntext',
                'place:ntext',
                'date:ntext',
                'text:ntext',
                'status:ntext',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Действия', 
                'headerOptions' => ['width' => '80'],
                'template' => '{update} {delete} {link}',
            ],
        ],
    ]); ?>
</div>
