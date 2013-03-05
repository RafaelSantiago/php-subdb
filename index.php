<?php
require "config.inc.php";
require "functions.inc.php";

// THIRD-PARTY CLASSES
require "libs/class.php-prowl.php";

$arrArquivos = array();
$count = 0;

getFiles($path_scan, $arrArquivos);

foreach ($arrArquivos as $arquivo){

        if ((in_array(extensao($arquivo),$allowed_extensions)) && (filesize($arquivo) > $min_size * 1024 * 1024)){

                $count++;
                $hash = hashSubDb($arquivo);

                echo "<br/>-----------------------<br/>";
                echo "Arquivo Encontrado: " .$arquivo. " | Hash: ".$hash."<br/>";
                echo "Procurando Legenda para: ".$arquivo."<br/>";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_USERAGENT, "SubDB/1.0 (PHPSubDB 0.1; http://github.com/)");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL, "http://api.thesubdb.com/?action=search&hash=".$hash);
                $retorno = curl_exec($ch);
                unset($ch);

                if (strpos($retorno, $language) !== false){

                        echo "Encontrada Legenda: ".$arquivo."<br/>";

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_USERAGENT, "SubDB/1.0 (PHPSubDB 0.1; http://github.com/)");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_URL, "http://api.thesubdb.com/?action=download&hash=".$hash."&language=".$language);
                        $retorno = curl_exec($ch);
                        unset($ch);

                        $retorno = (substr($retorno,0,1) == '?') ? substr($retorno,1,strlen($retorno)-1) : $retorno;

                        $fileLegenda = fopen(pathArquivo($arquivo) . DIRECTORY_SEPARATOR . fileNameLegenda($arquivo),'w');
                        fwrite($fileLegenda, $retorno);
                        fclose($fileLegenda);

                        echo "Legenda Baixada: ".pathArquivo($arquivo) . DIRECTORY_SEPARATOR . fileNameLegenda($arquivo)."<br/>";

                        if ($prowl_send == true){
                            sendProwlMessage($prowl_api_key, fileNameLegenda($arquivo));
                        }

                }
                else {

                        echo "Não encontrada Legenda: ".$arquivo."</br>";

                }

        }

}

if ($count == 0){
    echo "Nenhum arquivo de video encontrado.";
}
?>