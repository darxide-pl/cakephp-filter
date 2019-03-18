<?php 

namespace Filter\Storage;
use Filter\Storage\FilterStorageInterface;
use Filter\Utility\NormalizeKeyTrait;

abstract class BaseStorage implements FilterStorageInterface 
{
    use NormalizeKeyTrait; 
    
    public function write(string $key, $data) :bool 
    {
        return FALSE;
    }

    public function read(string $key) 
    {
        return FALSE;
    }

    public function delete(string $key) :bool 
    {
        return FALSE;
    }
}