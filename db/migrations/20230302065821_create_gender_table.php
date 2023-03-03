<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateGenderTable extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('gender');

        $rows  = [
            [
                'gender_id'   => 1,
                'gender_name' => 'муж.'
            ],
            [
                'gender_id'   => 2,
                'gender_name' => 'жен.'
            ]
        ];

        $table->insert($rows)->saveData();
    }

    public function change(): void
    {
        $table = $this->table('gender', ['id' => false, 'primary_key' => 'gender_id']);

        $table->addColumn('gender_id', 'integer')
              ->addColumn('gender_name', 'string')
              ->create();
    }
}
