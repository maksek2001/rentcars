<?php

namespace backend\libs\storage;

use backend\libs\storage\classes\StorageFile;

/**
 * Класс для работы с файловым хранилищем
 * 
 * @author Spirkov Maksim
 */
class Storage
{
    /** 
     * @var string абсолютный путь до директории, в которую будет происходит запись файлов
     * Все остальные пути, которые принимают функции, пишутся относительно этого корневого пути
     */
    public $location;

    public function __construct($location)
    {
        $this->location = static::prepareDirectoryPath($location);
    }

    /**
     * Получение полного пути до файла
     * 
     * @param string $filePath относительный путь до файла
     */
    public function getFullFilePath(string $filePath): string
    {
        $filePath = static::prepareDirectoryPath($filePath);
        $filePath = str_replace(['?', '<', '>', '"', '*', ':'], '', $filePath);

        return $this->location . DIRECTORY_SEPARATOR . $filePath;
    }

    /**
     * Получение полного пути до директории
     * По умолчанию вернёт корневую директорию
     * 
     * @param string $directoryPath относительный путь до директории
     */
    public function getFullDirectoryPath(string $directoryPath): string
    {
        return $this->location . DIRECTORY_SEPARATOR . static::prepareDirectoryPath($directoryPath);
    }

    /**
     * Подготовка пути до директории
     */
    public static function prepareDirectoryPath(string $directoryPath): string
    {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $directoryPath);
    }

    public function uploadFile(StorageFile $file): bool
    {
        $fileLocation = $this->getFullDirectoryPath($file->getDirectoryPath());

        if (!file_exists($fileLocation))
            mkdir($fileLocation, 0740, true);

        if (!is_dir($fileLocation))
            return false;

        $filePath = $this->getFullFilePath($file->getFullPath());

        if (file_put_contents($filePath, $file->getContent()) !== false)
            return true;

        return false;
    }

    /**
     * Получение содержимого файла
     * 
     * @param string $filePath относительный путь до файла
     */
    public function getFileContent(string $filePath): ?string
    {
        if (!$this->exists($filePath))
            return null;

        $filePath = $this->getFullFilePath($filePath);

        $fileContent = file_get_contents($filePath);

        return $fileContent ? $fileContent : null;
    }

    /**
     * Проверка файла на существование
     * 
     * @param string $filePath относительный путь до файла
     */
    public function exists(string $filePath): bool
    {
        $filePath = $this->getFullFilePath($filePath);

        return file_exists($filePath) && is_file($filePath);
    }

    /**
     * Удаление файла
     * 
     * @param string $filePath относительный путь до файла
     */
    public function deleteFile(string $filePath): bool
    {
        return $this->exists($filePath) ? unlink($this->getFullFilePath($filePath)) : false;
    }

    /**
     * Перемещение файла в новую директорию с удалением его из прошлой директории
     * Также есть возможность переименовать файл или оставить старое имя
     * 
     * @param string $oldFilePath старый относительный путь до файла
     * @param string $newDirectoryPath относительный путь до новой директории
     */
    public function moveFile(string $oldFilePath, string $newDirectoryPath, string $newFileName = ''): bool
    {
        // на случай, если перемещение идёт в корневую директорию
        $fullNewFilePath = ltrim($newDirectoryPath . DIRECTORY_SEPARATOR . $newFileName, DIRECTORY_SEPARATOR);

        if ($this->getFullFilePath($oldFilePath) == $this->getFullFilePath($fullNewFilePath))
            return false;

        $fileContent = $this->getFileContent($oldFilePath);

        if ($fileContent == null)
            return false;

        $fileName = $newFileName !== '' ? $newFileName : basename($oldFilePath);

        $file = new StorageFile($fileName, $fileContent, $newDirectoryPath);

        if (!$this->uploadFile($file))
            return false;

        return $this->deleteFile($oldFilePath);
    }

    /**
     * Удаление непустой директории вместе с её содержимым
     * 
     * @param string $path асболютный путь до директории
     */
    public static function deleteFolder($path)
    {
        if (substr($path, -1) == "/") {
            $pathForGlob = $path . "*";
        } else {
            $pathForGlob = $path . DIRECTORY_SEPARATOR . "*";
        }

        foreach (glob($pathForGlob) as $element) {
            if (is_dir($element)) {
                static::deleteFolder($element);
            } else {
                unlink($element);
            }
        }

        rmdir($path);
    }

    /**
     * Удаление всех папок из определённой директории, оставляя только файлы
     * 
     * @param string $path асболютный путь до директории
     */
    public static function deleteFolders($path)
    {
        if (substr($path, -1) == "/") {
            $pathForGlob = $path . "*";
        } else {
            $pathForGlob = $path . DIRECTORY_SEPARATOR . "*";
        }

        foreach (glob($pathForGlob) as $element) {
            if (is_dir($element))
                static::deleteFolder($element);
        }
    }

    /**
     * Рекурсивное удаление всех пустых директорий из определённой директории
     * 
     * @param string $path асболютный путь до директории
     */
    public static function deleteEmptyFolders($path): bool
    {
        // по умолчанию директория считается пустой
        $isFolderEmpty = true;

        if (substr($path, -1) == "/") {
            $pathForGlob = $path . "*";
        } else {
            $pathForGlob = $path . DIRECTORY_SEPARATOR . "*";
        }

        foreach (glob($pathForGlob) as $element) {
            if (is_dir($element)) {
                if (!static::deleteEmptyFolders($element))
                    $isFolderEmpty = false;
            } else {
                $isFolderEmpty = false;
            }
        }

        if ($isFolderEmpty)
            rmdir($path);

        return $isFolderEmpty;
    }
}
