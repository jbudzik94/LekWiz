<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disease".
 *
 * @property integer $doctor_id
 * @property string $name
 *
 * @property Doctor $doctor
 */
class Disease extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disease';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['doctor_id', 'name'], 'required'],
            [['doctor_id'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'doctor_id' => 'Doctor ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }

    public function saveDisease($doctorID)
    {
        $this->doctor_id = $doctorID;

        if (!$this->validate()) {
            return false;
        }

        $transaction = $this->getDb()->beginTransaction();

        if (!$this->save()) {
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();

        return true;

    }
}
