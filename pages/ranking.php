<?php
require './utils/utils.php';
session_start();
// Conexão com o banco de dados
require '../connection/conn.php';

try {
    // Conectar ao banco
    $conn = new mysqli($servername, $username, $password, $dbaccount);
} catch (mysqli_sql_exception $e) {
    // captura o erro e lida com ele
    $_SESSION['error'] = "Erro na conexão com o banco de dados: " . $e->getMessage();
    http_response_code(500);
    header('Location: status.php');
    // error_log("Erro na conexão com o banco de dados: " . $e->getMessage());
    // echo "Erro ao conectar ao banco de dados. Tente novamente mais tarde.";
    unset($_SESSION['error']);
}

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbplayer", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}
//Definindo Variáveis de Paginação
$por_pagina = 10; // Número de itens por página
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina > 1) ? ($pagina * $por_pagina) - $por_pagina : 0;

//SQL
$sql = "SELECT p.job, p.name, p.level, p.exp, pi.empire
FROM $dbplayer.player AS p
INNER JOIN $dbplayer.player_index AS pi ON p.account_id = pi.id
WHERE p.name NOT IN (SELECT mName FROM $dbcommon.gmlist)
ORDER BY p.level DESC, p.exp ASC
LIMIT :inicio, :por_pagina";


//Consulta ao Banco de Dados
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
$stmt->bindValue(':por_pagina', $por_pagina, PDO::PARAM_INT);
$stmt->execute();
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Contando o Total de Itens
$total = $pdo->query("SELECT COUNT(*) FROM $dbplayer.player")->fetchColumn();
$paginas = ceil($total / $por_pagina);

$offset = ($pagina - 1) * $por_pagina;


?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Metin2</title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="../index.php" class="navbar-brand"><img src="../assets/metin2.png" class="img-fluid ms-1" alt="metin2"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse responsive" id="navbarText">
      <div class="links-navegator">
        <ul class="navbar-nav" id="mainNav">
          <li class="nav-item">
            <a class="nav-link" href="../index.php"><i class="bi bi-house-door"></i>Início</a>
          </li>
          <?php
            if (!$_SESSION['user']) {          
              echo '<li class="nav-item">';
              echo '<a class="nav-link" href="register.php"><i class="bi bi-person-plus"></i>Cadastrar</a>';
              echo '</li>';
            }
          ?>             
          <li class="nav-item">
            <a class="nav-link" href="download.php"><i class="bi bi-cloud-arrow-down"></i>Download</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="ranking.php"><i class="bi bi-trophy"></i>Ranking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="rules.php"><i class="bi bi-book"></i>Regras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="status.php"><i class="bi bi-info-circle"></i>Status</a>
          </li>
        </ul>
      </div>
      <div class="logar">
        <ul class="navbar-nav">
          <li class="nav-item">
            <?php
            if (!$_SESSION['user']) {
              echo '<a class="btn btn-primary me-2" href="login.php">';
              echo '<i class="bi bi-box-arrow-in-right me-1"></i>';
              echo 'Entrar';
              echo '</a>';
            }
            ?>
          </li>
        </ul>
        <?php
        avatar($_SESSION['user'], $avatarBackgroundColor, '../index.php');
        ?>
      </div>
    </div>
  </nav>
    <main>
        <div class="content">
            <div class="container">
                <h2 class="text text-primary">Ranking de Personagens</h2>
                <table class="table table-striped table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Classe</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Nível</th>
                            <th scope="col">Exp</th>
                            <th scope="col">Reino</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        // Saída dos dados de cada linha
                        foreach ($players as $player => $row) {
                            $position = $offset + $player + 1;
                            echo "<tr>";
                            echo "<th scop='row'>" . $position . "</th>";
                            echo "<td>" . pgClass($row['job']) . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["level"] . "</td>";
                            echo "<td>" . $row["exp"] . "</td>";
                            echo "<td>" . pgKingdom($row["empire"]) . "</td>";
                            echo "</tr>";
                        }


                        // Fecha a conexão
                        $conn->close();
                        ?>
                    </tbody>
                </table>
                <?php
                $total_paginas = ceil($total / $por_pagina);
                $limite = 2; // Número de páginas a mostrar antes e depois da página atual
                echo '<div class="container">';
                echo '<div class="pagination">';

                for ($i = 1; $i <= $total_paginas; $i++) {
                    // Se estamos na primeira página ou na última, sempre mostramos
                    if ($i == 1 || $i == $total_paginas) {
                        echo ($i == $pagina) ? "<strong class='page-link active'>$i</strong> " : "<a class='page-link' href='?pagina=$i'>$i</a> ";
                    }
                    // Mostra páginas vizinhas à página atual
                    elseif ($i >= $pagina - $limite && $i <= $pagina + $limite) {
                        echo ($i == $pagina) ? "<strong class='page-link active'>$i</strong> " : "<a class='page-link' href='?pagina=$i'>$i</a> ";
                    }
                    // Adiciona os três pontinhos
                    elseif ($i == $pagina - $limite - 1 || $i == $pagina + $limite + 1) {
                        echo "<div class='page-link'>...</div>";
                    }
                }

                echo '</div>';
                echo '</div>';
                ?>
            </div>
        </div>
    </main>
    <footer class="rodape">   
        <!-- Direitos Autorais no meio -->
        <div class="direitos">
          &copy; <?php echo date("Y"); ?> Todos os direitos reservados!
        </div>
        
        <!-- Redes Sociais na direita -->
        <div class="redes-sociais">
            <a href="#" target="_blank"><i class="bi bi-youtube"></i></a>
            <a href="#" target="_blank"><i class="bi bi-instagram"></i></a>
        </div>
    </footer>
  <script src="../script/dynamic-icons.js"></script>    
</body>