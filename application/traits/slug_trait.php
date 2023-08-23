<?php

namespace Traits;

trait SlugTrait
{
    public function slugName(string $stringToSlug): string
    {
        return url_title($stringToSlug, 'dash', TRUE);
    }
}
