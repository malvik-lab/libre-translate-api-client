<?php

namespace MalvikLab\LibreTranslateClient\DTO;

final readonly class SuggestResponseDTO
{
    /**
     * @param bool $success
     */
    public function __construct(
        public bool $success,
    ) {
    }
}