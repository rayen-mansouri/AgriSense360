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

/* management/workers.html.twig */
class __TwigTemplate_07c995ff1a3bcb5b3e3e33842bfca975 extends Template
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
            'eyebrow' => [$this, 'block_eyebrow'],
            'heading' => [$this, 'block_heading'],
            'subhead' => [$this, 'block_subhead'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return $this->load((((($tmp = ((array_key_exists("adminMode", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 1, $this->source); })()), false)) : (false))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("admin/layout.html.twig") : ("management/layout.html.twig")), 1);
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "management/workers.html.twig"));

        yield from $this->getParent($context)->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
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

        yield "Workers Management";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 4
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_eyebrow(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "eyebrow"));

        yield "Workers Management";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_heading(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "heading"));

        yield "Task assignments and evaluations";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 6
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_subhead(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "subhead"));

        yield "Manage affectations and worker performance evaluations";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 8
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 9
        yield "<!-- Chart.js for statistics visualization -->
<script src=\"https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js\"></script>

<!-- Admin Selected User Scope (Only visible in admin mode) -->
";
        // line 13
        if (((isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 13, $this->source); })()) && array_key_exists("availableUsers", $context))) {
            // line 14
            yield "<section class=\"telemetry-panel\" style=\"margin-bottom: 18px;\">
    <header>
        <h3>Selected User Scope</h3>
        <span class=\"tag\">Admin can manage worker assignments per user account</span>
    </header>
    <form method=\"get\" action=\"";
            // line 19
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_workers");
            yield "\" style=\"display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;\">
        <label style=\"min-width:280px; display:grid; gap:6px;\">
            <span>User</span>
            <select class=\"input\" name=\"user_id\" required onchange=\"this.form.submit()\">
                ";
            // line 23
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["availableUsers"]) || array_key_exists("availableUsers", $context) ? $context["availableUsers"] : (function () { throw new RuntimeError('Variable "availableUsers" does not exist.', 23, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
                // line 24
                yield "                    <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 24), "html", null, true);
                yield "\" ";
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 24) == (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 24, $this->source); })()))) {
                    yield "selected";
                }
                yield ">
                        #";
                // line 25
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 25), "html", null, true);
                yield " - ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "firstName", [], "any", false, false, false, 25), "html", null, true);
                yield " ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "lastName", [], "any", false, false, false, 25), "html", null, true);
                yield " (";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "roleName", [], "any", false, false, false, 25), "html", null, true);
                yield ")
                    </option>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['user'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 28
            yield "            </select>
        </label>
    </form>
</section>
";
        }
        // line 33
        yield "
<!-- Weather & AI Recommendations (for admin) -->
";
        // line 35
        if (((isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 35, $this->source); })()) && array_key_exists("aiOptimization", $context))) {
            // line 36
            yield "<section class=\"telemetry-panel\" style=\"margin-bottom: 18px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;\">
    <header>
        <h3>🤖 AI Task Optimization</h3>
        <span class=\"tag\" style=\"background: rgba(255,255,255,0.2);\">Groq AI Recommendations</span>
    </header>
    <div style=\"padding: 16px; background: rgba(0,0,0,0.1); border-radius: 8px; font-size: 14px; line-height: 1.6;\">
        ";
            // line 42
            yield Twig\Extension\CoreExtension::nl2br($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["aiOptimization"]) || array_key_exists("aiOptimization", $context) ? $context["aiOptimization"] : (function () { throw new RuntimeError('Variable "aiOptimization" does not exist.', 42, $this->source); })()), "html", null, true));
            yield "
    </div>
</section>
";
        }
        // line 46
        yield "
<!-- Weather Data (if available) -->
";
        // line 48
        if (((array_key_exists("weatherData", $context) && CoreExtension::getAttribute($this->env, $this->source, ($context["weatherData"] ?? null), "current", [], "any", true, true, false, 48)) && (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["weatherData"]) || array_key_exists("weatherData", $context) ? $context["weatherData"] : (function () { throw new RuntimeError('Variable "weatherData" does not exist.', 48, $this->source); })()), "current", [], "any", false, false, false, 48), "cod", [], "any", false, false, false, 48) == 200))) {
            // line 49
            yield "<section class=\"telemetry-panel\" style=\"margin-bottom: 18px;\">
    <header>
        <h3>🌤️ Current Weather & 5-Day Forecast</h3>
        <span class=\"tag\">OpenWeather API - Real-time + Forecast</span>
    </header>

    <!-- Current Weather (Large) -->
    ";
            // line 56
            $context["current"] = CoreExtension::getAttribute($this->env, $this->source, (isset($context["weatherData"]) || array_key_exists("weatherData", $context) ? $context["weatherData"] : (function () { throw new RuntimeError('Variable "weatherData" does not exist.', 56, $this->source); })()), "current", [], "any", false, false, false, 56);
            // line 57
            yield "    <div style=\"padding: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; margin-bottom: 16px;\">
        <div style=\"display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 16px; text-align: center;\">
            <div>
                <span style=\"font-size: 32px; font-weight: bold;\">";
            // line 60
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::round(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["current"]) || array_key_exists("current", $context) ? $context["current"] : (function () { throw new RuntimeError('Variable "current" does not exist.', 60, $this->source); })()), "main", [], "any", false, false, false, 60), "temp", [], "any", false, false, false, 60), 1), "html", null, true);
            yield "°C</span>
                <small style=\"display: block; margin-top: 4px;\">Current Temperature</small>
            </div>
            <div>
                <span style=\"font-size: 28px;\">💧</span>
                <span style=\"font-size: 20px; font-weight: bold;\">";
            // line 65
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["current"]) || array_key_exists("current", $context) ? $context["current"] : (function () { throw new RuntimeError('Variable "current" does not exist.', 65, $this->source); })()), "main", [], "any", false, false, false, 65), "humidity", [], "any", false, false, false, 65), "html", null, true);
            yield "%</span>
                <small style=\"display: block;\">Humidity</small>
            </div>
            <div>
                <span style=\"font-size: 28px;\">💨</span>
                <span style=\"font-size: 20px; font-weight: bold;\">";
            // line 70
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::round(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["current"]) || array_key_exists("current", $context) ? $context["current"] : (function () { throw new RuntimeError('Variable "current" does not exist.', 70, $this->source); })()), "wind", [], "any", false, false, false, 70), "speed", [], "any", false, false, false, 70), 1), "html", null, true);
            yield " m/s</span>
                <small style=\"display: block;\">Wind Speed</small>
            </div>
            <div>
                <span style=\"font-size: 24px; text-transform: capitalize;\">";
            // line 74
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["current"]) || array_key_exists("current", $context) ? $context["current"] : (function () { throw new RuntimeError('Variable "current" does not exist.', 74, $this->source); })()), "weather", [], "any", false, false, false, 74), 0, [], "array", false, false, false, 74), "main", [], "any", false, false, false, 74), "html", null, true);
            yield "</span>
                <small style=\"display: block;\">";
            // line 75
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::capitalize($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["current"]) || array_key_exists("current", $context) ? $context["current"] : (function () { throw new RuntimeError('Variable "current" does not exist.', 75, $this->source); })()), "weather", [], "any", false, false, false, 75), 0, [], "array", false, false, false, 75), "description", [], "any", false, false, false, 75)), "html", null, true);
            yield "</small>
            </div>
        </div>
    </div>

    <!-- 5-Day Forecast -->
    <div>
        <h4 style=\"margin-bottom: 12px; color: #333;\">5-Day Forecast</h4>
        <div style=\"display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px;\">
            ";
            // line 84
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, (isset($context["weatherData"]) || array_key_exists("weatherData", $context) ? $context["weatherData"] : (function () { throw new RuntimeError('Variable "weatherData" does not exist.', 84, $this->source); })()), "list", [], "any", false, false, false, 84), 0, 8));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 85
                yield "            <div style=\"padding: 12px; border: 1px solid #e0e0e0; border-radius: 6px; background: #f9f9f9; text-align: center;\">
                <strong style=\"font-size: 12px; color: #666; display: block; margin-bottom: 6px;\">";
                // line 86
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "dt_txt", [], "any", false, false, false, 86), "H:i"), "html", null, true);
                yield "</strong>
                <span style=\"font-size: 18px; font-weight: bold; display: block;\">";
                // line 87
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::round(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "main", [], "any", false, false, false, 87), "temp", [], "any", false, false, false, 87)), "html", null, true);
                yield "°C</span>
                <small style=\"color: #666; display: block; margin: 4px 0;\">";
                // line 88
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "weather", [], "any", false, false, false, 88), 0, [], "array", false, false, false, 88), "main", [], "any", false, false, false, 88), "html", null, true);
                yield "</small>
                <small style=\"color: #666;\">💧 ";
                // line 89
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "main", [], "any", false, false, false, 89), "humidity", [], "any", false, false, false, 89), "html", null, true);
                yield "%</small>
            </div>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 92
            yield "        </div>
    </div>
</section>
";
        }
        // line 96
        yield "
<!-- AI Insights & Performance Reports -->
";
        // line 98
        if (((((Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["evaluations"]) || array_key_exists("evaluations", $context) ? $context["evaluations"] : (function () { throw new RuntimeError('Variable "evaluations" does not exist.', 98, $this->source); })())) > 0) || (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 98, $this->source); })())) && array_key_exists("stats", $context)) && CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "totalEvaluations", [], "any", true, true, false, 98))) {
            // line 99
            yield "<section class=\"telemetry-panel\" style=\"margin-bottom: 18px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;\">
    <header>
        <h3>📊 AI Performance Insights</h3>
        <span class=\"tag\" style=\"background: rgba(255,255,255,0.2);\">Groq AI - Worker Performance Analytics</span>
    </header>
    <div style=\"display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-bottom: 16px;\">
        <div style=\"padding: 12px; background: rgba(0,0,0,0.2); border-radius: 6px; text-align: center;\">
            <div style=\"font-size: 24px; font-weight: bold;\">";
            // line 106
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "totalEvaluations", [], "any", true, true, false, 106)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 106, $this->source); })()), "totalEvaluations", [], "any", false, false, false, 106), 0)) : (0)), "html", null, true);
            yield "</div>
            <small>Total Evaluations</small>
        </div>
        <div style=\"padding: 12px; background: rgba(0,0,0,0.2); border-radius: 6px; text-align: center;\">
            <div style=\"font-size: 24px; font-weight: bold;\">";
            // line 110
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "averageNote", [], "any", true, true, false, 110)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 110, $this->source); })()), "averageNote", [], "any", false, false, false, 110), 0)) : (0)), "html", null, true);
            yield "</div>
            <small>Avg Score (";
            // line 111
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "averageNote", [], "any", true, true, false, 111)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 111, $this->source); })()), "averageNote", [], "any", false, false, false, 111), 0)) : (0)), "html", null, true);
            yield "/20)</small>
        </div>
        <div style=\"padding: 12px; background: rgba(0,0,0,0.2); border-radius: 6px; text-align: center;\">
            <div style=\"font-size: 24px; font-weight: bold;\">";
            // line 114
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "excellentCount", [], "any", true, true, false, 114)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 114, $this->source); })()), "excellentCount", [], "any", false, false, false, 114), 0)) : (0)), "html", null, true);
            yield "</div>
            <small>Excellent Ratings</small>
        </div>
        <div style=\"padding: 12px; background: rgba(0,0,0,0.2); border-radius: 6px; text-align: center;\">
            <div style=\"font-size: 24px; font-weight: bold;\">";
            // line 118
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "completionRate", [], "any", true, true, false, 118)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 118, $this->source); })()), "completionRate", [], "any", false, false, false, 118), 0)) : (0)), "html", null, true);
            yield "%</div>
            <small>Completion Rate</small>
        </div>
    </div>
    <div style=\"padding: 12px; background: rgba(0,0,0,0.1); border-radius: 6px; font-size: 13px; line-height: 1.6;\">
        <strong>📈 Key Findings:</strong><br>
        ";
            // line 124
            if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 124, $this->source); })()), "averageNote", [], "any", false, false, false, 124) >= 16)) {
                // line 125
                yield "            ✓ Exceptional team performance! Average score is very high.<br>
        ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 126
(isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 126, $this->source); })()), "averageNote", [], "any", false, false, false, 126) >= 12)) {
                // line 127
                yield "            ✓ Good overall performance. Consider targeted improvements for lower scores.<br>
        ";
            } else {
                // line 129
                yield "            ⚠️ Performance needs attention. Review training programs and task assignments.<br>
        ";
            }
            // line 131
            yield "
        ";
            // line 132
            if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 132, $this->source); })()), "completionRate", [], "any", false, false, false, 132) == 100)) {
                // line 133
                yield "            ✓ All assigned tasks completed successfully!<br>
        ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 134
(isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 134, $this->source); })()), "completionRate", [], "any", false, false, false, 134) >= 80)) {
                // line 135
                yield "            ✓ Strong completion rate. Some tasks still in progress.<br>
        ";
            } else {
                // line 137
                yield "            ⚠️ Only ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 137, $this->source); })()), "completionRate", [], "any", false, false, false, 137), "html", null, true);
                yield "% tasks completed. Check for blockers.<br>
        ";
            }
            // line 139
            yield "
        ";
            // line 140
            if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 140, $this->source); })()), "excellentCount", [], "any", false, false, false, 140) > (CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 140, $this->source); })()), "totalEvaluations", [], "any", false, false, false, 140) / 2))) {
                // line 141
                yield "            ✓ More than half evaluations are excellent ratings!
        ";
            }
            // line 143
            yield "    </div>
</section>
";
        }
        // line 146
        yield "
