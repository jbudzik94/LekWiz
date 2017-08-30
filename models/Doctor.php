<?php

namespace app\models;

use Yii;
use app\models\MainCategory;
use app\models\VisitType;
use app\models\City;

/**
 * This is the model class for table "doctor".
 *
 * @property integer $user_id
 * @property integer $city_id
 * @property integer $main_category_id
 * @property integer $visit_type_id
 * @property string $phone
 *
 * @property User $user
 * @property MainCategory $mainCategory
 * @property VisitType $visitType
 * @property City $city
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
            [['user_id', 'city_id', 'main_category_id', 'visit_type_id', 'phone'], 'required'],
            [['user_id', 'city_id', 'main_category_id', 'visit_type_id'], 'integer'],
            [['phone'], 'string', 'max' => 20],
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
            'city_id' => 'City ID',
            'main_category_id' => 'Main Category ID',
            'visit_type_id' => 'Visit Type ID',
            'phone' => 'Phone',
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
    public function getVisitType()
    {
        return $this->hasOne(VisitType::className(), ['id' => 'visit_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

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
}
