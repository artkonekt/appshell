@extends($theme->layout('private'))

@section('title')
    Dropdowns
@endsection

@section('content')
    <div class="row my-4">
        <div class="col col-md-4">
            <ul class="dropdown-menu d-block position-static mx-0 shadow w-220px" data-bs-theme="light">
                <li><a class="dropdown-item d-flex gap-2 align-items-center" href="#"
                       data-alpine-devtools-right-click="">
                        {!! icon('file') !!}
                        Documents
                    </a></li>
                <li><a class="dropdown-item d-flex gap-2 align-items-center" href="#">
                        {!! icon('image') !!}
                        Photos
                    </a></li>
                <li><a class="dropdown-item d-flex gap-2 align-items-center" href="#">
                        {!! icon('play') !!}
                        Movies
                    </a></li>
                <li><a class="dropdown-item d-flex gap-2 align-items-center" href="#">
                        {!! icon('spinner') !!}
                        Music
                    </a></li>
                <li><a class="dropdown-item d-flex gap-2 align-items-center" href="#">
                        {!! icon(':)') !!}
                        Games
                    </a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item dropdown-item-danger d-flex gap-2 align-items-center" href="#">
                        {!! icon('delete') !!}
                        Trash
                    </a></li>
            </ul>
        </div>
        <div class="col col-md-4 d-flex justify-content-center">
            <ul class="dropdown-menu d-block">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
                <li><a class="dropdown-item disabled" aria-disabled="true">Disabled link</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
        </div>
        <div class="col col-md-4">
            <div class="dropdown-menu d-block position-static pt-0 mx-0 rounded-3 shadow overflow-hidden w-280px"
                 data-bs-theme="light">
                <form class="p-2 mb-2 bg-body-tertiary border-bottom" data-alpine-devtools-right-click=""><input
                        type="search" class="form-control" autocomplete="false" placeholder="Type to filter..."></form>
                <ul class="list-unstyled mb-0">
                    <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#"> <span
                                class="d-inline-block bg-success rounded-circle p-1"></span>
                            Action
                        </a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#"> <span
                                class="d-inline-block bg-primary rounded-circle p-1"></span>
                            Another action
                        </a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#"> <span
                                class="d-inline-block bg-danger rounded-circle p-1"></span>
                            Something else here
                        </a></li>
                    <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#"> <span
                                class="d-inline-block bg-info rounded-circle p-1"></span>
                            Separated link
                        </a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col col-md-6 offset-md-3">
            <div
                class="dropdown-menu position-static d-flex flex-column flex-lg-row align-items-stretch justify-content-start p-3 rounded-3 shadow-lg"
                data-bs-theme="light">
                <nav class="col-lg-8">
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="#"
                               class="btn btn-hover-light rounded-2 d-flex align-items-start gap-2 py-2 px-3 lh-sm text-start"
                               data-alpine-devtools-right-click="">
                                <svg class="bi" width="24" height="24" aria-hidden="true">
                                    <use xlink:href="#image-fill"></use>
                                </svg>
                                <div><strong class="d-block">Main product</strong> <small>Take a tour through the
                                        product</small></div>
                            </a></li>
                        <li><a href="#"
                               class="btn btn-hover-light rounded-2 d-flex align-items-start gap-2 py-2 px-3 lh-sm text-start">
                                <svg class="bi" width="24" height="24" aria-hidden="true">
                                    <use xlink:href="#music-note-beamed"></use>
                                </svg>
                                <div><strong class="d-block">Another product</strong> <small>Explore this other product
                                        we offer</small></div>
                            </a></li>
                        <li><a href="#"
                               class="btn btn-hover-light rounded-2 d-flex align-items-start gap-2 py-2 px-3 lh-sm text-start">
                                <svg class="bi" width="24" height="24" aria-hidden="true">
                                    <use xlink:href="#question-circle"></use>
                                </svg>
                                <div><strong class="d-block">Support</strong> <small>Get help from our support
                                        crew</small></div>
                            </a></li>
                    </ul>
                </nav>
                <div class="d-none d-lg-block vr mx-4 opacity-10">&nbsp;</div>
                <hr class="d-lg-none">
                <div class="col-lg-auto pe-3">
                    <nav>
                        <ul class="d-flex flex-column gap-2 list-unstyled small">
                            <li><a href="#"
                                   class="link-offset-2 link-underline link-underline-opacity-25 link-underline-opacity-75-hover">Documentation</a>
                            </li>
                            <li><a href="#"
                                   class="link-offset-2 link-underline link-underline-opacity-25 link-underline-opacity-75-hover">Use
                                    cases</a></li>
                            <li><a href="#"
                                   class="link-offset-2 link-underline link-underline-opacity-25 link-underline-opacity-75-hover">API
                                    status</a></li>
                            <li><a href="#"
                                   class="link-offset-2 link-underline link-underline-opacity-25 link-underline-opacity-75-hover">Partners</a>
                            </li>
                            <li><a href="#"
                                   class="link-offset-2 link-underline link-underline-opacity-25 link-underline-opacity-75-hover">Resources</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

    </div>
@endsection
