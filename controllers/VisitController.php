<?php

namespace app\controllers;

use app\models\Calendar;
use app\models\Day;
use app\models\Doctor;
use app\models\DoctorCategory;
use app\models\Office;
use app\models\ProfilePhoto;
use app\models\ScheduleItem;
use app\models\ScheduleItemService;
use app\models\Service;
use app\models\User;
use app\models\UserDetails;
use Yii;
use app\models\Visit;
use app\models\VisitSearch;
use yii\base\Security;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VisitController implements the CRUD actions for Visit model.
 */
class VisitController extends Controller
{
    /**
     * @inheritdoc
     */
     public function behaviors()
      {
          return [
              'verbs' => [
                  'class' => VerbFilter::className(),
                  'actions' => [
                      'delete' => ['POST'],
                  ],
              ],
              'access' => [
                  'class' => AccessControl::className(),
                  'rules' => [
                      [
                          'allow' => true,
                          'actions' => ['make-appointment', 'my-visits', 'visits-history','confirmation', 'cancel-visit'],
                          'roles' => ['patient', 'doctor'],
                      ],
                  ],
              ],
          ];
      }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Lists all Visit models.
     * @return mixed
     */
    /*  public function actionIndex()
      {
          $searchModel = new VisitSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

          return $this->render('index', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,
          ]);
      }
  */
    /**
     * Displays a single Visit model.
     * @param integer $id
     * @return mixed
     */
    /* public function actionView($id)
     {
         return $this->render('view', [
             'model' => $this->findModel($id),
         ]);
     }
 */
    /**
     * Creates a new Visit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*   public function actionCreate()
       {
           $model = new Visit();

           if ($model->load(Yii::$app->request->post()) && $model->save()) {
               return $this->redirect(['view', 'id' => $model->id]);
           } else {
               return $this->render('create', [
                   'model' => $model,
               ]);
           }
       }*/

