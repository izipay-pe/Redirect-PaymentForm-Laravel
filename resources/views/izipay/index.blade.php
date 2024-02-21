<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
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

        .btn-izi:hover {
            background-color: #08b9b6;
        }

        .nav-bar {
            position: absolute;
            top: 10%;
        }
    </style>

    <nav class="nav-bar">
        <a href="/">
            <img src="https://iziweb001b.s3.amazonaws.com/webresources/img/logo.png" width="150"
                alt="" /></a>
    </nav>

    <div class="card p-4">
        <h4 class="mb-1">Formulario en redirección</h4>
        <hr class="w-100 mb-4">
        <form action="{{url('/confirm')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label ">Email:</label>
                <input type="Email" class="form-control" id="email" name="email" required />
            </div>
            <div class="mb-3">
                <label for="firstname" class="form-label ">Nombres:</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required />
            </div>
            <div class="mb-3">
                <label for="firstname" class="form-label ">Apellidos:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required />
            </div>
            <div class="mb-3">
                <label for="order" class="form-label ">N° Orden (Pedido):</label>
                <input type="text" class="form-control" id="order" value="{{ $order }}" name="order"
                    required />
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label ">Monto:</label>
                <input type="number" class="form-control" id="amount" name="amount" required />
            </div>

            <input class="btn btn-izi w-50 mx-auto text-white mt-2" type="submit" value="Pagar" />

        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
