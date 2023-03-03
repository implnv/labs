<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RenameCreateDateFieldFromStudents extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('students');

        $table->renameColumn('created_date', 'current_creation_date');
        $table->save();
    }
}
