<?php
namespace app\models;
use yii\db\ActiveRecord;
use app\models\UsersList;

class MessageList extends ActiveRecord
{
      public static function tableName()
      {
            return 'users_noify'; // Имя таблицы в БД
      }

      public function getUserId()
      {
            return $this->hasOne(UsersList::className(), ['id' => 'id_user']);
      }
      
      public function getSenderId()
      {
            return $this->hasOne(UsersList::className(), ['id' => 'id_sender']);
      }
      public function getUsernameSender() 
      {
            return $this->senderId ? $this->senderId->name : '-Без имени-';
      }

      public function getUserimageSender() 
      {
            return $this->senderId ? $this->senderId->img : null;
      }


      public function getUsername() 
      {
            return $this->userId ? $this->userId->name : '-Без имени-';
      }

      public function getUserimage() 
      {
            return $this->userId ? $this->userId->img : null;
      }

      public function getAllUserId() {
            return $this->hasMany($this::className(), ['id_user' => 'id_user']);
      }
        
      public function getUserRevCount() { // Получить количества отзывов пользователя (для сообщений)
            return count($this->allUserId);
      }
}