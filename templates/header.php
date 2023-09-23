<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faça seu Pedido!</title>

    <!-- Bootstrap aqui -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Font Awesome aqui - para pegar link: https://cdnjs.com/libraries/font-awesome --> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS do projeto-->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
 

<header>

    <nav class="navbar navbar-expand-lg">
        <a href="index.php" class="navbar-brand"> 
            <!-- Imagem de pizza que é link para o index -->
            <img src="img/pizza.svg" alt="Pizzaria do João" id="brand-logo">

        </a>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav"></ul>

                <li class="nav-item active">

                    <a href="index.php" class="nav-link">
                        Peça sua pizza!
                    </a>
                </li>

        </div>

    </nav>
</header>

<div class="alert alert-sucess">
    <p>Pedido realizado com sucesso!</p>
</div>