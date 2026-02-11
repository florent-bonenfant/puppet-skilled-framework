<?php
namespace App\Service\Content;

use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Util\Xml;

class CustomLinkRenderer implements InlineRendererInterface
{

    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof \League\CommonMark\Inline\Element\Link)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        $attrs = array();

        $attrs['href'] =  Xml::escape($inline->getUrl(), true);

        if (isset($inline->attributes['title'])) {
            $attrs['title'] =  Xml::escape($inline->data['title'], true);
        }

        // add custom css to a balise
        $attrs['style'] = "display: inline-block; background-color: #ac0040; border: none; color: #fff; border-radius: 2px; padding: 10px 20px; cursor: pointer;text-decoration:none;";

        return new HtmlElement('a', $attrs, $htmlRenderer->renderInlines($inline->children()));
    }
}