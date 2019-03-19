<?php 

namespace Filter\Engine; 
use Filter\Storage\FilterStorageInterface;
use Cake\Http\ServerRequest;

interface FilterEngineInterface {

    /**
     * 	Get filter value by key from user input 
     *  
     *  The idea: Basically we should use engine classes as way to grab values which user provides directly (get, post, json).
     * 
     *  Thats why this interface is "readonly" - generally only user can write values into post or get form 
     * 
     *  For grabbing values which was saved in sessions, cookies, database - we should implemet the FilterStorageInterface
     * 
     *  In filters we can store near to anything (typically strings, ints and arrays)
     * 	@return mixed
     */
    public function get(string $key);

    /**
     *  Get request 
     *  @return ServerRequest
     */
    public function getRequest() :ServerRequest;

    /**
     *  Set request 
     *  @param ServerRequest 
     *  @return ServerRequest
     */
    public function setRequest(ServerRequest $request) :ServerRequest;
}