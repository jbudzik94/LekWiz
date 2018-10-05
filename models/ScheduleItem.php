<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schedule_item".
 *
 * @property integer $id
 * @property integer $calendar_id
 * @property integer $day_id
 * @property string $start_hour
 * @property string $end_hour
 * @property integer $visit_minutes
 * @property integer $visit_type
 *
 * @property Calendar $calendar
 * @property Day $day
 * @property ScheduleItemService[] $scheduleItemServices
 */
class ScheduleItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_id', 'day_id', 'start_hour', 'end_hour', 'visit_minutes', 'visit_type'], 'required'],
            [['calendar_id', 'day_id', 'visit_minutes', 'visit_type'], 'integer'],
            [['start_hour', 'end_hour'], 'safe'],
            [['calendar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Calendar::className(), 'targetAttribute' => ['calendar_id' => 'id']],
            [['day_id'], 'exist', 'skipOnError' => true, 'targetClass' => Day::className(), 'targetAttribute' => ['day_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'calendar_id' => 'Calendar ID',
            'day_id' => 'Day ID',
            'start_hour' => 'Start Hour',
            'end_hour' => 'End Hour',
            'visit_minutes' => 'Visit Minutes',
            'visit_type' => 'Visit Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendar()
    {
        return $this->hasOne(Calendar::className(), ['id' => 'calendar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDay()
    {
        return $this->hasOne(Day::className(), ['id' => 'day_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleItemServices()
    {
        return $this->hasMany(ScheduleItemService::className(), ['schedule_item_id' => 'id']);
    }
}
