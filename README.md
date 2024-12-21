# LibreTranslate API Client

An API client written in PHP to interact with [LibreTranslate](https://libretranslate.com/), a free, open-source translation API.

## Characteristics
- Translations between different languages ​​supported by LibreTranslate.
- Automatic language detection.
- Support for API Key, if needed.
- Easy setup and use.

## Installation
You can install the client via Composer:
```bash
composer require malvik-lab/libre-translate-api-client
```

## Initializing
```php
<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client as HttpClient;
use MalvikLab\LibreTranslateClient\Client;

// LibreTranslate server URL
$baseUrl = 'http://localhost:5000';

// If the server requires an API Key, enter it here.
// If the server is free (no need for API Key), pass `null` as a parameter.
$apiKey = null; // API Key (optional)

// Example 1: Minimal configuration (without API Key, if the server does not require it)
$client = new Client($baseUrl); // No API Key required

// Example 2: Configuration with API Key (if required by the server)
$client = new Client($baseUrl, $apiKey); // Pass the API Key (can be null)

// Example 3: Configuration with a custom Guzzle instance (for advanced customization)
$httpClient = new HttpClient(); // Custom Guzzle client (useful for adding middlewares, timeouts, etc.)
$client = new Client($baseUrl, $apiKey, $httpClient); // With API Key
// or
$client = new Client($baseUrl, null, $httpClient); // Without API Key (if server is free)
```

## Client Methods
- [Detect](#detect)
- [Languages](#languages)
- [Translate](#translate)
- [Translate file](#translate-file)
- [Suggest](#suggest)
- [Frontend Settings](#frontend-settings)

## Usage
### Detect
Implementation
```php
<?php

// ...

use MalvikLab\LibreTranslateClient\DTO\DetectRequestDTO;

$request = new DetectRequestDTO('Il diavolo fa le pentole ma non i coperchi.');
$response = $client->detect($request);
```

Output
```php
MalvikLab\LibreTranslateClient\DTO\DetectResponseDTO Object
(
    [items] => Array
        (
            [0] => MalvikLab\LibreTranslateClient\DTO\DetectDTO Object
                (
                    [confidence] => 100
                    [language] => it
                )

        )

)
```

### Languages
Implementation
```php
<?php

// ...

$response = $this->client->languages();
```

Output
```php
MalvikLab\LibreTranslateClient\DTO\LanguagesResponseDTO Object
(
    [items] => Array
        (
            [0] => MalvikLab\LibreTranslateClient\DTO\LanguageDTO Object
                (
                    [code] => en
                    [name] => English
                    [targets] => Array
                        (
                            [0] => ar
                            // ...
                            [45] => zt
                        )
                )
                
            // ...
        )

)
```

### Translate
Implementation
```php
<?php

// ...

use MalvikLab\LibreTranslateClient\DTO\TranslateRequestDTO;
use MalvikLab\LibreTranslateClient\Enum\FormatEnum;

$request = new TranslateRequestDTO(
    'Il lupo perde il pelo ma non il vizio',
    'it',
    'en',
    FormatEnum::TEXT,
    3
);
$response = $client->translate($request);
```

Output
```php
MalvikLab\LibreTranslateClient\DTO\TranslateResponseDTO Object
(
    [translatedText] => The wolf loses the fur but not the vice
    [alternatives] => Array
        (
            [0] => The wolf loses his hair but not his vice
            [1] => The wolf loses his fur but not his vice
            [2] => The wolf loses his fur but not the vice
        )
)
```

### Translate file
Implementation
```php
<?php

// ...

use MalvikLab\LibreTranslateClient\DTO\TranslateFileRequestDTO;

$request = new TranslateFileRequestDTO(
    'path/to/file.txt',
    'it',
    'en'
);
$response = $client->translateFile($request);
```

Output
```php
MalvikLab\LibreTranslateClient\DTO\TranslateFileResponseDTO Object
(
    [translatedFileUrl] => http://localhost:5000/download_file/72e720fe-1568-457a-a1a4-017939c9f533.file_en.txt
)
```

### Suggest
Implementation
```php
<?php

// ...

use MalvikLab\LibreTranslateClient\DTO\SuggestRequestDTO;

$request = new SuggestRequestDTO(
    'Hello world!',
    '¡Hola mundo!',
    'en',
    'es'
);
$response = $client->suggest($request);
```

Output
```php
MalvikLab\LibreTranslateClient\DTO\SuggestResponseDTO Object
(
    [success] => 1
)
```

### Frontend Settings
Implementation
```php
<?php

// ...

$response = $client->frontendSettings();
```

Output
```php
MalvikLab\LibreTranslateClient\DTO\FrontendSettingsResponseDTO Object
(
    [apiKeys] => 
    [charLimit] => -1
    [filesTranslation] => 1
    [frontendTimeout] => 500
    [keyRequired] => 
    [language] => MalvikLab\LibreTranslateClient\DTO\SettingsLanguageDTO Object
        (
            [source] => MalvikLab\LibreTranslateClient\DTO\SourceDTO Object
                (
                    [code] => auto
                    [name] => Auto Detect
                )

            [target] => MalvikLab\LibreTranslateClient\DTO\TargetDTO Object
                (
                    [code] => sq
                    [name] => Albanian
                )

        )

    [suggestions] => 1
    [supportedFilesFormat] => Array
        (
            [0] => .txt
            [1] => .odt
            [2] => .odp
            [3] => .docx
            [4] => .pptx
            [5] => .epub
            [6] => .html
        )

)
```

## Running Test
Without API Key
```sh
BASE_URL=http://localhost:5000 vendor/bin/phpunit tests --testdox
```
With API Key
```sh
BASE_URL=http://localhost:5000 API_KEY=yourApiKey vendor/bin/phpunit tests --testdox
```