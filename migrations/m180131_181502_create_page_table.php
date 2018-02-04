<?php

use yii\db\Migration;

/**
 * Handles the creation of table `page`.
 */
class m180131_181502_create_page_table extends Migration {

    public function up() {
        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(100)->notNull()->defaultValue('index'),
            'category' => $this->string(100)->notNull()->defaultValue('index'),
            'title' => $this->string(255),
            'content' => $this->text(),
        ]);
        $this->createIndex('slug-category-idx', '{{%page}}', ['slug', 'category'], true);
    }

    public function down() {
        $this->dropTable('{{%page}}');
    }
}
