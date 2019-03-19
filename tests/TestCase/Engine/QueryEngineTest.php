<?php 

namespace Filter\Test\TestCase\Engine; 
use Cake\TestSuite\TestCase; 
use Filter\Engine\QueryEngine;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;

class QueryEngineTest extends TestCase 
{
    public function testNullValueWithEmptyRequest() 
    {
        $engine = new QueryEngine();
        Router::pushRequest(new ServerRequest);
        $this->assertNull($engine->get('lastname'));
    }

    public function testNullValuesWithNonEmptyQueryParams() 
    {
        $engine = new QueryEngine();

        $request = (new ServerRequest)
            ->withQueryParams([
                'filter' => [
                    'name' => 'John',
                    'lastname' => 'Doe'
                ]
            ]);

        Router::pushRequest($request);

        $this->assertNull($engine->get('role'));
        $this->assertNull($engine->get('payment'));
        $this->assertNull($engine->get('worgh9uerwrfha0odsghujfdlng'));
    }

    public function testGrabbingExpectedVaules() 
    {
        $engine = new QueryEngine(); 
        
        $request = (new ServerRequest)
            ->withQueryParams([
                'filter' => [
                    'name' => 'Josh', 
                    'lastname' => 'Doe',
                    'groups' => ['admin', 'customer']
                ]
            ]);
        
        Router::pushRequest($request);

        $this->assertTrue('Josh' === $engine->get('name'));
        $this->assertTrue('Doe' === $engine->get('lastname'));
        $this->assertTrue(is_array($engine->get('groups')));
        $this->assertTrue(2 === count($engine->get('groups')));
    }

    public function testDeelplyNestedFilter() 
    {
        $engine = new QueryEngine;
        $request = (new ServerRequest)
            ->withQueryParams([
                'filter' => [
                    'some' => [
                        'deeply' => [
                            'nested' => 'awesome_value'
                        ]
                    ]
                ]
            ]);
        
        Router::pushRequest($request);
        $this->assertTrue('awesome_value' === $engine->get('some.deeply.nested'));
    }

    public function testNullValueWhenNonEmptyPostParamExists() 
    {
        $engine = new QueryEngine;
        $request = (new ServerRequest)
            ->withData('filter' , [
                'name' => 'John'
            ]);

        Router::pushRequest($request);
        $this->assertNull($engine->get('name'));
    }

    public function testArrayTypeError() 
    {
        $engine = new QueryEngine();
        $this->expectException(\TypeError::class);
        $engine->get([]);    
    }

    public function testAnyObjectTypeError() 
    {
        $engine = new QueryEngine();
        $this->expectException(\TypeError::class);    
        $engine->get(new ServerRequest);
    }

    public function testIntTypeError() 
    {
        $engine = new QueryEngine();
        $this->expectException(\TypeError::class);    
        $engine->get(14324);
    }

    public function testFloatTypeError() 
    {
        $engine = new QueryEngine();
        $this->expectException(\TypeError::class);    
        $engine->get(1.1);
    }

    public function testAnonymousClassTypeError() 
    {
        $engine = new QueryEngine();
        $this->expectException(\TypeError::class);    
        $engine->get(new class (5465, []) {});
    }

    public function testLambdaTypeError() 
    {
        $engine = new QueryEngine();
        $this->expectException(\TypeError::class);        
        $engine->get(function ($v) { return FALSE;});
    }

    public function testNoParamTypeError() 
    {
        $engine = new QueryEngine();
        $this->expectException(\TypeError::class);
        $engine->get();    
    }
}