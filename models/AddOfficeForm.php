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
    public $phone;
    public $street;
    public $postalCode;
    public $city;
    public $servicesName = [];
    public $servicesPrice = [];
    public $existedServicesName = [];
    public $existedServicesPrice = [];
    /**
     * @var UploadedFile
     */
    public $imageFile;


    public function rules()
    {

        return [
            [['phone', 'name', 'street', 'postalCode', 'city'], 'required'],
            ['existedServicesName', 'each', 'rule' => ['string']],
            ['existedServicesPrice', 'each', 'rule' => ['string']],
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
            'postalCode' => 'Kod pocztowy',
            'city' => 'Miasto',
            'servicesName' => 'nazwa usługi',
            'servicesPrice' => 'cena usługi',
            'phone' => 'Telefon'
        ];
    }

    public function saveOffice($userId)
    {
        $office = new Office();
        $office->name = $this->name;
        $office->doctor_id = Doctor::find()->where(['user_id' => $userId])->one()->id;
        $office->city = $this->city;
        $office->postal_code = $this->postalCode;
        $office->street = $this->street;
        $office->phone = $this->phone;
        $office->save();

        $calendar = new Calendar();
        $calendar->office_id = $office->id;
        $calendar->valid_until = date("Y-m-d", time());
        $calendar->valid_from = date("Y-m-d", time());
        $calendar->save();

        if (count($this->servicesName) == count($this->servicesPrice)) {
            for ($i = 0; $i < count($this->servicesName); $i++) {
                $serviceModel = new Service();
                $serviceModel->name = $this->servicesName[$i];
                $serviceModel->price = $this->servicesPrice[$i];
                $serviceModel->office_id = $office->id;
                $serviceModel->save();

            }

        }

    }

    /** public function upload()
     * {
     * if ($this->validate()) {
     * $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
     * return true;
     * } else {
     * return false;
     * }
     * }*/

    public function editOffice($id)
    {

        $office = Office::findOne($id);
        $office->name = $this->name;
        $office->city = $this->city;
        $office->street = $this->street;
        $office->postal_code = $this->postalCode;
        $office->save();

        $calendar_id = Calendar::find()->where(['office_id' => $id])->one()->id;
        //$scheduleItems = ScheduleItem::find()->where(['calendar_id'=> $calendar_id])->all();
        //$scheduleItemId =[];
        //foreach ($scheduleItems as $scheduleItem)
          //  array_push($scheduleItemId, $scheduleItem->id);
       // $scheduleItemServices = ScheduleItemService::find()->where(['schedule_item_id'=>  $scheduleItemId])->all(); //usługi wykorzystywane w schedule
        //$officeServicesId = [];
       // foreach ($scheduleItemServices as $scheduleItemService)
         //   array_push($officeServicesId, $scheduleItemService->service_id);

        //Service::deleteAll(['office_id' => $id]);
        //
//Service::find()->where(['office_id' => $id, id jest różne od offi])
      //  $serviceNotToDelete = Service::find()->where('office_id == :office_id and id != :officeServicesId and id != :existedOfficeServicesId', ['office_id'=>$id, 'officeServicesId'=> $officeServicesId, 'existedOfficeServicesId' => $this->existedServicesName])->all();
       // $serviceNotToDeleteId = [];
        //foreach ($serviceNotToDelete  as $service)
          //  array_push($serviceNotToDeleteId, $service->id);
        //Service::deleteAll('office_id == :office_id and id != :officeServicesId ', ['office_id'=>$id, 'officeServicesId'=> [3,2]]);
       // Service::deleteAll(['id'=>$serviceNotToDeleteId]);

        if (count($this->servicesName) == count($this->servicesPrice)) {
            for ($i = 0; $i < count($this->servicesName); $i++) {
                $serviceModel = new Service();
                $serviceModel->name = $this->servicesName[$i];
                $serviceModel->price = $this->servicesPrice[$i];
                $serviceModel->office_id = $office->id;
                $serviceModel->save();
            }
        }

    }
}