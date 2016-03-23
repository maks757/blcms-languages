<?php
namespace bl\cms\language\controllers;

use bl\cms\language\models\form\CreateLanguageForm;
use bl\multilang\entities\Language;
use RuntimeException;
use yii\base\InvalidParamException;
use yii\web\Controller;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class LanguageController extends Controller
{
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'create',
                    'delete',
                    'switch-active',
                    'switch-show'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['createLanguage']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['showLanguage']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['switch-active'],
                        'roles' => ['activeLanguage']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['switch-show'],
                        'roles' => ['showLanguage']
                    ],
                ],
            ],
        ];
    }*/

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
                $this->redirect(['settings/index']);
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
            $this->redirect(['/settings']);
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
        $this->redirect(['/settings']);
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
        $this->redirect(['/settings']);
    }
}