<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCpf implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cpf = preg_replace('/\D/', '', $value);

        // CPF precisa ter 11 números
        if (strlen($cpf) !== 11) {
            $fail('O CPF deve conter 11 números.');
            return;
        }

        // Impede CPFs como 11111111111, 22222222222...
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            $fail('O CPF informado é inválido.');
            return;
        }

        // Primeiro dígito verificador
        $soma = 0;

        for ($i = 0; $i < 9; $i++) {
            $soma += intval($cpf[$i]) * (10 - $i);
        }

        $resto = $soma % 11;

        $digito1 = $resto < 2 ? 0 : 11 - $resto;

        if ($digito1 != intval($cpf[9])) {
            $fail('O CPF informado é inválido.');
            return;
        }

        // Segundo dígito verificador
        $soma = 0;

        for ($i = 0; $i < 10; $i++) {
            $soma += intval($cpf[$i]) * (11 - $i);
        }

        $resto = $soma % 11;

        $digito2 = $resto < 2 ? 0 : 11 - $resto;

        if ($digito2 != intval($cpf[10])) {
            $fail('O CPF informado é inválido.');
        }
    }
}