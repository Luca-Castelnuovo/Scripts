<?php

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
