<?php

namespace app\controllers;

use app\models\AddOfficeForm;
use app\models\Calendar;
use app\models\City;
use app\models\OfficePhoto;
use app\models\ScheduleItem;
use app\models\ScheduleItemService;
use app\models\Service;
use app\models\Visit;
use Yii;
use app\models\Office;
use app\models\OfficeSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OfficeController implements the CRUD actions for Office model.
 */
class OfficeController extends Controller
{
    /**
     * @inheritdoc
     */
   /* public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }*/

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'disconnect' => ['post'],
                    'delete'     => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['edit','delete-own-office'],
                        'roles'   => ['doctor'],
                    ],
                ],
            ],
        ];
    }

  /**
     * Lists all Office models.
     * @return mixed
     */
    /*    public function actionIndex()
      {
          if (\Yii::$app->user->can("showOffice")) {
              $searchModel = new OfficeSearch();
              $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

              return $this->render('index', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
              ]);
          } else {
              throw new ForbiddenHttpException();
          }
      }
  */
    /**
     * Displays a single Office model.
     * @param integer $id
     * @return mixed
     */
    /*   public function actionView($id)
     {
         return $this->render('view', [
             'model' => $this->findModel($id),
         ]);
     }

     /**
      * Creates a new Office model.
      * If creation is successful, the browser will be redirected to the 'view' page.
      * @return mixed
      */
    /*   public function actionCreate()
     {
         $model = new Office();

         if ($model->load(Yii::$app->request->post()) && $model->save()) {
             return $this->redirect(['view', 'id' => $model->id]);
         } else {
             return $this->render('create', [
                 'model' => $model,
             ]);
         }
     }

     /**
      * Updates an existing Office model.
      * If update is successful, the browser will be redirected to the 'view' page.
      * @param integer $id
      * @return mixed
      */
    /*   public function actionUpdate($id)
     {
         $model = $this->findModel($id);

         if ($model->load(Yii::$app->request->post()) && $model->save()) {
             return $this->redirect(['view', 'id' => $model->id]);
         } else {
             return $this->render('update', [
                 'model' => $model,
             ]);
         }
     }

     /**
      * Deletes an existing Office model.
      * If deletion is successful, the browser will be redirected to the 'index' page.
      * @param integer $id
      * @return mixed
      */
    /*  public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Office model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Office the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*  protected function findModel($id)
    {
        if (($model = Office::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
*/
    public function actionEdit($id)
    {

        if (\Yii::$app->user->can('updateOwnOffice', ['officeId' => $id])) {
            $model = new AddOfficeForm();

            if (Yii::$app->request->post()) {
                   $name = $_POST['name'];
                   $servicesName = json_decode($_POST['servicesName']);
                   $servicesPrice = json_decode($_POST['servicesPrice']);

                   $toRemove = json_decode($_POST['toRemove']);

                   $city = $_POST['city'];
                    //$cityId = $_POST['cityId'];

                $postalCode = $_POST['postalCode'];
                   $street = $_POST['street'];
                   $servicesPriceInt = [];

                   foreach ($servicesPrice as $price){
                       array_push($servicesPriceInt, intval($price));
                   }

                   $model->name = $name;
                   $model->city = $city;
                    // $model->cityId = $cityId;
                   $model->postalCode = $postalCode;
                   $model->street = $street;
                   $model->servicesName = $servicesName;
                   $model->servicesPrice = $servicesPriceInt;
                  // $model->servicesPrice = $servicesPrice;//$model->servicesName = [""];//$servicesName;
                   $model-> editOffice($id); //officeId

                foreach ($toRemove as $service_id){
                    ScheduleItemService::deleteAll(["service_id" =>$service_id ]);
                //ScheduleItemService::findOne(102)->delete();
                    Service::findOne(intval($service_id))->delete();
                }


                 \Yii::$app->getSession()->setFlash('office-edit', 'Zmiany zostały zapisane');
                //return $this->render(['edit', 'id' => $id]);
              /*$office = Office::findOne($id);
                $services = Service::findAll(['office_id' => $office->id]);
                return $this->render('edit', [
                    'model' => $model,
                    'office' => $office,
                    'services' => $services,
                    'id' => $id
                ]);*/
             // $model = new Office();
                //return $this->render('index');
               return $this->redirect(['edit', 'id' => $id]);

              /*  $office = Office::findOne($id);
                $services = Service::findAll(['office_id' => $office->id]);
                return $this->render('edit', [
                    'model' => $model,
                    'office' => $office,
                    'services' => $services,
                    'id' => $id,
                    'toRemove' => 1
                ]);*/


            } else {
                $office = Office::findOne($id);
                $services = Service::findAll(['office_id' => $office->id]);
                return $this->render('edit', [
                    'model' => $model,
                    'office' => $office,
                    'services' => $services,
                    'id' => $id,
                    'toRemove' => 1
                ]);
            }
       } else throw new ForbiddenHttpException("Nie masz uprawnień do wykonania tej operacji");

    }

    public function actionDeleteOwnOffice($id)
    {
        if (\Yii::$app->user->can('updateOwnOffice', ['officeId' => $id])) {

            $office = Office::findOne($id);

         /*   if ($office->getOfficePhotos()->exists()) {
                foreach ($office->getOfficePhotos()->all() as $photo) {
                    $photo->delete();
                }
            }
            if ($office->getServices()->exists()) {
                foreach ($office->getServices()->all() as $service) {
                    $service->delete();
                }
            }
            $this->findModel($id)->delete();*/
         $office->deleteOffice();
      /*   $calendar = Calendar::find()->where(["office_id" => $id])->one();
         $scheduleItems = ScheduleItem::find()->where(["calendar_id" => $calendar->id])->all();

         foreach ($scheduleItems as $scheduleItem){

             ScheduleItemService::deleteAll(["schedule_item_id"=>$scheduleItem->id]);
         }
         ScheduleItem::deleteAll(["calendar_id" => $calendar->id]);
            Visit::deleteAll(["calendar_id" => $calendar->id]);
         Calendar::deleteAll(["office_id" => $id]);
         Service::deleteAll(["office_id" => $id]);
         OfficePhoto::deleteAll(["office_id"=>$id]);
         Office::deleteAll(["id" => $id]);
*/
            return $this->redirect(['user/settings/offices']);
        }else throw new ForbiddenHttpException("Nie masz uprawnień do wykonania tej czynności");

    }


}
