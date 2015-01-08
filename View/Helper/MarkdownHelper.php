<?php

use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;

class MarkdownHelper extends AppHelper {

    public $helpers = [
        'Croogo.Layout'
    ];

    public function transform($markdownText) {
        $environment = Environment::createCommonMarkEnvironment();

        $beforeParseEvent = Croogo::dispatchEvent('Helper.Markdown.beforeMarkdownParse', $this->_View, array(
            'environment' => $environment,
            'markdown' => $markdownText
        ));
        $markdownText = $beforeParseEvent->data['markdown'];
        $environment = $beforeParseEvent->data['environment'];

        $parser = new DocParser($environment);
        $htmlRenderer = new HtmlRenderer($environment);

        $documentAST = $parser->parse($markdownText);

        $beforeRenderEvent = Croogo::dispatchEvent('Helper.Markdown.beforeMarkdownRender', $this->_View, array(
            'ast' => $documentAST
        ));
        $documentAST = $beforeRenderEvent->data['ast'];

        $rendered = $htmlRenderer->renderBlock($documentAST);

        $afterRenderEvent = Croogo::dispatchEvent('Helper.Markdown.afterMarkdownRender', $this->_View, array(
            'rendered' => $rendered
        ));

        return $afterRenderEvent->data['rendered'];
    }

    public function afterSetNode() {
        $fields = Configure::read('Croogomark.node_fields');
        if (is_array($fields)) {
            foreach ($fields AS $field) {
                $this->Layout->setNodeField($field, $this->transform($this->Layout->node($field)));
            }
        }
    }

}