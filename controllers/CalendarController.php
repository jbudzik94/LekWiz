<?php

namespace app\controllers;

use app\models\Doctor;
use app\models\Office;
use app\models\ScheduleItem;
use app\models\ScheduleItemService;
use app\models\Service;
use app\models\UserDetails;
use app\models\Visit;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Null_;
use Yii;
use app\models\Calendar;
use app\models\CalendarSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CalendarController implements the CRUD actions for Calendar model.
 */
class CalendarController extends Controller
{
    /**
     * @inheritdoc
     */
    /*public function behaviors()
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
                    'delete' => ['post'],
                    'save-new-day-item' => ['post'],
                    'save-date' => ['post'],
                    'edit-day-item' => ['post'],
                    'delete-day-item' => ['post'],
                    'save-append-patient' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['edit-schedule', 'show-schedule', 'settings', 'save-new-day-item', 'save-date', 'edit-day-item', 'delete-day-item', 'cancel-visit', 'append-patient', 'save-append-patient'],
                        'roles' => ['doctor'],
                    ],
                ],
            ],
        ];
    }


    /*
        /**
         * Lists all Calendar models.
         * @return mixed
         */
    /*  public function actionIndex()
      {
          $searchModel = new CalendarSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

          return $this->render('index', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,
          ]);
      }
  */
    /**
     * Displays a single Calendar model.
     * @param integer $id
     * @return mixed
     */
    /* public function actionView($id)
     {
         return $this->render('view', [
             'model' => $this->findModel($id),
         ]);
     }

     /**
      * Creates a new Calendar model.
      * If creation is successful, the browser will be redirected to the 'view' page.
      * @return mixed
      */
    /* public function actionCreate()
     {
         $model = new Calendar();

         if ($model->load(Yii::$app->request->post()) && $model->save()) {
             return $this->redirect(['view', 'id' => $model->id]);
         } else {
             return $this->render('create', [
                 'model' => $model,
             ]);
         }
     }

     /**
      * Updates an existing Calendar model.
      * If update is successful, the browser will be redirected to the 'view' page.
      * @param integer $id
      * @return mixed
      */
    /* public function actionUpdate($id)
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
 */
    /**
     * Deletes an existing Calendar model.
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
       * Finds the Calendar model based on its primary key value.
       * If the model is not found, a 404 HTTP exception will be thrown.
       * @param integer $id
       * @return Calendar the loaded model
       * @throws NotFoundHttpException if the model cannot be found
       */
    /* protected function findModel($id)
     {
         if (($model = Calendar::findOne($id)) !== null) {
             return $model;
         } else {
             throw new NotFoundHttpException('The requested page does not exist.');
         }
     }
 */
    public function actionEditSchedule($office_id, $day_id, $schedule_id)
    {
        return $this->redirect(['settings', "office_id" => $office_id, "day_id" => $day_id, 'schedule_id' => $schedule_id]);
    }

