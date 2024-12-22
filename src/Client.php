<?php

namespace MalvikLab\LibreTranslateClient;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Exception\InvalidSource;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\GuzzleException;
use MalvikLab\LibreTranslateClient\DTO\AbstractRequestDTO;
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
use MalvikLab\LibreTranslateClient\Makers\LanguagesResponseMaker;
use MalvikLab\LibreTranslateClient\Makers\SuggestResponseMaker;
use MalvikLab\LibreTranslateClient\Makers\TranslateFileResponseMaker;
use MalvikLab\LibreTranslateClient\Makers\TranslateResponseMaker;
use MalvikLab\LibreTranslateClient\Makers\DetectResponseMaker;
use MalvikLab\LibreTranslateClient\Makers\FrontendSettingsResponseMaker;

class Client
{
    private const NAME = 'LIBRE TRANSLATE API CLIENT';
    private const VERSION = '1.0.1';
    private HttpClient $httpClient;

    /**
     * @param string $baseUrl
     * @param string|null $apiKey
     * @param HttpClient|null $httpClient
     */
    public function __construct(
        private readonly string $baseUrl,
        private readonly ?string $apiKey = null,
        ?HttpClient $httpClient = null
    ) {
        $this->httpClient = $httpClient ?? new HttpClient();
    }

    /**
     * @param DetectRequestDTO $request
     * @return DetectResponseDTO
     * @throws GuzzleException
     * @throws InvalidSource
     * @throws MappingError
     */
    public function detect(DetectRequestDTO $request): DetectResponseDTO
    {
        $requestBody = $this->prepareRequestBody($request);
        $response = $this->httpClient->request('POST', $this->baseUrl . '/detect', [
            'json' => $requestBody
        ]);

        return DetectResponseMaker::make($response);
    }

    /**
     * @return LanguagesResponseDTO
     * @throws GuzzleException
     * @throws InvalidSource
     * @throws MappingError
     */
    public function languages(): LanguagesResponseDTO
    {
        $response = $this->httpClient->request('GET', $this->baseUrl . '/languages');

        return LanguagesResponseMaker::make($response);
    }

    /**
     * @param TranslateRequestDTO $request
     * @return TranslateResponseDTO
     * @throws GuzzleException
     * @throws InvalidSource
     * @throws MappingError
     */
    public function translate(TranslateRequestDTO $request): TranslateResponseDTO
    {
        $requestBody = $this->prepareRequestBody($request);
        $response = $this->httpClient->request('POST', $this->baseUrl . '/translate', [
            'json' => $requestBody
        ]);

        return TranslateResponseMaker::make($response);
    }

    /**
     * @param TranslateFileRequestDTO $request
     * @return TranslateFileResponseDTO
     * @throws GuzzleException
     * @throws InvalidSource
     * @throws MappingError
     */
    public function translateFile(TranslateFileRequestDTO $request): TranslateFileResponseDTO
    {
        $excludeFields = [
            'filePath',
        ];
        $includeFields = [
            'file' => Psr7\Utils::tryFopen($request->filePath, 'r'),
        ];
        $requestBody = $this->prepareMultipartRequestBody($request, $excludeFields, $includeFields);

        $response = $this->httpClient->request('POST', $this->baseUrl . '/translate_file', [
            'multipart' => $requestBody,
        ]);

        return TranslateFileResponseMaker::make($response);
    }

    /**
     * @param SuggestRequestDTO $request
     * @return SuggestResponseDTO
     * @throws GuzzleException
     * @throws InvalidSource
     * @throws MappingError
     */
    public function suggest(SuggestRequestDTO $request): SuggestResponseDTO
    {
        $requestBody = $this->prepareRequestBody($request);
        $response = $this->httpClient->request('POST', $this->baseUrl . '/suggest', [
            'json' => $requestBody
        ]);

        return SuggestResponseMaker::make($response);
    }

    /**
     * @return FrontendSettingsResponseDTO
     * @throws MappingError
     * @throws InvalidSource
     * @throws GuzzleException
     */
    public function frontendSettings(): FrontendSettingsResponseDTO
    {
        $response = $this->httpClient->request('GET', $this->baseUrl . '/frontend/settings');

        return FrontendSettingsResponseMaker::make($response);
    }

    /**
     * @return string
     */
    public function getNane(): string
    {
        return self::NAME;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return self::VERSION;
    }

    /**
     * @param AbstractRequestDTO $request
     * @return array<string, mixed>
     */
    private function prepareRequestBody(AbstractRequestDTO $request): array
    {
        $requestBody = (array)$request;

        if ( $this->apiKey )
        {
            $requestBody['api_key'] = $this->apiKey;
        }

        return $requestBody;
    }

    /**
     * @param AbstractRequestDTO $request
     * @param array<string> $excludeFields
     * @param array<string, mixed> $includeFields
     * @return array<int<0, max>, array<string, mixed>>
     */
    private function prepareMultipartRequestBody(AbstractRequestDTO $request, array $excludeFields = [], array $includeFields = []): array
    {
        $requestBody = [];

        foreach ( (array)$request as $key => $value )
        {
            if ( in_array($key, $excludeFields) )
            {
                continue;
            }

            $requestBody[] = [
                'name' => $key,
                'contents' => $value,
            ];
        }

        foreach ( $includeFields as $key => $value )
        {
            $requestBody[] = [
                'name' => $key,
                'contents' => $value,
            ];
        }

        if ( $this->apiKey )
        {
            $requestBody[] = [
                'name' => 'api_key',
                'contents' => $this->apiKey,
            ];
        }

        return $requestBody;
    }
}