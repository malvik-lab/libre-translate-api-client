<?php

namespace MalvikLab\LibreTranslateClient\DTO;

final readonly class DetectResponseDTO
{
    /**
     * @param DetectDTO[] $items
     */
    public function __construct(public array $items)
    {}
}