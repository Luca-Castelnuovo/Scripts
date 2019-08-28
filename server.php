<?php

require __DIR__ . '/vendor/autoload.php';

$configKey = getenv('CONFIG_KEY');
$configClient = new \ConfigCat\ConfigCatClient($configKey);

if (!$configClient->getValue("appActive", true)) {
    http_response_code(503);
    exit('App is temporarily disabled.');
}

class Server
{
    private $scriptID;

    public function __construct($scriptID)
    {
        $this->scriptID = $scriptID;
    }

    private function scandir() {
        $scriptList = scandir(__DIR__ . '/scripts');
        
        unset($scriptList[0]);
        unset($scriptList[1]);

        return $scriptList;
    }

    private function listScripts() {
        echo json_encode($this->scandir());
        exit;
    }

    private function requireScript($scriptID) {
        $scripts = $this->scandir();

        if (!array_key_exists($scriptID, $scripts)) {
            $this->listScripts();
        }

        require __DIR__ . "/scripts/{$scripts[$scriptID]}";
    }

    public function start() {
        if (empty($this->scriptID)) {
            $this->listScripts();
        }

        $this->requireScript($this->scriptID);
    }
}
