<?php

namespace app\models;

use Yii;
use app\models\MainCategory;
use app\models\VisitType;


/**
 * This is the model class for table "doctor".
 *
 * @property integer $user_id

 * @property integer $main_category_id
 * @property integer $visit_type_id
 * @property string $phone
 * @property string $degree_id
 * @property string $rating
 * @property string $rating_number
 *
 *
 * @property User $user
 * @property MainCategory $mainCategory
 * @property VisitType $visitType

 */
class Doctor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doctor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'main_category_id'], 'required'],
            [['user_id', 'main_category_id'], 'integer'],
            [['rating'], 'double'],
           // [['phone'], 'string', 'max' => 20],
            [['degree_id'], 'integer'],
            [['user_id'], 'unique'],
            //[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            //[['main_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MainCategory::className(), 'targetAttribute' => ['main_category_id' => 'id']],
            //[['visit_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VisitType::className(), 'targetAttribute' => ['visit_type_id' => 'id']],
           // [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',

            'main_category_id' => 'Main Category ID',
           // 'visit_type_id' => 'Visit Type ID',
            //'phone' => 'Phone',
            'degree_id' => 'Degree ID'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainCategory()
    {
        return $this->hasOne(MainCategory::className(), ['id' => 'main_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   /* public function getVisitType()
    {
        return $this->hasOne(VisitType::className(), ['id' => 'visit_type_id']);
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */


    public function saveDoctor($userID)
    {
        $this->user_id = $userID;

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

    public function getOfficesId($userId){
        $doctor = Doctor::find()->where(["user_id" => $userId])->one();
        $offices = Office::find()->where(["doctor_id"=>$doctor->id])->all();
        $officesId = array();
        foreach ($offices as $office){
            array_push($officesId, $office->id);
        }
        return $officesId;
    }
}
