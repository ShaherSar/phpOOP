<?php

namespace System\Container;

class Container{
    protected array $bindings;

    protected static ?Container $instance = null;

    protected function __construct(){

    }

    public static function getInstance(){

        if(is_null(self::$instance)){
            self::$instance = new static();
        }

        return self::$instance;
    }

    //$abstract :: abstract class , interface
    //$concrete :: instance of class or extends the abstract class, interface

    public function bind($abstract, $concrete){
        $this->bindings[$abstract] = $concrete;
    }

    //build instance of abstract class, interface passed
    //build dependencies for that class passed
    //throw exception if something goes wrong
    public function resolve($abstract){

        if(!$this->bindings[$abstract]){
            $this->ensureClassIsInitial($abstract);
        }

        $concrete = $this->bindings[$abstract] ?? $abstract;

        if(is_callable($concrete)){
            return call_user_func($concrete);
        }

        return $this->buildInstance($concrete);
    }

    protected function ensureClassIsInitial($abstract){
        $reflection = new \ReflectionClass($abstract);

        if(!$reflection->isInstantiable()){
            throw new \Exception("class init error");
        }

    }

    protected function buildInstance($class){
        $reflection = new \ReflectionClass($class);

        $constructor = $reflection->getConstructor();

        if(isset($this->bindings[$class]) and is_callable($this->bindings[$class])){
            return call_user_func($this->bindings[$class]);
        }

        if(!$constructor and $reflection->isInstantiable()){
            return new $class();
        }

        if(!$constructor and $this->bindings[$class]){
            return $this->buildInstance($this->bindings[$class]);
        }

        if(!$constructor and !isset($this->bindings[$class])){
            throw new \Exception("no binding provided for class :: " . $class);
        }

        $params = $constructor->getParameters();

        $deps = [];

        foreach($params as $param){
            if(!$param->getType() and !$param->isOptional()){
                throw new \Exception($param->getType()." is not correct . :: " . $param->getName());
            }

            $deps[] = $this->buildInstance($param->getType());
        }

        return new $class(...$deps);
    }
}