

# Site Responsivo para Servidor Metin2

Site completo e responsivo desenvolvido para gerenciamento e interface de servidores de Metin2. O projeto foca na experiência do usuário e na integração de sistemas essenciais para a operação do jogo.

🛠️ Funcionalidades
- Autenticação: Páginas de Login e Cadastro de contas.
- Central de Downloads: Acesso facilitado aos arquivos do cliente.
- Competição: Sistema de Ranking integrado.
- Informativo: Seções dedicadas a Notícias, Regras e Status do servidor em tempo real.
- Design: Interface totalmente responsiva (Mobile/Desktop).

## Demostração simples
<img width="1898" height="914" alt="image" src="https://github.com/user-attachments/assets/9edf8505-df9e-492d-b5d0-9d35183d63fb" />




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
   * Localize a conta desejada e altere o valor da coluna `web` para `1`. Isso fará com que o site reconheça a conta como Administrador.

2. **Acessar o Painel:**
   * Conecte-se à conta modificada através do site.

3. **Executar a Instalação:**
   * No menu do usuário, clique no link **"Instalar sistema de notícia"**.
   
   <img width="1328" alt="Link de instalação no menu" src="https://github.com/user-attachments/assets/0ebbfb9f-446d-45e6-bb24-cf33e6c2d781" />

   * O sistema exibirá uma tela com as orientações de configuração. Leia e basta aceitá-las para prosseguir.
   
   <img width="454" alt="Janela de confirmação da instalação" src="https://github.com/user-attachments/assets/eb15a5d2-6657-4eed-bfc7-41fad49dc68e" />

> 💡 **Pronto!** O sistema de notícias foi instalado e as tabelas estruturadas com sucesso. A partir de agora, o painel de gerenciamento estará disponível para uso da administração.


