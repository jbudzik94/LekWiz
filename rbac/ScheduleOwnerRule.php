<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 12.01.2018
 * Time: 09:04
 */

namespace app\rbac;
use app\models\Calendar;
use app\models\Doctor;
use app\models\Office;
use app\models\ScheduleItem;
use yii\rbac\Rule;

class ScheduleOwnerRule extends Rule
{
    public $name = 'scheduleOwner';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (isset($params['scheduleId']) && ($schedule = ScheduleItem::findOne($params['scheduleId'])) != null) {
         if(Doctor::findOne(Office::findOne(Calendar::findOne($schedule->calendar_id)->office_id)->doctor_id)->user_id == $user)
             return true;
        }
        return false;
    }
}