<?php 

namespace Filter\Engine; 
use Filter\Engine\FilterEngineInterface; 

abstract class BaseEngine implements FilterEngineInterface 
{
    public function get(string $key) 
    {
        return NULL;
    }
}