<?php
    require_once '../../../connection/conn.php';

    $dsn = "mysql:host=$servername;dbname=$dbaccount;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $username, $password, $options);

        $sqlVerificaTabela = "
        CREATE TABLE IF NOT EXISTS `noticias` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `titulo` VARCHAR(255) NOT NULL,
        `slug` VARCHAR(191) NOT NULL UNIQUE,
        `conteudo` TEXT NOT NULL,
        `resumo` VARCHAR(500) DEFAULT NULL,
        `autor` VARCHAR(100) DEFAULT 'Admin',
        `data_publicacao` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `status` ENUM('rascunho', 'publicado') DEFAULT 'publicado',
        INDEX idx_data (`data_publicacao` DESC)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        $pdo->exec($sqlVerificaTabela);

        $checarTrigger = $pdo->query("SHOW TRIGGERS LIKE 'noticias'")->fetchAll();
        $triggerExiste = false;

        foreach ($checarTrigger as $trig) {
            if ($trig['Trigger'] === 'ajusta_hora_noticia') {
                $triggerExiste = true;
                break;
            }
        }

        if (!$triggerExiste) {
            $sqlTrigger = "
            CREATE TRIGGER `ajusta_hora_noticia`
            BEFORE INSERT ON `noticias`
            FOR EACH ROW
            BEGIN
                SET NEW.data_publicacao = DATE_SUB(NOW(), INTERVAL 3 HOUR);
            END;
            ";
            $pdo->exec($sqlTrigger);
        }

        // 2. SALVA A MENSAGEM DE SUCESSO NA SESSÃO
        $_SESSION['success_system'] = "🚀 Sistema de notícias inicializado e sincronizado com o horário de Brasília!";

        // 3. REDIRECIONA PARA A OUTRA PÁGINA (mude 'index.php' para o arquivo que preferir)
        header("Location: ../../../index.php");
        exit(); // Interrompe o script para garantir o redirecionamento imediato
        
    } catch (\PDOException $e) {
        // Se houver erro na conexão ou no SQL, captura aqui
        die("Erro no sistema de notícias: " . $e->getMessage());
    }
?>