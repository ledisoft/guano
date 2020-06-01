<?php

namespace App\Console\Commands\VueI18n\Generate;

use SplFileInfo;
use ErrorException;
use RuntimeException;
use DirectoryIterator;
use InvalidArgumentException;
use Illuminate\Console\Command;

class Main extends Command
{
    /**
     * Configuration
     *
     * @var array
     */
    private $config;

    /**
     * Escape character
     *
     * @var string
     */
    private $escapeCharacter = '!';

    /**
     * Available languages
     *
     * @var array
     */
    private $availableLanguages = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vue-i18n:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a vue-i18n compatible JS array out of project translations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        /** @var array $config */
        $config = config('vue-i18n');

        if (!isset($config['exclude'])) {
            $config['exclude'] = [];
        }

        if (!isset($config['escape_character'])) {
            $config['escape_character'] = $this->escapeCharacter;
        }

        $this->config = $config;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws ErrorException
     */
    public function handle(): void
    {
        /** @var array $outputData */
        $outputData = [];

        /** @var string $outputFile */
        $outputFile = $this->config['output_file'];

        foreach ($this->languagesPath() as $languagePath) {
            /** @var SplFileInfo $languageInfo */
            $languageInfo = new SplFileInfo($languagePath);

            /** @var string $languageName */
            $languageName = $this->removePathExtension($languageInfo->getFilename());

            if (!empty($languageName)) {
                if (!in_array($languageName, $this->availableLanguages, true)) {
                    $this->availableLanguages[] = $languageName;
                }

                if ($languageInfo->isDir()) {
                    /** @var array $translations */
                    $translations = $this->allocateLanguageArray($languageInfo->getRealPath());
                } else {
                    /** @var array $translations */
                    $translations = $this->allocateLanguageJSON($languageInfo->getRealPath());

                    if ($languageInfo === null) {
                        continue;
                    }
                }

                if (!array_key_exists($languageName, $outputData)) {
                    $outputData[$languageName] = $translations;
                }
            }
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Could not generate JSON, error code: ' . json_last_error());
        }

        file_put_contents($outputFile, 'export default ' . json_encode($outputData, 64 | 128 | 256) . PHP_EOL);

        if ($this->config['output_messages']) {
            $this->info('Done! vue-i18n translation files have been successfully compiled.');
        }
    }

    /**
     * Get languages path
     *
     * @return array
     * @throws ErrorException
     */
    private function languagesPath(): array
    {
        /** @var array $paths */
        $paths = [];

        /** @var string $rootPath */
        $rootPath = $this->config['root_path'];

        if (!is_dir($rootPath)) {
            throw new ErrorException("Directory not found: {$rootPath}");
        }

        foreach (new DirectoryIterator($rootPath) as $path) {
            if (!$path->isDot()) {
                if (in_array($path->getFilename(), $this->config['exclude'], true)) {
                    continue;
                }

                $paths[] = $path->getRealPath();
            }
        }

        asort($paths);

        return $paths;
    }

    /**
     * Should exclude given file?
     *
     * @param string $file
     * @return string
     */
    private function shouldExcludeFile(string $file): string
    {
        return isset($this->config['exclude']) && in_array($file, $this->config['exclude'], true);
    }

    /**
     * Remove path extension
     *
     * @param string $path
     * @return string
     */
    private function removePathExtension(string $path): string
    {
        return pathinfo($path, PATHINFO_FILENAME);
    }

    /**
     * Allocate language array
     *
     * @param string $path
     * @return array
     */
    private function allocateLanguageArray(string $path): array
    {
        /** @var array $data */
        $data = [];

        foreach (new DirectoryIterator($path) as $file) {
            if ($file->isDot()) {
                continue;
            }

            if ($file->isDir()) {
                /** @var string $key */
                $key = $file->getFilename();

                $data[$key] = $this->allocateLanguageArray($path . DIRECTORY_SEPARATOR . $file->getFilename());
            } else {
                /** @var string $fileName */
                $fileName = $this->removePathExtension($file->getFilename());

                /** @var string $filePath */
                $filePath = $path . DIRECTORY_SEPARATOR . $file->getFilename();

                if (pathinfo($filePath, PATHINFO_EXTENSION) !== 'php') {
                    continue;
                }

                if ($this->shouldExcludeFile($fileName)) {
                    continue;
                }

                /** @var array $fileContent */
                $fileContent = include($filePath);

                if (!is_array($fileContent)) {
                    throw new RuntimeException("Unexpected data while processing {$filePath}");
                    continue;
                }

                $data[$fileName] = $this->sanitizeTranslationArray($fileContent);
            }
        }

        return $data;
    }

    /**
     * Allocate language JSON
     *
     * @param string $path
     * @return array
     */
    private function allocateLanguageJSON(string $path): array
    {
        if (pathinfo($path, PATHINFO_EXTENSION) !== 'json') {
            return null;
        }

        /** @var array $translation */
        $translation = json_decode(file_get_contents($path), true);

        if (!is_array($translation)) {
            throw new InvalidArgumentException("Unexpected data while processing {$path}");
        }

        return $this->sanitizeTranslationArray($translation);
    }

    /**
     * Remove escape character
     *
     * @param string $string
     * @return string
     */
    private function removeEscapeCharacter(string $string): string
    {
        /** @var string $escaped_escape_character */
        $escaped_escape_character = preg_quote($this->config['escape_character'], '/');

        return preg_replace_callback("/{$escaped_escape_character}(:\w+)/", static function ($matches) {
            return mb_substr($matches[0], 1);
        }, $string);
    }

    /**
     * Sanitize translation array
     *
     * @param array $array
     * @return array
     */
    private function sanitizeTranslationArray(array $array): array
    {
        /** @var array $data */
        $data = [];

        foreach ($array as $key => $value) {
            /** @var string $key */
            $key = $this->removeEscapeCharacter($this->sanitizeTranslationString($key));

            if (is_array($value)) {
                $data[$key] = $this->sanitizeTranslationArray($value);
            } else {
                $data[$key] = $this->removeEscapeCharacter($this->sanitizeTranslationString($value));
            }
        }

        return $data;
    }

    /**
     * Sanitize translation string
     *
     * @param string $string
     * @return string
     */
    private function sanitizeTranslationString(string $string): string
    {
        if (!is_string($string)) {
            return $string;
        }

        /** @var string $escaped_escape_character */
        $escaped_escape_character = preg_quote($this->config['escape_character'], '/');

        return preg_replace_callback("/(?<!mailto|tel|{$escaped_escape_character}):\w+/", static function ($matches) {
            return '{' . mb_substr($matches[0], 1) . '}';
        }, $string);
    }
}
