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

/* admin/home.html.twig */
class __TwigTemplate_dad240a305865c369f607ffcafdbd4d9 extends Template
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

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body_state_class' => [$this, 'block_body_state_class'],
            'eyebrow' => [$this, 'block_eyebrow'],
            'heading' => [$this, 'block_heading'],
            'subhead' => [$this, 'block_subhead'],
            'collapsed_state' => [$this, 'block_collapsed_state'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "admin/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/home.html.twig"));

        $this->parent = $this->load("admin/layout.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        yield "Admin Operations Dashboard";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 4
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body_state_class(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body_state_class"));

        if ((($tmp = ((array_key_exists("authTransition", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["authTransition"]) || array_key_exists("authTransition", $context) ? $context["authTransition"] : (function () { throw new RuntimeError('Variable "authTransition" does not exist.', 4, $this->source); })()), false)) : (false))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " auth-entry";
        }
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_eyebrow(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "eyebrow"));

        yield "Control Center";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 6
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_heading(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "heading"));

        yield "Administrative Operations Dashboard";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 7
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_subhead(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "subhead"));

        yield "Executive visibility into equipment reliability, maintenance pressure, and operational spend across AgriSense infrastructure.";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 8
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_collapsed_state(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "collapsed_state"));

        yield "true";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 10
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 11
        yield "    <section class=\"ops-kpi-grid\">
        <article class=\"ops-kpi\">
            <span class=\"k\">Total Equipments</span>
            <strong>";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["kpis"]) || array_key_exists("kpis", $context) ? $context["kpis"] : (function () { throw new RuntimeError('Variable "kpis" does not exist.', 14, $this->source); })()), "totalEquipments", [], "any", false, false, false, 14), "html", null, true);
        yield "</strong>
            <small>Tracked assets in system</small>
        </article>
        <article class=\"ops-kpi\">
            <span class=\"k\">Maintenance Records</span>
            <strong>";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["kpis"]) || array_key_exists("kpis", $context) ? $context["kpis"] : (function () { throw new RuntimeError('Variable "kpis" does not exist.', 19, $this->source); })()), "totalMaintenances", [], "any", false, false, false, 19), "html", null, true);
        yield "</strong>
            <small>Historical interventions</small>
        </article>
        <article class=\"ops-kpi\">
            <span class=\"k\">Ready Fleet Ratio</span>
            <strong>";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["kpis"]) || array_key_exists("kpis", $context) ? $context["kpis"] : (function () { throw new RuntimeError('Variable "kpis" does not exist.', 24, $this->source); })()), "readyRate", [], "any", false, false, false, 24), "html", null, true);
        yield "%</strong>
            <small>Operational availability</small>
        </article>
        <article class=\"ops-kpi\">
            <span class=\"k\">Avg Maintenance Cost</span>
            <strong>";
        // line 29
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(CoreExtension::getAttribute($this->env, $this->source, (isset($context["kpis"]) || array_key_exists("kpis", $context) ? $context["kpis"] : (function () { throw new RuntimeError('Variable "kpis" does not exist.', 29, $this->source); })()), "avgMaintenanceCost", [], "any", false, false, false, 29), 2, ".", ","), "html", null, true);
        yield "</strong>
            <small>Per maintenance event</small>
        </article>
    </section>

    <section class=\"ops-grid\">
        <article class=\"ops-panel ops-panel-wide\">
            <header>
                <h3>Maintenance Cost Curve (Last Months)</h3>
                <span class=\"tag\">Financial trend line</span>
            </header>
            <svg viewBox=\"0 0 820 260\" class=\"trend-svg\" id=\"ops-cost-curve\" data-labels='";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(json_encode((isset($context["costLabels"]) || array_key_exists("costLabels", $context) ? $context["costLabels"] : (function () { throw new RuntimeError('Variable "costLabels" does not exist.', 40, $this->source); })())), "html_attr");
        yield "' data-values='";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(json_encode((isset($context["costValues"]) || array_key_exists("costValues", $context) ? $context["costValues"] : (function () { throw new RuntimeError('Variable "costValues" does not exist.', 40, $this->source); })())), "html_attr");
        yield "'>
                <defs>
                    <linearGradient id=\"ops-cost-fill\" x1=\"0\" y1=\"0\" x2=\"0\" y2=\"1\">
                        <stop offset=\"0%\" stop-color=\"rgba(137, 205, 155, 0.46)\" />
                        <stop offset=\"100%\" stop-color=\"rgba(137, 205, 155, 0.05)\" />
                    </linearGradient>
                </defs>
                <g class=\"grid-lines\"></g>
                <path class=\"trend-area\" d=\"\"></path>
                <path class=\"trend-line\" d=\"\"></path>
                <g class=\"trend-points\"></g>
                <g class=\"trend-labels\"></g>
            </svg>
        </article>

        <article class=\"ops-panel\">
            <header>
                <h3>Equipment Status Composition</h3>
                <span class=\"tag\">Donut chart</span>
            </header>
            ";
        // line 60
        $context["totalStatus"] = ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["statusCounts"]) || array_key_exists("statusCounts", $context) ? $context["statusCounts"] : (function () { throw new RuntimeError('Variable "statusCounts" does not exist.', 60, $this->source); })()), "Ready", [], "any", false, false, false, 60) + CoreExtension::getAttribute($this->env, $this->source, (isset($context["statusCounts"]) || array_key_exists("statusCounts", $context) ? $context["statusCounts"] : (function () { throw new RuntimeError('Variable "statusCounts" does not exist.', 60, $this->source); })()), "Service", [], "any", false, false, false, 60)) + CoreExtension::getAttribute($this->env, $this->source, (isset($context["statusCounts"]) || array_key_exists("statusCounts", $context) ? $context["statusCounts"] : (function () { throw new RuntimeError('Variable "statusCounts" does not exist.', 60, $this->source); })()), "Offline", [], "any", false, false, false, 60));
        // line 61
        yield "            ";
        $context["safeTotalStatus"] = ((((isset($context["totalStatus"]) || array_key_exists("totalStatus", $context) ? $context["totalStatus"] : (function () { throw new RuntimeError('Variable "totalStatus" does not exist.', 61, $this->source); })()) > 0)) ? ((isset($context["totalStatus"]) || array_key_exists("totalStatus", $context) ? $context["totalStatus"] : (function () { throw new RuntimeError('Variable "totalStatus" does not exist.', 61, $this->source); })())) : (1));
        // line 62
        yield "            ";
        $context["readyP"] = Twig\Extension\CoreExtension::round(((CoreExtension::getAttribute($this->env, $this->source, (isset($context["statusCounts"]) || array_key_exists("statusCounts", $context) ? $context["statusCounts"] : (function () { throw new RuntimeError('Variable "statusCounts" does not exist.', 62, $this->source); })()), "Ready", [], "any", false, false, false, 62) / (isset($context["safeTotalStatus"]) || array_key_exists("safeTotalStatus", $context) ? $context["safeTotalStatus"] : (function () { throw new RuntimeError('Variable "safeTotalStatus" does not exist.', 62, $this->source); })())) * 100), 1);
        // line 63
        yield "            ";
        $context["serviceP"] = Twig\Extension\CoreExtension::round(((CoreExtension::getAttribute($this->env, $this->source, (isset($context["statusCounts"]) || array_key_exists("statusCounts", $context) ? $context["statusCounts"] : (function () { throw new RuntimeError('Variable "statusCounts" does not exist.', 63, $this->source); })()), "Service", [], "any", false, false, false, 63) / (isset($context["safeTotalStatus"]) || array_key_exists("safeTotalStatus", $context) ? $context["safeTotalStatus"] : (function () { throw new RuntimeError('Variable "safeTotalStatus" does not exist.', 63, $this->source); })())) * 100), 1);
        // line 64
        yield "            ";
        $context["offlineP"] = Twig\Extension\CoreExtension::round(((CoreExtension::getAttribute($this->env, $this->source, (isset($context["statusCounts"]) || array_key_exists("statusCounts", $context) ? $context["statusCounts"] : (function () { throw new RuntimeError('Variable "statusCounts" does not exist.', 64, $this->source); })()), "Offline", [], "any", false, false, false, 64) / (isset($context["safeTotalStatus"]) || array_key_exists("safeTotalStatus", $context) ? $context["safeTotalStatus"] : (function () { throw new RuntimeError('Variable "safeTotalStatus" does not exist.', 64, $this->source); })())) * 100), 1);
        // line 65
        yield "            <div class=\"pie-wrap\">
                <div class=\"pie\" style=\"background: conic-gradient(#89b66b 0 ";
        // line 66
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["readyP"]) || array_key_exists("readyP", $context) ? $context["readyP"] : (function () { throw new RuntimeError('Variable "readyP" does not exist.', 66, $this->source); })()), "html", null, true);
        yield "%, #f0b75f ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["readyP"]) || array_key_exists("readyP", $context) ? $context["readyP"] : (function () { throw new RuntimeError('Variable "readyP" does not exist.', 66, $this->source); })()), "html", null, true);
        yield "% ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((isset($context["readyP"]) || array_key_exists("readyP", $context) ? $context["readyP"] : (function () { throw new RuntimeError('Variable "readyP" does not exist.', 66, $this->source); })()) + (isset($context["serviceP"]) || array_key_exists("serviceP", $context) ? $context["serviceP"] : (function () { throw new RuntimeError('Variable "serviceP" does not exist.', 66, $this->source); })())), "html", null, true);
        yield "%, #d86a5b ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((isset($context["readyP"]) || array_key_exists("readyP", $context) ? $context["readyP"] : (function () { throw new RuntimeError('Variable "readyP" does not exist.', 66, $this->source); })()) + (isset($context["serviceP"]) || array_key_exists("serviceP", $context) ? $context["serviceP"] : (function () { throw new RuntimeError('Variable "serviceP" does not exist.', 66, $this->source); })())), "html", null, true);
        yield "% 100%);\"></div>
                <ul class=\"legend\">
                    <li><span class=\"dot\" style=\"background:#89b66b\"></span><span>Ready (";
        // line 68
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["statusCounts"]) || array_key_exists("statusCounts", $context) ? $context["statusCounts"] : (function () { throw new RuntimeError('Variable "statusCounts" does not exist.', 68, $this->source); })()), "Ready", [], "any", false, false, false, 68), "html", null, true);
        yield ")</span><strong>";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["readyP"]) || array_key_exists("readyP", $context) ? $context["readyP"] : (function () { throw new RuntimeError('Variable "readyP" does not exist.', 68, $this->source); })()), "html", null, true);
        yield "%</strong></li>
                    <li><span class=\"dot\" style=\"background:#f0b75f\"></span><span>Service (";
        // line 69
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["statusCounts"]) || array_key_exists("statusCounts", $context) ? $context["statusCounts"] : (function () { throw new RuntimeError('Variable "statusCounts" does not exist.', 69, $this->source); })()), "Service", [], "any", false, false, false, 69), "html", null, true);
        yield ")</span><strong>";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["serviceP"]) || array_key_exists("serviceP", $context) ? $context["serviceP"] : (function () { throw new RuntimeError('Variable "serviceP" does not exist.', 69, $this->source); })()), "html", null, true);
        yield "%</strong></li>
                    <li><span class=\"dot\" style=\"background:#d86a5b\"></span><span>Offline (";
        // line 70
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["statusCounts"]) || array_key_exists("statusCounts", $context) ? $context["statusCounts"] : (function () { throw new RuntimeError('Variable "statusCounts" does not exist.', 70, $this->source); })()), "Offline", [], "any", false, false, false, 70), "html", null, true);
        yield ")</span><strong>";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["offlineP"]) || array_key_exists("offlineP", $context) ? $context["offlineP"] : (function () { throw new RuntimeError('Variable "offlineP" does not exist.', 70, $this->source); })()), "html", null, true);
        yield "%</strong></li>
                </ul>
            </div>
        </article>

        <article class=\"ops-panel\">
            <header>
                <h3>Top Equipment Types</h3>
                <span class=\"tag\">Bar distribution</span>
            </header>
            ";
        // line 80
        $context["maxType"] = 1;
        // line 81
        yield "            ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["topTypes"]) || array_key_exists("topTypes", $context) ? $context["topTypes"] : (function () { throw new RuntimeError('Variable "topTypes" does not exist.', 81, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["value"]) {
            // line 82
            yield "                ";
            if (($context["value"] > (isset($context["maxType"]) || array_key_exists("maxType", $context) ? $context["maxType"] : (function () { throw new RuntimeError('Variable "maxType" does not exist.', 82, $this->source); })()))) {
                $context["maxType"] = $context["value"];
            }
            // line 83
            yield "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['value'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 84
        yield "            <ul class=\"ops-bar-list\">
                ";
        // line 85
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["topTypes"]) || array_key_exists("topTypes", $context) ? $context["topTypes"] : (function () { throw new RuntimeError('Variable "topTypes" does not exist.', 85, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["label"] => $context["value"]) {
            // line 86
            yield "                    <li>
                        <div class=\"meta\"><span>";
            // line 87
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["label"], "html", null, true);
            yield "</span><strong>";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["value"], "html", null, true);
            yield "</strong></div>
                        <div class=\"track\"><span style=\"width: ";
            // line 88
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::round((($context["value"] / (isset($context["maxType"]) || array_key_exists("maxType", $context) ? $context["maxType"] : (function () { throw new RuntimeError('Variable "maxType" does not exist.', 88, $this->source); })())) * 100), 1), "html", null, true);
            yield "%\"></span></div>
                    </li>
                ";
            $context['_iterated'] = true;
        }
        // line 90
        if (!$context['_iterated']) {
            // line 91
            yield "                    <li class=\"ops-empty\">No equipment type data.</li>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['label'], $context['value'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 93
        yield "            </ul>
        </article>

        <article class=\"ops-panel\">
            <header>
                <h3>Top Maintenance Categories</h3>
                <span class=\"tag\">Bar distribution</span>
            </header>
            ";
        // line 101
        $context["maxMaintenanceType"] = 1;
        // line 102
        yield "            ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["topMaintenanceTypes"]) || array_key_exists("topMaintenanceTypes", $context) ? $context["topMaintenanceTypes"] : (function () { throw new RuntimeError('Variable "topMaintenanceTypes" does not exist.', 102, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["value"]) {
            // line 103
            yield "                ";
            if (($context["value"] > (isset($context["maxMaintenanceType"]) || array_key_exists("maxMaintenanceType", $context) ? $context["maxMaintenanceType"] : (function () { throw new RuntimeError('Variable "maxMaintenanceType" does not exist.', 103, $this->source); })()))) {
                $context["maxMaintenanceType"] = $context["value"];
            }
            // line 104
            yield "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['value'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 105
        yield "            <ul class=\"ops-bar-list\">
                ";
        // line 106
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["topMaintenanceTypes"]) || array_key_exists("topMaintenanceTypes", $context) ? $context["topMaintenanceTypes"] : (function () { throw new RuntimeError('Variable "topMaintenanceTypes" does not exist.', 106, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["label"] => $context["value"]) {
            // line 107
            yield "                    <li>
                        <div class=\"meta\"><span>";
            // line 108
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["label"], "html", null, true);
            yield "</span><strong>";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["value"], "html", null, true);
            yield "</strong></div>
                        <div class=\"track\"><span style=\"width: ";
            // line 109
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::round((($context["value"] / (isset($context["maxMaintenanceType"]) || array_key_exists("maxMaintenanceType", $context) ? $context["maxMaintenanceType"] : (function () { throw new RuntimeError('Variable "maxMaintenanceType" does not exist.', 109, $this->source); })())) * 100), 1), "html", null, true);
            yield "%\"></span></div>
                    </li>
                ";
            $context['_iterated'] = true;
        }
        // line 111
        if (!$context['_iterated']) {
            // line 112
            yield "                    <li class=\"ops-empty\">No maintenance category data.</li>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['label'], $context['value'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 114
        yield "            </ul>
        </article>

        <article class=\"ops-panel\">
            <header>
                <h3>Admin Actions</h3>
                <span class=\"tag\">Quick access</span>
            </header>
            <div class=\"ops-actions\">
                <a class=\"primary\" href=\"";
        // line 123
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_equipments");
        yield "\">Open E&M Management</a>
            </div>
            <p class=\"ops-note\">This dashboard is administrative only and focused on supervision and operational decisions.</p>
        </article>
    </section>

    <script>
        function drawOpsCurve() {
            const svg = document.getElementById('ops-cost-curve');
            if (!svg) {
                return;
            }

            const labels = JSON.parse(svg.dataset.labels || '[]');
            const values = JSON.parse(svg.dataset.values || '[]').map((v) => Number(v));
            if (!Array.isArray(values) || values.length === 0) {
                return;
            }

            const width = 820;
            const height = 260;
            const paddingX = 42;
            const paddingTop = 24;
            const paddingBottom = 42;
            const chartHeight = height - paddingTop - paddingBottom;
            const chartWidth = width - paddingX * 2;
            const min = Math.min(...values, 0);
            const max = Math.max(...values, 1);
            const range = Math.max(max - min, 1);

            const points = values.map((value, index) => {
                const x = paddingX + (index * chartWidth) / Math.max(values.length - 1, 1);
                const y = paddingTop + (1 - (value - min) / range) * chartHeight;
                return { x, y, value, label: labels[index] || '' };
            });

            const linePath = points.map((point, index) => `\${index === 0 ? 'M' : 'L'} \${point.x.toFixed(2)} \${point.y.toFixed(2)}`).join(' ');
            const areaPath = `\${linePath} L \${points[points.length - 1].x.toFixed(2)} \${(height - paddingBottom).toFixed(2)} L \${points[0].x.toFixed(2)} \${(height - paddingBottom).toFixed(2)} Z`;

            const grid = svg.querySelector('.grid-lines');
            const line = svg.querySelector('.trend-line');
            const area = svg.querySelector('.trend-area');
            const pointsGroup = svg.querySelector('.trend-points');
            const labelsGroup = svg.querySelector('.trend-labels');

            if (!grid || !line || !area || !pointsGroup || !labelsGroup) {
                return;
            }

            let gridHtml = '';
            for (let i = 0; i <= 4; i += 1) {
                const y = paddingTop + (i * chartHeight) / 4;
                gridHtml += `<line x1=\"\${paddingX}\" y1=\"\${y}\" x2=\"\${width - paddingX}\" y2=\"\${y}\"></line>`;
            }
            grid.innerHTML = gridHtml;

            line.setAttribute('d', linePath);
            area.setAttribute('d', areaPath);

            pointsGroup.innerHTML = points
                .map((point) => `<circle cx=\"\${point.x.toFixed(2)}\" cy=\"\${point.y.toFixed(2)}\" r=\"4\"></circle>`)
                .join('');

            labelsGroup.innerHTML = points
                .map((point) => `<text x=\"\${point.x.toFixed(2)}\" y=\"\${height - 16}\" text-anchor=\"middle\">\${point.label.slice(2)}</text>`)
                .join('');
        }

        drawOpsCurve();
    </script>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "admin/home.html.twig";
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
        return array (  423 => 123,  412 => 114,  405 => 112,  403 => 111,  396 => 109,  390 => 108,  387 => 107,  382 => 106,  379 => 105,  373 => 104,  368 => 103,  363 => 102,  361 => 101,  351 => 93,  344 => 91,  342 => 90,  335 => 88,  329 => 87,  326 => 86,  321 => 85,  318 => 84,  312 => 83,  307 => 82,  302 => 81,  300 => 80,  285 => 70,  279 => 69,  273 => 68,  262 => 66,  259 => 65,  256 => 64,  253 => 63,  250 => 62,  247 => 61,  245 => 60,  220 => 40,  206 => 29,  198 => 24,  190 => 19,  182 => 14,  177 => 11,  167 => 10,  150 => 8,  133 => 7,  116 => 6,  99 => 5,  80 => 4,  63 => 3,  46 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'admin/layout.html.twig' %}

{% block title %}Admin Operations Dashboard{% endblock %}
{% block body_state_class %}{% if authTransition|default(false) %} auth-entry{% endif %}{% endblock %}
{% block eyebrow %}Control Center{% endblock %}
{% block heading %}Administrative Operations Dashboard{% endblock %}
{% block subhead %}Executive visibility into equipment reliability, maintenance pressure, and operational spend across AgriSense infrastructure.{% endblock %}
{% block collapsed_state %}true{% endblock %}

{% block body %}
    <section class=\"ops-kpi-grid\">
        <article class=\"ops-kpi\">
            <span class=\"k\">Total Equipments</span>
            <strong>{{ kpis.totalEquipments }}</strong>
            <small>Tracked assets in system</small>
        </article>
        <article class=\"ops-kpi\">
            <span class=\"k\">Maintenance Records</span>
            <strong>{{ kpis.totalMaintenances }}</strong>
            <small>Historical interventions</small>
        </article>
        <article class=\"ops-kpi\">
            <span class=\"k\">Ready Fleet Ratio</span>
            <strong>{{ kpis.readyRate }}%</strong>
            <small>Operational availability</small>
        </article>
        <article class=\"ops-kpi\">
            <span class=\"k\">Avg Maintenance Cost</span>
            <strong>{{ kpis.avgMaintenanceCost|number_format(2, '.', ',') }}</strong>
            <small>Per maintenance event</small>
        </article>
    </section>

    <section class=\"ops-grid\">
        <article class=\"ops-panel ops-panel-wide\">
            <header>
                <h3>Maintenance Cost Curve (Last Months)</h3>
                <span class=\"tag\">Financial trend line</span>
            </header>
            <svg viewBox=\"0 0 820 260\" class=\"trend-svg\" id=\"ops-cost-curve\" data-labels='{{ costLabels|json_encode|e('html_attr') }}' data-values='{{ costValues|json_encode|e('html_attr') }}'>
                <defs>
                    <linearGradient id=\"ops-cost-fill\" x1=\"0\" y1=\"0\" x2=\"0\" y2=\"1\">
                        <stop offset=\"0%\" stop-color=\"rgba(137, 205, 155, 0.46)\" />
                        <stop offset=\"100%\" stop-color=\"rgba(137, 205, 155, 0.05)\" />
                    </linearGradient>
                </defs>
                <g class=\"grid-lines\"></g>
                <path class=\"trend-area\" d=\"\"></path>
                <path class=\"trend-line\" d=\"\"></path>
                <g class=\"trend-points\"></g>
                <g class=\"trend-labels\"></g>
            </svg>
        </article>

        <article class=\"ops-panel\">
            <header>
                <h3>Equipment Status Composition</h3>
                <span class=\"tag\">Donut chart</span>
            </header>
            {% set totalStatus = statusCounts.Ready + statusCounts.Service + statusCounts.Offline %}
            {% set safeTotalStatus = totalStatus > 0 ? totalStatus : 1 %}
            {% set readyP = (statusCounts.Ready / safeTotalStatus * 100)|round(1) %}
            {% set serviceP = (statusCounts.Service / safeTotalStatus * 100)|round(1) %}
            {% set offlineP = (statusCounts.Offline / safeTotalStatus * 100)|round(1) %}
            <div class=\"pie-wrap\">
                <div class=\"pie\" style=\"background: conic-gradient(#89b66b 0 {{ readyP }}%, #f0b75f {{ readyP }}% {{ (readyP + serviceP) }}%, #d86a5b {{ (readyP + serviceP) }}% 100%);\"></div>
                <ul class=\"legend\">
                    <li><span class=\"dot\" style=\"background:#89b66b\"></span><span>Ready ({{ statusCounts.Ready }})</span><strong>{{ readyP }}%</strong></li>
                    <li><span class=\"dot\" style=\"background:#f0b75f\"></span><span>Service ({{ statusCounts.Service }})</span><strong>{{ serviceP }}%</strong></li>
                    <li><span class=\"dot\" style=\"background:#d86a5b\"></span><span>Offline ({{ statusCounts.Offline }})</span><strong>{{ offlineP }}%</strong></li>
                </ul>
            </div>
        </article>

        <article class=\"ops-panel\">
            <header>
                <h3>Top Equipment Types</h3>
                <span class=\"tag\">Bar distribution</span>
            </header>
            {% set maxType = 1 %}
            {% for value in topTypes %}
                {% if value > maxType %}{% set maxType = value %}{% endif %}
            {% endfor %}
            <ul class=\"ops-bar-list\">
                {% for label, value in topTypes %}
                    <li>
                        <div class=\"meta\"><span>{{ label }}</span><strong>{{ value }}</strong></div>
                        <div class=\"track\"><span style=\"width: {{ (value / maxType * 100)|round(1) }}%\"></span></div>
                    </li>
                {% else %}
                    <li class=\"ops-empty\">No equipment type data.</li>
                {% endfor %}
            </ul>
        </article>

        <article class=\"ops-panel\">
            <header>
                <h3>Top Maintenance Categories</h3>
                <span class=\"tag\">Bar distribution</span>
            </header>
            {% set maxMaintenanceType = 1 %}
            {% for value in topMaintenanceTypes %}
                {% if value > maxMaintenanceType %}{% set maxMaintenanceType = value %}{% endif %}
            {% endfor %}
            <ul class=\"ops-bar-list\">
                {% for label, value in topMaintenanceTypes %}
                    <li>
                        <div class=\"meta\"><span>{{ label }}</span><strong>{{ value }}</strong></div>
                        <div class=\"track\"><span style=\"width: {{ (value / maxMaintenanceType * 100)|round(1) }}%\"></span></div>
                    </li>
                {% else %}
                    <li class=\"ops-empty\">No maintenance category data.</li>
                {% endfor %}
            </ul>
        </article>

        <article class=\"ops-panel\">
            <header>
                <h3>Admin Actions</h3>
                <span class=\"tag\">Quick access</span>
            </header>
            <div class=\"ops-actions\">
                <a class=\"primary\" href=\"{{ path('admin_management_equipments') }}\">Open E&M Management</a>
            </div>
            <p class=\"ops-note\">This dashboard is administrative only and focused on supervision and operational decisions.</p>
        </article>
    </section>

    <script>
        function drawOpsCurve() {
            const svg = document.getElementById('ops-cost-curve');
            if (!svg) {
                return;
            }

            const labels = JSON.parse(svg.dataset.labels || '[]');
            const values = JSON.parse(svg.dataset.values || '[]').map((v) => Number(v));
            if (!Array.isArray(values) || values.length === 0) {
                return;
            }

            const width = 820;
            const height = 260;
            const paddingX = 42;
            const paddingTop = 24;
            const paddingBottom = 42;
            const chartHeight = height - paddingTop - paddingBottom;
            const chartWidth = width - paddingX * 2;
            const min = Math.min(...values, 0);
            const max = Math.max(...values, 1);
            const range = Math.max(max - min, 1);

            const points = values.map((value, index) => {
                const x = paddingX + (index * chartWidth) / Math.max(values.length - 1, 1);
                const y = paddingTop + (1 - (value - min) / range) * chartHeight;
                return { x, y, value, label: labels[index] || '' };
            });

            const linePath = points.map((point, index) => `\${index === 0 ? 'M' : 'L'} \${point.x.toFixed(2)} \${point.y.toFixed(2)}`).join(' ');
            const areaPath = `\${linePath} L \${points[points.length - 1].x.toFixed(2)} \${(height - paddingBottom).toFixed(2)} L \${points[0].x.toFixed(2)} \${(height - paddingBottom).toFixed(2)} Z`;

            const grid = svg.querySelector('.grid-lines');
            const line = svg.querySelector('.trend-line');
            const area = svg.querySelector('.trend-area');
            const pointsGroup = svg.querySelector('.trend-points');
            const labelsGroup = svg.querySelector('.trend-labels');

            if (!grid || !line || !area || !pointsGroup || !labelsGroup) {
                return;
            }

            let gridHtml = '';
            for (let i = 0; i <= 4; i += 1) {
                const y = paddingTop + (i * chartHeight) / 4;
                gridHtml += `<line x1=\"\${paddingX}\" y1=\"\${y}\" x2=\"\${width - paddingX}\" y2=\"\${y}\"></line>`;
            }
            grid.innerHTML = gridHtml;

            line.setAttribute('d', linePath);
            area.setAttribute('d', areaPath);

            pointsGroup.innerHTML = points
                .map((point) => `<circle cx=\"\${point.x.toFixed(2)}\" cy=\"\${point.y.toFixed(2)}\" r=\"4\"></circle>`)
                .join('');

            labelsGroup.innerHTML = points
                .map((point) => `<text x=\"\${point.x.toFixed(2)}\" y=\"\${height - 16}\" text-anchor=\"middle\">\${point.label.slice(2)}</text>`)
                .join('');
        }

        drawOpsCurve();
    </script>
{% endblock %}
", "admin/home.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\admin\\home.html.twig");
    }
}
