<?php

use Livewire\Volt\Component;

new class extends Component
{
    public $updateOutput = '';
    public $isUpdating = false;
    public $currentCommit = '';
    public $currentBranch = '';
    public $currentCommitMessage = '';
    public $currentCommitTime = '';

    public function mount()
    {
        $this->loadCurrentCommit();
    }

    public function loadCurrentCommit()
    {
        try {
            $basePath = base_path();
            $commitHash = shell_exec('git -c safe.directory="' . $basePath . '" rev-parse --short HEAD');
            $commitMessage = shell_exec('git -c safe.directory="' . $basePath . '" log -1 --pretty=%B');
            $branch = shell_exec('git -c safe.directory="' . $basePath . '" rev-parse --abbrev-ref HEAD');
            $commitDate = shell_exec('git -c safe.directory="' . $basePath . '" log -1 --date=format:"%Y-%m-%d %H:%M:%S" --pretty=%cd');
            $commitRelative = shell_exec('git -c safe.directory="' . $basePath . '" log -1 --date=relative --pretty=%cd');
            
            if ($commitHash) {
                $this->currentBranch = trim($branch) . ' @ ' . trim($commitHash);
                $this->currentCommitMessage = trim(strtok($commitMessage, "\n"));
                $this->currentCommitTime = trim($commitDate) . ' (' . trim($commitRelative) . ')';
                $this->currentCommit = $this->currentBranch . ' - ' . $this->currentCommitMessage . ' - ' . $this->currentCommitTime;
            } else {
                $this->currentBranch = 'Unknown';
                $this->currentCommitMessage = 'Git not initialized or not accessible';
                $this->currentCommitTime = 'N/A';
                $this->currentCommit = 'Unknown';
            }
        } catch (\Exception $e) {
            $this->currentBranch = 'Error';
            $this->currentCommitMessage = $e->getMessage();
            $this->currentCommitTime = 'Error';
            $this->currentCommit = 'Error loading commit info';
        }
    }

    public function updateSite()
    {
        $this->isUpdating = true;
        $this->updateOutput = "Starting update process...\n\n";

        $basePath = base_path();

        // Commands to run
        $commands = [
            'git -c safe.directory="' . $basePath . '" reset --hard HEAD 2>&1',
            'git -c safe.directory="' . $basePath . '" pull origin main 2>&1',
            'php artisan migrate --force 2>&1',
            'php artisan optimize:clear 2>&1',
        ];

        $output = [];
        foreach ($commands as $command) {
            $output[] = "$ " . $command;
            $cmdOutput = [];
            $status = null;
            exec("cd " . base_path() . " && " . $command, $cmdOutput, $status);
            $output[] = implode("\n", $cmdOutput);
            $output[] = "Exit Code: " . $status . "\n";
        }

        $this->updateOutput .= implode("\n", $output);

        $this->loadCurrentCommit();
        $this->isUpdating = false;
        
        session()->flash('update_message', 'Update process completed.');
    }
}
?>

<div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6 mt-6">
    <div class="flex items-center gap-2 pb-4 mb-5 border-b border-slate-100">
        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 15H18" />
        </svg>
        <h2 class="text-base font-bold text-slate-800">System Actions & Git Updates</h2>
    </div>
    
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-6">
        <div class="max-w-xl">
            <span class="text-sm font-semibold text-slate-800">Git Repository Deployment</span>
            <p class="text-slate-500 text-xs mt-1 leading-relaxed">
                Pull the latest updates from the remote GitHub branch, automatically execute database migrations, and clear cache bundles to deploy changes.
            </p>
        </div>
        <div class="text-xs font-mono bg-slate-50 border border-slate-200/60 rounded-xl p-4 flex flex-col gap-2 min-w-[280px] md:min-w-[340px] shadow-sm">
            <div class="flex items-center">
                <span class="text-[10px] uppercase font-bold text-slate-400 w-28">Current Branch:</span>
                <span class="text-indigo-600 font-semibold truncate">{{ $currentBranch }}</span>
            </div>
            <div class="flex items-center">
                <span class="text-[10px] uppercase font-bold text-slate-400 w-28">Latest Commit:</span>
                <span class="text-slate-700 truncate">"{{ $currentCommitMessage }}"</span>
            </div>
            <div class="flex items-center">
                <span class="text-[10px] uppercase font-bold text-slate-400 w-28">Timestamp:</span>
                <span class="text-emerald-600 truncate">{{ $currentCommitTime }}</span>
            </div>
        </div>
    </div>

    @if (session()->has('update_message'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg text-sm mb-5 flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('update_message') }}</span>
        </div>
    @endif

    <div class="flex flex-col gap-4">
        <div>
            <button 
                wire:click="updateSite" 
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-400 text-white font-semibold text-xs uppercase tracking-wider rounded-lg shadow transition duration-150 ease-in-out cursor-pointer"
            >
                <svg wire:loading.remove wire:target="updateSite" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 15H18" />
                </svg>
                <!-- Loading spinner -->
                <svg wire:loading wire:target="updateSite" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="updateSite">Update from GitHub</span>
                <span wire:loading wire:target="updateSite">Updating Site...</span>
            </button>
        </div>

        @if ($updateOutput)
            <div class="mt-2">
                <label class="block font-semibold text-xs text-slate-700 uppercase tracking-wider mb-2">Console Log Output:</label>
                <pre class="bg-slate-900 border border-slate-800 text-emerald-400 p-4 rounded-xl font-mono text-xs overflow-x-auto max-h-[300px] overflow-y-auto leading-relaxed shadow-inner">{{ $updateOutput }}</pre>
            </div>
        @endif
    </div>
</div>
