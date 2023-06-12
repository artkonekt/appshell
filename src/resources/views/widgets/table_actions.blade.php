@isset($actions['edit'])
    @can($actions['edit']['can'])
        <a href="{{ route($actions['edit']['route'], $model) }}"
           class="btn btn-sm btn-outline-primary btn-show-on-tr-hover float-right" title="{{ __('Edit') }}">
            {!! icon('edit') !!}
        </a>
    @endcan
@endisset

@isset($actions['delete'])
    @can($actions['delete']['can'])
        {!! Form::open(['route' => [$actions['delete']['route'], $model],
                        'method' => 'DELETE',
                        'data-confirmation-text' => $actions['delete']['confirmation_text'],
                        'class' => 'd-inline',
                        ])
                !!}
        <button class="btn btn-sm btn-outline-danger btn-show-on-tr-hover" title="{{ __('Delete') }}">
            {!! icon('delete') !!}
        </button>
        {!! Form::close() !!}
    @endcan
@endisset