    /**
     * Updates an existing Visit model.
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
     * Deletes an existing Visit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    /*  public function actionDelete($id)
      {
          $this->findModel($id)->delete();

          return $this->redirect(['index']);
      }
  */
    /**
     * Finds the Visit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Visit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*  protected function findModel($id)
      {
          if (($model = Visit::findOne($id)) !== null) {
              return $model;
          } else {
              throw new NotFoundHttpException('The requested page does not exist.');
          }
      }
  */
    public function actionMakeAppointment($date, $time, $schedule) //doctor_id, schedule_id
    {

        $model = new Visit();

        if (ScheduleItem::findOne($schedule) == null) { //sprawdza czy istnieją
            throw new BadRequestHttpException('Szukana strona nie istnieje.');
        } else { // sprawdza czy jest powiązanie miedzy schedule a gabinetem należącym do podanego lekarza

            $calendar_id = ScheduleItem::findOne($schedule)->calendar_id;
            $office_id = Calendar::findOne($calendar_id)->office_id;
            $doctor_id = Office::findOne($office_id)->doctor_id;
        }

        if (Yii::$app->request->post()) {

            $post = Yii::$app->request->post('Visit');//->post('Visit[patient_name]');
            $model->patient_name = $post['patient_name'];
            $model->patient_last_name = $post['patient_last_name'];
            $model->service = Service::findOne($post['service'])->name;
            $model->calendar_id = $calendar_id;
            $model->user_id = Yii::$app->user->identity->getId();
            $model->doctor_id = $doctor_id;
            $model->date = $date;
            $model->time = $time;
            $model->token = Yii::$app->getSecurity()->generateRandomString();
            $model->status = 'oczekująca';
            $model->phone = $post['phone'];
            if ($model->save()) {
                $url = Url::to(['visit/confirmation', 'id' => $model->id, 'code' => $model->token], true);

                Yii::$app->mailer->compose('visit-confirmation', ['confirmationLink' => $url, 'date' => $date, 'time' => $time])// a view rendering result becomes the message body here
                ->setFrom('from@domain.com')
                    ->setTo(\dektrium\user\models\User::findOne(['id' => Yii::$app->user->getId()])->email)
                    ->setSubject('Message subject')
                    ->send();
                return $this->render('info_send_email');
            }

        } else { //jeśli nie wysłąno posta
            $schedule_this = ScheduleItem::findOne($schedule);
            $calendar_this = Calendar::findOne($calendar_id);
            $date_arr = []; //przechowuje możliwe daty danego dnia tygodnia w zakresie ważności kalendarza
            $time_arr = []; //przechowuje możliwe godziny w danym dniu

            if (date('N', time()) == date('N', strtotime($date))) { //jeśli wizyta jest w danym dniu
                //if (date('G:i', time())< date('Y-m-d', $i))
                $date_arr[0] = date('Y-m-d', time());
                if (strtotime($schedule_this->start_hour) > time()) //obecny czas jest wcześniejszy niż pierwsza wizytya
                    $start_time = strtotime($schedule_this->start_hour);
                else {
                    $start_time = time(); // wez pierwszy który jest późniejszy
                    for ($j = strtotime($schedule_this->start_hour); $j < strtotime("+" . $schedule_this->visit_minutes . " minutes", time()); $j = strtotime("+" . $schedule_this->visit_minutes . " minutes", $j)) {
                        //array_push($time_arr, date('G:i', $j));
                        $start_time = $j;
                    }
                }
                for ($j = $start_time; $j < strtotime($schedule_this->end_hour); $j = strtotime("+" . $schedule_this->visit_minutes . " minutes", $j)) {
                    array_push($time_arr, date('G:i', $j));
                }
            } else {

                for ($i = time(); $i <= strtotime('+1 day', strtotime($calendar_this->valid_until)); $i = strtotime('+1 day', $i)) {
                    if (date('N', $i) == $schedule_this->day_id)
                        array_push($date_arr, date('Y-m-d', $i));
                }

                for ($j = strtotime($schedule_this->start_hour); $j < strtotime($schedule_this->end_hour); $j = strtotime("+" . $schedule_this->visit_minutes . " minutes", $j)) {
                    array_push($time_arr, date('G:i', $j));
                }
            }

            $visitsExists = Visit::find()->where(['time' => $time, 'date' => $date, 'calendar_id' => $calendar_id, 'status' => 'zaakceptowana'])->exists();

            if (in_array($time, $time_arr) && in_array($date, $date_arr) && $visitsExists == null) { //jeśli taka godzina jest możliwa w schedule && istnieje taka data w schedule

                $model->patient_last_name = UserDetails::find()->where(["user_id" => Yii::$app->user->identity->getId()])->one()->last_name;
                $model->patient_name = UserDetails::find()->where(["user_id" => Yii::$app->user->identity->getId()])->one()->name;
                $scheduleServices = ScheduleItemService::find()->where(['schedule_item_id' => $schedule])->all();
                $services = [];
                foreach ($scheduleServices as $item) {
                    array_push($services, $item->service_id);
                }

                return $this->render('make_appointment', [
                    'model' => $model,
                    'calendar' => $calendar_id,
                    'doctor' => $doctor_id,
                    'date' => $date,
                    'time' => $time,
                    'services' => $services,
                    'date_arr' => $date_arr,
                    'time_arr' => $time_arr,
                    'schedule' => strtotime($schedule_this->start_hour)
                ]);

            } else {//jeśli taki termin nie istnieje
                throw new BadRequestHttpException('Szukana strona nie istnieje.');
            }
        }
    }

    public function actionConfirmation($id, $code) //visitId, token
    {
        $currentVisit = Visit::find()->where(['id' => $id, 'status' => 'oczekująca'])->one();
        if ($currentVisit != null) {
            $visits = Visit::find()->where(['time' => $currentVisit->time, 'date' => $currentVisit->date, 'calendar_id' => $currentVisit->calendar_id, 'status' => 'zaakceptowana']);
            if (date('Y-m-d', time()) == date('Y-m-d', strtotime($currentVisit->date))) {//jeśli jest w tym samym dniu
                if (strtotime($currentVisit->time) < time()) {
                    $isExpired = true;
                } else
                    $isExpired = false;
            } else if (date('Y-m-d', time()) > date('Y-m-d', strtotime($currentVisit->date)))
                $isExpired = true;
            else
                $isExpired = false;
            if ($visits->exists()) {
                \Yii::$app->getSession()->setFlash('confirmation-fail', 'Wizyta w tym terminie jest już zarezerwowana');
                return $this->render('confirmation');
            } else if ($isExpired == true) {
                \Yii::$app->getSession()->setFlash('confirmation-expired', 'Ważność linku aktywacyjnego wygasła');
                return $this->render('confirmation');
            } else if ($currentVisit->token == $code) {
                \Yii::$app->getSession()->setFlash('confirmation-success', 'confirmation-success');
                $currentVisit->status = 'zaakceptowana';
                if ($currentVisit->save())
                    return $this->render('confirmation');
            }

        } else
            throw new BadRequestHttpException('Szukana strona nie istnieje.');

    }


