<?php

include_once("templates/header.php");
include_once("process/orders.php");

?>



<link rel="stylesheet" href="css/style_dashboard.css">


<div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Gerenciar Pedidos:</h2>
            </div>
            <div class="col-md-12 table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"> <span>Pedido</span> # </th>
                            <th scope="col">Borda</th>
                            <th scope="col">Massa</th>
                            <th scope="col">Sabores</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach($pizzas as $pizza): ?>

                            <tr> <!-- PRINTANDO ID, BORDA e MASSA DO BACKEND pizza.php e orders.php-->
                                <td><?= $pizza["id"] ?></td>
                                <td><?= $pizza["borda"] ?></td>
                                <td><?= $pizza["massa"] ?></td>
                                <td>
                                    <ul>
                                        <?php foreach($pizza["sabores"] as $sabor): ?>

                                            <li><?= $sabor ?></li>
                                        
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td>
                                    <form action="process/order.php" method="POST" class="form-group update-form">
                                        <input type="hidden" name="type" value="update">
                                        <input type="hidden" name="id" value="<?= $pizza["id"]?>">
                                        <select name="status" class="form-control status-input">
                                            <!-- PRINTANDO O STATUS (CONDICAO) DO BACKEND pizza.php e orders.php-->
                                            <?php foreach ($condicao as $c):?>
                                                    <!-- Aqui nós temos o print da condição dentro deste foreach e este ECHO ali em baixo é um "if" ternário de php para nos entregar de fato qual status (condicao) é a atual do pedido mesmo -->
                                                <option value="<?= $c["id"]?>" <?php echo ($c["id"] == $pizza["condicao"]) ? "selected" : "";  ?> > <?= $c["tipo"]?> </option>

                                            <?php endforeach?>

                                        </select>
                                        <button type="submit" class="update-btn">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="process/orders.php" method="POST">
                                        <input type="hidden" name="type" value="delete">
                                        <input type="hidden" name="id" value="<?= $pizza["id"]?>">
                                        <button type="submit" class="delete-btn">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php 

include_once("templates/footer.php")

?>