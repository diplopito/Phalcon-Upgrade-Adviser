<?php

use Phalcon\Cli\Task;

class MainTask extends Task
{      
    public function mainAction()
    {        
        echo "Upgrade Adviser from Phalcon 3.x to 4.x ready.\n" .
        "Run the app with the path to your Application or a single file, i.e.:\n" .
        "php cli.php Main createLog path/to/my/file.php\n";
    }

    public function createLogAction(string $path, string $logFile = "upgradeLog.txt")
    {
        if (empty($path)) {
            echo "Please provide the path to the Application";
            exit;
        }

        if (is_file($path)) {
            echo $this->logPhalconClassesState($path);
            exit;
        }

        $phpFiles = $this->getPhpFiles($path);

        $log = $this->processPhpFiles($phpFiles);

        file_put_contents($logFile, $log);

        echo "Check '{$logFile}' to review the necessary changes to upgrade\n";

    }

    private function getPhpFiles(string $path): array
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

    private function processPhpFiles(array $files): string
    {
        $log = "";

        foreach ($files as $file) {
            $log .= $this->logPhalconClassesState($file);
        }

        return $log;
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
            if (isset(Phalcon3to4::CLASSES_V3[$class])) {
                $log .= $class . " => " . Phalcon3to4::CLASSES_V3[$class] . "\n";
            } elseif (strpos($class, "::") > 0) {
                $log .= $class . " => Check possible changes in constant\n";
            } elseif (isset(Phalcon3to4::CLASSES_V4[$class])) {
                $log .= $class . " => Upgraded. New in v4\n";
            } else {
                $log .= $class . " => No changes (Might need to check types)\n";
            }
        }

        return $log;
    }
}
<?php

use Phalcon\Cli\Task;

class MainTask extends Task
{      
    public function mainAction()
    {        
        echo "Upgrade Adviser from Phalcon 3.x to 4.x ready.\n" .
        "Run the app with the path to your Application or a single file, i.e.:\n" .
        "php cli.php Main createLog path/to/my/file.php\n";
    }

    public function createLogAction(string $path, string $logFile = "upgradeLog.txt")
    {
        if (empty($path)) {
            echo "Please provide the path to the Application";
            exit;
        }

        if (is_file($path)) {
            echo $this->logPhalconClassesState($path);
            exit;
        }

        $phpFiles = $this->getPhpFiles($path);

        $log = $this->processPhpFiles($phpFiles);

        file_put_contents($logFile, $log);

        echo "Check '{$logFile}' to review the necessary changes to upgrade\n";

    }

    private function getPhpFiles(string $path): array
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

    private function processPhpFiles(array $files): string
    {
        $log = "";

        foreach ($files as $file) {
            $log .= $this->logPhalconClassesState($file);
        }

        return $log;
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
            if (isset(Phalcon3to4::CLASSES_V3[$class])) {
                $log .= $class . " => " . Phalcon3to4::CLASSES_V3[$class] . "\n";
            } elseif (strpos($class, "::") > 0) {
                $log .= $class . " => Check possible changes in constant\n";
            } elseif (isset(Phalcon3to4::CLASSES_V4[$class])) {
                $log .= $class . " => Upgraded. New in v4\n";
            } else {
                $log .= $class . " => No changes (Might need to check types)\n";
            }
        }

        return $log;
    }
}
