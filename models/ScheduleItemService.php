<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schedule_item_service".
 *
 * @property integer $schedule_item_id
 * @property integer $service_id
 *
 * @property Service $service
 * @property ScheduleItem $scheduleItem
 */
class ScheduleItemService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule_item_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schedule_item_id', 'service_id'], 'required'],
            [['schedule_item_id', 'service_id'], 'integer'],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::className(), 'targetAttribute' => ['service_id' => 'id']],
            [['schedule_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleItem::className(), 'targetAttribute' => ['schedule_item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'schedule_item_id' => 'Schedule Item ID',
            'service_id' => 'Service ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleItem()
    {
        return $this->hasOne(ScheduleItem::className(), ['id' => 'schedule_item_id']);
    }
}
