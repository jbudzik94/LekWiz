<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 03.11.2017
 * Time: 18:52
 */

namespace app\models;


use yii\base\Model;

class IndexSearch extends Model
{
    public $categoryOrName;
    public $city;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both string
            [['city', 'categoryOrName'], 'string']

        ];
    }

    public function search($params)
    {
        $query = Doctor::find();

    }

   /* public function attributeLabels()
    {
        return [
            'categoryOrName' => 'Nazwa gabinetu',
            'city' => 'Ulica i numer budynku',

        ];
    }*/


}