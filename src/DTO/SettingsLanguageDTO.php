<?php

namespace MalvikLab\LibreTranslateClient\DTO;

final readonly class SettingsLanguageDTO
{
    /**
     * @param SourceDTO $source
     * @param TargetDTO $target
     */
    public function __construct(
        public SourceDTO $source,
        public TargetDTO $target,
    ) {
    }
}