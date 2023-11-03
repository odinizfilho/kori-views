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
        if (!is_dir($templateDirectory) || !is_writable($templateDirectory)) {
            throw new \Exception("Invalid or unwritable template directory: $templateDirectory");
        }

        $this->templateDirectory = realpath($templateDirectory);
        if ($this->templateDirectory === false) {
            throw new \Exception("Invalid template directory: $templateDirectory");
        }
    }

    public function render($templateName, $data = [])
    {
        $templatePath = $this->templateDirectory . DIRECTORY_SEPARATOR . $templateName;

        if (strpos($templatePath, $this->templateDirectory) !== 0 || !file_exists($templatePath) || !is_file($templatePath)) {
            throw new \Exception("Template not found or invalid: $templateName");
        }

        ob_start();

        // Evite conflitos de variáveis globais passando dados explicitamente
        $renderTemplate = function ($templatePath, $data) {
            extract($data);
            include $templatePath;
        };

        // Execute a função de renderização dentro de um escopo isolado
        $renderTemplate($templatePath, $data);

        return ob_get_clean();
    }
}
