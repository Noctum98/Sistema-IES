@if($year < 2024)
     <span class="badge {{ $nota >= 4 ? 'bg-success' : 'bg-danger' }}">{{ $nota >= 0 ? $nota : 'A'}}</span>
@else
    <span class="badge {{ $nota >= 6 ? 'bg-success' : 'bg-danger' }}">{{ $nota >= 0 ? $nota : 'A'}}</span>
@endif
