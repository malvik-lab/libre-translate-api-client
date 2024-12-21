<?php

namespace MalvikLab\LibreTranslateClient\DTO;

final readonly class FrontendSettingsResponseDTO
{
    /**
     * @param bool $apiKeys
     * @param int $charLimit
     * @param bool $filesTranslation
     * @param int $frontendTimeout
     * @param bool $keyRequired
     * @param SettingsLanguageDTO $language
     * @param bool $suggestions
     * @param string[] $supportedFilesFormat
     */
    public function __construct(
        public bool $apiKeys,
        public int $charLimit,
        public bool $filesTranslation,
        public int $frontendTimeout,
        public bool $keyRequired,
        public SettingsLanguageDTO $language,
        public bool $suggestions,
        public array $supportedFilesFormat
    ) {
    }
}