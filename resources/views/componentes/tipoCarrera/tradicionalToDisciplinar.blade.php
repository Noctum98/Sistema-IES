@switch($tipo)
    @case('tradicional')
        Disciplinar
        @break
    @case('tradicional2')
        Disciplinar2
        @break
    @default
        {{ ucfirst($tipo) }}
@endswitch
