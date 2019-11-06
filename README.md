<img src="https://gist.githubusercontent.com/alexsantossilva/a1bfa0a6e9e6592176f860210a226dfe/raw/374ed1819de58169d05482c8188d6edc8687c2e6/genpay.png" width="300" align="top>" />

# GenComm PHP SDK Client.
>

[![wercker status](https://app.wercker.com/status/0427e4e65bb1ad0ca4d2e5ed759d1743/m/master "wercker status")](https://app.wercker.com/project/byKey/0427e4e65bb1ad0ca4d2e5ed759d1743)

> O jeito mais simples e rápido de integrar o GenPay a sua aplicação PHP

**Instruções**

- [Instalação](#instalação)
- [Configurando a autenticação](#configurando-a-autenticação)
    - [Implementação do GenPay](#implementando-GenPay)
    - [Implementação do GenLog](#implementando-GenLog)
- [GenPay](#GenPay)
    - [Pedidos](#Pedidos)
        - [Criando Pedido no Boleto](#criando-pedido-no-boleto)
        - [Criando Pedido no Cartão de Crédito](#criando-pedido-no-cartão-de-crédito)
        - [Cancelando um Pedido](#cancelando-um-pedido)
        - [Estorno Total de um Pedido](#estorno-total-de-um-pedido)
        - [Estorno Parcial de um Pedido](#estorno-parcial-de-um-pedido)
        - [Consultas](#consulta)
            - [Verificar Credenciais](#verificar-credenciais)
            - [Juros Comprador](#juros-comprador)
- [GenLog](#GenLog)
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
composer require gencomm/gencomm-sdk-php
```

## Configurando a autenticação

```php
require 'vendor/autoload.php';

use GenComm\GenPay;
use GenComm\Enum\Environment;

$document = '77753821000123';
$apiKey = '546JK45NJ6K4N6456JKLN6464J5N';
$signature = '123IOU3OI2U1IIOU1OI3UIO23';
```

### Implementando GenPay
```php
$genPay = new GenPay($document, $apiKey, $signature, Environment::SANDBOX);
```

### Implementando GenLog
```php
$genLog = new GenLog($document, $apiKey, $signature, Environment::SANDBOX);
```

# GenPay
## Pedidos
### Criando pedido no boleto
Neste exemplo será criado um pedido.
```php
$order = $genPay
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

$customer = $genPay
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

$payment = $genPay
    ->asBillet()
    ->setAmount(200.0)
    ->setExpiresOn("3");
    
$response = $genPay->createOrder($order, $customer, $payment);
print_r($response);
```

### Criando pedido no cartão de crédito
Neste exemplo será criado um pedido.
```php
$order = $genPay
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

$customer = $genPay
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

$payment = $genPay
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

$response = $genPay->createOrder($order, $customer, $payment);
print_r($response);
```

### Cancelando um Pedido
Neste exemplo será cancelado um pedido.
```php
$response = $genPay->cancel("fake-charge-uuid", Requester::MERCHANTGenComm\Tests\Unit\Resource\GenPay\RefundTest, "Produto errado.");

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

$refund = $genPay->asRefund();

$refund->setReason("Comprou errado.")
    ->setRequester(Requester::MERCHANT)
    ->addPayment('fake-payment-id', 250, $bankAccount);

$response = $genPay->refund($refund, "fake-charge-uuid");

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

$refund = $genPay->asRefund();

$refund->setReason("Comprou errado.")
    ->setRequester(Requester::MERCHANT)
    ->addPayment('fake-payment-id', 50, $bankAccount);

$response = $genPay->refundPartial($refund, "fake-charge-uuid");

print_r($response);
```

## Consulta
### Juros Comprador

```php
$amount = 1000
$response = $genPay->checkout($amount);
print_r($response);
```

### Verificar Credenciais

```php
$response = $genPay->authorizationValidate();
print_r($response);
```

# GenLogistics
### Consultar Endereço
```php
$response = $genLog->autocomplete("01415001");

// Parametro Opcional - Autocomplete Online
$response = $genLog->autocomplete("01415001", true);
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

$calculation = $genLog->calculation();
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
$response = $genLog->createCalculation($calculation);
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

$batch = $genLog->batch();
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
$response = $genLog->generateBatch($batch);

print_r($response);
```

### Detalhes do Pedido
```php
$response = $genLog->orderDetail("order-id");

print_r($response);
```

## Suporte

Dúvidas ou deseja implementar  o serviço GenComm acesse [GenPay](https://www.gencomm.com.br/developers/)
