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

use yii\helpers\Url;
use yii\data\Pagination;

use yii\widgets\LinkPager;



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
			
				
			// Get the user query 
			$q=Yii::$app->request->post('SearchForm')['query']; //For PHP > 5.4
			
			
			
			// Search for a document in ES 
			$params = [
				'index' => Yii::$app->params['indexName'],
				'type' =>  Yii::$app->params['indexType'],
				'from' => 0,
				'size' => Yii::$app->params['page_size'],
				'body' => [
					'query' => [
						'multi_match' => [
							'query'  => $q, 
							'fields' => [ 'city', 'state', 'employer']
						]
					]
				]
			];
		
			$response = $client->search($params);

			#echo Url::to(['', 'id' => 100, '#' => 'content']);
			#die;
			
			
			//print_r($response['hits']['total']);
			//die;
			
			// create a pagination object with the total count
			$pagination = new Pagination(['totalCount' => $response['hits']['total'],  'pageSize' =>Yii::$app->params['page_size']] );
			
			echo LinkPager::widget([
				'pagination' => $pagination,
			]);
			
			
			
			// Encode the JSON results
			//$searchresults_json= json_decode($response['hits']['hits']);
			
			// If you do not specify this, the currently requested route will be used
			$pagination->route = 'site/index';
			
			
			// displays: /index.php?r=article%2Findex&page=100
			//echo $pagination->createUrl(100);
			#die;
			
			
			// Send it to the viewer to draw it
			return $this->render('index', [
			    'model' => $model,
				'pages' => $pagination, 
				'searchresults' => $response['hits']['hits'],
			]);
			
			
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
