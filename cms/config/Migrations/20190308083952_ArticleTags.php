<?php
use Migrations\AbstractMigration;

class ArticleTags extends AbstractMigration
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
        $articlesTags = $this->table('articles_tags', ['id' => false]);
        $articlesTags
                ->addColumn('article_id', 'integer', ['limit' => 11])
                ->addColumn('tag_id', 'integer', ['limit' => 11])
                ->addIndex(['tag_id'])
                ->save();
              
    }
}
