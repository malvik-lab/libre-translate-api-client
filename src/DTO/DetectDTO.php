<?php

namespace MalvikLab\LibreTranslateClient\DTO;

final readonly class DetectDTO extends AbstractRequestDTO
{
    /**
     * @param float $confidence
     * @param string $language
     */
    public function __construct(
        public float $confidence,
        public string $language
    ) {
    }
}