    public function actionSettings($office_id, $day_id = null, $schedule_id = null) //menu
    {
        if (\Yii::$app->user->can('updateOwnOffice', ['officeId' => $office_id])) { //tutajj dam officeOwner
            $office = Office::findOne($office_id);
            $schedule = ScheduleItem::findOne($schedule_id);
            if ($schedule != null) { //tutajj dam scheduleOwner
                $calendar_id = $schedule->calendar_id;
                $calendar = Calendar::findOne($calendar_id);
                if ($calendar != null) {
                    if ($office_id != $calendar->office_id)
                        throw new NotFoundHttpException("Szukana strona nie istnieje");
                }
            }
            if (($office != null && in_array($day_id, [1, 2, 3, 4, 5, 6, 7]) && $schedule != null) || ($office != null && in_array($day_id, [1, 2, 3, 4, 5, 6, 7]) && $schedule_id == null)) {
                $doctor_id = Yii::$app->user->identity->getId();
                $calendar = Calendar::find()->where(['office_id' => $office_id])->one();
                $calendar_id = $calendar->id;

                $schedule_mon = ScheduleItem::find()->where(['calendar_id' => $calendar_id])->andWhere(["day_id" => 1])->orderBy(['start_hour' => SORT_ASC])->all();
                $schedule_tue = ScheduleItem::find()->where(['calendar_id' => $calendar_id])->andWhere(["day_id" => 2])->orderBy(['start_hour' => SORT_ASC])->all();
                $schedule_wen = ScheduleItem::find()->where(['calendar_id' => $calendar_id])->andWhere(["day_id" => 3])->orderBy(['start_hour' => SORT_ASC])->all();
                $schedule_thu = ScheduleItem::find()->where(['calendar_id' => $calendar_id])->andWhere(["day_id" => 4])->orderBy(['start_hour' => SORT_ASC])->all();
                $schedule_fri = ScheduleItem::find()->where(['calendar_id' => $calendar_id])->andWhere(["day_id" => 5])->orderBy(['start_hour' => SORT_ASC])->all();
                $schedule_sat = ScheduleItem::find()->where(['calendar_id' => $calendar_id])->andWhere(["day_id" => 6])->orderBy(['start_hour' => SORT_ASC])->all();
                $schedule_sun = ScheduleItem::find()->where(['calendar_id' => $calendar_id])->andWhere(["day_id" => 7])->orderBy(['start_hour' => SORT_ASC])->all();

                $services_id = [];
                $visitType = '';
                if ($schedule_id != null) {
                    // $services_id = 2;
                    $services = ScheduleItemService::find()->where(['schedule_item_id' => $schedule_id])->all();
                    $visitType = ScheduleItem::findOne($schedule_id)->visit_type;
                    foreach ($services as $service) {
                        array_push($services_id, $service->service_id);
                    }
                }


                $max = max(count($schedule_mon), count($schedule_tue), count($schedule_wen), count($schedule_thu), count($schedule_fri), count($schedule_sat), count($schedule_sun));
//$max =2;
                $valid_from = $calendar->valid_from;
                $valid_until = $calendar->valid_until;

                $doctor = Doctor::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one();
                $offices = Office::find()->where(['doctor_id' => $doctor->id])->all();
                $item = [['label' => 'Mój grafik', 'url' => ['/calendar/show-schedule']]];
                foreach ($offices as $office) {
                    array_push($item, ['label' => $office->name, 'url' => ['/calendar/settings', 'office_id' => $office->id, 'day_id' => '1']]);
                }
                return $this->render('settings', [
                    'doctor_id' => $doctor_id,
                    'office_id' => $office_id,
                    'day_id' => $day_id,
                    "schedule_mon" => $schedule_mon,
                    "schedule_tue" => $schedule_tue,
                    "schedule_wen" => $schedule_wen,
                    "schedule_thu" => $schedule_thu,
                    "schedule_fri" => $schedule_fri,
                    "schedule_sat" => $schedule_sat,
                    "schedule_sun" => $schedule_sun,
                    'max' => $max,
                    'valid_from' => $calendar->valid_from,
                    'valid_until' => $calendar->valid_until,
                    'schedule_id' => $schedule_id,
                    'services_id' => $services_id,
                    'item' => $item,
                    'visitType' => $visitType,

                ]);
            } else throw new NotFoundHttpException("Szukana strona nie ostnieje");
        } else throw  new ForbiddenHttpException('Nie masz dostępu do tej strony');
    }