<!-- Google Maps Integration for Worker Locations -->
";
        // line 148
        if ((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 148, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 149
            yield "<section class=\"telemetry-panel\" style=\"margin-bottom: 18px;\">
    <header>
        <h3>🗺️ Worker Locations Map & Affectations</h3>
        <span class=\"tag\">Google Maps - Farm Operations with Work Zones</span>
    </header>

    <!-- Map Container with Leaflet (Open Source Alternative) -->
    <div id=\"workerMap\" style=\"width: 100%; height: 450px; border-radius: 6px; overflow: hidden; background: #e0e0e0; margin-bottom: 12px;\">
        <!-- Leaflet Map -->
        <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css\" />
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js\"></script>
        <div id=\"map\" style=\"width: 100%; height: 100%; border-radius: 6px;\"></div>
    </div>

    <!-- Work Zone List with Weather Integration -->
    <div style=\"display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 12px;\">
        ";
            // line 165
            $context["workZones"] = [];
            // line 166
            yield "        ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["affectations"]) || array_key_exists("affectations", $context) ? $context["affectations"] : (function () { throw new RuntimeError('Variable "affectations" does not exist.', 166, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["affectation"]) {
                // line 167
                yield "            ";
                $context["zone"] = ((CoreExtension::getAttribute($this->env, $this->source, $context["affectation"], "zoneTravail", [], "any", true, true, false, 167)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["affectation"], "zoneTravail", [], "any", false, false, false, 167), "Unknown Zone")) : ("Unknown Zone"));
                // line 168
                yield "            ";
                $context["workZones"] = Twig\Extension\CoreExtension::merge((isset($context["workZones"]) || array_key_exists("workZones", $context) ? $context["workZones"] : (function () { throw new RuntimeError('Variable "workZones" does not exist.', 168, $this->source); })()), [ (string)(isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 168, $this->source); })()) => (((CoreExtension::getAttribute($this->env, $this->source, ($context["workZones"] ?? null), (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 168, $this->source); })()), [], "array", true, true, false, 168)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["workZones"]) || array_key_exists("workZones", $context) ? $context["workZones"] : (function () { throw new RuntimeError('Variable "workZones" does not exist.', 168, $this->source); })()), (isset($context["zone"]) || array_key_exists("zone", $context) ? $context["zone"] : (function () { throw new RuntimeError('Variable "zone" does not exist.', 168, $this->source); })()), [], "array", false, false, false, 168), [])) : ([])) + [$context["affectation"]])]);
                // line 169
                yield "        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['affectation'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 170
            yield "
        ";
            // line 171
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["workZones"]) || array_key_exists("workZones", $context) ? $context["workZones"] : (function () { throw new RuntimeError('Variable "workZones" does not exist.', 171, $this->source); })()));
            foreach ($context['_seq'] as $context["zone"] => $context["zoneAffectations"]) {
                // line 172
                yield "        <div style=\"padding: 12px; border: 2px solid #667eea; border-radius: 6px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);\">
            <strong style=\"color: #667eea; font-size: 14px;\">📍 ";
                // line 173
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["zone"], "html", null, true);
                yield "</strong>
            <div style=\"margin-top: 8px; font-size: 12px; line-height: 1.6; color: #333;\">
                <span style=\"background: #667eea; color: white; padding: 2px 6px; border-radius: 3px; display: inline-block; margin-bottom: 6px;\">";
                // line 175
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), $context["zoneAffectations"]), "html", null, true);
                yield " tasks</span>

                <!-- Zone Status Breakdown -->
                ";
                // line 178
                $context["zoneStatuses"] = [];
                // line 179
                yield "                ";
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable($context["zoneAffectations"]);
                foreach ($context['_seq'] as $context["_key"] => $context["aff"]) {
                    // line 180
                    yield "                    ";
                    $context["status"] = ((CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "statut", [], "any", true, true, false, 180)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "statut", [], "any", false, false, false, 180), "Unknown")) : ("Unknown"));
                    // line 181
                    yield "                    ";
                    $context["zoneStatuses"] = Twig\Extension\CoreExtension::merge((isset($context["zoneStatuses"]) || array_key_exists("zoneStatuses", $context) ? $context["zoneStatuses"] : (function () { throw new RuntimeError('Variable "zoneStatuses" does not exist.', 181, $this->source); })()), [ (string)(isset($context["status"]) || array_key_exists("status", $context) ? $context["status"] : (function () { throw new RuntimeError('Variable "status" does not exist.', 181, $this->source); })()) => (((CoreExtension::getAttribute($this->env, $this->source, ($context["zoneStatuses"] ?? null), (isset($context["status"]) || array_key_exists("status", $context) ? $context["status"] : (function () { throw new RuntimeError('Variable "status" does not exist.', 181, $this->source); })()), [], "array", true, true, false, 181)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["zoneStatuses"]) || array_key_exists("zoneStatuses", $context) ? $context["zoneStatuses"] : (function () { throw new RuntimeError('Variable "zoneStatuses" does not exist.', 181, $this->source); })()), (isset($context["status"]) || array_key_exists("status", $context) ? $context["status"] : (function () { throw new RuntimeError('Variable "status" does not exist.', 181, $this->source); })()), [], "array", false, false, false, 181), 0)) : (0)) + 1)]);
                    // line 182
                    yield "                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['aff'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 183
                yield "
                ";
                // line 184
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable((isset($context["zoneStatuses"]) || array_key_exists("zoneStatuses", $context) ? $context["zoneStatuses"] : (function () { throw new RuntimeError('Variable "zoneStatuses" does not exist.', 184, $this->source); })()));
                foreach ($context['_seq'] as $context["status"] => $context["count"]) {
                    // line 185
                    yield "                    <div style=\"margin-top: 4px;\">
                        📋 <strong>";
                    // line 186
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["status"], "html", null, true);
                    yield ":</strong> ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["count"], "html", null, true);
                    yield "
                    </div>
                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['status'], $context['count'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 189
                yield "
                <!-- Weather Badge for Zone -->
                ";
                // line 191
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["weatherData"] ?? null), "list", [], "any", true, true, false, 191)) {
                    // line 192
                    yield "                    <div style=\"margin-top: 8px; padding: 6px; background: white; border-radius: 3px;\">
                        <small style=\"color: #666;\">
                            🌡️ ";
                    // line 194
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::round(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["weatherData"]) || array_key_exists("weatherData", $context) ? $context["weatherData"] : (function () { throw new RuntimeError('Variable "weatherData" does not exist.', 194, $this->source); })()), "list", [], "any", false, false, false, 194), 0, [], "array", false, false, false, 194), "main", [], "any", false, false, false, 194), "temp", [], "any", false, false, false, 194)), "html", null, true);
                    yield "°C
                            💧 ";
                    // line 195
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["weatherData"]) || array_key_exists("weatherData", $context) ? $context["weatherData"] : (function () { throw new RuntimeError('Variable "weatherData" does not exist.', 195, $this->source); })()), "list", [], "any", false, false, false, 195), 0, [], "array", false, false, false, 195), "main", [], "any", false, false, false, 195), "humidity", [], "any", false, false, false, 195), "html", null, true);
                    yield "%
                        </small>
                    </div>
                ";
                }
                // line 199
                yield "            </div>
        </div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['zone'], $context['zoneAffectations'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 202
            yield "    </div>

    <small style=\"color: #666; margin-top: 12px; display: block;\">
        ✅ Dynamic map shows all work zones. Weather data integrated for task planning. Click zone cards for details.
    </small>
</section>

<script>
// Initialize Leaflet Map
document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('map').setView([36.8065, 10.1686], 8); // Tunisia center

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Mark work zones from affectations
    const zones = {
        ";
            // line 222
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["workZones"]) || array_key_exists("workZones", $context) ? $context["workZones"] : (function () { throw new RuntimeError('Variable "workZones" does not exist.', 222, $this->source); })()));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["zone"] => $context["zoneAffectations"]) {
                // line 223
                yield "            \"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["zone"], "js"), "html", null, true);
                yield "\": {
                count: ";
                // line 224
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), $context["zoneAffectations"]), "html", null, true);
                yield ",
                tasks: ";
                // line 225
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), $context["zoneAffectations"]), "html", null, true);
                yield "
            }";
                // line 226
                yield (((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 226)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (",") : (""));
                yield "
        ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['zone'], $context['zoneAffectations'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 228
            yield "    };

    // Default zone coordinates (Tunisia regions)
    const zoneCoords = {
        'Tunis': [36.8065, 10.1686],
        'Ariana': [36.8697, 10.1637],
        'Manouba': [36.8118, 10.2607],
        'Sousse': [35.8256, 10.6369],
        'Sfax': [34.7406, 10.7603],
        'Gafsa': [34.4269, 8.7838],
        'Kairouan': [35.6781, 9.5898],
        'Bizerte': [37.2744, 9.8739],
        'Gabès': [33.8869, 10.0994],
        'Kasserine': [35.1667, 8.8333]
    };

    // Add markers for each zone
    let markersAdded = 0;
    for (const zone in zones) {
        const coords = zoneCoords[zone] || [36.8065 + Math.random() * 2, 10.1686 + Math.random() * 2];
        const zoneInfo = zones[zone];

        const markerColor = zoneInfo.tasks > 5 ? 'red' : zoneInfo.tasks > 2 ? 'orange' : 'green';

        L.circleMarker(coords, {
            radius: Math.min(20, 10 + zoneInfo.tasks),
            fillColor: markerColor,
            color: '#fff',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.7
        }).bindPopup(`
            <strong>\${zone}</strong><br>
            Tasks: \${zoneInfo.count}<br>
            <small>Click for details</small>
        `).addTo(map);

        markersAdded++;
    }

    console.log('✅ Leaflet Map initialized with', markersAdded, 'zones');
});
</script>
";
        }
        // line 272
        if (((isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 272, $this->source); })()) && array_key_exists("stats", $context))) {
            // line 273
            yield "<section class=\"stats-rail\">
    <article class=\"stat-tile\">
        <span class=\"k\">Total Affectations</span>
        <span class=\"v\">";
            // line 276
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "totalAffectations", [], "any", true, true, false, 276)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 276, $this->source); })()), "totalAffectations", [], "any", false, false, false, 276), 0)) : (0)), "html", null, true);
            yield "</span>
        <small>Task assignments in system</small>
    </article>
    <article class=\"stat-tile\">
        <span class=\"k\">Completion Rate</span>
        <span class=\"v\">";
            // line 281
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "completionRate", [], "any", true, true, false, 281)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 281, $this->source); })()), "completionRate", [], "any", false, false, false, 281), 0)) : (0)), "html", null, true);
            yield "%</span>
        <small>Tasks successfully completed</small>
    </article>
    <article class=\"stat-tile\">
        <span class=\"k\">Evaluations Count</span>
        <span class=\"v\">";
            // line 286
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "totalEvaluations", [], "any", true, true, false, 286)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 286, $this->source); })()), "totalEvaluations", [], "any", false, false, false, 286), 0)) : (0)), "html", null, true);
            yield "</span>
        <small>Performance reviews</small>
    </article>
    <article class=\"stat-tile\">
        <span class=\"k\">Average Performance</span>
        <span class=\"v\">";
            // line 291
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "averageNote", [], "any", true, true, false, 291)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 291, $this->source); })()), "averageNote", [], "any", false, false, false, 291), 0)) : (0)), "html", null, true);
            yield "/20</span>
        <small>Mean worker rating</small>
    </article>
</section>

<!-- Charts and Technical Analytics Section -->
<section class=\"telemetry-grid\" style=\"margin-top: 24px;\">
    <!-- Status Distribution Chart -->
    <article class=\"telemetry-panel\">
        <header>
            <h3>Task Status Distribution</h3>
            <span class=\"tag\">Current workflow states</span>
        </header>
        <canvas id=\"statusChart\" style=\"max-height: 280px;\"></canvas>
    </article>

    <!-- Quality Distribution Chart -->
    <article class=\"telemetry-panel\">
        <header>
            <h3>Performance Quality Ratings</h3>
            <span class=\"tag\">Worker performance assessment</span>
        </header>
        <canvas id=\"qualityChart\" style=\"max-height: 280px;\"></canvas>
    </article>

    <!-- Task Type Distribution -->
    ";
            // line 317
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 317, $this->source); })()), "typeCounts", [], "any", false, false, false, 317)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 318
                yield "    <article class=\"telemetry-panel\">
        <header>
            <h3>Task Types Breakdown</h3>
            <span class=\"tag\">Distribution of work assignments</span>
        </header>
        <canvas id=\"typeChart\" style=\"max-height: 280px;\"></canvas>
    </article>
    ";
            }
            // line 326
            yield "
    <!-- Work Zones Distribution -->
    ";
            // line 328
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 328, $this->source); })()), "zoneCounts", [], "any", false, false, false, 328)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 329
                yield "    <article class=\"telemetry-panel\">
        <header>
            <h3>Work Zones Activity</h3>
            <span class=\"tag\">Geographical distribution</span>
        </header>
        <canvas id=\"zoneChart\" style=\"max-height: 280px;\"></canvas>
    </article>
    ";
            }
            // line 337
            yield "
    <!-- Technical Dashboard -->
    <article class=\"telemetry-panel\" style=\"grid-column: 1 / -1;\">
        <header>
            <h3>Database Signals & Technical Metrics</h3>
            <span class=\"tag\">Live system telemetry</span>
        </header>
        <dl class=\"kv-grid\">
            <div>
                <dt>Database Engine</dt>
                <dd>SQLite 3 (ACID)</dd>
            </div>
            <div>
                <dt>Total Affectations</dt>
                <dd>";
            // line 351
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "totalAffectations", [], "any", true, true, false, 351)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 351, $this->source); })()), "totalAffectations", [], "any", false, false, false, 351), 0)) : (0)), "html", null, true);
            yield " records</dd>
            </div>
            <div>
                <dt>Total Evaluations</dt>
                <dd>";
            // line 355
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "totalEvaluations", [], "any", true, true, false, 355)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 355, $this->source); })()), "totalEvaluations", [], "any", false, false, false, 355), 0)) : (0)), "html", null, true);
            yield " records</dd>
            </div>
            <div>
                <dt>Average Rating</dt>
                <dd>";
            // line 359
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "averageNote", [], "any", true, true, false, 359)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 359, $this->source); })()), "averageNote", [], "any", false, false, false, 359), 0)) : (0)), "html", null, true);
            yield "/20</dd>
            </div>
            <div>
                <dt>Completion Status</dt>
                <dd>";
            // line 363
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "statusCounts", [], "any", false, true, false, 363), "Complété", [], "array", true, true, false, 363)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 363, $this->source); })()), "statusCounts", [], "any", false, false, false, 363), "Complété", [], "array", false, false, false, 363), 0)) : (0)), "html", null, true);
            yield " / ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "totalAffectations", [], "any", true, true, false, 363)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 363, $this->source); })()), "totalAffectations", [], "any", false, false, false, 363), 0)) : (0)), "html", null, true);
            yield "</dd>
            </div>
            <div>
                <dt>In Progress Tasks</dt>
                <dd>";
            // line 367
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "statusCounts", [], "any", false, true, false, 367), "En cours", [], "array", true, true, false, 367)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 367, $this->source); })()), "statusCounts", [], "any", false, false, false, 367), "En cours", [], "array", false, false, false, 367), 0)) : (0)), "html", null, true);
            yield "</dd>
            </div>
            <div>
                <dt>Pending Tasks</dt>
                <dd>";
            // line 371
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "statusCounts", [], "any", false, true, false, 371), "En attente", [], "array", true, true, false, 371)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 371, $this->source); })()), "statusCounts", [], "any", false, false, false, 371), "En attente", [], "array", false, false, false, 371), 0)) : (0)), "html", null, true);
            yield "</dd>
            </div>
            <div>
                <dt>Suspended/Cancelled</dt>
                <dd>";
            // line 375
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "statusCounts", [], "any", false, true, false, 375), "Suspendu", [], "array", true, true, false, 375)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 375, $this->source); })()), "statusCounts", [], "any", false, false, false, 375), "Suspendu", [], "array", false, false, false, 375), 0)) : (0)) + ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "statusCounts", [], "any", false, true, false, 375), "Annulé", [], "array", true, true, false, 375)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 375, $this->source); })()), "statusCounts", [], "any", false, false, false, 375), "Annulé", [], "array", false, false, false, 375), 0)) : (0))), "html", null, true);
            yield "</dd>
            </div>
            <div>
                <dt>Task Types Count</dt>
                <dd>";
            // line 379
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 379, $this->source); })()), "typeCounts", [], "any", false, false, false, 379)), "html", null, true);
            yield " different types</dd>
            </div>
            <div>
                <dt>Work Zones Count</dt>
                <dd>";
            // line 383
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 383, $this->source); })()), "zoneCounts", [], "any", false, false, false, 383)), "html", null, true);
            yield " zones</dd>
            </div>
            <div>
                <dt>Excellent Quality Reviews</dt>
                <dd>";
            // line 387
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "qualityCounts", [], "any", false, true, false, 387), "Excellent", [], "array", true, true, false, 387)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 387, $this->source); })()), "qualityCounts", [], "any", false, false, false, 387), "Excellent", [], "array", false, false, false, 387), 0)) : (0)), "html", null, true);
            yield "</dd>
            </div>
            <div>
                <dt>Time Span Coverage</dt>
                <dd>";
            // line 391
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "dateStats", [], "any", false, true, false, 391), "daysSpan", [], "any", true, true, false, 391)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 391, $this->source); })()), "dateStats", [], "any", false, false, false, 391), "daysSpan", [], "any", false, false, false, 391), 0)) : (0)), "html", null, true);
            yield " days</dd>
            </div>
            <div>
                <dt>Earliest Assignment</dt>
                <dd>";
            // line 395
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "dateStats", [], "any", false, true, false, 395), "earliestDate", [], "any", true, true, false, 395)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 395, $this->source); })()), "dateStats", [], "any", false, false, false, 395), "earliestDate", [], "any", false, false, false, 395), "N/A")) : ("N/A")), "html", null, true);
            yield "</dd>
            </div>
            <div>
                <dt>Latest Assignment</dt>
                <dd>";
            // line 399
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "dateStats", [], "any", false, true, false, 399), "latestDate", [], "any", true, true, false, 399)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 399, $this->source); })()), "dateStats", [], "any", false, false, false, 399), "latestDate", [], "any", false, false, false, 399), "N/A")) : ("N/A")), "html", null, true);
            yield "</dd>
            </div>
            <div>
                <dt>Ongoing Active Tasks</dt>
                <dd>";
            // line 403
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "dateStats", [], "any", false, true, false, 403), "ongoingCount", [], "any", true, true, false, 403)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 403, $this->source); })()), "dateStats", [], "any", false, false, false, 403), "ongoingCount", [], "any", false, false, false, 403), 0)) : (0)), "html", null, true);
            yield "</dd>
            </div>
            <div>
                <dt>Connection Type</dt>
                <dd>PDO via Doctrine DBAL</dd>
            </div>
        </dl>
    </article>
