<?php 

namespace Filter\Test\TestCase\Utility; 
use Cake\TestSuite\TestCase; 
use Cake\Datasource\RepositoryInterface;
use Filter\FilterAwareTrait;
use Cake\ORM\Table;
use Cake\Database\Schema\TableSchema;

class FilterAwareTraitTest extends TestCase 
{

    public function testIfObjectIsValid() 
    {    
        $mock = new class ([
            'schema' => new TableSchema('Dunno')
        ]) extends Table {
            use FilterAwareTrait;
        };

        $this->assertInstanceOf(\Filter\ORM\FilterQuery::class, $mock->query());
    }
}