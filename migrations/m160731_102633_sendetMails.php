<?php

use yii\db\Migration;

class m160731_102633_sendetMails extends Migration
{
    public $tableName = '{{sendetMails}}';

    public function up()
    {
        $this->createTable(
            $this->tableName,
            array(
                'id' => 'INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'email' => 'VARCHAR(255) NOT NULL',
                'token' => 'VARCHAR(255) NOT NULL',

            ),
            'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci'
        );
    }

    public function down()
    {
        echo "m160731_102633_sendetMails cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
