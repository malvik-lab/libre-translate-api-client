<?php

namespace MalvikLab\LibreTranslateClient\DTO;

final readonly class DetectRequestDTO extends AbstractRequestDTO
{
    /**
     * @param string $q
     */
    public function __construct(
        public string $q
    ) {
    }
}