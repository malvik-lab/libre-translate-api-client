<?php

namespace MalvikLab\LibreTranslateClient\DTO;

final readonly class LanguagesResponseDTO
{
    /**
     * @param LanguageDTO[] $items
     */
    public function __construct(public array $items)
    {}
}