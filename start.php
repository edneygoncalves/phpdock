<?php

require_once "./lib/helpers.php";


echo "#############################################################\n";
echo "######################## PHPDOCK ############################\n";
echo "############ Gerador de Projetos Docker/Laravel #############\n";
echo "#############################################################\n";

if (isset($argv[1])) {

    $projectName = $argv[1];

} else {

    echo "\n\nDigite o nome do projeto:";

    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);

    fclose($handle);

    $projectName = $line;

}

$nomeFormatado = slugify($projectName);

$dirRoot = $_SERVER['HOME'] . '/docker-amazon/projects/' . $nomeFormatado;

$oldmask = umask(0);
mkdir($dirRoot, 0777);
mkdir("$dirRoot/artefatos", 0777);
mkdir("$dirRoot/src-$nomeFormatado", 0777);
umask($oldmask);

recurse_copy('./resources/phpdocker', $dirRoot . '/phpdocker');

// Listando arquivos

$files['docker-compose.yml'] = file_get_contents('./resources/docker-compose.res');
$files['inicia.sh'] = file_get_contents('./resources/inicia.res');
$files['encerra.sh'] = file_get_contents('./resources/encerra.res');
$files['exec.sh'] = file_get_contents('./resources/exec.res');

foreach($files as $i => $f){

    $rootFile = fopen("$dirRoot/$i", "w") or die("Unable to open file!");
    
    $formatedFile = str_replace('[@!project-name!@]', $nomeFormatado, $f);


    fwrite($rootFile, $formatedFile);


}



echo "Projeto criado em $dirRoot\n\n";
echo "Para o funcionamento correto, execute o comando \n \"chmod +x $dirRoot/*.sh\"\n\n";

