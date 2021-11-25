<?php
session_start();
include_once("conexao.php");
?>

<!Doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>CRUD - Listar</title>
    </head>
    <body>
        <a href="cad_usuario.php">Cadastrar</a><br>
        <a href="index.php">Listar</a><br>
        <h1>Listar usuário</h1>
        <?php
            if(isset($_SESSION['msg'])){    
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }

            //receber o num da pagina
            $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);

            $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
            
            //setar qtd itens por pagina
            $qtd_resultados_pagina = 3;

            //calcualr inicio da visualização
            $inicio = ($qtd_resultados_pagina * $pagina) - $qtd_resultados_pagina;


            $usuarios = "SELECT * FROM usuarios LIMIT $inicio, $qtd_resultados_pagina";
            $lista_usuarios = mysqli_query($conn, $usuarios);
            while($row_usuario = mysqli_fetch_assoc($lista_usuarios)){
                echo "ID: " . $row_usuario['id'] . "<br>";
                echo "Nome: " . $row_usuario['nome'] . "<br>";
                echo "E-mail: " . $row_usuario['email'] . "<br>";
                echo "<a href='edit_usuario.php?id=" . $row_usuario['id'] . "'>Editar</a><br>";
                echo "<a href='proc_apagar_usuario.php?id=" . $row_usuario['id'] . "'>Apagar</a><br><hr><br>";
            }

            //Paginação - Somar a quantidade de usuarios
            $resul_pg = "SELECT COUNT(id) AS num_result FROM usuarios";
            $resultado_pg = mysqli_query($conn, $resul_pg);
            $row_pg = mysqli_fetch_assoc($resultado_pg);
            //echo $row_pg['num_result'];

            $qtd_pg = ceil($row_pg['num_result'] / $qtd_resultados_pagina);

            //limitar os links antes e depois
            $max_links = 2;
            echo "<a href='index.php?pagina=1'>Primeira<a/> ";
            
            for($pagina_ant = $pagina - $max_links; $pagina_ant <=  $pagina - 1; $pagina_ant++){
                if($pagina_ant >= 1) {
                    echo "<a href='index.php?pagina=$pagina_ant'>$pagina_ant<a/> ";
                }
            }
            
            echo "$pagina ";

            for($pagina_seguinte = $pagina + 1; $pagina_seguinte <=  $pagina + $max_links; $pagina_seguinte++){
                if($pagina_seguinte <= $qtd_pg) {
                    echo "<a href='index.php?pagina=$pagina_seguinte'>$pagina_seguinte<a/> ";
                }
            }
            
            echo "<a href='index.php?pagina=$qtd_pg'>Última<a/>";
        ?>
        
    </body>

</html>