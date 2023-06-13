


<?php


$urls = [
    'postgres://postgress:root@localhost:5432/film'
];

foreach ($urls as $url) {
    echo $url, PHP_EOL;
    var_export(parse_url($url));
    echo PHP_EOL, PHP_EOL;
}


echo "creado";