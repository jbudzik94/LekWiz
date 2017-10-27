<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "degree".
 *
 * @property integer $id
 * @property string $degree
 *
 * @property Doctor[] $doctors
 */
class Degree extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'degree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['degree'], 'required'],
            [['degree'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'degree' => 'Degree',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctors()
    {
        return $this->hasMany(Doctor::className(), ['degree_id' => 'id']);
    }
}
