<?php
function calcularINSS()
{
  $salarioBruto = $_GET['salarioBruto'];
  $inss = 0;
  $aliquotaProgressiva = 0;

  $primeiraFaixa = 97.65;
  $segundaFaixa = 114.23;
  $terceiraFaixa = 154.27;

  if ($salarioBruto <= 1302.00) {
    $aliquotaProgressiva = $salarioBruto * 0.075;
    $salarioSemInss = $salarioBruto - $aliquotaProgressiva;
  } else if ($salarioBruto <= 2571.29) {
    $aliquotaProgressiva =  $primeiraFaixa + (($salarioBruto - 1302.00) * 0.09);
    $salarioSemInss = $salarioBruto - $aliquotaProgressiva;
  } else if ($salarioBruto <= 3856.94) {
    $aliquotaProgressiva =  $primeiraFaixa + $segundaFaixa + (($salarioBruto - 2571.29) * 0.12);
    $salarioSemInss = $salarioBruto - $aliquotaProgressiva;
  } else if ($salarioBruto <= 7507.49) {
    $aliquotaProgressiva =  $primeiraFaixa + $segundaFaixa +  $terceiraFaixa + (($salarioBruto - 3856.94) * 0.14);
    $salarioSemInss = $salarioBruto - $aliquotaProgressiva;
  } else {
    $salarioSemInss = $salarioBruto - 877.24;
  }

  return calcularIRRF($salarioSemInss, $aliquotaProgressiva);
}

function calcularIRRF($salarioSemInss, $aliquotaProgressiva)
{
  $numDependentes = $_GET['numDependentes'];
  $irrf = 0;
  $valorLiquido = 0;

  $valorBaseIR1 = $salarioSemInss;
  $valorBaseIR2 = $valorBaseIR1 - ($numDependentes * 189.59);

  switch (true) {
    case ($valorBaseIR2 <= 1903.98):
      $irrf = 0;
      break;
    case ($valorBaseIR2 <= 2826.65):
      $irrf = ($valorBaseIR2 * 0.075) - 142.80;
      break;
    case ($valorBaseIR2 <= 3751.05):
      $irrf = ($valorBaseIR2 * 0.15) - 354.80;
      break;
    case ($valorBaseIR2 <= 4664.68):
      $irrf = ($valorBaseIR2 * 0.225) - 636.13;
      break;
    default:
      $irrf = ($valorBaseIR2 * 0.275) - 869.36;
  }

  $valorLiquido = $salarioSemInss - $irrf;

  return "Valor de IRRF: " . round($irrf, 2) . '<br>' .  
  "Valor de INSS: " . round($aliquotaProgressiva, 2) . '<br>' . 
  "Salario liquido: " . round($valorLiquido, 2) ;
}
