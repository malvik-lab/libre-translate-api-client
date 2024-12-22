<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Exception\InvalidSource;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use MalvikLab\LibreTranslateClient\Client;
use MalvikLab\LibreTranslateClient\DTO\DetectRequestDTO;
use MalvikLab\LibreTranslateClient\DTO\DetectResponseDTO;
use MalvikLab\LibreTranslateClient\DTO\LanguagesResponseDTO;
use MalvikLab\LibreTranslateClient\DTO\SuggestRequestDTO;
use MalvikLab\LibreTranslateClient\DTO\SuggestResponseDTO;
use MalvikLab\LibreTranslateClient\DTO\TranslateFileRequestDTO;
use MalvikLab\LibreTranslateClient\DTO\TranslateFileResponseDTO;
use MalvikLab\LibreTranslateClient\DTO\TranslateRequestDTO;
use MalvikLab\LibreTranslateClient\DTO\TranslateResponseDTO;
use MalvikLab\LibreTranslateClient\DTO\FrontendSettingsResponseDTO;
use MalvikLab\LibreTranslateClient\Enum\FormatEnum;
use MalvikLab\LibreTranslateClient\DTO\DetectDTO;

final class ClientTest extends TestCase
{
    private Client $client;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->client = new Client(
            (string)getenv('BASE_URL'),
            getenv('API_KEY') ?: null
        );
    }

    /**
     * @throws InvalidSource
     * @throws GuzzleException
     * @throws MappingError
     */
    public function testFrontendSettings(): void
    {
        $response = $this->client->frontendSettings();

        $this->assertInstanceOf(FrontendSettingsResponseDTO::class, $response);
    }

    /**
     * @throws InvalidSource
     * @throws GuzzleException
     * @throws MappingError
     */
    public function testDetect(): void
    {
        $request = new DetectRequestDTO('Chi lascia la via vecchia per la nuova, sa quel che lascia non sa quel che trova.');
        $response = $this->client->detect($request);

        $this->assertInstanceOf(DetectResponseDTO::class, $response);
    }

    /**
     * @throws InvalidSource
     * @throws GuzzleException
     * @throws MappingError
     */
    public function testLanguages(): void
    {
        $response = $this->client->languages();

        $this->assertInstanceOf(LanguagesResponseDTO::class, $response);
    }

    /**
     * @throws InvalidSource
     * @throws GuzzleException
     * @throws MappingError
     */
    public function testTranslateFromSelectedLanguage(): void
    {
        $request = new TranslateRequestDTO(
            'I soldi non fanno la felicità, figuratevi la miseria...',
            'it',
            'en',
            FormatEnum::TEXT,
            3
        );
        $response = $this->client->translate($request);

        $this->assertInstanceOf(TranslateResponseDTO::class, $response);
        $this->assertNull($response->detectedLanguage);
    }

    /**
     * @return void
     * @throws GuzzleException
     * @throws InvalidSource
     * @throws MappingError
     */
    public function testTranslateFromDetectedLanguage(): void
    {
        $request = new TranslateRequestDTO(
            'Morto un papa se ne fa un altro.',
            'auto',
            'en',
            FormatEnum::TEXT,
            3
        );
        $response = $this->client->translate($request);

        $this->assertInstanceOf(TranslateResponseDTO::class, $response);
        $this->assertInstanceOf(DetectDTO::class, $response->detectedLanguage);
    }

    /**
     * @return void
     * @throws GuzzleException
     * @throws InvalidSource
     * @throws MappingError
     */
    public function testTranslateFile(): void
    {
        $request = new TranslateFileRequestDTO(
            join(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'data', 'test.txt']),
            'it',
            'en'
        );
        $response = $this->client->translateFile($request);

        $this->assertInstanceOf(TranslateFileResponseDTO::class, $response);
    }

    /**
     * @throws InvalidSource
     * @throws GuzzleException
     * @throws MappingError
     */
    public function testSuggest(): void
    {
        $frontendSettings = $this->client->frontendSettings();

        if ( !$frontendSettings->suggestions )
        {
            $this->expectException(ClientException::class);
        }

        $request = new SuggestRequestDTO(
            'Hello world!',
            '¡Hola mundo!',
            'en',
            'es'
        );
        $response = $this->client->suggest($request);

        $this->assertInstanceOf(SuggestResponseDTO::class, $response);
    }
}