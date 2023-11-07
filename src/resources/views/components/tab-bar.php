<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link{{ $active ? ' active show' : '' }}" data-bs-toggle="tab" href="#{{ $id }}" role="tab"
           aria-controls="{{ $id }}" aria-selected="true">{{ $label }}</a>
    </li>
</ul>
<div class="tab-content">
    <div id="{{ $id }}" class="tab-pane{{ $active ? ' active show' : '' }}" role="tabpanel">
        {{ $slot }}
    </div>
</div>
