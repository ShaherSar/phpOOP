<?php

namespace System\Container;

use ReflectionClass;

//my code
class AppContainer{
    protected array $bindings = [];

    public function bind($abstract, $concrete){
        $this->bindings[$abstract] = $concrete;
    }

    public function resolve($abstract){
        $concrete = $this->bindings[$abstract] ?? $abstract;

        if(is_callable($concrete)){
            return call_user_func($concrete);
        }

        $reflection = new ReflectionClass($concrete);

        $constructor = $reflection->getConstructor();

        if(!$constructor){

            if($reflection->isInstantiable()){
                return new $concrete;
            }

            throw new \Exception("no concrete passed for this class . " . $concrete);
        }

        $params = $constructor->getParameters();

        $deps = [];

        foreach($params as $param){
            $class = $param->getType()->getName();

            $deps[] = $this->resolve($class);
        }

        return $reflection->newInstanceArgs($deps);
    }
}