<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateDisciplinesTeachersTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('disciplines_teachers', ['id' => false, 'primary_key' => 'discipline_teacher_id']);
        
        $table->addColumn('discipline_teacher_id', 'integer')
              ->addColumn('teacher_id', 'integer')
              ->addForeignKey('teacher_id', 'teachers', 'teacher_id')
              ->addColumn('discipline_id', 'integer')
              ->addForeignKey('discipline_id', 'disciplines', 'discipline_id')
              ->create();
    }
}
