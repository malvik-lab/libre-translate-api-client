<?php

namespace MalvikLab\LibreTranslateClient\Makers;

use CuyZ\Valinor\Mapper\MappingError;
use Psr\Http\Message\ResponseInterface;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;
use CuyZ\Valinor\Mapper\Source\Exception\InvalidSource;
use MalvikLab\LibreTranslateClient\DTO\LanguagesResponseDTO;

class LanguagesResponseMaker
{
    /**
     * @throws InvalidSource
     * @throws MappingError
     */
    public static function make(ResponseInterface $response): LanguagesResponseDTO
    {
        return (new MapperBuilder())
            ->mapper()
            ->map(
                LanguagesResponseDTO::class,
                Source::json($response->getBody())
            );
    }
}
