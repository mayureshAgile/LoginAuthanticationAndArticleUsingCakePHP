<?php
use Migrations\AbstractMigration;

class Articles extends AbstractMigration
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
        $articles = $this->table('articles');
        $articles
              ->addColumn('user_id', 'integer', ['limit' => 11])
              ->addColumn('title', 'string', ['limit' => 30])
              ->addColumn('slug', 'string', ['limit' => 255])
              ->addColumn('body', 'string', ['limit' => 255])
              ->addColumn('published', 'integer', ['limit' => 2])
              ->addColumn('ImageName', 'string', ['limit' => 255])
              ->addColumn('created', 'datetime')
              ->addColumn('modified', 'datetime', ['null' => true])
              ->addIndex(['user_id','slug'], ['unique' => true])
              ->save();
    }
}
