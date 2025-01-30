<?php

// Formata CNPJ (XX.XXX.XXX/XXXX-XX)
if (!function_exists('formatCNPJ')) {
    function formatCNPJ($cnpj) {
        if (strlen($cnpj) == 14) {
            return substr($cnpj, 0, 2) . '.' . 
                   substr($cnpj, 2, 3) . '.' . 
                   substr($cnpj, 5, 3) . '/' . 
                   substr($cnpj, 8, 4) . '-' . 
                   substr($cnpj, 12);
        }
        return $cnpj;
    }
}

// Formata CPF (XXX.XXX.XXX-XX)
if (!function_exists('formatCPF')) {
    function formatCPF($cpf) {
        if (strlen($cpf) == 11) {
            return substr($cpf, 0, 3) . '.' . 
                   substr($cpf, 3, 3) . '.' . 
                   substr($cpf, 6, 3) . '-' . 
                   substr($cpf, 9);
        }
        return $cpf;
    }
}

// Formata Data (dd/mm/yyyy)
if (!function_exists('formatData')) {
    function formatData($data) {
        $timestamp = strtotime($data);
        if ($timestamp) {
            return date('d/m/Y', $timestamp);
        }
        return $data;
    }
}

// Formata Dinheiro (R$ X.XXX,XX)
if (!function_exists('formatDinheiro')) {
    function formatDinheiro($valor) {
        return 'R$ ' . number_format($valor, 2, ',', '.');
    }
}

// Formata CEP (XXXXX-XXX)
if (!function_exists('formatCEP')) {
    function formatCEP($cep) {
        if (strlen($cep) == 8) {
            return substr($cep, 0, 5) . '-' . substr($cep, 5);
        }
        return $cep;
    }
}

// Formata Telefone com ou sem DDD ((XX) XXXX-XXXX ou (XX) XXXXX-XXXX)
if (!function_exists('formatPhone')) {
    function formatPhone($phone, $ddd = null) {
        $formatted = preg_replace('/(\d{4,5})(\d{4})/', '$1-$2', $phone);
        if ($ddd) {
            return "($ddd) $formatted";
        }
        return $formatted;
    }
}

// Valida se é um cnpj
if (!function_exists('isCnpj')) {
    function isCnpj($cnpj) {
        return preg_match('/^\d{2}\.?\d{3}\.?\d{3}\/?\d{4}-?\d{2}$/', $cnpj);
    }
}

// Desformata um CNPJ para o padrão do banco
if (!function_exists('unFormatCnpj')) {
    function unFormatCnpj($cnpj) {
        return preg_replace('/[^0-9]/', '', $cnpj);
    }
}

//Limpa os espaços somente do início e do fim das frases
if(!function_exists('cleanSpaceExterns')){
    function cleanSpaceExterns($texto) {
        return trim($texto,$characters = " \t\n\r\0\x0B");
    }
}