<?php

use League\CommonMark\CommonMarkConverter;

class MarkdownHelper extends AppHelper {

    public $helpers = [
        'Croogo.Layout'
    ];

    public function transform($text) {
        $converter = new CommonMarkConverter();

        return $converter->convertToHtml($text);
    }

    public function afterSetNode() {
        $fields = Configure::read('Croogodown.node_fields');
        if (is_array($fields)) {
            foreach ($fields AS $field) {
                $this->Layout->setNodeField($field, $this->transform($this->Layout->node($field)));
            }
        }
    }

}