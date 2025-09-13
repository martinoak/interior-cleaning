@props(['spz', 'size' => 'md'])

@php
    // Parse Czech license plate format
    $spzClean = strtoupper(trim($spz ?? ''));

    // Size classes
    $sizeClasses = [
        'sm' => [
            'container' => 'w-34 h-6',
            'flag' => 'w-4 h-full',
            'circle' => 'w-2 h-2',
            'cz' => 'text-[6px]',
            'text' => 'text-lg'
        ],
        'md' => [
            'container' => 'w-44 h-8',
            'flag' => 'w-6 h-full',
            'circle' => 'w-3 h-3',
            'cz' => 'text-[8px]',
            'text' => 'text-2xl'
        ]
    ];

    $classes = $sizeClasses[$size] ?? $sizeClasses['md'];

    if (preg_match('/^([\S]{1,3})\s*(\S{3,4})$/', $spzClean, $matches)) {
        $leftPart = $matches[1];
        $rightPart = $matches[2];
    } else {
        // Fallback for any format
        $parts = explode(' ', $spzClean);
        $leftPart = $parts[0] ?? '';
        $rightPart = $parts[1] ?? '';
    }
@endphp

<div class="inline-flex items-center justify-center {{ $classes['container'] }} bg-white border-2 border-black rounded-sm shadow-lg font-mono font-black tracking-wider relative overflow-hidden">
    <!-- EU Flag Section -->
    <div class="{{ $classes['flag'] }} bg-blue-600 flex flex-col items-center justify-around text-yellow-400">
        <!-- Golden Circle -->
        <div class="flex items-center justify-center">
            <div class="{{ $classes['circle'] }} border border-yellow-400 rounded-full"></div>
        </div>
        <!-- CZ Text -->
        <div class="{{ $classes['cz'] }} font-bold text-white leading-none">
            CZ
        </div>
    </div>

    <!-- License Plate Text -->
    <div class="flex-1 flex items-center justify-center {{ $classes['text'] }} text-black font-bold tracking-wide">
        <span>{{ $leftPart }}</span>
        <div class="mx-1.5 flex flex-col space-y-0.5">
            <div class="w-2 h-2 border border-gray-300 rounded-full opacity-60"></div>
            <div class="w-2 h-2 border border-gray-300 rounded-full opacity-60"></div>
        </div>
        <span>{{ $rightPart }}</span>
    </div>
</div>
