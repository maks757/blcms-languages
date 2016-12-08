<?php

namespace maks757\language;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class Module extends \yii\base\Module
{
    public $defaultRoute = 'language';
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    public function registerTranslations() {
        \Yii::$app->i18n->translations['*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => '@vendor/maks757/languages/messages',
            'fileMap' => [
                'languages' => 'main.php',
            ],
        ];
    }

    public static function t($message, $params = [], $language = null) {
        return \Yii::t('languages', $message, $params, $language);
    }
}