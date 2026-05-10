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

/* home/index.html.twig */
class __TwigTemplate_9132863237d4eafc27d30b9a738ff28d extends Template
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
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "home/index.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>AgriSense 360</title>
    <link rel=\"stylesheet\" href=\"";
        // line 7
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/styles/home.css"), "html", null, true);
        yield "\">
    <link rel=\"stylesheet\" href=\"";
        // line 8
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/styles/management.css"), "html", null, true);
        yield "\">
    <link rel=\"stylesheet\" href=\"";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/styles/menu.css"), "html", null, true);
        yield "\">
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
</head>
<body class=\"user-home";
        // line 14
        if ((($tmp = ((array_key_exists("authTransition", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["authTransition"]) || array_key_exists("authTransition", $context) ? $context["authTransition"] : (function () { throw new RuntimeError('Variable "authTransition" does not exist.', 14, $this->source); })()), false)) : (false))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " auth-entry";
        }
        yield "\" data-collapsed=\"true\">

    <div class=\"page\">
        <div class=\"ambient\" aria-hidden=\"true\">
            <div class=\"ambient-leaf\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M10 40C18 18 38 8 54 10c-2 18-12 36-34 44-6-6-10-10-10-14z\" fill=\"currentColor\"/>
                    <path d=\"M20 44c10-12 22-20 30-24\" fill=\"none\" stroke=\"rgba(255,255,255,0.7)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
            <div class=\"ambient-leaf leaf-2\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M12 46C18 22 36 10 54 12c-2 18-14 34-34 42-5-4-8-6-8-8z\" fill=\"currentColor\"/>
                    <path d=\"M22 46c8-10 18-16 26-20\" fill=\"none\" stroke=\"rgba(255,255,255,0.6)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
            <div class=\"ambient-leaf leaf-3\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M10 40C18 18 38 8 54 10c-2 18-12 36-34 44-6-6-10-10-10-14z\" fill=\"currentColor\"/>
                    <path d=\"M20 44c10-12 22-20 30-24\" fill=\"none\" stroke=\"rgba(255,255,255,0.7)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
            <div class=\"ambient-leaf leaf-4\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M12 46C18 22 36 10 54 12c-2 18-14 34-34 42-5-4-8-6-8-8z\" fill=\"currentColor\"/>
                    <path d=\"M22 46c8-10 18-16 26-20\" fill=\"none\" stroke=\"rgba(255,255,255,0.6)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
            <div class=\"ambient-leaf leaf-5\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M10 40C18 18 38 8 54 10c-2 18-12 36-34 44-6-6-10-10-10-14z\" fill=\"currentColor\"/>
                    <path d=\"M20 44c10-12 22-20 30-24\" fill=\"none\" stroke=\"rgba(255,255,255,0.7)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
            <div class=\"ambient-leaf leaf-6\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M12 46C18 22 36 10 54 12c-2 18-14 34-34 42-5-4-8-6-8-8z\" fill=\"currentColor\"/>
                    <path d=\"M22 46c8-10 18-16 26-20\" fill=\"none\" stroke=\"rgba(255,255,255,0.6)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
            <div class=\"ambient-leaf leaf-7\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M10 40C18 18 38 8 54 10c-2 18-12 36-34 44-6-6-10-10-10-14z\" fill=\"currentColor\"/>
                    <path d=\"M20 44c10-12 22-20 30-24\" fill=\"none\" stroke=\"rgba(255,255,255,0.7)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
            <div class=\"ambient-leaf leaf-8\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M12 46C18 22 36 10 54 12c-2 18-14 34-34 42-5-4-8-6-8-8z\" fill=\"currentColor\"/>
                    <path d=\"M22 46c8-10 18-16 26-20\" fill=\"none\" stroke=\"rgba(255,255,255,0.6)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
        </div>
        <aside class=\"sidebar\" aria-label=\"Primary\" id=\"sidebar\">
            <div class=\"brand\">
                <img src=\"";
        // line 69
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/images/agrisense-logo.png"), "html", null, true);
        yield "\" alt=\"AgriSense 360 logo\" class=\"brand-logo\">
                <div class=\"brand-text\">
                    <span class=\"brand-name\">AgriSense 360</span>
                    <span class=\"brand-tagline\">Smart AI Companion for Farms</span>
                </div>
            </div>
            <nav class=\"managements\">
                <p class=\"nav-title\">Managements</p>
                ";
        // line 77
        $context["currentRoute"] = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 77, $this->source); })()), "request", [], "any", false, false, false, 77), "attributes", [], "any", false, false, false, 77), "get", ["_route"], "method", false, false, false, 77);
        // line 78
        yield "                <ul>
                    <li class=\"";
        // line 79
        if (((isset($context["currentRoute"]) || array_key_exists("currentRoute", $context) ? $context["currentRoute"] : (function () { throw new RuntimeError('Variable "currentRoute" does not exist.', 79, $this->source); })()) == "home")) {
            yield "active";
        }
        yield "\">
                        <a class=\"nav-link\" href=\"";
        // line 80
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
        // line 90
        if (((isset($context["currentRoute"]) || array_key_exists("currentRoute", $context) ? $context["currentRoute"] : (function () { throw new RuntimeError('Variable "currentRoute" does not exist.', 90, $this->source); })()) == "management_animals")) {
            yield "active";
        }
        yield "\">
                        <a class=\"nav-link\" href=\"";
        // line 91
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
        // line 102
        if (((isset($context["currentRoute"]) || array_key_exists("currentRoute", $context) ? $context["currentRoute"] : (function () { throw new RuntimeError('Variable "currentRoute" does not exist.', 102, $this->source); })()) == "management_equipments")) {
            yield "active";
        }
        yield "\">
                        <a class=\"nav-link\" href=\"";
        // line 103
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
        // line 114
        if (((isset($context["currentRoute"]) || array_key_exists("currentRoute", $context) ? $context["currentRoute"] : (function () { throw new RuntimeError('Variable "currentRoute" does not exist.', 114, $this->source); })()) == "management_stock")) {
            yield "active";
        }
        yield "\">
                        <a class=\"nav-link\" href=\"";
        // line 115
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
        // line 125
        if (((isset($context["currentRoute"]) || array_key_exists("currentRoute", $context) ? $context["currentRoute"] : (function () { throw new RuntimeError('Variable "currentRoute" does not exist.', 125, $this->source); })()) == "management_culture")) {
            yield "active";
        }
        yield "\">
                        <a class=\"nav-link\" href=\"";
        // line 126
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
        // line 137
        if (((isset($context["currentRoute"]) || array_key_exists("currentRoute", $context) ? $context["currentRoute"] : (function () { throw new RuntimeError('Variable "currentRoute" does not exist.', 137, $this->source); })()) == "management_workers")) {
            yield "active";
        }
        yield "\">
                        <a class=\"nav-link\" href=\"";
        // line 138
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
        // line 149
        if (((isset($context["currentRoute"]) || array_key_exists("currentRoute", $context) ? $context["currentRoute"] : (function () { throw new RuntimeError('Variable "currentRoute" does not exist.', 149, $this->source); })()) == "management_users")) {
            yield "active";
        }
        yield "\">
                        <a class=\"nav-link\" href=\"";
        // line 150
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
        // line 164
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("auth_logout");
        yield "\">Log out</a>
            </div>
        </aside>

        <main class=\"content\">
            <header class=\"topbar\">
                <div class=\"topbar-left\">
                    <button class=\"sidebar-toggle\" id=\"sidebarToggle\" type=\"button\" aria-label=\"Toggle sidebar\" aria-controls=\"sidebar\" aria-expanded=\"true\">
                        <span class=\"toggle-icon\">
                            <span class=\"toggle-mid\"></span>
                        </span>
                        <span class=\"toggle-text\">Menu</span>
                    </button>
                    <h1>AgriSense 360 helps farms grow healthier, faster, and smarter.</h1>
                    <p class=\"topbar-sub\">Your AI assistant unifies livestock, crops, equipment, inventory, and workforce data into one living system.</p>
                </div>
                <div class=\"topbar-right\">
                    <div class=\"stat\">
                        <span class=\"stat-value\">98%</span>
                        <span class=\"stat-label\">Yield Insight</span>
                    </div>
                    <div class=\"stat\">
                        <span class=\"stat-value\">24/7</span>
                        <span class=\"stat-label\">AI Monitoring</span>
                    </div>
                </div>
            </header>

            <section class=\"hero-banner\">
                <div class=\"hero-copy\">
                    <p class=\"hero-kicker\">Future-ready farms start here</p>
                    <h2>Turn every field signal into a confident decision.</h2>
                    <p class=\"hero-lead\">AgriSense 360 watches your farm in real time, detects risks early, and guides teams with a clear, unified view of operations.</p>
                    <div class=\"hero-actions\">
                        <button class=\"primary\">Explore the platform</button>
                        <button class=\"ghost\">See how it works</button>
                    </div>
                </div>
                <div class=\"hero-visual\">
                    <img src=\"https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1200&q=80\" alt=\"Farmland with sunrise\" loading=\"lazy\">
                    <div class=\"hero-badge\">
                        <span>AI Forecast</span>
                        <strong>Low risk today</strong>
                    </div>
                </div>
                <div class=\"hero-panel\">
                    <div class=\"panel-item\">
                        <span class=\"panel-label\">Field Health</span>
                        <span class=\"panel-value\">92%</span>
                    </div>
                    <div class=\"panel-item\">
                        <span class=\"panel-label\">Active Sensors</span>
                        <span class=\"panel-value\">148</span>
                    </div>
                    <div class=\"panel-item\">
                        <span class=\"panel-label\">Worker Tasks</span>
                        <span class=\"panel-value\">36</span>
                    </div>
                    <div class=\"panel-chart\">
                        <span class=\"panel-label\">Climate Stress Index</span>
                        <svg viewBox=\"0 0 120 40\" role=\"presentation\" aria-hidden=\"true\">
                            <path d=\"M2 30 L20 26 L38 28 L56 20 L74 18 L92 10 L118 12\" fill=\"none\" stroke=\"rgba(255,255,255,0.7)\" stroke-width=\"2\"/>
                            <path d=\"M2 30 L20 26 L38 28 L56 20 L74 18 L92 10 L118 12 L118 38 L2 38 Z\" fill=\"rgba(255,255,255,0.08)\"/>
                            <circle cx=\"92\" cy=\"10\" r=\"3\" fill=\"#ffffff\"/>
                        </svg>
                        <span class=\"panel-note\">Rising trend this week</span>
                    </div>
                </div>
            </section>

            <section class=\"about-band\">
                <div>
                    <h2>Built for modern farms and agribusiness teams.</h2>
                    <p>We combine AI assistance, field data, and team workflows into a single operating system. From animal health to stock accuracy, everything stays connected, accountable, and measurable.</p>
                    <div class=\"climate-card\">
                        <div>
                            <h3>Climate impact on yield</h3>
                            <p>Monitoring heat, humidity, and rainfall helps protect crops before stress turns into loss.</p>
                        </div>
                        <div class=\"climate-graph\">
                            <svg viewBox=\"0 0 220 120\" role=\"presentation\" aria-hidden=\"true\">
                                <rect x=\"0\" y=\"0\" width=\"220\" height=\"120\" rx=\"16\" fill=\"rgba(255,255,255,0.4)\"/>
                                <path d=\"M20 90 L60 70 L100 78 L140 52 L180 60\" fill=\"none\" stroke=\"rgba(32,176,160,0.9)\" stroke-width=\"4\" stroke-linecap=\"round\"/>
                                <circle cx=\"60\" cy=\"70\" r=\"5\" fill=\"#20b0a0\"/>
                                <circle cx=\"140\" cy=\"52\" r=\"5\" fill=\"#20b0a0\"/>
                                <text x=\"20\" y=\"108\" fill=\"rgba(23,35,24,0.6)\" font-size=\"10\">2019</text>
                                <text x=\"176\" y=\"108\" fill=\"rgba(23,35,24,0.6)\" font-size=\"10\">2025</text>
                            </svg>
                            <div class=\"climate-stats\">
                                <div>
                                    <span class=\"stat-number\">+1.7°C</span>
                                    <span class=\"stat-text\">Avg. temp rise</span>
                                </div>
                                <div>
                                    <span class=\"stat-number\">-12%</span>
                                    <span class=\"stat-text\">Yield risk</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=\"about-media\">
                    <img src=\"";
        // line 266
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/images/about-field.jpg"), "html", null, true);
        yield "\" alt=\"Rice field workers\" loading=\"lazy\">
                </div>
                <div class=\"about-card\">
                    <h3>Mission</h3>
                    <p>Help farmers unlock sustainable growth with precise, actionable intelligence across the whole farm lifecycle.</p>
                </div>
            </section>

            <section class=\"services\">
                <div class=\"section-title\">
                    <span>What we manage</span>
                    <h2>Every department in one control center.</h2>
                </div>
                <div class=\"grid\">
                    <article class=\"card delay-1\">
                        <img src=\"https://images.unsplash.com/photo-1500595046743-cd271d694d30?auto=format&fit=crop&w=700&q=80\" alt=\"Cattle herd\" loading=\"lazy\">
                        <h3>Animals Management</h3>
                        <p>Monitor health, feeding schedules, and productivity with predictive alerts.</p>
                    </article>
                    <article class=\"card delay-2\">
                        <img src=\"";
        // line 286
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/images/equipment.jpg"), "html", null, true);
        yield "\" alt=\"Agriculture equipment\" loading=\"lazy\">
                        <h3>Equipments Management</h3>
                        <p>Track maintenance cycles, usage, and readiness for every machine.</p>
                    </article>
                    <article class=\"card delay-3\">
                        <img src=\"https://images.unsplash.com/photo-1472141521881-95d0e87e2e39?auto=format&fit=crop&w=700&q=80\" alt=\"Grain storage\" loading=\"lazy\">
                        <h3>Stock Management</h3>
                        <p>Control inventory, forecast demand, and reduce input waste.</p>
                    </article>
                    <article class=\"card delay-4\">
                        <img src=\"https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&w=700&q=80\" alt=\"Crop fields\" loading=\"lazy\">
                        <h3>Culture Management</h3>
                        <p>Plan crop cycles with soil insight, climate trends, and yield modeling.</p>
                    </article>
                    <article class=\"card delay-5\">
                        <img src=\"";
        // line 301
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/images/workers.jpg"), "html", null, true);
        yield "\" alt=\"Workers in a field\" loading=\"lazy\">
                        <h3>Workers Management</h3>
                        <p>Coordinate tasks, scheduling, and field execution in real time.</p>
                    </article>
                </div>
            </section>

            <section class=\"stats-strip\">
                <div class=\"stat-block\">
                    <span class=\"stat-number\">16%</span>
                    <span class=\"stat-text\">Reduced input waste</span>
                </div>
                <div class=\"stat-block\">
                    <span class=\"stat-number\">4.8x</span>
                    <span class=\"stat-text\">Faster issue response</span>
                </div>
                <div class=\"stat-block\">
                    <span class=\"stat-number\">37%</span>
                    <span class=\"stat-text\">Higher task completion</span>
                </div>
            </section>

            <footer class=\"image-credits\">
                <p>Image credits: User-provided.</p>
                <div class=\"credit-links\">
                    <a href=\"https://unsplash.com/photos/b39e6451bec6\" target=\"_blank\" rel=\"noreferrer\">Hero field</a>
                    <a href=\"https://unsplash.com/photos/b586d89ba3ee\" target=\"_blank\" rel=\"noreferrer\">Harvest field</a>
                    <a href=\"https://unsplash.com/photos/cd271d694d30\" target=\"_blank\" rel=\"noreferrer\">Cattle</a>
                    <a href=\"https://unsplash.com/photos/95d0e87e2e39\" target=\"_blank\" rel=\"noreferrer\">Stock</a>
                    <a href=\"https://unsplash.com/photos/aef1dfb1e735\" target=\"_blank\" rel=\"noreferrer\">Crops</a>
                </div>
            </footer>
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
    </script>
