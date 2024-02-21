<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Resultado</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #ff2d46;
      }
    </style>
  </head>
  <body>
    <style>
      .btn-izi {
          background-color: #00a09d;
      }
      .btn-izi:hover{
          background-color: #08b9b6;
      }
  </style>
    
    <nav class="col d-flex justify-content-center">
        <a href="/">
            <img
            src="https://iziweb001b.s3.amazonaws.com/webresources/img/logo.png"
            width="300"
            alt=""
        /></a>
    </nav>
    
    <div class="col mx-auto d-flex flex-wrap me-5 card p-5">
        <h4 class="mb-1 text-center">Estado de la transacción: <b>{{ $data['vads_trans_status'] }}</b></h4>
        <hr class="w-100 mb-3" />
        <p>N° de pedido: <b>{{ $data['order'] }}</b> </p>
        <p>Email: <b>{{ $data['vads_cust_email'] }}</b></p>
        <p>Nombres: <b>{{ $data['vads_cust_first_name'] }}</b></p>
        <p>Apellidos: <b>{{ $data['vads_cust_last_name'] }}</b></p>
        <p>Monto: <b>S/{{ $amount }}</b></p>
        <p class="alert alert-danger">Modo: <b>{{ $data['vads_ctx_mode'] }}</b></p>
    </div>
    

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
