<?php

namespace MalvikLab\LibreTranslateClient\DTO;

final readonly class LanguageDTO
{
    /**
     * @param string $code
     * @param string $name
     * @param string[] $targets
     */
    public function __construct(
        public string $code,
        public string $name,
        public array $targets
    ) {
    }
}