</section>

<!-- Chart.js Render Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Color palette matching admin dashboard
    const colors = {
        success: '#89b66b',
        warning: '#f0b75f',
        danger: '#d86a5b',
        primary: '#667eea',
        accent: '#764ba2'
    };

    // Status Chart
    const statusCtx = document.getElementById('statusChart')?.getContext('2d');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['En attente', 'En cours', 'Complété', 'Suspendu', 'Annulé'],
                datasets: [{
                    data: [
                        ";
            // line 434
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "statusCounts", [], "any", false, true, false, 434), "En attente", [], "array", true, true, false, 434)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 434, $this->source); })()), "statusCounts", [], "any", false, false, false, 434), "En attente", [], "array", false, false, false, 434), 0)) : (0)), "html", null, true);
            yield ",
                        ";
            // line 435
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "statusCounts", [], "any", false, true, false, 435), "En cours", [], "array", true, true, false, 435)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 435, $this->source); })()), "statusCounts", [], "any", false, false, false, 435), "En cours", [], "array", false, false, false, 435), 0)) : (0)), "html", null, true);
            yield ",
                        ";
            // line 436
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "statusCounts", [], "any", false, true, false, 436), "Complété", [], "array", true, true, false, 436)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 436, $this->source); })()), "statusCounts", [], "any", false, false, false, 436), "Complété", [], "array", false, false, false, 436), 0)) : (0)), "html", null, true);
            yield ",
                        ";
            // line 437
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "statusCounts", [], "any", false, true, false, 437), "Suspendu", [], "array", true, true, false, 437)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 437, $this->source); })()), "statusCounts", [], "any", false, false, false, 437), "Suspendu", [], "array", false, false, false, 437), 0)) : (0)), "html", null, true);
            yield ",
                        ";
            // line 438
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "statusCounts", [], "any", false, true, false, 438), "Annulé", [], "array", true, true, false, 438)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 438, $this->source); })()), "statusCounts", [], "any", false, false, false, 438), "Annulé", [], "array", false, false, false, 438), 0)) : (0)), "html", null, true);
            yield "
                    ],
                    backgroundColor: [
                        '#e8d4c4',
                        '#b3d9e8',
                        colors.success,
                        colors.warning,
                        colors.danger
                    ],
                    borderColor: 'white',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 12 } } }
                }
            }
        });
    }

    // Quality Chart
    const qualityCtx = document.getElementById('qualityChart')?.getContext('2d');
    if (qualityCtx) {
        new Chart(qualityCtx, {
            type: 'bar',
            data: {
                labels: ['Excellent', 'Très bon', 'Bon', 'Acceptable', 'Insuffisant'],
                datasets: [{
                    label: 'Reviews',
                    data: [
                        ";
            // line 471
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "qualityCounts", [], "any", false, true, false, 471), "Excellent", [], "array", true, true, false, 471)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 471, $this->source); })()), "qualityCounts", [], "any", false, false, false, 471), "Excellent", [], "array", false, false, false, 471), 0)) : (0)), "html", null, true);
            yield ",
                        ";
            // line 472
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "qualityCounts", [], "any", false, true, false, 472), "Très bon", [], "array", true, true, false, 472)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 472, $this->source); })()), "qualityCounts", [], "any", false, false, false, 472), "Très bon", [], "array", false, false, false, 472), 0)) : (0)), "html", null, true);
            yield ",
                        ";
            // line 473
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "qualityCounts", [], "any", false, true, false, 473), "Bon", [], "array", true, true, false, 473)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 473, $this->source); })()), "qualityCounts", [], "any", false, false, false, 473), "Bon", [], "array", false, false, false, 473), 0)) : (0)), "html", null, true);
            yield ",
                        ";
            // line 474
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "qualityCounts", [], "any", false, true, false, 474), "Acceptable", [], "array", true, true, false, 474)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 474, $this->source); })()), "qualityCounts", [], "any", false, false, false, 474), "Acceptable", [], "array", false, false, false, 474), 0)) : (0)), "html", null, true);
            yield ",
                        ";
            // line 475
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "qualityCounts", [], "any", false, true, false, 475), "Insuffisant", [], "array", true, true, false, 475)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 475, $this->source); })()), "qualityCounts", [], "any", false, false, false, 475), "Insuffisant", [], "array", false, false, false, 475), 0)) : (0)), "html", null, true);
            yield "
                    ],
                    backgroundColor: [
                        colors.success,
                        '#89c9b3',
                        '#a8d5ba',
                        colors.warning,
                        colors.danger
                    ]
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: { legend: { display: true, labels: { font: { size: 11 } } } }
            }
        });
    }

    // Type Chart
    const typeCtx = document.getElementById('typeChart')?.getContext('2d');
    if (typeCtx) {
        const typeLabels = Object.keys(";
            // line 497
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(json_encode(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 497, $this->source); })()), "typeCounts", [], "any", false, false, false, 497)), "html", null, true);
            yield ");
        const typeData = Object.values(";
            // line 498
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(json_encode(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 498, $this->source); })()), "typeCounts", [], "any", false, false, false, 498)), "html", null, true);
            yield ");
        new Chart(typeCtx, {
            type: 'pie',
            data: {
                labels: typeLabels,
                datasets: [{
                    data: typeData,
                    backgroundColor: [
                        colors.primary,
                        colors.success,
                        colors.warning,
                        colors.danger,
                        colors.accent,
                        '#8ba3d0'
                    ],
                    borderColor: 'white',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'right', labels: { font: { size: 11 } } } }
            }
        });
    }

    // Zone Chart
    const zoneCtx = document.getElementById('zoneChart')?.getContext('2d');
    if (zoneCtx) {
        const zoneLabels = Object.keys(";
            // line 527
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(json_encode(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 527, $this->source); })()), "zoneCounts", [], "any", false, false, false, 527)), "html", null, true);
            yield ");
        const zoneData = Object.values(";
            // line 528
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(json_encode(CoreExtension::getAttribute($this->env, $this->source, (isset($context["stats"]) || array_key_exists("stats", $context) ? $context["stats"] : (function () { throw new RuntimeError('Variable "stats" does not exist.', 528, $this->source); })()), "zoneCounts", [], "any", false, false, false, 528)), "html", null, true);
            yield ");
        new Chart(zoneCtx, {
            type: 'radar',
            data: {
                labels: zoneLabels,
                datasets: [{
                    label: 'Tasks',
                    data: zoneData,
                    backgroundColor: 'rgba(102, 126, 234, 0.15)',
                    borderColor: colors.primary,
                    pointBackgroundColor: colors.primary,
                    pointBorderColor: 'white',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: { r: { beginAtZero: true, grid: { color: '#f0f0f0' } } },
                plugins: { legend: { labels: { font: { size: 11 } } } }
            }
        });
    }
});
</script>
";
        }
        // line 553
        yield "
