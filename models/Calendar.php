<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar".
 *
 * @property integer $id
 * @property integer $office_id
 * @property string $valid_from
 * @property string $valid_until
 *
 * @property Office $office
 * @property ScheduleItem[] $scheduleItems
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['office_id', 'valid_from', 'valid_until'], 'required'],
            [['office_id'], 'integer'],
            [['valid_from', 'valid_until'], 'safe'],
            [['office_id'], 'exist', 'skipOnError' => true, 'targetClass' => Office::className(), 'targetAttribute' => ['office_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'office_id' => 'Office ID',
            'valid_from' => 'Valid From',
            'valid_until' => 'Valid Until',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffice()
    {
        return $this->hasOne(Office::className(), ['id' => 'office_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleItems()
    {
        return $this->hasMany(ScheduleItem::className(), ['calendar_id' => 'id']);
    }

    public function createCalendar($office_id)
    {
          $calendar = new Calendar();
          $calendar->office_id = $office_id;
          $calendar->valid_until = date('Y-m-d', time());
          $calendar->valid_from = date('Y-m-d', time());
          if ($calendar->save())
              return true;

    }
}
