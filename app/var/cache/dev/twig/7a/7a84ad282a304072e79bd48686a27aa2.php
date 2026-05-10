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

/* management/animals.html.twig */
class __TwigTemplate_0faceb1393b9457d79f0e12097584128 extends Template
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
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "management/animals.html.twig"));

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

        yield "Animals Management";
        
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

        yield "Animals Management";
        
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

        yield "Animal management";
        
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

        yield "Track animals, health records, and shared option lists with sortable, searchable tables.";
        
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
        $context["pageRoute"] = (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 9, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("admin_management_animals") : ("management_animals"));
        // line 10
        $context["animalSaveRoute"] = (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 10, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("admin_management_animals_save") : ("management_animals_save"));
        // line 11
        $context["animalDeleteRoute"] = (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 11, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("admin_management_animals_delete") : ("management_animals_delete"));
        // line 12
        $context["recordSaveRoute"] = (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 12, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("admin_management_animal_record_save") : ("management_animal_record_save"));
        // line 13
        $context["recordDeleteRoute"] = (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 13, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("admin_management_animal_record_delete") : ("management_animal_record_delete"));
        // line 14
        $context["typeAddRoute"] = "admin_management_animal_type_add";
        // line 15
        $context["typeDeleteRoute"] = "admin_management_animal_type_delete";
        // line 16
        $context["locationAddRoute"] = "admin_management_animal_location_add";
        // line 17
        $context["locationDeleteRoute"] = "admin_management_animal_location_delete";
        // line 18
        $context["currentAnimalId"] = (((($tmp = (isset($context["selectedAnimal"]) || array_key_exists("selectedAnimal", $context) ? $context["selectedAnimal"] : (function () { throw new RuntimeError('Variable "selectedAnimal" does not exist.', 18, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, (isset($context["selectedAnimal"]) || array_key_exists("selectedAnimal", $context) ? $context["selectedAnimal"] : (function () { throw new RuntimeError('Variable "selectedAnimal" does not exist.', 18, $this->source); })()), "id", [], "any", false, false, false, 18)) : (0));
        // line 19
        yield "
<section class=\"crud-section animals-page\">
    ";
        // line 21
        if ((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 21, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 22
            yield "        <div class=\"crud-card\">
            <div class=\"crud-head\">
                <div>
                    <h2>Owner selector</h2>
                    <p>Choose the user whose animals you want to manage.</p>
                </div>
            </div>
            <form method=\"get\" class=\"form-grid\" style=\"grid-template-columns: minmax(0, 1fr) auto; align-items:end;\">
                <label class=\"field\" style=\"grid-column: 1 / -1;\">
                    <span>User</span>
                    <select class=\"input\" name=\"user_id\">
                        ";
            // line 33
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["availableUsers"]) || array_key_exists("availableUsers", $context) ? $context["availableUsers"] : (function () { throw new RuntimeError('Variable "availableUsers" does not exist.', 33, $this->source); })()));
            $context['_iterated'] = false;
            foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
                // line 34
                yield "                            <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 34), "html", null, true);
                yield "\" ";
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 34) == (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 34, $this->source); })()))) {
                    yield "selected";
                }
                yield ">
                                ";
                // line 35
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "firstName", [], "any", false, false, false, 35), "html", null, true);
                yield " ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "lastName", [], "any", false, false, false, 35), "html", null, true);
                yield " - ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "email", [], "any", false, false, false, 35), "html", null, true);
                yield "
                            </option>
                        ";
                $context['_iterated'] = true;
            }
            // line 37
            if (!$context['_iterated']) {
                // line 38
                yield "                            <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 38, $this->source); })()), "html", null, true);
                yield "\">Current admin</option>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['user'], $context['_parent'], $context['_iterated']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 40
            yield "                    </select>
                </label>
                <input type=\"hidden\" name=\"animalId\" value=\"";
            // line 42
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["currentAnimalId"]) || array_key_exists("currentAnimalId", $context) ? $context["currentAnimalId"] : (function () { throw new RuntimeError('Variable "currentAnimalId" does not exist.', 42, $this->source); })()), "html", null, true);
            yield "\">
                <button class=\"primary\" type=\"submit\">Switch user</button>
            </form>
        </div>
    ";
        }
        // line 47
        yield "
    ";
        // line 48
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 48, $this->source); })()), "flashes", ["success"], "method", false, false, false, 48));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 49
            yield "        <div class=\"flash flash-success\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "</div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 51
        yield "    ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 51, $this->source); })()), "flashes", ["error"], "method", false, false, false, 51));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 52
            yield "        <div class=\"flash flash-error\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "</div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 54
        yield "    ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 54, $this->source); })()), "flashes", ["errors"], "method", false, false, false, 54));
        foreach ($context['_seq'] as $context["_key"] => $context["errors"]) {
            // line 55
            yield "        ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable($context["errors"]);
            foreach ($context['_seq'] as $context["key"] => $context["message"]) {
                // line 56
                yield "            <div class=\"flash flash-error\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["key"], "html", null, true);
                yield ": ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
                yield "</div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['key'], $context['message'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 58
            yield "    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['errors'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 59
        yield "
    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Animal insights</h2>
                <p>Operational stats and quick distributions for this management scope.</p>
            </div>
        </div>
        <div class=\"ops-kpi-grid\">
            <article class=\"ops-kpi\">
                <span class=\"k\">Animals</span>
                <strong>";
        // line 70
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["animalInsights"]) || array_key_exists("animalInsights", $context) ? $context["animalInsights"] : (function () { throw new RuntimeError('Variable "animalInsights" does not exist.', 70, $this->source); })()), "stats", [], "any", false, false, false, 70), "animalCount", [], "any", false, false, false, 70), "html", null, true);
        yield "</strong>
                <small>Total rows in animals table.</small>
            </article>
            <article class=\"ops-kpi\">
                <span class=\"k\">Health Records</span>
                <strong>";
        // line 75
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["animalInsights"]) || array_key_exists("animalInsights", $context) ? $context["animalInsights"] : (function () { throw new RuntimeError('Variable "animalInsights" does not exist.', 75, $this->source); })()), "stats", [], "any", false, false, false, 75), "recordCount", [], "any", false, false, false, 75), "html", null, true);
        yield "</strong>
                <small>Total rows in health records table.</small>
            </article>
            <article class=\"ops-kpi\">
                <span class=\"k\">Vaccinated</span>
                <strong>";
        // line 80
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["animalInsights"]) || array_key_exists("animalInsights", $context) ? $context["animalInsights"] : (function () { throw new RuntimeError('Variable "animalInsights" does not exist.', 80, $this->source); })()), "stats", [], "any", false, false, false, 80), "vaccinatedCount", [], "any", false, false, false, 80), "html", null, true);
        yield "</strong>
                <small>Animals currently marked vaccinated.</small>
            </article>
            <article class=\"ops-kpi\">
                <span class=\"k\">Critical Cases</span>
                <strong>";
        // line 85
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["animalInsights"]) || array_key_exists("animalInsights", $context) ? $context["animalInsights"] : (function () { throw new RuntimeError('Variable "animalInsights" does not exist.', 85, $this->source); })()), "stats", [], "any", false, false, false, 85), "criticalCount", [], "any", false, false, false, 85), "html", null, true);
        yield "</strong>
                <small>Records with CRITICAL condition.</small>
            </article>
        </div>
        <div class=\"ops-grid\" style=\"margin-top:18px;\">
            <article class=\"ops-panel\">
                <header>
                    <h3>Animal Type Mix</h3>
                </header>
                <ul class=\"ops-bar-list\">
                    ";
        // line 95
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["animalInsights"]) || array_key_exists("animalInsights", $context) ? $context["animalInsights"] : (function () { throw new RuntimeError('Variable "animalInsights" does not exist.', 95, $this->source); })()), "animalTypeLegend", [], "any", false, false, false, 95));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 96
            yield "                        <li>
                            <div class=\"meta\"><span>";
            // line 97
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "label", [], "any", false, false, false, 97), "html", null, true);
            yield "</span><strong>";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "value", [], "any", false, false, false, 97), "html", null, true);
            yield " (";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "percent", [], "any", false, false, false, 97), "html", null, true);
            yield "%)</strong></div>
                            <div class=\"track\"><span style=\"width: ";
            // line 98
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "percent", [], "any", false, false, false, 98), "html", null, true);
            yield "%; background: ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "color", [], "any", false, false, false, 98), "html", null, true);
            yield ";\"></span></div>
                        </li>
                    ";
            $context['_iterated'] = true;
        }
        // line 100
        if (!$context['_iterated']) {
            // line 101
            yield "                        <li class=\"ops-empty\">No animal data available yet.</li>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['row'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 103
        yield "                </ul>
            </article>
            <article class=\"ops-panel\">
                <header>
                    <h3>Condition Mix</h3>
                </header>
                <ul class=\"ops-bar-list\">
                    ";
        // line 110
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["animalInsights"]) || array_key_exists("animalInsights", $context) ? $context["animalInsights"] : (function () { throw new RuntimeError('Variable "animalInsights" does not exist.', 110, $this->source); })()), "conditionLegend", [], "any", false, false, false, 110));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 111
            yield "                        <li>
                            <div class=\"meta\"><span>";
            // line 112
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "label", [], "any", false, false, false, 112), "html", null, true);
            yield "</span><strong>";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "value", [], "any", false, false, false, 112), "html", null, true);
            yield " (";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "percent", [], "any", false, false, false, 112), "html", null, true);
            yield "%)</strong></div>
                            <div class=\"track\"><span style=\"width: ";
            // line 113
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "percent", [], "any", false, false, false, 113), "html", null, true);
            yield "%; background: ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "color", [], "any", false, false, false, 113), "html", null, true);
            yield ";\"></span></div>
                        </li>
                    ";
            $context['_iterated'] = true;
        }
        // line 115
        if (!$context['_iterated']) {
            // line 116
            yield "                        <li class=\"ops-empty\">No health record data available yet.</li>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['row'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 118
        yield "                </ul>
            </article>
        </div>
    </div>

    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Animals</h2>
                <p>";
        // line 127
        yield (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 127, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Manage the selected user's herd.") : ("Manage your animals and keep profile values in sync."));
        yield "</p>
            </div>
            <div class=\"crud-actions\">
                <span class=\"pill\">";
        // line 130
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["animalCount"]) || array_key_exists("animalCount", $context) ? $context["animalCount"] : (function () { throw new RuntimeError('Variable "animalCount" does not exist.', 130, $this->source); })()), "html", null, true);
        yield " records</span>
            </div>
        </div>

        <div class=\"crud-grid animals-entry-grid animals-entry-row\">
            <div class=\"crud-form\" id=\"animal-form\">
                <h3>";
        // line 136
        yield (((($tmp = (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 136, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Edit animal") : ("Create animal"));
        yield "</h3>
                <form method=\"post\" action=\"";
        // line 137
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath((isset($context["animalSaveRoute"]) || array_key_exists("animalSaveRoute", $context) ? $context["animalSaveRoute"] : (function () { throw new RuntimeError('Variable "animalSaveRoute" does not exist.', 137, $this->source); })()));
        yield "\">
                    <input type=\"hidden\" name=\"id\" value=\"";
        // line 138
        yield (((($tmp = (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 138, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 138, $this->source); })()), "id", [], "any", false, false, false, 138), "html", null, true)) : (""));
        yield "\">
                    <input type=\"hidden\" name=\"animal_id\" value=\"";
        // line 139
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["currentAnimalId"]) || array_key_exists("currentAnimalId", $context) ? $context["currentAnimalId"] : (function () { throw new RuntimeError('Variable "currentAnimalId" does not exist.', 139, $this->source); })()), "html", null, true);
        yield "\">
                    ";
        // line 140
        if ((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 140, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 141
            yield "                        <input type=\"hidden\" name=\"user_id\" value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 141, $this->source); })()), "html", null, true);
            yield "\">
                    ";
        }
        // line 143
        yield "                    <div class=\"form-grid animals-form-grid\">
                        <label class=\"field\">
                            <span>Ear tag</span>
                            <input class=\"input\" type=\"number\" name=\"ear_tag\" value=\"";
        // line 146
        yield (((($tmp = (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 146, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 146, $this->source); })()), "earTag", [], "any", false, false, false, 146), "html", null, true)) : (""));
        yield "\" required>
                        </label>
                        <label class=\"field\">
                            <span>Type</span>
                            <select class=\"input\" name=\"type\" required>
                                <option value=\"\">Select type</option>
                                ";
        // line 152
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["types"]) || array_key_exists("types", $context) ? $context["types"] : (function () { throw new RuntimeError('Variable "types" does not exist.', 152, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["type"]) {
            // line 153
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["type"], "html", null, true);
            yield "\" ";
            if (((isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 153, $this->source); })()) && (CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 153, $this->source); })()), "type", [], "any", false, false, false, 153) == $context["type"]))) {
                yield "selected";
            }
            yield ">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["type"], "html", null, true);
            yield "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['type'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 155
        yield "                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Weight</span>
                            <input class=\"input\" type=\"text\" name=\"weight\" value=\"";
        // line 159
        yield ((((isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 159, $this->source); })()) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 159, $this->source); })()), "weight", [], "any", false, false, false, 159)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 159, $this->source); })()), "weight", [], "any", false, false, false, 159), "html", null, true)) : (""));
        yield "\" placeholder=\"0.0\">
                        </label>
                        <label class=\"field\">
                            <span>Birth date</span>
                            <input class=\"input\" type=\"date\" name=\"birth_date\" value=\"";
        // line 163
        yield ((((isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 163, $this->source); })()) && CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 163, $this->source); })()), "birthDate", [], "any", false, false, false, 163))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 163, $this->source); })()), "birthDate", [], "any", false, false, false, 163), "Y-m-d"), "html", null, true)) : (""));
        yield "\">
                        </label>
                        <label class=\"field\">
                            <span>Entry date</span>
                            <input class=\"input\" type=\"date\" name=\"entry_date\" value=\"";
        // line 167
        yield ((((isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 167, $this->source); })()) && CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 167, $this->source); })()), "entryDate", [], "any", false, false, false, 167))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 167, $this->source); })()), "entryDate", [], "any", false, false, false, 167), "Y-m-d"), "html", null, true)) : (""));
        yield "\">
                        </label>
                        <label class=\"field\">
                            <span>Origin</span>
                            <select class=\"input\" name=\"origin\" required>
                                <option value=\"\">Select origin</option>
                                ";
        // line 173
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["origins"]) || array_key_exists("origins", $context) ? $context["origins"] : (function () { throw new RuntimeError('Variable "origins" does not exist.', 173, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["origin"]) {
            // line 174
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["origin"], "html", null, true);
            yield "\" ";
            if (((isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 174, $this->source); })()) && (CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 174, $this->source); })()), "origin", [], "any", false, false, false, 174) == $context["origin"]))) {
                yield "selected";
            }
            yield ">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["origin"], "html", null, true);
            yield "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['origin'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 176
        yield "                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Location</span>
                            <select class=\"input\" name=\"location\" required>
                                <option value=\"\">Select location</option>
                                ";
        // line 182
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["locations"]) || array_key_exists("locations", $context) ? $context["locations"] : (function () { throw new RuntimeError('Variable "locations" does not exist.', 182, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["location"]) {
            // line 183
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["location"], "html", null, true);
            yield "\" ";
            if (((isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 183, $this->source); })()) && (CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 183, $this->source); })()), "location", [], "any", false, false, false, 183) == $context["location"]))) {
                yield "selected";
            }
            yield ">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["location"], "html", null, true);
            yield "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['location'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 185
        yield "                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Vaccinated</span>
                            <select class=\"input\" name=\"vaccinated\">
                                <option value=\"0\" ";
        // line 190
        if (( !(isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 190, $this->source); })()) ||  !CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 190, $this->source); })()), "vaccinated", [], "any", false, false, false, 190))) {
            yield "selected";
        }
        yield ">No</option>
                                <option value=\"1\" ";
        // line 191
        if (((isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 191, $this->source); })()) && CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 191, $this->source); })()), "vaccinated", [], "any", false, false, false, 191))) {
            yield "selected";
        }
        yield ">Yes</option>
                            </select>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\">";
        // line 196
        yield (((($tmp = (isset($context["editingAnimal"]) || array_key_exists("editingAnimal", $context) ? $context["editingAnimal"] : (function () { throw new RuntimeError('Variable "editingAnimal" does not exist.', 196, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Update") : ("Save"));
        yield "</button>
                        <a class=\"ghost\" href=\"";
        // line 197
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath((isset($context["pageRoute"]) || array_key_exists("pageRoute", $context) ? $context["pageRoute"] : (function () { throw new RuntimeError('Variable "pageRoute" does not exist.', 197, $this->source); })()), (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 197, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (["user_id" => (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 197, $this->source); })()), "animalId" => (isset($context["currentAnimalId"]) || array_key_exists("currentAnimalId", $context) ? $context["currentAnimalId"] : (function () { throw new RuntimeError('Variable "currentAnimalId" does not exist.', 197, $this->source); })())]) : (["animalId" => (isset($context["currentAnimalId"]) || array_key_exists("currentAnimalId", $context) ? $context["currentAnimalId"] : (function () { throw new RuntimeError('Variable "currentAnimalId" does not exist.', 197, $this->source); })())]))), "html", null, true);
        yield "\">Reset</a>
                    </div>
                </form>
            </div>

            <div class=\"crud-list\">
                <div class=\"list-head table-tools-row\">
                    <select class=\"input table-filter-column\" id=\"animal-search-column\">
                        <option value=\"all\">All columns</option>
                        <option value=\"0\">Ear Tag</option>
                        <option value=\"1\">Type</option>
                        <option value=\"2\">Weight</option>
                        <option value=\"3\">Health</option>
                        <option value=\"4\">Birth</option>
                        <option value=\"5\">Entry</option>
                        <option value=\"6\">Origin</option>
                        <option value=\"7\">Vaccinated</option>
                        <option value=\"8\">Location</option>
                    </select>
                    <input class=\"input\" id=\"animal-search\" type=\"search\" placeholder=\"Search animals\" autocomplete=\"off\">
                    <select class=\"input table-sort-column\" id=\"animal-sort-column\">
                        <option value=\"0\">Sort Ear Tag</option>
                        <option value=\"1\">Sort Type</option>
                        <option value=\"2\">Sort Weight</option>
                        <option value=\"3\">Sort Health</option>
                        <option value=\"4\">Sort Birth</option>
                        <option value=\"5\">Sort Entry</option>
                        <option value=\"6\">Sort Origin</option>
                        <option value=\"7\">Sort Vaccinated</option>
                        <option value=\"8\">Sort Location</option>
                    </select>
                    <select class=\"input table-sort-dir\" id=\"animal-sort-dir\">
                        <option value=\"asc\">Asc</option>
                        <option value=\"desc\">Desc</option>
                    </select>
                    <span class=\"pill\" id=\"animal-visible-pill\">";
        // line 232
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["animals"]) || array_key_exists("animals", $context) ? $context["animals"] : (function () { throw new RuntimeError('Variable "animals" does not exist.', 232, $this->source); })())), "html", null, true);
        yield " visible</span>
                </div>
                <div class=\"table-scroll\">
                    <table class=\"data-table\" id=\"animal-table\">
                        <thead>
                            <tr>
                                <th>Ear Tag</th>
                                <th>Type</th>
                                <th>Weight</th>
                                <th>Health</th>
                                <th>Birth</th>
                                <th>Entry</th>
                                <th>Origin</th>
                                <th>Vaccinated</th>
                                <th>Location</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id=\"animal-table-body\">
                            ";
        // line 251
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["animals"]) || array_key_exists("animals", $context) ? $context["animals"] : (function () { throw new RuntimeError('Variable "animals" does not exist.', 251, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["animal"]) {
            // line 252
            yield "                                <tr>
                                    <td data-sort=\"";
            // line 253
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "earTag", [], "any", false, false, false, 253), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "earTag", [], "any", false, false, false, 253), "html", null, true);
            yield "</td>
                                    <td data-sort=\"";
            // line 254
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "type", [], "any", false, false, false, 254)), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "type", [], "any", false, false, false, 254), "html", null, true);
            yield "</td>
                                    <td data-sort=\"";
            // line 255
            yield (((($tmp =  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "weight", [], "any", false, false, false, 255))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "weight", [], "any", false, false, false, 255), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape( -1, "html", null, true)));
            yield "\">";
            yield (((($tmp =  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "weight", [], "any", false, false, false, 255))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "weight", [], "any", false, false, false, 255) . " kg"), "html", null, true)) : ("-"));
            yield "</td>
                                    <td data-sort=\"";
            // line 256
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "healthStatus", [], "any", true, true, false, 256)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "healthStatus", [], "any", false, false, false, 256), "")) : (""))), "html", null, true);
            yield "\">";
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "healthStatus", [], "any", false, false, false, 256)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "healthStatus", [], "any", false, false, false, 256), "html", null, true)) : ("-"));
            yield "</td>
                                    <td data-sort=\"";
            // line 257
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "birthDate", [], "any", false, false, false, 257)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "birthDate", [], "any", false, false, false, 257), "Y-m-d"), "html", null, true)) : (""));
            yield "\">";
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "birthDate", [], "any", false, false, false, 257)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "birthDate", [], "any", false, false, false, 257), "Y-m-d"), "html", null, true)) : ("-"));
            yield "</td>
                                    <td data-sort=\"";
            // line 258
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "entryDate", [], "any", false, false, false, 258)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "entryDate", [], "any", false, false, false, 258), "Y-m-d"), "html", null, true)) : (""));
            yield "\">";
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "entryDate", [], "any", false, false, false, 258)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "entryDate", [], "any", false, false, false, 258), "Y-m-d"), "html", null, true)) : ("-"));
            yield "</td>
                                    <td data-sort=\"";
            // line 259
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "origin", [], "any", true, true, false, 259)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "origin", [], "any", false, false, false, 259), "")) : (""))), "html", null, true);
            yield "\">";
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "origin", [], "any", false, false, false, 259)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "origin", [], "any", false, false, false, 259), "html", null, true)) : ("-"));
            yield "</td>
                                    <td data-sort=\"";
            // line 260
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "vaccinated", [], "any", false, false, false, 260)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("1") : ("0"));
            yield "\">";
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "vaccinated", [], "any", false, false, false, 260)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Yes") : ("No"));
            yield "</td>
                                    <td data-sort=\"";
            // line 261
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "location", [], "any", true, true, false, 261)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "location", [], "any", false, false, false, 261), "")) : (""))), "html", null, true);
            yield "\">";
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "location", [], "any", false, false, false, 261)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "location", [], "any", false, false, false, 261), "html", null, true)) : ("-"));
            yield "</td>
                                    <td>
                                        <a class=\"link\" href=\"";
            // line 263
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath((isset($context["pageRoute"]) || array_key_exists("pageRoute", $context) ? $context["pageRoute"] : (function () { throw new RuntimeError('Variable "pageRoute" does not exist.', 263, $this->source); })()), Twig\Extension\CoreExtension::merge(["animalId" => CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "id", [], "any", false, false, false, 263), "editAnimalId" => CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "id", [], "any", false, false, false, 263)], (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 263, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (["user_id" => (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 263, $this->source); })())]) : ([])))), "html", null, true);
            yield "\">Edit</a>
                                        <form method=\"post\" action=\"";
            // line 264
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath((isset($context["animalDeleteRoute"]) || array_key_exists("animalDeleteRoute", $context) ? $context["animalDeleteRoute"] : (function () { throw new RuntimeError('Variable "animalDeleteRoute" does not exist.', 264, $this->source); })()), ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "id", [], "any", false, false, false, 264)]), "html", null, true);
            yield "\" style=\"display:inline;\">
                                            <input type=\"hidden\" name=\"animal_id\" value=\"";
            // line 265
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["currentAnimalId"]) || array_key_exists("currentAnimalId", $context) ? $context["currentAnimalId"] : (function () { throw new RuntimeError('Variable "currentAnimalId" does not exist.', 265, $this->source); })()), "html", null, true);
            yield "\">
                                            ";
            // line 266
            if ((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 266, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield "<input type=\"hidden\" name=\"user_id\" value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 266, $this->source); })()), "html", null, true);
                yield "\">";
            }
            // line 267
            yield "                                            <button class=\"link danger\" type=\"submit\">Delete</button>
                                        </form>
                                        <a class=\"link\" href=\"";
            // line 269
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath((isset($context["pageRoute"]) || array_key_exists("pageRoute", $context) ? $context["pageRoute"] : (function () { throw new RuntimeError('Variable "pageRoute" does not exist.', 269, $this->source); })()), Twig\Extension\CoreExtension::merge(["animalId" => CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "id", [], "any", false, false, false, 269)], (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 269, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (["user_id" => (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 269, $this->source); })())]) : ([])))), "html", null, true);
            yield "\">Records</a>
                                    </td>
                                </tr>
                            ";
            $context['_iterated'] = true;
        }
        // line 272
        if (!$context['_iterated']) {
            // line 273
            yield "                                <tr>
                                    <td colspan=\"10\">No animals found yet.</td>
                                </tr>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['animal'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 277
        yield "                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Health records</h2>
                <p>";
        // line 288
        if ((($tmp = (isset($context["selectedAnimal"]) || array_key_exists("selectedAnimal", $context) ? $context["selectedAnimal"] : (function () { throw new RuntimeError('Variable "selectedAnimal" does not exist.', 288, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "Records for ear tag ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["selectedAnimal"]) || array_key_exists("selectedAnimal", $context) ? $context["selectedAnimal"] : (function () { throw new RuntimeError('Variable "selectedAnimal" does not exist.', 288, $this->source); })()), "earTag", [], "any", false, false, false, 288), "html", null, true);
            yield " (";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["selectedAnimal"]) || array_key_exists("selectedAnimal", $context) ? $context["selectedAnimal"] : (function () { throw new RuntimeError('Variable "selectedAnimal" does not exist.', 288, $this->source); })()), "type", [], "any", false, false, false, 288), "html", null, true);
            yield ").";
        } else {
            yield "Select an animal to view its health history.";
        }
        yield "</p>
            </div>
            <div class=\"crud-actions\"><span class=\"pill\">";
        // line 290
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["recordCount"]) || array_key_exists("recordCount", $context) ? $context["recordCount"] : (function () { throw new RuntimeError('Variable "recordCount" does not exist.', 290, $this->source); })()), "html", null, true);
        yield " records</span></div>
        </div>

        <div class=\"crud-grid animals-entry-grid animals-entry-row\">
            <div class=\"crud-form\" id=\"record-form\">
                <h3>";
        // line 295
        yield (((($tmp = (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 295, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Edit record") : ("Create record"));
        yield "</h3>
                <form method=\"post\" action=\"";
        // line 296
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath((isset($context["recordSaveRoute"]) || array_key_exists("recordSaveRoute", $context) ? $context["recordSaveRoute"] : (function () { throw new RuntimeError('Variable "recordSaveRoute" does not exist.', 296, $this->source); })()));
        yield "\">
                    <input type=\"hidden\" name=\"id\" value=\"";
        // line 297
        yield (((($tmp = (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 297, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 297, $this->source); })()), "id", [], "any", false, false, false, 297), "html", null, true)) : (""));
        yield "\">
                    ";
        // line 298
        if ((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 298, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 299
            yield "                        <input type=\"hidden\" name=\"user_id\" value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 299, $this->source); })()), "html", null, true);
            yield "\">
                    ";
        }
        // line 301
        yield "                    <div class=\"form-grid animals-form-grid\">
                        <label class=\"field\">
                            <span>Animal</span>
                            <select class=\"input\" name=\"animal_id\" required>
                                <option value=\"\">Select animal</option>
                                ";
        // line 306
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["animals"]) || array_key_exists("animals", $context) ? $context["animals"] : (function () { throw new RuntimeError('Variable "animals" does not exist.', 306, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["animal"]) {
            // line 307
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "id", [], "any", false, false, false, 307), "html", null, true);
            yield "\" ";
            if ((((isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 307, $this->source); })()) && (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 307, $this->source); })()), "animal", [], "any", false, false, false, 307), "id", [], "any", false, false, false, 307) == CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "id", [], "any", false, false, false, 307))) || (( !(isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 307, $this->source); })()) && (isset($context["selectedAnimal"]) || array_key_exists("selectedAnimal", $context) ? $context["selectedAnimal"] : (function () { throw new RuntimeError('Variable "selectedAnimal" does not exist.', 307, $this->source); })())) && (CoreExtension::getAttribute($this->env, $this->source, (isset($context["selectedAnimal"]) || array_key_exists("selectedAnimal", $context) ? $context["selectedAnimal"] : (function () { throw new RuntimeError('Variable "selectedAnimal" does not exist.', 307, $this->source); })()), "id", [], "any", false, false, false, 307) == CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "id", [], "any", false, false, false, 307))))) {
                yield "selected";
            }
            yield ">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "earTag", [], "any", false, false, false, 307), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["animal"], "type", [], "any", false, false, false, 307), "html", null, true);
            yield "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['animal'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 309
        yield "                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Record date</span>
                            <input class=\"input\" type=\"date\" name=\"record_date\" value=\"";
        // line 313
        yield ((((isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 313, $this->source); })()) && CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 313, $this->source); })()), "recordDate", [], "any", false, false, false, 313))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 313, $this->source); })()), "recordDate", [], "any", false, false, false, 313), "Y-m-d"), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y-m-d"), "html", null, true)));
        yield "\" required>
                        </label>
                        <label class=\"field\">
                            <span>Weight</span>
                            <input class=\"input\" type=\"text\" name=\"weight\" value=\"";
        // line 317
        yield ((((isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 317, $this->source); })()) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 317, $this->source); })()), "weight", [], "any", false, false, false, 317)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 317, $this->source); })()), "weight", [], "any", false, false, false, 317), "html", null, true)) : (""));
        yield "\" placeholder=\"0.0\">
                        </label>
                        <label class=\"field\">
                            <span>Appetite</span>
                            <select class=\"input\" name=\"appetite\">
                                <option value=\"\">Select appetite</option>
                                ";
        // line 323
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["appetites"]) || array_key_exists("appetites", $context) ? $context["appetites"] : (function () { throw new RuntimeError('Variable "appetites" does not exist.', 323, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["appetite"]) {
            // line 324
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["appetite"], "html", null, true);
            yield "\" ";
            if (((isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 324, $this->source); })()) && (CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 324, $this->source); })()), "appetite", [], "any", false, false, false, 324) == $context["appetite"]))) {
                yield "selected";
            }
            yield ">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["appetite"], "html", null, true);
            yield "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['appetite'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 326
        yield "                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Condition</span>
                            <select class=\"input\" name=\"condition_status\" required>
                                <option value=\"\">Select condition</option>
                                ";
        // line 332
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["conditions"]) || array_key_exists("conditions", $context) ? $context["conditions"] : (function () { throw new RuntimeError('Variable "conditions" does not exist.', 332, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["condition"]) {
            // line 333
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["condition"], "html", null, true);
            yield "\" ";
            if (((isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 333, $this->source); })()) && (CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 333, $this->source); })()), "conditionStatus", [], "any", false, false, false, 333) == $context["condition"]))) {
                yield "selected";
            }
            yield ">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["condition"], "html", null, true);
            yield "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['condition'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 335
        yield "                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Production</span>
                            <input class=\"input\" type=\"text\" name=\"production\" value=\"";
        // line 339
        yield (((($tmp = (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 339, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ((((CoreExtension::getAttribute($this->env, $this->source, ($context["editingRecord"] ?? null), "milkYield", [], "any", true, true, false, 339) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 339, $this->source); })()), "milkYield", [], "any", false, false, false, 339)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 339, $this->source); })()), "milkYield", [], "any", false, false, false, 339), "html", null, true)) : ((((CoreExtension::getAttribute($this->env, $this->source, ($context["editingRecord"] ?? null), "eggCount", [], "any", true, true, false, 339) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 339, $this->source); })()), "eggCount", [], "any", false, false, false, 339)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 339, $this->source); })()), "eggCount", [], "any", false, false, false, 339), "html", null, true)) : ((((CoreExtension::getAttribute($this->env, $this->source, ($context["editingRecord"] ?? null), "woolLength", [], "any", true, true, false, 339) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 339, $this->source); })()), "woolLength", [], "any", false, false, false, 339)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 339, $this->source); })()), "woolLength", [], "any", false, false, false, 339), "html", null, true)) : (""))))))) : (""));
        yield "\" placeholder=\"0\">
                        </label>
                        <label class=\"field\" style=\"grid-column: 1 / -1;\">
                            <span>Notes</span>
                            <textarea class=\"input\" name=\"notes\" rows=\"4\" placeholder=\"Optional notes\">";
        // line 343
        yield (((($tmp = (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 343, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 343, $this->source); })()), "notes", [], "any", false, false, false, 343), "html", null, true)) : (""));
        yield "</textarea>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\">";
        // line 347
        yield (((($tmp = (isset($context["editingRecord"]) || array_key_exists("editingRecord", $context) ? $context["editingRecord"] : (function () { throw new RuntimeError('Variable "editingRecord" does not exist.', 347, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Update") : ("Save"));
        yield "</button>
                        <a class=\"ghost\" href=\"";
        // line 348
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath((isset($context["pageRoute"]) || array_key_exists("pageRoute", $context) ? $context["pageRoute"] : (function () { throw new RuntimeError('Variable "pageRoute" does not exist.', 348, $this->source); })()), (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 348, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (["user_id" => (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 348, $this->source); })()), "animalId" => (isset($context["currentAnimalId"]) || array_key_exists("currentAnimalId", $context) ? $context["currentAnimalId"] : (function () { throw new RuntimeError('Variable "currentAnimalId" does not exist.', 348, $this->source); })())]) : (["animalId" => (isset($context["currentAnimalId"]) || array_key_exists("currentAnimalId", $context) ? $context["currentAnimalId"] : (function () { throw new RuntimeError('Variable "currentAnimalId" does not exist.', 348, $this->source); })())]))), "html", null, true);
        yield "\">Reset</a>
                    </div>
                </form>
            </div>

            <div class=\"crud-list\">
                <div class=\"list-head table-tools-row\">
                    <select class=\"input table-filter-column\" id=\"record-search-column\">
                        <option value=\"all\">All columns</option>
                        <option value=\"0\">Animal</option>
                        <option value=\"1\">Date</option>
                        <option value=\"2\">Weight</option>
                        <option value=\"3\">Appetite</option>
                        <option value=\"4\">Condition</option>
                        <option value=\"5\">Production</option>
                        <option value=\"6\">Notes</option>
                    </select>
                    <input class=\"input\" id=\"record-search\" type=\"search\" placeholder=\"Search records\" autocomplete=\"off\">
                    <select class=\"input table-sort-column\" id=\"record-sort-column\">
                        <option value=\"0\">Sort Animal</option>
                        <option value=\"1\">Sort Date</option>
                        <option value=\"2\">Sort Weight</option>
                        <option value=\"3\">Sort Appetite</option>
                        <option value=\"4\">Sort Condition</option>
                        <option value=\"5\">Sort Production</option>
                        <option value=\"6\">Sort Notes</option>
                    </select>
                    <select class=\"input table-sort-dir\" id=\"record-sort-dir\">
                        <option value=\"asc\">Asc</option>
                        <option value=\"desc\">Desc</option>
                    </select>
                    <span class=\"pill\" id=\"record-visible-pill\">";
        // line 379
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["records"]) || array_key_exists("records", $context) ? $context["records"] : (function () { throw new RuntimeError('Variable "records" does not exist.', 379, $this->source); })())), "html", null, true);
        yield " visible</span>
                </div>
                <div class=\"table-scroll\">
                    <table class=\"data-table\" id=\"record-table\">
                        <thead>
                            <tr>
                                <th>Animal</th>
                                <th>Date</th>
                                <th>Weight</th>
                                <th>Appetite</th>
                                <th>Condition</th>
                                <th>Production</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id=\"record-table-body\">
                            ";
        // line 396
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["records"]) || array_key_exists("records", $context) ? $context["records"] : (function () { throw new RuntimeError('Variable "records" does not exist.', 396, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["record"]) {
            // line 397
            yield "                                ";
            $context["productionValue"] = (((($tmp =  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["record"], "milkYield", [], "any", false, false, false, 397))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, $context["record"], "milkYield", [], "any", false, false, false, 397)) : ((((($tmp =  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["record"], "eggCount", [], "any", false, false, false, 397))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, $context["record"], "eggCount", [], "any", false, false, false, 397)) : ((((($tmp =  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["record"], "woolLength", [], "any", false, false, false, 397))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, $context["record"], "woolLength", [], "any", false, false, false, 397)) : (null))))));
            // line 398
            yield "                                <tr>
                                    <td data-sort=\"";
            // line 399
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["record"], "animal", [], "any", false, false, false, 399), "earTag", [], "any", false, false, false, 399), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["record"], "animal", [], "any", false, false, false, 399), "earTag", [], "any", false, false, false, 399), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["record"], "animal", [], "any", false, false, false, 399), "type", [], "any", false, false, false, 399), "html", null, true);
            yield "</td>
                                    <td data-sort=\"";
            // line 400
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["record"], "recordDate", [], "any", false, false, false, 400)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["record"], "recordDate", [], "any", false, false, false, 400), "Y-m-d"), "html", null, true)) : (""));
            yield "\">";
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["record"], "recordDate", [], "any", false, false, false, 400)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["record"], "recordDate", [], "any", false, false, false, 400), "Y-m-d"), "html", null, true)) : ("-"));
            yield "</td>
                                    <td data-sort=\"";
            // line 401
            yield (((($tmp =  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["record"], "weight", [], "any", false, false, false, 401))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["record"], "weight", [], "any", false, false, false, 401), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape( -1, "html", null, true)));
            yield "\">";
            yield (((($tmp =  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["record"], "weight", [], "any", false, false, false, 401))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, $context["record"], "weight", [], "any", false, false, false, 401) . " kg"), "html", null, true)) : ("-"));
            yield "</td>
                                    <td data-sort=\"";
            // line 402
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["record"], "appetite", [], "any", true, true, false, 402)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["record"], "appetite", [], "any", false, false, false, 402), "")) : (""))), "html", null, true);
            yield "\">";
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["record"], "appetite", [], "any", false, false, false, 402)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["record"], "appetite", [], "any", false, false, false, 402), "html", null, true)) : ("-"));
            yield "</td>
                                    <td data-sort=\"";
            // line 403
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["record"], "conditionStatus", [], "any", true, true, false, 403)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["record"], "conditionStatus", [], "any", false, false, false, 403), "")) : (""))), "html", null, true);
            yield "\">";
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["record"], "conditionStatus", [], "any", false, false, false, 403)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["record"], "conditionStatus", [], "any", false, false, false, 403), "html", null, true)) : ("-"));
            yield "</td>
                                    <td data-sort=\"";
            // line 404
            yield (((($tmp =  !(null === (isset($context["productionValue"]) || array_key_exists("productionValue", $context) ? $context["productionValue"] : (function () { throw new RuntimeError('Variable "productionValue" does not exist.', 404, $this->source); })()))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["productionValue"]) || array_key_exists("productionValue", $context) ? $context["productionValue"] : (function () { throw new RuntimeError('Variable "productionValue" does not exist.', 404, $this->source); })()), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape( -1, "html", null, true)));
            yield "\">";
            yield (((($tmp =  !(null === (isset($context["productionValue"]) || array_key_exists("productionValue", $context) ? $context["productionValue"] : (function () { throw new RuntimeError('Variable "productionValue" does not exist.', 404, $this->source); })()))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["productionValue"]) || array_key_exists("productionValue", $context) ? $context["productionValue"] : (function () { throw new RuntimeError('Variable "productionValue" does not exist.', 404, $this->source); })()), "html", null, true)) : ("-"));
            yield "</td>
                                    <td data-sort=\"";
            // line 405
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["record"], "notes", [], "any", true, true, false, 405)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["record"], "notes", [], "any", false, false, false, 405), "")) : (""))), "html", null, true);
            yield "\">";
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["record"], "notes", [], "any", false, false, false, 405)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["record"], "notes", [], "any", false, false, false, 405), "html", null, true)) : ("-"));
            yield "</td>
                                    <td>
                                        <a class=\"link\" href=\"";
            // line 407
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath((isset($context["pageRoute"]) || array_key_exists("pageRoute", $context) ? $context["pageRoute"] : (function () { throw new RuntimeError('Variable "pageRoute" does not exist.', 407, $this->source); })()), Twig\Extension\CoreExtension::merge(["animalId" => (isset($context["currentAnimalId"]) || array_key_exists("currentAnimalId", $context) ? $context["currentAnimalId"] : (function () { throw new RuntimeError('Variable "currentAnimalId" does not exist.', 407, $this->source); })()), "editRecordId" => CoreExtension::getAttribute($this->env, $this->source, $context["record"], "id", [], "any", false, false, false, 407)], (((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 407, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (["user_id" => (isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 407, $this->source); })())]) : ([])))), "html", null, true);
            yield "\">Edit</a>
                                        <form method=\"post\" action=\"";
            // line 408
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath((isset($context["recordDeleteRoute"]) || array_key_exists("recordDeleteRoute", $context) ? $context["recordDeleteRoute"] : (function () { throw new RuntimeError('Variable "recordDeleteRoute" does not exist.', 408, $this->source); })()), ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["record"], "id", [], "any", false, false, false, 408)]), "html", null, true);
            yield "\" style=\"display:inline;\">
                                            <input type=\"hidden\" name=\"animal_id\" value=\"";
            // line 409
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["currentAnimalId"]) || array_key_exists("currentAnimalId", $context) ? $context["currentAnimalId"] : (function () { throw new RuntimeError('Variable "currentAnimalId" does not exist.', 409, $this->source); })()), "html", null, true);
            yield "\">
                                            ";
            // line 410
            if ((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 410, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield "<input type=\"hidden\" name=\"user_id\" value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 410, $this->source); })()), "html", null, true);
                yield "\">";
            }
            // line 411
            yield "                                            <button class=\"link danger\" type=\"submit\">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            ";
            $context['_iterated'] = true;
        }
        // line 415
        if (!$context['_iterated']) {
            // line 416
            yield "                                <tr>
                                    <td colspan=\"8\">No health records yet.</td>
                                </tr>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['record'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 420
        yield "                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    ";
        // line 427
        if ((($tmp = (isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 427, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 428
            yield "        <div class=\"crud-card\">
            <div class=\"crud-head\">
                <div>
                    <h2>Options</h2>
                    <p>Manage shared type and location lists used by animal forms.</p>
                </div>
            </div>
            <div class=\"crud-grid\">
                <div class=\"crud-list\">
                    <div class=\"crud-head\" style=\"margin-bottom: 12px;\">
                        <div>
                            <h2>Animal types</h2>
                            <p>Values are stored in lowercase for consistency.</p>
                        </div>
                    </div>
                    <ul style=\"list-style:none; display:grid; gap:10px; margin-bottom:16px;\">
                        ";
            // line 444
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["types"]) || array_key_exists("types", $context) ? $context["types"] : (function () { throw new RuntimeError('Variable "types" does not exist.', 444, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["type"]) {
                // line 445
                yield "                            <li style=\"display:flex; justify-content:space-between; gap:12px; align-items:center;\">
                                <span>";
                // line 446
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["type"], "html", null, true);
                yield "</span>
                                <form method=\"post\" action=\"";
                // line 447
                yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath((isset($context["typeDeleteRoute"]) || array_key_exists("typeDeleteRoute", $context) ? $context["typeDeleteRoute"] : (function () { throw new RuntimeError('Variable "typeDeleteRoute" does not exist.', 447, $this->source); })()));
                yield "\">
                                    <input type=\"hidden\" name=\"user_id\" value=\"";
                // line 448
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 448, $this->source); })()), "html", null, true);
                yield "\">
                                    <input type=\"hidden\" name=\"value\" value=\"";
                // line 449
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["type"], "html", null, true);
                yield "\">
                                    <button class=\"link danger\" type=\"submit\">Delete</button>
                                </form>
                            </li>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['type'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 454
            yield "                    </ul>
                    <form method=\"post\" action=\"";
            // line 455
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath((isset($context["typeAddRoute"]) || array_key_exists("typeAddRoute", $context) ? $context["typeAddRoute"] : (function () { throw new RuntimeError('Variable "typeAddRoute" does not exist.', 455, $this->source); })()));
            yield "\" class=\"form-grid\">
                        <input type=\"hidden\" name=\"user_id\" value=\"";
            // line 456
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 456, $this->source); })()), "html", null, true);
            yield "\">
                        <label class=\"field\" style=\"grid-column: 1 / -1;\">
                            <span>New type</span>
                            <input class=\"input\" name=\"value\" placeholder=\"cow, goat, chicken...\">
                        </label>
                        <button class=\"primary\" type=\"submit\">Add type</button>
                    </form>
                </div>
                <div class=\"crud-list\">
                    <div class=\"crud-head\" style=\"margin-bottom: 12px;\">
                        <div>
                            <h2>Animal locations</h2>
                            <p>Simple reusable location values.</p>
                        </div>
                    </div>
                    <ul style=\"list-style:none; display:grid; gap:10px; margin-bottom:16px;\">
                        ";
            // line 472
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["locations"]) || array_key_exists("locations", $context) ? $context["locations"] : (function () { throw new RuntimeError('Variable "locations" does not exist.', 472, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["location"]) {
                // line 473
                yield "                            <li style=\"display:flex; justify-content:space-between; gap:12px; align-items:center;\">
                                <span>";
                // line 474
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["location"], "html", null, true);
                yield "</span>
                                <form method=\"post\" action=\"";
                // line 475
                yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath((isset($context["locationDeleteRoute"]) || array_key_exists("locationDeleteRoute", $context) ? $context["locationDeleteRoute"] : (function () { throw new RuntimeError('Variable "locationDeleteRoute" does not exist.', 475, $this->source); })()));
                yield "\">
                                    <input type=\"hidden\" name=\"user_id\" value=\"";
                // line 476
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 476, $this->source); })()), "html", null, true);
                yield "\">
                                    <input type=\"hidden\" name=\"value\" value=\"";
                // line 477
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["location"], "html", null, true);
                yield "\">
                                    <button class=\"link danger\" type=\"submit\">Delete</button>
                                </form>
                            </li>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['location'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 482
            yield "                    </ul>
                    <form method=\"post\" action=\"";
            // line 483
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath((isset($context["locationAddRoute"]) || array_key_exists("locationAddRoute", $context) ? $context["locationAddRoute"] : (function () { throw new RuntimeError('Variable "locationAddRoute" does not exist.', 483, $this->source); })()));
            yield "\" class=\"form-grid\">
                        <input type=\"hidden\" name=\"user_id\" value=\"";
            // line 484
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["selectedUserId"]) || array_key_exists("selectedUserId", $context) ? $context["selectedUserId"] : (function () { throw new RuntimeError('Variable "selectedUserId" does not exist.', 484, $this->source); })()), "html", null, true);
            yield "\">
                        <label class=\"field\" style=\"grid-column: 1 / -1;\">
                            <span>New location</span>
                            <input class=\"input\" name=\"value\" placeholder=\"barn, coop, pasture...\">
                        </label>
                        <button class=\"primary\" type=\"submit\">Add location</button>
                    </form>
                </div>
            </div>
        </div>
    ";
        }
        // line 495
        yield "</section>

