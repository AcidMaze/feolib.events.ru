<?php

namespace app\controllers;
use Yii;
use yii\db\Command;
use yii\web\Controller;
use yii\web\Response;
use yii\web\Cookie;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use app\models\AddEvent;
use app\models\EditEvent;
use app\models\EventsList;
use app\models\UsersList;
use app\models\UsersEdit;


class AdminController extends Controller
{
   
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionIndex(){
        $admin = new UsersList;
        if($admin->isAdmin(Yii::$app->request->cookies->getValue('uniqueID')))
        {
            $dataProvider = new ActiveDataProvider([
                'query' => EventsList::find(),
            ]);
            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        }
        else
        {
            return $this->redirect(['/']);
        }
    }

    public function actionDelete(){
        $admin = new UsersList;
        if($admin->isAdmin(Yii::$app->request->cookies->getValue('uniqueID')))
        {
            $id = Yii::$app->request->get('id');
            $model = EventsList::find()->where('id = :id', [':id' => $id])->one();
            if($model)
            {
                $model->delete();
                return $this->redirect(['index']);
            }
            else{
                return $this->redirect(['index']);
            }
        }
        else
        {
            return $this->redirect(['/']);
        }
    }

    public function actionUpdate()
    {
        $admin = new UsersList;
        if($admin->isAdmin(Yii::$app->request->cookies->getValue('uniqueID')))
        {
            $id = Yii::$app->request->get('id');
            $model = EditEvent::find()->where('id = :id', [':id' => $id])->one();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) 
            {
                $model->title = $model->title;
                $model->place = $model->place;
                $model->text = $model->text;
                $model->date = $model->date;
                $model->status = $model->status;
                $model->save();
                return $this->redirect(['index']);
            } 
            return $this->render('update', ['model' => $model]);
        }
        else
        {
            return $this->redirect(['/']);
        }
    }
    public function actionAdd(){
        $admin = new UsersList;
        $cnt_user = UsersList::find()->all();
        $cnt_user = count($cnt_user);
        if($admin->isAdmin(Yii::$app->request->cookies->getValue('uniqueID')))
        {
            $model = new AddEvent();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) 
            {
                $file = \yii\web\UploadedFile::getInstance($model, 'imageFile');
                $fp = fopen($file->tempName, 'r');
                $file = fread($fp, $file->size);
                fclose($fp);
                $model->title = $model->title;
                $model->place = $model->place;
                $model->text = $model->text;
                $model->date = $model->date;
                $model->status = $model->status;
                $model->title_img = $file;
                $model->save();
                for($i = 1; $i <= $cnt_user; $i++) 
                {
                    Yii::$app->db->createCommand('INSERT INTO `users_noify` (`id_user`,`id_sender`,`title`,`message`) 
                    VALUES (:id_user,:id_sender,:title,:mes)', [
                        ':id_user' => $i,
                        ':id_sender' => null,
                        ':title' => "Приглашаем вас на мероприятие ".$model->title,
                        ':mes' => $model->text,
                    ])->execute();
                }
                return $this->redirect(['index']);
            } 
            return $this->render('add', ['model' => $model]);
        }
        else
        {
            return $this->redirect(['/']);
        }
    }


    public function actionUserlist(){
        $admin = new UsersList;
        if($admin->isAdmin(Yii::$app->request->cookies->getValue('uniqueID')))
        {
            $dataProvider = new ActiveDataProvider([
                'query' => UsersList::find(),
            ]);
            return $this->render('userlist', [
                'dataProvider' => $dataProvider,
            ]);
        }
        else
        {
            return $this->redirect(['/']);
        }
    }


    public function actionDeleteuser(){
        $admin = new UsersList;
        if($admin->isAdmin(Yii::$app->request->cookies->getValue('uniqueID')))
        {
            $id = Yii::$app->request->get('id');
            $model = UsersList::find()->where('id = :id', [':id' => $id])->one();
            if($model)
            {
                $model->delete();
                return $this->redirect(['userlist']);
            }
            else{
                return $this->redirect(['index']);
            }
        }
        else
        {
            return $this->redirect(['/']);
        }
    }


    public function actionEdituser()
    {
        $admin = new UsersList;
        if($admin->isAdmin(Yii::$app->request->cookies->getValue('uniqueID')))
        {
            $id = Yii::$app->request->get('id');
            $model = UsersEdit::find()->where('id = :id', [':id' => $id])->one();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) 
            {
                $model->name = $model->name;
                $model->phone = $model->phone;
                $model->age_date = $model->age_date;
                $model->email = $model->email;
                $model->sex = $model->sex;
                $model->save();
                return $this->redirect(['userlist']);
            } 
            return $this->render('edituser', ['model' => $model]);
        }
        else
        {
            return $this->redirect(['/']);
        }
    }
}
