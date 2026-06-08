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
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Metin2</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a href="../index.php" class="navbar-brand"><img src="../assets/metin2.png" class="img-fluid ms-1"
                alt="metin2"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
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
                        <a class="nav-link" href="rules.php"><i class="bi bi-shield-shaded me-2"></i>Regras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="status.php"><i class="bi bi-info-circle"></i>Status</a>
                    </li>
                </ul>
            </div>
            <div class="logar">
                <ul class="navbar-nav align-items-center pe-3 pe-md-4">
                    <li class="nav-item">
                        <?php if (!$_SESSION['user']): ?>
                            <a class="btn btn-outline-primary btn-sm px-3 py-1.5 fw-semibold text-uppercase d-inline-flex align-items-center gap-2"
                                href="./login.php"
                                style="letter-spacing: 0.5px; font-size: 0.85rem; transition: all 0.2s ease;">
                                <i class="bi bi-box-arrow-in-right fs-5"></i>
                                <span>Entrar</span>
                            </a>
                        <?php endif; ?>
                    </li>
                </ul>
                <?php
                avatar($_SESSION['user'], $avatarBackgroundColor, 'logout.php', './change_password.php');
                ?>
            </div>
        </div>
    </nav>
    <main class="bg-white text-dark min-vh-100 py-5">
        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-xl-10">

                        <div class="text-center mb-4 bg-dark p-4 rounded border border-secondary shadow-sm">
                            <h2 class="h3 text-white text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">
                                <i class="bi bi-trophy-fill me-2 text-warning"></i>Ranking de Personagens
                            </h2>
                            <p class="text-white-50 small mb-0">Os guerreiros mais poderosos que moldam a história do
                                servidor.</p>
                        </div>

                        <div class="card bg-dark text-light border-secondary shadow-sm">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover align-middle mb-0 text-center custom-table">
                                    <thead>
                                        <tr class="border-bottom border-secondary text-uppercase"
                                            style="font-size: 0.85rem; letter-spacing: 0.5px;">
                                            <th scope="col" class="py-3 text-light">#</th>
                                            <th scope="col" class="py-3 text-light">Classe</th>
                                            <th scope="col" class="py-3 text-light">Nome</th>
                                            <th scope="col" class="py-3 text-light">Nível</th>
                                            <th scope="col" class="py-3 text-light">Exp</th>
                                            <th scope="col" class="py-3 text-light">Reino</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 0;
                                        foreach ($players as $player => $row) {
                                            $position = $offset + $player + 1;

                                            $rowClass = '';
                                            $medalha = '';

                                            if ($position === 1) {
                                                $rowClass = 'table-podium-gold';
                                                $medalha = '<i class="bi bi-award-fill text-warning fs-5 me-1 animate-glow" title="1º Lugar (Ouro)"></i> ';
                                            } elseif ($position === 2) {
                                                $rowClass = 'table-podium-silver';
                                                $medalha = '<i class="bi bi-award-fill text-secondary fs-5 me-1" title="2º Lugar (Prata)"></i> ';
                                            } elseif ($position === 3) {
                                                $rowClass = 'table-podium-bronze';
                                                $medalha = '<i class="bi bi-award-fill fs-5 me-1" style="color: #cd7f32;" title="3º Lugar (Bronze)"></i> ';
                                            }

                                            echo "<tr class='border-bottom border-secondary-subtle " . $rowClass . "'>";
                                            echo "<th scope='row' class='fw-bold text-white py-3'>" . $medalha . $position . "</th>";
                                            echo "<td class='text-white-50'>" . pgClass($row['job'], '../assets/character/') . "</td>";
                                            echo "<td class='fw-semibold text-white'>" . htmlspecialchars($row["name"]) . "</td>";
                                            echo "<td><span class='badge bg-primary bg-opacity-25 border border-primary text-primary px-2.5 py-1.5 fw-bold'>" . $row["level"] . "</span></td>";
                                            echo "<td class='text-white-50 text-opacity-75'>" . number_format($row["exp"]) . "</td>";
                                            echo "<td>" . pgKingdom($row["empire"]) . "</td>";
                                            echo "</tr>";
                                        }

                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <?php
                        $total_paginas = ceil($total / $por_pagina);
                        $limite = 2;

                        if ($total_paginas > 1): ?>
                            <nav aria-label="Navegação do ranking" class="mt-4">
                                <ul class="pagination justify-content-center mb-0">
                                    <?php
                                    for ($i = 1; $i <= $total_paginas; $i++) {
                                        $isActive = ($i == $pagina);

                                        if ($i == 1 || $i == $total_paginas || ($i >= $pagina - $limite && $i <= $pagina + $limite)) {
                                            if ($isActive) {
                                                echo '<li class="page-item active" aria-current="page"><span class="page-link bg-primary border-primary text-white fw-bold">' . $i . '</span></li>';
                                            } else {
                                                echo '<li class="page-item"><a class="page-link bg-white border-secondary-subtle text-dark hover-page" href="?pagina=' . $i . '">' . $i . '</a></li>';
                                            }
                                        } elseif ($i == $pagina - $limite - 1 || $i == $pagina + $limite + 1) {
                                            echo '<li class="page-item disabled"><span class="page-link bg-light border-secondary-subtle text-muted">...</span></li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </nav>
                        <?php endif; ?>

                    </div>
                </div>
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
            <a href="<?= $social['youtube'] ?>" target="_blank"><i class="bi bi-youtube"></i></a>
            <a href="<?= $social['instagram'] ?>" target="_blank"><i class="bi bi-instagram"></i></a>
        </div>
    </footer>
    <script src="../script/dynamic-icons.js"></script>
</body>