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

/* intro/index.html.twig */
class __TwigTemplate_bf2fc480293fd79eb5fc305fb7d849fa extends Template
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
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "intro/index.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>AgriSense 360 Intro</title>
    <link rel=\"stylesheet\" href=\"";
        // line 7
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/styles/home.css"), "html", null, true);
        yield "\">
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
</head>
<body class=\"intro-page intro-pending intro-locked ";
        // line 12
        if (((isset($context["mode"]) || array_key_exists("mode", $context) ? $context["mode"] : (function () { throw new RuntimeError('Variable "mode" does not exist.', 12, $this->source); })()) == "admin")) {
            yield "admin-mode";
        }
        yield "\" data-collapsed=\"true\">
    <a class=\"mode-switch\" href=\"";
        // line 13
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("intro", ["mode" => (isset($context["switchTargetMode"]) || array_key_exists("switchTargetMode", $context) ? $context["switchTargetMode"] : (function () { throw new RuntimeError('Variable "switchTargetMode" does not exist.', 13, $this->source); })())]), "html", null, true);
        yield "\">";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["switchLabel"]) || array_key_exists("switchLabel", $context) ? $context["switchLabel"] : (function () { throw new RuntimeError('Variable "switchLabel" does not exist.', 13, $this->source); })()), "html", null, true);
        yield "</a>

    <section class=\"plant-intro-overlay\" id=\"plant-intro-overlay\" aria-label=\"AgriSense intro animation\">
        <canvas id=\"plant-intro-canvas\" aria-hidden=\"true\"></canvas>
        <div class=\"plant-intro-overlay__layer\"></div>
        <div class=\"plant-intro-overlay__content\">
            <h2 class=\"plant-intro-title\" id=\"plant-intro-title\">AgriSense 360</h2>
            <p class=\"plant-intro-sub\" id=\"plant-intro-sub\">";
        // line 20
        if (((isset($context["mode"]) || array_key_exists("mode", $context) ? $context["mode"] : (function () { throw new RuntimeError('Variable "mode" does not exist.', 20, $this->source); })()) == "admin")) {
            yield "Administrative Intelligence Layer";
        } else {
            yield "Smart AI Companion for Farms";
        }
        yield "</p>

            <aside class=\"plant-intro-panel left top\" id=\"plant-panel-left-a\">
                <span class=\"side-label\">Unified View</span>
                <strong>One Dashboard</strong>
                <span class=\"side-sub\">Animals, crops, stock, workers, and equipment in one place, with a calm layout that keeps every signal easy to read.</span>
            </aside>

            <aside class=\"plant-intro-panel left middle\" id=\"plant-panel-left-b\">
                <span class=\"side-label\">Smart Alerts</span>
                <strong>Early Signals</strong>
                <span class=\"side-sub\">Catch maintenance, weather, and health risks before loss happens, so your team can move early and stay ahead.</span>
            </aside>

            <aside class=\"plant-intro-panel left bottom\" id=\"plant-panel-left-c\">
                <span class=\"side-label\">Daily Clarity</span>
                <strong>Actionable Tasks</strong>
                <span class=\"side-sub\">Your team gets precise priorities for every shift, with focused updates that keep work organized and smooth.</span>
            </aside>

            <aside class=\"plant-intro-panel right top\" id=\"plant-panel-right-a\">
                <span class=\"side-label\">Yield Insight</span>
                <strong>98%</strong>
                <span class=\"side-sub\">Above seasonal average, showing the platform's clear visibility into farm performance and progress.</span>
            </aside>

            <aside class=\"plant-intro-panel right middle\" id=\"plant-panel-right-b\">
                <span class=\"side-label\">Active Sensors</span>
                <strong>148</strong>
                <span class=\"side-sub\">Live field monitoring at every zone, helping you spot changes quickly without overwhelming the screen.</span>
            </aside>

            <aside class=\"plant-intro-panel right bottom\" id=\"plant-panel-right-c\">
                <span class=\"side-label\">Decision Speed</span>
                <strong>4.8x</strong>
                <span class=\"side-sub\">Faster intervention when anomalies appear, making day-to-day farm decisions feel steadier and more confident.</span>
            </aside>

            <div class=\"plant-intro-progress\">
                <div class=\"plant-intro-progress__track\"><div class=\"plant-intro-progress__fill\" id=\"plant-intro-fill\"></div></div>
                <span id=\"plant-intro-text\">scroll to grow</span>
            </div>

            <div class=\"plant-intro-actions\" id=\"plant-intro-actions\">
                <a class=\"plant-intro-action\" href=\"";
        // line 64
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("auth_login", ["mode" => (isset($context["mode"]) || array_key_exists("mode", $context) ? $context["mode"] : (function () { throw new RuntimeError('Variable "mode" does not exist.', 64, $this->source); })())]), "html", null, true);
        yield "\">Log In</a>
                <a class=\"plant-intro-action\" href=\"";
        // line 65
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("auth_signup", ["mode" => (isset($context["mode"]) || array_key_exists("mode", $context) ? $context["mode"] : (function () { throw new RuntimeError('Variable "mode" does not exist.', 65, $this->source); })())]), "html", null, true);
        yield "\">Sign Up</a>
            </div>
        </div>
    </section>

    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js\"></script>
    <script src=\"";
        // line 71
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/scripts/home-plant-overlay.js"), "html", null, true);
        yield "\"></script>
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
        return "intro/index.html.twig";
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
        return array (  143 => 71,  134 => 65,  130 => 64,  79 => 20,  67 => 13,  61 => 12,  53 => 7,  45 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>AgriSense 360 Intro</title>
    <link rel=\"stylesheet\" href=\"{{ asset('assets/styles/home.css') }}\">
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
</head>
<body class=\"intro-page intro-pending intro-locked {% if mode == 'admin' %}admin-mode{% endif %}\" data-collapsed=\"true\">
    <a class=\"mode-switch\" href=\"{{ path('intro', { mode: switchTargetMode }) }}\">{{ switchLabel }}</a>

    <section class=\"plant-intro-overlay\" id=\"plant-intro-overlay\" aria-label=\"AgriSense intro animation\">
        <canvas id=\"plant-intro-canvas\" aria-hidden=\"true\"></canvas>
        <div class=\"plant-intro-overlay__layer\"></div>
        <div class=\"plant-intro-overlay__content\">
            <h2 class=\"plant-intro-title\" id=\"plant-intro-title\">AgriSense 360</h2>
            <p class=\"plant-intro-sub\" id=\"plant-intro-sub\">{% if mode == 'admin' %}Administrative Intelligence Layer{% else %}Smart AI Companion for Farms{% endif %}</p>

            <aside class=\"plant-intro-panel left top\" id=\"plant-panel-left-a\">
                <span class=\"side-label\">Unified View</span>
                <strong>One Dashboard</strong>
                <span class=\"side-sub\">Animals, crops, stock, workers, and equipment in one place, with a calm layout that keeps every signal easy to read.</span>
            </aside>

            <aside class=\"plant-intro-panel left middle\" id=\"plant-panel-left-b\">
                <span class=\"side-label\">Smart Alerts</span>
                <strong>Early Signals</strong>
                <span class=\"side-sub\">Catch maintenance, weather, and health risks before loss happens, so your team can move early and stay ahead.</span>
            </aside>

            <aside class=\"plant-intro-panel left bottom\" id=\"plant-panel-left-c\">
                <span class=\"side-label\">Daily Clarity</span>
                <strong>Actionable Tasks</strong>
                <span class=\"side-sub\">Your team gets precise priorities for every shift, with focused updates that keep work organized and smooth.</span>
            </aside>

            <aside class=\"plant-intro-panel right top\" id=\"plant-panel-right-a\">
                <span class=\"side-label\">Yield Insight</span>
                <strong>98%</strong>
                <span class=\"side-sub\">Above seasonal average, showing the platform's clear visibility into farm performance and progress.</span>
            </aside>

            <aside class=\"plant-intro-panel right middle\" id=\"plant-panel-right-b\">
                <span class=\"side-label\">Active Sensors</span>
                <strong>148</strong>
                <span class=\"side-sub\">Live field monitoring at every zone, helping you spot changes quickly without overwhelming the screen.</span>
            </aside>

            <aside class=\"plant-intro-panel right bottom\" id=\"plant-panel-right-c\">
                <span class=\"side-label\">Decision Speed</span>
                <strong>4.8x</strong>
                <span class=\"side-sub\">Faster intervention when anomalies appear, making day-to-day farm decisions feel steadier and more confident.</span>
            </aside>

            <div class=\"plant-intro-progress\">
                <div class=\"plant-intro-progress__track\"><div class=\"plant-intro-progress__fill\" id=\"plant-intro-fill\"></div></div>
                <span id=\"plant-intro-text\">scroll to grow</span>
            </div>

            <div class=\"plant-intro-actions\" id=\"plant-intro-actions\">
                <a class=\"plant-intro-action\" href=\"{{ path('auth_login', { mode: mode }) }}\">Log In</a>
                <a class=\"plant-intro-action\" href=\"{{ path('auth_signup', { mode: mode }) }}\">Sign Up</a>
            </div>
        </div>
    </section>

    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js\"></script>
    <script src=\"{{ asset('assets/scripts/home-plant-overlay.js') }}\"></script>
</body>
</html>
", "intro/index.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\intro\\index.html.twig");
    }
}
