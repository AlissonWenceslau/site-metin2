

# Site Responsivo para Servidor Metin2

Site completo e responsivo desenvolvido para gerenciamento e interface de servidores de Metin2. O projeto foca na experiência do usuário e na integração de sistemas essenciais para a operação do jogo.

🛠️ Funcionalidades
- Autenticação: Páginas de Login e Cadastro de contas.
- Central de Downloads: Acesso facilitado aos arquivos do cliente.
- Competição: Sistema de Ranking integrado.
- Informativo: Seções dedicadas a Notícias, Regras e Status do servidor em tempo real.
- Design: Interface totalmente responsiva (Mobile/Desktop).

## Demostração simples
<img width="1910" height="908" alt="image" src="https://github.com/user-attachments/assets/ad73e282-cefa-499e-86da-d4c6d9510528" />





## Tecnologia
- [x] PHP 8+
- [x] Mysql 5.6
- [x] Bootstrap

## Configuração do IP
Para que o site envie e receba repostas do servidor, é preciso abrir o arquivo **'conn.php'** localizado na pasta  **connection** e colocar o **ip do servidor, usuário e senha MYSQL.**

<img width="716" height="237" alt="image" src="https://github.com/user-attachments/assets/64277e31-5e3a-40ac-97d1-4203ff87ce80" />

## 📰 Configurando o Sistema de Notícias

O sistema de notícias é uma funcionalidade integrada ao site. Para que ele funcione adequadamente, é necessário configurar a tabela que gerenciará o sistema e definir uma conta de administrador.

### Passo a Passo

1. **Definir Administrador no Banco de Dados:**
   * Acesse a base de dados `account`.
   * Acessa a tabela `account`
   * Localize a conta desejada e altere o valor da coluna `web_admin` para `1`. Isso fará com que o site reconheça a conta como Administrador.
     <img width="1874" height="246" alt="image" src="https://github.com/user-attachments/assets/54d357ab-d6e2-4421-9977-f3159bdc38a0" />


2. **Acessar o Painel:**
   * Conecte-se à conta modificada através do site.

3. **Executar a Instalação:**
   * No menu do usuário, clique no link **"Instalar Notícia"**.
   
<img width="1910" height="911" alt="image" src="https://github.com/user-attachments/assets/f7a044b1-8ad8-4405-99a0-16be2c8ff1a4" />


   * O sistema exibirá uma tela com as orientações de configuração. Leia e basta Executar Instalação para prosseguir.
   
   <img width="507" height="639" alt="image" src="https://github.com/user-attachments/assets/e5b0ea88-9a17-4aba-9685-53176bafd18f" />



> 💡 **Pronto!** O sistema de notícias foi instalado e as tabelas estruturadas com sucesso. A partir de agora, o painel de gerenciamento estará disponível para uso da administração.


