<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateDisciplinesTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('disciplines');
        $table->addColumn('discipline_id', 'integer')
              ->addColumn('discipline_name', 'string')
              ->create();
    }
}
