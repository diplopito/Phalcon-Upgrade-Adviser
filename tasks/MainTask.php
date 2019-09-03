<?php

use Phalcon\Cli\Task;

class MainTask extends Task
{   
    private $logFile;
    
    public function mainAction()
    {        
        echo "Upgrader from Phalcon 3.x to 4.x ready.\nRun the app with the path to your Application or a single file, i.e.:\n";
        echo "php cli.php Main createLog path/to/my/file.php";
    }

    public function createLogAction(string $path, string $logFile = "upgraderLog.txt")
    {
        if (empty($path)) {
            echo "Please provide the path to the Application";
            exit;
        }

        if (is_file($path)) {
            echo $this->logPhalconClassesState($path);
            exit;
        }

        $this->logFile = $logFile;

        $this->controlPhpFiles($path);
    }

    private function controlPhpFiles($path)
    {
        $phpFiles = $this->getPhpFiles($path);
        $this->processPhpFiles($phpFiles);
    }

    private function getPhpFiles(string $path)
    {
        $utils = new Utils();
        $files = [];
        $utils->getPhpFiles($path, $files);

        if (count($files) == 0) {
            echo "No PHP files found in folder $path";
            exit;                
        }

        return $files;       
    }

    private function processPhpFiles(array $files)
    {
        $log = "";

        foreach ($files as $file) {
            $log .= $this->logPhalconClassesState($file);
        }

        $this->writeLog($log);

        echo "Check '{$this->logFile}' to review the necessary changes for upgrading";
    }

    private function logPhalconClassesState(string $file)
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

        if (count($classes) == 0) {
            return $file . ":\nNo Phalcon classes found\n\n";
        }

        return $file . ":\n" . $this->checkClassState($classes) . "\n\n";

    }

    private function checkClassState(array $classes)
    {
        $log = "";

        foreach ($classes as $class) {
            if (isset(Phalcon3to4::CLASSES[$class])) {
                $log .= $class . " => " . Phalcon3to4::CLASSES[$class] . "\n";
            } elseif (strpos($class, "::") > 0) {
                $log .= $class . " => Check changes in constant\n";
            } else {
                $log .= $class . " => No changes (Might need to check types)\n";
            }
        }

        return $log;
    }

    private function writeLog(string $log)
    {
        file_put_contents($this->logFile, $log);
    }
}
