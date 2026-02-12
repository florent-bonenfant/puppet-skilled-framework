<?php

namespace App\Controllers\Webservice;

class Content extends \App\Core\Controller\Webservice
{
    protected $isPublic = true;

    /**
     * @api {get} /content/{id}  Get all page and text contents
     * @apiName contentAll
     * @apiGroup Content
     * @apiVersion 1
     *
     * @apiSuccess (200)    {result}       result       Array of contents by slug
     *
     */
    public function all()
    {
        $contents = [];

        foreach ($this->contentService->getContentInfoByType(['page', 'content_simple']) as $content) {
            $contents[$content->slug] = [
                'title' => $content->french->title,
                'content' => $content->french->content,
                'excerpt' => $content->french->excerpt
            ];
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $contents
        ]);
    }
}
