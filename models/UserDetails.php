<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_details".
 *
 * @property integer $user_id
 * @property string $role
 * @property string $name
 * @property string $last_name
 *
 * @property User $user
 */
class UserDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        'nameLength'   => ['name', 'string', 'min' => 3, 'max' => 40, 'message' => 'Name invalid'],
        'lastNameLength'   => ['last_name', 'string', 'min' => 3, 'max' => 40, 'message' => 'Name invalid']
           /* [['user_id', 'role', 'name', 'last_name'], 'required'],
            [['user_id'], 'integer'],
            [['role', 'name', 'last_name'], 'string', 'max' => 40],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']], */
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'role' => 'Role',
            'name' => 'Name',
            'last_name' => 'Last Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

        public function saveDetails($userID)
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

    public function isDoctor($id)
    {
        if ($this->role == 'doctor')
            return true;

    }



}
