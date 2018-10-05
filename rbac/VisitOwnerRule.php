<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 11.01.2018
 * Time: 18:34
 */

namespace app\rbac;

use app\models\Doctor;
use app\models\User;
use app\models\UserDetails;
use app\models\Visit;
use yii\rbac\Rule;


class VisitOwnerRule extends Rule
{
    public $name = 'visitOwner';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (isset($params['visitId']) && ($visit = Visit::findOne($params['visitId'])) != null) {
            if (UserDetails::find()->where(['user_id' => $user])->one()->role == 'lekarz') {
                if ($visit ->user_id == $user || $visit ->doctor_id == Doctor::find()->where(['user_id' => $user])->one()->id)
                    return true;
            } else {
                if ($visit ->user_id == $user)
                    return true;
                return true;
            }
        }
        return false;
    }
}