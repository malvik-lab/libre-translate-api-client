<?php

namespace MalvikLab\LibreTranslateClient\DTO;

final readonly class TranslateResponseDTO
{
    /**
     * @param string $translatedText
     * @param string[] $alternatives
     * @param DetectDTO|null $detectedLanguage
     */
    public function __construct(
        public string $translatedText,
        public array $alternatives,
        public ?DetectDTO $detectedLanguage = null
    ) {
    }
}