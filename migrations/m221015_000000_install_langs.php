<?php

use yii\db\Schema;

class m221015_000000_install_langs extends \yii\db\Migration
{
    public function up()
    {
        $this->execute('ALTER SCHEMA DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci');
        $this->execute('ALTER SCHEMA CHARACTER SET utf8 COLLATE utf8_general_ci');

        $this->createTable('{{lang}}', [
            'shortcut' => $this->string(10)->notNull()->unique(),
            'name' => $this->string()
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->insert('{{lang}}', ['shortcut' => 'cs', 'name' => 'Czech']);
        $this->insert('{{lang}}', ['shortcut' => 'en', 'name' => 'English']);
    }

    public function down()
    {
        $this->dropTable('{{lang}}');
    }
}
