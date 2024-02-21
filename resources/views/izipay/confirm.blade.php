<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Confirmar</title>
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
  
    <div class="col mx-auto d-flex flex-wrap align-items-center me-5 card p-4">
        <h3 class="mb-1  text-center">Confirmar Datos</h3>
        <hr class="w-100 mb-3 " />
        <form class="d-flex flex-wrap justify-content-between" action="{{ $URL }}" method="POST">
            @foreach($data as $key => $value)
            <div class="mb-3 d-flex flex-wrap" style="width: 32%;">
                <label for="{{ $key }}" class="form-label w-100">{{ $key }}</label>
                <input type="text" class="form-control w-100" id="{{ $key }}" name="{{ $key }}" value="{{ $value }}" required />
            </div>
            @endforeach
            <input class="btn btn-lg btn-izi w-100 text-white mt-2 " type="submit" value="Validar" />
        </form>

    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