    public function actionSaveNewDayItem()
    {
        if (Yii::$app->request->post()) {

            // $calendar = Calendar::find()->where(['office_id' => $_POST['officeId']])->one();
            //   $coś = $_POST['officeId'];
            if (\Yii::$app->user->can('updateOwnOffice', ['officeId' => $_POST['officeId']])) {
                $calendar = Calendar::find()->where(['office_id' => $_POST['officeId']]);
                if ($calendar->exists()) {
                    $schedule_item = new ScheduleItem();
                    $schedule_item->calendar_id = $calendar->one()->id;
                    $schedule_item->day_id = $_POST['day'];
                    $schedule_item->start_hour = $_POST['startHour'];
                    $schedule_item->end_hour = $_POST['endHour'];
                    $schedule_item->visit_minutes = intval($_POST['visitMinutes']);
                    $schedule_item->visit_type = $_POST['visitType'];
                    $schedule_item->save();

                    $visitTypes = json_decode($_POST['services']);

                    foreach ($visitTypes as $d) {
                        $schedule_item_services = new ScheduleItemService();
                        $schedule_item_services->schedule_item_id = $schedule_item->id;
                        $schedule_item_services->service_id = $d;
                        $schedule_item_services->save();
                    }

                    //return "data[0] " . $data[0] . " data[1] " . $data[1];
                    return true;
                } else {
                    return false;

                }
            } else throw new ForbiddenHttpException("Nie masz dostępu do tej strony");
        }
    }


    public function actionSaveDate()
    {
        if (Yii::$app->request->post()) {
            if (\Yii::$app->user->can('updateOwnOffice', ['officeId' => $_POST['officeId']])) {

                $calendar = Calendar::find()->where(['office_id' => $_POST['officeId']])->one();
                $calendar->valid_from = $_POST['startDay'];
                $calendar->valid_until = $_POST['endDay'];
                if ($calendar->save())
                    return "zapisano";
                else
                    return "nie zapisano";
            } else throw new ForbiddenHttpException("nie masz dostępu do tej strony");
        }
    }

    /*    public function actionTest($office_id, $day_id, $schedule_id = null)
        {
            $office = Office::findOne($office_id);

            $doctor_id = Yii::$app->user->identity->getId();
            $calendar = Calendar::find()->where(['office_id' => $office_id])->one();
            $calendar_id = $calendar->id;

            $schedule_mon = ScheduleItem::find()->where(['calendar_id' => $calendar_id])->andWhere(["day_id" => 1])->all();
            $schedule_tue = ScheduleItem::find()->where(['calendar_id' => $calendar_id])->andWhere(["day_id" => 2])->all();
            $schedule_wen = ScheduleItem::find()->where(['calendar_id' => $calendar_id])->andWhere(["day_id" => 3])->all();
            $schedule_thu = ScheduleItem::find()->where(['calendar_id' => $calendar_id])->andWhere(["day_id" => 4])->all();
            $schedule_fri = ScheduleItem::find()->where(['calendar_id' => $calendar_id])->andWhere(["day_id" => 5])->all();
            $schedule_sat = ScheduleItem::find()->where(['calendar_id' => $calendar_id])->andWhere(["day_id" => 6])->all();
            $schedule_sun = ScheduleItem::find()->where(['calendar_id' => $calendar_id])->andWhere(["day_id" => 7])->all();

            if ($schedule_id != null) {
                $services_id = 2;
            } else $services_id = 1;

            $max = max(count($schedule_mon), count($schedule_tue), count($schedule_wen), count($schedule_thu), count($schedule_fri), count($schedule_sat), count($schedule_sun));

            return $this->render('settings', [
                'doctor_id' => $doctor_id,
                'office_id' => $office_id,
                'day_id' => $day_id,
                "schedule_mon" => $schedule_mon,
                "schedule_tue" => $schedule_tue,
                "schedule_wen" => $schedule_wen,
                "schedule_thu" => $schedule_thu,
                "schedule_fri" => $schedule_fri,
                "schedule_sat" => $schedule_sat,
                "schedule_sun" => $schedule_sun,
                'max' => $max,
                'valid_from' => $calendar->valid_from,
                'valid_until' => $calendar->valid_until,
                'schedule_id' => $schedule_id
            ]);
        }
    */
    public function actionEditDayItem()
    {
        if (Yii::$app->request->post()) {
            if (\Yii::$app->user->can('editOwnSchedule', ['scheduleId' => $_POST['scheduleId']])) {

                $scheduleId = $_POST['scheduleId'];
                $startHour = $_POST['startHour'];
                $endHour = $_POST['endHour'];
                $visitMinutes = $_POST['visitMinutes'];
                $services = json_decode($_POST['services']); //id services

                $schedule = ScheduleItem::findOne($scheduleId);
                $schedule->start_hour = $startHour;
                $schedule->end_hour = $endHour;
                $schedule->visit_minutes = $visitMinutes;
                $schedule->visit_type = $_POST['visitType'];
                $schedule->save();

                ScheduleItemService::deleteAll(['schedule_item_id' => $scheduleId]);

                foreach ($services as $d) {
                    $schedule_item_services = new ScheduleItemService();
                    $schedule_item_services->schedule_item_id = $scheduleId;
                    $schedule_item_services->service_id = $d;
                    $schedule_item_services->save();
                }
            } else throw new ForbiddenHttpException("Nie masz dostępu do tej strony");
        }
        return " editk";
    }

