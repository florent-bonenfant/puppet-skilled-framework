<?php
namespace App\Service\Content;

use League\CommonMark\CommonMarkConverter;

class Builder
{
    protected $data;

    public $value;

    protected $variables;

    protected $activeMarkdown;

    public function __construct($value, $variables = [])
    {
        $this->value = $value;
        $this->variables = $variables?: [];
        $this->activeMarkdown = false;
    }

    public function activeMarkdown($active)
    {
        $this->activeMarkdown = $active;
        return $this;
    }

    public function bind($data)
    {
        if (is_array($data)) {
            $this->data = $data;
        } else {
            $this->data = (array) $data;
        }
        return $this;
    }

    protected function convertToHtml($markdown)
    {
        $markdown = str_replace(array("\r\n", "\n", "\r"), "\n\n", $markdown);
        $converter = new CommonMarkConverter(['html_input' => 'escape']);
        return $converter->convertToHtml($markdown);
    }

    protected function replaceVariables($content, $key)
    {
        $value = (isset($this->data[$key]) ? $this->data[$key] : '');
        return preg_replace('/\{\{' .preg_quote($key). '\}\}/', $value, $content);
    }

    public function __toString()
    {
        // First replace vars
        $content = $this->value;
        foreach ($this->variables as $key) {
            $content = $this->replaceVariables($content, $key);
        }
        // MD convertion
        if ($this->activeMarkdown) {
            return $this->convertToHtml($content);
        }
        return $content;
    }
}
