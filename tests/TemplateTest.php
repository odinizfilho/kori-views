<?php

require_once __DIR__ . '/../src/Template.php';

// Testando a  class Template 
$template = new KoriViews\Template();
$templateDirectory = __DIR__ . '/templates'; // Defina o diretório aqui
$template->setTemplateDirectory($templateDirectory);
$data = ['name' => 'John'];
$output = $template->render('test-template.kori', $data);

echo $output;

