@isset($actions['edit'])
    @can($actions['edit']['can'])
        <a href="{{ route($actions['edit']['route'], $model) }}"
           class="btn btn-xs btn-outline-primary btn-show-on-tr-hover">{{ __('Edit') }}</a>
    @endcan
@endisset

@isset($actions['delete'])
    @can($actions['delete']['can'])
        {!! Form::open(['route' => [$actions['delete']['route'], $model],
                        'method' => 'DELETE',
                        'data-confirmation-text' => $actions['delete']['confirmation_text']
                        ])
                !!}
        <button class="btn btn-xs btn-outline-danger btn-show-on-tr-hover">{{ __('Delete') }}</button>
        {!! Form::close() !!}
    @endcan
@endisset
