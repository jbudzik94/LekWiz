<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 11.10.2017
 * Time: 09:45
 */

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class AddOfficeForm extends Model
{
    public $name;
    public $street;
    public $postalCode;
    public $city;
    public $servicesName = [];
    public $servicesPrice = [];
    /**
     * @var UploadedFile
     */
    public $imageFile;


    public function rules(){

        return [
            [['name', 'street', 'postalCode', 'city'], 'required'],
            ['servicesName', 'each', 'rule' => ['string']],
           // ['servicesName', 'each', 'rule' => ['required']],
            ['servicesPrice', 'each', 'rule' => ['string']],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg']
            //['servicePrice', 'each', 'rule' => ['integer'] ]
           // [ 'city', 'rule' => ['match','pattern' => '/^[a-z]\w*$/i']],
           ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Nazwa gabinetu',
            'street' => 'Ulica i numer budynku',
            'postalCode' =>'Kod pocztowy',
            'city' => 'Miasto',
            'servicesName' => 'nazwa usługi',
            'servicesPrice' => 'cena usługi',

        ];
    }

    public function saveOffice($userId){
        $office = new Office();
      $office->name = $this->name;
      $office->doctor_id = Doctor::find()->where(['user_id' => $userId ])->one()->id;
      $office->city_id = $this->city;
      $office->postal_code = $this->postalCode;
      $office->street = $this->street;
      $office->save();

      if(count($this->servicesName) == count($this->servicesPrice)) {
          for ($i = 0; $i < count($this->servicesName); $i++) {
              $serviceModel = new Service();
              $serviceModel->name = $this->servicesName[$i];
              $serviceModel->price = $this->servicesPrice[$i];
              $serviceModel->office_id = $office->id;
              $serviceModel->save();

          }
      }

    }
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }



}