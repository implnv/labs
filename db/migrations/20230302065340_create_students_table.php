<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateStudentsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('students', ['id' => false, 'primary_key' => 'student_id']);

        $table->addColumn('student_id', 'integer')
              ->addColumn('first_name', 'string')
              ->addColumn('second_name', 'string')
              ->addColumn('birth_date', 'datetime')
              ->addColumn('receipt_date', 'datetime')
              ->addColumn('group_id', 'integer')
              ->addForeignKey('group_id', 'groups', 'group_id')
              ->create();
    }
}
