<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateGenderTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('gender');
        $table->addColumn('gender_id', 'integer')
              ->addColumn('gender_name', 'string')
              ->create();
    }
}
