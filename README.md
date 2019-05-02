<img src="https://gist.githubusercontent.com/alexsantossilva/d714e42d00e8bbaa5bece16e88f4c87f/raw/11cb121c10abcf5cd1a2eaadc9bdf14970ee4900/rakuten-connector-logo.png" align="top>" />

# Rakuten PHP SDK Client.
>

[![wercker status](https://app.wercker.com/status/0427e4e65bb1ad0ca4d2e5ed759d1743/m/master "wercker status")](https://app.wercker.com/project/byKey/0427e4e65bb1ad0ca4d2e5ed759d1743)

> O jeito mais simples e rápido de integrar o RakutenPay a sua aplicação PHP

**Instruções**

- [Instalação](#instalação)
- [Configurando a autenticação](#configurando-a-autenticação)
- [Exemplos de Uso](#pedidos):
    - [Pedidos](#pedidos)
        - [Criando Pedido no Boleto](#criando-pedido-no-boleto)
        - [Consultas](#consulta)
            - [Verificar Credenciais](#verificar-credenciais)
            - [Juros Comprador](#juros-comprador)
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

$rakutenPay = new RakutenPay($document, $apiKey, $signature, Environment::SANDBOX);
```

## Pedidos
### Criando pedido no boleto
Neste exemplo será criado um pedido.
```php
$order = $rakutenPay
            ->order()
            ->setAmount(200.0)
            ->setCurrency("BRL")
            ->setFingerprint("c9a3374e5b564eca2e734a81c01f0a54-fodm1ud7nrejul9x1d7")
            ->setWebhookUrl("http://intregation.test/sdk/")
            ->setReference($reference)
            ->setItemsAmount(200.0)
            ->setPayerIp("127.0.0.1")
            ->setTaxesAmount(0)
            ->setShippingAmount(0)
            ->setDiscountAmount(0)
            ->addItem(
                $reference,
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
            ->addAPhones("others",
                "999999998",
                "55",
                "11",
                "shipping")
            ->addAPhones("others",
                "999999998",
                "55",
                "11",
                "billing");

$payment = $rakutenPay
    ->asBillet()
    ->setAmount(200.0)
    ->setExpiresOn("3");
    
$response = $rakutenPay->createOrder($order, $customer, $payment);
print_r($reponse);
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

## Suporte

Dúvidas ou deseja implementar  o serviço Rakuten Connector acesse [Rakuten Digital Commerce](https://digitalcommerce.rakuten.com.br)
