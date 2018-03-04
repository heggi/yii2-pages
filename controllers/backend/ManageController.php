<?php

namespace heggi\yii2pages\controllers\backend;

use Yii;
use heggi\yii2pages\models\Page;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

class ManageController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
			    'class' => \yii\filters\AccessControl::className(),
			    'rules' => [
			        [
			            'allow' => true,
			            'roles' => ['@'],
			        ],
			    ],
			],
        ];
    }

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Page::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate() {
        if(!$this->module->allowCreate) {
            throw new ForbiddenHttpException('Создание новых страниц запрещено конфигурацией');
        }

        $model = new Page();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->uploadFile();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->uploadFile();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        if(!$this->module->allowDelete) {
            throw new ForbiddenHttpException('Удаление страниц запрещено конфигурацией');
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
