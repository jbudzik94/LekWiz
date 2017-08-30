<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 29.08.2017
 * Time: 15:28
 */

namespace app\models;

use app\models\Disease;
use app\models\Doctor;
use yii\base\Model;

class AboutDoctorForm extends Model
{
    public $diseaseName;

    public function rules(){
        return [[['diseaseName'], 'required']];
    }

    public function attributeLabels()
    {
        return [
            'diseaseName' => 'Choroba',
        ];
    }


    public function save(){

       // if (!$this->validate()) {
        //    return false;
       // }

        $disease = new Disease();
       // $doctor = new Doctor();



        $userId = \Yii::$app->user->getId();
        $doctor = Doctor::find()->where(['user_id' => $userId])->one();

        $doctorId = $doctor->id;
        //$this->loadAttributes($disease);

        $disease->name = $this->attributes['diseaseName'];
        $disease->doctor_id = $doctorId;

        $disease->save();

        return true;



    }
}