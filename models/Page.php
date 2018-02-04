<?php

namespace heggi\yii2pages\models;

use Yii;
use yii\db\ActiveRecord;

class Page extends ActiveRecord {

    public static function tableName() {
        return '{{%page}}';
    }

    public function rules() {
        return [
            [['slug'], 'required'],
            [['content'], 'string'],
            [['slug', 'category'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'slug' => 'Ссылка',
            'category' => 'Категория',
            'title' => 'Заголовок',
            'content' => 'Содержимое',
        ];
    }
}
