<?php
include './utils/utils.php';
session_start();
// Conexão com o banco de dados
include 'conn.php';

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
$sql = "SELECT p.job, p.name, p.level, p.exp, pi.empire FROM $dbplayer.player as p
INNER JOIN $dbplayer.player_index as pi ON p.account_id = pi.id
WHERE p.`name` NOT IN (SELECT mName FROM $dbcommon.gmlist)
ORDER BY p.level DESC LIMIT :inicio, :por_pagina";

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
    <link rel="shortcut icon" type="image/x-icon" href="./assets/favicon.ico">
    <title>Metin2</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-flex justify-content-between">
        <div class="d-flex">
            <div class="logo">
                <a href="index.php" class="navbar-brand"><img src="./assets/metin2.png" class="img-fluid" alt="metin2"></a>
            </div>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="download.php">Download</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="ranking.php">Ranking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rules.php">Regras</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="status.php">Status</a>
                </li>
            </ul>
        </div>
        <div class="d-flex">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <?php
                    if (!$_SESSION['user']) {
                        echo '<a class="btn btn-primary me-2" href="login.php">';
                        echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right me-1"     viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                  <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>';
                        echo 'Entrar';
                        echo '</a>';
                    }
                    ?>
                </li>
            </ul>
      <?php
        avatar($_SESSION['user'], $avatarBackgroundColor);
      ?>
        </div>
    </nav>
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
    <footer id="sticky-footer" class="flex-shrink-0 py-3 bg-dark text-white-50">
        <div class="container text-center">
            <small>Todos os direitos reservados! Copyright &copy; <?php echo date("Y"); ?></small>
        </div>
    </footer>
</body>