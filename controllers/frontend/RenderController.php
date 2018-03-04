<?php

namespace heggi\yii2pages\controllers\frontend;

use Yii;
use yii\web\Controller;
use heggi\yii2pages\models\Page;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

class RenderController extends Controller {

    public function actionIndex($cat1 = 'index', $cat2 = 'index', $cat3 = 'index', $page = 'index') {
        $category = $this->catConcat($cat1, $cat2, $cat3);

        if (($model = Page::findOne(['category' => $category, 'slug' => $page])) === null) {
            throw new NotFoundHttpException('Запрошенная страница не существует');
        }

        //view for category
        $this->layout = ArrayHelper::getValue($this->module->categories, $category.'.layout', $this->layout);
        $view = ArrayHelper::getValue($this->module->categories, $category.'.view', $this->module->defaultView);

        //view for personal page
        $this->layout = ArrayHelper::getValue($this->module->pages, $category.'/'. $page .'.layout', $this->layout);
        $view = ArrayHelper::getValue($this->module->pages, $category.'/'. $page .'.view', $view);

        return $this->render($view, compact('model'));
    }

    private function catConcat($cat1, $cat2, $cat3) {
        if($cat1 === 'index') {
            return 'index';
        }

        if($cat2 === 'index') {
            return $cat1;
        }

        if($cat3 === 'index') {
            return "${cat1}-${cat2}";
        }

        return "${cat1}-${cat2}-${cat3}";
    }
}