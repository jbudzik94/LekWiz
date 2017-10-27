<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 29.08.2017
 * Time: 15:28
 */

namespace app\models;

use yii\base\Model;

class AboutDoctorForm extends Model
{
    public $diseaseNames;
    public $universityNames;
    public $dateOfGraduation;
    public $categories;
    public $profilePhotoName;
    public $name;
    public $lastName;
    public $degree;
    public $certificatePhotoNames;



    public function rules(){

        return [

            'diseaseNamesPattern' =>['diseaseNames', 'each', 'rule' => ['pattern' => '/^[a-z\s]+$/']],
            'universityNamesPattern' =>['universityNames', 'each', 'rule' => ['pattern' => '/^[a-z\s]+$/']],
            'dateOfGraduationPattern' =>['dateOfGraduation', 'each', 'rule' => ['pattern' => '/^[a-z\s]+$/']],
            'profilePhoto'=>['string'],
            'name'=>['string'],
            'lastName'=>['string'],
            'degree'=>['string'],
            'certificatePhotoNames' => ['string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'diseaseNames' => 'Choroba',
            'universityNames' => 'Ukończone szkoły',
            'dateOfGraduation' => "Data ukończenia szkoły",
            'photo' => 'zdjęcie',
            'name' => 'imie',
            'lastName' => 'nazwisko',
            'degree' => 'stopień naukowy',
            'certificatePhotoNames' => 'certyfikat'
        ];
    }


    public function saveDiseases(){

        $userId = \Yii::$app->user->getId();
        $doctor = Doctor::find()->where(['user_id' => $userId])->one();

        $doctorId = $doctor->id;

        for( $x = 0; $x < count($this->diseaseNames); $x++ )
        {
            $disease = new Disease();
            $disease->name = $this->diseaseNames[$x];
            $disease->doctor_id = $doctorId;
            $disease->save();
        }
        return true;
    }

    public function saveUniversities(){

        $userId = \Yii::$app->user->getId();
        $doctorId = Doctor::find()->where(['user_id' => $userId])->one()->id;

        for( $i = 0; $i < count($this->universityNames); $i++ )
        {
            $university = new University();
            $university->name = $this->universityNames[$i];
            $university->date_of_graduation = $this->dateOfGraduation[$i];
            $university->id_doctor = $doctorId;
            $university->save();
        }

        return true;

    }

    public function deleteData(){
        $userId = \Yii::$app->user->getId();
        $doctorId = Doctor::find()->where(['user_id' => $userId])->one()->id;

        University::deleteAll(['id_doctor' => $doctorId]);
        Disease::deleteAll(['doctor_id' => $doctorId]);

        return true;

    }

    public function saveProfilePhoto(){
        $userId = \Yii::$app->user->getId();
        $doctorId = Doctor::find()->where(['user_id' => $userId])->one()->id;
        ProfilePhoto::deleteAll(['doctor_id' => $doctorId]);
        $profilePhoto = new ProfilePhoto();
        $profilePhoto->name = $this->profilePhotoName;
        $profilePhoto->doctor_id = $doctorId;
        $profilePhoto->save();

        return true;
    }

    public function saveCategories(){
        $userId = \Yii::$app->user->getId();
        $doctor = Doctor::find()->where(['user_id' => $userId])->one();
        $doctorId = $doctor->id;
        $doctor->main_category_id = $this->categories[0];
        $doctor->save();

        DoctorCategory::deleteAll(['doctor_id' => $doctorId]);
        $doctorCategory = new DoctorCategory();
        $doctorCategory->doctor_id = $doctorId;
        $doctorCategory->main_category_id = $this->categories[1];
        $doctorCategory->save();

        $doctorCategory = new DoctorCategory();
        $doctorCategory->doctor_id = $doctorId;
        $doctorCategory->main_category_id = $this->categories[2];
        $doctorCategory->save();

        return true;

    }

    public function saveUserDetails(){
        $userId = \Yii::$app->user->getId();

        UserDetails::deleteAll(['user_id' => $userId]);

        $userDetails = new UserDetails();
        $userDetails->user_id = $userId;
        $userDetails->name = $this->name;
        $userDetails->last_name = $this->lastName;
        $userDetails->role = "lekarz";
        $userDetails->save();

        return true;


    }

    public function saveDegree(){
        $userId = \Yii::$app->user->getId();
        $doctor = Doctor::find()->where(['user_id' => $userId])->one();
       // $doctorId = $doctor->id;
        $doctor->degree_id = 2;
        $doctor->save();

    }

    public function saveCertificates(){

        $userId = \Yii::$app->user->getId();
        $doctor = Doctor::find()->where(['user_id' => $userId])->one();

        $doctorId = $doctor->id;
        //CertificatePhoto::deleteAll(['doctor_id' => $doctorId]);

        for( $x = 0; $x < count($this->certificatePhotoNames); $x++ )
        {
            $certificate = new CertificatePhoto();
            $certificate->doctor_id = $doctorId;
            $certificate->name = $this->certificatePhotoNames[$x];
            $certificate->save();
        }
        return true;
    }

    public function deleteCertificate($certificatesToDelete){
        foreach ($certificatesToDelete as $cert)
        CertificatePhoto::deleteAll(['name' => $cert]); //dodaćwarunek że id liekarza wynosi ...
        return true;
    }


}