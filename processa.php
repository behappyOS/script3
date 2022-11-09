<?php


$mysqli = new mysqli("url", "user", "pass", "database");
mysqli_set_charset($mysqli, 'utf8');
set_time_limit(0);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//$sql_stmt = "SELECT * FROM receitaws";

//$result = mysqli_query( $mysqli, $sql_stmt );

//if (!$result)
 //   die("Database access failed: " . mysqli_error());

//$rows = mysqli_num_rows($result);

//if ($rows) {

  //  while ($row = mysqli_fetch_array($result)) {
    //    echo 'nome: ' . $row['nome'] . '<br>';
      //  echo 'cnpj: ' . $row['cnpj'] . '<br>';
        //echo 'cep: ' . $row['cep'] . '<br>';
        //echo 'logradouro: ' . $row['logradouro'] . '<br>';
        //echo 'numero: ' . $row['numero'] . '<br>';
        //echo 'complemento: ' . $row['complemento'] . '<br>';
        //echo 'bairro: ' . $row['bairro'] . '<br>';
        //echo 'municipio: ' . $row['municipio'] . '<br>';
        //echo 'uf: ' . $row['uf'] . '<br><br>';
    //}
//}


//die();

$le = 'txt.txt';
//$grava = 'ende.txt';

$handle = fopen( $le, 'r' );

$ler = fread( $handle, filesize($le) );

$cnpj= explode(',', $ler );

//    if (!$handle = fopen($grava, 'a')) {
//        echo "Não foi possível abrir o arquivo ($grava)";
//    }

    foreach ($cnpj as $value) {
  //      $sql = mysqli_query($mysqli,"SELECT cnpj FROM receitaws WHERE cnpj='$value'");

//print_r($sql);
        //if (mysqli_num_rows($sql) > 0) {

       //     echo "CNPJ já existe '$value'</br>";
       // }
      //  else {

            $data = file_get_contents("https://bi.exametoxicologico.com.br/api/cnpjs/{$value}/receitaws/30");

            $obj = json_decode($data, true);

            echo "<pre>";
            var_dump($obj);

            $nome = $obj['body']['nome'];
            $cnpj = $obj['body']['cnpj'];
            $cep = $obj['body']['cep'];
            $logradouro = $obj['body']['logradouro'];
            $numero = $obj['body']['numero'];
            $complemento = $obj['body']['complemento'];
            $bairro = $obj['body']['bairro'];
            $municipio = $obj['body']['municipio'];
            $uf = $obj['body']['uf'];

            die();

            $cnpj = str_replace('.', '', $cnpj);
            $cnpj = str_replace('-', '', $cnpj);
            $cnpj = str_replace('/', '', $cnpj);
            $cep = str_replace('.', '', $cep);
            $cep = str_replace('-', '', $cep);

            $query = "INSERT INTO receitaws
                VALUES('','$nome','$cnpj','$cep','$logradouro',
                '$numero','$complemento','$bairro','$municipio','$uf')";

            $mysqli->query($query);

            echo "Data Imported Sucessfully from JSON!";
        }
//        try {
//            if (fwrite($handle, $data."\n") === FALSE) {
//                throw new Exception( "Não foi possível escrever no arquivo ($grava)");
//            }
//
//            throw new Exception("Sucesso: Escrito ($data) no arquivo ($grava)");
//
//        } catch (Exception $grava){
//            echo 'Exceção capturada: ',  $grava->getMessage(), "\n";
//        }

   // }

fclose($handle);

?>
