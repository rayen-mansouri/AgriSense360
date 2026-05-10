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

/* admin/equipments.html.twig */
class __TwigTemplate_4f614c25f258667b43776fed78ddc4ce extends Template
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
            'heading' => [$this, 'block_heading'],
            'subhead' => [$this, 'block_subhead'],
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
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/equipments.html.twig"));

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

        yield "Admin Equipment & Maintenance";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 4
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_heading(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "heading"));

        yield "Equipment & Maintenance Command Console";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_subhead(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "subhead"));

        yield "Database telemetry, maintenance analytics, and operational CRUD for admin-level supervision.";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 7
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 8
        yield "    ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 8, $this->source); })()), "flashes", ["errors"], "method", false, false, false, 8));
        foreach ($context['_seq'] as $context["_key"] => $context["errors"]) {
            // line 9
            yield "        ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable($context["errors"]);
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 10
                yield "            <div class=\"form-warning\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
                yield "</div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 12
            yield "    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['errors'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        yield "    ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 13, $this->source); })()), "flashes", ["error"], "method", false, false, false, 13));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 14
            yield "        <div class=\"form-warning\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "</div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        yield "
    <section class=\"telemetry-panel\" style=\"margin-bottom: 18px;\">
        <header>
            <h3>Selected User Scope</h3>
            <span class=\"tag\">Admin can switch and manage each account data</span>
        </header>
        <form method=\"get\" action=\"";
        // line 22
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_equipments");
        yield "\" novalidate style=\"display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;\">
            <label style=\"min-width:280px; display:grid; gap:6px;\">
                <span>User</span>
                <select class=\"input\" name=\"user_id\" required>
                    ";
        // line 26
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["availableUsers"]) || array_key_exists("availableUsers", $context) ? $context["availableUsers"] : (function () { throw new RuntimeError('Variable "availableUsers" does not exist.', 26, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
            // line 27
            yield "                        <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 27), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 27) == (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 27, $this->source); })()))) {
                yield "selected";
            }
            yield ">
                            #";
            // line 28
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 28), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "firstName", [], "any", false, false, false, 28), "html", null, true);
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "lastName", [], "any", false, false, false, 28), "html", null, true);
            yield " (";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "roleName", [], "any", false, false, false, 28), "html", null, true);
            yield ")
                        </option>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['user'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        yield "                </select>
            </label>
            <button class=\"primary\" type=\"submit\">Load User Data</button>
        </form>
    </section>

    <section class=\"stats-rail\">
        <article class=\"stat-tile\">
            <span class=\"k\">Equipments</span>
            <span class=\"v\">";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["adminStats"]) || array_key_exists("adminStats", $context) ? $context["adminStats"] : (function () { throw new RuntimeError('Variable "adminStats" does not exist.', 40, $this->source); })()), "equipmentCount", [], "any", false, false, false, 40), "html", null, true);
        yield "</span>
            <small>Rows in EQUIPMENTS</small>
        </article>
        <article class=\"stat-tile\">
            <span class=\"k\">Maintenance Logs</span>
            <span class=\"v\">";
        // line 45
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["adminStats"]) || array_key_exists("adminStats", $context) ? $context["adminStats"] : (function () { throw new RuntimeError('Variable "adminStats" does not exist.', 45, $this->source); })()), "maintenanceCount", [], "any", false, false, false, 45), "html", null, true);
        yield "</span>
            <small>Rows in MAINTENANCE</small>
        </article>
        <article class=\"stat-tile\">
            <span class=\"k\">Total / Avg Cost</span>
            <span class=\"v\">";
        // line 50
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(CoreExtension::getAttribute($this->env, $this->source, (isset($context["adminStats"]) || array_key_exists("adminStats", $context) ? $context["adminStats"] : (function () { throw new RuntimeError('Variable "adminStats" does not exist.', 50, $this->source); })()), "maintenanceCost", [], "any", false, false, false, 50), 2, ".", ","), "html", null, true);
        yield "</span>
            <small>Avg: ";
        // line 51
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(CoreExtension::getAttribute($this->env, $this->source, (isset($context["adminStats"]) || array_key_exists("adminStats", $context) ? $context["adminStats"] : (function () { throw new RuntimeError('Variable "adminStats" does not exist.', 51, $this->source); })()), "averageCost", [], "any", false, false, false, 51), 2, ".", ","), "html", null, true);
        yield "</small>
        </article>
        <article class=\"stat-tile\">
            <span class=\"k\">Last DB Change</span>
            <span class=\"v\">";
        // line 55
        yield ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["dbTelemetry"]) || array_key_exists("dbTelemetry", $context) ? $context["dbTelemetry"] : (function () { throw new RuntimeError('Variable "dbTelemetry" does not exist.', 55, $this->source); })()), "lastDataChange", [], "any", false, false, false, 55)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["dbTelemetry"]) || array_key_exists("dbTelemetry", $context) ? $context["dbTelemetry"] : (function () { throw new RuntimeError('Variable "dbTelemetry" does not exist.', 55, $this->source); })()), "lastDataChange", [], "any", false, false, false, 55), "html", null, true)) : ("N/A"));
        yield "</span>
            <small>Most recent known table date</small>
        </article>
    </section>

    <section class=\"telemetry-grid\">
        <article class=\"telemetry-panel\">
            <header>
                <h3>Database Signals</h3>
                <span class=\"tag\">Live from SQL*Plus reads</span>
            </header>
            <dl class=\"kv-grid\">
                <div>
                    <dt>Equipments Rows</dt>
                    <dd>";
        // line 69
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["dbTelemetry"]) || array_key_exists("dbTelemetry", $context) ? $context["dbTelemetry"] : (function () { throw new RuntimeError('Variable "dbTelemetry" does not exist.', 69, $this->source); })()), "equipmentRows", [], "any", false, false, false, 69), "html", null, true);
        yield "</dd>
                </div>
                <div>
                    <dt>Maintenance Rows</dt>
                    <dd>";
        // line 73
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["dbTelemetry"]) || array_key_exists("dbTelemetry", $context) ? $context["dbTelemetry"] : (function () { throw new RuntimeError('Variable "dbTelemetry" does not exist.', 73, $this->source); })()), "maintenanceRows", [], "any", false, false, false, 73), "html", null, true);
        yield "</dd>
                </div>
                <div>
                    <dt>Last Equipment ID</dt>
                    <dd>";
        // line 77
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["dbTelemetry"]) || array_key_exists("dbTelemetry", $context) ? $context["dbTelemetry"] : (function () { throw new RuntimeError('Variable "dbTelemetry" does not exist.', 77, $this->source); })()), "latestEquipmentId", [], "any", false, false, false, 77), "html", null, true);
        yield "</dd>
                </div>
                <div>
                    <dt>Last Maintenance ID</dt>
                    <dd>";
        // line 81
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["dbTelemetry"]) || array_key_exists("dbTelemetry", $context) ? $context["dbTelemetry"] : (function () { throw new RuntimeError('Variable "dbTelemetry" does not exist.', 81, $this->source); })()), "latestMaintenanceId", [], "any", false, false, false, 81), "html", null, true);
        yield "</dd>
                </div>
                <div>
                    <dt>Estimated Next Equipment ID</dt>
                    <dd>";
        // line 85
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["dbTelemetry"]) || array_key_exists("dbTelemetry", $context) ? $context["dbTelemetry"] : (function () { throw new RuntimeError('Variable "dbTelemetry" does not exist.', 85, $this->source); })()), "nextEquipmentIdEstimate", [], "any", false, false, false, 85), "html", null, true);
        yield "</dd>
                </div>
                <div>
                    <dt>Estimated Next Maintenance ID</dt>
                    <dd>";
        // line 89
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["dbTelemetry"]) || array_key_exists("dbTelemetry", $context) ? $context["dbTelemetry"] : (function () { throw new RuntimeError('Variable "dbTelemetry" does not exist.', 89, $this->source); })()), "nextMaintenanceIdEstimate", [], "any", false, false, false, 89), "html", null, true);
        yield "</dd>
                </div>
                <div>
                    <dt>Latest Equipment Date</dt>
                    <dd>";
        // line 93
        yield ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["dbTelemetry"]) || array_key_exists("dbTelemetry", $context) ? $context["dbTelemetry"] : (function () { throw new RuntimeError('Variable "dbTelemetry" does not exist.', 93, $this->source); })()), "lastEquipmentChange", [], "any", false, false, false, 93)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["dbTelemetry"]) || array_key_exists("dbTelemetry", $context) ? $context["dbTelemetry"] : (function () { throw new RuntimeError('Variable "dbTelemetry" does not exist.', 93, $this->source); })()), "lastEquipmentChange", [], "any", false, false, false, 93), "html", null, true)) : ("N/A"));
        yield "</dd>
                </div>
                <div>
                    <dt>Latest Maintenance Date</dt>
                    <dd>";
        // line 97
        yield ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["dbTelemetry"]) || array_key_exists("dbTelemetry", $context) ? $context["dbTelemetry"] : (function () { throw new RuntimeError('Variable "dbTelemetry" does not exist.', 97, $this->source); })()), "lastMaintenanceChange", [], "any", false, false, false, 97)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["dbTelemetry"]) || array_key_exists("dbTelemetry", $context) ? $context["dbTelemetry"] : (function () { throw new RuntimeError('Variable "dbTelemetry" does not exist.', 97, $this->source); })()), "lastMaintenanceChange", [], "any", false, false, false, 97), "html", null, true)) : ("N/A"));
        yield "</dd>
                </div>
                <div>
                    <dt>Missing Purchase Dates</dt>
                    <dd>";
        // line 101
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["dbTelemetry"]) || array_key_exists("dbTelemetry", $context) ? $context["dbTelemetry"] : (function () { throw new RuntimeError('Variable "dbTelemetry" does not exist.', 101, $this->source); })()), "missingPurchaseDateCount", [], "any", false, false, false, 101), "html", null, true);
        yield "</dd>
                </div>
                <div>
                    <dt>Equipment Type Count</dt>
                    <dd>";
        // line 105
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["dbTelemetry"]) || array_key_exists("dbTelemetry", $context) ? $context["dbTelemetry"] : (function () { throw new RuntimeError('Variable "dbTelemetry" does not exist.', 105, $this->source); })()), "equipmentTypeCount", [], "any", false, false, false, 105), "html", null, true);
        yield "</dd>
                </div>
            </dl>
        </article>

        <article class=\"telemetry-panel recent-activity-panel\">
            <header>
                <h3>Recent Activity Log</h3>
                <div class=\"recent-activity-tools\">
                    <span class=\"tag\">Derived from latest records</span>
                    <label class=\"recent-activity-filter\" for=\"recent-log-date\">
                        <span>Date</span>
                        <input class=\"input\" type=\"date\" id=\"recent-log-date\">
                    </label>
                    <button class=\"ghost recent-log-reset\" type=\"button\" id=\"recent-log-reset\">Clear</button>
                </div>
            </header>
            <ul class=\"log-list\">
                ";
        // line 123
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["recentLogs"]) || array_key_exists("recentLogs", $context) ? $context["recentLogs"] : (function () { throw new RuntimeError('Variable "recentLogs" does not exist.', 123, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["log"]) {
            // line 124
            yield "                    <li data-log-date=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::slice($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["log"], "timestamp", [], "any", true, true, false, 124)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["log"], "timestamp", [], "any", false, false, false, 124), "")) : ("")), 0, 10), "html_attr");
            yield "\">
                        <span class=\"log-table\">";
            // line 125
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["log"], "table", [], "any", false, false, false, 125), "html", null, true);
            yield "</span>
                        <p>";
            // line 126
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["log"], "entry", [], "any", false, false, false, 126), "html", null, true);
            yield "</p>
                        <small>";
            // line 127
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["log"], "timestamp", [], "any", false, false, false, 127), "html", null, true);
            yield "</small>
                    </li>
                ";
            $context['_iterated'] = true;
        }
        // line 129
        if (!$context['_iterated']) {
            // line 130
            yield "                    <li data-log-empty=\"true\">
                        <span class=\"log-table\">SYSTEM</span>
                        <p>No activity available yet.</p>
                        <small>N/A</small>
                    </li>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['log'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 136
        yield "            </ul>
            <p class=\"recent-log-empty\" id=\"recent-log-empty\" hidden>No logs for selected date.</p>
        </article>
    </section>

    <section class=\"charts-grid\">
        <article class=\"chart-panel\">
            <header>
                <h3>Equipment Status Distribution</h3>
                <span>Pie chart</span>
            </header>
            <div class=\"pie-wrap\">
                <div class=\"pie\" style=\"background: conic-gradient(";
        // line 148
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["statusPieGradient"]) || array_key_exists("statusPieGradient", $context) ? $context["statusPieGradient"] : (function () { throw new RuntimeError('Variable "statusPieGradient" does not exist.', 148, $this->source); })()), "html", null, true);
        yield ");\"></div>
                <ul class=\"legend\">
                    ";
        // line 150
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["statusLegend"]) || array_key_exists("statusLegend", $context) ? $context["statusLegend"] : (function () { throw new RuntimeError('Variable "statusLegend" does not exist.', 150, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 151
            yield "                        <li>
                            <span class=\"dot\" style=\"background: ";
            // line 152
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "color", [], "any", false, false, false, 152), "html", null, true);
            yield "\"></span>
                            <span>";
            // line 153
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "label", [], "any", false, false, false, 153), "html", null, true);
            yield " (";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "value", [], "any", false, false, false, 153), "html", null, true);
            yield ")</span>
                            <strong>";
            // line 154
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "percent", [], "any", false, false, false, 154), "html", null, true);
            yield "%</strong>
                        </li>
                    ";
            $context['_iterated'] = true;
        }
        // line 156
        if (!$context['_iterated']) {
            // line 157
            yield "                        <li>No status data.</li>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['item'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 159
        yield "                </ul>
            </div>
        </article>

        <article class=\"chart-panel\">
            <header>
                <h3>Maintenance Type Distribution</h3>
                <span>Pie chart</span>
            </header>
            <div class=\"pie-wrap\">
                <div class=\"pie\" style=\"background: conic-gradient(";
        // line 169
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["maintenancePieGradient"]) || array_key_exists("maintenancePieGradient", $context) ? $context["maintenancePieGradient"] : (function () { throw new RuntimeError('Variable "maintenancePieGradient" does not exist.', 169, $this->source); })()), "html", null, true);
        yield ");\"></div>
                <ul class=\"legend\">
                    ";
        // line 171
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["maintenanceLegend"]) || array_key_exists("maintenanceLegend", $context) ? $context["maintenanceLegend"] : (function () { throw new RuntimeError('Variable "maintenanceLegend" does not exist.', 171, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 172
            yield "                        <li>
                            <span class=\"dot\" style=\"background: ";
            // line 173
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "color", [], "any", false, false, false, 173), "html", null, true);
            yield "\"></span>
                            <span>";
            // line 174
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "label", [], "any", false, false, false, 174), "html", null, true);
            yield " (";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "value", [], "any", false, false, false, 174), "html", null, true);
            yield ")</span>
                            <strong>";
            // line 175
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "percent", [], "any", false, false, false, 175), "html", null, true);
            yield "%</strong>
                        </li>
                    ";
            $context['_iterated'] = true;
        }
        // line 177
        if (!$context['_iterated']) {
            // line 178
            yield "                        <li>No maintenance data.</li>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['item'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 180
        yield "                </ul>
            </div>
        </article>

        <article class=\"chart-panel chart-wide\">
            <header>
                <h3>Maintenance Cost Trend</h3>
                <span>Curve by maintenance date</span>
            </header>
            <svg viewBox=\"0 0 760 220\" class=\"trend-svg\" id=\"trend-chart\" data-labels='";
        // line 189
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(json_encode((isset($context["costTrendLabels"]) || array_key_exists("costTrendLabels", $context) ? $context["costTrendLabels"] : (function () { throw new RuntimeError('Variable "costTrendLabels" does not exist.', 189, $this->source); })())), "html_attr");
        yield "' data-values='";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(json_encode((isset($context["costTrendValues"]) || array_key_exists("costTrendValues", $context) ? $context["costTrendValues"] : (function () { throw new RuntimeError('Variable "costTrendValues" does not exist.', 189, $this->source); })())), "html_attr");
        yield "'>
                <defs>
                    <linearGradient id=\"trend-fill\" x1=\"0\" y1=\"0\" x2=\"0\" y2=\"1\">
                        <stop offset=\"0%\" stop-color=\"rgba(129, 203, 153, 0.45)\" />
                        <stop offset=\"100%\" stop-color=\"rgba(129, 203, 153, 0.04)\" />
                    </linearGradient>
                </defs>
                <g class=\"grid-lines\"></g>
                <path class=\"trend-area\" d=\"\"></path>
                <path class=\"trend-line\" d=\"\"></path>
                <g class=\"trend-points\"></g>
                <g class=\"trend-labels\"></g>
            </svg>
        </article>
    </section>

    <div class=\"crud-grid\" id=\"admin-management-panel\">
        <section class=\"crud-card\">
            <div class=\"card-head\">
                <span class=\"pill\">EQUIPMENTS</span>
                <h2>Create or update equipment</h2>
            </div>
            <form method=\"post\" action=\"";
        // line 211
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_equipments", ["user_id" => (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 211, $this->source); })())]), "html", null, true);
        yield "\" class=\"crud-form\" id=\"equipment-form\" data-create-url=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_equipments", ["user_id" => (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 211, $this->source); })())]), "html", null, true);
        yield "\" novalidate>
                <input type=\"hidden\" name=\"equipment_id\" id=\"equipment_id\">
                <input type=\"hidden\" name=\"target_user_id\" value=\"";
        // line 213
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 213, $this->source); })()), "html", null, true);
        yield "\">
                <input type=\"hidden\" name=\"form_type\" value=\"equipment\">
                <label>
                    <span>Equipment Name</span>
                    <input class=\"input\" name=\"name\" id=\"equipment_name\" value=\"";
        // line 217
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["equipment"] ?? null), "name", [], "any", true, true, false, 217)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 217, $this->source); })()), "name", [], "any", false, false, false, 217), "")) : ("")), "html", null, true);
        yield "\" required>
                </label>
                <label>
                    <span>Type</span>
                    <input class=\"input\" name=\"type\" id=\"equipment_type\" value=\"";
        // line 221
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["equipment"] ?? null), "type", [], "any", true, true, false, 221)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 221, $this->source); })()), "type", [], "any", false, false, false, 221), "")) : ("")), "html", null, true);
        yield "\" required>
                </label>
                <label>
                    <span>Status</span>
                    <input class=\"input\" name=\"status\" id=\"equipment_status\" value=\"";
        // line 225
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["equipment"] ?? null), "status", [], "any", true, true, false, 225)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 225, $this->source); })()), "status", [], "any", false, false, false, 225), "Ready")) : ("Ready")), "html", null, true);
        yield "\" required>
                </label>
                <label>
                    <span>Purchase Date</span>
                    <input class=\"input\" type=\"date\" name=\"purchase_date\" id=\"equipment_purchase_date\" value=\"";
        // line 229
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["equipment"] ?? null), "purchaseDate", [], "any", true, true, false, 229) && CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 229, $this->source); })()), "purchaseDate", [], "any", false, false, false, 229))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 229, $this->source); })()), "purchaseDate", [], "any", false, false, false, 229), "Y-m-d"), "html", null, true)) : (""));
        yield "\">
                </label>
                <div class=\"actions-row\">
                    <button class=\"primary\" type=\"submit\">Save equipment</button>
                    <button class=\"ghost\" type=\"button\" id=\"equipment-reset\">Clear</button>
                </div>
            </form>
        </section>

        <section class=\"crud-card\">
            <div class=\"card-head\">
                <span class=\"pill\">MAINTENANCE</span>
                <h2>Create or update maintenance</h2>
            </div>
            <form method=\"post\" action=\"";
        // line 243
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_equipments", ["user_id" => (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 243, $this->source); })())]), "html", null, true);
        yield "\" class=\"crud-form\" id=\"maintenance-form\" data-create-url=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_equipments", ["user_id" => (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 243, $this->source); })())]), "html", null, true);
        yield "\" novalidate>
                <input type=\"hidden\" name=\"maintenance_id\" id=\"maintenance_id\">
                <input type=\"hidden\" name=\"target_user_id\" value=\"";
        // line 245
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 245, $this->source); })()), "html", null, true);
        yield "\">
                <input type=\"hidden\" name=\"form_type\" value=\"maintenance\">
                <label>
                    <span>Equipment</span>
                    <select class=\"input\" name=\"equipment_id\" id=\"maintenance_equipment_id\" required>
                        <option value=\"\">Select equipment</option>
                        ";
        // line 251
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["equipments"]) || array_key_exists("equipments", $context) ? $context["equipments"] : (function () { throw new RuntimeError('Variable "equipments" does not exist.', 251, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["equipmentRow"]) {
            // line 252
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "id", [], "any", false, false, false, 252), "html", null, true);
            yield "\" ";
            if ((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["maintenance"] ?? null), "equipment", [], "any", false, true, false, 252), "id", [], "any", true, true, false, 252)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 252, $this->source); })()), "equipment", [], "any", false, false, false, 252), "id", [], "any", false, false, false, 252), ((CoreExtension::getAttribute($this->env, $this->source, ($context["maintenance"] ?? null), "equipmentId", [], "any", true, true, false, 252)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 252, $this->source); })()), "equipmentId", [], "any", false, false, false, 252), ((CoreExtension::getAttribute($this->env, $this->source, ($context["maintenance"] ?? null), "equipment", [], "any", true, true, false, 252)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 252, $this->source); })()), "equipment", [], "any", false, false, false, 252), "")) : ("")))) : (((CoreExtension::getAttribute($this->env, $this->source, ($context["maintenance"] ?? null), "equipment", [], "any", true, true, false, 252)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 252, $this->source); })()), "equipment", [], "any", false, false, false, 252), "")) : ("")))))) : (((CoreExtension::getAttribute($this->env, $this->source, ($context["maintenance"] ?? null), "equipmentId", [], "any", true, true, false, 252)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 252, $this->source); })()), "equipmentId", [], "any", false, false, false, 252), ((CoreExtension::getAttribute($this->env, $this->source, ($context["maintenance"] ?? null), "equipment", [], "any", true, true, false, 252)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 252, $this->source); })()), "equipment", [], "any", false, false, false, 252), "")) : ("")))) : (((CoreExtension::getAttribute($this->env, $this->source, ($context["maintenance"] ?? null), "equipment", [], "any", true, true, false, 252)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 252, $this->source); })()), "equipment", [], "any", false, false, false, 252), "")) : ("")))))) == CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "id", [], "any", false, false, false, 252))) {
                yield "selected";
            }
            yield ">
                                #";
            // line 253
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "id", [], "any", false, false, false, 253), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "name", [], "any", false, false, false, 253), "html", null, true);
            yield " (";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "type", [], "any", false, false, false, 253), "html", null, true);
            yield ")
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['equipmentRow'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 256
        yield "                    </select>
                </label>
                <label>
                    <span>Maintenance Date</span>
                    <input class=\"input\" type=\"date\" name=\"maintenance_date\" id=\"maintenance_date\" value=\"";
        // line 260
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["maintenance"] ?? null), "maintenanceDate", [], "any", true, true, false, 260) && CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 260, $this->source); })()), "maintenanceDate", [], "any", false, false, false, 260))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 260, $this->source); })()), "maintenanceDate", [], "any", false, false, false, 260), "Y-m-d"), "html", null, true)) : (""));
        yield "\" required>
                </label>
                <label>
                    <span>Maintenance Type</span>
                    <input class=\"input\" name=\"maintenance_type\" id=\"maintenance_type\" value=\"";
        // line 264
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["maintenance"] ?? null), "maintenanceType", [], "any", true, true, false, 264)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 264, $this->source); })()), "maintenanceType", [], "any", false, false, false, 264), "Inspection")) : ("Inspection")), "html", null, true);
        yield "\" placeholder=\"Inspection, Repair, Calibration\" required>
                </label>
                <label>
                    <span>Cost</span>
                    <input class=\"input\" name=\"cost\" id=\"maintenance_cost\" type=\"number\" min=\"0\" step=\"0.01\" value=\"";
        // line 268
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["maintenance"] ?? null), "cost", [], "any", true, true, false, 268)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 268, $this->source); })()), "cost", [], "any", false, false, false, 268), "0")) : ("0")), "html", null, true);
        yield "\" required>
                </label>
                <div class=\"actions-row\">
                    <button class=\"primary\" type=\"submit\">Save maintenance</button>
                    <button class=\"ghost\" type=\"button\" id=\"maintenance-reset\">Clear</button>
                </div>
            </form>
        </section>

        <section class=\"crud-list\" id=\"equipments-table-zone\">
            <div class=\"list-head\">
                <h3>EQUIPMENTS table</h3>
                <input class=\"input\" type=\"search\" id=\"equipment-search\" placeholder=\"Search by id, name, type, status, date\">
            </div>
            <div class=\"table-wrap\">
                <table class=\"data-table\" id=\"equipments-table\">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Purchase Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    ";
        // line 295
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["equipments"]) || array_key_exists("equipments", $context) ? $context["equipments"] : (function () { throw new RuntimeError('Variable "equipments" does not exist.', 295, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["equipmentRow"]) {
            // line 296
            yield "                        <tr>
                            <td>";
            // line 297
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "id", [], "any", false, false, false, 297), "html", null, true);
            yield "</td>
                            <td>";
            // line 298
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "name", [], "any", false, false, false, 298), "html", null, true);
            yield "</td>
                            <td>";
            // line 299
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "type", [], "any", false, false, false, 299), "html", null, true);
            yield "</td>
                            <td>";
            // line 300
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "status", [], "any", false, false, false, 300), "html", null, true);
            yield "</td>
                            <td>";
            // line 301
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "purchaseDate", [], "any", false, false, false, 301)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "purchaseDate", [], "any", false, false, false, 301), "html", null, true)) : ("N/A"));
            yield "</td>
                            <td>
                                <button type=\"button\"
                                        class=\"ghost js-edit-equipment\"
                                        data-id=\"";
            // line 305
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "id", [], "any", false, false, false, 305), "html", null, true);
            yield "\"
                                        data-name=\"";
            // line 306
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "name", [], "any", false, false, false, 306), "html_attr");
            yield "\"
                                        data-type=\"";
            // line 307
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "type", [], "any", false, false, false, 307), "html_attr");
            yield "\"
                                        data-status=\"";
            // line 308
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "status", [], "any", false, false, false, 308), "html_attr");
            yield "\"
                                        data-purchase-date=\"";
            // line 309
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "purchaseDate", [], "any", true, true, false, 309)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "purchaseDate", [], "any", false, false, false, 309), "")) : ("")), "html", null, true);
            yield "\"
                                        data-edit-url=\"";
            // line 310
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_equipments_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "id", [], "any", false, false, false, 310), "user_id" => (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 310, $this->source); })())]), "html", null, true);
            yield "\">
                                    Edit
                                </button>
                                <form method=\"post\" action=\"";
            // line 313
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_equipments_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "id", [], "any", false, false, false, 313), "user_id" => (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 313, $this->source); })())]), "html", null, true);
            yield "\" class=\"inline-delete js-ajax-delete\">
                                    <input type=\"hidden\" name=\"_token\" value=\"";
            // line 314
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken(("delete_equipment_" . CoreExtension::getAttribute($this->env, $this->source, $context["equipmentRow"], "id", [], "any", false, false, false, 314))), "html", null, true);
            yield "\">
                                    <button type=\"submit\" class=\"danger\">Delete</button>
                                </form>
                            </td>
                        </tr>
                    ";
            $context['_iterated'] = true;
        }
        // line 319
        if (!$context['_iterated']) {
            // line 320
            yield "                        <tr>
                            <td colspan=\"6\">No equipment records found.</td>
                        </tr>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['equipmentRow'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 324
        yield "                    </tbody>
                </table>
            </div>
        </section>

        <section class=\"crud-list\" id=\"maintenance-table-zone\">
            <div class=\"list-head\">
                <h3>MAINTENANCE table</h3>
                <input class=\"input\" type=\"search\" id=\"maintenance-search\" placeholder=\"Search by id, equipment, date, type, cost\">
                <select class=\"input\" id=\"maintenance-search-column\">
                    <option value=\"all\">All columns</option>
                    <option value=\"id\">ID</option>
                    <option value=\"equipmentId\">Equipment ID</option>
                    <option value=\"equipmentName\">Equipment Name</option>
                    <option value=\"maintenanceDate\">Date</option>
                    <option value=\"maintenanceType\">Type</option>
                    <option value=\"cost\">Cost</option>
                </select>
            </div>
            <div class=\"table-wrap\">
                <table class=\"data-table\" id=\"maintenance-table\">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Equipment ID</th>
                        <th>Equipment Name</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Cost</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    ";
        // line 357
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["maintenances"]) || array_key_exists("maintenances", $context) ? $context["maintenances"] : (function () { throw new RuntimeError('Variable "maintenances" does not exist.', 357, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["maintenanceRow"]) {
            // line 358
            yield "                        <tr data-id=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "id", [], "any", true, true, false, 358)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "id", [], "any", false, false, false, 358), "")) : ("")), "html_attr");
            yield "\" data-equipment-id=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "equipmentId", [], "any", true, true, false, 358)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "equipmentId", [], "any", false, false, false, 358), "")) : ("")), "html_attr");
            yield "\" data-equipment-name=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "equipmentName", [], "any", true, true, false, 358)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "equipmentName", [], "any", false, false, false, 358), "")) : (""))), "html_attr");
            yield "\" data-maintenance-date=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "maintenanceDate", [], "any", true, true, false, 358)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "maintenanceDate", [], "any", false, false, false, 358), "")) : (""))), "html_attr");
            yield "\" data-maintenance-type=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "maintenanceType", [], "any", true, true, false, 358)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "maintenanceType", [], "any", false, false, false, 358), "")) : (""))), "html_attr");
            yield "\" data-cost=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "cost", [], "any", true, true, false, 358)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "cost", [], "any", false, false, false, 358), "")) : ("")), "html_attr");
            yield "\">
                            <td>";
            // line 359
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "id", [], "any", false, false, false, 359), "html", null, true);
            yield "</td>
                            <td>";
            // line 360
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "equipmentId", [], "any", false, false, false, 360), "html", null, true);
            yield "</td>
                            <td>";
            // line 361
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "equipmentName", [], "any", false, false, false, 361), "html", null, true);
            yield "</td>
                            <td>";
            // line 362
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "maintenanceDate", [], "any", false, false, false, 362)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "maintenanceDate", [], "any", false, false, false, 362), "html", null, true)) : ("N/A"));
            yield "</td>
                            <td>";
            // line 363
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "maintenanceType", [], "any", false, false, false, 363), "html", null, true);
            yield "</td>
                            <td>";
            // line 364
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "cost", [], "any", false, false, false, 364), "html", null, true);
            yield "</td>
                            <td>
                                <button type=\"button\"
                                        class=\"ghost js-edit-maintenance\"
                                        data-id=\"";
            // line 368
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "id", [], "any", false, false, false, 368), "html", null, true);
            yield "\"
                                        data-equipment-id=\"";
            // line 369
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "equipmentId", [], "any", false, false, false, 369), "html", null, true);
            yield "\"
                                        data-maintenance-date=\"";
            // line 370
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "maintenanceDate", [], "any", true, true, false, 370)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "maintenanceDate", [], "any", false, false, false, 370), "")) : ("")), "html", null, true);
            yield "\"
                                        data-maintenance-type=\"";
            // line 371
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "maintenanceType", [], "any", false, false, false, 371), "html_attr");
            yield "\"
                                        data-cost=\"";
            // line 372
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "cost", [], "any", false, false, false, 372), "html_attr");
            yield "\"
                                        data-edit-url=\"";
            // line 373
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_maintenance_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "id", [], "any", false, false, false, 373), "user_id" => (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 373, $this->source); })())]), "html", null, true);
            yield "\">
                                    Edit
                                </button>
                                <form method=\"post\" action=\"";
            // line 376
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_management_maintenance_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "id", [], "any", false, false, false, 376), "user_id" => (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 376, $this->source); })())]), "html", null, true);
            yield "\" class=\"inline-delete js-ajax-delete\">
                                    <input type=\"hidden\" name=\"_token\" value=\"";
            // line 377
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken(("delete_maintenance_" . CoreExtension::getAttribute($this->env, $this->source, $context["maintenanceRow"], "id", [], "any", false, false, false, 377))), "html", null, true);
            yield "\">
                                    <button type=\"submit\" class=\"danger\">Delete</button>
                                </form>
                            </td>
                        </tr>
                    ";
            $context['_iterated'] = true;
        }
        // line 382
        if (!$context['_iterated']) {
            // line 383
            yield "                        <tr>
                            <td colspan=\"7\">No maintenance logs found.</td>
                        </tr>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['maintenanceRow'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 387
        yield "                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <script>
        function drawTrendCurve() {
            const svg = document.getElementById('trend-chart');
            if (!svg) {
                return;
            }

            const labels = JSON.parse(svg.dataset.labels || '[]');
            const values = JSON.parse(svg.dataset.values || '[]').map((v) => Number(v));
            if (!Array.isArray(values) || values.length === 0) {
                return;
            }

            const width = 760;
            const height = 220;
            const paddingX = 38;
            const paddingTop = 22;
            const paddingBottom = 36;
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
                .map((point) => {
                    const shortLabel = point.label ? point.label.slice(5) : '';
                    return `<text x=\"\${point.x.toFixed(2)}\" y=\"\${height - 12}\" text-anchor=\"middle\">\${shortLabel}</text>`;
                })
                .join('');
        }

        function wireAdminPanel() {
            drawTrendCurve();

            const equipmentForm = document.getElementById('equipment-form');
            const maintenanceForm = document.getElementById('maintenance-form');
            const equipmentIdInput = document.getElementById('equipment_id');
            const equipmentNameInput = document.getElementById('equipment_name');
            const equipmentTypeInput = document.getElementById('equipment_type');
            const equipmentStatusInput = document.getElementById('equipment_status');
            const equipmentPurchaseDateInput = document.getElementById('equipment_purchase_date');
            const maintenanceIdInput = document.getElementById('maintenance_id');
            const maintenanceEquipmentInput = document.getElementById('maintenance_equipment_id');
            const maintenanceDateInput = document.getElementById('maintenance_date');
            const maintenanceTypeInput = document.getElementById('maintenance_type');
            const maintenanceCostInput = document.getElementById('maintenance_cost');

            const equipmentReset = document.getElementById('equipment-reset');
            const maintenanceReset = document.getElementById('maintenance-reset');
            const searchInput = document.getElementById('equipment-search');
            const equipmentRows = document.querySelectorAll('#equipments-table tbody tr');
            const maintenanceSearchInput = document.getElementById('maintenance-search');
            const maintenanceSearchColumn = document.getElementById('maintenance-search-column');
            const maintenanceRows = document.querySelectorAll('#maintenance-table tbody tr');
            const recentLogDateInput = document.getElementById('recent-log-date');
            const recentLogResetButton = document.getElementById('recent-log-reset');
            const recentLogRows = Array.from(document.querySelectorAll('.log-list li:not([data-log-empty=\"true\"])'));
            const recentLogEmpty = document.getElementById('recent-log-empty');

            function applyRecentLogDateFilter() {
                if (!recentLogDateInput || !recentLogEmpty || recentLogRows.length === 0) {
                    return;
                }

                const selectedDate = recentLogDateInput.value;
                let visibleCount = 0;

                recentLogRows.forEach((row) => {
                    const rowDate = (row.dataset.logDate || '').slice(0, 10);
                    const shouldShow = selectedDate === '' || rowDate === selectedDate;
                    row.style.display = shouldShow ? '' : 'none';
                    if (shouldShow) {
                        visibleCount += 1;
                    }
                });

                recentLogEmpty.hidden = visibleCount !== 0;
            }

            document.querySelectorAll('.js-edit-equipment').forEach((button) => {
                button.addEventListener('click', () => {
                    equipmentIdInput.value = button.dataset.id || '';
                    equipmentNameInput.value = button.dataset.name || '';
                    equipmentTypeInput.value = button.dataset.type || '';
                    equipmentStatusInput.value = button.dataset.status || '';
                    equipmentPurchaseDateInput.value = button.dataset.purchaseDate || '';
                    equipmentForm.action = button.dataset.editUrl || equipmentForm.dataset.createUrl;
                    equipmentNameInput.focus();
                });
            });

            document.querySelectorAll('.js-edit-maintenance').forEach((button) => {
                button.addEventListener('click', () => {
                    maintenanceIdInput.value = button.dataset.id || '';
                    maintenanceEquipmentInput.value = button.dataset.equipmentId || '';
                    maintenanceDateInput.value = button.dataset.maintenanceDate || '';
                    maintenanceTypeInput.value = button.dataset.maintenanceType || '';
                    maintenanceCostInput.value = button.dataset.cost || '';
                    maintenanceForm.action = button.dataset.editUrl || maintenanceForm.dataset.createUrl;
                    maintenanceDateInput.focus();
                });
            });

            if (equipmentReset) {
                equipmentReset.addEventListener('click', () => {
                    equipmentForm.reset();
                    equipmentIdInput.value = '';
                    equipmentForm.action = equipmentForm.dataset.createUrl;
                });
            }

            if (maintenanceReset) {
                maintenanceReset.addEventListener('click', () => {
                    maintenanceForm.reset();
                    maintenanceIdInput.value = '';
                    maintenanceForm.action = maintenanceForm.dataset.createUrl;
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', () => {
                    const term = searchInput.value.trim().toLowerCase();
                    equipmentRows.forEach((row) => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(term) ? '' : 'none';
                    });
                });
            }

            function applyMaintenanceSearch() {
                if (!maintenanceSearchInput) {
                    return;
                }

                const term = maintenanceSearchInput.value.trim().toLowerCase();
                const column = maintenanceSearchColumn ? maintenanceSearchColumn.value : 'all';

                maintenanceRows.forEach((row) => {
                    const text = column === 'all'
                        ? row.textContent.toLowerCase()
                        : String(row.dataset[column] || '').toLowerCase();
                    row.style.display = text.includes(term) ? '' : 'none';
                });
            }

            if (maintenanceSearchInput) {
                maintenanceSearchInput.addEventListener('input', applyMaintenanceSearch);
            }

            if (maintenanceSearchColumn) {
                maintenanceSearchColumn.addEventListener('change', applyMaintenanceSearch);
            }

            if (recentLogDateInput) {
                recentLogDateInput.addEventListener('input', applyRecentLogDateFilter);
                recentLogDateInput.addEventListener('change', applyRecentLogDateFilter);
            }

            if (recentLogResetButton && recentLogDateInput) {
                recentLogResetButton.addEventListener('click', () => {
                    recentLogDateInput.value = '';
                    applyRecentLogDateFilter();
                });
            }

            applyRecentLogDateFilter();

            document.querySelectorAll('.js-ajax-delete').forEach((form) => {
                form.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (response.ok) {
                        window.location.reload();
                    }
                });
            });

            [equipmentForm, maintenanceForm].forEach((form) => {
                if (!form) {
                    return;
                }
                form.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (response.ok) {
                        window.location.reload();
                    }
                });
            });
        }

        wireAdminPanel();
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
        return "admin/equipments.html.twig";
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
        return array (  881 => 387,  872 => 383,  870 => 382,  860 => 377,  856 => 376,  850 => 373,  846 => 372,  842 => 371,  838 => 370,  834 => 369,  830 => 368,  823 => 364,  819 => 363,  815 => 362,  811 => 361,  807 => 360,  803 => 359,  788 => 358,  783 => 357,  748 => 324,  739 => 320,  737 => 319,  727 => 314,  723 => 313,  717 => 310,  713 => 309,  709 => 308,  705 => 307,  701 => 306,  697 => 305,  690 => 301,  686 => 300,  682 => 299,  678 => 298,  674 => 297,  671 => 296,  666 => 295,  636 => 268,  629 => 264,  622 => 260,  616 => 256,  603 => 253,  594 => 252,  590 => 251,  581 => 245,  574 => 243,  557 => 229,  550 => 225,  543 => 221,  536 => 217,  529 => 213,  522 => 211,  495 => 189,  484 => 180,  477 => 178,  475 => 177,  468 => 175,  462 => 174,  458 => 173,  455 => 172,  450 => 171,  445 => 169,  433 => 159,  426 => 157,  424 => 156,  417 => 154,  411 => 153,  407 => 152,  404 => 151,  399 => 150,  394 => 148,  380 => 136,  369 => 130,  367 => 129,  360 => 127,  356 => 126,  352 => 125,  347 => 124,  342 => 123,  321 => 105,  314 => 101,  307 => 97,  300 => 93,  293 => 89,  286 => 85,  279 => 81,  272 => 77,  265 => 73,  258 => 69,  241 => 55,  234 => 51,  230 => 50,  222 => 45,  214 => 40,  203 => 31,  188 => 28,  179 => 27,  175 => 26,  168 => 22,  160 => 16,  151 => 14,  146 => 13,  140 => 12,  131 => 10,  126 => 9,  121 => 8,  111 => 7,  94 => 5,  77 => 4,  60 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'admin/layout.html.twig' %}

