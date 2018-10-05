<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visit".
 *
 * @property integer $id
 * @property integer $calendar_id
 * @property integer $user_id
 * @property integer $doctor_id
 * @property string $patient_name
 * @property string $patient_last_name

 * @property integer $service
 * @property string $phone
 * @property string $date
 * @property string $time
 * @property string $token
 * @property string $status
 *
 * @property Calendar $calendar
 * @property Doctor $doctor
 * @property User $user

 */
class Visit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_id', 'doctor_id', 'patient_name', 'patient_last_name', 'service', 'phone', 'date', 'time', 'status'], 'required'],
            [['calendar_id', 'user_id', 'doctor_id'], 'integer'],
            [['patient_name', 'patient_last_name', 'status'], 'string'],
            [['date', 'time'], 'safe'],
            [['phone'], 'string', 'max' => 20],
            [['token'], 'string', 'max' => 255],
            //[['calendar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Calendar::className(), 'targetAttribute' => ['calendar_id' => 'id']],
            //[['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
           // [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
          //  [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::className(), 'targetAttribute' => ['service_id' => 'id']],
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
            'user_id' => 'User ID',
            'doctor_id' => 'Doctor ID',
            'patient_name' => 'Imię',
            'patient_last_name' => 'Nazwisko',
           // 'service_id' => 'Service ID',
            'service' => 'Typ wizyty',
            'phone' => 'Telefon',
            'date' => 'Data',
            'time' => 'Godzina',
            'token' => 'Token',
            'status' => 'Status',
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
    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   /* public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }*/
}
