<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RemoveCreateDateFieldFromStudents extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('students');

        $table->removeColumn('created_date');
        $table->save();
    }
}
