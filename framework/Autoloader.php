<?php

class Autoloader
{
    protected $baseDir = __DIR__;
    protected $jsonFile = '';
    protected $directories = array();
    protected $psr4entries = array();

    public function __construct($jsonFile = 'autoload.json')
    {
        $this->jsonFile = $this->makeAbsoluteDir($jsonFile);
        $this->directories = $this->loadDirectories($this->jsonFile);
        $this->psr4entries = $this->loadPsr4Entries($this->jsonFile);
    }

    public function autoload($className)
    {
        //PSR4
        $className = ltrim($className, "\\");
        foreach ($this->psr4entries as $namespace => $directory) {
            if (strpos($className, $namespace) === 0) {
                $restNamespacePart = ltrim(str_replace($namespace, '', $className), "\\");
                $restDir = str_replace("\\", DIRECTORY_SEPARATOR, $restNamespacePart);
                
                require_once join(DIRECTORY_SEPARATOR, array($this->baseDir, $directory, $restDir)) . '.php';
                break;
            }
        }

        //Directory
        foreach ($this->directories as $dir) {
            if ($this->autoloadFromDir($className, $this->makeAbsoluteDir($dir))) {
                break;
            }
        }
    }

    public function autoloadFromDir($className, $directory)
    {
        if (file_exists($this->makeAbsoluteDir($className . '.php', $directory))) {
            require_once $this->makeAbsoluteDir($className . '.php', $directory);
        } else {
            return false;
        }

       return true; 
    }
    
    public function loadPsr4Entries($jsonFile)
    {
        $autoloadJson = json_decode(file_get_contents($jsonFile), true);
        $psr4Entries = $autoloadJson['psr4'];
        
        foreach ($psr4Entries as $namespace => $directory) {
            $psr4Entries[$namespace] = rtrim($directory, "\\");
        }
        
        return $psr4Entries;
    }
    
    public function setBaseDir($baseDir)
    {
        $this->baseDir = $baseDir;
        return $this;
    }

    protected function loadDirectories($file)
    {
        $autoload = json_decode(file_get_contents($file), true);
        
        foreach ($autoload['directory'] as &$autoloadDir) {
            $autoloadDir = ltrim($autoloadDir, DIRECTORY_SEPARATOR);
        }
        
        return $autoload['directory'];
    }

    protected function makeAbsoluteDir($directory, $baseDirectory = '')
    {
        $baseDirectory = empty($baseDirectory) ? $this->baseDir : $baseDirectory;
        return join(DIRECTORY_SEPARATOR, array($baseDirectory, $directory));
    }

}

$autoloader = new Autoloader();
spl_autoload_register(array($autoloader, 'autoload'));
