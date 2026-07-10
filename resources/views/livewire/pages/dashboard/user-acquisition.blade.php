<?php

use Livewire\Volt\Component;
use App\Models\User;
use Carbon\Carbon;

new class extends Component
{
    public $viewType = 'monthly'; // 'daily', 'weekly', 'monthly', 'yearly'
    public $offset = 0;

    public function setViewType($type)
    {
        $this->viewType = $type;
        $this->offset = 0;
    }

    public function previous()
    {
        $this->offset--;
    }

    public function next()
    {
        if ($this->offset < 0) {
            $this->offset++;
        }
    }

    public function with()
    {
        $data = [];
        $labels = [];
        $totalAllTime = User::count();

        if ($this->viewType === 'daily') {
            $pointsCount = 12;
            $endDate = Carbon::now()->addDays($this->offset * $pointsCount);
            $startDate = (clone $endDate)->subDays($pointsCount - 1)->startOfDay();
            
            for ($i = 0; $i < $pointsCount; $i++) {
                $currentDay = (clone $startDate)->addDays($i);
                $labels[] = $currentDay->format('d M');
                $data[] = User::whereBetween('created_at', [
                    $currentDay->startOfDay()->toDateTimeString(),
                    $currentDay->endOfDay()->toDateTimeString()
                ])->count();
            }

        } elseif ($this->viewType === 'weekly') {
            $pointsCount = 12;
            $endDate = Carbon::now()->addWeeks($this->offset * $pointsCount)->endOfWeek();
            $startDate = (clone $endDate)->subWeeks($pointsCount - 1)->startOfWeek();
            
            for ($i = 0; $i < $pointsCount; $i++) {
                $currentWeek = (clone $startDate)->addWeeks($i);
                $labels[] = $currentWeek->format('d M');
                $data[] = User::whereBetween('created_at', [
                    $currentWeek->startOfWeek()->toDateTimeString(),
                    $currentWeek->endOfWeek()->toDateTimeString()
                ])->count();
            }

        } elseif ($this->viewType === 'monthly') {
            $pointsCount = 12;
            $endDate = Carbon::now()->addMonths($this->offset * $pointsCount)->endOfMonth();
            $startDate = (clone $endDate)->subMonths($pointsCount - 1)->startOfMonth();
            
            for ($i = 0; $i < $pointsCount; $i++) {
                $currentMonth = (clone $startDate)->addMonths($i);
                $labels[] = $currentMonth->format('M Y');
                $data[] = User::whereBetween('created_at', [
                    $currentMonth->startOfMonth()->toDateTimeString(),
                    $currentMonth->endOfMonth()->toDateTimeString()
                ])->count();
            }

        } else { // yearly
            $pointsCount = 6;
            $endDate = Carbon::now()->addYears($this->offset * $pointsCount)->endOfYear();
            $startDate = (clone $endDate)->subYears($pointsCount - 1)->startOfYear();
            
            for ($i = 0; $i < $pointsCount; $i++) {
                $currentYear = (clone $startDate)->addYears($i);
                $labels[] = $currentYear->format('Y');
                $data[] = User::whereBetween('created_at', [
                    $currentYear->startOfYear()->toDateTimeString(),
                    $currentYear->endOfYear()->toDateTimeString()
                ])->count();
            }
        }

        $periodTotal = array_sum($data);

        // Generate SVG Path
        $svgWidth = 1000;
        $svgHeight = 300;
        $paddingLeft = 60;
        $paddingRight = 60;
        $paddingTop = 40;
        $paddingBottom = 50;
        
        $chartWidth = $svgWidth - $paddingLeft - $paddingRight;
        $chartHeight = $svgHeight - $paddingTop - $paddingBottom;
        
        $n = count($data);
        $points = [];
        $maxVal = max($data);
        if ($maxVal <= 0) {
            $maxVal = 1;
        }
        
        for ($i = 0; $i < $n; $i++) {
            $x = $paddingLeft + ($i * $chartWidth / ($n - 1));
            $y = ($svgHeight - $paddingBottom) - ($data[$i] / $maxVal * $chartHeight);
            $points[] = ['x' => $x, 'y' => $y, 'val' => $data[$i], 'label' => $labels[$i]];
        }
        
        // Build smooth bezier path
        $linePath = '';
        $areaPath = '';
        
        if (count($points) > 0) {
            $linePath = "M {$points[0]['x']} {$points[0]['y']}";
            
            for ($i = 0; $i < count($points) - 1; $i++) {
                $cp1_x = $points[$i]['x'] + ($points[$i+1]['x'] - $points[$i]['x']) / 3;
                $cp1_y = $points[$i]['y'];
                $cp2_x = $points[$i]['x'] + 2 * ($points[$i+1]['x'] - $points[$i]['x']) / 3;
                $cp2_y = $points[$i+1]['y'];
                
                $linePath .= " C $cp1_x $cp1_y, $cp2_x $cp2_y, {$points[$i+1]['x']} {$points[$i+1]['y']}";
            }
            
            $baseY = $svgHeight - $paddingBottom;
            $areaPath = $linePath . " L {$points[count($points)-1]['x']} $baseY L {$points[0]['x']} $baseY Z";
        }

        // Generate Y-axis grid values
        $gridLines = [];
        $gridSteps = 4;
        for ($i = 0; $i <= $gridSteps; $i++) {
            $ratio = $i / $gridSteps;
            $y = ($svgHeight - $paddingBottom) - ($ratio * $chartHeight);
            $val = round($ratio * $maxVal);
            $gridLines[] = ['y' => $y, 'val' => $val];
        }

        return [
            'points' => $points,
            'linePath' => $linePath,
            'areaPath' => $areaPath,
            'gridLines' => $gridLines,
            'labels' => $labels,
            'periodTotal' => $periodTotal,
            'totalAllTime' => $totalAllTime,
            'svgWidth' => $svgWidth,
            'svgHeight' => $svgHeight,
            'paddingBottom' => $paddingBottom,
        ];
    }
}; ?>

