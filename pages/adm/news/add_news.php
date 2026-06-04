<?php
session_start();
if (!isset($_SESSION['user'])) {
  // Usuário não logado, redireciona para a página de login
  header("Location: ../../../index.php");
  exit;
}
require_once '../../../connection/conn.php';

$mensagemSucesso = "";
$mensagemErro = "";
$pdo = new PDO("mysql:host=$servername;dbname=$dbaccount;charset=$charset", "$username", "$password");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_DEFAULT);
    $autor  = filter_input(INPUT_POST, 'autor', FILTER_DEFAULT);
    
    $conteudo = filter_input(INPUT_POST, 'conteudo', FILTER_DEFAULT);

    if (empty($titulo) || empty($conteudo)) {
        $mensagemErro = "❌ O título e o conteúdo são obrigatórios!";
    } else {
        
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', iconv('UTF-8', 'ASCII//TRANSLIT', $titulo))));

        try {
            date_default_timezone_set('America/Sao_Paulo');
            $dataAtual = date('Y-m-d H:i:s'); // Gera: 2026-05-24 23:04:56

            $sql = "INSERT INTO noticias (titulo, slug, conteudo, autor, data_publicacao) 
                    VALUES (:titulo, :slug, :conteudo, :autor, :data)";

            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([
                'titulo'   => $titulo,
                'slug'     => $slug,
                'conteudo' => $conteudo,
                'autor'    => !empty($autor) ? $autor : 'Admin',
                'data'     => $dataAtual // <-- O PHP envia a hora certa de Brasília para o banco
            ]);

            if ($resultado) {
                $mensagemSucesso = "🚀 Notícia cadastrada com sucesso!";
                $titulo = $conteudo = $autor = "";
            }

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $mensagemErro = "❌ Já existe uma notícia com esse título. Mude um pouco o título!";
            } else {
                $mensagemErro = "❌ Erro ao salvar no banco: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Nova Notícia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                
                <a href="../../../index.php" class="btn btn-outline-secondary btn-sm mb-4">
                    ← Voltar para o Site
                </a>

                <div class="card bg-dark text-light border-secondary shadow">
                    <div class="card-header border-secondary bg-secondary bg-opacity-10 p-4">
                        <h2 class="h4 mb-0 text-warning text-uppercase fw-bold" style="letter-spacing: 1px;">
                            ✍️ Publicar Nova Notícia
                        </h2>
                        <small class="text-llight">Preencha os campos abaixo para atualizar os jogadores</small>
                    </div>
                    
                    <div class="card-body p-4">
                        
                        <?php if (!empty($mensagemSucesso)): ?>
                            <div class="alert alert-success bg-success bg-opacity-25 border-success text-light mb-4" role="alert">
                                <?= $mensagemSucesso; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($mensagemErro)): ?>
                            <div class="alert alert-danger bg-danger bg-opacity-25 border-danger text-light mb-4" role="alert">
                                <?= $mensagemErro; ?>
                            </div>
                        <?php endif; ?>

                        <form action="" method="POST">
                            
                            <div class="mb-3">
                                <label for="titulo" class="form-label fw-bold text-secondary-light">Título da Notícia</label>
                                <input type="text" class="form-input form-control bg-dark text-light border-secondary" 
                                       id="titulo" name="titulo" placeholder="Ex: Grande atualização de balanceamento" 
                                       value="<?= isset($titulo) ? htmlspecialchars($titulo) : ''; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="autor" class="form-label fw-bold text-secondary-light">Autor / Redator</label>
                                <input type="text" class="form-input form-control bg-dark text-light border-secondary" 
                                       id="autor" name="autor" placeholder="Ex: GM_Gabriel ou Admin"
                                       value="<?= isset($autor) ? htmlspecialchars($autor) : ''; ?>">
                            </div>

                            <div class="mb-4">
                                <label for="conteudo" class="form-label fw-bold text-secondary-light">Conteúdo Completo</label>
                                <textarea class="form-control bg-dark text-light border-secondary" 
                                          id="conteudo" name="conteudo" rows="10" 
                                          placeholder="Escreva o texto aqui. Você pode apertar ENTER normalmente para criar novos parágrafos..." required><?= isset($conteudo) ? htmlspecialchars($conteudo) : ''; ?></textarea>
                            </div>

                            <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
                                <button type="reset" class="btn btn-outline-secondary px-4 me-sm-2">Limpar Tudo</button>
                                <button type="submit" class="btn btn-warning px-5 fw-bold text-dark">Publicar Notícia</button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Ajustes finos de inputs para o tema dark */
        .form-control:focus {
            background-color: #212529 !important;
            color: #fff !important;
            border-color: #ffc107 !important;
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25) !important;
        }
        .text-secondary-light { color: #d0d0d0; }
    </style>
</body>
</html>