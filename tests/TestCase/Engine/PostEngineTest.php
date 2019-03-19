<?php 

namespace Filter\Test\TestCase\Engine; 
use Cake\TestSuite\TestCase; 
use Filter\Engine\PostEngine;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;

class PostEngineTest extends TestCase 
{
    public function testNullValuesWithEmptyRequest() 
    {
        $engine = new PostEngine(); 
        Router::pushRequest(new ServerRequest); 
        $this->assertNull($engine->get('lastname'));
    }
    public function testNullValuesWithNonEmptyRequest() {
        
        $engine = new PostEngine(); 
        $request = (new ServerRequest)
            ->withData('filter' , [
                'name' => 'John'
            ]);

        Router::pushRequest($request);
        $this->assertNull($engine->get('lastname'));
        $this->assertNull($engine->get('search'));
    }

    public function testGrabbingExpectedValues() 
    {
        $engine = new PostEngine(); 
        $request = (new ServerRequest)
            ->withData('filter' , [
                'name' => 'Jane',
                'lastname' => 'Doe', 
                'premium_user' => TRUE
            ]);
        
        Router::pushRequest($request);

        $this->assertTrue($engine->get('name') === 'Jane');
        $this->assertTrue($engine->get('lastname') === 'Doe');
        $this->assertTrue($engine->get('premium_user'));
    }

    public function testNullValueWhenQueryParamExists() 
    {
        $engine = new PostEngine;
        $request = (new ServerRequest)
            ->withQueryParams([
                'filter' => ['name' => 'John']
            ]);

        Router::pushRequest($request);
        $this->assertNull($engine->get('name'));
    }

    public function testDeeplyNestedValue() 
    {
        $engine = new PostEngine;
        $request = (new ServerRequest)
            ->withData('filter' , [
                'some' => [
                    'deeply' => [
                        'nested' => 'value'
                    ]
                ]
            ]);

        Router::pushRequest($request);
        $this->assertTrue('value' === $engine->get('some.deeply.nested'));
    }
    public function testArrayTypeError() 
    {
        $engine = new PostEngine();
        $this->expectException(\TypeError::class);
        $engine->get([]);    
    }

    public function testAnyObjectTypeError() 
    {
        $engine = new PostEngine();
        $this->expectException(\TypeError::class);    
        $engine->get(new ServerRequest);
    }

    public function testIntTypeError() 
    {
        $engine = new PostEngine();
        $this->expectException(\TypeError::class);    
        $engine->get(14324);
    }

    public function testFloatTypeError() 
    {
        $engine = new PostEngine();
        $this->expectException(\TypeError::class);    
        $engine->get(1.1);
    }

    public function testAnonymousClassTypeError() 
    {
        $engine = new PostEngine();
        $this->expectException(\TypeError::class);    
        $engine->get(new class (5465, []) {});
    }

    public function testLambdaTypeError() 
    {
        $engine = new PostEngine();
        $this->expectException(\TypeError::class);        
        $engine->get(function ($v) { return FALSE;});
    }

    public function testNoParamTypeError() 
    {
        $engine = new PostEngine();
        $this->expectException(\TypeError::class);
        $engine->get();    
    }    
}