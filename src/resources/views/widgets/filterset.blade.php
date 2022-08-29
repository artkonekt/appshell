@php
  $filterFormId = 'filterForm' . mt_rand();
@endphp
<div class="dropdown filterset">
    @if($filters->activeCount() > 0)
        <span class="position-relative" title="{{ __('Filters') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {!! icon('filters', null, ['class' => 'btn']) !!}
            <small class="position-absolute" style="left: 25px; top: -7px"><span class="badge rounded-pill bg-danger">{{ $filters->activeCount() }}</span></small>
        </span>
    @else
        {!! icon('filters', null, [
                'class' => 'btn',
                'data-toggle' => 'dropdown',
                'aria-haspopup' => 'true',
                'aria-expanded' => 'false',
                'title' => __('Filters'),
            ])
        !!}
    @endif

    <div class="dropdown-menu dropdown-menu-right filterset-dropdown-of-{{ count($filters) < 7 ? count($filters) : 'many' }}">
        <form action="{{ route($route) }}" class="m-3" id="{{ $filterFormId }}">

            <div class="form-group">
                <div class="form-row">
                    @foreach($widgets as $widget)
                        <div class="col">
                            {!! $widget->render() !!}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="filterset-button-holder">
                <button class="btn btn-sm btn-outline-secondary" type="button" onclick="window.location.href=this.form.action">{{ __('Reset') }}</button>
                <button class="btn btn-sm btn-primary" type="submit">{{ __('Filter') }}</button>
            </div>
        </form>
    </div>
</div>
@once
    @push('onload-scripts')
        /* Removes unused fields from query string */
        function submitAppShellFilter(event) {
            event.preventDefault();
            const form = event.target;
            let url = new URL(form.action);
            Array.from(form.elements).forEach((field) => {
                if ('' != field.name && '' != field.value) {
                    if ("selectedOptions" in field && field.selectedOptions.length > 1) {
                        Array.from(field.selectedOptions).forEach((option) => {
                            url.searchParams.append(field.name, option.value);
                        });
                    } else {
                        url.searchParams.append(field.name, field.value);
                    }
                }
            });

            window.location = url.toString();
        }
    @endpush
@endonce
@push('onload-scripts')
  document.getElementById("{{ $filterFormId }}").addEventListener("submit", submitAppShellFilter);
@endpush
