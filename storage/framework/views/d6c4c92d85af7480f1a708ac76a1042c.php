<!DOCTYPE html>
<html>

<head>
  <title>Resultado de pago</title>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/journal/bootstrap.min.css"
  integrity="sha384-QDSPDoVOoSWz2ypaRUidLmLYl4RyoBWI44iA5agn6jHegBxZkNqgm2eHb6yZ5bYs" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel='stylesheet' href='css/style.css' />
</head>
<body>
  <nav class="navbar bg-primary" style="background-color: #FF2D46!important;">
    <div class="container-fluid">
        <a href="/" class="navbar-brand mb-1"><img src="https://iziweb001b.s3.amazonaws.com/webresources/img/logo.png" width="80"></a>
    </div>
  </nav>
<section class="container">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="center-column col-md-6">
      <section class="result-form">
        <h2>Resultado de pago:</h2>
        <hr>
        <p><strong>Estado: </strong><?= $data["vads_trans_status"] ?></p>
        <p><strong>Monto:
          </strong><?= $data["vads_currency"] == 604 ? "PEN": "USD" ?> <?= number_format($data['vads_amount'] / 100, 2)  ?></p>
        <p><strong>Order-id:</strong> <?= $data['vads_order_id']  ?></p>
        <hr>
        <details open>
          <summary>
            <h2>Respuesta recibida del servidor:</h2>
          </summary>
          <pre><?php echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
        </details>
        <hr>
        <form action="/" method="get">
          <button class="btn btn-primary">Volver a probar</button>
        </form>
      </section>
    </div>
    <div class="col-md-3"></div>
  </div>
</section>
</body>

</html><?php /**PATH C:\laragon\www\Redirect-PaymentForm-Laravel-main\resources\views/izipay/result.blade.php ENDPATH**/ ?>