<?php
namespace App\Service\Content;

use \League\CommonMark\DocParser;
use \League\CommonMark\Environment;
use \League\CommonMark\HtmlRenderer;
use App\Service\Content\CustomLinkRenderer;

class Content extends \Globalis\PuppetSkilled\Service\Base
{
    protected $contentTable = 'contents';

    protected $contentTranslationTable = 'contents_translations';

    protected $contentMetaTable = 'contents_metas';

    protected $database;

    protected $debug = false;

    protected $debugCallback = false;

    protected $cache = [];

    public function __construct()
    {
        $this->database = $this->db;
    }

    public function buildContent($slug, array $variables = [], $local = null)
    {
        $content = $this->getContentInfo($slug);

        if ($local === null) {
            $local = config_item('language');
        }

        if ($content && $content->active == 1) {
            // Add values
            $return = new \stdClass();
            $return->title = ($content->{$local}->title)?: '';
            $return->content = ($content->{$local}->content)?: '';
            $return->excerpt = ($content->{$local}->excerpt)?: '';
            if (!empty($content->variables)) {
                foreach ($content->variables as $key) {
                    $value = (isset($variables[$key]) ? $variables[$key] : '');
                    $return->title = $this->replaceVariables($return->title, $key, $value);
                    $return->content = $this->replaceVariables($return->content, $key, $value);
                    $return->excerpt = $this->replaceVariables($return->excerpt, $key, $value);
                }
            }
            $return->title = $return->title;
            $return->content = $this->convertToHtml($return->content);
            $return->excerpt = $this->convertToHtml($return->excerpt);
            return $return;
        }
        return false;
    }

    protected function replaceVariables($content, $key, $value)
    {
        return preg_replace('/\{\{' .preg_quote($key). '\}\}/', $value, $content);
    }

    public function getValue($slug, $local = null)
    {
        if ($local === null) {
            $local = config_item('language');
        }

        if (!isset($this->cache[$local])) {
            $this->cache[$local] = [];
        }

        if (!isset($this->cache[$local][$slug])) {
            $result =  $this->getBaseQuery()
                ->select(['contents.active', 'contents_translations.local', 'contents_translations.title', 'contents_translations.content', 'contents_translations.excerpt'])
                ->join($this->contentTranslationTable.' as contents_translations', 'contents.slug', '=', 'contents_translations.content_slug')
                ->where('contents.slug', $slug)
                ->where('contents_translations.local', $local)
                ->first();
            $this->cache[$local][$slug] = $result;
        }
        if ($this->cache[$local][$slug] && $this->cache[$local][$slug]->active && $this->cache[$local][$slug]->content) {
            return $this->convertToHtml($this->cache[$local][$slug]->content);
        }
        return false;
    }

    public function load($contentSlug, $type = null, $local = null)
    {
        if ($local === null) {
            $local = config_item('language');
        }

        if (!isset($this->cache[$local])) {
            $this->cache[$local] = [];
        }

        $query =  $this->getBaseQuery()
            ->select(['contents.slug', 'contents.active', 'contents_translations.local', 'contents_translations.title', 'contents_translations.content', 'contents_translations.excerpt'])
            ->join($this->contentTranslationTable.' as contents_translations', 'contents.slug', '=', 'contents_translations.content_slug')
            ->where('contents.slug', 'like', '%' . $contentSlug . '%')
            ->where('contents_translations.local', $local);
        if ($type !== null) {
            $query->where('contents.type', 'in', (array)$type);
        }
        foreach ($query->cursor() as $result) {
            $this->cache[$local][$result->slug] = $result;
        }
    }

    public function isActive($slug)
    {
        return (boolean)$this->getBaseQuery()
            ->where('contents.slug', $slug)
            ->where('contents.active', 1)
            ->count();
    }

    public function convertToHtml($markdown)
    {
        $markdown = str_replace(["\r\n", "\n", "\r"], "\n\n", $markdown);

        $env = Environment::createCommonMarkEnvironment();
        $env->addInlineRenderer('League\CommonMark\Inline\Element\Link', new CustomLinkRenderer());
        $parser = new DocParser($env);
        $htmlRend = new HtmlRenderer($env);

        $doc = $parser->parse($markdown);

        return $htmlRend->renderBlock($doc);
    }

    public function getContentInfo($slug)
    {
        $item = $this->getBaseQuery()
            ->where('contents.slug', $slug)
            ->first();

        if (!$item) {
            return false;
        }

        // Add meta data to the model
        $metas = $this->getBaseMetaQuery()
                ->where('content_slug', $item->slug)
                ->cursor();
        foreach ($metas as $meta) {
            $item->{$meta->key} = unserialize($meta->value);
        }

        // Add translation to the item
        $translations = $this->getBaseTranslationQuery()
            ->where('content_slug', $item->slug)
            ->cursor();
        foreach ($translations as $translation) {
            $item->{$translation->local} = $translation;
        }

        return $item;
    }

    public function getContentInfoByType($type = [])
    {
        $items = $this->getBaseQuery()
                        ->whereIn('type', $type)
                        ->where('active', 1)
                        ->get();

        if (!$items) {
            return false;
        }

        $item_list = [];

        foreach ($items as $item) {
            // Add meta data to the model
            $metas = $this->getBaseMetaQuery()
                    ->where('content_slug', $item->slug)
                    ->cursor();
            foreach ($metas as $meta) {
                $item->{$meta->key} = unserialize($meta->value);
            }

            // Add translation to the item
            $translations = $this->getBaseTranslationQuery()
                ->where('content_slug', $item->slug)
                ->cursor();
            foreach ($translations as $translation) {
                $item->{$translation->local} = $translation;
            }

            $item_list[] = $item;
        }

        return $item_list;
    }

    public function active($slug, $active = 1)
    {
        return $this->newQuery()
            ->from($this->contentTable)
            ->where('slug', $slug)
            ->update(['active' => $active]);
    }

    public function setTranslation($slug, $local, $title, $content, $excerpt = null)
    {
        return $this->newQuery()
            ->from($this->contentTranslationTable)
            ->updateOrInsert(
                [
                    'content_slug' => $slug,
                    'local' => $local,
                ], [
                    'content_slug' => $slug,
                    'local' => $local,
                    'title' => $title,
                    'content' => $content,
                    'excerpt' => $excerpt,
                ]
            );
    }

    public function newQuery()
    {
            return $this->queryBuilder;
    }

    public function getBaseQuery()
    {
        return $this->newQuery()
            ->select([
                'contents.slug',
                'contents.type',
                'contents.title_key',
                'contents.description_key',
                'contents.active',
                'contents.created_at',
                'contents.modified_at'
            ])
            ->from($this->contentTable . ' as contents');
    }

    protected function getBaseTranslationQuery()
    {
        return $this->newQuery()
            ->select([
                'content_slug',
                'local',
                'title',
                'content',
                'excerpt',
            ])
            ->from($this->contentTranslationTable);
    }

    protected function getBaseMetaQuery()
    {
        return $this->newQuery()
            ->select([
                'content_meta.content_slug',
                'content_meta.key',
                'content_meta.value',
            ])
            ->from($this->contentMetaTable . ' as content_meta');
    }
}
