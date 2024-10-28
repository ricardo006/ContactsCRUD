
  <nav class="navbar navbar-expand-lg navbar-custom">
    <a class="navbar-brand text-white" href="index.php">SGC</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php">Página Inicial</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="create_person.php">Criar Nova Pessoa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="list_people.php">Listar Pessoas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="suporte_balanceado.php">Suporte Balanceado</a>
            </li>
        </ul>
    </div>
</nav>

<style>
    .navbar-custom {
        background: linear-gradient(to right, #9600ff, #8c07dd, #9600ff);
        height: 70px;
        margin: 10px;
        border-radius: 40px;
    }

    .navbar-collapse {
        justify-content: center;
    }

    .navbar-collapse ul {
        border-radius: 40px;
        display: flex;
        vertical-align: middle;
        opacity: 0.9;
        background: #3c096c;
    }

    .nav-link {
        padding: 10px 15px;
        color: #fff;
        font-weight: 400;
        opacity: 0.9;
        border: 1px solid transparent;
        border-radius: 40px;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .nav-link:hover, .nav-link:focus, .nav-link:active {
        opacity: 1;
        background-color: rgba(255, 255, 255, 0.2);
        border-color: #e1d8f7;
        font-weight: 600;
        outline: none;
    }
</style>
