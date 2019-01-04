<!DOCTYPE html>
<html>
<head>
    <base href="{{ route('') }}/">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow, noarchive, noodp, NoImageIndex, noydir">
    <title>{{ env('APP_NAME') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link href="{{ asset('lib/bs/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('lib/fa/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('lib/adminlte/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('lib/adminlte/css/skins/skin-blue-light.min.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('css/firefly.css') }}" rel="stylesheet" type="text/css"/>

    {# Extra CSS for the demo: #}
    {% if not shownDemo %}
    <link href="v1/lib/intro/introjs.min.css?v={{ FF_VERSION }}" rel="stylesheet" type="text/css"/>
    {% endif %}

    {# Any local custom CSS. #}
    {% block styles %}{% endblock %}
    <!--[if lt IE 9]>
    <script src="v1/js/lib/html5shiv.min.js?v={{ FF_VERSION }}"></script>
    <script src="v1/js/lib/respond.min.js?v={{ FF_VERSION }}"></script>
    <![endif]-->

    {# this entry is in the header so it's loaded early #}
    {# SHA256: C45493A8175B10AC47EEDFC7C20AC31FAE5C804FB6C4F75468DB0F95112664BF #}
    <script type="text/javascript">var forceDemoOff = false;</script>

    {# favicons #}
    {% include('partials.favicons') %}

</head>
<body class="skin-blue-light sidebar-mini hold-transition">
<div class="wrapper" id="app">

    <header class="main-header">

        {# Logo #}
        <a href="{{ route('index') }}" class="logo">
            {# mini logo for sidebar mini 50x50 pixels #}
            <span class="logo-mini">FF</span>
            {# logo for regular state and mobile devices #}
            <span class="logo-lg"><b>Firefly</b>III</span>
        </a>

        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">{{ 'toggleNavigation'|_ }}</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <li class="hidden-sm hidden-xs">
                        <a href="#" id="help" data-route="{{ original_route_name }}"
                           data-extra="{{ what|default("") }}">
                            <i class="fa fa-question-circle" data-route="{{ original_route_name }}"
                               data-extra="{{ what|default("") }}"></i>
                        </a>
                    </li>

                    <li>
                        <span style="color:#fff;padding: 15px;display: block;line-height: 20px;">
                            <span id="daterange"></span>
                        </span>
                    </li>

                    {% if not SANDSTORM %}
                    <li class="dropdown user user-menu">
                        <span style="cursor:default;color:#fff;padding: 15px;display: block;line-height: 20px;">
                            <span class="hidden-xs">{{ Auth.user.email }}</span>
                        </span>
                    </li>
                    {% endif %}
                    <li id="sidebar-toggle">
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-plus-circle"></i></a>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <form action="{{ route('search.index') }}" method="get" class="sidebar-form">
                <div class="input-group">
                    <input autocomplete="off" type="text" name="q" class="form-control"
                           placeholder="{{ 'searchPlaceholder'|_ }}" value="{{ query }}"/>
                    <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i
                        class="fa fa-search"></i></button>
              </span>
                </div>
            </form>
            {% include('partials.menu-sidebar') %}
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            {% include('partials.page-header') %}
            {% block breadcrumbs %}{% endblock %}
        </section>

        <section class="content">
            {% if IS_DEMO_SITE %}
            <div class="row no-print">
                <div class="col-lg-12">
                    <p class="well">
                        {% include ['demo.' ~ Route.getCurrentRoute.getName, 'demo.no-demo-text'] %}
                    </p>
                </div>
            </div>
            {% endif %}

            {% include('partials.flashes') %}

            {% block content %}{% endblock %}
        </section>
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>{{ 'version'|_ }}</b> <a href="{{ route('debug') }}">{{ Config.get('firefly.version') }}</a>
        </div>
        <strong><a href="https://github.com/firefly-iii/firefly-iii">Firefly III</a></strong>
    </footer>

    {% include('partials.control-bar') %}

</div>
<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="helpModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="helpTitle">&nbsp;</h4>
            </div>
            <div class="modal-body" id="helpBody">&nbsp;</div>
            <div class="modal-footer">
                <small class="pull-left">
                    {{ 'need_more_help'|_ }}
                </small>
                <br/>
                <small class="pull-left">
                    {{ trans('firefly.reenable_intro_text')|raw }}
                </small>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ 'close'|_ }}</button>
            </div>
        </div>
    </div>
</div>

{# Java libraries and stuff: #}

{# Moment JS #}
<script src="v1/js/lib/moment.min.js?v={{ FF_VERSION }}" type="text/javascript"></script>
<script src="v1/js/ff/moment/{{ language }}.js?v={{ FF_VERSION }}" type="text/javascript"></script>

{# All kinds of variables. #}
<script
    src="{{ route('javascript.variables') }}?ext=.js&amp;v={{ FF_VERSION }}{% if account %}&amp;account={{ account.id }}{% endif %}"
    type="text/javascript"></script>

{# big fat JS thing courtesy of Vue#}
<script src="v1/js/app.js?v={{ FF_VERSION }}" type="text/javascript"></script>

{# date range picker, current template, etc.#}
<script src="v1/js/lib/daterangepicker.js?v={{ FF_VERSION }}" type="text/javascript"></script>
<script src="v1/lib/adminlte/js/adminlte.min.js?v={{ FF_VERSION }}" type="text/javascript"></script>
<script type="text/javascript" src="v1/js/lib/accounting.min.js?v={{ FF_VERSION }}"></script>

{# Firefly III code#}
<script type="text/javascript" src="v1/js/ff/firefly.js?v={{ FF_VERSION }}"></script>
<script type="text/javascript" src="v1/js/ff/help.js?v={{ FF_VERSION }}"></script>
{% if not shownDemo %}
<script type="text/javascript">
    var routeForTour = "{{ current_route_name }}";
    var routeStepsUri = "{{ route('json.intro', [current_route_name, what|default("")]) }}";
    var routeForFinishedTour = "{{ route('json.intro.finished', [current_route_name, what|default("")]) }}";
</script>
<script type="text/javascript" src="v1/lib/intro/intro.min.js?v={{ FF_VERSION }}"></script>
<script type="text/javascript" src="v1/js/ff/intro/intro.js?v={{ FF_VERSION }}"></script>
{% endif %}
{% block scripts %}{% endblock %}

{% if config('firefly.analytics_id') != '' %}
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('firefly.analytics_id')  }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', '{{ config('firefly.analytics_id')  }}');
</script>
{% endif %}

</body>
</html>
