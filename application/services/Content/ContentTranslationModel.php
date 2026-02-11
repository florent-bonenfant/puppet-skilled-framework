<?php
namespace App\Service\Content;

class ContentTranslationModel extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contents_translations';

    /**
     * Meta data table
     *
     * @var string
     */
    protected $contentMetaTable = 'contents_metas';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'content_slug';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The associated variables
     *
     * @var array
     */
    protected $variables;


    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function getTitleAttribute($value)
    {
        $b = new Builder($value, $this->getVariables());
        return $b->activeMarkdown(false);
    }

    public function getContentAttribute($value)
    {
        $b = new Builder($value, $this->getVariables());
        return $b->activeMarkdown(true);
    }

    public function getExcerptAttribute($value)
    {
        $b = new Builder($value, $this->getVariables());
        return $b->activeMarkdown(true);
    }

    public function getVariables()
    {
        if ($this->variables === null) {
            $this->variables = app()->queryBuilder->select([
                    'value',
                ])
                ->from($this->contentMetaTable . ' as content_meta')
                ->where('key', 'variables')
                ->where('content_slug', $this->content_slug)
                ->first();
            if ($this->variables) {
                $this->variables = unserialize($this->variables->value);
            } else {
                $this->variables = [];
            }
        }
        return $this->variables;
    }
}
