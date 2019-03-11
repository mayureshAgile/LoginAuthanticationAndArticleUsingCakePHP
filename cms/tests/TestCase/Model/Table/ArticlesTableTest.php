<?php
namespace App\Test\TestCase\Model\Table;
use App\Model\Table\ArticlesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class ArticlesTableTest extends TestCase
{
    public $fixtures = ['app.Articles'];
    public function setUp()
    {
        parent::setUp();
        $this->Articles = TableRegistry::getTableLocator()->get('Articles');
    }

    public function testFindPublished()
    {
        $query = $this->Articles->find('published');
        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->enableHydration(false)->toArray();
        $expected = [
            ['id' => 1, 'title' => 'First Article'],
            ['id' => 2, 'title' => 'Second Article'],
            ['id' => 3, 'title' => 'Third Article']
        ];

        $this->assertEquals($expected, $result);
    }
    public  function testBeforeSave(){
    $query = $this->Articles->find('tag_string');
    $this->assertInstanceOf('Cake\ORM\Query', $query);
    $result = $query->enableHydration(false)->toArray();
     $expected = ['ImageName' => null,
                            'user_id '=> '1',
                            'tag_string '=> 'derfgdfgd',
                            'title '=> 'second is  value',
                            'body '=> 'sdfds dsf dsa sd asd '
         ];
      $this->assertEquals($expected, $result);
    }
    public function testFindTagged()
    {
     
        $query = $this->Articles->find('tags');
//        $this->assertInstanceOf('Cake\ORM\Query', $query);
//        $result = $query->enableHydration(false)->toArray();
//        $expected = [
//            ['id' => 1, 'title' => 'First Article'],
//            ['id' => 2, 'title' => 'Second Article'],
//            ['id' => 3, 'title' => 'Third Article']
//        ];
//        $this->assertEquals($expected, $result);
    }
}
