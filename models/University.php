<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "university".
 *
 * @property integer $id_doctor
 * @property string $name
 * @property string $date_of_graduation
 *
 * @property Doctor $idDoctor
 */
class University extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'university';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_doctor', 'name', 'date_of_graduation'], 'required'],
            [['id_doctor'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['date_of_graduation'], 'string', 'max' => 30],
            [['id_doctor'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['id_doctor' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_doctor' => 'Id Doctor',
            'name' => 'Name',
            'date_of_graduation' => 'Date Of Graduation',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'id_doctor']);
    }
}
