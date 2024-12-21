<?php

namespace MalvikLab\LibreTranslateClient\DTO;

use MalvikLab\LibreTranslateClient\Enum\FormatEnum;

final readonly class TranslateRequestDTO extends AbstractRequestDTO
{
    /**
     * @param string $q
     * @param string $source
     * @param string $target
     * @param FormatEnum $format
     * @param int $alternatives
     */
    public function __construct(
        public string $q,
        public string $source,
        public string $target,
        public FormatEnum $format = FormatEnum::TEXT,
        public int $alternatives = 3
    ) {
    }
}
