<?php //Aqui poderiamos ter deixado o código tanto o "header" quanto o "footer" neste index mesmo, mas para facilitar a leitura e poder reutilizar em outras páginas eu salvei o código deles na pasta templates e então eu importo eles facilmente usando o "include_once"
// HEADER AQUI
    include_once("templates/header.php");
    
//Aqui conectei o arquivo BACKEND pizza.php com o index
//OBS: Ao fazer esse include de backend pode ser que dê algum erro ao abrir o arquivo - se não der nada, quer dizer que deu certo a conexão
    include_once("process/pizza.php");
?>


<!-- Banner de título com imagem de fundo --> 
<div id="main-banner">
    <h1>Faça seu pedido</h1>
</div>


<!-- Container de tudo --> 
<div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12"> <!-- Elemento de grid - 12 colunas - facilitado pelo Bootstrap --> 
                <h2>Monte a pizza como desejar:</h2>
                <form action="process/pizza.php" method="POST" id="pizza-form">



                <!-- Escolha de borda --> 
                    <div class="form-group">
                        <label for="borda">Borda:</label>
                        <select name="borda" id="borda" class="form-control">
                            <option value="">Selecione a borda da pizza:</option>


                        <!-- CONEXÃO COM BD DE BORDAS -->
                        <?php foreach ($bordas as $borda): ?>

                            <option value="<?= $borda['id'] ?>"><?= $borda["tipo"] ?></option>

                        <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- 
                        Neste código ACIMA revisado:

                        1. <div class="form-group">: Este elemento <div> usa a classe CSS "form-group" do Bootstrap para estilizar o grupo de elementos do formulário.

                        2. <label for="borda">Borda:</label>: O rótulo está associado ao campo de seleção com o atributo for e é usado para descrever o campo.

                        3. <select name="borda" id="borda" class="form-control">: O elemento <select> usa a classe "form-control" do Bootstrap para aplicar estilos de formulário consistentes.

                        4. <option value="">Selecione a borda da pizza:</option>: Esta é a primeira opção na lista suspensa e é usada como uma instrução para o usuário selecionar uma opção.

                        CONEXÃO COM O BANCO DE DADOS COM O LOOP FOREACH de forma mais detalhada:

                        1. <php foreach ($bordas as $borda): ?>: Aqui, você inicia um loop foreach em PHP. O objetivo desse loop é iterar através de cada elemento no array $bordas. Isso significa que o código dentro do loop será executado uma vez para cada borda armazenada em $bordas. Dentro do loop, cada borda é referenciada como $borda.

                        2. <option value="$borda['id'] ?>"> $borda["tipo"] ?></option>: Dentro do loop, você está criando um elemento <option> para a lista suspensa.

                            value=" $borda['id'] ?>": Aqui, você define o atributo value do elemento <option> com o valor da chave "id" da borda atual. Isso significa que, quando o usuário selecionar uma opção, o valor associado será o ID da borda.

                            <$borda["tipo"] ?>: Dentro do elemento <option>, você insere o texto que será exibido na lista suspensa. O texto é obtido da chave "tipo" da borda atual, então o usuário verá o tipo da borda, como "Borda Fina", "Borda Recheada", etc.

                        3. <endforeach; ?>: Esta linha fecha o loop foreach, indicando que não há mais código a ser executado dentro do loop.

                        Em resumo, o loop foreach percorre todas as bordas no array $bordas e cria uma opção na lista suspensa para cada borda. Cada opção tem um valor associado (o ID da borda) e um texto exibido (o tipo da borda) que é mostrado ao usuário. Isso permite que o usuário selecione a borda desejada ao fazer um pedido no sistema da pizzaria.

                        A LÓGICA É A MESMA PARA MASSAS E SABORES ABAIXO
                    -->


                
                    <!-- Escolha de massa --> 
                    <div class="form-group">
                        <label for="massa">Massa:</label>
                        <select name="massa" id="massa" class="form-control">
                        <option value="">Selecione a massa da pizza:</option>
                        
                        <!-- CONEXÃO COM BD DE MASSAS -->
                        <?php foreach ($massas as $massa): ?>

                            <option value="<?= $massa['id'] ?>"><?= $massa["tipo"] ?></option>

                        <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- Escolha de sabores --> 
                    <!-- Esta é diferente dos outros - pois podemos escolher mais de uma - então temos o atributo "multiple" bem como sinal de [] no "name" e não há necessidade da "Option"--> 
                    <div class="form-group"> 
                        <label for="sabores">Sabores:</label>
                        <select multiple name="sabores[]" id="sabores" class="form-control">

                        <!-- CONEXÃO COM BD DE MASSAS -->
                        <?php foreach ($sabores as $sabor): ?>

                            <option value="<?= $sabor['id'] ?>"><?= $sabor["tipo"] ?></option>

                        <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- Botão de Submit --> 
                    <div class="form-group"> 
                        <input type="submit" class="btn btn-primary" value="Fazer Pedido!">
                    </div>
                </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php // FOOTER
    include_once ("templates/footer.php");
?>