</body>
</html>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "home/index.html.twig";
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
        return array (  432 => 301,  414 => 286,  391 => 266,  286 => 164,  269 => 150,  263 => 149,  249 => 138,  243 => 137,  229 => 126,  223 => 125,  210 => 115,  204 => 114,  190 => 103,  184 => 102,  170 => 91,  164 => 90,  151 => 80,  145 => 79,  142 => 78,  140 => 77,  129 => 69,  69 => 14,  61 => 9,  57 => 8,  53 => 7,  45 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>AgriSense 360</title>
    <link rel=\"stylesheet\" href=\"{{ asset('assets/styles/home.css') }}\">
    <link rel=\"stylesheet\" href=\"{{ asset('assets/styles/management.css') }}\">
    <link rel=\"stylesheet\" href=\"{{ asset('assets/styles/menu.css') }}\">
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
</head>
<body class=\"user-home{% if authTransition|default(false) %} auth-entry{% endif %}\" data-collapsed=\"true\">

    <div class=\"page\">
        <div class=\"ambient\" aria-hidden=\"true\">
            <div class=\"ambient-leaf\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M10 40C18 18 38 8 54 10c-2 18-12 36-34 44-6-6-10-10-10-14z\" fill=\"currentColor\"/>
                    <path d=\"M20 44c10-12 22-20 30-24\" fill=\"none\" stroke=\"rgba(255,255,255,0.7)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
            <div class=\"ambient-leaf leaf-2\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M12 46C18 22 36 10 54 12c-2 18-14 34-34 42-5-4-8-6-8-8z\" fill=\"currentColor\"/>
                    <path d=\"M22 46c8-10 18-16 26-20\" fill=\"none\" stroke=\"rgba(255,255,255,0.6)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
            <div class=\"ambient-leaf leaf-3\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M10 40C18 18 38 8 54 10c-2 18-12 36-34 44-6-6-10-10-10-14z\" fill=\"currentColor\"/>
                    <path d=\"M20 44c10-12 22-20 30-24\" fill=\"none\" stroke=\"rgba(255,255,255,0.7)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
            <div class=\"ambient-leaf leaf-4\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M12 46C18 22 36 10 54 12c-2 18-14 34-34 42-5-4-8-6-8-8z\" fill=\"currentColor\"/>
                    <path d=\"M22 46c8-10 18-16 26-20\" fill=\"none\" stroke=\"rgba(255,255,255,0.6)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
            <div class=\"ambient-leaf leaf-5\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M10 40C18 18 38 8 54 10c-2 18-12 36-34 44-6-6-10-10-10-14z\" fill=\"currentColor\"/>
                    <path d=\"M20 44c10-12 22-20 30-24\" fill=\"none\" stroke=\"rgba(255,255,255,0.7)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
            <div class=\"ambient-leaf leaf-6\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M12 46C18 22 36 10 54 12c-2 18-14 34-34 42-5-4-8-6-8-8z\" fill=\"currentColor\"/>
                    <path d=\"M22 46c8-10 18-16 26-20\" fill=\"none\" stroke=\"rgba(255,255,255,0.6)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
            <div class=\"ambient-leaf leaf-7\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M10 40C18 18 38 8 54 10c-2 18-12 36-34 44-6-6-10-10-10-14z\" fill=\"currentColor\"/>
                    <path d=\"M20 44c10-12 22-20 30-24\" fill=\"none\" stroke=\"rgba(255,255,255,0.7)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
            <div class=\"ambient-leaf leaf-8\">
                <svg viewBox=\"0 0 64 64\" role=\"presentation\">
                    <path d=\"M12 46C18 22 36 10 54 12c-2 18-14 34-34 42-5-4-8-6-8-8z\" fill=\"currentColor\"/>
                    <path d=\"M22 46c8-10 18-16 26-20\" fill=\"none\" stroke=\"rgba(255,255,255,0.6)\" stroke-width=\"2\" stroke-linecap=\"round\"/>
                </svg>
            </div>
        </div>
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
                {% set currentRoute = app.request.attributes.get('_route') %}
                <ul>
                    <li class=\"{% if currentRoute == 'home' %}active{% endif %}\">
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
                    <li class=\"{% if currentRoute == 'management_animals' %}active{% endif %}\">
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
                    <li class=\"{% if currentRoute == 'management_equipments' %}active{% endif %}\">
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
                    <li class=\"{% if currentRoute == 'management_stock' %}active{% endif %}\">
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
                    <li class=\"{% if currentRoute == 'management_culture' %}active{% endif %}\">
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
                    <li class=\"{% if currentRoute == 'management_workers' %}active{% endif %}\">
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
                    <li class=\"{% if currentRoute == 'management_users' %}active{% endif %}\">
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
                <div class=\"topbar-left\">
                    <button class=\"sidebar-toggle\" id=\"sidebarToggle\" type=\"button\" aria-label=\"Toggle sidebar\" aria-controls=\"sidebar\" aria-expanded=\"true\">
                        <span class=\"toggle-icon\">
                            <span class=\"toggle-mid\"></span>
                        </span>
                        <span class=\"toggle-text\">Menu</span>
                    </button>
                    <h1>AgriSense 360 helps farms grow healthier, faster, and smarter.</h1>
                    <p class=\"topbar-sub\">Your AI assistant unifies livestock, crops, equipment, inventory, and workforce data into one living system.</p>
                </div>
                <div class=\"topbar-right\">
                    <div class=\"stat\">
                        <span class=\"stat-value\">98%</span>
                        <span class=\"stat-label\">Yield Insight</span>
                    </div>
                    <div class=\"stat\">
                        <span class=\"stat-value\">24/7</span>
                        <span class=\"stat-label\">AI Monitoring</span>
                    </div>
                </div>
            </header>

            <section class=\"hero-banner\">
                <div class=\"hero-copy\">
                    <p class=\"hero-kicker\">Future-ready farms start here</p>
                    <h2>Turn every field signal into a confident decision.</h2>
                    <p class=\"hero-lead\">AgriSense 360 watches your farm in real time, detects risks early, and guides teams with a clear, unified view of operations.</p>
                    <div class=\"hero-actions\">
                        <button class=\"primary\">Explore the platform</button>
                        <button class=\"ghost\">See how it works</button>
                    </div>
                </div>
                <div class=\"hero-visual\">
                    <img src=\"https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1200&q=80\" alt=\"Farmland with sunrise\" loading=\"lazy\">
                    <div class=\"hero-badge\">
                        <span>AI Forecast</span>
                        <strong>Low risk today</strong>
                    </div>
                </div>
                <div class=\"hero-panel\">
                    <div class=\"panel-item\">
                        <span class=\"panel-label\">Field Health</span>
                        <span class=\"panel-value\">92%</span>
                    </div>
                    <div class=\"panel-item\">
                        <span class=\"panel-label\">Active Sensors</span>
                        <span class=\"panel-value\">148</span>
                    </div>
                    <div class=\"panel-item\">
                        <span class=\"panel-label\">Worker Tasks</span>
                        <span class=\"panel-value\">36</span>
                    </div>
                    <div class=\"panel-chart\">
                        <span class=\"panel-label\">Climate Stress Index</span>
                        <svg viewBox=\"0 0 120 40\" role=\"presentation\" aria-hidden=\"true\">
                            <path d=\"M2 30 L20 26 L38 28 L56 20 L74 18 L92 10 L118 12\" fill=\"none\" stroke=\"rgba(255,255,255,0.7)\" stroke-width=\"2\"/>
                            <path d=\"M2 30 L20 26 L38 28 L56 20 L74 18 L92 10 L118 12 L118 38 L2 38 Z\" fill=\"rgba(255,255,255,0.08)\"/>
                            <circle cx=\"92\" cy=\"10\" r=\"3\" fill=\"#ffffff\"/>
                        </svg>
                        <span class=\"panel-note\">Rising trend this week</span>
                    </div>
                </div>
            </section>

            <section class=\"about-band\">
                <div>
                    <h2>Built for modern farms and agribusiness teams.</h2>
                    <p>We combine AI assistance, field data, and team workflows into a single operating system. From animal health to stock accuracy, everything stays connected, accountable, and measurable.</p>
                    <div class=\"climate-card\">
                        <div>
                            <h3>Climate impact on yield</h3>
                            <p>Monitoring heat, humidity, and rainfall helps protect crops before stress turns into loss.</p>
                        </div>
                        <div class=\"climate-graph\">
                            <svg viewBox=\"0 0 220 120\" role=\"presentation\" aria-hidden=\"true\">
                                <rect x=\"0\" y=\"0\" width=\"220\" height=\"120\" rx=\"16\" fill=\"rgba(255,255,255,0.4)\"/>
                                <path d=\"M20 90 L60 70 L100 78 L140 52 L180 60\" fill=\"none\" stroke=\"rgba(32,176,160,0.9)\" stroke-width=\"4\" stroke-linecap=\"round\"/>
                                <circle cx=\"60\" cy=\"70\" r=\"5\" fill=\"#20b0a0\"/>
                                <circle cx=\"140\" cy=\"52\" r=\"5\" fill=\"#20b0a0\"/>
                                <text x=\"20\" y=\"108\" fill=\"rgba(23,35,24,0.6)\" font-size=\"10\">2019</text>
                                <text x=\"176\" y=\"108\" fill=\"rgba(23,35,24,0.6)\" font-size=\"10\">2025</text>
                            </svg>
                            <div class=\"climate-stats\">
                                <div>
                                    <span class=\"stat-number\">+1.7°C</span>
                                    <span class=\"stat-text\">Avg. temp rise</span>
                                </div>
                                <div>
                                    <span class=\"stat-number\">-12%</span>
                                    <span class=\"stat-text\">Yield risk</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=\"about-media\">
                    <img src=\"{{ asset('assets/images/about-field.jpg') }}\" alt=\"Rice field workers\" loading=\"lazy\">
                </div>
                <div class=\"about-card\">
                    <h3>Mission</h3>
                    <p>Help farmers unlock sustainable growth with precise, actionable intelligence across the whole farm lifecycle.</p>
                </div>
            </section>

            <section class=\"services\">
                <div class=\"section-title\">
                    <span>What we manage</span>
                    <h2>Every department in one control center.</h2>
                </div>
                <div class=\"grid\">
                    <article class=\"card delay-1\">
                        <img src=\"https://images.unsplash.com/photo-1500595046743-cd271d694d30?auto=format&fit=crop&w=700&q=80\" alt=\"Cattle herd\" loading=\"lazy\">
                        <h3>Animals Management</h3>
                        <p>Monitor health, feeding schedules, and productivity with predictive alerts.</p>
                    </article>
                    <article class=\"card delay-2\">
                        <img src=\"{{ asset('assets/images/equipment.jpg') }}\" alt=\"Agriculture equipment\" loading=\"lazy\">
                        <h3>Equipments Management</h3>
                        <p>Track maintenance cycles, usage, and readiness for every machine.</p>
                    </article>
                    <article class=\"card delay-3\">
                        <img src=\"https://images.unsplash.com/photo-1472141521881-95d0e87e2e39?auto=format&fit=crop&w=700&q=80\" alt=\"Grain storage\" loading=\"lazy\">
                        <h3>Stock Management</h3>
                        <p>Control inventory, forecast demand, and reduce input waste.</p>
                    </article>
                    <article class=\"card delay-4\">
                        <img src=\"https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&w=700&q=80\" alt=\"Crop fields\" loading=\"lazy\">
                        <h3>Culture Management</h3>
                        <p>Plan crop cycles with soil insight, climate trends, and yield modeling.</p>
                    </article>
                    <article class=\"card delay-5\">
                        <img src=\"{{ asset('assets/images/workers.jpg') }}\" alt=\"Workers in a field\" loading=\"lazy\">
                        <h3>Workers Management</h3>
                        <p>Coordinate tasks, scheduling, and field execution in real time.</p>
                    </article>
                </div>
            </section>

            <section class=\"stats-strip\">
                <div class=\"stat-block\">
                    <span class=\"stat-number\">16%</span>
                    <span class=\"stat-text\">Reduced input waste</span>
                </div>
                <div class=\"stat-block\">
                    <span class=\"stat-number\">4.8x</span>
                    <span class=\"stat-text\">Faster issue response</span>
                </div>
                <div class=\"stat-block\">
                    <span class=\"stat-number\">37%</span>
                    <span class=\"stat-text\">Higher task completion</span>
                </div>
            </section>

            <footer class=\"image-credits\">
                <p>Image credits: User-provided.</p>
                <div class=\"credit-links\">
                    <a href=\"https://unsplash.com/photos/b39e6451bec6\" target=\"_blank\" rel=\"noreferrer\">Hero field</a>
                    <a href=\"https://unsplash.com/photos/b586d89ba3ee\" target=\"_blank\" rel=\"noreferrer\">Harvest field</a>
                    <a href=\"https://unsplash.com/photos/cd271d694d30\" target=\"_blank\" rel=\"noreferrer\">Cattle</a>
                    <a href=\"https://unsplash.com/photos/95d0e87e2e39\" target=\"_blank\" rel=\"noreferrer\">Stock</a>
                    <a href=\"https://unsplash.com/photos/aef1dfb1e735\" target=\"_blank\" rel=\"noreferrer\">Crops</a>
                </div>
            </footer>
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
    </script>
</body>
</html>
", "home/index.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\home\\index.html.twig");
    }
}