<section class=\"crud-section\">
    <!-- Flash Messages Section -->
    ";
        // line 556
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 556, $this->source); })()), "flashes", ["error"], "method", false, false, false, 556));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 557
            yield "        <div style=\"background-color: #fee; border: 1px solid #fcc; border-radius: 8px; padding: 16px; margin-bottom: 20px; color: #c33; font-weight: 500;\">
            <div style=\"display: flex; align-items: center; gap: 10px;\">
                <span style=\"font-size: 20px;\">⚠️</span>
                <div>
                    <strong>Erreur de validation</strong>
                    <p style=\"margin: 8px 0 0 0; font-weight: 400;\">";
            // line 562
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "</p>
                </div>
            </div>
        </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 567
        yield "
    ";
        // line 568
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 568, $this->source); })()), "flashes", ["success"], "method", false, false, false, 568));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 569
            yield "        <div style=\"background-color: #efe; border: 1px solid #cfc; border-radius: 8px; padding: 16px; margin-bottom: 20px; color: #3c3; font-weight: 500;\">
            <div style=\"display: flex; align-items: center; gap: 10px;\">
                <span style=\"font-size: 20px;\">✅</span>
                <div>
                    <strong>Succès</strong>
                    <p style=\"margin: 8px 0 0 0; font-weight: 400;\">";
            // line 574
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "</p>
                </div>
            </div>
        </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 579
        yield "
    <!-- Affectation (Task Assignments) Card -->
    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Affectation</h2>
                <p>Assign and manage work tasks with dates and status.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"primary\" onclick=\"document.querySelector('form[data-form-type=affectation]')?.scrollIntoView({behavior:'smooth'})\">Add affectation</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <!-- Affectations List -->
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    ";
        // line 595
        if ((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 595, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 596
            yield "                        <input class=\"input\" type=\"search\" placeholder=\"Search by ID or type...\" id=\"affectation-search\">
                    ";
        } else {
            // line 598
            yield "                        <input class=\"input\" type=\"search\" placeholder=\"Search affectations...\" id=\"affectation-search\">
                    ";
        }
        // line 600
        yield "                    <span class=\"pill\">";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["affectations"]) || array_key_exists("affectations", $context) ? $context["affectations"] : (function () { throw new RuntimeError('Variable "affectations" does not exist.', 600, $this->source); })())), "html", null, true);
        yield " records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            ";
        // line 605
        if ((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 605, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<th>Id</th>";
        }
        // line 606
        yield "                            <th>Type</th>
                            <th>Zone</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id=\"affectation-list\">
                        ";
        // line 615
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["affectations"]) || array_key_exists("affectations", $context) ? $context["affectations"] : (function () { throw new RuntimeError('Variable "affectations" does not exist.', 615, $this->source); })())) > 0)) {
            // line 616
            yield "                            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["affectations"]) || array_key_exists("affectations", $context) ? $context["affectations"] : (function () { throw new RuntimeError('Variable "affectations" does not exist.', 616, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["aff"]) {
                // line 617
                yield "                                <tr>
                                    ";
                // line 618
                if ((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 618, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield "<td>#AF-";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::sprintf("%02d", ((CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "id", [], "any", true, true, false, 618)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "id", [], "any", false, false, false, 618), 0)) : (0))), "html", null, true);
                    yield "</td>";
                }
                // line 619
                yield "                                    <td style=\"font-weight: 500;\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "typeTravail", [], "any", true, true, false, 619)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "typeTravail", [], "any", false, false, false, 619), "N/A")) : ("N/A")), "html", null, true);
                yield "</td>
                                    <td>
                                        📍 ";
                // line 621
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "zoneTravail", [], "any", true, true, false, 621)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "zoneTravail", [], "any", false, false, false, 621), "N/A")) : ("N/A")), "html", null, true);
                yield "
                                        ";
                // line 622
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["weatherData"] ?? null), "list", [], "any", true, true, false, 622)) {
                    // line 623
                    yield "                                            <div style=\"font-size: 11px; color: #666; margin-top: 3px;\">
                                                🌡️ ";
                    // line 624
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::round(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["weatherData"]) || array_key_exists("weatherData", $context) ? $context["weatherData"] : (function () { throw new RuntimeError('Variable "weatherData" does not exist.', 624, $this->source); })()), "list", [], "any", false, false, false, 624), 0, [], "array", false, false, false, 624), "main", [], "any", false, false, false, 624), "temp", [], "any", false, false, false, 624)), "html", null, true);
                    yield "°C · 💧 ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["weatherData"]) || array_key_exists("weatherData", $context) ? $context["weatherData"] : (function () { throw new RuntimeError('Variable "weatherData" does not exist.', 624, $this->source); })()), "list", [], "any", false, false, false, 624), 0, [], "array", false, false, false, 624), "main", [], "any", false, false, false, 624), "humidity", [], "any", false, false, false, 624), "html", null, true);
                    yield "%
                                            </div>
                                        ";
                }
                // line 627
                yield "                                    </td>
                                    <td>";
                // line 628
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::default($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "dateDebut", [], "any", false, false, false, 628), "Y-m-d"), "N/A"), "html", null, true);
                yield "</td>
                                    <td>";
                // line 629
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::default($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "dateFin", [], "any", false, false, false, 629), "Y-m-d"), "N/A"), "html", null, true);
                yield "</td>
                                    <td>
                                        ";
                // line 631
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "statut", [], "any", false, false, false, 631) == "En cours")) {
                    // line 632
                    yield "                                            <span class=\"status ok\">● ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "statut", [], "any", false, false, false, 632), "html", null, true);
                    yield "</span>
                                        ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 633
$context["aff"], "statut", [], "any", false, false, false, 633) == "Complété")) {
                    // line 634
                    yield "                                            <span class=\"status ok\">✓ ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "statut", [], "any", false, false, false, 634), "html", null, true);
                    yield "</span>
                                        ";
                } elseif (((CoreExtension::getAttribute($this->env, $this->source,                 // line 635
$context["aff"], "statut", [], "any", false, false, false, 635) == "Suspendu") || (CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "statut", [], "any", false, false, false, 635) == "Annulé"))) {
                    // line 636
                    yield "                                            <span class=\"status warn\">⚠ ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "statut", [], "any", false, false, false, 636), "html", null, true);
                    yield "</span>
                                        ";
                } else {
                    // line 638
                    yield "                                            <span class=\"status\">◌ ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "statut", [], "any", true, true, false, 638)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "statut", [], "any", false, false, false, 638), "N/A")) : ("N/A")), "html", null, true);
                    yield "</span>
                                        ";
                }
                // line 640
                yield "                                    </td>
                                    <td style=\"font-size: 13px;\">
                                        <a href=\"";
                // line 642
                yield (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 642, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_workers_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "id", [], "any", false, false, false, 642)]), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_workers_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "id", [], "any", false, false, false, 642)]), "html", null, true)));
                yield "\" class=\"link\">✏️ Edit</a>
                                        <form method=\"POST\" action=\"";
                // line 643
                yield (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 643, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_workers_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "id", [], "any", false, false, false, 643)]), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_workers_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "id", [], "any", false, false, false, 643)]), "html", null, true)));
                yield "\" style=\"display:inline\">
                                            <input type=\"hidden\" name=\"_token\" value=\"";
                // line 644
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken(("delete_affectation_" . CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "id", [], "any", false, false, false, 644))), "html", null, true);
                yield "\">
                                            <button type=\"submit\" class=\"link danger\" onclick=\"return confirm('Delete this affectation?')\">🗑️ Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['aff'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 650
            yield "                        ";
        } else {
            // line 651
            yield "                            <tr>
                                <td colspan=\"";
            // line 652
            if ((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 652, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield "7";
            } else {
                yield "6";
            }
            yield "\" style=\"text-align:center; padding:20px\">No affectations found</td>
                            </tr>
                        ";
        }
        // line 655
        yield "                    </tbody>
                </table>
            </div>

            <!-- Affectation Form -->
            <div class=\"crud-form\">
                <h3>";
        // line 661
        yield (((($tmp = (isset($context["affectationEditing"]) || array_key_exists("affectationEditing", $context) ? $context["affectationEditing"] : (function () { throw new RuntimeError('Variable "affectationEditing" does not exist.', 661, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Edit affectation") : ("Create affectation"));
        yield "</h3>
                <form method=\"POST\" data-form-type=\"affectation\">
                    <input type=\"hidden\" name=\"form_type\" value=\"affectation\">
                    <input type=\"hidden\" name=\"_token\" value=\"";
        // line 664
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken((((($tmp = (isset($context["affectationEditing"]) || array_key_exists("affectationEditing", $context) ? $context["affectationEditing"] : (function () { throw new RuntimeError('Variable "affectationEditing" does not exist.', 664, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (("edit_affectation_" . CoreExtension::getAttribute($this->env, $this->source, (isset($context["affectation"]) || array_key_exists("affectation", $context) ? $context["affectation"] : (function () { throw new RuntimeError('Variable "affectation" does not exist.', 664, $this->source); })()), "id", [], "any", false, false, false, 664))) : ("create_affectation"))), "html", null, true);
        yield "\">
                    ";
        // line 665
        if ((($tmp = (isset($context["affectationEditing"]) || array_key_exists("affectationEditing", $context) ? $context["affectationEditing"] : (function () { throw new RuntimeError('Variable "affectationEditing" does not exist.', 665, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 666
            yield "                        <input type=\"hidden\" name=\"affectation_id\" value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["affectation"] ?? null), "id", [], "any", true, true, false, 666)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["affectation"]) || array_key_exists("affectation", $context) ? $context["affectation"] : (function () { throw new RuntimeError('Variable "affectation" does not exist.', 666, $this->source); })()), "id", [], "any", false, false, false, 666), "")) : ("")), "html", null, true);
            yield "\">
                    ";
        }
        // line 668
        yield "
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Type de travail *</span>
                            <input class=\"input\" type=\"text\" name=\"type_travail\" placeholder=\"Ex: Récolte, Labour, Plantage\" value=\"";
        // line 672
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["affectation"] ?? null), "typeTravail", [], "any", true, true, false, 672)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["affectation"]) || array_key_exists("affectation", $context) ? $context["affectation"] : (function () { throw new RuntimeError('Variable "affectation" does not exist.', 672, $this->source); })()), "typeTravail", [], "any", false, false, false, 672), "")) : ("")), "html", null, true);
        yield "\" minlength=\"3\" maxlength=\"100\" required>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Minimum 3 caractères requis</small>
                        </label>
                        <label class=\"field\">
                            <span>Zone de travail *</span>
                            <input class=\"input\" type=\"text\" name=\"zone_travail\" placeholder=\"Ex: Champ Nord\" value=\"";
        // line 677
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["affectation"] ?? null), "zoneTravail", [], "any", true, true, false, 677)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["affectation"]) || array_key_exists("affectation", $context) ? $context["affectation"] : (function () { throw new RuntimeError('Variable "affectation" does not exist.', 677, $this->source); })()), "zoneTravail", [], "any", false, false, false, 677), "")) : ("")), "html", null, true);
        yield "\" minlength=\"3\" maxlength=\"100\" required>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Minimum 3 caractères requis</small>
                        </label>
                        <label class=\"field\">
                            <span>Date début *</span>
                            <input class=\"input\" type=\"date\" name=\"date_debut\" value=\"";
        // line 682
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::default($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["affectation"]) || array_key_exists("affectation", $context) ? $context["affectation"] : (function () { throw new RuntimeError('Variable "affectation" does not exist.', 682, $this->source); })()), "dateDebut", [], "any", false, false, false, 682), "Y-m-d"), ""), "html", null, true);
        yield "\" required>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Requis</small>
                        </label>
                        <label class=\"field\">
                            <span>Date fin *</span>
                            <input class=\"input\" type=\"date\" name=\"date_fin\" value=\"";
        // line 687
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::default($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["affectation"]) || array_key_exists("affectation", $context) ? $context["affectation"] : (function () { throw new RuntimeError('Variable "affectation" does not exist.', 687, $this->source); })()), "dateFin", [], "any", false, false, false, 687), "Y-m-d"), ""), "html", null, true);
        yield "\" required>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Doit être >= à la date début</small>
                        </label>
                        <label class=\"field\" style=\"grid-column: 1 / -1\">
                            <span>Statut *</span>
                            <select class=\"input\" name=\"statut\" required>
                                <option value=\"\">Select status</option>
                                <option value=\"En attente\" ";
        // line 694
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["affectation"]) || array_key_exists("affectation", $context) ? $context["affectation"] : (function () { throw new RuntimeError('Variable "affectation" does not exist.', 694, $this->source); })()), "statut", [], "any", false, false, false, 694) == "En attente")) {
            yield "selected";
        }
        yield ">En attente</option>
                                <option value=\"En cours\" ";
        // line 695
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["affectation"]) || array_key_exists("affectation", $context) ? $context["affectation"] : (function () { throw new RuntimeError('Variable "affectation" does not exist.', 695, $this->source); })()), "statut", [], "any", false, false, false, 695) == "En cours")) {
            yield "selected";
        }
        yield ">En cours</option>
                                <option value=\"Complété\" ";
        // line 696
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["affectation"]) || array_key_exists("affectation", $context) ? $context["affectation"] : (function () { throw new RuntimeError('Variable "affectation" does not exist.', 696, $this->source); })()), "statut", [], "any", false, false, false, 696) == "Complété")) {
            yield "selected";
        }
        yield ">Complété</option>
                                <option value=\"Suspendu\" ";
        // line 697
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["affectation"]) || array_key_exists("affectation", $context) ? $context["affectation"] : (function () { throw new RuntimeError('Variable "affectation" does not exist.', 697, $this->source); })()), "statut", [], "any", false, false, false, 697) == "Suspendu")) {
            yield "selected";
        }
        yield ">Suspendu</option>
                                <option value=\"Annulé\" ";
        // line 698
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["affectation"]) || array_key_exists("affectation", $context) ? $context["affectation"] : (function () { throw new RuntimeError('Variable "affectation" does not exist.', 698, $this->source); })()), "statut", [], "any", false, false, false, 698) == "Annulé")) {
            yield "selected";
        }
        yield ">Annulé</option>
                            </select>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\">Save</button>
                        <a href=\"";
        // line 704
        yield (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 704, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_workers")) : ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_workers")));
        yield "\" class=\"ghost\">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Evaluation (Performance) Card -->
    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Evaluation Performance</h2>
                <p>Track and rate worker performance on completed tasks.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"primary\" onclick=\"document.querySelector('form[data-form-type=evaluation]')?.scrollIntoView({behavior:'smooth'})\">Add evaluation</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <!-- Evaluations List -->
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    ";
        // line 726
        if ((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 726, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 727
            yield "                        <input class=\"input\" type=\"search\" placeholder=\"Search by ID or quality...\" id=\"evaluation-search\">
                    ";
        } else {
            // line 729
            yield "                        <input class=\"input\" type=\"search\" placeholder=\"Search evaluations...\" id=\"evaluation-search\">
                    ";
        }
        // line 731
        yield "                    <span class=\"pill\">";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["evaluations"]) || array_key_exists("evaluations", $context) ? $context["evaluations"] : (function () { throw new RuntimeError('Variable "evaluations" does not exist.', 731, $this->source); })())), "html", null, true);
        yield " records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            ";
        // line 736
        if ((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 736, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<th>Id</th>";
        }
        // line 737
        yield "                            <th>Affectation</th>
                            <th>Note</th>
                            <th>Quality</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id=\"evaluation-list\">
                        ";
        // line 745
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["evaluations"]) || array_key_exists("evaluations", $context) ? $context["evaluations"] : (function () { throw new RuntimeError('Variable "evaluations" does not exist.', 745, $this->source); })())) > 0)) {
            // line 746
            yield "                            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["evaluations"]) || array_key_exists("evaluations", $context) ? $context["evaluations"] : (function () { throw new RuntimeError('Variable "evaluations" does not exist.', 746, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["eval"]) {
                // line 747
                yield "                                <tr>
                                    ";
                // line 748
                if ((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 748, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield "<td>#EV-";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::sprintf("%02d", ((CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "id", [], "any", true, true, false, 748)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "id", [], "any", false, false, false, 748), 0)) : (0))), "html", null, true);
                    yield "</td>";
                }
                // line 749
                yield "                                    <td style=\"font-weight: 500;\">
                                        <a href=\"";
                // line 750
                yield (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 750, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_workers_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "affectationId", [], "any", false, false, false, 750)]), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_workers_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "affectationId", [], "any", false, false, false, 750)]), "html", null, true)));
                yield "\" class=\"link\" style=\"text-decoration: none;\">
                                            #AF-";
                // line 751
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::sprintf("%02d", ((CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "affectationId", [], "any", true, true, false, 751)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "affectationId", [], "any", false, false, false, 751), 0)) : (0))), "html", null, true);
                yield "
                                        </a>
                                    </td>
                                    <td style=\"text-align: center; font-weight: 600; padding: 6px 10px;\">
                                        ";
                // line 755
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "note", [], "any", false, false, false, 755) >= 16)) {
                    // line 756
                    yield "                                            <span style=\"background: #89b66b; color: white; padding: 2px 8px; border-radius: 12px;\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "note", [], "any", false, false, false, 756), "html", null, true);
                    yield "/20</span>
                                        ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 757
$context["eval"], "note", [], "any", false, false, false, 757) >= 12)) {
                    // line 758
                    yield "                                            <span style=\"background: #f0b75f; color: white; padding: 2px 8px; border-radius: 12px;\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "note", [], "any", false, false, false, 758), "html", null, true);
                    yield "/20</span>
                                        ";
                } else {
                    // line 760
                    yield "                                            <span style=\"background: #d86a5b; color: white; padding: 2px 8px; border-radius: 12px;\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "note", [], "any", false, false, false, 760), "html", null, true);
                    yield "/20</span>
                                        ";
                }
                // line 762
                yield "                                    </td>
                                    <td>
                                        ";
                // line 764
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "qualite", [], "any", false, false, false, 764) == "Excellent")) {
                    // line 765
                    yield "                                            <span class=\"status ok\">⭐ ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "qualite", [], "any", false, false, false, 765), "html", null, true);
                    yield "</span>
                                        ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 766
$context["eval"], "qualite", [], "any", false, false, false, 766) == "Très bon")) {
                    // line 767
                    yield "                                            <span class=\"status ok\">👍 ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "qualite", [], "any", false, false, false, 767), "html", null, true);
                    yield "</span>
                                        ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 768
$context["eval"], "qualite", [], "any", false, false, false, 768) == "Bon")) {
                    // line 769
                    yield "                                            <span class=\"status\">✓ ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "qualite", [], "any", false, false, false, 769), "html", null, true);
                    yield "</span>
                                        ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 770
$context["eval"], "qualite", [], "any", false, false, false, 770) == "Acceptable")) {
                    // line 771
                    yield "                                            <span class=\"status warn\">~ ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "qualite", [], "any", false, false, false, 771), "html", null, true);
                    yield "</span>
                                        ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 772
$context["eval"], "qualite", [], "any", false, false, false, 772) == "Insuffisant")) {
                    // line 773
                    yield "                                            <span class=\"status warn\">✗ ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "qualite", [], "any", false, false, false, 773), "html", null, true);
                    yield "</span>
                                        ";
                } else {
                    // line 775
                    yield "                                            ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "qualite", [], "any", true, true, false, 775)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "qualite", [], "any", false, false, false, 775), "N/A")) : ("N/A")), "html", null, true);
                    yield "
                                        ";
                }
                // line 777
                yield "                                    </td>
                                    <td>";
                // line 778
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::default($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "dateEvaluation", [], "any", false, false, false, 778), "Y-m-d"), "N/A"), "html", null, true);
                yield "</td>
                                    <td style=\"font-size: 13px;\">
                                        <a href=\"";
                // line 780
                yield (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 780, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_evaluation_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "id", [], "any", false, false, false, 780)]), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_evaluation_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "id", [], "any", false, false, false, 780)]), "html", null, true)));
                yield "\" class=\"link\">✏️ Edit</a>
                                        <form method=\"POST\" action=\"";
                // line 781
                yield (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 781, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_evaluation_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "id", [], "any", false, false, false, 781)]), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_evaluation_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "id", [], "any", false, false, false, 781)]), "html", null, true)));
                yield "\" style=\"display:inline\">
                                            <input type=\"hidden\" name=\"_token\" value=\"";
                // line 782
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken(("delete_evaluation_" . CoreExtension::getAttribute($this->env, $this->source, $context["eval"], "id", [], "any", false, false, false, 782))), "html", null, true);
                yield "\">
                                            <button type=\"submit\" class=\"link danger\" onclick=\"return confirm('Delete this evaluation?')\">🗑️ Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['eval'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 788
            yield "                        ";
        } else {
            // line 789
            yield "                            <tr>
                                <td colspan=\"";
            // line 790
            if ((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 790, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield "6";
            } else {
                yield "5";
            }
            yield "\" style=\"text-align:center; padding:20px\">No evaluations found</td>
                            </tr>
                        ";
        }
        // line 793
        yield "                    </tbody>
                </table>
            </div>

            <!-- Evaluation Form -->
            <div class=\"crud-form\">
                <h3>";
        // line 799
        yield (((($tmp = (isset($context["evaluationEditing"]) || array_key_exists("evaluationEditing", $context) ? $context["evaluationEditing"] : (function () { throw new RuntimeError('Variable "evaluationEditing" does not exist.', 799, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Edit evaluation") : ("Create evaluation"));
        yield "</h3>
                <form method=\"POST\" data-form-type=\"evaluation\">
                    <input type=\"hidden\" name=\"form_type\" value=\"evaluation\">
                    <input type=\"hidden\" name=\"_token\" value=\"";
        // line 802
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken((((($tmp = (isset($context["evaluationEditing"]) || array_key_exists("evaluationEditing", $context) ? $context["evaluationEditing"] : (function () { throw new RuntimeError('Variable "evaluationEditing" does not exist.', 802, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (("edit_evaluation_" . CoreExtension::getAttribute($this->env, $this->source, (isset($context["evaluation"]) || array_key_exists("evaluation", $context) ? $context["evaluation"] : (function () { throw new RuntimeError('Variable "evaluation" does not exist.', 802, $this->source); })()), "id", [], "any", false, false, false, 802))) : ("create_evaluation"))), "html", null, true);
        yield "\">
                    ";
        // line 803
        if ((($tmp = (isset($context["evaluationEditing"]) || array_key_exists("evaluationEditing", $context) ? $context["evaluationEditing"] : (function () { throw new RuntimeError('Variable "evaluationEditing" does not exist.', 803, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 804
            yield "                        <input type=\"hidden\" name=\"evaluation_id\" value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["evaluation"] ?? null), "id", [], "any", true, true, false, 804)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["evaluation"]) || array_key_exists("evaluation", $context) ? $context["evaluation"] : (function () { throw new RuntimeError('Variable "evaluation" does not exist.', 804, $this->source); })()), "id", [], "any", false, false, false, 804), "")) : ("")), "html", null, true);
            yield "\">
                    ";
        }
        // line 806
        yield "
                    <div class=\"form-grid\">
                        <label class=\"field\" style=\"grid-column: 1 / -1\">
                            <span>Affectation *</span>
                            <select class=\"input\" name=\"affectation_id\" required>
                                <option value=\"\">Select an affectation</option>
                                ";
        // line 812
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["affectations"]) || array_key_exists("affectations", $context) ? $context["affectations"] : (function () { throw new RuntimeError('Variable "affectations" does not exist.', 812, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["aff"]) {
            // line 813
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "id", [], "any", false, false, false, 813), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["evaluation"]) || array_key_exists("evaluation", $context) ? $context["evaluation"] : (function () { throw new RuntimeError('Variable "evaluation" does not exist.', 813, $this->source); })()), "affectationId", [], "any", false, false, false, 813) == CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "id", [], "any", false, false, false, 813))) {
                yield "selected";
            }
            yield ">
                                        #AF-";
            // line 814
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::sprintf("%02d", CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "id", [], "any", false, false, false, 814)), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "typeTravail", [], "any", false, false, false, 814), "html", null, true);
            yield " (";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "dateDebut", [], "any", false, false, false, 814), "Y-m-d"), "html", null, true);
            yield " to ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["aff"], "dateFin", [], "any", false, false, false, 814), "Y-m-d"), "html", null, true);
            yield ")
                                    </option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['aff'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 817
        yield "                            </select>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Une affectation valide est requise</small>
                        </label>
                        <label class=\"field\">
                            <span>Note (0-20) *</span>
                            <input class=\"input\" type=\"number\" name=\"note\" min=\"0\" max=\"20\" placeholder=\"Ex: 15\" value=\"";
        // line 822
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["evaluation"] ?? null), "note", [], "any", true, true, false, 822)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["evaluation"]) || array_key_exists("evaluation", $context) ? $context["evaluation"] : (function () { throw new RuntimeError('Variable "evaluation" does not exist.', 822, $this->source); })()), "note", [], "any", false, false, false, 822), "")) : ("")), "html", null, true);
        yield "\" required>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Entre 0 et 20</small>
                        </label>
                        <label class=\"field\">
                            <span>Qualité *</span>
                            <select class=\"input\" name=\"qualite\" required>
                                <option value=\"\">Select quality</option>
                                <option value=\"Excellent\" ";
        // line 829
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["evaluation"]) || array_key_exists("evaluation", $context) ? $context["evaluation"] : (function () { throw new RuntimeError('Variable "evaluation" does not exist.', 829, $this->source); })()), "qualite", [], "any", false, false, false, 829) == "Excellent")) {
            yield "selected";
        }
        yield ">Excellent</option>
                                <option value=\"Très bon\" ";
        // line 830
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["evaluation"]) || array_key_exists("evaluation", $context) ? $context["evaluation"] : (function () { throw new RuntimeError('Variable "evaluation" does not exist.', 830, $this->source); })()), "qualite", [], "any", false, false, false, 830) == "Très bon")) {
            yield "selected";
        }
        yield ">Très bon</option>
                                <option value=\"Bon\" ";
        // line 831
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["evaluation"]) || array_key_exists("evaluation", $context) ? $context["evaluation"] : (function () { throw new RuntimeError('Variable "evaluation" does not exist.', 831, $this->source); })()), "qualite", [], "any", false, false, false, 831) == "Bon")) {
            yield "selected";
        }
        yield ">Bon</option>
                                <option value=\"Acceptable\" ";
        // line 832
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["evaluation"]) || array_key_exists("evaluation", $context) ? $context["evaluation"] : (function () { throw new RuntimeError('Variable "evaluation" does not exist.', 832, $this->source); })()), "qualite", [], "any", false, false, false, 832) == "Acceptable")) {
            yield "selected";
        }
        yield ">Acceptable</option>
                                <option value=\"Insuffisant\" ";
        // line 833
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["evaluation"]) || array_key_exists("evaluation", $context) ? $context["evaluation"] : (function () { throw new RuntimeError('Variable "evaluation" does not exist.', 833, $this->source); })()), "qualite", [], "any", false, false, false, 833) == "Insuffisant")) {
            yield "selected";
        }
        yield ">Insuffisant</option>
                            </select>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Requis</small>
                        </label>
                        <label class=\"field\" style=\"grid-column: 1 / -1\">
                            <span>Date d'évaluation *</span>
                            <input class=\"input\" type=\"date\" name=\"date_evaluation\" value=\"";
        // line 839
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::default($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["evaluation"]) || array_key_exists("evaluation", $context) ? $context["evaluation"] : (function () { throw new RuntimeError('Variable "evaluation" does not exist.', 839, $this->source); })()), "dateEvaluation", [], "any", false, false, false, 839), "Y-m-d"), ""), "html", null, true);
        yield "\" max=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y-m-d"), "html", null, true);
        yield "\" required>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Doit être aujourd'hui ou antérieure (pas de date future)</small>
                        </label>
                        <label class=\"field\" style=\"grid-column: 1 / -1\">
                            <span>Commentaires *</span>
                            <textarea class=\"input\" name=\"commentaire\" placeholder=\"Add your comments...\" rows=\"4\" minlength=\"5\" maxlength=\"500\" style=\"font-family: inherit; padding: 8px; border: 1px solid var(--border); border-radius: 8px;\" required>";
        // line 844
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["evaluation"] ?? null), "commentaire", [], "any", true, true, false, 844)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["evaluation"]) || array_key_exists("evaluation", $context) ? $context["evaluation"] : (function () { throw new RuntimeError('Variable "evaluation" does not exist.', 844, $this->source); })()), "commentaire", [], "any", false, false, false, 844), "")) : ("")), "html", null, true);
        yield "</textarea>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Minimum 5 caractères requis</small>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\">Save</button>
                        <a href=\"";
        // line 850
        yield (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 850, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_workers")) : ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_workers")));
        yield "\" class=\"ghost\">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Client-side Validation Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate affectation date range
    const affectationForm = document.querySelector('form[data-form-type=\"affectation\"]');
    if (affectationForm) {
        const dateDebut = affectationForm.querySelector('input[name=\"date_debut\"]');
        const dateFin = affectationForm.querySelector('input[name=\"date_fin\"]');

        affectationForm.addEventListener('submit', function(e) {
            if (dateDebut.value && dateFin.value) {
                const start = new Date(dateDebut.value);
                const end = new Date(dateFin.value);

                if (end < start) {
                    e.preventDefault();
                    alert('❌ Erreur: La date fin doit être supérieure ou égale à la date début');
                    dateFin.focus();
                    dateFin.style.borderColor = '#d86a5b';
                    return false;
                }
            }
        });

        // Real-time validation feedback
        dateFin.addEventListener('change', function() {
            if (dateDebut.value && this.value) {
                const start = new Date(dateDebut.value);
                const end = new Date(this.value);

                if (end < start) {
                    this.style.borderColor = '#d86a5b';
                } else {
                    this.style.borderColor = '';
                }
            }
        });
    }

    // Validate note range
    const evaluationForm = document.querySelector('form[data-form-type=\"evaluation\"]');
    if (evaluationForm) {
        const affectationSelect = evaluationForm.querySelector('select[name=\"affectation_id\"]');
        const noteInput = evaluationForm.querySelector('input[name=\"note\"]');
        const dateEvaluationInput = evaluationForm.querySelector('input[name=\"date_evaluation\"]');

        // Validate affectation selection
        affectationSelect.addEventListener('change', function() {
            if (this.value === '' || parseInt(this.value) <= 0) {
                this.style.borderColor = '#d86a5b';
            } else {
                this.style.borderColor = '';
            }
        });

        // Validate note range
        noteInput.addEventListener('change', function() {
            const value = parseInt(this.value);
            if (value < 0 || value > 20) {
                this.style.borderColor = '#d86a5b';
                alert('❌ Erreur: La note doit être entre 0 et 20');
                this.value = '';
            } else {
                this.style.borderColor = '';
            }
        });

        // Validate evaluation date on change
        dateEvaluationInput.addEventListener('change', function() {
            if (this.value) {
                const evaluationDate = new Date(this.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                evaluationDate.setHours(0, 0, 0, 0);

                if (evaluationDate > today) {
                    this.style.borderColor = '#d86a5b';
                    alert('❌ Erreur: La date d\\'évaluation ne peut pas être dans le futur');
                    this.value = '';
                } else {
                    this.style.borderColor = '';
                }
            }
        });

        // Validate on form submit
        evaluationForm.addEventListener('submit', function(e) {
            let isValid = true;

            // Check affectation selection
            if (affectationSelect.value === '' || parseInt(affectationSelect.value) <= 0) {
                e.preventDefault();
                alert('❌ Erreur: Vous devez sélectionner une affectation');
                affectationSelect.focus();
                affectationSelect.style.borderColor = '#d86a5b';
                isValid = false;
            }

            // Check evaluation date
            if (isValid && dateEvaluationInput.value) {
                const evaluationDate = new Date(dateEvaluationInput.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                evaluationDate.setHours(0, 0, 0, 0);

                if (evaluationDate > today) {
                    e.preventDefault();
                    alert('❌ Erreur: La date d\\'évaluation ne peut pas être dans le futur');
                    dateEvaluationInput.focus();
                    dateEvaluationInput.style.borderColor = '#d86a5b';
                    isValid = false;
                }
            }

            return isValid;
        });
    }

    // Character count feedback
    const typeInput = document.querySelector('input[name=\"type_travail\"]');
    const zoneInput = document.querySelector('input[name=\"zone_travail\"]');
    const commentaires = document.querySelector('textarea[name=\"commentaire\"]');

    if (typeInput) {
        typeInput.addEventListener('input', function() {
            if (this.value.length < 3 && this.value.length > 0) {
                this.style.borderColor = '#f0b75f';
            } else if (this.value.length === 0) {
                this.style.borderColor = '#d86a5b';
            } else {
                this.style.borderColor = '';
            }
        });
    }

    if (zoneInput) {
        zoneInput.addEventListener('input', function() {
            if (this.value.length < 3 && this.value.length > 0) {
                this.style.borderColor = '#f0b75f';
            } else if (this.value.length === 0) {
                this.style.borderColor = '#d86a5b';
            } else {
                this.style.borderColor = '';
            }
        });
    }

    if (commentaires) {
        commentaires.addEventListener('input', function() {
            if (this.value.length < 5 && this.value.length > 0) {
                this.style.borderColor = '#f0b75f';
            } else if (this.value.length === 0) {
                this.style.borderColor = '#d86a5b';
            } else {
                this.style.borderColor = '';
            }
        });
    }

    // Search/Filter by ID and other fields (Admin only)
    const affectationSearch = document.getElementById('affectation-search');
    if (affectationSearch) {
        affectationSearch.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const affectationRows = document.querySelectorAll('#affectation-list tr');
            let visibleCount = 0;

            affectationRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let matches = false;

                if (query === '') {
                    matches = true;
                } else {
                    // Search in all cells (ID, Type, Zone, Start Date, End Date, Status)
                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(query)) {
                            matches = true;
                        }
                    });
                }

                row.style.display = matches ? '' : 'none';
                if (matches) visibleCount++;
            });

            // Show \"no results\" message if needed
            const emptyRow = document.querySelector('#affectation-list tr[style*=\"display: none\"]');
            if (visibleCount === 0 && query !== '') {
                console.log('Aucune affectation trouvée pour: ' + query);
            }
        });
    }

    // Search/Filter evaluations by ID and quality (Admin only)
    const evaluationSearch = document.getElementById('evaluation-search');
    if (evaluationSearch) {
        evaluationSearch.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const evaluationRows = document.querySelectorAll('#evaluation-list tr');
            let visibleCount = 0;

            evaluationRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let matches = false;

                if (query === '') {
                    matches = true;
                } else {
                    // Search in all cells (ID, Affectation, Note, Quality, Date)
                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(query)) {
                            matches = true;
                        }
                    });
                }

                row.style.display = matches ? '' : 'none';
                if (matches) visibleCount++;
            });

            // Show \"no results\" message if needed
            if (visibleCount === 0 && query !== '') {
                console.log('Aucune évaluation trouvée pour: ' + query);
            }
        });
    }
});
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
        return "management/workers.html.twig";
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
        return array (  1703 => 850,  1694 => 844,  1684 => 839,  1673 => 833,  1667 => 832,  1661 => 831,  1655 => 830,  1649 => 829,  1639 => 822,  1632 => 817,  1617 => 814,  1608 => 813,  1604 => 812,  1596 => 806,  1590 => 804,  1588 => 803,  1584 => 802,  1578 => 799,  1570 => 793,  1560 => 790,  1557 => 789,  1554 => 788,  1542 => 782,  1538 => 781,  1534 => 780,  1529 => 778,  1526 => 777,  1520 => 775,  1514 => 773,  1512 => 772,  1507 => 771,  1505 => 770,  1500 => 769,  1498 => 768,  1493 => 767,  1491 => 766,  1486 => 765,  1484 => 764,  1480 => 762,  1474 => 760,  1468 => 758,  1466 => 757,  1461 => 756,  1459 => 755,  1452 => 751,  1448 => 750,  1445 => 749,  1439 => 748,  1436 => 747,  1431 => 746,  1429 => 745,  1419 => 737,  1415 => 736,  1406 => 731,  1402 => 729,  1398 => 727,  1396 => 726,  1371 => 704,  1360 => 698,  1354 => 697,  1348 => 696,  1342 => 695,  1336 => 694,  1326 => 687,  1318 => 682,  1310 => 677,  1302 => 672,  1296 => 668,  1290 => 666,  1288 => 665,  1284 => 664,  1278 => 661,  1270 => 655,  1260 => 652,  1257 => 651,  1254 => 650,  1242 => 644,  1238 => 643,  1234 => 642,  1230 => 640,  1224 => 638,  1218 => 636,  1216 => 635,  1211 => 634,  1209 => 633,  1204 => 632,  1202 => 631,  1197 => 629,  1193 => 628,  1190 => 627,  1182 => 624,  1179 => 623,  1177 => 622,  1173 => 621,  1167 => 619,  1161 => 618,  1158 => 617,  1153 => 616,  1151 => 615,  1140 => 606,  1136 => 605,  1127 => 600,  1123 => 598,  1119 => 596,  1117 => 595,  1099 => 579,  1088 => 574,  1081 => 569,  1077 => 568,  1074 => 567,  1063 => 562,  1056 => 557,  1052 => 556,  1047 => 553,  1019 => 528,  1015 => 527,  983 => 498,  979 => 497,  954 => 475,  950 => 474,  946 => 473,  942 => 472,  938 => 471,  902 => 438,  898 => 437,  894 => 436,  890 => 435,  886 => 434,  852 => 403,  845 => 399,  838 => 395,  831 => 391,  824 => 387,  817 => 383,  810 => 379,  803 => 375,  796 => 371,  789 => 367,  780 => 363,  773 => 359,  766 => 355,  759 => 351,  743 => 337,  733 => 329,  731 => 328,  727 => 326,  717 => 318,  715 => 317,  686 => 291,  678 => 286,  670 => 281,  662 => 276,  657 => 273,  655 => 272,  609 => 228,  593 => 226,  589 => 225,  585 => 224,  580 => 223,  563 => 222,  541 => 202,  533 => 199,  526 => 195,  522 => 194,  518 => 192,  516 => 191,  512 => 189,  501 => 186,  498 => 185,  494 => 184,  491 => 183,  485 => 182,  482 => 181,  479 => 180,  474 => 179,  472 => 178,  466 => 175,  461 => 173,  458 => 172,  454 => 171,  451 => 170,  445 => 169,  442 => 168,  439 => 167,  434 => 166,  432 => 165,  414 => 149,  412 => 148,  408 => 146,  403 => 143,  399 => 141,  397 => 140,  394 => 139,  388 => 137,  384 => 135,  382 => 134,  379 => 133,  377 => 132,  374 => 131,  370 => 129,  366 => 127,  364 => 126,  361 => 125,  359 => 124,  350 => 118,  343 => 114,  337 => 111,  333 => 110,  326 => 106,  317 => 99,  315 => 98,  311 => 96,  305 => 92,  296 => 89,  292 => 88,  288 => 87,  284 => 86,  281 => 85,  277 => 84,  265 => 75,  261 => 74,  254 => 70,  246 => 65,  238 => 60,  233 => 57,  231 => 56,  222 => 49,  220 => 48,  216 => 46,  209 => 42,  201 => 36,  199 => 35,  195 => 33,  188 => 28,  173 => 25,  164 => 24,  160 => 23,  153 => 19,  146 => 14,  144 => 13,  138 => 9,  128 => 8,  111 => 6,  94 => 5,  77 => 4,  60 => 3,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends adminMode|default(false) ? 'admin/layout.html.twig' : 'management/layout.html.twig' %}

