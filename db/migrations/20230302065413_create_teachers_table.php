<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTeachersTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('teachers', ['id' => false, 'primary_key' => 'teacher_id']);

        $table->addColumn('teacher_id', 'integer')
              ->addColumn('first_name', 'string')
              ->addColumn('second_name', 'string')
              ->addColumn('middle_name', 'string')
              ->addColumn('age_num', 'integer')
              ->addColumn('gender_id', 'integer')
              ->addForeignKey('gender_id', 'gender', 'gender_id')
              ->create();
    }
}
