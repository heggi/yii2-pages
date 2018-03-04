<?php

namespace heggi\yii2pages\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Page extends ActiveRecord {

    public $picture;
    public $deletePicture;

    public static function tableName() {
        return '{{%page}}';
    }

    public function rules() {
        return [
            [['slug'], 'required'],
            [['content'], 'string'],
            [['slug', 'category'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 255],
            [['excerpt'], 'string', 'max' => 4000],
            [['slug'], 'unique'],
            [['picture'], 'file'],
            [['deletePicture'], 'integer'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'slug' => 'Ссылка',
            'category' => 'Категория',
            'title' => 'Заголовок',
            'content' => 'Содержимое',
            'excerpt' => 'Отрывок',
        ];
    }

    public function behaviors() {
        return [
            \heggi\yii2files\behaviors\FilesBehave::className(),
        ];
    }

    public function uploadFile() {
        if($this->deletePicture) {
            $this->removeFile('picture');
        }
        $upfs = UploadedFile::getInstance($this, "picture");
        $this->setFile($upfs, 'picture');
    }
}
