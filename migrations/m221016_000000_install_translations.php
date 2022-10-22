<?php

use yii\db\Schema;

class m221016_000000_install_translations extends \yii\db\Migration
{
    public function up()
    {
        $this->execute('ALTER SCHEMA DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci');
        $this->execute('ALTER SCHEMA CHARACTER SET utf8 COLLATE utf8_general_ci');

        $this->createTable('{{translation}}', [
            'key' => $this->string()->notNull()->unique(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->createTable('{{translationlang}}', [
            'id' => $this->primaryKey(),
            'lang' => $this->string(10),
            'key' => $this->string(),
            'translation' => $this->string(),
        ]);
        $this->addForeignKey('fk_translationlang_lang', '{{translationlang}}', 'lang', '{{lang}}', 'shortcut', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_translationlang_translation', '{{translationlang}}', 'key', '{{translation}}', 'key', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_translationlang_lang', '{{translationlang}}');
        $this->dropForeignKey('fk_translationlang_translation', '{{translationlang}}');
        $this->dropTable('{{translationlang}}');
        $this->dropTable('{{translation}}');
    }
}