    public function actionMyVisits()
    {
        $user_id = Yii::$app->user->identity->getId();
        $visits = Visit::find()->where(['user_id' => $user_id, 'status' => 'zaakceptowana'])->andWhere('date >= :date', ['date' => date('Y-m-d', time())])->all();
        $doctors = [];
        $users_details = [];
        $categories = [];
        $photos = [];
        $offices = [];
        for ($i = 0; $i < count($visits); $i++) {
            $office_id = Calendar::findOne($visits[$i]->calendar_id)->office_id;
            $offices[$i] = Office::findOne($office_id);
            $doctors[$i] = Doctor::findOne($visits[$i]->doctor_id);
            $users_details[$i] = UserDetails::find()->where(['user_id' => $doctors[$i]->user_id])->one();
            $categories[$i][0] = $doctors[$i]->main_category_id;
            $categories_db = DoctorCategory::find()->where(['doctor_id' => $doctors[$i]->id]);
            if ($categories_db->exists()) {
                foreach ($categories_db->all() as $category_db) {
                    array_push($categories[$i], $category_db->main_category_id);
                }
            }
            $photos_db = ProfilePhoto::find()->where(['doctor_id' => $doctors[$i]->id]);
            if ($photos_db->exists()) {
                $photos[$i] = $photos_db->one()->name;
            } else {
                $photos[$i] = '0';
            }

        }
        return $this->render('patient_visit', [
            'visits' => $visits,
            'offices' => $offices,
            'doctors' => $doctors,
            'users_detail' => $users_details,
            'categories' => $categories,
            'photos' => $photos
        ]);
    }

    public function actionCancelVisit($id)
    {
        //if (\Yii::$app->user->can('cancelOwnVisit', ['visitId' => $id])) {
            $currentVisit = Visit::findOne($id);
            \Yii::$app->getSession()->setFlash('visit-cancel', 'Wizyta została odwołana');
            // $currentVisit->status = "odwołana";
            $currentVisit->delete();
            /* Yii::$app->mailer->compose('visit-cancel', ['date' => $currentVisit->date, 'time' => $currentVisit->time])// a view rendering result becomes the message body here
             ->setFrom('from@domain.com')
                 ->setTo(\dektrium\user\models\User::findOne(['id' => Yii::$app->user->getId()])->email)
                 ->setSubject('Message subject')
                 ->send();*/
            return $this->redirect(['visit/my-visits']);
        //} else throw new ForbiddenHttpException('Nie masz dostępu do tej strony');
    }

    public function actionVisitsHistory()
    {
        $user_id = Yii::$app->user->identity->getId();
        $visits = Visit::find()->where(['user_id' => $user_id, 'status' => 'zaakceptowana'])->andWhere('date < :date', ['date' => date('Y-m-d', time())])->all();
        $doctors = [];
        $users_details = [];
        $categories = [];
        $photos = [];
        $offices = [];
        for ($i = 0; $i < count($visits); $i++) {
            $office_id = Calendar::findOne($visits[$i]->calendar_id)->office_id;
            $offices[$i] = Office::findOne($office_id);
            $doctors[$i] = Doctor::findOne($visits[$i]->doctor_id);
            $users_details[$i] = UserDetails::find()->where(['user_id' => $doctors[$i]->user_id])->one();
            $categories[$i][0] = $doctors[$i]->main_category_id;
            $categories_db = DoctorCategory::find()->where(['doctor_id' => $doctors[$i]->id]);
            if ($categories_db->exists()) {
                foreach ($categories_db->all() as $category_db) {
                    array_push($categories[$i], $category_db->main_category_id);
                }
            }
            $photos_db = ProfilePhoto::find()->where(['doctor_id' => $doctors[$i]->id]);
            if ($photos_db->exists()) {
                $photos[$i] = $photos_db->one()->name;
            } else {
                $photos[$i] = '0';
            }

        }

        return $this->render('visit_history', [
            'visits' => $visits,
            'offices' => $offices,
            'doctors' => $doctors,
            'users_detail' => $users_details,
            'categories' => $categories,
            'photos' => $photos
        ]);
    }


}
