<?php 
include('navbar.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> <!-- Responsividade -->
    <title>SGC Contatos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card-1, .card-2, .card-3 {
            border-radius: 20px;
            min-height: 450px;
        }

        .card-1:hover, .card-2:hover, .card-3:hover {
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            transform: translateY(-5px)
            border: 0px !important;
            cursor: pointer;
        }

        .card-img-top {
            border-top-left-radius: 20px; /* Arredonda a parte superior esquerda da imagem */
            border-top-right-radius: 20px; /* Arredonda a parte superior direita da imagem */
        }

        .card-body {
            position: relative;
            z-index: 1;
            padding: 15px;
        }

        .btn-criar {
            border-radius: 20px;
            background: #1565c0;
            min-width: 120px;
            border: 0px !important;
            font-weight: 600;
        }

        .btn-contatos {
            border-radius: 20px;
            background: #006d77;
            min-width: 120px;
            border: 0px !important;
        }

        .btn-outros {
            border-radius: 20px;
            background: #fff3b0;
            color: #263238;
            min-width: 120px;
            border: 0px !important;
        }

        .btn-contatos:hover {
            border-radius: 20px;
            background: #086375;
            border: 2px solid #b2f7ef;
            min-width: 120px;
            font-weight: 600;
        }

        .btn-outros:hover {
            background: #fff3b0;
            color: #263238;
            min-width: 120px;
            border: 0px !important;
            font-weight: 600;
        }
    </style>

</head>
<body>
    <div class="container mt-5">
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card card-1">
                    <img src="./img/card1.png" class="card-img-top" alt="..." height="250px">
                    <div class="card-body">
                        <h5 class="card-title">Criar nova pessoa</h5>
                        <p class="card-text">
                            Crie uma nova pessoa e contatos.
                        </p>
                        <a href="create_person.php" class="btn btn-primary btn-criar shadow">Criar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-2 mb-4">
                    <img src="./img/card2.png" class="card-img-top" alt="..." height="250px">
                    <div class="card-body">
                        <h5 class="card-title">Listar Pessoas</h5>
                        <p class="card-text">Veja sua lista de contatos completa.</p>
                        <a href="list_people.php" class="btn btn-primary btn-contatos shadow">Meus contatos</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-3 mb-4">
                    <img src="./img/card3.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Suporte Balanceado</h5>
                        <p class="card-text">Suportes balanceados.</p>
                        <a href="suporte_balanceado.php" class="btn btn-primary btn-outros shadow">Suportes Balanceados</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
