<?php

namespace KoriViews;

class Template
{
    protected string $templateDirectory;

    /**
     * Construtor do template
     *
     * @param string|null $templateDirectory O diretório que contém templates.
     */
    public function __construct(?string $templateDirectory = null)
    {
        if ($templateDirectory !== null) {
            $this->setTemplateDirectory($templateDirectory);
        }
    }


    /**
     * Sets the template directory.
     *
     * @param string $templateDirectory The directory containing templates.
     *
     * @throws \InvalidArgumentException If the directory is invalid or not writable.
     * @throws \RuntimeException         If the directory is not valid.
     */
    public function setTemplateDirectory(string $templateDirectory): void
    {
        if (!is_dir($templateDirectory) || !is_writable($templateDirectory)) {
            throw new \InvalidArgumentException("Invalid or unwritable template directory: $templateDirectory");
        }

        $realPath = realpath($templateDirectory);
        if ($realPath === false) {
            throw new \RuntimeException("Invalid template directory: $templateDirectory");
        }

        $this->templateDirectory = $realPath;
    }
    /**
     * Renderiza um template com os dados fornecidos.
     *
     * @param string $templateName O nome do arquivo de template.
     * @param array  $data         Dados a serem usados ​​no template.
     *
     * @return string O conteúdo renderizado.
     */

    public function render(string $templateName, array $data = []): string
    {
        $templatePath = $this->getTemplatePath($templateName);

        $content = file_get_contents($templatePath);
        $content = $this->replacePlaceholders($content, $data);

        return $content;
    }

    /**
     * Substitui espaços reservados no conteúdo pelos dados fornecidos.
     *
     * @param string $content O conteúdo com espaços reservados.
     * @param array  $data    Dados para substituir espaços reservados.
     *
     * @return string Conteúdo com espaços reservados substituídos.
     */
    protected function replacePlaceholders(string $content, array $data): string
    {
        // Substituir <kori code="variavel"/> pelos valores correspondentes
        foreach ($data as $key => $value) {
            $placeholder = '<kori code="' . $key . '"/>';
            $content = str_replace($placeholder, $value, $content);
        }

        return $content;
    }

    /**
     *Obtém o caminho completo do arquivo de template.
     *
     * @param string $templateName O nome do arquivo de template.
     *
     * @return string O caminho completo do arquivo de template.
     *
     * @throws \InvalidArgumentException Se o template não for encontrado ou for inválido.
     */

    protected function getTemplatePath(string $templateName): string
    {
        $templatePath = $this->templateDirectory . DIRECTORY_SEPARATOR . $templateName;
        $templatePath = $this->sanitizeTemplatePath($templatePath);

        if (!file_exists($templatePath) || !is_file($templatePath)) {
            throw new \InvalidArgumentException("template não encontrado ou inválido: $templateName");
        }

        return $templatePath;
    }

    /**
     * Limpa o caminho do template.
     *
     * @param string $templatePath O caminho do arquivo de template.
     *
     * @return string O caminho do template higienizado.
     *
     * @throws \InvalidArgumentException Se o caminho do template for inválido.
     */
    protected function sanitizeTemplatePath(string $templatePath): string
    {
        $basePath = rtrim($this->templateDirectory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $resolvedPath = realpath($templatePath);

        if ($resolvedPath === false || strpos($resolvedPath, $basePath) !== 0) {
            throw new \InvalidArgumentException("Caminho do template inválido: $templatePath");
        }

        return $resolvedPath;
    }

    /**
     * Renderiza um arquivo de template com os dados fornecidos.
     *
     * @param string $templatePath O caminho do arquivo de template.
     * @param array  $data         Dados a serem usados ​​no template.
     *
     * @throws \Throwable Se ocorrer um erro durante a renderização do template.
     */
    protected function renderTemplate(string $templatePath, array $data): void
    {
        $renderTemplate = function (string $templatePath, array $data) {
            extract($data);
            include $templatePath;
        };

        $renderTemplate($templatePath, $data);
    }
}
