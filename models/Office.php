<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "office".
 *
 * @property integer $id
 * @property integer $doctor_id
 * @property string $name

 * @property string $street
 * @property string $postal_code
 * @property string $phone
 * @property string $city
 *

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
            [['doctor_id', 'name', 'street', 'postal_code', 'city'], 'required'],
            [['doctor_id'], 'integer'],
            [['name', 'street'], 'string', 'max' => 40],
            [['postal_code'], 'string', 'max' => 9],
            [['phone'], 'string', 'max' => 10],
            [['city'], 'string', 'max' => 10],
            //[['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
           // [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
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
            'city' => 'City',
            'street' => 'Street',
            'postal_code' => 'Postal Code',
            'phone' => 'Telefon',
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
    public function getOfficePhotos()
    {
        return $this->hasMany(OfficePhoto::className(), ['office_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfficeSevices()
    {
        return $this->hasMany(Service::className(), ['office_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['office_id' => 'id']);
    }

    public function saveOffice($userID)
    {

        $this->doctor_id = Doctor::find()->where(["user_id" => $userID])->one()->id;

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

    public function deleteOffice(){
        $id = $this->id;
        $calendar = Calendar::find()->where(["office_id" => $id])->one();
        $scheduleItems = ScheduleItem::find()->where(["calendar_id" => $calendar->id])->all();
        //  $scheduleItemServices = [];
        foreach ($scheduleItems as $scheduleItem){
            //    array_push($scheduleItemServices, ScheduleItemService::)
            ScheduleItemService::deleteAll(["schedule_item_id"=>$scheduleItem->id]);
        }
        ScheduleItem::deleteAll(["calendar_id" => $calendar->id]);
        Visit::deleteAll(["calendar_id" => $calendar->id]);
        Calendar::deleteAll(["office_id" => $id]);
        Service::deleteAll(["office_id" => $id]);
        OfficePhoto::deleteAll(["office_id"=>$id]);
        Office::deleteAll(["id" => $id]);
    }

}
