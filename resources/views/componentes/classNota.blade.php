@if($year < 2024)
    {{ $nota < 4 ?  'text-danger':'text-success'}}
@else
    {{ $nota < 6 ?  'text-danger':'text-success'}}
@endif