<script>
(() => {
    function initInteractiveTable(config) {
        const table = document.getElementById(config.tableId);
        const body = document.getElementById(config.bodyId);
        const searchInput = document.getElementById(config.searchInputId);
        const searchColumn = document.getElementById(config.searchColumnId);
        const sortColumn = document.getElementById(config.sortColumnId);
        const sortDir = document.getElementById(config.sortDirId);
        const visiblePill = document.getElementById(config.visiblePillId);

        if (!table || !body || !searchInput || !searchColumn || !sortColumn || !sortDir || !visiblePill) {
            return;
        }

        const baseRows = Array.from(body.querySelectorAll('tr')).filter((row) => row.querySelectorAll('td').length > 0);

        function rowCellValue(row, index) {
            const cell = row.querySelectorAll('td')[index];
            if (!cell) {
                return '';
            }
            return String(cell.dataset.sort || cell.textContent || '').trim();
        }

        function compareValues(a, b) {
            const na = Number(a);
            const nb = Number(b);
            if (!Number.isNaN(na) && !Number.isNaN(nb)) {
                return na - nb;
            }
            return a.localeCompare(b, undefined, { sensitivity: 'base' });
        }

        function updateTable() {
            const query = searchInput.value.trim().toLowerCase();
            const selectedColumn = searchColumn.value;
            const sortIndex = Number(sortColumn.value);
            const direction = sortDir.value === 'desc' ? -1 : 1;

            const filtered = baseRows.filter((row) => {
                if (query === '') {
                    return true;
                }

                if (selectedColumn === 'all') {
                    return row.textContent.toLowerCase().includes(query);
                }

                const value = rowCellValue(row, Number(selectedColumn)).toLowerCase();
                return value.includes(query);
            });

            filtered.sort((leftRow, rightRow) => {
                const leftValue = rowCellValue(leftRow, sortIndex);
                const rightValue = rowCellValue(rightRow, sortIndex);
                return compareValues(leftValue, rightValue) * direction;
            });

            baseRows.forEach((row) => {
                row.style.display = 'none';
            });

            filtered.forEach((row) => {
                row.style.display = '';
                body.appendChild(row);
            });

            visiblePill.textContent = `\${filtered.length} visible`;
        }

        [searchInput, searchColumn, sortColumn, sortDir].forEach((el) => {
            el.addEventListener('input', updateTable);
            el.addEventListener('change', updateTable);
        });

        updateTable();
    }

    initInteractiveTable({
        tableId: 'animal-table',
        bodyId: 'animal-table-body',
        searchInputId: 'animal-search',
        searchColumnId: 'animal-search-column',
        sortColumnId: 'animal-sort-column',
        sortDirId: 'animal-sort-dir',
        visiblePillId: 'animal-visible-pill',
    });

    initInteractiveTable({
        tableId: 'record-table',
        bodyId: 'record-table-body',
        searchInputId: 'record-search',
        searchColumnId: 'record-search-column',
        sortColumnId: 'record-sort-column',
        sortDirId: 'record-sort-dir',
        visiblePillId: 'record-visible-pill',
    });
})();
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
        return "management/animals.html.twig";
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
        return array (  1215 => 495,  1201 => 484,  1197 => 483,  1194 => 482,  1183 => 477,  1179 => 476,  1175 => 475,  1171 => 474,  1168 => 473,  1164 => 472,  1145 => 456,  1141 => 455,  1138 => 454,  1127 => 449,  1123 => 448,  1119 => 447,  1115 => 446,  1112 => 445,  1108 => 444,  1090 => 428,  1088 => 427,  1079 => 420,  1070 => 416,  1068 => 415,  1060 => 411,  1054 => 410,  1050 => 409,  1046 => 408,  1042 => 407,  1035 => 405,  1029 => 404,  1023 => 403,  1017 => 402,  1011 => 401,  1005 => 400,  997 => 399,  994 => 398,  991 => 397,  986 => 396,  966 => 379,  932 => 348,  928 => 347,  921 => 343,  914 => 339,  908 => 335,  893 => 333,  889 => 332,  881 => 326,  866 => 324,  862 => 323,  853 => 317,  846 => 313,  840 => 309,  823 => 307,  819 => 306,  812 => 301,  806 => 299,  804 => 298,  800 => 297,  796 => 296,  792 => 295,  784 => 290,  771 => 288,  758 => 277,  749 => 273,  747 => 272,  739 => 269,  735 => 267,  729 => 266,  725 => 265,  721 => 264,  717 => 263,  710 => 261,  704 => 260,  698 => 259,  692 => 258,  686 => 257,  680 => 256,  674 => 255,  668 => 254,  662 => 253,  659 => 252,  654 => 251,  632 => 232,  594 => 197,  590 => 196,  580 => 191,  574 => 190,  567 => 185,  552 => 183,  548 => 182,  540 => 176,  525 => 174,  521 => 173,  512 => 167,  505 => 163,  498 => 159,  492 => 155,  477 => 153,  473 => 152,  464 => 146,  459 => 143,  453 => 141,  451 => 140,  447 => 139,  443 => 138,  439 => 137,  435 => 136,  426 => 130,  420 => 127,  409 => 118,  402 => 116,  400 => 115,  391 => 113,  383 => 112,  380 => 111,  375 => 110,  366 => 103,  359 => 101,  357 => 100,  348 => 98,  340 => 97,  337 => 96,  332 => 95,  319 => 85,  311 => 80,  303 => 75,  295 => 70,  282 => 59,  276 => 58,  265 => 56,  260 => 55,  255 => 54,  246 => 52,  241 => 51,  232 => 49,  228 => 48,  225 => 47,  217 => 42,  213 => 40,  204 => 38,  202 => 37,  191 => 35,  182 => 34,  177 => 33,  164 => 22,  162 => 21,  158 => 19,  156 => 18,  154 => 17,  152 => 16,  150 => 15,  148 => 14,  146 => 13,  144 => 12,  142 => 11,  140 => 10,  138 => 9,  128 => 8,  111 => 6,  94 => 5,  77 => 4,  60 => 3,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends adminMode|default(false) ? 'admin/layout.html.twig' : 'management/layout.html.twig' %}

