<?php

namespace backend\libs\storage\classes;

/**
 * Класс реализующий "файл хранилища"
 * 
 * @author Spirkov Maksim
 */
class StorageFile
{
    /** @var string */
    private $fileName;

    /** @var string*/
    private $content;

    /** @var string путь до директории относительно корневой директории Storage */
    private $directoryPath;

    /** 
     * @param string $directoryPath путь до директории относительно корневой директории Storage
     */
    public function __construct(string $fileName, string $content = '', string $directoryPath = '')
    {
        $this->fileName = $fileName;
        $this->content = $content;
        $this->directoryPath = $directoryPath;
    }

    public function getDirectoryPath()
    {
        return $this->directoryPath;
    }

    public function getFullPath()
    {
        if ($this->directoryPath != '' && $this->directoryPath != null) {
            return $this->directoryPath . DIRECTORY_SEPARATOR . $this->fileName;
        } else {
            return $this->fileName;
        }
    }

    public function getFileExtension(): string
    {
        return pathinfo($this->fileName, PATHINFO_EXTENSION);
    }

    /** 
     * @param string $directoryPath путь до директории относительно корневой директории Storage
     */
    public function setDirectoryPath(string $directoryPath)
    {
        $this->directoryPath = $directoryPath;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }
}