<?php

namespace backend\controllers;

use backend\exceptions\ApplicationException;
use backend\forms\auth\LoginForm;
use backend\helper\AppHelper;
use DomainException;
use Random\RandomException;
use Throwable;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        $postActions = ['logout', 'generate-apples', 'delete', 'fall-to-ground', 'eat'];

        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'generate-apples', 'delete', 'fall-to-ground', 'eat'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => array_fill_keys($postActions, ['post']),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     *
     * @throws ApplicationException
     */
    public function actionIndex(): string
    {
        return $this->render('index', [
            'appleEntities' => AppHelper::getAppleService()->getAllEntities(),
        ]);
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @throws ApplicationException|Throwable
     */
    public function actionFallToGround(int $id): Response
    {
        try {
            AppHelper::getAppleService()->fallToGround($id);
            Yii::$app->session->setFlash('success', 'Яблоко успешно упало');
        } catch (DomainException $exception) {
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect('index');
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @throws ApplicationException|Throwable
     */
    public function actionEat(int $id): Response
    {
        try {
            $percent = Yii::$app->request->post('percent');
            AppHelper::getAppleService()->eat($id, $percent);
            Yii::$app->session->setFlash('success', 'Яблоко успешно съедено');
        } catch (DomainException $exception) {
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect('index');
    }

    /**
     * @return string
     *
     * @throws ApplicationException|RandomException
     */
    public function actionGenerateApples(): string
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        return $this->renderPartial('_apples', [
            'appleEntities' => AppHelper::getAppleService()->generateRandom(),
            'now' => time(),
        ]);
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @throws ApplicationException|RandomException|Throwable
     */
    public function actionDelete(int $id): Response
    {
        try {
            AppHelper::getAppleService()->delete($id);
            Yii::$app->session->setFlash('success', 'Яблоко успешно удалено');
        } catch (DomainException $exception) {
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     *
     * @throws ApplicationException
     */
    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $form = new LoginForm();
        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $user = AppHelper::getAuthService()->authenticate($form);
                Yii::$app->user->login($user, $form->rememberMe ? Yii::$app->params['user.rememberMeDuration'] : 0);
                return $this->goBack();
            } catch (DomainException $exception) {
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        $form->password = '';

        return $this->render('login', [
            'model' => $form,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
