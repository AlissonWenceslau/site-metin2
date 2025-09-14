# METIN2  SIMPLE WEBPAGE
Este é um webpage responsivo simples desenvolvido por mim, que conta com um formulário para registros de contas para servidor de metin2.

![cadastro](https://github.com/user-attachments/assets/b299ea6c-8da9-45ba-a3eb-9798679988c7)
![login](https://github.com/user-attachments/assets/27ce8ea2-81e0-483c-8131-23df8e82791f)
![logado](https://github.com/user-attachments/assets/d9570712-7005-4694-a614-fea98344be3f)
![alterar_senha](https://github.com/user-attachments/assets/e317455a-e96e-4ff8-b898-2e7050754725)
![download](https://github.com/user-attachments/assets/1110f5c0-393c-47f0-b998-165de8177a02)
![ranking](https://github.com/user-attachments/assets/1b022b5e-68f3-4c55-928a-5f2be3660986)
![regras](https://github.com/user-attachments/assets/244c2cbf-4ef5-4f3c-a075-a007b55f52df)
![status](https://github.com/user-attachments/assets/e6b28e4f-7412-4f40-9003-6bd038ad25c4)

## Tecnologia
- [x] PHP 8+
- [x] Mysql 5.6
- [x] Bootstrap

## Instalação do banco de dados para teste local
**Observação**:
Esta instalação é necessária apenas para fins de teste. Se você já possui um servidor configurado, pode ignorar esta seção.
### Dump banco de dados
Aviso:
O dump disponibilizado neste repositório não representa o banco de dados real do Metin2. Ele foi criado exclusivamente para simular a estrutura de bancos e tabelas necessárias ao funcionamento do site, permitindo testes sem a necessidade de subir o servidor completo.

- [Acessar Arquivos Dump](https://github.com/AlissonWenceslau/simple-site-registry-metin2/tree/main/database/dump)
- Baixe o mysql na versão 5.6 em sua máquina e faça o dump;
- Via docker:
    ```docker 
    $ docker run --metin2 -p 3306:3306 -e MYSQL_ROOT_PASSWORD=123 -d mysql:5.6
    ```
    Após a instalação do container, você deve entrar no banco e fazer o dump

## Configurando webpage
Para que o webpage envie repostas ao servidor, é preciso abrir o arquivo **'conn.php'** e colocar o **ip do servidor, usuário e senha MYSQL.**

![conn](https://github.com/user-attachments/assets/ea83234e-bbcf-4bdf-958b-9f0d57da9b00)


## Créditos
[Alisson Wenceslau](https://www.youtube.com/@alissonwenceslau)
