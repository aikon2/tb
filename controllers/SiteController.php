<?php

namespace app\controllers;

use Yii;
//use yii\filters\AccessControl;
use yii\web\Controller;
//use yii\filters\VerbFilter;
//use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller {
/**
    public function behaviors() {
        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['umenu'],
                'rules' => [
                    [
                        'actions' => ['umenu'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            
        ];
         
    }
 * 
 * @return type
 */

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'height'=>60,
                'minLength' => 3,
                'maxLength' => 4,
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }
/**
    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }
 * 
 * @return type
 */

    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(
                Yii::$app->params['adminEmail'],
                Yii::$app->params['contactEmail'])) 
                {
                    Yii::$app->session->setFlash('contactFormSubmitted');
                    return $this->refresh();
                }
        return $this->render('contact', ['model' => $model,]);
    }

    public function actionAbout() {
        return $this->render('about');
    }        
/*
    public function actionUmenu() {
        return $this->render('umenu');
    }
 * 
 */
}
