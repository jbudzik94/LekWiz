<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "office".
 *
 * @property integer $id
 * @property integer $doctor_id
 * @property string $name
 * @property integer $city_id
 * @property string $street
 * @property string $postal_code
 *
 * @property City $city
 * @property Doctor $doctor
 * @property OfficePhoto[] $officePhotos
 * @property Service[] $services
 */
class Office extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'office';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['doctor_id', 'name', 'city_id', 'street', 'postal_code'], 'required'],
            [['doctor_id', 'city_id'], 'integer'],
            [['name', 'street'], 'string', 'max' => 40],
            [['postal_code'], 'string', 'max' => 9],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doctor_id' => 'Doctor ID',
            'name' => 'Name',
            'city_id' => 'City ID',
            'street' => 'Street',
            'postal_code' => 'Postal Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
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
    public function getOfficePhotos()
    {
        return $this->hasMany(OfficePhoto::className(), ['office_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['office_id' => 'id']);
    }
}
