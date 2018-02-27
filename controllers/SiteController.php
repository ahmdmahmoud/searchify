<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SearchForm;
use Elasticsearch\ClientBuilder;
require '../vendor/autoload.php';



class SiteController extends Controller
{
    /**
     * {@inheritdoc}
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
		$model = new SearchForm();
		
		$client = ClientBuilder::create()->build();

        if ($model->load(Yii::$app->request->post()) && $model->search()) 
		{
			// Index a document in elasticsearch 
			// $params = [
			// 'index' => 'my_index',
			// 'type' => 'my_type',
			// 'id' => 'my_id',
			// 'body' => ['testField' => 'abc']
			// ];

			// $response = $client->index($params);
			// print_r($response);
			// die();


			
			
			// search for a document from elasticsearch index
			$params = [
				'index' => 'bank',
				'type' => 'account',
				'body' => [
					'query' => [
						'multi_match' => [
							'query'  => 'Nelson', 
							'fields' => [ 'city', 'lastname', 'employer']
						]
					]
				]
			];

			$response = $client->search($params);
			print_r($response);
			//die;
			
			# Here, q object is the user query
			$q=Yii::$app->request->post('SearchForm')['query']; //For PHP > 5.4
			var_dump ($q);
			#return $this->refresh();
			
			return $this->render('index', [
            'model' => $model,
			]);
			
			
			#echo $q; 
			#die;
            
        }
		
        return $this->render('index', [
            'model' => $model,
        ]);
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
