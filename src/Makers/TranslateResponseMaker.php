<?php

namespace MalvikLab\LibreTranslateClient\Makers;

use CuyZ\Valinor\Mapper\MappingError;
use Psr\Http\Message\ResponseInterface;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;
use CuyZ\Valinor\Mapper\Source\Exception\InvalidSource;
use MalvikLab\LibreTranslateClient\DTO\TranslateResponseDTO;

class TranslateResponseMaker
{
    /**
     * @throws InvalidSource
     * @throws MappingError
     */
    public static function make(ResponseInterface $response): TranslateResponseDTO
    {
        return (new MapperBuilder())
            ->mapper()
            ->map(
                TranslateResponseDTO::class,
                Source::json($response->getBody())
            );
    }
}
