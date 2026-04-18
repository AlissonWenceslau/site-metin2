# Webpage Responsiva para Servidor Metin2

Webpage completa e responsiva desenvolvida para gerenciamento e interface de servidores de Metin2. O projeto foca na experiência do usuário e na integração de sistemas essenciais para a operação do jogo.

🛠️ Funcionalidades
- Autenticação: Páginas de Login e Cadastro de contas.
- Central de Downloads: Acesso facilitado aos arquivos do cliente.
- Competição: Sistema de Ranking integrado.
- Informativo: Seções dedicadas a Regras e Status do servidor em tempo real.
- Design: Interface totalmente responsiva (Mobile/Desktop).

## DEMO




## Tecnologia
- [x] PHP 8+
- [x] Mysql 5.6
- [x] Bootstrap

## Configurando webpage
Para que o webpage envie repostas ao servidor, é preciso abrir o arquivo **'conn.php'** localizado na pasta  **connection** e colocar o **ip do servidor, usuário e senha MYSQL.**

![conn](https://github.com/user-attachments/assets/ea83234e-bbcf-4bdf-958b-9f0d57da9b00)

## [OPCIONAL - AVANÇADO] Instalação do mysql e php para teste local via linux ou WSL
**Observação**:
Esta instalação é necessária apenas para fins de teste. Se você já possui um servidor configurado, pode ignorar esta seção.
### Dump banco de dados
Aviso:
O dump disponibilizado neste repositório não representa o banco de dados real do Metin2. Ele foi criado exclusivamente para simular a estrutura de bancos e tabelas necessárias ao funcionamento do site, permitindo testes sem a necessidade de subir o servidor completo.

- [Acessar Arquivos Dump](https://github.com/AlissonWenceslau/simple-site-registry-metin2/tree/main/database/dump)
- Baixe o php e mysql na versão 5.6 em sua máquina e faça o dump;
- Via docker:
    ```docker 
    $ docker run --metin2 -p 3306:3306 -e MYSQL_ROOT_PASSWORD=123 -d mysql:5.6
    ```
    Após a instalação do container, você deve entrar no banco e fazer o dump



## Créditos
[Alisson Wenceslau](https://www.youtube.com/@alissonwenceslau)
