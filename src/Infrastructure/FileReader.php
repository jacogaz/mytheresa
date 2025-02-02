<?php

namespace App\Infrastructure;

class FileReader
{

    public function __construct(private string $filePath)
    {
    }

    public function readJsonFile(): array
    {
        if (!file_exists($this->filePath)) {
            throw new \RuntimeException("El archivo no existe: {$this->filePath}");
        }

        $fileContents = file_get_contents($this->filePath);
        if ($fileContents === false) {
            throw new \RuntimeException("No se pudo leer el archivo: {$this->filePath}");
        }

        $data = json_decode($fileContents, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("Error al decodificar el JSON: " . json_last_error_msg());
        }

        return $data;
    }
}
