<?php
$social = [
    'instagram' => 'https://instagram.com',
    'youtube' => 'https://youtube.com',
];

$avatarBackgroundColor = [
    'A' => '#FF6633',
    'B' => '#FFB399',
    'C' => '#FF33FF',
    'D' => '#FFFF99',
    'E' => '#00B3E6',
    'F' => '#E6B333',
    'G' => '#3366E6',
    'H' => '#999966',
    'I' => '#99FF99',
    'J' => '#B34D4D',
    'K' => '#80B300',
    'L' => '#809900',
    'M' => '#E6B3B3',
    'N' => '#6680B3',
    'O' => '#66991A',
    'P' => '#FF99E6',
    'Q' => '#CCFF1A',
    'R' => '#FF1A66',
    'S' => '#E6331A',
    'T' => '#33FFCC',
    'U' => '#66994D',
    'V' => '#B366CC',
    'W' => '#4D8000',
    'X' => '#B33300',
    'Y' => '#CC80CC',
    'Z' => '#66664D',
];


function pgClass($job, $path)
{
    // Garante que o caminho termine com uma barra se o desenvolvedor esquecer de colocar
    $path = rtrim($path, '/') . '/';

    switch ($job) {
        case 0:
            return '<img src="' . htmlspecialchars($path) . '0.png" alt="Guerreiro M">';
        case 1:
            return '<img src="' . htmlspecialchars($path) . '1.png" alt="Ninja F">';
        case 2:
            return '<img src="' . htmlspecialchars($path) . '2.png" alt="Sura M">';
        case 3:
            return '<img src="' . htmlspecialchars($path) . '3.png" alt="Xamã F">';
        case 4:
            return '<img src="' . htmlspecialchars($path) . '4.png" alt="Guerreiro F">';
        case 5:
            return '<img src="' . htmlspecialchars($path) . '5.png" alt="Ninja M">';
        case 6:
            return '<img src="' . htmlspecialchars($path) . '6.png" alt="Sura F">';
        case 7:
            return '<img src="' . htmlspecialchars($path) . '7.png" alt="Xamã M">';
        default:
            // Caso venha um job inválido ou não mapeado (ex: Lycan ou erro do banco)
            return '<img src="' . htmlspecialchars($path) . '0.png" alt="Desconhecido">';
    }
}

function pgKingdom($kingdom)
{
    switch ($kingdom) {
        case 1:
            return '<img src="../assets/kingdom/shinso.jpg">';
        case 2:
            return '<img src="../assets/kingdom/chunjo.jpg">';
        case 3:
            return '<img src="../assets/kingdom/jinno.jpg">';
    }
}

function avatar($session, $avatarBackgroundColor, $path, $changePasswordPath = '#')
{
    if ($session) {
        // Pega a primeira letra do nome, em maiúscula
        $letra = strtoupper($session[0]);

        // Protege a letra para evitar XSS e pega a cor correspondente
        $letraSegura = htmlspecialchars($letra);
        $cor = $avatarBackgroundColor[$letra] ?? '#6c757d'; // Cor padrão cinza

        echo <<<HTML
        <div class="dropdown me-2">
            <a href="#" class="d-flex align-items-center dropdown-toggle text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="rounded-circle shadow-sm d-flex justify-content-center align-items-center text-light fw-bold fs-5"
                     style="width: 40px; height: 40px; background-color: {$cor}; user-select: none;" 
                     title="Acessar menu da conta">
                    {$letraSegura}
                </div>
            </a>
            
            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-start dropdown-menu-md-end shadow border-secondary mt-2">
                <li class="dropdown-header text-secondary small text-uppercase">Minha Conta</li>
                <li><hr class="dropdown-divider border-secondary"></li>
                
                <li>
                    <a class="dropdown-item text-light d-flex align-items-center gap-2 py-2" href="{$changePasswordPath}">
                        <i class="bi bi-shield-lock text-primary fs-5"></i> Alterar Senha
                    </a>
                </li>
                
                <li><hr class="dropdown-divider border-secondary"></li>
                
                <li>
                    <a class="dropdown-item text-danger d-flex align-items-center gap-2 fw-semibold py-2" href="{$path}">
                        <i class="bi bi-box-arrow-right fs-5"></i> Sair da Conta
                    </a>
                </li>
            </ul>
        </div>
        HTML;
    }
}