<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateGroupsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('groups');
        $table->addColumn('group_id', 'integer')
              ->addColumn('group_name', 'string')
              ->create();
    }
}
