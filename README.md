
# Kori Views 

Kori Views é uma biblioteca leve de renderização de templates em PHP para a construção de páginas da web dinâmicas. Ela permite separar sua lógica PHP de seus modelos HTML, tornando seu código mais limpo e mais fácil de manter.


## Instalação

Instale kori-views com composer

```bash
  composer require odinizfilho/kori-views:dev-master
```
    
## Uso/Exemplos
Aqui está como você pode usar o Kori Views em seu projeto PHP:

```php
<?php

require_once __DIR__ . '/../src/Template.php';

// Crie uma instância da classe Template
$template = new KoriViews\Template();

// Defina o diretório de modelos (substitua 'templates' pelo diretório de seus modelos)
$template->setTemplateDirectory(__DIR__ . '/templates');

// Defina os dados a serem usados no modelo
$data = ['name' => 'John'];

// Renderize um modelo (substitua 'test-template.kori' pelo nome real do arquivo de modelo)
$output = $template->render('test-template.kori');

// Exiba o modelo renderizado
echo $output;

```

Certifique-se de substituir __DIR__ . '/templates' pelo caminho real para o seu diretório de modelos e 'test-template.kori' pelo nome real do arquivo de modelo.
## Licença

[MIT](https://choosealicense.com/licenses/mit/)

