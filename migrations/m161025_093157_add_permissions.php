<?php

use yii\db\Migration;

class m161025_093157_add_permissions extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        /*Add permissions*/
        $viewLanguages = $auth->createPermission('viewLanguages');
        $viewLanguages->description = 'View list of languages';
        $auth->add($viewLanguages);

        $createLanguage = $auth->createPermission('createLanguage');
        $createLanguage->description = 'Create new language';
        $auth->add($createLanguage);

        $deleteLanguage = $auth->createPermission('deleteLanguage');
        $deleteLanguage->description = 'Delete language';
        $auth->add($deleteLanguage);

        $editLanguage = $auth->createPermission('editLanguage');
        $editLanguage->description = 'Edit language';
        $auth->add($editLanguage);


        /*Add roles*/
        $languageManager = $auth->createRole('languageManager');
        $languageManager->description = 'Language manager';
        $auth->add($languageManager);


        /*Add childs*/
        $auth->addChild($languageManager, $viewLanguages);
        $auth->addChild($languageManager, $createLanguage);
        $auth->addChild($languageManager, $deleteLanguage);
        $auth->addChild($languageManager, $editLanguage);

    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        $viewLanguages = $auth->getPermission('viewLanguages');
        $createLanguage = $auth->getPermission('createLanguage');
        $deleteLanguage = $auth->getPermission('deleteLanguage');
        $editLanguage = $auth->getPermission('editLanguage');

        $articleManager = $auth->getRole('languageManager');

        $auth->removeChildren($articleManager);

        $auth->remove($viewLanguages);
        $auth->remove($createLanguage);
        $auth->remove($deleteLanguage);
        $auth->remove($editLanguage);

        $auth->remove($articleManager);
    }
}
