<?php
namespace app\models;
use yii\db\ActiveRecord;
use app\models\UsersList;

class EventReviewList extends ActiveRecord
{
      public static function tableName()
      {
            return 'event_rev'; // Имя таблицы в БД
      }
      public function rules() 
      {
            return 
            [
                  [['rev_text'], 'required', 'message' => 'Поле должно быть заполнено'],
                  [['rev_text'], 'string', 'max' => 512, 'message' => 'Максимальный размер отзыва 512 символов'],
                  [['rev_text'], 'string', 'min' => 3, 'message' => 'Минимальный размер отзыва 16 символов'],
                  [['id_user','id_event'], 'integer'],
            ];
      }

      public function getUserId()
      {
            return $this->hasOne(UsersList::className(), ['id' => 'id_user']);
      }

      public function getUsername() //Узнать никнейм пользьвателя (для коментарией)
      {
            return $this->userId ? $this->userId->name : '-Без имени-';
      }

      public function getUserimage() //Получить изображения пользователя (для коментарией)
      {
            return $this->userId ? $this->userId->img : null;
      }

      public function getAllUserId() {
            return $this->hasMany($this::className(), ['id_user' => 'id_user']);
      }
        
      public function getUserRevCount() { // Получить количества отзывов пользователя (для коментарией)
            return count($this->allUserId);
      }
}