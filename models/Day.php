<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "day".
 *
 * @property integer $id
 * @property string $name
 *
 * @property ScheduleItem[] $scheduleItems
 */
class Day extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'day';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleItems()
    {
        return $this->hasMany(ScheduleItem::className(), ['day_id' => 'id']);
    }
}
