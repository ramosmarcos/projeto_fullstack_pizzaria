<?php //Aqui poderiamos ter deixado o código tanto o "header" quanto o "footer" neste index mesmo, mas para facilitar a leitura e poder reutilizar em outras páginas eu salvei o código deles na pasta templates e então eu importo eles facilmente usando o "include_once"
    include_once ("templates/header.php");
?>

<!-- Banner de título com imagem de fundo --> 
<div id="main-banner">
    <h1>Faça o seu pedido!</h1>
</div>

<!-- Container de tudo --> 
<div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12"> <!-- Elemento de grid - 12 colunas - facilitado pelo Bootstrap --> 
                <h2>Monte a pizza como desejar:</h2>
                <form action="process/pizza.php" method="POST" id="pizza-form"></form>

                <!-- Escolha de borda --> 
                    <div class="form-group">
                        <label for="borda">Borda:</label></div>
                        <select name="borda" id="borda" class="form-control">
                            <option value="">Selecione a borda da pizza:</option>
                        </select>
                    </div>

                    <!-- Escolha de massa --> 
                    <div class="form-group">
                                <label for="massa">Massa:</label></div>
                                <select name="massa" id="massa" class="form-control">
                                    <option value="">Selecione a massa da pizza:</option>
                                </select>
                    </div>

                    <!-- Escolha de sabores --> 
                    <!-- Esta é diferente dos outros - pois podemos escolher mais de uma - então temos o atributo "multiple" bem como sinal de [] no "name" e não há necessidade da "Option"--> 
                    <div class="form-group"> 
                                <label for="sabores">Sabores:</label></div>
                                <select multiple name="sabores[]" id="sabores" class="form-control">
                                </select>
                    </div>

                    <!-- Botão de Submit --> 
                    <div class="form-group"> 
                        <input type="submit" class="btn btn-primary" value="Fazer Pedido!">
                    </div>

        </div>
    </div>
</div>

<?php // FOOTER
    include_once ("templates/footer.php");
?>