    public function actionDeleteDayItem()
    {
        if (Yii::$app->request->post()) {
            if (\Yii::$app->user->can('editOwnSchedule', ['scheduleId' => $_POST['scheduleId']])) {

                ScheduleItemService::deleteAll(['schedule_item_id' => $_POST['scheduleId']]);
                ScheduleItem::deleteAll(['id' => $_POST['scheduleId']]);
            } else throw new ForbiddenHttpException("Nie masz dostępu do tej strony");
        }
        return " delete";
    }

    public function actionShowSchedule($day = null)
    { //menu

        $doctor = Doctor::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one();
        $offices = Office::find()->where(['doctor_id' => $doctor->id])->all();
        $item = [['label' => 'Mój grafik', 'url' => ['/calendar/show-schedule']]];
        $visits_time = [];
        $exceptional_visits = []; //wizyty które za zarezerwowane ale nie pokrywają się z godzinami kalendarza
        $time_arr = [];
        foreach ($offices as $office) {
            array_push($item, ['label' => $office->name, 'url' => ['/calendar/settings', 'office_id' => $office->id, 'day_id' => '1']]);
        }

        if (time() > strtotime($day . ' 24:00:00')) {
            $info = 'dzień przeminął';
            $visits = Visit::find()->where(['doctor_id' => $doctor->id, 'status' => 'zaakceptowana', 'date' => $day])->all();

        } else {

            $info = 'dzień nie przeminął';
            if ($day == null)
                $day = date('Y-m-d', time());

            $day_int = date('N', strtotime($day));
            $time_arr = Array(
                'time' => array(),
                'schedule' => array(
                    'id' => array(),
                    'minutes' => array()
                )
            );

            $calendar_ids = [];
            foreach ($offices as $office) {
                if (Calendar::find()->where(['office_id' => $office])->andWhere('valid_until >= :date and valid_from <= :date ', ['date' => $day])->one() != null)
                    array_push($calendar_ids, Calendar::find()->where(['office_id' => $office])
                        ->andWhere('valid_until >= :date and valid_from <= :date', ['date' => $day])->one()->id);
            }

            $schedules = ScheduleItem::find()->where(['calendar_id' => $calendar_ids, 'day_id' => $day_int])->orderBy(['start_hour' => SORT_ASC])->all();

            foreach ($schedules as $schedule) {
                for ($j = strtotime($schedule->start_hour); $j < strtotime($schedule->end_hour); $j = strtotime("+" . $schedule->visit_minutes . " minutes", $j)) {
                    array_push($time_arr['time'], date('G:i', $j));
                    array_push($time_arr['schedule']['id'], $schedule->id);
                    array_push($time_arr['schedule']['minutes'], $schedule->visit_minutes);
                }
            }

            $visits = Visit::find()->where(['doctor_id' => $doctor->id, 'status' => 'zaakceptowana', 'date' => $day])->all();

            for ($i = 0; $i < count($visits); $i++) {
                array_push($visits_time, date('G:i', strtotime($visits[$i]->time)));
                if (!in_array($visits_time[$i], $time_arr['time']))
                    array_push($exceptional_visits, $visits[$i]);
            }
        }

        return $this->render('show_schedule', [
            'item' => $item,
            'visits' => $visits,
            'visits_time' => $visits_time,
            'time_arr' => $time_arr,
            // 'schedules' => $schedules,
            'exceptional_visits' => $exceptional_visits,
            'day' => $day,
            'info' => $info
        ]);
    }