{% block title %}Workers Management{% endblock %}
{% block eyebrow %}Workers Management{% endblock %}
{% block heading %}Task assignments and evaluations{% endblock %}
{% block subhead %}Manage affectations and worker performance evaluations{% endblock %}

{% block body %}
<!-- Chart.js for statistics visualization -->
<script src=\"https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js\"></script>

<!-- Admin Selected User Scope (Only visible in admin mode) -->
{% if adminMode and availableUsers is defined %}
<section class=\"telemetry-panel\" style=\"margin-bottom: 18px;\">
    <header>
        <h3>Selected User Scope</h3>
        <span class=\"tag\">Admin can manage worker assignments per user account</span>
    </header>
    <form method=\"get\" action=\"{{ path('admin_management_workers') }}\" style=\"display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;\">
        <label style=\"min-width:280px; display:grid; gap:6px;\">
            <span>User</span>
            <select class=\"input\" name=\"user_id\" required onchange=\"this.form.submit()\">
                {% for user in availableUsers %}
                    <option value=\"{{ user.id }}\" {% if user.id == selectedUserId %}selected{% endif %}>
                        #{{ user.id }} - {{ user.firstName }} {{ user.lastName }} ({{ user.roleName }})
                    </option>
                {% endfor %}
            </select>
        </label>
    </form>
