<?php

use yii\db\Migration;

class m170107_095500_create_tables_geo extends Migration
{
    public function up()
    {
      $this->createTable('geo_type', [
           'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
           'name' => $this->string()->notNull()->defaultValue(''),
           'machine_name' => $this->string()->notNull()->defaultValue(''),
           'PRIMARY KEY (`id`)',
           'UNIQUE KEY (machine_name)'
       ]);

      $this->createTable('geo', [
           'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
           'geo_type_mn' => $this->string()->notNull(),
           'rus' => $this->string()->notNull(),
           'eng' => $this->string()->notNull(),
           'rus_adjective_masculine' => $this->string()->notNull(),
           'rus_adjective_feminine' => $this->string()->notNull(),
           'rus_adjective_neuter' => $this->string()->notNull(),
           'rus_adjective_alias' => $this->string(),
           'PRIMARY KEY (`id`)'
       ]);

       $this->addForeignKey('fk_geo_type_mn',"{{%geo}}", 'geo_type_mn', '{{%geo_type}}', 'machine_name');

       $this->batchInsert('geo_type',[
            'name','machine_name'
         ],[
            ['страна','country'],
            ['город','city'],
            ['область','region']
         ]);

       $this->batchInsert('geo',[
          'geo_type_mn', 'rus', 'eng', 'rus_adjective_masculine','rus_adjective_feminine', 'rus_adjective_neuter','rus_adjective_alias'
       ],[
         ['country','Россия','Russia','Российский','Российская','Российское','Русский'],
         ['country','Китай','China','Китайский','Китайская','Китайское', NULL],
         ['country','Грузия','Georgia','Грузинский','Грузинская','Грузинское', NULL],
         ['country','Италия','Italy','Итальянский','Итальянская','Итальянское', NULL],
         ['country','Тайланд','Thailand','Тайский','Тайская','Тайское', NULL],
       ]);
    }

    public function down()
    {
        $this->dropTable('geo');
        $this->dropTable('geo_type');
    }
}
