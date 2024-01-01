<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Traits\DaemonTrait;

class ProcessControlPanel extends Component
{
    use DaemonTrait;

    public $processStatus = 'Loading..';
    // public $processResult = '';
    public $buttonLabel = 'Start';
    // public $buttonClasses = 'bg-green-500 hover:bg-green-700';
    public $buttonIconClass = '';

    protected $listeners = ['mrllUpdated'];

    public function toggleProcess()
    {
        // $this->buttonClasses = 'bg-gray-500 hover:bg-gray-700';
        if ($this->processStatus === 'Stopped') {
            Log::info('Enabled scheduled download of products.');
            if (preg_match('/npemwin/', config('emwin-controller.download_clients_enabled'))) {
                // Start process
                $results = $this->performDeamonCommand('start');
                $this->processStatus = $results['details']['status'];
                // $this->processResult = $results['details']['result'];
                $this->buttonLabel = 'Stop';
                // $this->buttonClasses = 'bg-red-500 hover:bg-red-700';
                $this->buttonIconClass = 'fa-stop';
            } elseif (preg_match('/(http|ftp)/', config('emwin-controller.download_clients_enabled'))) {
                // Turn on scheduled downloading
                $this->enableScheduledDownloads();
                sleep(2);
                $this->buttonLabel = 'Stop';
                $this->processStatus = 'Running';
            }
        } elseif ($this->processStatus === 'Running') {
            Log::info('Disabled scheduled download of products.');
            if (preg_match('/npemwin/', config('emwin-controller.download_clients_enabled'))) {
                // Stop process
                $results = $this->performDeamonCommand('stop');
                $this->processStatus = $results['details']['status'];
                // $this->processResult = $results['details']['result'];
                $this->buttonLabel = 'Start';
                // $this->buttonClasses = 'bg-green-500 hover:bg-green-700';
                $this->buttonIconClass = 'fa-play';
            } elseif (preg_match('/(http|ftp)/', config('emwin-controller.download_clients_enabled'))) {
                // Turn off scheduled downloading
                $this->disableScheduledDownloads();
                sleep(2);
                $this->buttonLabel = 'Start';
                $this->processStatus = 'Stopped';
            }
        } else {
            $this->processStatus = 'Error';
            // $this->processResult = 'Invalid config command';
        }
        $this->dispatchBrowserEvent('commandFinished');
    }

    /**
     * Initialize properties
     */
    public function mount()
    {
        if (preg_match('/npemwin/', config('emwin-controller.download_clients_enabled'))) {
            $results = $this->performDeamonCommand('status');
        } elseif (preg_match('/(http|ftp)/', config('emwin-controller.download_clients_enabled'))) {
            $results = $this->checkScheduledDownloads();
        }
        $this->processStatus = $results['details']['status'];
        // $this->processResult = $results['details']['result'];
        $this->buttonLabel = $this->processStatus === 'Running' ? 'Stop' : 'Start';
        // $this->buttonClasses = $this->processStatus === 'Running' ? 'bg-red-500 hover:bg-red-700' : 'bg-green-500 hover:bg-green-700';
        $this->buttonIconClass = $this->processStatus === 'Running' ? 'fa-stop' : 'fa-play';
    }

    /**
     * Render component
     */
    public function render()
    {
        return view('livewire.process-control-panel');
    }

}
