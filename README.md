<img src="https://gist.githubusercontent.com/alexsantossilva/d714e42d00e8bbaa5bece16e88f4c87f/raw/11cb121c10abcf5cd1a2eaadc9bdf14970ee4900/rakuten-connector-logo.png" align="top>" />

# Rakuten PHP SDK Client.
>

[![wercker status](https://app.wercker.com/status/0427e4e65bb1ad0ca4d2e5ed759d1743/m/master "wercker status")](https://app.wercker.com/project/byKey/0427e4e65bb1ad0ca4d2e5ed759d1743)

> O jeito mais simples e rápido de integrar o RakutenPay a sua aplicação PHP

**Instruções**

- [Instalação](#instalação)
- [Configurando a autenticação](#configurando-a-autenticação)
    - [Implementação do RakutenPay](#implementando-rakutenPay)
    - [Implementação do RakutenLogistics](#implementando-rakutenLogistics)
- [RakutenPay](#RakutenPay):
    - [Pedidos](#Pedidos)
        - [Criando Pedido no Boleto](#criando-pedido-no-boleto)
        - [Criando Pedido no Cartão de Crédito](#criando-pedido-no-cartão-de-crédito)
        - [Cancelando um Pedido](#cancelando-um-pedido)
        - [Estorno Total de um Pedido](#estorno-total-de-um-pedido)
        - [Estorno Parcial de um Pedido](#estorno-parcial-de-um-pedido)
        - [Consultas](#consulta)
            - [Verificar Credenciais](#verificar-credenciais)
            - [Juros Comprador](#juros-comprador)
- [RakutenLogistics](#RakutenLogistics)
    - [Consultar Endereço](#consultar-endereço)
    - [Criar Cálculo](#criar-cálculo)
    - [Criar Lote](#criar-lote)
    - [Detalhes do Pedido](#detalhes-do-pedido)
- [Suporte](#suporte)


## Dependências
#### require
* PHP >= 5.6

#### require-dev
* phpunit/phpunit ~ 5.7.27

## Instalação

Execute em seu shell:

```
composer require rakuten/rakuten-sdk-php
```

## Configurando a autenticação

```php
require 'vendor/autoload.php';

use Rakuten\Connector\RakutenPay;
use Rakuten\Connector\Enum\Environment;

$document = '77753821000123';
$apiKey = '546JK45NJ6K4N6456JKLN6464J5N';
$signature = '123IOU3OI2U1IIOU1OI3UIO23';
```

### Implementando RakutenPay
```php
$rakutenPay = new RakutenPay($document, $apiKey, $signature, Environment::SANDBOX);
```

### Implementando RakutenLogistics
```php
$rakutenLog = new RakutenLog($document, $apiKey, $signature, Environment::SANDBOX);
```

# RakutenPay
## Pedidos
### Criando pedido no boleto
Neste exemplo será criado um pedido.
```php
$order = $rakutenPay
            ->order()
            ->setAmount(200.0)
            ->setCurrency("BRL")
            ->setFingerprint("fake-fingerprint")
            ->setWebhookUrl("http://intregation.test/sdk/")
            ->setReference("Pedido#01")
            ->setItemsAmount(200.0)
            ->setPayerIp("127.0.0.1")
            ->setTaxesAmount(0)
            ->setShippingAmount(0)
            ->setDiscountAmount(0)
            ->addItem(
                "Pedido#01",
                "NIKE TENIS",
                1,
                200.0,
                200.0
            );

$customer = $rakutenPay
            ->customer()
            ->setName("Maria")
            ->setBirthDate("1985-04-16")
            ->setBusinessName("Maria")
            ->setDocument("12345678909")
            ->setEmail("teste@teste.com.br")
            ->setKind("personal")
            ->addAddress("shipping",
                "09840-500",
                "Rua Dos Morros",
                "1000",
                "ABC",
                "Maua",
                "SP",
                "Maria",
                "")
            ->addAddress("billing",
                "09840-500",
                "Rua Dos Morros",
                "1000",
                "ABC",
                "Maua",
                "SP",
                "Maria",
                "")
            ->addAPhones("55",
                "11",
                "999999998",
                "others",
                "shipping")
            ->addAPhones("55",
                "11",
                "999999998",
                "others",
                "billing");

$payment = $rakutenPay
    ->asBillet()
    ->setAmount(200.0)
    ->setExpiresOn("3");
    
$response = $rakutenPay->createOrder($order, $customer, $payment);
print_r($response);
```

### Criando pedido no cartão de crédito
Neste exemplo será criado um pedido.
```php
$order = $rakutenPay
            ->order()
            ->setAmount(200.0)
            ->setCurrency("BRL")
            ->setFingerprint("fake-fingerprint")
            ->setWebhookUrl("http://intregation.test/sdk/")
            ->setReference("Pedido#01")
            ->setItemsAmount(200.0)
            ->setPayerIp("127.0.0.1")
            ->setTaxesAmount(0)
            ->setShippingAmount(0)
            ->setDiscountAmount(0)
            ->addItem(
                "Pedido#01",
                "NIKE TENIS",
                1,
                200.0,
                200.0
            );

$customer = $rakutenPay
            ->customer()
            ->setName("Maria")
            ->setBirthDate("1985-04-16")
            ->setBusinessName("Maria")
            ->setDocument("12345678909")
            ->setEmail("teste@teste.com.br")
            ->setKind("personal")
            ->addAddress("shipping",
                "09840-500",
                "Rua Dos Morros",
                "1000",
                "ABC",
                "Maua",
                "SP",
                "Maria",
                "")
            ->addAddress("billing",
                "09840-500",
                "Rua Dos Morros",
                "1000",
                "ABC",
                "Maua",
                "SP",
                "Maria",
                "")
            ->addAPhones("55",
                "11",
                "999999998",
                "others",
                "shipping")
            ->addAPhones("55",
                "11",
                "999999998",
                "others",
                "billing");

$payment = $rakutenPay
    ->asCreditCard()
    ->setToken("fake-credit-card-token")
    ->setReference("Pedido#01")
    ->setInstallmentsQuantity(10)
    ->setHolderName("MARIA DA SILVA")
    ->setHolderDocument("12345678909")
    ->setCvv("123")
    ->setBrand("VISA")
    ->setAmount(200.0)
    ->setInstallmentInterest(
        1,
        0,
        200,
        200,
        200
    );

$response = $rakutenPay->createOrder($order, $customer, $payment);
print_r($response);
```

### Cancelando um Pedido
Neste exemplo será cancelado um pedido.
```php
$response = $rakutenPay->cancel("fake-charge-uuid", Requester::RAKUTEN, "Produto errado.");

print_r($response);
```

### Estorno Total de um Pedido
Neste exemplo será feito o estorno total de um pedido.
```php
// Parametro Opcional
$bankAccount = [
            'document' => '11111111111',
            'bank_code' => '341',
            'bank_agency' => '1234',
            'bank_number' => '12345678-1',
        ];

$refund = $rakutenPay->asRefund();

$refund->setReason("Comprou errado.")
    ->setRequester(Requester::RAKUTEN)
    ->addPayment('fake-payment-id', 250, $bankAccount);

$response = $rakutenPay->refund($refund, "fake-charge-uuid");

print_r($response);
```

### Estorno Parcial de um Pedido
Neste exemplo será feito o estorno parcial de um pedido.
```php
// Parametro Opcional
$bankAccount = [
            'document' => '11111111111',
            'bank_code' => '341',
            'bank_agency' => '1234',
            'bank_number' => '12345678-1',
        ];

$refund = $rakutenPay->asRefund();

$refund->setReason("Comprou errado.")
    ->setRequester(Requester::RAKUTEN)
    ->addPayment('fake-payment-id', 50, $bankAccount);

$response = $rakutenPay->refundPartial($refund, "fake-charge-uuid");

print_r($response);
```

## Consulta
### Juros Comprador

```php
$amount = 1000
$response = $rakutenPay->checkout($amount);
print_r($response);
```

### Verificar Credenciais

```php
$response = $rakutenPay->authorizationValidate();
print_r($response);
```

# RakutenLogistics
### Consultar Endereço
```php
$response = $rakutenLog->autocomplete("01415001");

// Parametro Opcional - Autocomplete Online
$response = $rakutenLog->autocomplete("01415001", true);
print_r($response);
```

### Criar Cálculo
```php
$code = "Product-Code";
$name = "TENIS NIKE";
$quantity = 1;
$cost = 50;
$width = 1;
$weight = 1;
$lenght = 1;
$height = 1;

$calculation = $rakutenLog->calculation();
$calculation->setDestinationZipcode("05001100")
    ->calculation->setPostageServiceCodes(array());
    ->calculation->addProducts(
        $code,
        $name,
        $quantity,
        $cost,
        $width,
        $weight,
        $lenght,
        $height
    );
$response = $rakutenLog->createCalculation($calculation);
print_r($response);
```

### Criar Lote
```php
$firstName = "Maria";
$lastName = "Da Silva";
$document = "12345678909";

$valueBaseICMS = 1.0;
$valueICMS = 0.50;
$valueBaseICMSST = 1.0;
$valueICMSST = 1;

$batch = $rakutenLog->batch();
$batch->setCalculationCode("fake-calculation-code")
    ->setPostageServiceCode("fake-postage-service-code")
    ->setOrder("1666000041", "1666000041", 200.83)
    ->setCustomer($firstName, $lastName, $document)
    ->setInvoice(
        "series",
        "number",
        "key",
        "cfop",
        "2019-01-01",
        $valueBaseICMS,
        $valueICMS,
        $valueBaseICMSST,
        $valueICMSST
    )
    ->setDeliveryAddress(
        $firstName,
        $lastName,
        "Av. Francisco Matarazzo",
        "1500",
        "Torre New York 6 Andar",
        "Água Branca",
        "São Paulo",
        "SP",
        "05001100",
        "maria@teste.com.br",
        "1144556677",
        "1155667788"
    );
$response = $rakutenLog->generateBatch($batch);

print_r($response);
```

### Detalhes do Pedido
```php
$response = $rakutenLog->orderDetail("order-id");

print_r($response);
```

## Suporte

Dúvidas ou deseja implementar  o serviço Rakuten Connector acesse [Rakuten Digital Commerce](https://digitalcommerce.rakuten.com.br)
