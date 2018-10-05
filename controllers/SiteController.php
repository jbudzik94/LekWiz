<?php

namespace app\controllers;

use app\models\Calendar;
use app\models\CertificatePhoto;
use app\models\City;
use app\models\Degree;
use app\models\Description;
use app\models\Disease;
use app\models\Doctor;
use app\models\DoctorCategory;
use app\models\IndexSearch;
use app\models\MainCategory;
use app\models\Office;
use app\models\PatientReview;
use app\models\ProfilePhoto;
use app\models\ScheduleItem;
use app\models\University;
use app\models\User;
use app\models\UserDetails;
use app\models\Visit;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\Pagination;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout', 'save-review'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['search'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //   $searchModel = new City();
        // $searchModel = new UserDetails();
        $searchModel = new MainCategory();

        //$model = new ContactForm();
        return $this->render('index', [
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionCityList($q = null, $id = null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name AS text')
                ->from('city')
                ->where(['like', 'name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => City::find($id)->name];
        }
        return $out;
    }

    public function actionCategoryList($q = null, $id = null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name AS text')
                ->from('main_category')
                ->where(['like', 'name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => MainCategory::find($id)->name];
        }
        return $out;
    }

    public function actionTestList($q = null, $id = null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            //$words[1]= "";
            $words = array_map('trim', explode(' ', $q));
            if (count($words) == 1) {
                $query = new Query;
                $query->select(["user_id AS id", "CONCAT(name, ' ', last_name) AS text"])->from('user_details')
                    ->where(['role' => 'lekarz'])
                    ->andFilterWhere(['or',
                        ['like', 'name', $words[0]],
                        ['like', 'last_name', $words[0]]])
                    ->limit(10);
                $command = $query->createCommand();
                $data = $command->queryAll();

                $out['results'] = array_values($data);
            } else {
                $query = new Query;
                $query->select(["user_id AS id", "CONCAT(name, ' ', last_name) AS text"])->from('user_details')
                    ->where(['role' => 'lekarz'])
                    ->andFilterWhere(['and',
                        ['like', 'name', $words[0]],
                        ['like', 'last_name', $words[1]]])
                    ->orFilterWhere(['and',
                        ['like', 'name', $words[1]],
                        ['like', 'last_name', $words[0]]])
                    ->limit(10);
                $command = $query->createCommand();
                $data = $command->queryAll();

                $out['results'] = array_values($data);
            }

        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'name' => UserDetails::find($id)->name, 'last' => UserDetails::find($id)->last_name];
        }
        return $out;
    }


    /* public function actionSearch($city, $category, $name)
     {

         $result = array();

         if ($city == 0) {
             if ($category == 0) {
                 if ($name == 0) {

                 } else { //name != 0
                     $tab = Doctor::find()->where(['user_id' => $name])->all(); //obiekt lekarz z wyszukanym imieniem
                 }
             } else { //category != 0
                 $doctorCategoryDoctorId = array();
                 $doctorCategory = DoctorCategory::find()->where(['main_category_id' => $category])->all();
                 foreach ($doctorCategory as $item) {
                     array_push($doctorCategoryDoctorId, $item->doctor_id);
                 }
                 if ($name == 0) {
                     //wszyscy doktorzy TYLKO z szukana specjalizacją
                     $tab = Doctor::find()->where(['main_category_id' => $category])->orWhere(["id" => $doctorCategoryDoctorId])->all(); //obiekt lekarz z wyszukaną kategorią

                 } else { //name != 0
                     //wszyscy doktorzy TYLKO z szukana specjalizacją
                     $doctorsCategory = Doctor::find()->where(['main_category_id' => $category])->orWhere(["id" => $doctorCategoryDoctorId])->all(); //obiekt lekarz z wyszukaną kategorią
                     //Pobrać imię i nazwisko lekarza
                     $nameDoctor = UserDetails::find()->where(['user_id' => $name])->one()->name;
                     $lastNameDoctor = UserDetails::find()->where(['user_id' => $name])->one()->last_name;
                     $doctorNames = UserDetails::find()->where(['role' => 'lekarz'])->andWhere(['name' => $nameDoctor])
                         ->andWhere(['last_name' => $lastNameDoctor])->all();
                     $doctorNamesDoctorId = array();
                     foreach ($doctorNames as $item) {
                         array_push($doctorNamesDoctorId, $item->user_id);
                     }
                     $doctorsWithName = Doctor::find()->where(['user_id' => $doctorNamesDoctorId])->all(); //lekarze o szukanym imieniu i nazwisku
                     //Część wspólna
                     $tab = array_map('unserialize', array_intersect(array_map('serialize', $doctorsCategory), array_map('serialize', $doctorsWithName)));
                 }
             }
         } else { //city != 0
             if ($category == 0) {
                 if ($name == 0) {
                     $doctor_ids = [];
                     $offices = Office::find()->where(['city_id' => $city])->all();
                     foreach ($offices as $office)
                         array_push($doctor_ids, $office->doctor_id);
                     $tab = Doctor::find()->where(['id' => $doctor_ids])->all();

                 } else { //name != 0
                     //  $doctorsCity = Doctor::find()->where(['city_id' => $city])->all();
                     $doctor_ids = [];
                     $offices = Office::find()->where(['city_id' => $city])->all();
                     foreach ($offices as $office)
                         array_push($doctor_ids, $office->doctor_id);
                     $doctorsCity = Doctor::find()->where(['id' => $doctor_ids])->all();
                     //$doctorsCity = Doctor::find()->where(['city_id' => $city])->all();
                     $nameDoctor = UserDetails::find()->where(['user_id' => $name])->one()->name;
                     $lastNameDoctor = UserDetails::find()->where(['user_id' => $name])->one()->last_name;
                     $doctorNames = UserDetails::find()->where(['role' => 'lekarz'])->andWhere(['name' => $nameDoctor])
                         ->andWhere(['last_name' => $lastNameDoctor])->all();
                     $doctorNamesDoctorId = array();
                     foreach ($doctorNames as $item) {
                         array_push($doctorNamesDoctorId, $item->user_id);
                     }
                     $doctorsWithName = Doctor::find()->where(['user_id' => $doctorNamesDoctorId])->all(); //lekarze o szukanym imieniu i nazwisku
                     //Część wspólna
                     $tab = array_map('unserialize', array_intersect(array_map('serialize', $doctorsCity), array_map('serialize', $doctorsWithName)));
                 }
             } else { //category != 0
                 $doctorCategoryDoctorId = array();
                 $doctorCategory = DoctorCategory::find()->where(['main_category_id' => $category])->all();
                 foreach ($doctorCategory as $item) {
                     array_push($doctorCategoryDoctorId, $item->doctor_id);
                 }
                 if ($name == 0) {
                     //część wspólna tablic LOKALIZACAJ i SPECJALIZACJA
                     $doctors = Doctor::find()->where(['main_category_id' => $category])->orWhere(["id" => $doctorCategoryDoctorId])->all(); //obiekt lekarz z wyszukaną kategorią
                     //$doctorsCity = Doctor::find()->where(['city_id' => $city])->all();
                     $doctor_ids = [];
                     $offices = Office::find()->where(['city_id' => $city])->all();
                     foreach ($offices as $office)
                         array_push($doctor_ids, $office->doctor_id);
                     $doctorsCity = Doctor::find()->where(['id' => $doctor_ids])->all();

                     $tab = array_map('unserialize', array_intersect(array_map('serialize', $doctors), array_map('serialize', $doctorsCity)));
                 } else { //name != 0
                     $doctorsWithCategory = Doctor::find()->where(['main_category_id' => $category])->orWhere(["id" => $doctorCategoryDoctorId])->all(); //obiekt lekarz z wyszukaną kategorią
                     //$doctorsCity = Doctor::find()->where(['city_id' => $city])->all();

                     $doctor_ids = [];
                     $offices = Office::find()->where(['city_id' => $city])->all();
                     foreach ($offices as $office)
                         array_push($doctor_ids, $office->doctor_id);
                     $doctorsCity = Doctor::find()->where(['id' => $doctor_ids])->all();

                     $nameDoctor = UserDetails::find()->where(['user_id' => $name])->one()->name;
                     $lastNameDoctor = UserDetails::find()->where(['user_id' => $name])->one()->last_name;
                     $doctorNames = UserDetails::find()->where(['role' => 'lekarz'])->andWhere(['name' => $nameDoctor])
                         ->andWhere(['last_name' => $lastNameDoctor])->all();
                     $doctorNamesDoctorId = array();
                     foreach ($doctorNames as $item) {
                         array_push($doctorNamesDoctorId, $item->user_id);
                     }
                     $doctorsWithName = Doctor::find()->where(['user_id' => $doctorNamesDoctorId])->all(); //lekarze o szukanym imieniu i nazwisku
                     //Część wspólna
                     $tab = array_map('unserialize', array_intersect(array_map('serialize', $doctorsCity), array_map('serialize', $doctorsWithName), array_map('serialize', $doctorsWithCategory)));


                 }
             }
         }

         foreach ($tab as $doctor) {
             array_push($result, UserDetails::find()->where(["user_id" => $doctor->user_id])->one());
         }

         $doctorsIds = array();
         foreach ($result as $item) {
             array_push($doctorsIds, Doctor::find()->where(['user_id' => $item->user_id])->one()->id);
         }

         $numberOfResult = count($result);

         $photo = array();
         for ($i = 0; $i < $numberOfResult; $i++) {
             $id = Doctor::find()->where(['user_id' => $result[$i]->user_id])->one()->id;
             $photoTmp = ProfilePhoto::find()->where(['doctor_id' => $id]);
             if ($photoTmp->exists()) {
                 $photo[$i] = $photoTmp->one()->name;
             } else {
                 $photo[$i] = '0';
             }

         }

         $categorys = array();
         for ($i = 0; $i < $numberOfResult; $i++) {
             $categorys[$i][0] = MainCategory::findOne(Doctor::findOne($doctorsIds[$i])->main_category_id)->name;
             $extraCategory = DoctorCategory::find()->where(["doctor_id" => $doctorsIds[$i]]);
             if ($extraCategory->exists()) {
                 $extraCategoryAll = $extraCategory->all();
                 for ($j = 0; $j < count($extraCategoryAll); $j++) {
                     $categorys[$i][$j + 1] = MainCategory::findOne($extraCategoryAll[$j]->main_category_id)->name;
                 }
             }
         }

         $offices = array();
         for ($i = 0; $i < $numberOfResult; $i++) {
             $doctorsOffices = Office::find()->where(["doctor_id" => $doctorsIds[$i]])->all();
             for ($j = 0; $j < count($doctorsOffices); $j++) {
                 $offices[$i][$j] = $doctorsOffices[$j];
             }
         }

         $degrees = array();
         for ($i = 0; $i < $numberOfResult; $i++) {
             $doctor = Doctor::findOne($doctorsIds[$i]);
             if ($doctor->degree_id == NULL) {
                 $degrees[$i] = "";
             } else {
                 $degrees[$i] = Degree::findOne($doctor->degree_id)->degree;
             }

         }
         if (Yii::$app->request->get()) {
             return $this->render('doctor_index', [
                 'result' => $result,
                 'photo' => $photo,
                 'category' => $category,
                 'doctorsIds' => $doctorsIds,
                 'city' => $city,
                 'categorys' => $categorys,
                 'degrees' => $degrees,
                 'offices' => $offices,
                 'name' => $name
             ]);
         } else return $this->render('about');
     }*/


    public function actionSearch($city, $category, $name)
    {
        $result = [];
        $resultCategory = [];
        $resultCity = [];
        $resultName = [];
        $userNames = [];
        if ($category != 0) {
            $doctorsCategory = Doctor::find()->where(['main_category_id' => $category])->all();
            if ($doctorsCategory != null) {
                foreach ($doctorsCategory as $doctorCategory)
                    array_push($resultCategory, $doctorCategory->id);
            }
            $doctorsCategory = DoctorCategory::find()->where(['main_category_id' => $category])->all();
            if ($doctorsCategory != null) {
                foreach ($doctorsCategory as $doctorCategory)
                   // array_push($resultCategory, $doctorCategory->doctor_id);
                    array_push($resultCategory, $doctorCategory->doctor_id);
            } 
        }

        if ($city != '0') {
            $offices = Office::find()->where(['city' => $city])->select('doctor_id')->all();
            // $resultCity = Doctor::find()->where(['id' => $offices])->select('id')->all();
            if ($offices != null) {
                foreach ($offices as $office)
                    array_push($resultCity, $office->doctor_id);
            }
            $resultCity = array_unique($resultCity);
        }

        if ($name != '0') {
            $names = explode(" ", $name);
            if (count($names) == 1) {
                $userNames = UserDetails::find()->andFilterWhere([
                    'or',
                    ['=', 'name', $names[0]],
                    ['=', 'last_name', $names[0]],
                ])->andWhere(['role' => 'lekarz'])->all();
            } else if (count($names) >= 2) {
                $userNames = UserDetails::find()->andFilterWhere([
                    'or',
                    ['=', 'name', $names[0]],
                    ['=', 'name', $names[1]],
                ])->andFilterWhere([
                    'or',
                    ['=', 'last_name', $names[0]],
                    ['=', 'last_name', $names[1]],
                ])->andWhere(['role' => 'lekarz'])->all();
            }

            if ($userNames != null) {
                foreach ($userNames as $userName)
                    array_push($resultName, Doctor::find()->where(['user_id' => $userName->user_id])->one()->id);
            }
        }

        if ($name == '0') {
            if ($category == 0) {
                if ($city == '0') {  //0,0,0
                    $result = [];
                } else { //0,0,1
                    $result = $resultCity;
                }
            } else {
                if ($city == '0') {  //0,1,0
                    $result = $resultCity;
                } else { //0,1,1
                    $result = array_intersect($resultCategory, $resultCity);
                }
            }
        } else {
            if ($category == 0) {
                if ($city == '0') {  //1,0,0
                    $result = $resultName;
                } else { //1,0,1
                    $result = array_intersect($resultName, $resultCity);
                }
            } else {
                if ($city == '0') {  //1,1,0
                    $result = array_intersect($resultName, $resultCategory);
                } else { //1,1,1
                    $result = array_intersect($resultCity, $resultCategory, $resultName);
                }
            }
        }

        $offices = [];
        $userDetails = [];
        $caregories = [];
        $doctors = [];
        $photos = [];

        // build a DB query to get all articles with status = 1
        $query = Doctor::find()->where(['id' => $result]);

        // get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();

        // create a pagination object with the total count
        $pagination = new Pagination(['pageSize' => 5, 'totalCount' => $count]);

        // limit the query using the pagination and retrieve the articles
        $doctors = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        for ($i = 0; $i < count($doctors); $i++) {
            // $doctors[$i] = Doctor::findOne($result[$i]);
            $offices[$i] = Office::find()->where(['doctor_id' => $doctors[$i]->id])->all();
            $userDetails[$i] = UserDetails::find()->where(['user_id' => $doctors[$i]->user_id])->one();
            $doctorCategorys = DoctorCategory::find()->where(["doctor_id" => $doctors[$i]->id])->all(); //pobrać id category
            $caregories[$i] = [];
            foreach ($doctorCategorys as $doctorCategory)
                array_push($caregories[$i], MainCategory::findOne($doctorCategory->main_category_id));
            $photos[$i] = ProfilePhoto::find()->where(["doctor_id" => $doctors[$i]->id])->one();
        }

        return $this->render('doctor_index', [
           'result' => $result, // doctor ids
          // 'result' => [1], 
           'offices' => $offices, //tablica office Object
            'userDetails' => $userDetails, //UserDetails Object
            'categories' => $caregories, //tablica MainCategory object
            'doctors' => $doctors, //doctors Object
            'photos' => $photos, //photos Object
            'pagination' => $pagination,
        ]);
    }

    public function actionShow($id, $week = null)
    {
        if (Doctor::findOne($id) != null) {
            $offices = array();
            $calendars = array();
            $schedule_mon = array();
            $schedule_tue = array();
            $schedule_wen = array();
            $schedule_thu = array();
            $schedule_fri = array();
            $schedule_sat = array();
            $max = array();
            $week_date = array(array());
            $week_visits_date = array(array());


            if ($week == null) {
                $week = 0;
            }

            $officesDB = Office::find()->where(["doctor_id" => $id])->all();
            for ($i = 0; $i < count($officesDB); $i++) {

                $offices[$i] = $officesDB[$i];
                $calendars[$i] = Calendar::find()->where(['office_id' => $offices[$i]->id])->one();

                if (strtotime($calendars[$i]->valid_from) < time())
                    $time = time();
                else $time = strtotime($calendars[$i]->valid_from);
                //for($j = 0; $j < 7; $j++)
                $week_date[$i][0] = date("Y-m-d", strtotime('monday this week', strtotime("+" . $week . " week", strtotime(date("Y-m-d", $time)))));
                $week_date[$i][1] = date("Y-m-d", strtotime('tuesday this week', strtotime("+" . $week . " week", strtotime(date("Y-m-d", $time)))));
                $week_date[$i][2] = date("Y-m-d", strtotime('wednesday this week', strtotime("+" . $week . " week", strtotime(date("Y-m-d", $time)))));
                $week_date[$i][3] = date("Y-m-d", strtotime('thursday this week', strtotime("+" . $week . " week", strtotime(date("Y-m-d", $time)))));
                $week_date[$i][4] = date("Y-m-d", strtotime('friday this week', strtotime("+" . $week . " week", strtotime(date("Y-m-d", $time)))));
                $week_date[$i][5] = date("Y-m-d", strtotime('saturday this week', strtotime("+" . $week . " week", strtotime(date("Y-m-d", $time)))));
                $week_date[$i][6] = date("Y-m-d", strtotime('sunday this week', strtotime("+" . $week . " week", strtotime(date("Y-m-d", $time)))));

                for ($j = 0; $j < 7; $j++){
                    $week_visits_date[$i][$j] =[];
                    $visits = Visit::find()->where(['calendar_id' => $calendars[$i], 'date' => $week_date[$i][$j], 'status' => 'zaakceptowana'])->all();
                    foreach ($visits as $visit)
                    array_push($week_visits_date[$i][$j], date("G:i", strtotime($visit ->time)));
                }

                $schedule_mon[$i] = ScheduleItem::find()->where(['calendar_id' => $calendars[$i]->id])->andWhere(["day_id" => 1])->orderBy(['start_hour' => SORT_ASC])->all();
                //dla poniedziałku zrobić godziny rozpoczęcia
                $schedule_tue[$i] = ScheduleItem::find()->where(['calendar_id' => $calendars[$i]->id])->andWhere(["day_id" => 2])->orderBy(['start_hour' => SORT_ASC])->all();
                //dla wtorku zrobić godziny rozpoczęcia
                $schedule_wen[$i] = ScheduleItem::find()->where(['calendar_id' => $calendars[$i]->id])->andWhere(["day_id" => 3])->orderBy(['start_hour' => SORT_ASC])->all();
                $schedule_thu[$i] = ScheduleItem::find()->where(['calendar_id' => $calendars[$i]->id])->andWhere(["day_id" => 4])->orderBy(['start_hour' => SORT_ASC])->all();
                $schedule_fri[$i] = ScheduleItem::find()->where(['calendar_id' => $calendars[$i]->id])->andWhere(["day_id" => 5])->orderBy(['start_hour' => SORT_ASC])->all();
                $schedule_sat[$i] = ScheduleItem::find()->where(['calendar_id' => $calendars[$i]->id])->andWhere(["day_id" => 6])->orderBy(['start_hour' => SORT_ASC])->all();
                $schedule_sun[$i] = ScheduleItem::find()->where(['calendar_id' => $calendars[$i]->id])->andWhere(["day_id" => 7])->orderBy(['start_hour' => SORT_ASC])->all();

              //  $max[$i] = max(count($schedule_mon[$i]), count($schedule_tue[$i]), count($schedule_wen[$i]), count($schedule_thu[$i]), count($schedule_fri[$i]), count($schedule_sat[$i]), count($schedule_sun[$i]));
            }

            $userId = Doctor::findOne($id)->user_id;

            $userDetails = UserDetails::find()->where(["user_id" => $userId])->one(); //name lastName

            $photo = ProfilePhoto::find()->where(['doctor_id' => $id])->one();

            $categorys = array();
            $categorys[0] = MainCategory::findOne(Doctor::findOne($id)->main_category_id)->name;
            $extraCategory = DoctorCategory::find()->where(["doctor_id" => $id]);
            if ($extraCategory->exists()) {
                $extraCategoryAll = $extraCategory->all();
                for ($j = 0; $j < count($extraCategoryAll); $j++) {
                    $categorys[$j + 1] = MainCategory::findOne($extraCategoryAll[$j]->main_category_id)->name;
                }
            }

            $descriptionDB = Description::find()->where(["doctor_id" => $id]);
            if ($descriptionDB->exists()) {
                $description = $descriptionDB->one()->content;
                if (strlen($description) < 200) {
                    $description1 = $description;
                    $description2 = null;
                } else {
                    $index = strpos($description, ' ', 200);
                    $description1 = substr($description, 0, $index);
                    $description2 = substr($description, $index);
                }

            } else {
                $description1 = null;
                $description2 = null;
            }


            $universities = array();
            $universitiesDB = University::find()->where(["id_doctor" => $id]);
            if ($universitiesDB->exists()) {
                $universitiesDB = University::find()->where(["id_doctor" => $id])->all();
                for ($i = 0; $i < count($universitiesDB); $i++) {
                    $universities[$i] = $universitiesDB[$i];
                }
            } else {
                $universities = null;
            }

            $diseases = array();
            $diseasesDB = Disease::find()->where(["doctor_id" => $id]);
            if ($diseasesDB->exists()) {
                $diseasesDB = Disease::find()->where(["doctor_id" => $id])->all(); // tutaj dać diseaseDB
                for ($i = 0; $i < count($diseasesDB); $i++) {
                    $diseases[$i] = $diseasesDB[$i];
                }
            } else {
                $diseases = null;
            }

            $certificatesPath = array();
            $certificatesDB = CertificatePhoto::find()->where(["doctor_id" => $id]);
            if ($certificatesDB->exists()) {
                $certificatesDB = CertificatePhoto::find()->where(["doctor_id" => $id])->all(); // tutaj dać diseaseDB
                for ($i = 0; $i < count($certificatesDB); $i++) {
                    $certificatesPath[$i] = "uploads/doctor_" . $id . "/" . $certificatesDB[$i]->name;
                }
            } else {
                $certificatesPath = null;
            }


            $patientReviewForm = new PatientReview();


            // build a DB query to get all articles with status = 1
            $query = PatientReview::find()->where(["doctor_id" => $id]);

            // get the total number of articles (but do not fetch the article data yet)
            $count = $query->count();

            // create a pagination object with the total count
            $pagination = new Pagination(['pageSize' => 4, 'totalCount' => $count]);

            // limit the query using the pagination and retrieve the articles
            $patientReview = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->orderBy(['id' => SORT_DESC])
                ->all();

            return $this->render('show', [
                'patientReview' => $patientReview,
                'pagination' => $pagination,
                'userDetails' => $userDetails,
                'categorys' => $categorys,
                'description1' => $description1,
                'description2' => $description2,
                'offices' => $offices,
                'photo' => $photo,
                'universities' => $universities,
                'diseases' => $diseases,
                'certificatesPath' => $certificatesPath,
                'patientReviewForm' => $patientReviewForm,
                'calendars' => $calendars,
               // 'time' => date('H:i:s'),
               // 'currentDate' => date("Y-m-d", time()),
                "schedule_mon" => $schedule_mon,
                "schedule_tue" => $schedule_tue,
                "schedule_wen" => $schedule_wen,
                "schedule_thu" => $schedule_thu,
                "schedule_fri" => $schedule_fri,
                "schedule_sat" => $schedule_sat,
                "schedule_sun" => $schedule_sun,
              //  "max" => $max,
                "doctor_id" => $id,
                "week" => $week,
                "week_visits_date" => $week_visits_date,
                "week_date" => $week_date
            ]);
        }
        throw new NotFoundHttpException("Podana strona nie istnieje");

    }


    public function actionSaveReview()
    {
        //validacj apo stroni klienta uzupełnić

        if (Yii::$app->request->post()) {
            $patientReview = new PatientReview();
            $patientReview->doctor_id = $_POST['doctor_id'];
            $patientReview->user_id = Yii::$app->user->getId();
            $patientReview->punctuality = $_POST['punctuality'];
            $patientReview->competences = $_POST['competences'];
            $patientReview->kindness = $_POST['kindness'];
            $patientReview->recommendable = $_POST['recommendable'];
            $patientReview->comment = $_POST['comment'];
            $patientReview->created_date = date('Y-m-d');
            $patientReview->save();

            $avarage = (doubleval($_POST['punctuality']) + doubleval($_POST['competences']) + doubleval($_POST['kindness']) + doubleval($_POST['recommendable'])) / 4;

            $doctor = Doctor::findOne($_POST['doctor_id']);

            $doctor->rating = ((doubleval($doctor->rating) * intval($doctor->rating_number) + $avarage)) / (intval($doctor->rating_number) + 1);
            $doctor->rating_number = intval($doctor->rating_number) + 1;
            $doctor->save();

            return true;

        }
    }

    public
    function actionAddReview()
    {

        $patientReviewForm = new PatientReview();
        return $this->renderAjax('_review_form', ['patientReviewForm' => $patientReviewForm]);

    }


}
