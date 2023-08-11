<?php
require 'vendor/autoload.php';

use System\Container\AppContainer;

$app = new AppContainer();

interface PaymentGateway{
    public function pay();
}

class Stripe implements PaymentGateway{
    public function pay (){
        echo "\r\nstrip pay called\r\n";
    }
}

class PayPal implements PaymentGateway{
    public function pay (){
        echo "\r\npaypal pay called\r\n";
    }
}

class PaymentService{
    protected PaymentGateway $paymentGateway;
    protected PaymentLogin $paymentLogin;

    public function __construct(PaymentGateway $paymentGateway, PaymentLogin $paymentLogin){
        echo "PaymentService :: __construct called";
        $this->paymentLogin = $paymentLogin;
        $this->paymentGateway = $paymentGateway;
    }

    public function pay(){
        echo "PaymentService :: pay() called";
        $this->paymentGateway->pay();
    }

    public function login(){
        $this->paymentLogin->login();
    }
}

class PaymentLogin{
    public function __construct($api_key, $api_secret){
        echo "\r\n__construct called\r\n";
    }

    public function login(){
        echo "\r\nlogin called :: true\r\n";
    }
}

$app->bind(PaymentGateway::class, Stripe::class);

$app->bind(PaymentLogin::class, function (){
    return new PaymentLogin("username", "password");
});

try{
    $paymentService = $app->resolve(PaymentService::class);

    $paymentService->login();

    $paymentService->pay();
}catch (Exception $e){
    echo $e->getMessage();
}

