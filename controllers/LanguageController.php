<?php
namespace maks757\language\controllers;

use maks757\language\models\form\CreateLanguageForm;
use maks757\multilang\entities\Language;
use RuntimeException;
use yii\base\InvalidParamException;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class LanguageController extends Controller
{
//    /**
//     * @inheritdoc
//     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'actions' => ['index'],
//                        'roles' => ['viewLanguages'],
//                        'allow' => true,
//                    ],
//                    [
//                        'actions' => ['create'],
//                        'roles' => ['createLanguage'],
//                        'allow' => true,
//                    ],
//                    [
//                        'actions' => ['delete'],
//                        'roles' => ['deleteLanguage'],
//                        'allow' => true,
//                    ],
//                    [
//                        'actions' => ['switch-active'],
//                        'roles' => ['editLanguage'],
//                        'allow' => true,
//                    ],
//                    [
//                        'actions' => ['switch-default'],
//                        'roles' => ['editLanguage'],
//                        'allow' => true,
//                    ],
//                    [
//                        'actions' => ['switch-show'],
//                        'roles' => ['editLanguage'],
//                        'allow' => true,
//                    ],
//                ],
//            ]
//        ];
//    }


    public function actionIndex() {
        $languages = Language::find()->all();
        $createLanguageForm = new CreateLanguageForm();

        return $this->render('list', [
            'languages' => $languages,
            'createLanguageForm' => $createLanguageForm
        ]);
    }

    public function actionCreate() {
        $formModel = new CreateLanguageForm();

        if($formModel->load(\Yii::$app->request->post())) {
            try {
                $formModel->create();
                $this->redirect(['/languages']);
            }
            catch(RuntimeException $ex) {
                return $this->render('/site/error', [
                    'message' => 'Internal Server Error'
                ]);
            }
            catch(InvalidParamException $ex) {
                return $this->render('/site/error', [
                    'message' => 'Error',
                    'errors' => $formModel->getErrors()
                ]);
            }
        }
    }

    public function actionDelete() {
        $id = \Yii::$app->request->get('id');
        if(Language::deleteAll(['id' => $id])) {
            $this->redirect(['/languages']);
        }
        else {
            return $this->render('/site/error', [
                'message' => 'Internal Server Error'
            ]);
        }
    }

    public function actionSwitchActive() {
        $id = \Yii::$app->request->get('id');
        if(!empty($id)) {
            if($language = Language::findOne($id)) {
                $language->active = !$language->active;
                $language->save();
            }
            else {
                return $this->render('/site/error', [
                    'message' => 'Error',
                    'errors' => 'Language is not found'
                ]);
            }
        }
        $this->redirect(['/languages']);
    }

    public function actionSwitchDefault($id) {
        if(!empty($id)) {
            if($language = Language::findOne($id)) {
                if($defaultLanguage = Language::findOne(['default' => true])) {
                    $defaultLanguage->default = false;
                    $defaultLanguage->save();
                }

                $language->default = true;
                $language->save();
            }
            else {
                // TODO: render error
            }
        }
        $this->redirect(['/languages']);
    }

    public function actionSwitchShow() {
        $id = \Yii::$app->request->get();
        if(!empty($id) && isset($id)) {
            $item = Language::findOne($id);
            if($item) {
                $show = $item->show;
                if ($show == 1) {
                    $show = 0;
                } else {
                    $show = 1;
                }
                $item->show = $show;
                $item->save();
            }
            else {
                return $this->render('/site/error', ['message' => 'Error', 'errors' => 'Language is not found']);
            }
        }
        $this->redirect(['/languages']);
    }
}