<div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6 mt-6">
    <!-- Header Row -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-100 pb-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 20.03c-2.115 0-4.07-.58-5.75-1.595a4.125 4.125 0 00-5.74 3.447h16.5m-3.92-14.77a3 3 0 11-6 0 3 3 0 016 0zm-7.42 8.25a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">User Acquisition</h3>
                <p class="text-xs text-slate-400 font-medium">New user registrations over time</p>
            </div>
        </div>

        <!-- Navigation & Tabs controls combined -->
        <div class="flex items-center gap-2 bg-slate-100/80 p-1 rounded-lg border border-slate-200/20 w-full sm:w-auto justify-between sm:justify-start">
            <button wire:click="previous" class="p-1.5 hover:bg-white text-slate-500 hover:text-slate-900 rounded transition duration-150 focus:outline-none" title="Previous Period">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
            
            <div class="flex items-center gap-0.5">
                <button wire:click="setViewType('daily')" class="px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider transition duration-150 focus:outline-none {{ $viewType === 'daily' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">Daily</button>
                <button wire:click="setViewType('weekly')" class="px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider transition duration-150 focus:outline-none {{ $viewType === 'weekly' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">Weekly</button>
                <button wire:click="setViewType('monthly')" class="px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider transition duration-150 focus:outline-none {{ $viewType === 'monthly' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">Monthly</button>
                <button wire:click="setViewType('yearly')" class="px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider transition duration-150 focus:outline-none {{ $viewType === 'yearly' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">Yearly</button>
            </div>
            
            <button wire:click="next" class="p-1.5 hover:bg-white text-slate-500 hover:text-slate-900 rounded transition duration-150 focus:outline-none {{ $offset >= 0 ? 'opacity-30 cursor-not-allowed' : '' }}" {{ $offset >= 0 ? 'disabled' : '' }} title="Next Period">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Info Metrics Cards Row -->
    <div class="grid grid-cols-3 border-b border-slate-100 py-4 mb-4">
        <div class="border-r border-slate-100 px-4">
            <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Period Total</div>
            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $periodTotal }}</div>
        </div>
        <div class="border-r border-slate-100 px-4">
            <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">All Time</div>
            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalAllTime }}</div>
        </div>
        <div class="px-4">
            <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">View</div>
            <div class="text-sm font-semibold text-indigo-600 mt-2 capitalize">{{ $viewType }}</div>
        </div>
    </div>

    <!-- Chart Visualizer -->
    <div class="relative w-full overflow-x-auto select-none pt-4">
        <div class="min-w-[700px] w-full h-[300px]">
            <svg viewBox="0 0 {{ $svgWidth }} {{ $svgHeight }}" class="w-full h-full overflow-visible">
                <defs>
                    <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#4f46e5" stop-opacity="0.18" />
                        <stop offset="100%" stop-color="#4f46e5" stop-opacity="0.0" />
                    </linearGradient>
                </defs>

                <!-- Grid Y-axis horizontal lines -->
                @foreach($gridLines as $grid)
                    <line x1="60" y1="{{ $grid['y'] }}" x2="{{ $svgWidth - 60 }}" y2="{{ $grid['y'] }}" stroke="#f1f5f9" stroke-width="1" />
                    <text x="45" y="{{ $grid['y'] + 4 }}" fill="#94a3b8" font-size="10" font-weight="600" text-anchor="end">{{ $grid['val'] }}</text>
                @endforeach

                <!-- Chart Paths -->
                @if(!empty($linePath))
                    <!-- Gradient Area Fill -->
                    <path d="{{ $areaPath }}" fill="url(#chartGradient)" />
                    
                    <!-- Line path -->
                    <path d="{{ $linePath }}" fill="none" stroke="#4f46e5" stroke-width="3" stroke-linecap="round" />
                @endif

                <!-- Data point circles -->
                @foreach($points as $idx => $pt)
                    <g class="group/point cursor-pointer">
                        <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="5" fill="#ffffff" stroke="#4f46e5" stroke-width="3" class="transition-all duration-150 hover:r-7" />
                        <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="12" fill="transparent" />
                        
                        <!-- Mini Tooltip on hover -->
                        <g class="opacity-0 group-hover/point:opacity-100 transition-opacity duration-150 pointer-events-none">
                            <rect x="{{ $pt['x'] - 25 }}" y="{{ $pt['y'] - 35 }}" width="50" height="22" rx="4" fill="#1e293b" />
                            <text x="{{ $pt['x'] }}" y="{{ $pt['y'] - 20 }}" fill="#ffffff" font-size="10" font-weight="bold" text-anchor="middle">{{ $pt['val'] }}</text>
                        </g>
                    </g>
                @endforeach

                <!-- X-Axis Labels -->
                @foreach($points as $idx => $pt)
                    <text x="{{ $pt['x'] }}" y="{{ $svgHeight - 15 }}" fill="#94a3b8" font-size="10" font-weight="600" text-anchor="middle">{{ $pt['label'] }}</text>
                @endforeach
            </svg>
        </div>
    </div>
</div>