{% block title %}Admin Equipment & Maintenance{% endblock %}
{% block heading %}Equipment & Maintenance Command Console{% endblock %}
{% block subhead %}Database telemetry, maintenance analytics, and operational CRUD for admin-level supervision.{% endblock %}

{% block body %}
    {% for errors in app.flashes('errors') %}
        {% for message in errors %}
            <div class=\"form-warning\">{{ message }}</div>
        {% endfor %}
    {% endfor %}
    {% for message in app.flashes('error') %}
        <div class=\"form-warning\">{{ message }}</div>
    {% endfor %}

    <section class=\"telemetry-panel\" style=\"margin-bottom: 18px;\">
        <header>
            <h3>Selected User Scope</h3>
            <span class=\"tag\">Admin can switch and manage each account data</span>
        </header>
        <form method=\"get\" action=\"{{ path('admin_management_equipments') }}\" novalidate style=\"display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;\">
            <label style=\"min-width:280px; display:grid; gap:6px;\">
                <span>User</span>
                <select class=\"input\" name=\"user_id\" required>
                    {% for user in availableUsers %}
                        <option value=\"{{ user.id }}\" {% if user.id == selectedUserId %}selected{% endif %}>
                            #{{ user.id }} - {{ user.firstName }} {{ user.lastName }} ({{ user.roleName }})
                        </option>
                    {% endfor %}
                </select>
            </label>
            <button class=\"primary\" type=\"submit\">Load User Data</button>
        </form>
    </section>

    <section class=\"stats-rail\">
        <article class=\"stat-tile\">
            <span class=\"k\">Equipments</span>
            <span class=\"v\">{{ adminStats.equipmentCount }}</span>
            <small>Rows in EQUIPMENTS</small>
        </article>
        <article class=\"stat-tile\">
            <span class=\"k\">Maintenance Logs</span>
            <span class=\"v\">{{ adminStats.maintenanceCount }}</span>
            <small>Rows in MAINTENANCE</small>
        </article>
        <article class=\"stat-tile\">
            <span class=\"k\">Total / Avg Cost</span>
            <span class=\"v\">{{ adminStats.maintenanceCost|number_format(2, '.', ',') }}</span>
            <small>Avg: {{ adminStats.averageCost|number_format(2, '.', ',') }}</small>
        </article>
        <article class=\"stat-tile\">
            <span class=\"k\">Last DB Change</span>
            <span class=\"v\">{{ dbTelemetry.lastDataChange ?: 'N/A' }}</span>
            <small>Most recent known table date</small>
        </article>
    </section>

    <section class=\"telemetry-grid\">
        <article class=\"telemetry-panel\">
            <header>
                <h3>Database Signals</h3>
                <span class=\"tag\">Live from SQL*Plus reads</span>
            </header>
            <dl class=\"kv-grid\">
                <div>
                    <dt>Equipments Rows</dt>
                    <dd>{{ dbTelemetry.equipmentRows }}</dd>
                </div>
                <div>
                    <dt>Maintenance Rows</dt>
                    <dd>{{ dbTelemetry.maintenanceRows }}</dd>
                </div>
                <div>
                    <dt>Last Equipment ID</dt>
                    <dd>{{ dbTelemetry.latestEquipmentId }}</dd>
                </div>
                <div>
                    <dt>Last Maintenance ID</dt>
                    <dd>{{ dbTelemetry.latestMaintenanceId }}</dd>
                </div>
                <div>
                    <dt>Estimated Next Equipment ID</dt>
                    <dd>{{ dbTelemetry.nextEquipmentIdEstimate }}</dd>
                </div>
                <div>
                    <dt>Estimated Next Maintenance ID</dt>
                    <dd>{{ dbTelemetry.nextMaintenanceIdEstimate }}</dd>
                </div>
                <div>
                    <dt>Latest Equipment Date</dt>
                    <dd>{{ dbTelemetry.lastEquipmentChange ?: 'N/A' }}</dd>
                </div>
                <div>
                    <dt>Latest Maintenance Date</dt>
                    <dd>{{ dbTelemetry.lastMaintenanceChange ?: 'N/A' }}</dd>
                </div>
                <div>
                    <dt>Missing Purchase Dates</dt>
                    <dd>{{ dbTelemetry.missingPurchaseDateCount }}</dd>
                </div>
                <div>
                    <dt>Equipment Type Count</dt>
                    <dd>{{ dbTelemetry.equipmentTypeCount }}</dd>
                </div>
            </dl>
        </article>

        <article class=\"telemetry-panel recent-activity-panel\">
            <header>
                <h3>Recent Activity Log</h3>
                <div class=\"recent-activity-tools\">
                    <span class=\"tag\">Derived from latest records</span>
                    <label class=\"recent-activity-filter\" for=\"recent-log-date\">
                        <span>Date</span>
                        <input class=\"input\" type=\"date\" id=\"recent-log-date\">
                    </label>
                    <button class=\"ghost recent-log-reset\" type=\"button\" id=\"recent-log-reset\">Clear</button>
                </div>
            </header>
            <ul class=\"log-list\">
                {% for log in recentLogs %}
                    <li data-log-date=\"{{ log.timestamp|default('')|slice(0, 10)|e('html_attr') }}\">
                        <span class=\"log-table\">{{ log.table }}</span>
                        <p>{{ log.entry }}</p>
                        <small>{{ log.timestamp }}</small>
                    </li>
                {% else %}
                    <li data-log-empty=\"true\">
                        <span class=\"log-table\">SYSTEM</span>
                        <p>No activity available yet.</p>
                        <small>N/A</small>
                    </li>
                {% endfor %}
            </ul>
            <p class=\"recent-log-empty\" id=\"recent-log-empty\" hidden>No logs for selected date.</p>
        </article>
    </section>

    <section class=\"charts-grid\">
        <article class=\"chart-panel\">
            <header>
                <h3>Equipment Status Distribution</h3>
                <span>Pie chart</span>
            </header>
            <div class=\"pie-wrap\">
                <div class=\"pie\" style=\"background: conic-gradient({{ statusPieGradient }});\"></div>
                <ul class=\"legend\">
                    {% for item in statusLegend %}
                        <li>
                            <span class=\"dot\" style=\"background: {{ item.color }}\"></span>
                            <span>{{ item.label }} ({{ item.value }})</span>
                            <strong>{{ item.percent }}%</strong>
                        </li>
                    {% else %}
                        <li>No status data.</li>
                    {% endfor %}
                </ul>
            </div>
        </article>

        <article class=\"chart-panel\">
            <header>
                <h3>Maintenance Type Distribution</h3>
                <span>Pie chart</span>
            </header>
            <div class=\"pie-wrap\">
                <div class=\"pie\" style=\"background: conic-gradient({{ maintenancePieGradient }});\"></div>
                <ul class=\"legend\">
                    {% for item in maintenanceLegend %}
                        <li>
                            <span class=\"dot\" style=\"background: {{ item.color }}\"></span>
                            <span>{{ item.label }} ({{ item.value }})</span>
                            <strong>{{ item.percent }}%</strong>
                        </li>
                    {% else %}
                        <li>No maintenance data.</li>
                    {% endfor %}
                </ul>
            </div>
        </article>

        <article class=\"chart-panel chart-wide\">
            <header>
                <h3>Maintenance Cost Trend</h3>
                <span>Curve by maintenance date</span>
            </header>
            <svg viewBox=\"0 0 760 220\" class=\"trend-svg\" id=\"trend-chart\" data-labels='{{ costTrendLabels|json_encode|e('html_attr') }}' data-values='{{ costTrendValues|json_encode|e('html_attr') }}'>
                <defs>
                    <linearGradient id=\"trend-fill\" x1=\"0\" y1=\"0\" x2=\"0\" y2=\"1\">
                        <stop offset=\"0%\" stop-color=\"rgba(129, 203, 153, 0.45)\" />
                        <stop offset=\"100%\" stop-color=\"rgba(129, 203, 153, 0.04)\" />
                    </linearGradient>
                </defs>
                <g class=\"grid-lines\"></g>
                <path class=\"trend-area\" d=\"\"></path>
                <path class=\"trend-line\" d=\"\"></path>
                <g class=\"trend-points\"></g>
                <g class=\"trend-labels\"></g>
            </svg>
        </article>
    </section>

    <div class=\"crud-grid\" id=\"admin-management-panel\">
        <section class=\"crud-card\">
            <div class=\"card-head\">
                <span class=\"pill\">EQUIPMENTS</span>
                <h2>Create or update equipment</h2>
            </div>
            <form method=\"post\" action=\"{{ path('admin_management_equipments', {'user_id': selectedUserId}) }}\" class=\"crud-form\" id=\"equipment-form\" data-create-url=\"{{ path('admin_management_equipments', {'user_id': selectedUserId}) }}\" novalidate>
                <input type=\"hidden\" name=\"equipment_id\" id=\"equipment_id\">
                <input type=\"hidden\" name=\"target_user_id\" value=\"{{ selectedUserId }}\">
                <input type=\"hidden\" name=\"form_type\" value=\"equipment\">
                <label>
                    <span>Equipment Name</span>
                    <input class=\"input\" name=\"name\" id=\"equipment_name\" value=\"{{ equipment.name|default('') }}\" required>
                </label>
                <label>
                    <span>Type</span>
                    <input class=\"input\" name=\"type\" id=\"equipment_type\" value=\"{{ equipment.type|default('') }}\" required>
                </label>
                <label>
                    <span>Status</span>
                    <input class=\"input\" name=\"status\" id=\"equipment_status\" value=\"{{ equipment.status|default('Ready') }}\" required>
                </label>
                <label>
                    <span>Purchase Date</span>
                    <input class=\"input\" type=\"date\" name=\"purchase_date\" id=\"equipment_purchase_date\" value=\"{{ equipment.purchaseDate is defined and equipment.purchaseDate ? equipment.purchaseDate|date('Y-m-d') : '' }}\">
                </label>
                <div class=\"actions-row\">
                    <button class=\"primary\" type=\"submit\">Save equipment</button>
                    <button class=\"ghost\" type=\"button\" id=\"equipment-reset\">Clear</button>
                </div>
            </form>
        </section>

        <section class=\"crud-card\">
            <div class=\"card-head\">
                <span class=\"pill\">MAINTENANCE</span>
                <h2>Create or update maintenance</h2>
            </div>
            <form method=\"post\" action=\"{{ path('admin_management_equipments', {'user_id': selectedUserId}) }}\" class=\"crud-form\" id=\"maintenance-form\" data-create-url=\"{{ path('admin_management_equipments', {'user_id': selectedUserId}) }}\" novalidate>
                <input type=\"hidden\" name=\"maintenance_id\" id=\"maintenance_id\">
                <input type=\"hidden\" name=\"target_user_id\" value=\"{{ selectedUserId }}\">
                <input type=\"hidden\" name=\"form_type\" value=\"maintenance\">
                <label>
                    <span>Equipment</span>
                    <select class=\"input\" name=\"equipment_id\" id=\"maintenance_equipment_id\" required>
                        <option value=\"\">Select equipment</option>
                        {% for equipmentRow in equipments %}
                            <option value=\"{{ equipmentRow.id }}\" {% if maintenance.equipment.id|default(maintenance.equipmentId|default(maintenance.equipment|default(''))) == equipmentRow.id %}selected{% endif %}>
                                #{{ equipmentRow.id }} - {{ equipmentRow.name }} ({{ equipmentRow.type }})
                            </option>
                        {% endfor %}
                    </select>
                </label>
                <label>
                    <span>Maintenance Date</span>
                    <input class=\"input\" type=\"date\" name=\"maintenance_date\" id=\"maintenance_date\" value=\"{{ maintenance.maintenanceDate is defined and maintenance.maintenanceDate ? maintenance.maintenanceDate|date('Y-m-d') : '' }}\" required>
                </label>
                <label>
                    <span>Maintenance Type</span>
                    <input class=\"input\" name=\"maintenance_type\" id=\"maintenance_type\" value=\"{{ maintenance.maintenanceType|default('Inspection') }}\" placeholder=\"Inspection, Repair, Calibration\" required>
                </label>
                <label>
                    <span>Cost</span>
                    <input class=\"input\" name=\"cost\" id=\"maintenance_cost\" type=\"number\" min=\"0\" step=\"0.01\" value=\"{{ maintenance.cost|default('0') }}\" required>
                </label>
                <div class=\"actions-row\">
                    <button class=\"primary\" type=\"submit\">Save maintenance</button>
                    <button class=\"ghost\" type=\"button\" id=\"maintenance-reset\">Clear</button>
                </div>
            </form>
        </section>

        <section class=\"crud-list\" id=\"equipments-table-zone\">
            <div class=\"list-head\">
                <h3>EQUIPMENTS table</h3>
                <input class=\"input\" type=\"search\" id=\"equipment-search\" placeholder=\"Search by id, name, type, status, date\">
            </div>
            <div class=\"table-wrap\">
                <table class=\"data-table\" id=\"equipments-table\">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Purchase Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for equipmentRow in equipments %}
                        <tr>
                            <td>{{ equipmentRow.id }}</td>
                            <td>{{ equipmentRow.name }}</td>
                            <td>{{ equipmentRow.type }}</td>
                            <td>{{ equipmentRow.status }}</td>
                            <td>{{ equipmentRow.purchaseDate ?: 'N/A' }}</td>
                            <td>
                                <button type=\"button\"
                                        class=\"ghost js-edit-equipment\"
                                        data-id=\"{{ equipmentRow.id }}\"
                                        data-name=\"{{ equipmentRow.name|e('html_attr') }}\"
                                        data-type=\"{{ equipmentRow.type|e('html_attr') }}\"
                                        data-status=\"{{ equipmentRow.status|e('html_attr') }}\"
                                        data-purchase-date=\"{{ equipmentRow.purchaseDate|default('') }}\"
                                        data-edit-url=\"{{ path('admin_management_equipments_edit', {'id': equipmentRow.id, 'user_id': selectedUserId}) }}\">
                                    Edit
                                </button>
                                <form method=\"post\" action=\"{{ path('admin_management_equipments_delete', {'id': equipmentRow.id, 'user_id': selectedUserId}) }}\" class=\"inline-delete js-ajax-delete\">
                                    <input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token('delete_equipment_' ~ equipmentRow.id) }}\">
                                    <button type=\"submit\" class=\"danger\">Delete</button>
                                </form>
                            </td>
                        </tr>
                    {% else %}
                        <tr>
                            <td colspan=\"6\">No equipment records found.</td>
                        </tr>
                    {% endfor %}
                    </tbody>
                </table>
            </div>
        </section>

        <section class=\"crud-list\" id=\"maintenance-table-zone\">
            <div class=\"list-head\">
                <h3>MAINTENANCE table</h3>
                <input class=\"input\" type=\"search\" id=\"maintenance-search\" placeholder=\"Search by id, equipment, date, type, cost\">
                <select class=\"input\" id=\"maintenance-search-column\">
                    <option value=\"all\">All columns</option>
                    <option value=\"id\">ID</option>
                    <option value=\"equipmentId\">Equipment ID</option>
                    <option value=\"equipmentName\">Equipment Name</option>
                    <option value=\"maintenanceDate\">Date</option>
                    <option value=\"maintenanceType\">Type</option>
                    <option value=\"cost\">Cost</option>
                </select>
            </div>
            <div class=\"table-wrap\">
                <table class=\"data-table\" id=\"maintenance-table\">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Equipment ID</th>
                        <th>Equipment Name</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Cost</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for maintenanceRow in maintenances %}
                        <tr data-id=\"{{ maintenanceRow.id|default('')|e('html_attr') }}\" data-equipment-id=\"{{ maintenanceRow.equipmentId|default('')|e('html_attr') }}\" data-equipment-name=\"{{ maintenanceRow.equipmentName|default('')|lower|e('html_attr') }}\" data-maintenance-date=\"{{ maintenanceRow.maintenanceDate|default('')|lower|e('html_attr') }}\" data-maintenance-type=\"{{ maintenanceRow.maintenanceType|default('')|lower|e('html_attr') }}\" data-cost=\"{{ maintenanceRow.cost|default('')|e('html_attr') }}\">
                            <td>{{ maintenanceRow.id }}</td>
                            <td>{{ maintenanceRow.equipmentId }}</td>
                            <td>{{ maintenanceRow.equipmentName }}</td>
                            <td>{{ maintenanceRow.maintenanceDate ?: 'N/A' }}</td>
                            <td>{{ maintenanceRow.maintenanceType }}</td>
                            <td>{{ maintenanceRow.cost }}</td>
                            <td>
                                <button type=\"button\"
                                        class=\"ghost js-edit-maintenance\"
                                        data-id=\"{{ maintenanceRow.id }}\"
                                        data-equipment-id=\"{{ maintenanceRow.equipmentId }}\"
                                        data-maintenance-date=\"{{ maintenanceRow.maintenanceDate|default('') }}\"
                                        data-maintenance-type=\"{{ maintenanceRow.maintenanceType|e('html_attr') }}\"
                                        data-cost=\"{{ maintenanceRow.cost|e('html_attr') }}\"
                                        data-edit-url=\"{{ path('admin_management_maintenance_edit', {'id': maintenanceRow.id, 'user_id': selectedUserId}) }}\">
                                    Edit
                                </button>
                                <form method=\"post\" action=\"{{ path('admin_management_maintenance_delete', {'id': maintenanceRow.id, 'user_id': selectedUserId}) }}\" class=\"inline-delete js-ajax-delete\">
                                    <input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token('delete_maintenance_' ~ maintenanceRow.id) }}\">
                                    <button type=\"submit\" class=\"danger\">Delete</button>
                                </form>
                            </td>
                        </tr>
                    {% else %}
                        <tr>
                            <td colspan=\"7\">No maintenance logs found.</td>
                        </tr>
                    {% endfor %}
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <script>
        function drawTrendCurve() {
            const svg = document.getElementById('trend-chart');
            if (!svg) {
                return;
            }

            const labels = JSON.parse(svg.dataset.labels || '[]');
            const values = JSON.parse(svg.dataset.values || '[]').map((v) => Number(v));
            if (!Array.isArray(values) || values.length === 0) {
                return;
            }

            const width = 760;
            const height = 220;
            const paddingX = 38;
            const paddingTop = 22;
            const paddingBottom = 36;
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
                .map((point) => {
                    const shortLabel = point.label ? point.label.slice(5) : '';
                    return `<text x=\"\${point.x.toFixed(2)}\" y=\"\${height - 12}\" text-anchor=\"middle\">\${shortLabel}</text>`;
                })
                .join('');
        }

        function wireAdminPanel() {
            drawTrendCurve();

            const equipmentForm = document.getElementById('equipment-form');
            const maintenanceForm = document.getElementById('maintenance-form');
            const equipmentIdInput = document.getElementById('equipment_id');
            const equipmentNameInput = document.getElementById('equipment_name');
            const equipmentTypeInput = document.getElementById('equipment_type');
            const equipmentStatusInput = document.getElementById('equipment_status');
            const equipmentPurchaseDateInput = document.getElementById('equipment_purchase_date');
            const maintenanceIdInput = document.getElementById('maintenance_id');
            const maintenanceEquipmentInput = document.getElementById('maintenance_equipment_id');
            const maintenanceDateInput = document.getElementById('maintenance_date');
            const maintenanceTypeInput = document.getElementById('maintenance_type');
            const maintenanceCostInput = document.getElementById('maintenance_cost');

            const equipmentReset = document.getElementById('equipment-reset');
            const maintenanceReset = document.getElementById('maintenance-reset');
            const searchInput = document.getElementById('equipment-search');
            const equipmentRows = document.querySelectorAll('#equipments-table tbody tr');
            const maintenanceSearchInput = document.getElementById('maintenance-search');
            const maintenanceSearchColumn = document.getElementById('maintenance-search-column');
            const maintenanceRows = document.querySelectorAll('#maintenance-table tbody tr');
            const recentLogDateInput = document.getElementById('recent-log-date');
            const recentLogResetButton = document.getElementById('recent-log-reset');
            const recentLogRows = Array.from(document.querySelectorAll('.log-list li:not([data-log-empty=\"true\"])'));
            const recentLogEmpty = document.getElementById('recent-log-empty');

            function applyRecentLogDateFilter() {
                if (!recentLogDateInput || !recentLogEmpty || recentLogRows.length === 0) {
                    return;
                }

                const selectedDate = recentLogDateInput.value;
                let visibleCount = 0;

                recentLogRows.forEach((row) => {
                    const rowDate = (row.dataset.logDate || '').slice(0, 10);
                    const shouldShow = selectedDate === '' || rowDate === selectedDate;
                    row.style.display = shouldShow ? '' : 'none';
                    if (shouldShow) {
                        visibleCount += 1;
                    }
                });

                recentLogEmpty.hidden = visibleCount !== 0;
            }

            document.querySelectorAll('.js-edit-equipment').forEach((button) => {
                button.addEventListener('click', () => {
                    equipmentIdInput.value = button.dataset.id || '';
                    equipmentNameInput.value = button.dataset.name || '';
                    equipmentTypeInput.value = button.dataset.type || '';
                    equipmentStatusInput.value = button.dataset.status || '';
                    equipmentPurchaseDateInput.value = button.dataset.purchaseDate || '';
                    equipmentForm.action = button.dataset.editUrl || equipmentForm.dataset.createUrl;
                    equipmentNameInput.focus();
                });
            });

            document.querySelectorAll('.js-edit-maintenance').forEach((button) => {
                button.addEventListener('click', () => {
                    maintenanceIdInput.value = button.dataset.id || '';
                    maintenanceEquipmentInput.value = button.dataset.equipmentId || '';
                    maintenanceDateInput.value = button.dataset.maintenanceDate || '';
                    maintenanceTypeInput.value = button.dataset.maintenanceType || '';
                    maintenanceCostInput.value = button.dataset.cost || '';
                    maintenanceForm.action = button.dataset.editUrl || maintenanceForm.dataset.createUrl;
                    maintenanceDateInput.focus();
                });
            });

            if (equipmentReset) {
                equipmentReset.addEventListener('click', () => {
                    equipmentForm.reset();
                    equipmentIdInput.value = '';
                    equipmentForm.action = equipmentForm.dataset.createUrl;
                });
            }

            if (maintenanceReset) {
                maintenanceReset.addEventListener('click', () => {
                    maintenanceForm.reset();
                    maintenanceIdInput.value = '';
                    maintenanceForm.action = maintenanceForm.dataset.createUrl;
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', () => {
                    const term = searchInput.value.trim().toLowerCase();
                    equipmentRows.forEach((row) => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(term) ? '' : 'none';
                    });
                });
            }

            function applyMaintenanceSearch() {
                if (!maintenanceSearchInput) {
                    return;
                }

                const term = maintenanceSearchInput.value.trim().toLowerCase();
                const column = maintenanceSearchColumn ? maintenanceSearchColumn.value : 'all';

                maintenanceRows.forEach((row) => {
                    const text = column === 'all'
                        ? row.textContent.toLowerCase()
                        : String(row.dataset[column] || '').toLowerCase();
                    row.style.display = text.includes(term) ? '' : 'none';
                });
            }

            if (maintenanceSearchInput) {
                maintenanceSearchInput.addEventListener('input', applyMaintenanceSearch);
            }

            if (maintenanceSearchColumn) {
                maintenanceSearchColumn.addEventListener('change', applyMaintenanceSearch);
            }

            if (recentLogDateInput) {
                recentLogDateInput.addEventListener('input', applyRecentLogDateFilter);
                recentLogDateInput.addEventListener('change', applyRecentLogDateFilter);
            }

            if (recentLogResetButton && recentLogDateInput) {
                recentLogResetButton.addEventListener('click', () => {
                    recentLogDateInput.value = '';
                    applyRecentLogDateFilter();
                });
            }

            applyRecentLogDateFilter();

            document.querySelectorAll('.js-ajax-delete').forEach((form) => {
                form.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (response.ok) {
                        window.location.reload();
                    }
                });
            });

            [equipmentForm, maintenanceForm].forEach((form) => {
                if (!form) {
                    return;
                }
                form.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (response.ok) {
                        window.location.reload();
                    }
                });
            });
        }

        wireAdminPanel();
    </script>
{% endblock %}
", "admin/equipments.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\admin\\equipments.html.twig");
    }
}
