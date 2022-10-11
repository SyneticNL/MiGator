<?php

namespace Translator;

use Illuminate\Support\Collection;

interface TranslatorInterface
{
    public function translateToUp(Collection $input);

    public function translateToDown(Collection $input);
}
