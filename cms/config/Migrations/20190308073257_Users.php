<?php
use Migrations\AbstractMigration;

class Users extends AbstractMigration
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
		$users = $this->table('users');
                $users->addColumn('firstname', 'string', ['limit' => 30])
                      ->addColumn('lastname', 'string', ['limit' => 30])
                      ->addColumn('email', 'string', ['limit' => 255])
                      ->addColumn('password', 'string', ['limit' => 255])
                      ->addColumn('gender', 'integer', ['limit' => 2])
                      ->addColumn('created', 'datetime')
                      ->addColumn('modified', 'datetime', ['null' => true])
                      ->create();
    }
}
