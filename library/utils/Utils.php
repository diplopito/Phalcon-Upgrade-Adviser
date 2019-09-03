<?php

class Utils
{
    public function getPhpFiles(string $dir, array &$phpFiles = [])
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (is_file($path)) {
                if (substr(strtolower($path), -4) == ".php") {
                    $phpFiles[] = $path;
                }
            } else if ($value != "." && $value != ".." && $value != "vendor" && $value != ".git") {
                $this->getPhpFiles($path, $phpFiles);
                if (substr(strtolower($path), -4) == ".php") {
                    $phpFiles[] = $path;
                }
            }
        }
        return;
    }
}


