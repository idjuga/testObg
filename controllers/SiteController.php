<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
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
     * @return string
     */
   /* public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }*/

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
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

    public function actionUsermail()
    {
        $email = Yii::$app->request->post('usermail');
        $token = Yii::$app->security->generateRandomString(24);
        $link = \yii\helpers\Html::a ( 'авторизації',  ['/site/confirmlogin', 'q'=>$token], $options = [] );
        $model = new \app\models\SendetMails();
        $model->email = $email;
        $model->token = $token;
        $model->save(false);
        Yii::$app->mailer->compose()
            ->setFrom('admin@test.com')
            ->setTo($email)
            ->setSubject('Message subject')
//            ->setTextBody('Plain text content')
            ->setHtmlBody('<span>Перейдіть за посиланням для </span>'.$link )
            ->send();
        Yii::$app->session->setFlash('sendUserMail');
        //echo '<span>Перейдіть за посиланням для </span>'.$link;
        return $this->render('index',['message'=>'<span>Перейдіть за посиланням для </span>'.$link]);
    }

    public function actionConfirmlogin()
    {
        $token = Yii::$app->request->get('q');
        $model = \app\models\SendetMails::find()->where(['token'=>$token])->one();
        if($model){
            $email = $model->email;
            $arr = explode('@',$email);
            $userlogin = $arr[0];
            $user = \dektrium\user\models\User::findOne(['username'=>$userlogin, 'email'=>$email]);
            $model->delete();
            if ($user) {
                Yii::$app->user->switchIdentity($user);
                return $this->redirect(['/user/settings/profile']);
            }
            else{
                /*/ttt/web/index.php?r=user%2Fregistration%2Fregister*/
                $user = new \dektrium\user\models\User();
                $user->email = $email;
                $user->username = $userlogin;            
                $user->register();
                Yii::$app->user->switchIdentity($user);
                return $this->redirect(['/user/settings/profile']);
            }
        }
        else return $this->redirect(['/']);
    }
}
