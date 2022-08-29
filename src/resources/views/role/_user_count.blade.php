<span class="badge rounded-pill bg-secondary"
      title="{{
    trans_choice(
        '{0} ' .
        __('Not assigned to any user')
        . '|[1] ' .
        __('Assigned to one user')
        . '|[2,*]' .
        __('Assigned to :n users', ['n' => $count]),
        $count
    )
}}">{{ $count }}</span>
