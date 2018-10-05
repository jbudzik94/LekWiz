<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "patient_review".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $doctor_id
 * @property string $comment
 * @property string $competences
 * @property string $punctuality
 * @property string $kindness
 * @property string $recommendable
 * @property string $created_date
 *
 * @property User $user
 * @property Doctor $doctor
 */
class PatientReview extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patient_review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'doctor_id', 'comment', 'competences', 'punctuality', 'kindness', 'recommendable', 'created_date'], 'required'],
            [['user_id', 'doctor_id'], 'integer'],
            [['comment', 'competences', 'punctuality', 'kindness', 'recommendable', 'created_date'], 'string'],
           // [['created_date'], 'safe'],
           // [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            //[['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'doctor_id' => 'Doctor ID',
            'comment' => 'Comment',
            'competences' => 'Competences',
            'punctuality' => 'Punctuality',
            'kindness' => 'Kindness',
            'recommendable' => 'Recommendable',
            'created_date' => 'Created Date',
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
    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }
}
