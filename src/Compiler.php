<?php

namespace KoriViews;

class Compiler
{
    public function compile($templateContent)
    {
        // Implemente a lógica de compilação aqui

        $compiledTemplate = $this->parseTemplate($templateContent);

        return $compiledTemplate;
    }

    protected function parseTemplate($templateContent)
    {
        // Implemente a lógica de análise do template aqui

        // Exemplo: Substituir variáveis
        $parsedTemplate = preg_replace('/{{\s*([^}]+)\s*}}/', '<?php echo $1; ?>', $templateContent);

        // Exemplo: Adicionar suporte a condicionais
        $parsedTemplate = $this->compileConditionals($parsedTemplate);

        // Exemplo: Adicionar suporte a loops
        $parsedTemplate = $this->compileLoops($parsedTemplate);

        // Exemplo: Adicionar suporte a filtros
        $parsedTemplate = $this->applyFilters($parsedTemplate);

        return $parsedTemplate;
    }

    protected function compileConditionals($templateContent)
    {
        // Implemente o suporte a condicionais
        $parsedTemplate = preg_replace('/@if\s*\(([^)]+)\)/', '<?php if ($1): ?>', $templateContent);
        $parsedTemplate = preg_replace('/@elseif\s*\(([^)]+)\)/', '<?php elseif ($1): ?>', $parsedTemplate);
        $parsedTemplate = preg_replace('/@else/', '<?php else: ?>', $parsedTemplate);
        $parsedTemplate = preg_replace('/@endif/', '<?php endif; ?>', $parsedTemplate);

        return $parsedTemplate;
    }

    protected function compileLoops($templateContent)
    {
        // Implemente o suporte a loops
        $parsedTemplate = preg_replace('/@foreach\s*\(([^)]+)\)/', '<?php foreach ($1): ?>', $templateContent);
        $parsedTemplate = preg_replace('/@endforeach/', '<?php endforeach; ?>', $parsedTemplate);

        return $parsedTemplate;
    }

    protected function applyFilters($templateContent)
    {
        // Implemente a aplicação de filtros
        $parsedTemplate = preg_replace('/\|(\w+)/', '->$1()', $templateContent);

        return $parsedTemplate;
    }
}
