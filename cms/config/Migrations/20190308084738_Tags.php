<?php
use Migrations\AbstractMigration;

class Tags extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $tags = $this->table('tags', ['id' => false]);
        $tags->addColumn('title', 'string', ['limit' => 191])
              ->addColumn('created', 'datetime')
              ->addColumn('modified', 'datetime', ['null' => true])
              ->addIndex('title', ['unique' => true])
              ->save();
              
    }
}