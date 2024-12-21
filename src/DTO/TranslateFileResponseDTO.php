<?php

namespace MalvikLab\LibreTranslateClient\DTO;

final readonly class TranslateFileResponseDTO
{
    /**
     * @param string $translatedFileUrl
     */
    public function __construct(
        public string $translatedFileUrl
    ) {
    }
}