</section>
{% endif %}

<!-- Weather & AI Recommendations (for admin) -->
{% if adminMode and aiOptimization is defined %}
<section class=\"telemetry-panel\" style=\"margin-bottom: 18px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;\">
    <header>
        <h3>🤖 AI Task Optimization</h3>
        <span class=\"tag\" style=\"background: rgba(255,255,255,0.2);\">Groq AI Recommendations</span>
    </header>
    <div style=\"padding: 16px; background: rgba(0,0,0,0.1); border-radius: 8px; font-size: 14px; line-height: 1.6;\">
        {{ aiOptimization|nl2br }}
    </div>
</section>
{% endif %}

<!-- Weather Data (if available) -->
{% if weatherData is defined and weatherData.current is defined and weatherData.current.cod == 200 %}
<section class=\"telemetry-panel\" style=\"margin-bottom: 18px;\">
    <header>
        <h3>🌤️ Current Weather & 5-Day Forecast</h3>
        <span class=\"tag\">OpenWeather API - Real-time + Forecast</span>
    </header>

    <!-- Current Weather (Large) -->
    {% set current = weatherData.current %}
    <div style=\"padding: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; margin-bottom: 16px;\">
        <div style=\"display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 16px; text-align: center;\">
            <div>
                <span style=\"font-size: 32px; font-weight: bold;\">{{ current.main.temp|round(1) }}°C</span>
                <small style=\"display: block; margin-top: 4px;\">Current Temperature</small>
            </div>
            <div>
                <span style=\"font-size: 28px;\">💧</span>
                <span style=\"font-size: 20px; font-weight: bold;\">{{ current.main.humidity }}%</span>
                <small style=\"display: block;\">Humidity</small>
            </div>
            <div>
                <span style=\"font-size: 28px;\">💨</span>
                <span style=\"font-size: 20px; font-weight: bold;\">{{ current.wind.speed|round(1) }} m/s</span>
                <small style=\"display: block;\">Wind Speed</small>
            </div>
            <div>
                <span style=\"font-size: 24px; text-transform: capitalize;\">{{ current.weather[0].main }}</span>
                <small style=\"display: block;\">{{ current.weather[0].description|capitalize }}</small>
            </div>
        </div>
    </div>

    <!-- 5-Day Forecast -->
    <div>
        <h4 style=\"margin-bottom: 12px; color: #333;\">5-Day Forecast</h4>
        <div style=\"display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px;\">
            {% for item in weatherData.list|slice(0, 8) %}
            <div style=\"padding: 12px; border: 1px solid #e0e0e0; border-radius: 6px; background: #f9f9f9; text-align: center;\">
                <strong style=\"font-size: 12px; color: #666; display: block; margin-bottom: 6px;\">{{ item.dt_txt|date('H:i') }}</strong>
                <span style=\"font-size: 18px; font-weight: bold; display: block;\">{{ item.main.temp|round }}°C</span>
                <small style=\"color: #666; display: block; margin: 4px 0;\">{{ item.weather[0].main }}</small>
                <small style=\"color: #666;\">💧 {{ item.main.humidity }}%</small>
            </div>
            {% endfor %}
        </div>
    </div>
</section>
{% endif %}

<!-- AI Insights & Performance Reports -->
{% if (evaluations|length > 0 or adminMode) and stats is defined and stats.totalEvaluations is defined %}
<section class=\"telemetry-panel\" style=\"margin-bottom: 18px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;\">
    <header>
        <h3>📊 AI Performance Insights</h3>
        <span class=\"tag\" style=\"background: rgba(255,255,255,0.2);\">Groq AI - Worker Performance Analytics</span>
    </header>
    <div style=\"display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-bottom: 16px;\">
        <div style=\"padding: 12px; background: rgba(0,0,0,0.2); border-radius: 6px; text-align: center;\">
            <div style=\"font-size: 24px; font-weight: bold;\">{{ stats.totalEvaluations|default(0) }}</div>
            <small>Total Evaluations</small>
        </div>
        <div style=\"padding: 12px; background: rgba(0,0,0,0.2); border-radius: 6px; text-align: center;\">
            <div style=\"font-size: 24px; font-weight: bold;\">{{ stats.averageNote|default(0) }}</div>
            <small>Avg Score ({{ stats.averageNote|default(0) }}/20)</small>
        </div>
        <div style=\"padding: 12px; background: rgba(0,0,0,0.2); border-radius: 6px; text-align: center;\">
            <div style=\"font-size: 24px; font-weight: bold;\">{{ stats.excellentCount|default(0) }}</div>
            <small>Excellent Ratings</small>
        </div>
        <div style=\"padding: 12px; background: rgba(0,0,0,0.2); border-radius: 6px; text-align: center;\">
            <div style=\"font-size: 24px; font-weight: bold;\">{{ stats.completionRate|default(0) }}%</div>
            <small>Completion Rate</small>
        </div>
    </div>
    <div style=\"padding: 12px; background: rgba(0,0,0,0.1); border-radius: 6px; font-size: 13px; line-height: 1.6;\">
        <strong>📈 Key Findings:</strong><br>
        {% if stats.averageNote >= 16 %}
            ✓ Exceptional team performance! Average score is very high.<br>
        {% elseif stats.averageNote >= 12 %}
            ✓ Good overall performance. Consider targeted improvements for lower scores.<br>
        {% else %}
            ⚠️ Performance needs attention. Review training programs and task assignments.<br>
        {% endif %}

        {% if stats.completionRate == 100 %}
            ✓ All assigned tasks completed successfully!<br>
        {% elseif stats.completionRate >= 80 %}
            ✓ Strong completion rate. Some tasks still in progress.<br>
        {% else %}
            ⚠️ Only {{ stats.completionRate }}% tasks completed. Check for blockers.<br>
        {% endif %}

        {% if stats.excellentCount > stats.totalEvaluations / 2 %}
            ✓ More than half evaluations are excellent ratings!
        {% endif %}
    </div>
</section>
{% endif %}

<!-- Google Maps Integration for Worker Locations -->
{% if adminMode %}
<section class=\"telemetry-panel\" style=\"margin-bottom: 18px;\">
    <header>
        <h3>🗺️ Worker Locations Map & Affectations</h3>
        <span class=\"tag\">Google Maps - Farm Operations with Work Zones</span>
    </header>

    <!-- Map Container with Leaflet (Open Source Alternative) -->
    <div id=\"workerMap\" style=\"width: 100%; height: 450px; border-radius: 6px; overflow: hidden; background: #e0e0e0; margin-bottom: 12px;\">
        <!-- Leaflet Map -->
        <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css\" />
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js\"></script>
        <div id=\"map\" style=\"width: 100%; height: 100%; border-radius: 6px;\"></div>
    </div>

    <!-- Work Zone List with Weather Integration -->
    <div style=\"display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 12px;\">
        {% set workZones = {} %}
        {% for affectation in affectations %}
            {% set zone = affectation.zoneTravail|default('Unknown Zone') %}
            {% set workZones = workZones|merge({(zone): (workZones[zone]|default([]) + [affectation])}) %}
        {% endfor %}

        {% for zone, zoneAffectations in workZones %}
        <div style=\"padding: 12px; border: 2px solid #667eea; border-radius: 6px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);\">
            <strong style=\"color: #667eea; font-size: 14px;\">📍 {{ zone }}</strong>
            <div style=\"margin-top: 8px; font-size: 12px; line-height: 1.6; color: #333;\">
                <span style=\"background: #667eea; color: white; padding: 2px 6px; border-radius: 3px; display: inline-block; margin-bottom: 6px;\">{{ zoneAffectations|length }} tasks</span>

                <!-- Zone Status Breakdown -->
                {% set zoneStatuses = {} %}
                {% for aff in zoneAffectations %}
                    {% set status = aff.statut|default('Unknown') %}
                    {% set zoneStatuses = zoneStatuses|merge({(status): (zoneStatuses[status]|default(0) + 1)}) %}
                {% endfor %}

                {% for status, count in zoneStatuses %}
                    <div style=\"margin-top: 4px;\">
                        📋 <strong>{{ status }}:</strong> {{ count }}
                    </div>
                {% endfor %}

                <!-- Weather Badge for Zone -->
                {% if weatherData.list is defined %}
                    <div style=\"margin-top: 8px; padding: 6px; background: white; border-radius: 3px;\">
                        <small style=\"color: #666;\">
                            🌡️ {{ weatherData.list[0].main.temp|round }}°C
                            💧 {{ weatherData.list[0].main.humidity }}%
                        </small>
                    </div>
                {% endif %}
            </div>
        </div>
        {% endfor %}
    </div>

    <small style=\"color: #666; margin-top: 12px; display: block;\">
        ✅ Dynamic map shows all work zones. Weather data integrated for task planning. Click zone cards for details.
    </small>
</section>

<script>
// Initialize Leaflet Map
document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('map').setView([36.8065, 10.1686], 8); // Tunisia center

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Mark work zones from affectations
    const zones = {
        {% for zone, zoneAffectations in workZones %}
            \"{{ zone|escape('js') }}\": {
                count: {{ zoneAffectations|length }},
                tasks: {{ zoneAffectations|length }}
            }{{ not loop.last ? ',' : '' }}
        {% endfor %}
    };

    // Default zone coordinates (Tunisia regions)
    const zoneCoords = {
        'Tunis': [36.8065, 10.1686],
        'Ariana': [36.8697, 10.1637],
        'Manouba': [36.8118, 10.2607],
        'Sousse': [35.8256, 10.6369],
        'Sfax': [34.7406, 10.7603],
        'Gafsa': [34.4269, 8.7838],
        'Kairouan': [35.6781, 9.5898],
        'Bizerte': [37.2744, 9.8739],
        'Gabès': [33.8869, 10.0994],
        'Kasserine': [35.1667, 8.8333]
    };

    // Add markers for each zone
    let markersAdded = 0;
    for (const zone in zones) {
        const coords = zoneCoords[zone] || [36.8065 + Math.random() * 2, 10.1686 + Math.random() * 2];
        const zoneInfo = zones[zone];

        const markerColor = zoneInfo.tasks > 5 ? 'red' : zoneInfo.tasks > 2 ? 'orange' : 'green';

        L.circleMarker(coords, {
            radius: Math.min(20, 10 + zoneInfo.tasks),
            fillColor: markerColor,
            color: '#fff',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.7
        }).bindPopup(`
            <strong>\${zone}</strong><br>
            Tasks: \${zoneInfo.count}<br>
            <small>Click for details</small>
        `).addTo(map);

        markersAdded++;
    }

    console.log('✅ Leaflet Map initialized with', markersAdded, 'zones');
});
</script>
{% endif %}
{% if adminMode and stats is defined %}
<section class=\"stats-rail\">
    <article class=\"stat-tile\">
        <span class=\"k\">Total Affectations</span>
        <span class=\"v\">{{ stats.totalAffectations|default(0) }}</span>
        <small>Task assignments in system</small>
    </article>
    <article class=\"stat-tile\">
        <span class=\"k\">Completion Rate</span>
        <span class=\"v\">{{ stats.completionRate|default(0) }}%</span>
        <small>Tasks successfully completed</small>
    </article>
    <article class=\"stat-tile\">
        <span class=\"k\">Evaluations Count</span>
        <span class=\"v\">{{ stats.totalEvaluations|default(0) }}</span>
        <small>Performance reviews</small>
    </article>
    <article class=\"stat-tile\">
        <span class=\"k\">Average Performance</span>
        <span class=\"v\">{{ stats.averageNote|default(0) }}/20</span>
        <small>Mean worker rating</small>
    </article>
