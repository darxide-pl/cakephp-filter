<?php 

namespace Filter\Test\TestCase\Engine; 
use Cake\TestSuite\TestCase; 
use Filter\Engine\RequestEngine;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;

class RequestEngineTest extends TestCase 
{
    public function testNullValueWithEmptyRequest() 
    {
        $engine = new RequestEngine;
        $request = new ServerRequest;
        Router::pushRequest($request);
        $this->assertNull($engine->get('user_group'));
    }

    public function testNullValuesWithNonEmptyRequest() 
    {
        $engine = new RequestEngine;
        $request = (new ServerRequest)
            ->withData('filter' , [
                'name' => 'John'
            ])
            ->withQueryParams([
                'filter' => ['lastname' => 'Doe']
            ]);

        Router::pushRequest($request);
        $this->assertNull($engine->get('search'));
        $this->assertNull($engine->get('deeply.nested.filter'));
    }

    public function testGrabbingExpectedQueryParams() 
    {
        $engine = new RequestEngine;
        $request = (new ServerRequest)
            ->withQueryParams([
                'filter' => [
                    'lastname' => 'Doe'
                ]
            ]);

        Router::pushRequest($request);
        $this->assertTrue('Doe' === $engine->get('lastname'));
    }

    public function testGrabbingExpectedPostParams() 
    {
        $engine = new RequestEngine;
        $request = (new ServerRequest)
            ->withData('filter' , [
                'name' => 'Jade'
            ]);

        Router::pushRequest($request);
        $this->assertTrue('Jade' === $engine->get('name'));
    }

    public function testQueryParamHasHigherPriorityThanPostParams() 
    {
        $engine = new RequestEngine;
        $request = (new ServerRequest)
            ->withQueryParams([
                'filter' => ['name' => 'Jane']
            ])
            ->withData('filter' , [
                'name' => 'John'
            ]);

        Router::pushRequest($request);
        $this->assertTrue('Jane' === $engine->get('name'));
    }

    public function testArrayTypeError() 
    {
        $engine = new RequestEngine();
        $this->expectException(\TypeError::class);
        $engine->get([]);    
    }

    public function testAnyObjectTypeError() 
    {
        $engine = new RequestEngine();
        $this->expectException(\TypeError::class);    
        $engine->get(new ServerRequest);
    }

    public function testIntTypeError() 
    {
        $engine = new RequestEngine();
        $this->expectException(\TypeError::class);    
        $engine->get(14324);
    }

    public function testFloatTypeError() 
    {
        $engine = new RequestEngine();
        $this->expectException(\TypeError::class);    
        $engine->get(1.1);
    }

    public function testAnonymousClassTypeError() 
    {
        $engine = new RequestEngine();
        $this->expectException(\TypeError::class);    
        $engine->get(new class (5465, []) {});
    }

    public function testLambdaTypeError() 
    {
        $engine = new RequestEngine();
        $this->expectException(\TypeError::class);        
        $engine->get(function ($v) { return FALSE;});
    }

    public function testNoParamTypeError() 
    {
        $engine = new RequestEngine();
        $this->expectException(\TypeError::class);
        $engine->get();    
    }
}