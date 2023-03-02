<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateDisciplinesTeachersTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('disciplines_teachers');
        $table->addColumn('discipline_teacher_id', 'integer')
              ->addColumn('teacher_id', 'integer')
              ->addColumn('discipline_id', 'integer')
              ->create();
    }
}
