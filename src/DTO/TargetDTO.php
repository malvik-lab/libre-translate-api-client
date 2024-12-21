<?php

namespace MalvikLab\LibreTranslateClient\DTO;

final readonly class TargetDTO
{
    /**
     * @param string $code
     * @param string $name
     */
    public function __construct(
        public string $code,
        public string $name,
    ) {
    }
}