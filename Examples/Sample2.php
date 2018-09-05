<?php
require_once '../vendor/autoload.php';  

$data = [ "table" => [
        ["foo", 1234, "$\\alpha$"],
        ["bar", 5678, "$\\beta$"],
        ["foobar", 42, "$\\epsilon$"],
    ],
    "author" => "Max Mustermann",
];

$template = __DIR__.DIRECTORY_SEPARATOR."sample2.phtml";
$destiny = ".";
$file = 'sample2.tex';

$generator = new PLG\PLG($destiny);
$generator->render($file,$template, $data);
$generator->generate($file);

