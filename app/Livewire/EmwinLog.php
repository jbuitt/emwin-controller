<?php

namespace App\Livewire;

use Livewire\Component;

class EmwinLog extends Component
{
    public $lastTenLogLines = 'Loading...<br /><br /><br /><br /><br /><br /><br /><br /><br />';

    public function getLogLines()
    {
        $logFile = base_path() . '/storage/logs/laravel-' . date('Y-m-d') . '.log';
        if (file_exists($logFile)) {
            $this->lastTenLogLines = shell_exec('tail ' . $logFile);
        } else {
            $this->lastTenLogLines = 'The file ' . $logFile . ' was not found.<br /><br /><br /><br /><br /><br /><br /><br /><br />';
        }
    }

    public function render()
    {
        return view('livewire.emwin-log');
    }
}
