<?php

require_once __DIR__ . '/../src/Template.php';

// Test the Template class
$template = new KoriViews\Template();
$template->setTemplateDirectory(__DIR__ . '/templates'); // Defina o diretório aqui
$data = ['name' => 'John'];
$output = $template->render('test-template.kori');

echo $output;
