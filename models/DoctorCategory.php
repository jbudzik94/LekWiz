<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doctor_category".
 *
 * @property integer $doctor_id
 * @property integer $main_category_id
 *
 * @property Doctor $doctor
 * @property MainCategory $mainCategory
 */
class DoctorCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doctor_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['doctor_id', 'main_category_id'], 'required'],
            [['doctor_id', 'main_category_id'], 'integer'],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
            [['main_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MainCategory::className(), 'targetAttribute' => ['main_category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'doctor_id' => 'Doctor ID',
            'main_category_id' => 'Main Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainCategory()
    {
        return $this->hasOne(MainCategory::className(), ['id' => 'main_category_id']);
    }
}
