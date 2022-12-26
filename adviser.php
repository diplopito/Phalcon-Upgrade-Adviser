<?php

class Adviser
{
    private $path;
    private $phalconClasses;
    private $logFile;

    public function __construct(array $phalconClasses, string $path, string $logFile = "upgradeLog.txt") {
        $this->phalconClasses = $phalconClasses;
        $this->path = $path;
        $this->logFile = $logFile;
    }
    
    public function createLogAction()
    {
        if (empty($this->path)) {
            die("Please provide the path to the Application");
        }

        if (is_file($this->path)) {
            die($this->logPhalconClassesState($this->path));
        }

        $phpFiles = [];

        $this->getPhpFiles($this->path, $phpFiles);

        $log = $this->processPhpFiles($phpFiles);

        file_put_contents($this->logFile, $log);

        echo "Check '$this->logFile' to review the necessary changes to upgrade\n";

    }

    public function travelPhpFiles(string $path): array
    {
        $files = [];

        $this->getPhpFiles($path, $files);

        if (count($files) == 0) {
            die("No PHP files found in folder $path");            
        }

        return $files;       
    }

    private function processPhpFiles(array $files): string
    {
        $log = "";

        foreach ($files as $file) {
            $log .= $this->logPhalconClassesState($file);
        }

        return $log;
    }

    private function getPhpFiles(string $dir, array &$phpFiles = [])
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);

            if (is_file($path)) {
                if (pathinfo($path, PATHINFO_EXTENSION) === "php") {
                    $phpFiles[] = $path;
                }
            } else if ($value != "." && $value != ".." && $value != "vendor" && $value != ".git") {
                $this->getPhpFiles($path, $phpFiles);
                if (pathinfo($path, PATHINFO_EXTENSION) === "php") {
                    $phpFiles[] = $path;
                }
            }
        }
    }

    private function logPhalconClassesState(string $file): string
    {       
        try {
            $fn = fopen($file, "r");
        } catch (exception $e) {
            return "Error opening $file => " . $e->getMessage() . ";\n";
        }       

        $classes = [];

        while(! feof($fn)) {           
            if (preg_match("/Phalcon\\\([^\s;(]+)/", fgets($fn), $match)) {
                $classes[] = $match[0];
            } 
        }

        fclose($fn);

        if (count($classes) == 0) {
            return $file . ":\nNo Phalcon classes found\n\n";
        }

        return $file . ":\n" . $this->checkClassState($classes) . "\n\n";
    }

    private function checkClassState(array $classes):string
    {
        $log = "";

        foreach ($classes as $class) {
            if (isset($this->phalconClasses[$class])) {
                $log .= $class . " => " . $this->phalconClasses[$class] . "\n";
            } elseif (strpos($class, "::") > 0) {
                $log .= $class . " => Check possible changes in constant\n";
            } else {
                $log .= $class . " => No changes\n";
            }
        }

        return $log;
    }
}