    public function actionCancelVisit($id, $day = null)
    { //przez lekarza

        if (\Yii::$app->user->can('cancelOwnVisit', ['visitId' => $id])) {
            $visit = Visit::findOne($id);

            if ($visit != null) {
                if (strtotime($visit->date . ' ' . $visit->time) >= time()) {
                    if ($visit->user_id != null) {
                        if (Yii::$app->mailer->compose('visit-cancel-doctor', ['date' => $visit->date, 'time' => $visit->time, 'user_details' => UserDetails::find()->where(['user_id' => Yii::$app->user->getId()])->one()])// a view rendering result becomes the message body here
                        ->setFrom('from@domain.com')
                            ->setTo(\dektrium\user\models\User::findOne(['id' => $visit->user_id])->email)
                            ->setSubject('Message subject')
                            ->send())
                            $visit->delete();
                        return $this->redirect(['show-schedule', 'day' => $day]);
                    } else {
                        $visit->delete();
                        return $this->redirect(['show-schedule', 'day' => $day]);
                    }
                }
                return $this->redirect(['show-schedule', 'day' => $day]);
            }
            return $this->redirect(['show-schedule', 'day' => $day]);
        } else throw new ForbiddenHttpException("Nie masz dostępu");
    }

    public function actionAppendPatient($time, $date, $schedule_id)
    {
        if (\Yii::$app->user->can('editOwnSchedule', ['scheduleId' => $schedule_id])) {
            //  if(false){
            $visit = new Visit();
            $calendar_id = ScheduleItem::findOne($schedule_id)->calendar_id;
            $schedule_item_services = ScheduleItemService::find()->where(['schedule_item_id' => $schedule_id])->all();
            $services_id = [];
            foreach ($schedule_item_services as $schedule_item_service) {
                array_push($services_id, $schedule_item_service->service_id);
            }
            $services = Service::find()->where(['id' => $services_id])->all();
            return $this->renderAjax('_append_patient', ['visit' => $visit, 'time' => $time, 'date' => $date, 'services' => $services, 'calendar_id' => $calendar_id]);
            //}
        } else throw new ForbiddenHttpException("Nie masz dostępu do tej strony");
    }

    public function actionSaveAppendPatient()
    {
        if (Yii::$app->request->post()) {
              if (\Yii::$app->user->can('appendPatient', ['calendarId' => intval($_POST['calendar_id'])])) {
            if (Visit::find()->where(['date' => $_POST['date'], 'time' => $_POST['time'], 'calendar_id' => intval($_POST['calendar_id'])])->exists()) {
                \Yii::$app->getSession()->setFlash('reserved', 'Ten termin jest już zarezerwowany.');
                return $this->redirect(['calendar/show-schedule', 'day' => date('Y-m-d', strtotime($_POST['date']))]);
            }
            if (strtotime($_POST['date'] . ' ' . $_POST['time']) >= time()) {
                $visit = new Visit();
                $visit->status = 'zaakceptowana';
                $visit->service = Service::findOne($_POST['service_id'])->name;
                $visit->calendar_id = intval($_POST['calendar_id']);//Calendar::find()->where(['office_id' =>118])->one()->id;
                $visit->patient_name = $_POST['name'];
                $visit->patient_last_name = $_POST['last_name'];
                $visit->phone = $_POST['phone'];
                $visit->date = $_POST['date'];
                $visit->time = $_POST['time'];
                $visit->doctor_id = Doctor::find()->where(['user_id' => Yii::$app->user->getId()])->one()->id;
                $visit->save();
                return $this->redirect(['calendar/show-schedule', 'day' => date('Y-m-d', strtotime($_POST['date']))]);
            }
            return $this->redirect(['calendar/show-schedule', 'day' => date('Y-m-d', strtotime($_POST['date']))]);
        }
           } else {

               throw new ForbiddenHttpException("Nie masz uprawnień do wykonania tej operacji");
           }

    }

}
