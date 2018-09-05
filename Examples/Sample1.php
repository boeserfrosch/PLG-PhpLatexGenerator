<?php
require_once '../vendor/autoload.php';

$data = [ "table" => [
        ["foo", 1234, "$\\alpha$"],
        ["bar", 5678, "$\\beta$"],
        ["foobar", 42, "$\\epsilon$"],
    ],
    "author" => "Max Mustermann",
];


$template = "sample1.twig";
$destiny = ".";
$file = 'sample1.tex';

$generator = new PLG\PLG($destiny);
$generator->render($file,$template, $data);
$generator->generate($file);
$generator->download();

