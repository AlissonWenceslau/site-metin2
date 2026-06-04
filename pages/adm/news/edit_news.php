<?php
session_start();

// 1. BARREIRA DE SEGURANÇA RÍGIDA
if (!isset($_SESSION['web']) || $_SESSION['web'] != 1) {
    header("Location: index.php");
    exit();
}

require_once '../../../connection/conn.php';
$dsn = "mysql:host=$servername;dbname=$dbaccount;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$mensagemErro = "";

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// 2. BUSCA OS DADOS ATUAIS DA NOTÍCIA PARA PREENCHER O FORMULÁRIO
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $noticia = $stmt->fetch();

    if (!$noticia) {
        $_SESSION['erro_sistema'] = "❌ Notícia não encontrada para edição.";
        header("Location: ../../../index.php");
        exit();
    }
} else {
    header("Location: ../../../index.php");
    exit();
}

// 3. PROCESSA O ENVIO DO FORMULÁRIO (SALVAR ALTERAÇÕES)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo   = filter_input(INPUT_POST, 'titulo', FILTER_DEFAULT);
    $autor    = filter_input(INPUT_POST, 'autor', FILTER_DEFAULT);
    $conteudo = filter_input(INPUT_POST, 'conteudo', FILTER_DEFAULT); // Mantém quebras de linha

    if (empty($titulo) || empty($conteudo)) {
        $mensagemErro = "❌ O título e o conteúdo são obrigatórios!";
    } else {
        // Recalcula o slug baseado no novo título
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', iconv('UTF-8', 'ASCII//TRANSLIT', $titulo))));

        try {
            $sql = "UPDATE noticias SET titulo = :titulo, slug = :slug, conteudo = :conteudo, autor = :autor WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'titulo'   => $titulo,
                'slug'     => $slug,
                'conteudo' => $conteudo,
                'autor'    => !empty($autor) ? $autor : 'Admin',
                'id'       => $id
            ]);

            // Define mensagem de sucesso e volta para a listagem
            $_SESSION['sucesso_sistema'] = "✏️ Notícia atualizada com sucesso!";
            header("Location: ../../../index.php");
            exit();

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $mensagemErro = "❌ Já existe outra notícia com esse título. Mude-o ligeiramente.";
            } else {
                $mensagemErro = "❌ Erro ao atualizar no banco: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Editar Notícia</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../../assets/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                
                <a href="../../../index.php" class="btn btn-outline-secondary btn-sm mb-4">
                    ← Cancelar e Voltar
                </a>

                <div class="card bg-dark text-light border-secondary shadow">
                    <div class="card-header border-secondary bg-secondary bg-opacity-10 p-4">
                        <h2 class="h4 mb-0 text-warning text-uppercase fw-bold" style="letter-spacing: 1px;">
                            ✏️ Editar Notícia #<?= $noticia['id']; ?>
                        </h2>
                        <small class="text-llight">Modifique os campos necessários para atualizar a postagem</small>
                    </div>
                    
                    <div class="card-body p-4">
                        
                        <?php if (!empty($mensagemErro)): ?>
                            <div class="alert alert-danger bg-danger bg-opacity-25 border-danger text-light mb-4" role="alert">
                                <?= $mensagemErro; ?>
                            </div>
                        <?php endif; ?>

                        <form action="edit_news.php?id=<?= $noticia['id']; ?>" method="POST">
                            
                            <div class="mb-3">
                                <label for="titulo" class="form-label fw-bold text-secondary-light">Título da Notícia</label>
                                <input type="text" class="form-control bg-dark text-light border-secondary" 
                                       id="titulo" name="titulo" 
                                       value="<?= htmlspecialchars($noticia['titulo']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="autor" class="form-label fw-bold text-secondary-light">Autor / Redator</label>
                                <input type="text" class="form-control bg-dark text-light border-secondary" 
                                       id="autor" name="autor" 
                                       value="<?= htmlspecialchars($noticia['autor']); ?>">
                            </div>

                            <div class="mb-4">
                                <label for="conteudo" class="form-label fw-bold text-secondary-light">Conteúdo da Notícia</label>
                                <textarea class="form-control bg-dark text-light border-secondary" 
                                          id="conteudo" name="conteudo" rows="10" required><?= htmlspecialchars($noticia['conteudo']); ?></textarea>
                            </div>

                            <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
                                <a href="../../../index.php" class="btn btn-outline-secondary px-4 me-sm-2">Descartar</a>
                                <button type="submit" class="btn btn-warning px-5 fw-bold text-dark">Salvar Alterações</button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
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