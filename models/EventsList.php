<?php
namespace app\models;
use yii\db\ActiveRecord;

class EventsList extends ActiveRecord
{
      public $fromDate;
      public $toDate;
      public static function tableName()
      {
            return 'events_list'; // Имя таблицы в БД
      }
      public function rules() 
      {
            return 
            [
                  [['fromDate','toDate'], 'string'],
            ];
      }

}