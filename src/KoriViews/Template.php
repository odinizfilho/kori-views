<?php

namespace KoriViews;

class Template
{
    protected $templateDirectory;

    public function __construct($templateDirectory = null)
    {
        if ($templateDirectory !== null) {
            $this->setTemplateDirectory($templateDirectory);
        }
    }

    public function setTemplateDirectory($templateDirectory)
    {
        if (!is_dir($templateDirectory)) {
            throw new \Exception("Invalid template directory: $templateDirectory");
        }
    
        $templateDirectory = realpath($templateDirectory);
    
        if ($templateDirectory === false) {
            throw new \Exception("Invalid template directory: $templateDirectory");
        }
    
        $this->templateDirectory = $templateDirectory;
    }
    

    


    public function render($templateName, $data = [])
    {
        $templatePath = $this->templateDirectory . '/' . $templateName;

        // Verifique se o caminho do template é válido
        if (strpos($templatePath, $this->templateDirectory) !== 0 || !file_exists($templatePath) || !is_file($templatePath)) {
            throw new \Exception("Template not found or invalid: $templateName");
        }

        // Use um buffer de saída de nível superior para capturar o conteúdo
        ob_start();

        // Evite conflitos de variáveis globais usando um escopo isolado
        $renderTemplate = function () use ($templatePath, $data) {
            extract($data);
            include $templatePath;
        };

        // Execute a função de renderização dentro de um escopo isolado
        $renderTemplate();

        return ob_get_clean();
    }
}
