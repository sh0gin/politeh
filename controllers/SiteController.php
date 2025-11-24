<?php

namespace app\controllers;

use app\models\Passport;
use app\models\RegisterForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\UserSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new RegisterForm();
        // var_dump(Yii::$app->request->post()); die;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $user = new User();
                $user->attributes = $model->attributes;
                $user->password = Yii::$app->security->generatePasswordHash($model->password);
                $user->auth_key = Yii::$app->security->generateRandomString();
                if ($user->save()) {
                    $passport = new Passport();
                    $passport->attributes = $model->attributes;
                    $passport->user_id = $user->id;
                    if ($passport->save()) {
                        Yii::$app->user->login($user);
                        Yii::$app->session->setFlash('success', "Вы успешно зарегистрировались и вошли в систему!");
                        return $this->goHome();
                    }
                }
                // VarDumper::dump($user->attributes, 10, true); die;
            }


            return $this->goBack();
        } else {

            // VarDumper::dump($model->attributes);
            // VarDumper::dump($model->errors);
            // die;
        }

        $model->password = '';
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionPersonal()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $searhModel = new UserSearch();
        $dataProvider = $searhModel->search($this->request->queryParams);
        $model = Passport::find()->where(['user_id' => Yii::$app->user->identity->id]);
        $model = new ActiveDataProvider([
            'query' => $model,
        ]);


        return $this->render('personal', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searhModel,
            'model' => $model, 
        ]);
    }

    public function actionChange()
    {
        $user = User::findOne(Yii::$app->user->identity->id);
    
        if ($user->load(Yii::$app->request->post())) {
            if ($user->save()) {
                return $this->redirect('personal');
            }
        }
        
        return $this->render('change', [
            "model" => $user,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
