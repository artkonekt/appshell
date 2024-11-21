<div class="mb-3">
    <div @class(['input-group input-group-lg', 'has-validation' => $errors->has('name')])>
        <span class="input-group-text">{!! icon('zone') !!}</span>
        <x-appshell::floating-label :label="__('Name')" :is-invalid="$errors->has('name')">
            {{ Form::text('name', null, [
                    'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                    'placeholder' => __('Name of the country')
                ])
            }}
        </x-appshell::floating-label>
        @if ($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="mb-3 row">
    <label for="code" class="col-form-label col-form-label-sm col-md-2">{{ __('Code') }}</label>
    <div class="col-md-10">
        {{ Form::text('code', null, [
                'class' => 'form-control form-control-sm' . ($errors->has('code') ? ' is-invalid': ''),
                'placeholder' => __('Enter the province code (e.g., HR, BE)'),
                'oninput' => 'this.value = this.value.toUpperCase()',
                'maxlength' => 16,
                'id' => 'code',
            ])
        }}
        @if ($errors->has('code'))
            <div class="invalid-feedback">{{ $errors->first('code') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row">
    <label for="type" class="col-form-label col-form-label-sm col-md-2">{{ __('Type') }}</label>
    <div class="col-md-10">
        {{ Form::select('type', $types, old('type', $province->type->value() ?? null), [
                'class' => 'form-select form-select-sm' . ($errors->has('type') ? ' is-invalid': ''),
                'placeholder' => __('Choose a type'),
                'id' => 'type'
           ])
        }}
        @if ($errors->has('type'))
            <div class="invalid-feedback">{{ $errors->first('type') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row">
    <label for="parent_id" class="col-form-label col-form-label-sm col-md-2">{{ __('Parent') }}</label>
    <div class="col-md-10">
        {{ Form::select('parent_id', $provinces->pluck('name', 'id'), null, [
                'class' => 'form-select form-select-sm' . ($errors->has('parent_id') ? ' is-invalid': ''),
                'placeholder' => __('No parent'),
                'id' => 'parent_id'
           ])
        }}
        @if ($errors->has('parent_id'))
            <div class="invalid-feedback">{{ $errors->first('parent_id') }}</div>
        @endif
    </div>
</div>
