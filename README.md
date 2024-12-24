<p align="center">
  <img src="https://github.com/izipay-pe/Imagenes/blob/main/logos_izipay/logo-izipay-banner-1140x100.png?raw=true" alt="Formulario" width=100%/>
</p>

# Redirect-PaymentForm-Laravel

## Índice

➡️ [1. Introducción](https://github.com/izipay-pe/Redirect-PaymentForm-Php/tree/main?tab=readme-ov-file#%EF%B8%8F-1-introducci%C3%B3n)  
🔑 [2. Requisitos previos](https://github.com/izipay-pe/Redirect-PaymentForm-Php/tree/main?tab=readme-ov-file#-2-requisitos-previos)  
🚀 [3. Ejecutar ejemplo](https://github.com/izipay-pe/Redirect-PaymentForm-Php/tree/main?tab=readme-ov-file#-3-ejecutar-ejemplo)  
🔗 [4. Pasos de integración](https://github.com/izipay-pe/Redirect-PaymentForm-Php/tree/main?tab=readme-ov-file#4-pasos-de-integraci%C3%B3n)  
💻 [4.1. Desplegar pasarela](https://github.com/izipay-pe/Redirect-PaymentForm-Php/tree/main?tab=readme-ov-file#41-desplegar-pasarela)  
💳 [4.2. Analizar resultado de pago](https://github.com/izipay-pe/Redirect-PaymentForm-Php/tree/main?tab=readme-ov-file#42-analizar-resultado-del-pago)  
📡 [4.3. Pase a producción](https://github.com/izipay-pe/Redirect-PaymentForm-Php/tree/main?tab=readme-ov-file#43pase-a-producci%C3%B3n)  
🎨 [5. Personalización](https://github.com/izipay-pe/Redirect-PaymentForm-Php/tree/main?tab=readme-ov-file#-5-personalizaci%C3%B3n)  
📚 [6. Consideraciones](https://github.com/izipay-pe/Redirect-PaymentForm-Php/tree/main?tab=readme-ov-file#-6-consideraciones)

## ➡️ 1. Introducción

En este manual podrás encontrar una guía paso a paso para configurar un proyecto de **[Laravel]** con la pasarela de pagos de IZIPAY. Te proporcionaremos instrucciones detalladas y credenciales de prueba para la instalación y configuración del proyecto, permitiéndote trabajar y experimentar de manera segura en tu propio entorno local.
Este manual está diseñado para ayudarte a comprender el flujo de la integración de la pasarela para ayudarte a aprovechar al máximo tu proyecto y facilitar tu experiencia de desarrollo.


<p align="center">
  <img src="https://github.com/izipay-pe/Imagenes/blob/main/formulario_redireccion/Imagen-Formulario-Redireccion.png?raw=true" alt="Formulario" width="750"/>
</p>

## 🔑 2. Requisitos Previos

- Comprender el flujo de comunicación de la pasarela. [Información Aquí](https://secure.micuentaweb.pe/doc/es-PE/rest/V4.0/javascript/guide/start.html)
- Extraer credenciales del Back Office Vendedor. [Guía Aquí](https://github.com/izipay-pe/obtener-credenciales-de-conexion)
- Para este proyecto utilizamos la herramienta Visual Studio Code.
- Servidor Web
- PHP 7.0 o superior
> [!NOTE]
> Tener en cuenta que, para que el desarrollo de tu proyecto, eres libre de emplear tus herramientas preferidas.

## 🚀 3. Ejecutar ejemplo

### Instalar Xampp u otro servidor local compatible con php

Xampp, servidor web local multiplataforma que contiene los intérpretes para los lenguajes de script de php. Para instalarlo:

1. Dirigirse a la página web de [xampp](https://www.apachefriends.org/es/index.html)
2. Descargarlo e instalarlo.
3. Inicia los servicios de Apache desde el panel de control de XAMPP.


### Clonar el proyecto
```sh
git clone https://github.com/izipay-pe/Redirect-PaymentForm-Laravel.git
``` 

### Datos de conexión 

Reemplace **[CHANGE_ME]** con sus credenciales extraídas desde el Back Office Vendedor, revisar [Requisitos previos](https://github.com/izipay-pe/Redirect-PaymentForm-Php/tree/main?tab=readme-ov-file#-2-requisitos-previos).

- Renombrar el archivo `./example.env` a `./.env`. Editar el archivo  en la ruta raiz del proyecto:
```php
  SHOP_ID=**[CHANGE_ME]**
  CLAVE=**[CHANGE_ME]**
  MODE=TEST
  URL_PAYMENT=https://secure.micuentaweb.pe/vads-payment/
```

### Ejecutar proyecto

1. Mueve el proyecto descargado a la carpeta de instalación de proyectos de xammp `c://xampp/htdocs/[proyecto_laravel]`

2. Inicia los servicios de Apache y MySQL desde el panel de control de XAMPP.
Acceder al Proyecto:

3. Abre tu navegador e ingresa a la siguiente url con el nombre de la carpeta del proyecto y realiza una compra.
```sh
http://localhost/[carpeta_laravel]/public
```

## 🔗4. Pasos de integración

<p align="center">
  <img src="https://i.postimg.cc/pT6SRjxZ/3-pasos.png" alt="Formulario" />
</p>

## 💻4.1. Desplegar pasarela
### Autentificación
Extraer las claves de `identificador de tienda` y `clave de test o producción` del Backoffice Vendedor y agregarlo en los parámetros `vads_site_id` y en la función `getSignature($datos, KEY)`. Este último permite calcular la firma transmitida de los datos de pago. Podrás encontrarlo en el archivo `./app/Http/Controllers/IzipayController.php`.
```php
  $paymentConfig = $this->initForm();
  ...
  $paymentConfig["vads_site_id"] = env('SHOP_ID');
  $paymentConfig["vads_order_id"] = $request->input("orderId");
  ...
  // Generar el signature
  $paymentConfig["signature"] = $this->getSignature($paymentConfig, env('CLAVE'));
  return view('izipay.checkout', ['data' => $paymentConfig])
```
ℹ️ Para más información: [Autentificación](https://secure.micuentaweb.pe/doc/es-PE/form-payment/quick-start-guide/identificarse-durante-los-intercambios.html)
### Visualizar formulario
Para desplegar la pasarela, crea un formulario **HTML** de tipo **POST** con el valor del **ACTION** con la url de servidor de la pasarela de pago y agregale los parámetros de pago como etiquetas `<input type="hidden" name="..." value="...">`. Como se muestra el ejemplo en la ruta del archivo `./app/Http/Controllers/IzipayController.php`. 

```php
// Formulario con los datos de pago
<form class="from-checkout" action="https://secure.micuentaweb.pe/vads-payment/" method="post">
  @csrf
    @foreach ($data as $key => $value )
      <input type="hidden" name="{{$key}}" value="{{$value}}" >
    @endforeach
  <button class="btn btn-checkout" type="submit" name="pagar">Pagar</button>
</form>
```
ℹ️ Para más información: [Formulario de pago en POST](https://secure.micuentaweb.pe/doc/es-PE/form-payment/quick-start-guide/enviar-un-formulario-de-pago-en-post.html)

## 💳4.2. Analizar resultado del pago

### Validación de firma
Se configura la función `getSignature($params, $key)` que generará la firma de los datos de la respuesta de pago. Podrás encontrarlo en el archivo `./app/Http/Controllers/IzipayController.php`.

```php
// Función para generar la firma
function getSignature($params, $key)
{
  $content_signature = "";
  // Ordenar los campos alfabéticamente
  ksort($params);
  foreach ($params as $name => $value) {
    // Recuperación de los campos vads_
    if (substr($name, 0, 5) == 'vads_') {
      // Concatenación con el separador "+"
      $content_signature .=  $value . "+";
    }
  }
  // Añadir la clave al final del string
  $content_signature .= $keys;
  // Codificación base64 del string cifrada con el algoritmo HMAC-SHA-256
  $signature = base64_encode(hash_hmac('sha256', mb_convert_encoding($content_signature, "UTF-8"), $keys, true));
  return $signature;
}
```

Se valida que la firma recibida es correcta en el archivo `./app/Http/Controllers/IzipayController.php`.

```php
public function result(Request $request){
  ...
  // comparar si la firma es válida
  if( $this->getSignature($data, env('CLAVE'))  !== $data["signature"]) return new Exception("Invalid signature");
  
  return view('izipay.result', compact("data"));
}
```
En caso que la validación sea exitosa, se puede extraer los datos del resultado de pago a través de la variable global de php `$_POST` y mostrarlos. Como se muestra en el archivo `./resources/views/izipay/result.blade.php`.

```php
<p><strong>Estado: </strong><?= $data["vads_trans_status"] ?></p>
```
ℹ️ Para más información: [Analizar resultado del pago](https://secure.micuentaweb.pe/doc/es-PE/form-payment/quick-start-guide/recuperar-los-datos-devueltos-en-la-respuesta.html)

### IPN
La IPN es una notificación de servidor a servidor (servidor de Izipay hacia el servidor del comercio) que facilita información en tiempo real y de manera automática cuando se produce un evento, por ejemplo, al registrar una transacción.


Se realiza la verificación de la firma utilizando la función `if($this->getSignature($request->input(), env('CLAVE')))` y se devuelve al servidor de izipay un mensaje confirmando el estado del pago. Podrás encontrarlo en el archivo `./app/Http/Controllers/IzipayController.php`.

```php
 public function notificationIpn(Request $request){
  ...
  // Generar firma
  $signature = $this->getSignature($request->input(), env('CLAVE'));
  // verificación de firma
  if ($request->input('signature') !== $signature) {
      return response("Signature Invalid", 200);
  }

  return response("Transaccion is {$request->input('vads_trans_status')}!", 200);
}
```

La IPN debe ir configurada en el Backoffice Vendedor, en `Configuración -> Reglas de notificación -> URL de notificación al final del pago`

<p align="center">
  <img src="https://github.com/izipay-pe/Imagenes/blob/main/formulario_redireccion/Url-Notificacion-Redireccion.png?raw=true" alt="Url de notificacion en redireccion" width="650" />
</p>

ℹ️ Para más información: [Analizar IPN](https://secure.micuentaweb.pe/doc/es-PE/form-payment/quick-start-guide/implementar-la-ipn.html)

### Transacción de prueba

Antes de poner en marcha su pasarela de pago en un entorno de producción, es esencial realizar pruebas para garantizar su correcto funcionamiento. 

Puede intentar realizar una transacción utilizando una tarjeta de prueba (en la parte inferior del formulario).

<p align="center">
  <img src="https://github.com/izipay-pe/Imagenes/blob/main/formulario_redireccion/Imagen-Formulario-Redireccion-testcard.png?raw=true" alt="Tarjetas de prueba" width="450"/>
</p>

- También puede encontrar tarjetas de prueba en el siguiente enlace. [Tarjetas de prueba](https://secure.micuentaweb.pe/doc/es-PE/rest/V4.0/api/kb/test_cards.html)

## 📡4.3.Pase a producción

Reemplace **[CHANGE_ME]** con sus credenciales de PRODUCCIÓN extraídas desde el Back Office Vendedor, revisar [Requisitos Previos](https://github.com/izipay-pe/Redirect-PaymentForm-Php/tree/main?tab=readme-ov-file#-2-requisitos-previos).

- Editar el archivo `./.env` en la ruta raiz del proyecto:
```php
SHOP_ID=**[CHANGE_ME]**
CLAVE=**[CHANGE_ME]**
MODE=TEST
URL_PAYMENT=https://secure.micuentaweb.pe/vads-payment/
```

## 🎨 5. Personalización

Si deseas aplicar cambios específicos en la apariencia de la página de pago, puedes lograrlo mediante las opciones de personalización en el Backoffice. En este enlace [Personalización - Página de pago](https://youtu.be/hy877zTjpS0?si=TgSeoqw7qiaQDV25) podrá encontrar un video para guiarlo en la personalización.

<p align="center">
  <img src="https://github.com/izipay-pe/Imagenes/blob/main/formulario_redireccion/Personalizacion-formulario-redireccion.png?raw=true" alt="Personalizacion de formulario en redireccion"  width="750" />
</p>

## 📚 6. Consideraciones

Para obtener más información, echa un vistazo a:

- [Formulario incrustado: prueba rápida](https://secure.micuentaweb.pe/doc/es-PE/rest/V4.0/javascript/quick_start_js.html)
- [Primeros pasos: pago simple](https://secure.micuentaweb.pe/doc/es-PE/rest/V4.0/javascript/guide/start.html)
- [Servicios web - referencia de la API REST](https://secure.micuentaweb.pe/doc/es-PE/rest/V4.0/api/reference.html)