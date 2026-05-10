<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* management/layout.html.twig */
class __TwigTemplate_040903eb0778ffcb2e3d5cc53bae28e7 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'eyebrow' => [$this, 'block_eyebrow'],
            'heading' => [$this, 'block_heading'],
            'subhead' => [$this, 'block_subhead'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "management/layout.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>";
        // line 6
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        yield " | AgriSense 360</title>
    <link rel=\"stylesheet\" href=\"";
        // line 7
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/styles/management.css"), "html", null, true);
        yield "\">
    <link rel=\"stylesheet\" href=\"";
        // line 8
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/styles/menu.css"), "html", null, true);
        yield "\">
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
</head>
<body class=\"management\" data-collapsed=\"true\">
    <div class=\"page\">
        <aside class=\"sidebar\" aria-label=\"Primary\" id=\"sidebar\">
            <div class=\"brand\">
                <img src=\"";
        // line 17
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/images/agrisense-logo.png"), "html", null, true);
        yield "\" alt=\"AgriSense 360 logo\" class=\"brand-logo\">
                <div class=\"brand-text\">
                    <span class=\"brand-name\">AgriSense 360</span>
                    <span class=\"brand-tagline\">Smart AI Companion for Farms</span>
                </div>
            </div>
            <nav class=\"managements\">
                <p class=\"nav-title\">Managements</p>
                <ul>
                    <li class=\"";
        // line 26
        if (((isset($context["active"]) || array_key_exists("active", $context) ? $context["active"] : (function () { throw new RuntimeError('Variable "active" does not exist.', 26, $this->source); })()) == "home")) {
            yield "active";
        }
        yield "\">
                        <a class=\"nav-link\" href=\"";
        // line 27
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("home");
        yield "\">
                            <span class=\"nav-icon\">
                                <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\">
                                    <path d=\"M4 11l8-7 8 7\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>
                                    <path d=\"M6 10v8h12v-8\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>
                                </svg>
                            </span>
                            <span class=\"nav-label\">Home</span>
                        </a>
                    </li>
                    <li class=\"";
        // line 37
        if (((isset($context["active"]) || array_key_exists("active", $context) ? $context["active"] : (function () { throw new RuntimeError('Variable "active" does not exist.', 37, $this->source); })()) == "animals")) {
            yield "active";
        }
        yield "\">
                        <a class=\"nav-link\" href=\"";
        // line 38
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_animals");
        yield "\">
                            <span class=\"nav-icon\">
                                <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\">
                                    <path d=\"M5 15c0 2 3 4 7 4s7-2 7-4\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                    <path d=\"M9 11c0-2 1.5-3 3-3s3 1 3 3\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                    <path d=\"M8 7c0-1.6 1.8-3 4-3s4 1.4 4 3\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                </svg>
                            </span>
                            <span class=\"nav-label\">Animals Management</span>
                        </a>
                    </li>
                    <li class=\"";
        // line 49
        if (((isset($context["active"]) || array_key_exists("active", $context) ? $context["active"] : (function () { throw new RuntimeError('Variable "active" does not exist.', 49, $this->source); })()) == "equipments")) {
            yield "active";
        }
        yield "\">
                        <a class=\"nav-link\" href=\"";
        // line 50
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_equipments");
        yield "\">
                            <span class=\"nav-icon\">
                                <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\">
                                    <path d=\"M4 15h16l-2-6H6l-2 6z\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linejoin=\"round\"/>
                                    <circle cx=\"8\" cy=\"17\" r=\"2\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"/>
                                    <circle cx=\"16\" cy=\"17\" r=\"2\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"/>
                                </svg>
                            </span>
                            <span class=\"nav-label\">Equipments Management</span>
                        </a>
                    </li>
                    <li class=\"";
        // line 61
        if (((isset($context["active"]) || array_key_exists("active", $context) ? $context["active"] : (function () { throw new RuntimeError('Variable "active" does not exist.', 61, $this->source); })()) == "stock")) {
            yield "active";
        }
        yield "\">
                        <a class=\"nav-link\" href=\"";
        // line 62
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_stock");
        yield "\">
                            <span class=\"nav-icon\">
                                <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\">
                                    <path d=\"M6 4h12v6H6z\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"/>
                                    <path d=\"M5 10h14v8H5z\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"/>
                                </svg>
                            </span>
                            <span class=\"nav-label\">Stock Management</span>
                        </a>
                    </li>
                    <li class=\"";
        // line 72
        if (((isset($context["active"]) || array_key_exists("active", $context) ? $context["active"] : (function () { throw new RuntimeError('Variable "active" does not exist.', 72, $this->source); })()) == "culture")) {
            yield "active";
        }
        yield "\">
                        <a class=\"nav-link\" href=\"";
        // line 73
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_culture");
        yield "\">
                            <span class=\"nav-icon\">
                                <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\">
                                    <path d=\"M4 18c4-3 12-3 16 0\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                    <path d=\"M7 10c2-2 8-2 10 0\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                    <path d=\"M9 6c1.5-1 4.5-1 6 0\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                </svg>
                            </span>
                            <span class=\"nav-label\">Culture Management</span>
                        </a>
                    </li>
                    <li class=\"";
        // line 84
        if (((isset($context["active"]) || array_key_exists("active", $context) ? $context["active"] : (function () { throw new RuntimeError('Variable "active" does not exist.', 84, $this->source); })()) == "workers")) {
            yield "active";
        }
        yield "\">
                        <a class=\"nav-link\" href=\"";
        // line 85
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_workers");
        yield "\">
                            <span class=\"nav-icon\">
                                <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\">
                                    <path d=\"M7 8h10\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                    <path d=\"M6 12h12\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                    <path d=\"M8 16h8\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                </svg>
                            </span>
                            <span class=\"nav-label\">Workers Management</span>
                        </a>
                    </li>
                    <li class=\"";
        // line 96
        if (((isset($context["active"]) || array_key_exists("active", $context) ? $context["active"] : (function () { throw new RuntimeError('Variable "active" does not exist.', 96, $this->source); })()) == "profile")) {
            yield "active";
        }
        yield "\">
                        <a class=\"nav-link\" href=\"";
        // line 97
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_users");
        yield "\">
                            <span class=\"nav-icon\">
                                <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\">
                                    <circle cx=\"12\" cy=\"8\" r=\"3\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"/>
                                    <path d=\"M6 20c1.5-3 10.5-3 12 0\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                </svg>
                            </span>
                            <span class=\"nav-label\">Profile</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class=\"sidebar-foot\">
                <span class=\"pulse-dot\"></span>
                <a class=\"sidebar-logout\" href=\"";
        // line 111
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("auth_logout");
        yield "\">Log out</a>
            </div>
        </aside>

        <main class=\"content\">
            <header class=\"topbar\">
                <div class=\"topbar-title\">
                        <button class=\"sidebar-toggle\" id=\"sidebarToggle\" type=\"button\" aria-label=\"Toggle sidebar\" aria-controls=\"sidebar\" aria-expanded=\"true\">
                            <span class=\"toggle-icon\">
                                <span class=\"toggle-mid\"></span>
                            </span>
                            <span class=\"toggle-text\">Menu</span>
                        </button>
                    <p class=\"eyebrow\">";
        // line 124
        yield from $this->unwrap()->yieldBlock('eyebrow', $context, $blocks);
        yield "</p>
                    <h1>";
        // line 125
        yield from $this->unwrap()->yieldBlock('heading', $context, $blocks);
        yield "</h1>
                    <p class=\"subhead\">";
        // line 126
        yield from $this->unwrap()->yieldBlock('subhead', $context, $blocks);
        yield "</p>
                </div>
                <div class=\"topbar-actions\">
                    <button class=\"ghost\" type=\"button\">Export</button>
                    <button class=\"primary\" type=\"button\">New record</button>
                </div>
            </header>

            ";
        // line 134
        yield from $this->unwrap()->yieldBlock('body', $context, $blocks);
        // line 135
        yield "        </main>
    </div>
        <script>
            const btn = document.getElementById('sidebarToggle');
            const body = document.body;

            if (btn) {
                const isCollapsed = body.getAttribute('data-collapsed') === 'true';
                btn.setAttribute('aria-expanded', String(!isCollapsed));

                btn.addEventListener('click', () => {
                    const collapsed = body.getAttribute('data-collapsed') === 'true';
                    const next = String(!collapsed);
                    body.setAttribute('data-collapsed', next);
                    localStorage.setItem('sidebarCollapsed', next);
                    btn.setAttribute('aria-expanded', String(next !== 'true'));
                });
            }

            document.querySelectorAll('form').forEach((form) => {
                form.setAttribute('novalidate', 'novalidate');
            });
        </script>
</body>
</html>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 6
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        yield "Management";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 124
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_eyebrow(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "eyebrow"));

        yield "Management";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 125
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_heading(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "heading"));

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 126
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_subhead(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "subhead"));

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 134
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "management/layout.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  366 => 134,  350 => 126,  334 => 125,  317 => 124,  300 => 6,  267 => 135,  265 => 134,  254 => 126,  250 => 125,  246 => 124,  230 => 111,  213 => 97,  207 => 96,  193 => 85,  187 => 84,  173 => 73,  167 => 72,  154 => 62,  148 => 61,  134 => 50,  128 => 49,  114 => 38,  108 => 37,  95 => 27,  89 => 26,  77 => 17,  65 => 8,  61 => 7,  57 => 6,  50 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>{% block title %}Management{% endblock %} | AgriSense 360</title>
    <link rel=\"stylesheet\" href=\"{{ asset('assets/styles/management.css') }}\">
    <link rel=\"stylesheet\" href=\"{{ asset('assets/styles/menu.css') }}\">
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
</head>
<body class=\"management\" data-collapsed=\"true\">
    <div class=\"page\">
        <aside class=\"sidebar\" aria-label=\"Primary\" id=\"sidebar\">
            <div class=\"brand\">
                <img src=\"{{ asset('assets/images/agrisense-logo.png') }}\" alt=\"AgriSense 360 logo\" class=\"brand-logo\">
                <div class=\"brand-text\">
                    <span class=\"brand-name\">AgriSense 360</span>
                    <span class=\"brand-tagline\">Smart AI Companion for Farms</span>
                </div>
            </div>
            <nav class=\"managements\">
                <p class=\"nav-title\">Managements</p>
                <ul>
                    <li class=\"{% if active == 'home' %}active{% endif %}\">
                        <a class=\"nav-link\" href=\"{{ path('home') }}\">
                            <span class=\"nav-icon\">
                                <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\">
                                    <path d=\"M4 11l8-7 8 7\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>
                                    <path d=\"M6 10v8h12v-8\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>
                                </svg>
                            </span>
                            <span class=\"nav-label\">Home</span>
                        </a>
                    </li>
                    <li class=\"{% if active == 'animals' %}active{% endif %}\">
                        <a class=\"nav-link\" href=\"{{ path('management_animals') }}\">
                            <span class=\"nav-icon\">
                                <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\">
                                    <path d=\"M5 15c0 2 3 4 7 4s7-2 7-4\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                    <path d=\"M9 11c0-2 1.5-3 3-3s3 1 3 3\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                    <path d=\"M8 7c0-1.6 1.8-3 4-3s4 1.4 4 3\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                </svg>
                            </span>
                            <span class=\"nav-label\">Animals Management</span>
                        </a>
                    </li>
                    <li class=\"{% if active == 'equipments' %}active{% endif %}\">
                        <a class=\"nav-link\" href=\"{{ path('management_equipments') }}\">
                            <span class=\"nav-icon\">
                                <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\">
                                    <path d=\"M4 15h16l-2-6H6l-2 6z\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linejoin=\"round\"/>
                                    <circle cx=\"8\" cy=\"17\" r=\"2\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"/>
                                    <circle cx=\"16\" cy=\"17\" r=\"2\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"/>
                                </svg>
                            </span>
                            <span class=\"nav-label\">Equipments Management</span>
                        </a>
                    </li>
                    <li class=\"{% if active == 'stock' %}active{% endif %}\">
                        <a class=\"nav-link\" href=\"{{ path('management_stock') }}\">
                            <span class=\"nav-icon\">
                                <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\">
                                    <path d=\"M6 4h12v6H6z\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"/>
                                    <path d=\"M5 10h14v8H5z\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"/>
                                </svg>
                            </span>
                            <span class=\"nav-label\">Stock Management</span>
                        </a>
                    </li>
                    <li class=\"{% if active == 'culture' %}active{% endif %}\">
                        <a class=\"nav-link\" href=\"{{ path('management_culture') }}\">
                            <span class=\"nav-icon\">
                                <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\">
                                    <path d=\"M4 18c4-3 12-3 16 0\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                    <path d=\"M7 10c2-2 8-2 10 0\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                    <path d=\"M9 6c1.5-1 4.5-1 6 0\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                </svg>
                            </span>
                            <span class=\"nav-label\">Culture Management</span>
                        </a>
                    </li>
                    <li class=\"{% if active == 'workers' %}active{% endif %}\">
                        <a class=\"nav-link\" href=\"{{ path('management_workers') }}\">
                            <span class=\"nav-icon\">
                                <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\">
                                    <path d=\"M7 8h10\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                    <path d=\"M6 12h12\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                    <path d=\"M8 16h8\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                </svg>
                            </span>
                            <span class=\"nav-label\">Workers Management</span>
                        </a>
                    </li>
                    <li class=\"{% if active == 'profile' %}active{% endif %}\">
                        <a class=\"nav-link\" href=\"{{ path('management_users') }}\">
                            <span class=\"nav-icon\">
                                <svg viewBox=\"0 0 24 24\" aria-hidden=\"true\">
                                    <circle cx=\"12\" cy=\"8\" r=\"3\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"/>
                                    <path d=\"M6 20c1.5-3 10.5-3 12 0\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                                </svg>
                            </span>
                            <span class=\"nav-label\">Profile</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class=\"sidebar-foot\">
                <span class=\"pulse-dot\"></span>
                <a class=\"sidebar-logout\" href=\"{{ path('auth_logout') }}\">Log out</a>
            </div>
        </aside>

        <main class=\"content\">
            <header class=\"topbar\">
                <div class=\"topbar-title\">
                        <button class=\"sidebar-toggle\" id=\"sidebarToggle\" type=\"button\" aria-label=\"Toggle sidebar\" aria-controls=\"sidebar\" aria-expanded=\"true\">
                            <span class=\"toggle-icon\">
                                <span class=\"toggle-mid\"></span>
                            </span>
                            <span class=\"toggle-text\">Menu</span>
                        </button>
                    <p class=\"eyebrow\">{% block eyebrow %}Management{% endblock %}</p>
                    <h1>{% block heading %}{% endblock %}</h1>
                    <p class=\"subhead\">{% block subhead %}{% endblock %}</p>
                </div>
                <div class=\"topbar-actions\">
                    <button class=\"ghost\" type=\"button\">Export</button>
                    <button class=\"primary\" type=\"button\">New record</button>
                </div>
            </header>

            {% block body %}{% endblock %}
        </main>
    </div>
        <script>
            const btn = document.getElementById('sidebarToggle');
            const body = document.body;

            if (btn) {
                const isCollapsed = body.getAttribute('data-collapsed') === 'true';
                btn.setAttribute('aria-expanded', String(!isCollapsed));

                btn.addEventListener('click', () => {
                    const collapsed = body.getAttribute('data-collapsed') === 'true';
                    const next = String(!collapsed);
                    body.setAttribute('data-collapsed', next);
                    localStorage.setItem('sidebarCollapsed', next);
                    btn.setAttribute('aria-expanded', String(next !== 'true'));
                });
            }

            document.querySelectorAll('form').forEach((form) => {
                form.setAttribute('novalidate', 'novalidate');
            });
        </script>
</body>
</html>
", "management/layout.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\management\\layout.html.twig");
    }
}
