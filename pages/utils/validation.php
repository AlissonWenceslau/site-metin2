<?php
    /*
        O que essa função faz?

        Essa função validatePassword() verifica se a senha atende aos seguintes critérios:

        Tamanho mínimo: Pelo menos 8 caracteres.

        Letra maiúscula: Deve conter pelo menos uma (ex: A, B, Z).

        Letra minúscula: Deve conter pelo menos uma (ex: a, b, z).

        Número: Deve conter pelo menos um dígito (0–9).

        Caractere especial: Deve conter ao menos um caractere especial (ex: !@#$%&* etc).
    */
    function validatePassword($password)
    {
        //Array com os erros
        $errors = [];
        // Critérios de validação
        $minCaracteres = 8;

        if (strlen($password) < $minCaracteres) {
            $errors[] = "Senha: A senha deve ter pelo menos $minCaracteres caracteres.";
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Senha: A senha deve conter pelo menos uma letra maiúscula.";
        }

        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Senha: A senha deve conter pelo menos uma letra minúscula.";
        }

        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = "Senha: A senha deve conter pelo menos um número.";
        }

        if (!preg_match('/[\W_]/', $password)) {
            $errors[] = "Senha: A senha deve conter pelo menos um caractere especial.";
        }

        return  $errors;
    }

        function validateConfirmPassword($password)
    {
        //Array com os erros
        $errors = [];
        // Critérios de validação
        $minCaracteres = 8;

        if (strlen($password) < $minCaracteres) {
            $errors[] = "Confirmar senha: A senha deve ter pelo menos $minCaracteres caracteres.";
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Confirmar senha: A senha deve conter pelo menos uma letra maiúscula.";
        }

        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Confirmar senha: A senha deve conter pelo menos uma letra minúscula.";
        }

        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = "Confirmar senha: A senha deve conter pelo menos um número.";
        }

        if (!preg_match('/[\W_]/', $password)) {
            $errors[] = "Confirmar senha: A senha deve conter pelo menos um caractere especial.";
        }

        return  $errors;
    }

    function validateNewConfirmPassword($password, $confirmPassword)
    {
        //Array com os erros
        $errors = [];
        // Critérios de validação
        $minCaracteres = 8;

        if (strlen($password) < $minCaracteres || strlen($confirmPassword) < $minCaracteres) {
            $errors[] = "Senha conta: A nova senha deve ter pelo menos $minCaracteres caracteres.";
        }

        if (strcmp($password, $confirmPassword)) {
            $errors[] = "Senha conta: A nova não corresponde";
        }

        return $errors;
    }

    function validateMax7Alphanumeric($input)
    {
        //Array com os erros
        $errors = [];
        // Verifica se contém apenas letras e números
        if (!preg_match('/^\d+$/', $input)) {
            $errors[] = "Senha Personagem: Apenas números são permitidos.";
        }

        // Verifica o comprimento (máximo 7 caracteres)
        if (strlen($input) > 7 || strlen($input) < 7) {
            $errors[] = "Senha do Personagem: A senha precisa ter exatamente 7 dígitos. Por favor, ajuste e tente novamente.";
        }

        return $errors;
    }

    function validateMax12Alphanumeric($input)
    {
        //Array com os erros
        $errors = [];

        // Verifica se contém apenas letras e números
        if (!preg_match('/^[a-zA-Z0-9]+$/', $input)) {
            $errors[] = "Login: Apenas letras e números são permitidos.";
        }

        // Verifica o comprimento (máximo 7 caracteres)
        if (strlen($input) > 12) {
            $errors[] = "Login: O valor deve conter no máximo 12 caracteres.";
        }

        return $errors;
    }
?>