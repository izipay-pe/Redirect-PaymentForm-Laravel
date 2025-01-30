<!DOCTYPE html>
<html>
<head>
  <title>Checkout</title>
  <link rel='stylesheet' href='css/style.css' />
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/journal/bootstrap.min.css"
      integrity="sha384-QDSPDoVOoSWz2ypaRUidLmLYl4RyoBWI44iA5agn6jHegBxZkNqgm2eHb6yZ5bYs" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
  <nav class="navbar bg-primary" style="background-color: #FF2D46!important;">
    <div class="container-fluid">
      <a href="/" class="navbar-brand mb-1"><img src="https://iziweb001b.s3.amazonaws.com/webresources/img/logo.png" width="80"></a>
    </div>
  </nav>
  <main>
  <div class="col-md-12">
      <div class="row">
        <div class="col-md-3"></div>
        <div class="center-column col-md-6">
          <section class="customer-details">
            <h2>Datos del pago</h2>
            <!-- Order ID -->
            <div class="form-group">
              <label for="orderId">Order-id</label>
              <input readonly class="form-control" value="<?= $parameters["vads_order_id"] ?>" />
            </div>

            <!-- Monto -->
            <div class="form-group">
              <label for="amount">Monto</label>
              <input readonly class="form-control" value="<?= number_format($parameters['vads_amount']/100 , 2) ?>" />
            </div>

            <!-- Moneda -->
            <div class="form-group">
              <label for="amount">Moneda</label>
              <input readonly class="form-control" value="<?= $parameters['vads_currency'] == 604?"PEN":"USD" ?>" />
            </div>
          </section>

          <!-- Formulario con los datos de pago -->
          <form class="from-checkout" action="https://secure.micuentaweb.pe/vads-payment/" method="post">
          <!-- Inputs generados dinámicamente -->
            <?php echo csrf_field(); ?>
              <?php $__currentLoopData = $parameters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>" >
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <button class="btn btn-primary" type="submit" name="pagar">Pagar</button>
          </form>
        </div>
        <div class="col-md-3"></div>
      </div>
    </div>
  </main>
</body>
<html><?php /**PATH C:\laragon\www\Redirect-PaymentForm-Laravel-main\resources\views/izipay/checkout.blade.php ENDPATH**/ ?>