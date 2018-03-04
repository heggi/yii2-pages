<?php

use yii\db\Migration;

class m180219_162928_add_excerpt_column_to_page_table extends Migration {

    public function up() {
        $this->addColumn('{{%page}}', 'excerpt', $this->string(4000));
    }

    public function down() {
        $this->dropColumn('{{%page}}', 'excerpt');
    }
}
