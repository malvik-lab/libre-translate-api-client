<?php

namespace MalvikLab\LibreTranslateClient\DTO;

final readonly class SuggestRequestDTO extends AbstractRequestDTO
{
    public function __construct(
        public string $q,
        public string $s,
        public string $source,
        public string $target
    ) {
    }
}