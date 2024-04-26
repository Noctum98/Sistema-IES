@switch($tipo)
    @case('tradicional')
        Disciplinar
        @break
    @case('tradicional2')
        Disciplinar 70/30
        @break
    @case('modular2')
        Modular 70/30
        @break
    @default
        {{ ucfirst($tipo) }}
@endswitch