</section>

<!-- Charts and Technical Analytics Section -->
<section class=\"telemetry-grid\" style=\"margin-top: 24px;\">
    <!-- Status Distribution Chart -->
    <article class=\"telemetry-panel\">
        <header>
            <h3>Task Status Distribution</h3>
            <span class=\"tag\">Current workflow states</span>
        </header>
        <canvas id=\"statusChart\" style=\"max-height: 280px;\"></canvas>
    </article>

    <!-- Quality Distribution Chart -->
    <article class=\"telemetry-panel\">
        <header>
            <h3>Performance Quality Ratings</h3>
            <span class=\"tag\">Worker performance assessment</span>
        </header>
        <canvas id=\"qualityChart\" style=\"max-height: 280px;\"></canvas>
    </article>

    <!-- Task Type Distribution -->
    {% if stats.typeCounts %}
    <article class=\"telemetry-panel\">
        <header>
            <h3>Task Types Breakdown</h3>
            <span class=\"tag\">Distribution of work assignments</span>
        </header>
        <canvas id=\"typeChart\" style=\"max-height: 280px;\"></canvas>
    </article>
    {% endif %}

    <!-- Work Zones Distribution -->
    {% if stats.zoneCounts %}
    <article class=\"telemetry-panel\">
        <header>
            <h3>Work Zones Activity</h3>
            <span class=\"tag\">Geographical distribution</span>
        </header>
        <canvas id=\"zoneChart\" style=\"max-height: 280px;\"></canvas>
    </article>
    {% endif %}

    <!-- Technical Dashboard -->
    <article class=\"telemetry-panel\" style=\"grid-column: 1 / -1;\">
        <header>
            <h3>Database Signals & Technical Metrics</h3>
            <span class=\"tag\">Live system telemetry</span>
        </header>
        <dl class=\"kv-grid\">
            <div>
                <dt>Database Engine</dt>
                <dd>SQLite 3 (ACID)</dd>
            </div>
            <div>
                <dt>Total Affectations</dt>
                <dd>{{ stats.totalAffectations|default(0) }} records</dd>
            </div>
            <div>
                <dt>Total Evaluations</dt>
                <dd>{{ stats.totalEvaluations|default(0) }} records</dd>
            </div>
            <div>
                <dt>Average Rating</dt>
                <dd>{{ stats.averageNote|default(0) }}/20</dd>
            </div>
            <div>
                <dt>Completion Status</dt>
                <dd>{{ stats.statusCounts['Complété']|default(0) }} / {{ stats.totalAffectations|default(0) }}</dd>
            </div>
            <div>
                <dt>In Progress Tasks</dt>
                <dd>{{ stats.statusCounts['En cours']|default(0) }}</dd>
            </div>
            <div>
                <dt>Pending Tasks</dt>
                <dd>{{ stats.statusCounts['En attente']|default(0) }}</dd>
            </div>
            <div>
                <dt>Suspended/Cancelled</dt>
                <dd>{{ (stats.statusCounts['Suspendu']|default(0)) + (stats.statusCounts['Annulé']|default(0)) }}</dd>
            </div>
            <div>
                <dt>Task Types Count</dt>
                <dd>{{ stats.typeCounts|length }} different types</dd>
            </div>
            <div>
                <dt>Work Zones Count</dt>
                <dd>{{ stats.zoneCounts|length }} zones</dd>
            </div>
            <div>
                <dt>Excellent Quality Reviews</dt>
                <dd>{{ stats.qualityCounts['Excellent']|default(0) }}</dd>
            </div>
            <div>
                <dt>Time Span Coverage</dt>
                <dd>{{ stats.dateStats.daysSpan|default(0) }} days</dd>
            </div>
            <div>
                <dt>Earliest Assignment</dt>
                <dd>{{ stats.dateStats.earliestDate|default('N/A') }}</dd>
            </div>
            <div>
                <dt>Latest Assignment</dt>
                <dd>{{ stats.dateStats.latestDate|default('N/A') }}</dd>
            </div>
            <div>
                <dt>Ongoing Active Tasks</dt>
                <dd>{{ stats.dateStats.ongoingCount|default(0) }}</dd>
            </div>
            <div>
                <dt>Connection Type</dt>
                <dd>PDO via Doctrine DBAL</dd>
            </div>
        </dl>
    </article>
</section>

