<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddCreateDateFieldToStudents extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('students');

        $table->addColumn('created_date', 'timestamp', ['default' => 'CURRENT_TIMESTAMP']);
        $table->save();
    }
}
