<?php
// FUNCAO QUE BUSCA TODOS OS ARQUIVOS DA PASTA (RECURSIVAMENTE)
function getFiles($scanPath, &$arrFiles){
	
    $dh = opendir($scanPath);

    while(false !== ($file = readdir($dh))){
        if ($file != '..' && $file != '.'){
            if (is_dir($scanPath.'/'.$file)){
                getFiles($scanPath.DIRECTORY_SEPARATOR.$file, $arrFiles);
            }
            else {
                array_push($arrFiles,$scanPath.DIRECTORY_SEPARATOR.$file);
            }
        }
    }
	
}

// FUNÇÃO QUE RETORNA O HASH DO ARQUIVO
function hashSubDB($filename){
    $size = filesize($filename);

    $inicio = file_get_contents($filename, false, null, 0, 64 * 1024);
    $fim = file_get_contents($filename, false, null, $size - (64 * 1024), 64 * 1024);
    $data = $inicio . $fim;

    $hash = md5($data);
    return $hash;
}

// FUNÇÃO QUE RETORNA A EXTENSAO DO ARQUIVO
function extensao($filename){
    $pos = strrpos($filename,'.');
    return substr($filename,$pos+1,strlen($filename)-$pos);
}

function fileNameLegenda($filename){
    $pos = strrpos($filename,'\\');
    if ($pos > 0){
        $filename = substr($filename, $pos+1, strlen($filename)-$pos);
    }

    $filename = str_replace(".".extensao($filename),'.srt',$filename);
    return $filename;
}

function pathArquivo($filename){
    return substr($filename, 0, strrpos($filename,'\\'));
}

function sendProwlMessage($apiKey, $filename){
    try {

        $prowl = new Prowl();
        $prowl->setApiKey($apiKey);
        $prowl->setDebug(false);

        $application = "PHPSubDB";
        $event = "Nova Legenda Encontrada";
        $description = "Foi encontrada uma legenda para o arquivo ".$filename;
        $priority = -1;

        $prowl->add($application, $event, $priority, $description);
        return true;
    }
    catch (Expection $error){
        return false;
    }
}
?>
