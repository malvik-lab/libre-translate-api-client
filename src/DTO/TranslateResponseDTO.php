<?php

namespace MalvikLab\LibreTranslateClient\DTO;

final readonly class TranslateResponseDTO
{
    /**
     * @param string $translatedText
     * @param string[] $alternatives
     */
    public function __construct(
        public string $translatedText,
        public array $alternatives
    ) {
    }
}