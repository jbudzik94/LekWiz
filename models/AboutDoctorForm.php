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
    public $diseaseNames = array();

    public function rules(){

        return [//'diseaseNamesLength' => ['diseaseNames','each', 'string', 'min' => 2, 'max' => 40],
            //'diseaseNamesPattern' => ['diseaseNames','each', 'match', 'pattern' => '/^[a-z\s]+$/'],
            ['diseaseNames', 'each', 'rule' => ['pattern' => '/^[a-z\s]+$/']],
            ];
    }

    public function attributeLabels()
    {
        return [
            'diseaseNames' => 'Choroba',
        ];
    }


    public function save(){

        if (!$this->validate()) {
            return false;
       }

        $disease = new Disease();
       // $doctor = new Doctor();



        $userId = \Yii::$app->user->getId();
        $doctor = Doctor::find()->where(['user_id' => $userId])->one();

        $doctorId = $doctor->id;
        //$this->loadAttributes($disease);

        foreach ($this->attributes['diseaseNames'] as $diseaseName) {
            $disease->name = $diseaseName;
            $disease->doctor_id = $doctorId;
            $disease->save();
        }

        /* odkomentować
        $disease->name = $this->attributes['diseaseNames'];
        $disease->doctor_id = $doctorId;

        $disease->save();
        */

        return true;



    }
}