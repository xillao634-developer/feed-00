@props(['status'])

@php
    $badgeClasses = [
        'pending' => 'bg-warning',
        'in_progress' => 'bg-info',
        'resolved' => 'bg-success',
        'closed' => 'bg-secondary'
    ];
@endphp

{{ $badgeClasses[$status] ?? 'bg-secondary' }}