{% block title %}Animals Management{% endblock %}
{% block eyebrow %}Animals Management{% endblock %}
{% block heading %}Animal management{% endblock %}
{% block subhead %}Track animals, health records, and shared option lists with sortable, searchable tables.{% endblock %}

{% block body %}
{% set pageRoute = adminMode ? 'admin_management_animals' : 'management_animals' %}
{% set animalSaveRoute = adminMode ? 'admin_management_animals_save' : 'management_animals_save' %}
{% set animalDeleteRoute = adminMode ? 'admin_management_animals_delete' : 'management_animals_delete' %}
{% set recordSaveRoute = adminMode ? 'admin_management_animal_record_save' : 'management_animal_record_save' %}
{% set recordDeleteRoute = adminMode ? 'admin_management_animal_record_delete' : 'management_animal_record_delete' %}
{% set typeAddRoute = 'admin_management_animal_type_add' %}
{% set typeDeleteRoute = 'admin_management_animal_type_delete' %}
{% set locationAddRoute = 'admin_management_animal_location_add' %}
{% set locationDeleteRoute = 'admin_management_animal_location_delete' %}
{% set currentAnimalId = selectedAnimal ? selectedAnimal.id : 0 %}

<section class=\"crud-section animals-page\">
    {% if adminMode %}
        <div class=\"crud-card\">
            <div class=\"crud-head\">
                <div>
                    <h2>Owner selector</h2>
                    <p>Choose the user whose animals you want to manage.</p>
                </div>
            </div>
            <form method=\"get\" class=\"form-grid\" style=\"grid-template-columns: minmax(0, 1fr) auto; align-items:end;\">
                <label class=\"field\" style=\"grid-column: 1 / -1;\">
                    <span>User</span>
                    <select class=\"input\" name=\"user_id\">
                        {% for user in availableUsers %}
                            <option value=\"{{ user.id }}\" {% if user.id == selectedUserId %}selected{% endif %}>
                                {{ user.firstName }} {{ user.lastName }} - {{ user.email }}
                            </option>
                        {% else %}
                            <option value=\"{{ selectedUserId }}\">Current admin</option>
                        {% endfor %}
                    </select>
                </label>
                <input type=\"hidden\" name=\"animalId\" value=\"{{ currentAnimalId }}\">
                <button class=\"primary\" type=\"submit\">Switch user</button>
            </form>
        </div>
    {% endif %}

    {% for message in app.flashes('success') %}
        <div class=\"flash flash-success\">{{ message }}</div>
    {% endfor %}
    {% for message in app.flashes('error') %}
        <div class=\"flash flash-error\">{{ message }}</div>
    {% endfor %}
    {% for errors in app.flashes('errors') %}
        {% for key, message in errors %}
            <div class=\"flash flash-error\">{{ key }}: {{ message }}</div>
        {% endfor %}
    {% endfor %}

    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Animal insights</h2>
                <p>Operational stats and quick distributions for this management scope.</p>
            </div>
        </div>
        <div class=\"ops-kpi-grid\">
            <article class=\"ops-kpi\">
                <span class=\"k\">Animals</span>
                <strong>{{ animalInsights.stats.animalCount }}</strong>
                <small>Total rows in animals table.</small>
            </article>
            <article class=\"ops-kpi\">
                <span class=\"k\">Health Records</span>
                <strong>{{ animalInsights.stats.recordCount }}</strong>
                <small>Total rows in health records table.</small>
            </article>
            <article class=\"ops-kpi\">
                <span class=\"k\">Vaccinated</span>
                <strong>{{ animalInsights.stats.vaccinatedCount }}</strong>
                <small>Animals currently marked vaccinated.</small>
            </article>
            <article class=\"ops-kpi\">
                <span class=\"k\">Critical Cases</span>
                <strong>{{ animalInsights.stats.criticalCount }}</strong>
                <small>Records with CRITICAL condition.</small>
            </article>
        </div>
        <div class=\"ops-grid\" style=\"margin-top:18px;\">
            <article class=\"ops-panel\">
                <header>
                    <h3>Animal Type Mix</h3>
                </header>
                <ul class=\"ops-bar-list\">
                    {% for row in animalInsights.animalTypeLegend %}
                        <li>
                            <div class=\"meta\"><span>{{ row.label }}</span><strong>{{ row.value }} ({{ row.percent }}%)</strong></div>
                            <div class=\"track\"><span style=\"width: {{ row.percent }}%; background: {{ row.color }};\"></span></div>
                        </li>
                    {% else %}
                        <li class=\"ops-empty\">No animal data available yet.</li>
                    {% endfor %}
                </ul>
            </article>
            <article class=\"ops-panel\">
                <header>
                    <h3>Condition Mix</h3>
                </header>
                <ul class=\"ops-bar-list\">
                    {% for row in animalInsights.conditionLegend %}
                        <li>
                            <div class=\"meta\"><span>{{ row.label }}</span><strong>{{ row.value }} ({{ row.percent }}%)</strong></div>
                            <div class=\"track\"><span style=\"width: {{ row.percent }}%; background: {{ row.color }};\"></span></div>
                        </li>
                    {% else %}
                        <li class=\"ops-empty\">No health record data available yet.</li>
                    {% endfor %}
                </ul>
            </article>
        </div>
    </div>

    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Animals</h2>
                <p>{{ adminMode ? 'Manage the selected user\\'s herd.' : 'Manage your animals and keep profile values in sync.' }}</p>
            </div>
            <div class=\"crud-actions\">
                <span class=\"pill\">{{ animalCount }} records</span>
            </div>
        </div>

        <div class=\"crud-grid animals-entry-grid animals-entry-row\">
            <div class=\"crud-form\" id=\"animal-form\">
                <h3>{{ editingAnimal ? 'Edit animal' : 'Create animal' }}</h3>
                <form method=\"post\" action=\"{{ path(animalSaveRoute) }}\">
                    <input type=\"hidden\" name=\"id\" value=\"{{ editingAnimal ? editingAnimal.id : '' }}\">
                    <input type=\"hidden\" name=\"animal_id\" value=\"{{ currentAnimalId }}\">
                    {% if adminMode %}
                        <input type=\"hidden\" name=\"user_id\" value=\"{{ selectedUserId }}\">
                    {% endif %}
                    <div class=\"form-grid animals-form-grid\">
                        <label class=\"field\">
                            <span>Ear tag</span>
                            <input class=\"input\" type=\"number\" name=\"ear_tag\" value=\"{{ editingAnimal ? editingAnimal.earTag : '' }}\" required>
                        </label>
                        <label class=\"field\">
                            <span>Type</span>
                            <select class=\"input\" name=\"type\" required>
                                <option value=\"\">Select type</option>
                                {% for type in types %}
                                    <option value=\"{{ type }}\" {% if editingAnimal and editingAnimal.type == type %}selected{% endif %}>{{ type }}</option>
                                {% endfor %}
                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Weight</span>
                            <input class=\"input\" type=\"text\" name=\"weight\" value=\"{{ editingAnimal and editingAnimal.weight is not null ? editingAnimal.weight : '' }}\" placeholder=\"0.0\">
                        </label>
                        <label class=\"field\">
                            <span>Birth date</span>
                            <input class=\"input\" type=\"date\" name=\"birth_date\" value=\"{{ editingAnimal and editingAnimal.birthDate ? editingAnimal.birthDate|date('Y-m-d') : '' }}\">
                        </label>
                        <label class=\"field\">
                            <span>Entry date</span>
                            <input class=\"input\" type=\"date\" name=\"entry_date\" value=\"{{ editingAnimal and editingAnimal.entryDate ? editingAnimal.entryDate|date('Y-m-d') : '' }}\">
                        </label>
                        <label class=\"field\">
                            <span>Origin</span>
                            <select class=\"input\" name=\"origin\" required>
                                <option value=\"\">Select origin</option>
                                {% for origin in origins %}
                                    <option value=\"{{ origin }}\" {% if editingAnimal and editingAnimal.origin == origin %}selected{% endif %}>{{ origin }}</option>
                                {% endfor %}
                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Location</span>
                            <select class=\"input\" name=\"location\" required>
                                <option value=\"\">Select location</option>
                                {% for location in locations %}
                                    <option value=\"{{ location }}\" {% if editingAnimal and editingAnimal.location == location %}selected{% endif %}>{{ location }}</option>
                                {% endfor %}
                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Vaccinated</span>
                            <select class=\"input\" name=\"vaccinated\">
                                <option value=\"0\" {% if not editingAnimal or not editingAnimal.vaccinated %}selected{% endif %}>No</option>
                                <option value=\"1\" {% if editingAnimal and editingAnimal.vaccinated %}selected{% endif %}>Yes</option>
                            </select>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\">{{ editingAnimal ? 'Update' : 'Save' }}</button>
                        <a class=\"ghost\" href=\"{{ path(pageRoute, adminMode ? {user_id: selectedUserId, animalId: currentAnimalId} : {animalId: currentAnimalId}) }}\">Reset</a>
                    </div>
                </form>
            </div>

            <div class=\"crud-list\">
                <div class=\"list-head table-tools-row\">
                    <select class=\"input table-filter-column\" id=\"animal-search-column\">
                        <option value=\"all\">All columns</option>
                        <option value=\"0\">Ear Tag</option>
                        <option value=\"1\">Type</option>
                        <option value=\"2\">Weight</option>
                        <option value=\"3\">Health</option>
                        <option value=\"4\">Birth</option>
                        <option value=\"5\">Entry</option>
                        <option value=\"6\">Origin</option>
                        <option value=\"7\">Vaccinated</option>
                        <option value=\"8\">Location</option>
                    </select>
                    <input class=\"input\" id=\"animal-search\" type=\"search\" placeholder=\"Search animals\" autocomplete=\"off\">
                    <select class=\"input table-sort-column\" id=\"animal-sort-column\">
                        <option value=\"0\">Sort Ear Tag</option>
                        <option value=\"1\">Sort Type</option>
                        <option value=\"2\">Sort Weight</option>
                        <option value=\"3\">Sort Health</option>
                        <option value=\"4\">Sort Birth</option>
                        <option value=\"5\">Sort Entry</option>
                        <option value=\"6\">Sort Origin</option>
                        <option value=\"7\">Sort Vaccinated</option>
                        <option value=\"8\">Sort Location</option>
                    </select>
                    <select class=\"input table-sort-dir\" id=\"animal-sort-dir\">
                        <option value=\"asc\">Asc</option>
                        <option value=\"desc\">Desc</option>
                    </select>
                    <span class=\"pill\" id=\"animal-visible-pill\">{{ animals|length }} visible</span>
                </div>
                <div class=\"table-scroll\">
                    <table class=\"data-table\" id=\"animal-table\">
                        <thead>
                            <tr>
                                <th>Ear Tag</th>
                                <th>Type</th>
                                <th>Weight</th>
                                <th>Health</th>
                                <th>Birth</th>
                                <th>Entry</th>
                                <th>Origin</th>
                                <th>Vaccinated</th>
                                <th>Location</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id=\"animal-table-body\">
                            {% for animal in animals %}
                                <tr>
                                    <td data-sort=\"{{ animal.earTag }}\">{{ animal.earTag }}</td>
                                    <td data-sort=\"{{ animal.type|lower }}\">{{ animal.type }}</td>
                                    <td data-sort=\"{{ animal.weight is not null ? animal.weight : -1 }}\">{{ animal.weight is not null ? animal.weight ~ ' kg' : '-' }}</td>
                                    <td data-sort=\"{{ animal.healthStatus|default('')|lower }}\">{{ animal.healthStatus ?: '-' }}</td>
                                    <td data-sort=\"{{ animal.birthDate ? animal.birthDate|date('Y-m-d') : '' }}\">{{ animal.birthDate ? animal.birthDate|date('Y-m-d') : '-' }}</td>
                                    <td data-sort=\"{{ animal.entryDate ? animal.entryDate|date('Y-m-d') : '' }}\">{{ animal.entryDate ? animal.entryDate|date('Y-m-d') : '-' }}</td>
                                    <td data-sort=\"{{ animal.origin|default('')|lower }}\">{{ animal.origin ?: '-' }}</td>
                                    <td data-sort=\"{{ animal.vaccinated ? '1' : '0' }}\">{{ animal.vaccinated ? 'Yes' : 'No' }}</td>
                                    <td data-sort=\"{{ animal.location|default('')|lower }}\">{{ animal.location ?: '-' }}</td>
                                    <td>
                                        <a class=\"link\" href=\"{{ path(pageRoute, {animalId: animal.id, editAnimalId: animal.id}|merge(adminMode ? {user_id: selectedUserId} : {})) }}\">Edit</a>
                                        <form method=\"post\" action=\"{{ path(animalDeleteRoute, {id: animal.id}) }}\" style=\"display:inline;\">
                                            <input type=\"hidden\" name=\"animal_id\" value=\"{{ currentAnimalId }}\">
                                            {% if adminMode %}<input type=\"hidden\" name=\"user_id\" value=\"{{ selectedUserId }}\">{% endif %}
                                            <button class=\"link danger\" type=\"submit\">Delete</button>
                                        </form>
                                        <a class=\"link\" href=\"{{ path(pageRoute, {animalId: animal.id}|merge(adminMode ? {user_id: selectedUserId} : {})) }}\">Records</a>
                                    </td>
                                </tr>
                            {% else %}
                                <tr>
                                    <td colspan=\"10\">No animals found yet.</td>
                                </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Health records</h2>
                <p>{% if selectedAnimal %}Records for ear tag {{ selectedAnimal.earTag }} ({{ selectedAnimal.type }}).{% else %}Select an animal to view its health history.{% endif %}</p>
            </div>
            <div class=\"crud-actions\"><span class=\"pill\">{{ recordCount }} records</span></div>
        </div>

        <div class=\"crud-grid animals-entry-grid animals-entry-row\">
            <div class=\"crud-form\" id=\"record-form\">
                <h3>{{ editingRecord ? 'Edit record' : 'Create record' }}</h3>
                <form method=\"post\" action=\"{{ path(recordSaveRoute) }}\">
                    <input type=\"hidden\" name=\"id\" value=\"{{ editingRecord ? editingRecord.id : '' }}\">
                    {% if adminMode %}
                        <input type=\"hidden\" name=\"user_id\" value=\"{{ selectedUserId }}\">
                    {% endif %}
                    <div class=\"form-grid animals-form-grid\">
                        <label class=\"field\">
                            <span>Animal</span>
                            <select class=\"input\" name=\"animal_id\" required>
                                <option value=\"\">Select animal</option>
                                {% for animal in animals %}
                                    <option value=\"{{ animal.id }}\" {% if (editingRecord and editingRecord.animal.id == animal.id) or (not editingRecord and selectedAnimal and selectedAnimal.id == animal.id) %}selected{% endif %}>{{ animal.earTag }} - {{ animal.type }}</option>
                                {% endfor %}
                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Record date</span>
                            <input class=\"input\" type=\"date\" name=\"record_date\" value=\"{{ editingRecord and editingRecord.recordDate ? editingRecord.recordDate|date('Y-m-d') : 'now'|date('Y-m-d') }}\" required>
                        </label>
                        <label class=\"field\">
                            <span>Weight</span>
                            <input class=\"input\" type=\"text\" name=\"weight\" value=\"{{ editingRecord and editingRecord.weight is not null ? editingRecord.weight : '' }}\" placeholder=\"0.0\">
                        </label>
                        <label class=\"field\">
                            <span>Appetite</span>
                            <select class=\"input\" name=\"appetite\">
                                <option value=\"\">Select appetite</option>
                                {% for appetite in appetites %}
                                    <option value=\"{{ appetite }}\" {% if editingRecord and editingRecord.appetite == appetite %}selected{% endif %}>{{ appetite }}</option>
                                {% endfor %}
                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Condition</span>
                            <select class=\"input\" name=\"condition_status\" required>
                                <option value=\"\">Select condition</option>
                                {% for condition in conditions %}
                                    <option value=\"{{ condition }}\" {% if editingRecord and editingRecord.conditionStatus == condition %}selected{% endif %}>{{ condition }}</option>
                                {% endfor %}
                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Production</span>
                            <input class=\"input\" type=\"text\" name=\"production\" value=\"{{ editingRecord ? (editingRecord.milkYield ?? editingRecord.eggCount ?? editingRecord.woolLength ?? '') : '' }}\" placeholder=\"0\">
                        </label>
                        <label class=\"field\" style=\"grid-column: 1 / -1;\">
                            <span>Notes</span>
                            <textarea class=\"input\" name=\"notes\" rows=\"4\" placeholder=\"Optional notes\">{{ editingRecord ? editingRecord.notes : '' }}</textarea>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\">{{ editingRecord ? 'Update' : 'Save' }}</button>
                        <a class=\"ghost\" href=\"{{ path(pageRoute, adminMode ? {user_id: selectedUserId, animalId: currentAnimalId} : {animalId: currentAnimalId}) }}\">Reset</a>
                    </div>
                </form>
            </div>

            <div class=\"crud-list\">
                <div class=\"list-head table-tools-row\">
                    <select class=\"input table-filter-column\" id=\"record-search-column\">
                        <option value=\"all\">All columns</option>
                        <option value=\"0\">Animal</option>
                        <option value=\"1\">Date</option>
                        <option value=\"2\">Weight</option>
                        <option value=\"3\">Appetite</option>
                        <option value=\"4\">Condition</option>
                        <option value=\"5\">Production</option>
                        <option value=\"6\">Notes</option>
                    </select>
                    <input class=\"input\" id=\"record-search\" type=\"search\" placeholder=\"Search records\" autocomplete=\"off\">
                    <select class=\"input table-sort-column\" id=\"record-sort-column\">
                        <option value=\"0\">Sort Animal</option>
                        <option value=\"1\">Sort Date</option>
                        <option value=\"2\">Sort Weight</option>
                        <option value=\"3\">Sort Appetite</option>
                        <option value=\"4\">Sort Condition</option>
                        <option value=\"5\">Sort Production</option>
                        <option value=\"6\">Sort Notes</option>
                    </select>
                    <select class=\"input table-sort-dir\" id=\"record-sort-dir\">
                        <option value=\"asc\">Asc</option>
                        <option value=\"desc\">Desc</option>
                    </select>
                    <span class=\"pill\" id=\"record-visible-pill\">{{ records|length }} visible</span>
                </div>
                <div class=\"table-scroll\">
                    <table class=\"data-table\" id=\"record-table\">
                        <thead>
                            <tr>
                                <th>Animal</th>
                                <th>Date</th>
                                <th>Weight</th>
                                <th>Appetite</th>
                                <th>Condition</th>
                                <th>Production</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id=\"record-table-body\">
                            {% for record in records %}
                                {% set productionValue = record.milkYield is not null ? record.milkYield : (record.eggCount is not null ? record.eggCount : (record.woolLength is not null ? record.woolLength : null)) %}
                                <tr>
                                    <td data-sort=\"{{ record.animal.earTag }}\">{{ record.animal.earTag }} - {{ record.animal.type }}</td>
                                    <td data-sort=\"{{ record.recordDate ? record.recordDate|date('Y-m-d') : '' }}\">{{ record.recordDate ? record.recordDate|date('Y-m-d') : '-' }}</td>
                                    <td data-sort=\"{{ record.weight is not null ? record.weight : -1 }}\">{{ record.weight is not null ? record.weight ~ ' kg' : '-' }}</td>
                                    <td data-sort=\"{{ record.appetite|default('')|lower }}\">{{ record.appetite ?: '-' }}</td>
                                    <td data-sort=\"{{ record.conditionStatus|default('')|lower }}\">{{ record.conditionStatus ?: '-' }}</td>
                                    <td data-sort=\"{{ productionValue is not null ? productionValue : -1 }}\">{{ productionValue is not null ? productionValue : '-' }}</td>
                                    <td data-sort=\"{{ record.notes|default('')|lower }}\">{{ record.notes ?: '-' }}</td>
                                    <td>
                                        <a class=\"link\" href=\"{{ path(pageRoute, {animalId: currentAnimalId, editRecordId: record.id}|merge(adminMode ? {user_id: selectedUserId} : {})) }}\">Edit</a>
                                        <form method=\"post\" action=\"{{ path(recordDeleteRoute, {id: record.id}) }}\" style=\"display:inline;\">
                                            <input type=\"hidden\" name=\"animal_id\" value=\"{{ currentAnimalId }}\">
                                            {% if adminMode %}<input type=\"hidden\" name=\"user_id\" value=\"{{ selectedUserId }}\">{% endif %}
                                            <button class=\"link danger\" type=\"submit\">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            {% else %}
                                <tr>
                                    <td colspan=\"8\">No health records yet.</td>
                                </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {% if adminMode %}
        <div class=\"crud-card\">
            <div class=\"crud-head\">
                <div>
                    <h2>Options</h2>
                    <p>Manage shared type and location lists used by animal forms.</p>
                </div>
            </div>
            <div class=\"crud-grid\">
                <div class=\"crud-list\">
                    <div class=\"crud-head\" style=\"margin-bottom: 12px;\">
                        <div>
                            <h2>Animal types</h2>
                            <p>Values are stored in lowercase for consistency.</p>
                        </div>
                    </div>
                    <ul style=\"list-style:none; display:grid; gap:10px; margin-bottom:16px;\">
                        {% for type in types %}
                            <li style=\"display:flex; justify-content:space-between; gap:12px; align-items:center;\">
                                <span>{{ type }}</span>
                                <form method=\"post\" action=\"{{ path(typeDeleteRoute) }}\">
                                    <input type=\"hidden\" name=\"user_id\" value=\"{{ selectedUserId }}\">
                                    <input type=\"hidden\" name=\"value\" value=\"{{ type }}\">
                                    <button class=\"link danger\" type=\"submit\">Delete</button>
                                </form>
                            </li>
                        {% endfor %}
                    </ul>
                    <form method=\"post\" action=\"{{ path(typeAddRoute) }}\" class=\"form-grid\">
                        <input type=\"hidden\" name=\"user_id\" value=\"{{ selectedUserId }}\">
                        <label class=\"field\" style=\"grid-column: 1 / -1;\">
                            <span>New type</span>
                            <input class=\"input\" name=\"value\" placeholder=\"cow, goat, chicken...\">
                        </label>
                        <button class=\"primary\" type=\"submit\">Add type</button>
                    </form>
                </div>
                <div class=\"crud-list\">
                    <div class=\"crud-head\" style=\"margin-bottom: 12px;\">
                        <div>
                            <h2>Animal locations</h2>
                            <p>Simple reusable location values.</p>
                        </div>
                    </div>
                    <ul style=\"list-style:none; display:grid; gap:10px; margin-bottom:16px;\">
                        {% for location in locations %}
                            <li style=\"display:flex; justify-content:space-between; gap:12px; align-items:center;\">
                                <span>{{ location }}</span>
                                <form method=\"post\" action=\"{{ path(locationDeleteRoute) }}\">
                                    <input type=\"hidden\" name=\"user_id\" value=\"{{ selectedUserId }}\">
                                    <input type=\"hidden\" name=\"value\" value=\"{{ location }}\">
                                    <button class=\"link danger\" type=\"submit\">Delete</button>
                                </form>
                            </li>
                        {% endfor %}
                    </ul>
                    <form method=\"post\" action=\"{{ path(locationAddRoute) }}\" class=\"form-grid\">
                        <input type=\"hidden\" name=\"user_id\" value=\"{{ selectedUserId }}\">
                        <label class=\"field\" style=\"grid-column: 1 / -1;\">
                            <span>New location</span>
                            <input class=\"input\" name=\"value\" placeholder=\"barn, coop, pasture...\">
                        </label>
                        <button class=\"primary\" type=\"submit\">Add location</button>
                    </form>
                </div>
            </div>
        </div>
    {% endif %}
</section>

<script>
(() => {
    function initInteractiveTable(config) {
        const table = document.getElementById(config.tableId);
        const body = document.getElementById(config.bodyId);
        const searchInput = document.getElementById(config.searchInputId);
        const searchColumn = document.getElementById(config.searchColumnId);
        const sortColumn = document.getElementById(config.sortColumnId);
        const sortDir = document.getElementById(config.sortDirId);
        const visiblePill = document.getElementById(config.visiblePillId);

        if (!table || !body || !searchInput || !searchColumn || !sortColumn || !sortDir || !visiblePill) {
            return;
        }

        const baseRows = Array.from(body.querySelectorAll('tr')).filter((row) => row.querySelectorAll('td').length > 0);

        function rowCellValue(row, index) {
            const cell = row.querySelectorAll('td')[index];
            if (!cell) {
                return '';
            }
            return String(cell.dataset.sort || cell.textContent || '').trim();
        }

        function compareValues(a, b) {
            const na = Number(a);
            const nb = Number(b);
            if (!Number.isNaN(na) && !Number.isNaN(nb)) {
                return na - nb;
            }
            return a.localeCompare(b, undefined, { sensitivity: 'base' });
        }

        function updateTable() {
            const query = searchInput.value.trim().toLowerCase();
            const selectedColumn = searchColumn.value;
            const sortIndex = Number(sortColumn.value);
            const direction = sortDir.value === 'desc' ? -1 : 1;

            const filtered = baseRows.filter((row) => {
                if (query === '') {
                    return true;
                }

                if (selectedColumn === 'all') {
                    return row.textContent.toLowerCase().includes(query);
                }

                const value = rowCellValue(row, Number(selectedColumn)).toLowerCase();
                return value.includes(query);
            });

            filtered.sort((leftRow, rightRow) => {
                const leftValue = rowCellValue(leftRow, sortIndex);
                const rightValue = rowCellValue(rightRow, sortIndex);
                return compareValues(leftValue, rightValue) * direction;
            });

            baseRows.forEach((row) => {
                row.style.display = 'none';
            });

            filtered.forEach((row) => {
                row.style.display = '';
                body.appendChild(row);
            });

            visiblePill.textContent = `\${filtered.length} visible`;
        }

        [searchInput, searchColumn, sortColumn, sortDir].forEach((el) => {
            el.addEventListener('input', updateTable);
            el.addEventListener('change', updateTable);
        });

        updateTable();
    }

    initInteractiveTable({
        tableId: 'animal-table',
        bodyId: 'animal-table-body',
        searchInputId: 'animal-search',
        searchColumnId: 'animal-search-column',
        sortColumnId: 'animal-sort-column',
        sortDirId: 'animal-sort-dir',
        visiblePillId: 'animal-visible-pill',
    });

    initInteractiveTable({
        tableId: 'record-table',
        bodyId: 'record-table-body',
        searchInputId: 'record-search',
        searchColumnId: 'record-search-column',
        sortColumnId: 'record-sort-column',
        sortDirId: 'record-sort-dir',
        visiblePillId: 'record-visible-pill',
    });
})();
</script>
{% endblock %}
", "management/animals.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\management\\animals.html.twig");
    }
}