<!-- Chart.js Render Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Color palette matching admin dashboard
    const colors = {
        success: '#89b66b',
        warning: '#f0b75f',
        danger: '#d86a5b',
        primary: '#667eea',
        accent: '#764ba2'
    };

    // Status Chart
    const statusCtx = document.getElementById('statusChart')?.getContext('2d');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['En attente', 'En cours', 'Complété', 'Suspendu', 'Annulé'],
                datasets: [{
                    data: [
                        {{ stats.statusCounts['En attente']|default(0) }},
                        {{ stats.statusCounts['En cours']|default(0) }},
                        {{ stats.statusCounts['Complété']|default(0) }},
                        {{ stats.statusCounts['Suspendu']|default(0) }},
                        {{ stats.statusCounts['Annulé']|default(0) }}
                    ],
                    backgroundColor: [
                        '#e8d4c4',
                        '#b3d9e8',
                        colors.success,
                        colors.warning,
                        colors.danger
                    ],
                    borderColor: 'white',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 12 } } }
                }
            }
        });
    }

    // Quality Chart
    const qualityCtx = document.getElementById('qualityChart')?.getContext('2d');
    if (qualityCtx) {
        new Chart(qualityCtx, {
            type: 'bar',
            data: {
                labels: ['Excellent', 'Très bon', 'Bon', 'Acceptable', 'Insuffisant'],
                datasets: [{
                    label: 'Reviews',
                    data: [
                        {{ stats.qualityCounts['Excellent']|default(0) }},
                        {{ stats.qualityCounts['Très bon']|default(0) }},
                        {{ stats.qualityCounts['Bon']|default(0) }},
                        {{ stats.qualityCounts['Acceptable']|default(0) }},
                        {{ stats.qualityCounts['Insuffisant']|default(0) }}
                    ],
                    backgroundColor: [
                        colors.success,
                        '#89c9b3',
                        '#a8d5ba',
                        colors.warning,
                        colors.danger
                    ]
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: { legend: { display: true, labels: { font: { size: 11 } } } }
            }
        });
    }

    // Type Chart
    const typeCtx = document.getElementById('typeChart')?.getContext('2d');
    if (typeCtx) {
        const typeLabels = Object.keys({{ stats.typeCounts|json_encode }});
        const typeData = Object.values({{ stats.typeCounts|json_encode }});
        new Chart(typeCtx, {
            type: 'pie',
            data: {
                labels: typeLabels,
                datasets: [{
                    data: typeData,
                    backgroundColor: [
                        colors.primary,
                        colors.success,
                        colors.warning,
                        colors.danger,
                        colors.accent,
                        '#8ba3d0'
                    ],
                    borderColor: 'white',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'right', labels: { font: { size: 11 } } } }
            }
        });
    }

    // Zone Chart
    const zoneCtx = document.getElementById('zoneChart')?.getContext('2d');
    if (zoneCtx) {
        const zoneLabels = Object.keys({{ stats.zoneCounts|json_encode }});
        const zoneData = Object.values({{ stats.zoneCounts|json_encode }});
        new Chart(zoneCtx, {
            type: 'radar',
            data: {
                labels: zoneLabels,
                datasets: [{
                    label: 'Tasks',
                    data: zoneData,
                    backgroundColor: 'rgba(102, 126, 234, 0.15)',
                    borderColor: colors.primary,
                    pointBackgroundColor: colors.primary,
                    pointBorderColor: 'white',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: { r: { beginAtZero: true, grid: { color: '#f0f0f0' } } },
                plugins: { legend: { labels: { font: { size: 11 } } } }
            }
        });
    }
});
</script>
{% endif %}

<section class=\"crud-section\">
    <!-- Flash Messages Section -->
    {% for message in app.flashes('error') %}
        <div style=\"background-color: #fee; border: 1px solid #fcc; border-radius: 8px; padding: 16px; margin-bottom: 20px; color: #c33; font-weight: 500;\">
            <div style=\"display: flex; align-items: center; gap: 10px;\">
                <span style=\"font-size: 20px;\">⚠️</span>
                <div>
                    <strong>Erreur de validation</strong>
                    <p style=\"margin: 8px 0 0 0; font-weight: 400;\">{{ message }}</p>
                </div>
            </div>
        </div>
    {% endfor %}

    {% for message in app.flashes('success') %}
        <div style=\"background-color: #efe; border: 1px solid #cfc; border-radius: 8px; padding: 16px; margin-bottom: 20px; color: #3c3; font-weight: 500;\">
            <div style=\"display: flex; align-items: center; gap: 10px;\">
                <span style=\"font-size: 20px;\">✅</span>
                <div>
                    <strong>Succès</strong>
                    <p style=\"margin: 8px 0 0 0; font-weight: 400;\">{{ message }}</p>
                </div>
            </div>
        </div>
    {% endfor %}

    <!-- Affectation (Task Assignments) Card -->
    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Affectation</h2>
                <p>Assign and manage work tasks with dates and status.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"primary\" onclick=\"document.querySelector('form[data-form-type=affectation]')?.scrollIntoView({behavior:'smooth'})\">Add affectation</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <!-- Affectations List -->
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    {% if adminMode %}
                        <input class=\"input\" type=\"search\" placeholder=\"Search by ID or type...\" id=\"affectation-search\">
                    {% else %}
                        <input class=\"input\" type=\"search\" placeholder=\"Search affectations...\" id=\"affectation-search\">
                    {% endif %}
                    <span class=\"pill\">{{ affectations|length }} records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            {% if adminMode %}<th>Id</th>{% endif %}
                            <th>Type</th>
                            <th>Zone</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id=\"affectation-list\">
                        {% if affectations|length > 0 %}
                            {% for aff in affectations %}
                                <tr>
                                    {% if adminMode %}<td>#AF-{{ \"%02d\"|format(aff.id|default(0)) }}</td>{% endif %}
                                    <td style=\"font-weight: 500;\">{{ aff.typeTravail|default('N/A') }}</td>
                                    <td>
                                        📍 {{ aff.zoneTravail|default('N/A') }}
                                        {% if weatherData.list is defined %}
                                            <div style=\"font-size: 11px; color: #666; margin-top: 3px;\">
                                                🌡️ {{ weatherData.list[0].main.temp|round }}°C · 💧 {{ weatherData.list[0].main.humidity }}%
                                            </div>
                                        {% endif %}
                                    </td>
                                    <td>{{ aff.dateDebut|date('Y-m-d')|default('N/A') }}</td>
                                    <td>{{ aff.dateFin|date('Y-m-d')|default('N/A') }}</td>
                                    <td>
                                        {% if aff.statut == 'En cours' %}
                                            <span class=\"status ok\">● {{ aff.statut }}</span>
                                        {% elseif aff.statut == 'Complété' %}
                                            <span class=\"status ok\">✓ {{ aff.statut }}</span>
                                        {% elseif aff.statut == 'Suspendu' or aff.statut == 'Annulé' %}
                                            <span class=\"status warn\">⚠ {{ aff.statut }}</span>
                                        {% else %}
                                            <span class=\"status\">◌ {{ aff.statut|default('N/A') }}</span>
                                        {% endif %}
                                    </td>
                                    <td style=\"font-size: 13px;\">
                                        <a href=\"{{ adminMode ? path('admin_management_workers_edit', {id: aff.id}) : path('management_workers_edit', {id: aff.id}) }}\" class=\"link\">✏️ Edit</a>
                                        <form method=\"POST\" action=\"{{ adminMode ? path('admin_management_workers_delete', {id: aff.id}) : path('management_workers_delete', {id: aff.id}) }}\" style=\"display:inline\">
                                            <input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token('delete_affectation_' ~ aff.id) }}\">
                                            <button type=\"submit\" class=\"link danger\" onclick=\"return confirm('Delete this affectation?')\">🗑️ Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            {% endfor %}
                        {% else %}
                            <tr>
                                <td colspan=\"{% if adminMode %}7{% else %}6{% endif %}\" style=\"text-align:center; padding:20px\">No affectations found</td>
                            </tr>
                        {% endif %}
                    </tbody>
                </table>
            </div>

            <!-- Affectation Form -->
            <div class=\"crud-form\">
                <h3>{{ affectationEditing ? 'Edit affectation' : 'Create affectation' }}</h3>
                <form method=\"POST\" data-form-type=\"affectation\">
                    <input type=\"hidden\" name=\"form_type\" value=\"affectation\">
                    <input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token(affectationEditing ? 'edit_affectation_' ~ affectation.id : 'create_affectation') }}\">
                    {% if affectationEditing %}
                        <input type=\"hidden\" name=\"affectation_id\" value=\"{{ affectation.id|default('') }}\">
                    {% endif %}

                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Type de travail *</span>
                            <input class=\"input\" type=\"text\" name=\"type_travail\" placeholder=\"Ex: Récolte, Labour, Plantage\" value=\"{{ affectation.typeTravail|default('') }}\" minlength=\"3\" maxlength=\"100\" required>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Minimum 3 caractères requis</small>
                        </label>
                        <label class=\"field\">
                            <span>Zone de travail *</span>
                            <input class=\"input\" type=\"text\" name=\"zone_travail\" placeholder=\"Ex: Champ Nord\" value=\"{{ affectation.zoneTravail|default('') }}\" minlength=\"3\" maxlength=\"100\" required>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Minimum 3 caractères requis</small>
                        </label>
                        <label class=\"field\">
                            <span>Date début *</span>
                            <input class=\"input\" type=\"date\" name=\"date_debut\" value=\"{{ affectation.dateDebut|date('Y-m-d')|default('') }}\" required>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Requis</small>
                        </label>
                        <label class=\"field\">
                            <span>Date fin *</span>
                            <input class=\"input\" type=\"date\" name=\"date_fin\" value=\"{{ affectation.dateFin|date('Y-m-d')|default('') }}\" required>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Doit être >= à la date début</small>
                        </label>
                        <label class=\"field\" style=\"grid-column: 1 / -1\">
                            <span>Statut *</span>
                            <select class=\"input\" name=\"statut\" required>
                                <option value=\"\">Select status</option>
                                <option value=\"En attente\" {% if affectation.statut == 'En attente' %}selected{% endif %}>En attente</option>
                                <option value=\"En cours\" {% if affectation.statut == 'En cours' %}selected{% endif %}>En cours</option>
                                <option value=\"Complété\" {% if affectation.statut == 'Complété' %}selected{% endif %}>Complété</option>
                                <option value=\"Suspendu\" {% if affectation.statut == 'Suspendu' %}selected{% endif %}>Suspendu</option>
                                <option value=\"Annulé\" {% if affectation.statut == 'Annulé' %}selected{% endif %}>Annulé</option>
                            </select>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\">Save</button>
                        <a href=\"{{ adminMode ? path('admin_management_workers') : path('management_workers') }}\" class=\"ghost\">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Evaluation (Performance) Card -->
    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Evaluation Performance</h2>
                <p>Track and rate worker performance on completed tasks.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"primary\" onclick=\"document.querySelector('form[data-form-type=evaluation]')?.scrollIntoView({behavior:'smooth'})\">Add evaluation</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <!-- Evaluations List -->
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    {% if adminMode %}
                        <input class=\"input\" type=\"search\" placeholder=\"Search by ID or quality...\" id=\"evaluation-search\">
                    {% else %}
                        <input class=\"input\" type=\"search\" placeholder=\"Search evaluations...\" id=\"evaluation-search\">
                    {% endif %}
                    <span class=\"pill\">{{ evaluations|length }} records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            {% if adminMode %}<th>Id</th>{% endif %}
                            <th>Affectation</th>
                            <th>Note</th>
                            <th>Quality</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id=\"evaluation-list\">
                        {% if evaluations|length > 0 %}
                            {% for eval in evaluations %}
                                <tr>
                                    {% if adminMode %}<td>#EV-{{ \"%02d\"|format(eval.id|default(0)) }}</td>{% endif %}
                                    <td style=\"font-weight: 500;\">
                                        <a href=\"{{ adminMode ? path('admin_management_workers_edit', {id: eval.affectationId}) : path('management_workers_edit', {id: eval.affectationId}) }}\" class=\"link\" style=\"text-decoration: none;\">
                                            #AF-{{ \"%02d\"|format(eval.affectationId|default(0)) }}
                                        </a>
                                    </td>
                                    <td style=\"text-align: center; font-weight: 600; padding: 6px 10px;\">
                                        {% if eval.note >= 16 %}
                                            <span style=\"background: #89b66b; color: white; padding: 2px 8px; border-radius: 12px;\">{{ eval.note }}/20</span>
                                        {% elseif eval.note >= 12 %}
                                            <span style=\"background: #f0b75f; color: white; padding: 2px 8px; border-radius: 12px;\">{{ eval.note }}/20</span>
                                        {% else %}
                                            <span style=\"background: #d86a5b; color: white; padding: 2px 8px; border-radius: 12px;\">{{ eval.note }}/20</span>
                                        {% endif %}
                                    </td>
                                    <td>
                                        {% if eval.qualite == 'Excellent' %}
                                            <span class=\"status ok\">⭐ {{ eval.qualite }}</span>
                                        {% elseif eval.qualite == 'Très bon' %}
                                            <span class=\"status ok\">👍 {{ eval.qualite }}</span>
                                        {% elseif eval.qualite == 'Bon' %}
                                            <span class=\"status\">✓ {{ eval.qualite }}</span>
                                        {% elseif eval.qualite == 'Acceptable' %}
                                            <span class=\"status warn\">~ {{ eval.qualite }}</span>
                                        {% elseif eval.qualite == 'Insuffisant' %}
                                            <span class=\"status warn\">✗ {{ eval.qualite }}</span>
                                        {% else %}
                                            {{ eval.qualite|default('N/A') }}
                                        {% endif %}
                                    </td>
                                    <td>{{ eval.dateEvaluation|date('Y-m-d')|default('N/A') }}</td>
                                    <td style=\"font-size: 13px;\">
                                        <a href=\"{{ adminMode ? path('admin_management_evaluation_edit', {id: eval.id}) : path('management_evaluation_edit', {id: eval.id}) }}\" class=\"link\">✏️ Edit</a>
                                        <form method=\"POST\" action=\"{{ adminMode ? path('admin_management_evaluation_delete', {id: eval.id}) : path('management_evaluation_delete', {id: eval.id}) }}\" style=\"display:inline\">
                                            <input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token('delete_evaluation_' ~ eval.id) }}\">
                                            <button type=\"submit\" class=\"link danger\" onclick=\"return confirm('Delete this evaluation?')\">🗑️ Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            {% endfor %}
                        {% else %}
                            <tr>
                                <td colspan=\"{% if adminMode %}6{% else %}5{% endif %}\" style=\"text-align:center; padding:20px\">No evaluations found</td>
                            </tr>
                        {% endif %}
                    </tbody>
                </table>
            </div>

            <!-- Evaluation Form -->
            <div class=\"crud-form\">
                <h3>{{ evaluationEditing ? 'Edit evaluation' : 'Create evaluation' }}</h3>
                <form method=\"POST\" data-form-type=\"evaluation\">
                    <input type=\"hidden\" name=\"form_type\" value=\"evaluation\">
                    <input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token(evaluationEditing ? 'edit_evaluation_' ~ evaluation.id : 'create_evaluation') }}\">
                    {% if evaluationEditing %}
                        <input type=\"hidden\" name=\"evaluation_id\" value=\"{{ evaluation.id|default('') }}\">
                    {% endif %}

                    <div class=\"form-grid\">
                        <label class=\"field\" style=\"grid-column: 1 / -1\">
                            <span>Affectation *</span>
                            <select class=\"input\" name=\"affectation_id\" required>
                                <option value=\"\">Select an affectation</option>
                                {% for aff in affectations %}
                                    <option value=\"{{ aff.id }}\" {% if evaluation.affectationId == aff.id %}selected{% endif %}>
                                        #AF-{{ \"%02d\"|format(aff.id) }} - {{ aff.typeTravail }} ({{ aff.dateDebut|date('Y-m-d') }} to {{ aff.dateFin|date('Y-m-d') }})
                                    </option>
                                {% endfor %}
                            </select>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Une affectation valide est requise</small>
                        </label>
                        <label class=\"field\">
                            <span>Note (0-20) *</span>
                            <input class=\"input\" type=\"number\" name=\"note\" min=\"0\" max=\"20\" placeholder=\"Ex: 15\" value=\"{{ evaluation.note|default('') }}\" required>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Entre 0 et 20</small>
                        </label>
                        <label class=\"field\">
                            <span>Qualité *</span>
                            <select class=\"input\" name=\"qualite\" required>
                                <option value=\"\">Select quality</option>
                                <option value=\"Excellent\" {% if evaluation.qualite == 'Excellent' %}selected{% endif %}>Excellent</option>
                                <option value=\"Très bon\" {% if evaluation.qualite == 'Très bon' %}selected{% endif %}>Très bon</option>
                                <option value=\"Bon\" {% if evaluation.qualite == 'Bon' %}selected{% endif %}>Bon</option>
                                <option value=\"Acceptable\" {% if evaluation.qualite == 'Acceptable' %}selected{% endif %}>Acceptable</option>
                                <option value=\"Insuffisant\" {% if evaluation.qualite == 'Insuffisant' %}selected{% endif %}>Insuffisant</option>
                            </select>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Requis</small>
                        </label>
                        <label class=\"field\" style=\"grid-column: 1 / -1\">
                            <span>Date d'évaluation *</span>
                            <input class=\"input\" type=\"date\" name=\"date_evaluation\" value=\"{{ evaluation.dateEvaluation|date('Y-m-d')|default('') }}\" max=\"{{ 'now'|date('Y-m-d') }}\" required>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Doit être aujourd'hui ou antérieure (pas de date future)</small>
                        </label>
                        <label class=\"field\" style=\"grid-column: 1 / -1\">
                            <span>Commentaires *</span>
                            <textarea class=\"input\" name=\"commentaire\" placeholder=\"Add your comments...\" rows=\"4\" minlength=\"5\" maxlength=\"500\" style=\"font-family: inherit; padding: 8px; border: 1px solid var(--border); border-radius: 8px;\" required>{{ evaluation.commentaire|default('') }}</textarea>
                            <small style=\"color: #666; font-size: 12px; margin-top: 4px;\">Minimum 5 caractères requis</small>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\">Save</button>
                        <a href=\"{{ adminMode ? path('admin_management_workers') : path('management_workers') }}\" class=\"ghost\">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Client-side Validation Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate affectation date range
    const affectationForm = document.querySelector('form[data-form-type=\"affectation\"]');
    if (affectationForm) {
        const dateDebut = affectationForm.querySelector('input[name=\"date_debut\"]');
        const dateFin = affectationForm.querySelector('input[name=\"date_fin\"]');

        affectationForm.addEventListener('submit', function(e) {
            if (dateDebut.value && dateFin.value) {
                const start = new Date(dateDebut.value);
                const end = new Date(dateFin.value);

                if (end < start) {
                    e.preventDefault();
                    alert('❌ Erreur: La date fin doit être supérieure ou égale à la date début');
                    dateFin.focus();
                    dateFin.style.borderColor = '#d86a5b';
                    return false;
                }
            }
        });

        // Real-time validation feedback
        dateFin.addEventListener('change', function() {
            if (dateDebut.value && this.value) {
                const start = new Date(dateDebut.value);
                const end = new Date(this.value);

                if (end < start) {
                    this.style.borderColor = '#d86a5b';
                } else {
                    this.style.borderColor = '';
                }
            }
        });
    }

    // Validate note range
    const evaluationForm = document.querySelector('form[data-form-type=\"evaluation\"]');
    if (evaluationForm) {
        const affectationSelect = evaluationForm.querySelector('select[name=\"affectation_id\"]');
        const noteInput = evaluationForm.querySelector('input[name=\"note\"]');
        const dateEvaluationInput = evaluationForm.querySelector('input[name=\"date_evaluation\"]');

        // Validate affectation selection
        affectationSelect.addEventListener('change', function() {
            if (this.value === '' || parseInt(this.value) <= 0) {
                this.style.borderColor = '#d86a5b';
            } else {
                this.style.borderColor = '';
            }
        });

        // Validate note range
        noteInput.addEventListener('change', function() {
            const value = parseInt(this.value);
            if (value < 0 || value > 20) {
                this.style.borderColor = '#d86a5b';
                alert('❌ Erreur: La note doit être entre 0 et 20');
                this.value = '';
            } else {
                this.style.borderColor = '';
            }
        });

        // Validate evaluation date on change
        dateEvaluationInput.addEventListener('change', function() {
            if (this.value) {
                const evaluationDate = new Date(this.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                evaluationDate.setHours(0, 0, 0, 0);

                if (evaluationDate > today) {
                    this.style.borderColor = '#d86a5b';
                    alert('❌ Erreur: La date d\\'évaluation ne peut pas être dans le futur');
                    this.value = '';
                } else {
                    this.style.borderColor = '';
                }
            }
        });

        // Validate on form submit
        evaluationForm.addEventListener('submit', function(e) {
            let isValid = true;

            // Check affectation selection
            if (affectationSelect.value === '' || parseInt(affectationSelect.value) <= 0) {
                e.preventDefault();
                alert('❌ Erreur: Vous devez sélectionner une affectation');
                affectationSelect.focus();
                affectationSelect.style.borderColor = '#d86a5b';
                isValid = false;
            }

            // Check evaluation date
            if (isValid && dateEvaluationInput.value) {
                const evaluationDate = new Date(dateEvaluationInput.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                evaluationDate.setHours(0, 0, 0, 0);

                if (evaluationDate > today) {
                    e.preventDefault();
                    alert('❌ Erreur: La date d\\'évaluation ne peut pas être dans le futur');
                    dateEvaluationInput.focus();
                    dateEvaluationInput.style.borderColor = '#d86a5b';
                    isValid = false;
                }
            }

            return isValid;
        });
    }

    // Character count feedback
    const typeInput = document.querySelector('input[name=\"type_travail\"]');
    const zoneInput = document.querySelector('input[name=\"zone_travail\"]');
    const commentaires = document.querySelector('textarea[name=\"commentaire\"]');

    if (typeInput) {
        typeInput.addEventListener('input', function() {
            if (this.value.length < 3 && this.value.length > 0) {
                this.style.borderColor = '#f0b75f';
            } else if (this.value.length === 0) {
                this.style.borderColor = '#d86a5b';
            } else {
                this.style.borderColor = '';
            }
        });
    }

    if (zoneInput) {
        zoneInput.addEventListener('input', function() {
            if (this.value.length < 3 && this.value.length > 0) {
                this.style.borderColor = '#f0b75f';
            } else if (this.value.length === 0) {
                this.style.borderColor = '#d86a5b';
            } else {
                this.style.borderColor = '';
            }
        });
    }

    if (commentaires) {
        commentaires.addEventListener('input', function() {
            if (this.value.length < 5 && this.value.length > 0) {
                this.style.borderColor = '#f0b75f';
            } else if (this.value.length === 0) {
                this.style.borderColor = '#d86a5b';
            } else {
                this.style.borderColor = '';
            }
        });
    }

    // Search/Filter by ID and other fields (Admin only)
    const affectationSearch = document.getElementById('affectation-search');
    if (affectationSearch) {
        affectationSearch.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const affectationRows = document.querySelectorAll('#affectation-list tr');
            let visibleCount = 0;

            affectationRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let matches = false;

                if (query === '') {
                    matches = true;
                } else {
                    // Search in all cells (ID, Type, Zone, Start Date, End Date, Status)
                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(query)) {
                            matches = true;
                        }
                    });
                }

                row.style.display = matches ? '' : 'none';
                if (matches) visibleCount++;
            });

            // Show \"no results\" message if needed
            const emptyRow = document.querySelector('#affectation-list tr[style*=\"display: none\"]');
            if (visibleCount === 0 && query !== '') {
                console.log('Aucune affectation trouvée pour: ' + query);
            }
        });
    }

    // Search/Filter evaluations by ID and quality (Admin only)
    const evaluationSearch = document.getElementById('evaluation-search');
    if (evaluationSearch) {
        evaluationSearch.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const evaluationRows = document.querySelectorAll('#evaluation-list tr');
            let visibleCount = 0;

            evaluationRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let matches = false;

                if (query === '') {
                    matches = true;
                } else {
                    // Search in all cells (ID, Affectation, Note, Quality, Date)
                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(query)) {
                            matches = true;
                        }
                    });
                }

                row.style.display = matches ? '' : 'none';
                if (matches) visibleCount++;
            });

            // Show \"no results\" message if needed
            if (visibleCount === 0 && query !== '') {
                console.log('Aucune évaluation trouvée pour: ' + query);
            }
        });
    }
});
</script>
{% endblock %}
", "management/workers.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\management\\workers.html.twig");
    }
}
