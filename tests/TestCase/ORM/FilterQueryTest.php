<?php 

namespace Filter\Test\TestCase\ORM; 
use Cake\TestSuite\TestCase; 
use Filter\ORM\FilterQuery;
use Cake\ORM\Query;
use Filter\Test\Fixture\UsersFixture;
use Cake\ORM\Table;
use Filter\FilterAwareTrait;
use Cake\Database\Schema\TableSchema;
use Filter\Filter\BaseFilter;
use Filter\Filter\SessionFilter;
use Filter\Filter\FilterInterface;
use Filter\Storage\SessionStorage;
use Filter\Storage\BaseStorage;
use Filter\Storage\FilterStorageInterface;
class FilterQueryTest extends TestCase 
{

    public $fixtures = [UsersFixture::class];

    /**
     *  @var instance of BaseFilter 
     */
    protected $base_filter;

    /**
     *  @var instance of SessionFilter
     */
    protected $session_filter;

    public function setUp()
    {
        $this->Users = new class ([
            'schema' => new TableSchema('Users')
        ]) extends Table  {
            use FilterAwareTrait;
        };

        $this->base_filter = new class () extends BaseFilter {};
        $this->session_filter = new class () extends SessionFilter {};
    }    
    public function testFinderReturnValidObject() 
    {
        $this->assertInstanceOf(FilterQuery::class, $this->Users->find());
        $this->assertInstanceOf(Query::class, $this->Users->find());
    }

    public function testQueryReturnValidObject() 
    {
        $this->assertInstanceOf(FilterQuery::class , $this->Users->query());
        $this->assertInstanceOf(Query::class , $this->Users->query());
    }

    public function testSetFatalFilterClassForQuery() 
    {
        $this->expectException(\Error::class);
        $this->Users->find()->setFilterClass(TestCase::class);
    }
    public function testSetJustWrongFilterClassForQuery() 
    {        
        $this->expectException(\RuntimeException::class);
        $this->Users->find()->setFilterClass(Table::class);
    }

    public function testSetBaseFilterClass() 
    {
        $query = $this
            ->Users 
            ->find()
            ->setFilterClass(get_class($this->base_filter));

        $this->assertInstanceOf(FilterInterface::class, $query->getFilter());
        $this->assertInstanceOf(BaseFilter::class, $query->getFilter());
    }

    public function testSetSessionFilterClass() 
    {
        $query = $this 
            ->Users 
            ->find()
            ->setFilterClass(get_class($this->session_filter));

        $this->assertInstanceOf(FilterInterface::class , $query->getFilter());
        $this->assertInstanceOf(BaseFilter::class, $query->getFilter());
        $this->assertInstanceOf(SessionFilter::class, $query->getFilter());
    }
    
}