<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 11.01.2018
 * Time: 17:09
 */

namespace app\rbac;

use app\models\Calendar;
use app\models\Doctor;
use app\models\Office;
use yii\rbac\Rule;

class CalendarOwnerRule extends Rule
{

    /**
     * Checks if authorID matches user passed via params
     */

    public $name = 'calendarOwner';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (isset($params['calendarId']) && Calendar::findOne($params['calendarId']) != null) {
            //$calendar = Calendar::findOne(intval($_POST['calendar_id']))
            if (Doctor::find()->where(['user_id' => $user])->one()->id != Office::findOne(Calendar::findOne($params['calendarId'])->office_id)->doctor_id)
                return false;
            else return true;
        }
        return false;

    }
}
