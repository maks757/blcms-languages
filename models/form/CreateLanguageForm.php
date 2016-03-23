<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 04.02.2016
 * Time: 1:22
 */

namespace bl\cms\language\models\form;

use bl\multilang\entities\Language;
use RuntimeException;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

class CreateLanguageForm extends Model
{

    public $name;
    public $lang_id;
    public $active;
    public $show;

    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['name', 'unique', 'targetClass' => '\common\entities\Language', 'message' => 'This name has already been taken.'],

            ['lang_id', 'filter', 'filter' => 'trim'],
            ['lang_id', 'required'],
            ['lang_id', 'unique', 'targetClass' => '\common\entities\Language', 'message' => 'This code has already been taken.'],

            [['active', 'show'], 'boolean']
        ];
    }

    public function create() {
        if($this->validate()) {
            $language = new Language();

            $language->name = $this->name;
            $language->lang_id = $this->lang_id;
            $language->active = $this->active;
            $language->show = $this->show;

            if($language->save()) {
                return true;
            }
            else {
                throw new RuntimeException('Database exception');
            }
        }
        else {
            throw new InvalidParamException("Invalid language params");
        }
    }

}