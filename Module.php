<?php

namespace heggi\yii2pages;

class Module extends \yii\base\Module {
    
    public $categories = [];
    public $pages = [];
    public $allowCreate = true;
    public $allowDelete = true;
    public $ckeditor = false;
    public $elfinder = false;
    public $allowUpdateSlug = false;
    public $allowChangeCategory = false;
    public $showExcerpt = false;
    public $defaultView = 'index';
}
