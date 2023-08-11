<?php

namespace System\Container;

//tutorial code
class Container{
    protected array $bindings = [];

    public function bind($abstract, $concrete){
        $this->bindings[$abstract] = $concrete;
    }

    protected function isCreatable($abstract){
        $reflection = new \ReflectionClass($abstract);

        if(!$reflection->isInstantiable()){
            throw new \Exception("class not initiable");
        }
    }

    public function resolve($abstract){
        echo "\r\n Resolve Method Called :: Abstract :: " . $abstract;

        if(!isset($this->bindings[$abstract])){
            $this->isCreatable($abstract);
        }

        $concrete = $this->bindings[$abstract] ?? $abstract;

        echo "\r\n Concrete :: " . $concrete;

        return $this->buildInstance($concrete);
    }

    protected function buildInstance($class){
        echo "\r\n##########################\r\n";
        echo "\r\n BuildInstance Called :: Class :: " . $class;

        $reflection = new \ReflectionClass($class);

        $constructor = $reflection->getConstructor();

        if(!$constructor){
            echo "\r\n Constructor not Found ..";

            if($reflection->isInstantiable()){
                echo "\r\n Class  :: " . $class . " is isInstantiable .. return new instance";
                return $reflection->newInstance();
            }

            if(isset($this->bindings[$class])){
                echo "\r\n Class :: " . $class . " .. has Binding to " . $this->bindings[$class];
                echo "\r\n return Building Instance of " . $this->bindings[$class];
                return $this->buildInstance($this->bindings[$class]);
            }

            throw new \Exception("no binding provided for class :: " . $class);
        }

        echo "\r\nConstructor Found ...";

        $params = $constructor->getParameters();

        echo "\r\nParams for the Constructor Are Below ::\r\n";
        print_r($params);

        $paramInstances = [];

        foreach($params as $param){
            echo "\r\n Param Class Name :: " . $param->getType()->getName()."\r\n";

            $paramInstances[] = $this->buildInstance($param->getType()->getName());
        }

        echo "\r\n Generated Params Instances Below ::\r\n";

        print_r($paramInstances);

        echo "Returning New Instance Of Class :: " . $class;
        return $reflection->newInstanceArgs($paramInstances);
    }
}