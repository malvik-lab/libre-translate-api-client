<?php

namespace MalvikLab\LibreTranslateClient\DTO;

final readonly class TranslateFileRequestDTO extends AbstractRequestDTO
{
    /**
     * @param string $filePath
     * @param string $source
     * @param string $target
     */
    public function __construct(
        public string $filePath,
        public string $source,
        public string $target
    ) {
    }
}