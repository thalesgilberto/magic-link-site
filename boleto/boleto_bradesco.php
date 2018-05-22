<?php

// ------------------------- DADOS DIN�MICOS DO SEU CLIENTE PARA A GERA��O DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formul�rio c/ POST, GET ou de BD (MySql,Postgre,etc)	//
// DADOS DO BOLETO PARA O SEU CLIENTE
require '../seguranca.php';
require_once '../planos_pessoa.php';
$planos_pessoa = new Planos_pessoa();

$dados = $planos_pessoa->dados_boleto($_GET['b']);

$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 0;
$data_pagamento = date_create($dados["data_pagamento"]);
$data_venc = date_format($data_pagamento, "d/m/Y");  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $dados["valor_plano"]; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".", $valor_cobrado);
$valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = "75896452";  // Nosso numero sem o DV - REGRA: M�ximo de 11 caracteres!
$dadosboleto["numero_documento"] = $dados["id_servico"]; // Num do pedido ou do documento = Nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss�o do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto;  // Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula
// DADOS DO SEU CLIENTE
if ($dados["flg_pessoa_juridica"] == 0) {
    $dados["cpf_cnpj"];
    $parte_um = substr($dados["cpf_cnpj"], 0, 3);
    $parte_dois = substr($dados["cpf_cnpj"], 3, 3);
    $parte_tres = substr($dados["cpf_cnpj"], 6, 3);
    $parte_quatro = substr($dados["cpf_cnpj"], 9, 2);
    $monta_cpf_cnpj = "CPF: $parte_um.$parte_dois.$parte_tres-$parte_quatro";
    
} else if ($dados["flg_pessoa_juridica"] == 1) {
    $dados["cpf_cnpj"];
    $parte_um = substr($dados["cpf_cnpj"], 0, 2);
    $parte_dois = substr($dados["cpf_cnpj"], 2, 3);
    $parte_tres = substr($dados["cpf_cnpj"], 5, 3);
    $parte_quatro = substr($dados["cpf_cnpj"], 8, 4);
    $parte_cinco = substr($dados["cpf_cnpj"], 12, 2);
    $monta_cpf_cnpj = "CNPJ: $parte_um.$parte_dois.$parte_tres/$parte_quatro-$parte_cinco";
}
$dadosboleto["cpf_cnpj_cliente"] = $monta_cpf_cnpj;
$dadosboleto["sacado"] = $dados["nome"];
$dadosboleto["endereco1"] = $dados["endereco"];
$dadosboleto["endereco2"] = $dados["cidade"] . " - " . $dados["estado"] . " - CEP: " . $dados["cep"];

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento de compra de plano de internet de " . $dados["descricao_plano"];
$dadosboleto["demonstrativo2"] = "";
$dadosboleto["demonstrativo3"] = "";
$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: atendimento@magiclink.com.br";
$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "001";
$dadosboleto["valor_unitario"] = $valor_boleto;
$dadosboleto["aceite"] = "";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DS";


// ---------------------- DADOS FIXOS DE CONFIGURA��O DO SEU BOLETO --------------- //
// DADOS DA SUA CONTA - Bradesco
$dadosboleto["agencia"] = "1100"; // Num da agencia, sem digito
$dadosboleto["agencia_dv"] = "0"; // Digito do Num da agencia
$dadosboleto["conta"] = "0102003";  // Num da conta, sem digito
$dadosboleto["conta_dv"] = "4";  // Digito do Num da conta
// DADOS PERSONALIZADOS - Bradesco
$dadosboleto["conta_cedente"] = "0102003"; // ContaCedente do Cliente, sem digito (Somente N�meros)
$dadosboleto["conta_cedente_dv"] = "4"; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"] = "06";  // C�digo da Carteira: pode ser 06 ou 03
// SEUS DADOS
$dadosboleto["identificacao"] = "Magic LINK";
$dadosboleto["cpf_cnpj"] = "00.000.000/0000-00";
$dadosboleto["endereco"] = "Cachoeira";
$dadosboleto["cidade_uf"] = "Cachoeira / Bahia";
$dadosboleto["cedente"] = "Magic Link";


ob_start();

// NÃO ALTERAR!
include("funcoes_bradesco.php");
include("layout_bradesco.php");

$content = ob_get_clean();

require '../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

try {
    $html2pdf = new HTML2PDF('P', 'A4', 'fr', array(0, 0, 0, 0));
    /* Abre a tela de impressão */
    //$html2pdf->pdf->IncludeJS("print(true);");

    $html2pdf->pdf->SetDisplayMode('real');

    /* Parametro vuehtml = true desabilita o pdf para desenvolvimento do layout */
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

    /* Abrir no navegador */
    $html2pdf->Output('boleto.pdf');

    /* Salva o PDF no servidor para enviar por email */
    //$html2pdf->Output('caminho/boleto.pdf', 'F');

    /* Força o download no browser */
    //$html2pdf->Output('boleto.pdf', 'D');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>


