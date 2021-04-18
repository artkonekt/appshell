<form action="{{ route($route) }}" class="form-inline">

    @foreach($filters as $filter)
        {!! $filter->render() !!}</span>
    @endforeach

{{--    {!! Form::select('projects[]', $projects, $filteredProjects ? $filteredProjects->first()->id : null, ['class' => 'form-control form-control-sm', 'placeholder' => __('All projects')]) !!}--}}
{{--    &nbsp;--}}
{{--    {!! Form::select('status', $statuses, $filteredStatuses ? $filteredStatuses[0] : null, ['class' => 'form-control form-control-sm', 'placeholder' => __('Any status')]) !!}--}}
{{--    &nbsp;--}}
{{--    {!! Form::select('users[]', $users, $filteredUsers ? $filteredUsers[0]->id : null, ['class' => 'form-control form-control-sm', 'placeholder' => __('All users')]) !!}--}}
    &nbsp;
    <button class="btn btn-sm btn-primary" type="submit">{{ __('Filter') }}</button>
</form>
