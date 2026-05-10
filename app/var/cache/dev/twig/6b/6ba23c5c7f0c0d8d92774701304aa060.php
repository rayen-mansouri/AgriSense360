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

/* management/equipments.html.twig */
class __TwigTemplate_805db52759fad9af12889d99cfcc934b extends Template
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
        return "management/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "management/equipments.html.twig"));

        $this->parent = $this->load("management/layout.html.twig", 1);
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

        yield "Equipments Management";
        
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

        yield "Equipments Management";
        
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

        yield "Equipment management";
        
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
        $context["isEditing"] = (((array_key_exists("editing", $context) &&  !(null === $context["editing"]))) ? ($context["editing"]) : (false));
        // line 10
        $context["formAction"] = (((($tmp = (isset($context["isEditing"]) || array_key_exists("isEditing", $context) ? $context["isEditing"] : (function () { throw new RuntimeError('Variable "isEditing" does not exist.', 10, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_equipments_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 10, $this->source); })()), "id", [], "any", false, false, false, 10)])) : ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_equipments")));
        // line 11
        $context["isMaintenanceEditing"] = (((array_key_exists("maintenanceEditing", $context) &&  !(null === $context["maintenanceEditing"]))) ? ($context["maintenanceEditing"]) : (false));
        // line 12
        $context["maintenanceAction"] = (((($tmp = (isset($context["isMaintenanceEditing"]) || array_key_exists("isMaintenanceEditing", $context) ? $context["isMaintenanceEditing"] : (function () { throw new RuntimeError('Variable "isMaintenanceEditing" does not exist.', 12, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_maintenance_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 12, $this->source); })()), "id", [], "any", false, false, false, 12)])) : ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_equipments")));
        // line 13
        yield "
<section class=\"crud-section\">
    ";
        // line 15
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 15, $this->source); })()), "flashes", ["errors"], "method", false, false, false, 15));
        foreach ($context['_seq'] as $context["_key"] => $context["errors"]) {
            // line 16
            yield "        ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable($context["errors"]);
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 17
                yield "            <div class=\"form-warning\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
                yield "</div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 19
            yield "    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['errors'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 20
        yield "    ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 20, $this->source); })()), "flashes", ["error"], "method", false, false, false, 20));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 21
            yield "        <div class=\"form-warning\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "</div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 23
        yield "
    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Equipement</h2>
                <p>Manage equipment inventory and status.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\" onclick=\"location.href='#equipment-form'\">Add equipement</button>
            </div>
        </div>

        ";
        // line 36
        $context["equipmentTotal"] = ((CoreExtension::getAttribute($this->env, $this->source, ($context["equipmentStats"] ?? null), "equipmentCount", [], "any", true, true, false, 36)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipmentStats"]) || array_key_exists("equipmentStats", $context) ? $context["equipmentStats"] : (function () { throw new RuntimeError('Variable "equipmentStats" does not exist.', 36, $this->source); })()), "equipmentCount", [], "any", false, false, false, 36), Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["equipments"]) || array_key_exists("equipments", $context) ? $context["equipments"] : (function () { throw new RuntimeError('Variable "equipments" does not exist.', 36, $this->source); })())))) : (Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["equipments"]) || array_key_exists("equipments", $context) ? $context["equipments"] : (function () { throw new RuntimeError('Variable "equipments" does not exist.', 36, $this->source); })()))));
        // line 37
        yield "        ";
        $context["equipmentSafeTotal"] = ((((isset($context["equipmentTotal"]) || array_key_exists("equipmentTotal", $context) ? $context["equipmentTotal"] : (function () { throw new RuntimeError('Variable "equipmentTotal" does not exist.', 37, $this->source); })()) > 0)) ? ((isset($context["equipmentTotal"]) || array_key_exists("equipmentTotal", $context) ? $context["equipmentTotal"] : (function () { throw new RuntimeError('Variable "equipmentTotal" does not exist.', 37, $this->source); })())) : (1));
        // line 38
        yield "        <div style=\"display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:10px; margin-bottom:14px;\">
            <div class=\"pill\">Total equipments: ";
        // line 39
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["equipmentTotal"]) || array_key_exists("equipmentTotal", $context) ? $context["equipmentTotal"] : (function () { throw new RuntimeError('Variable "equipmentTotal" does not exist.', 39, $this->source); })()), "html", null, true);
        yield "</div>
            <div class=\"pill\">Ready: ";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["equipmentStats"] ?? null), "readyCount", [], "any", true, true, false, 40)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipmentStats"]) || array_key_exists("equipmentStats", $context) ? $context["equipmentStats"] : (function () { throw new RuntimeError('Variable "equipmentStats" does not exist.', 40, $this->source); })()), "readyCount", [], "any", false, false, false, 40), 0)) : (0)), "html", null, true);
        yield "</div>
            <div class=\"pill\">Service: ";
        // line 41
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["equipmentStats"] ?? null), "serviceCount", [], "any", true, true, false, 41)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipmentStats"]) || array_key_exists("equipmentStats", $context) ? $context["equipmentStats"] : (function () { throw new RuntimeError('Variable "equipmentStats" does not exist.', 41, $this->source); })()), "serviceCount", [], "any", false, false, false, 41), 0)) : (0)), "html", null, true);
        yield "</div>
            <div class=\"pill\">Offline: ";
        // line 42
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["equipmentStats"] ?? null), "offlineCount", [], "any", true, true, false, 42)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipmentStats"]) || array_key_exists("equipmentStats", $context) ? $context["equipmentStats"] : (function () { throw new RuntimeError('Variable "equipmentStats" does not exist.', 42, $this->source); })()), "offlineCount", [], "any", false, false, false, 42), 0)) : (0)), "html", null, true);
        yield "</div>
        </div>
        <div style=\"display:grid; gap:8px; margin-bottom:14px;\">
            ";
        // line 45
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(((array_key_exists("equipmentStatusLegend", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["equipmentStatusLegend"]) || array_key_exists("equipmentStatusLegend", $context) ? $context["equipmentStatusLegend"] : (function () { throw new RuntimeError('Variable "equipmentStatusLegend" does not exist.', 45, $this->source); })()), [])) : ([])));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 46
            yield "                <div>
                    <p style=\"margin:0 0 4px 0; font-size:0.85rem;\">";
            // line 47
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "label", [], "any", false, false, false, 47), "html", null, true);
            yield " (";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "value", [], "any", false, false, false, 47), "html", null, true);
            yield ")</p>
                    <div style=\"height:10px; background:#ece8de; border-radius:999px;\"><span style=\"display:block; width:";
            // line 48
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::round(((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "value", [], "any", false, false, false, 48) / (isset($context["equipmentSafeTotal"]) || array_key_exists("equipmentSafeTotal", $context) ? $context["equipmentSafeTotal"] : (function () { throw new RuntimeError('Variable "equipmentSafeTotal" does not exist.', 48, $this->source); })())) * 100), 1), "html", null, true);
            yield "%; height:10px; border-radius:999px; background:";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "color", [], "any", false, false, false, 48), "html", null, true);
            yield ";\"></span></div>
                </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 51
        yield "        </div>

        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" id=\"equipment-search\" type=\"search\" placeholder=\"Search equipements\" autocomplete=\"off\">
                    <select class=\"input\" id=\"equipment-search-column\">
                        <option value=\"all\">All columns</option>
                        <option value=\"name\">Nom</option>
                        <option value=\"type\">Type</option>
                        <option value=\"status\">Etat</option>
                        <option value=\"purchaseDate\">DateAchat</option>
                    </select>
                    <span class=\"pill\">";
        // line 64
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["equipments"]) || array_key_exists("equipments", $context) ? $context["equipments"] : (function () { throw new RuntimeError('Variable "equipments" does not exist.', 64, $this->source); })())), "html", null, true);
        yield " records</span>
                </div>

                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>Etat</th>
                            <th>DateAchat</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id=\"equipment-table-body\">
                        ";
        // line 78
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["equipments"]) || array_key_exists("equipments", $context) ? $context["equipments"] : (function () { throw new RuntimeError('Variable "equipments" does not exist.', 78, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 79
            yield "                            <tr data-name=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["row"], "name", [], "any", true, true, false, 79)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "name", [], "any", false, false, false, 79), "")) : (""))), "html_attr");
            yield "\" data-type=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["row"], "type", [], "any", true, true, false, 79)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "type", [], "any", false, false, false, 79), "")) : (""))), "html_attr");
            yield "\" data-status=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["row"], "status", [], "any", true, true, false, 79)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "status", [], "any", false, false, false, 79), "")) : (""))), "html_attr");
            yield "\" data-purchase-date=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["row"], "purchaseDate", [], "any", false, false, false, 79)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "purchaseDate", [], "any", false, false, false, 79), "Y-m-d")) : (""))), "html_attr");
            yield "\">
                                <td>";
            // line 80
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "name", [], "any", false, false, false, 80), "html", null, true);
            yield "</td>
                                <td>";
            // line 81
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "type", [], "any", false, false, false, 81), "html", null, true);
            yield "</td>
                                <td>
                                    ";
            // line 83
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["row"], "status", [], "any", false, false, false, 83) == "Ready")) {
                // line 84
                yield "                                        <span class=\"status ok\">Ready</span>
                                    ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 85
$context["row"], "status", [], "any", false, false, false, 85) == "Service")) {
                // line 86
                yield "                                        <span class=\"status warn\">Service</span>
                                    ";
            } else {
                // line 88
                yield "                                        <span class=\"status danger\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "status", [], "any", false, false, false, 88), "html", null, true);
                yield "</span>
                                    ";
            }
            // line 90
            yield "                                </td>
                                <td>";
            // line 91
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["row"], "purchaseDate", [], "any", false, false, false, 91)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "purchaseDate", [], "any", false, false, false, 91), "Y-m-d"), "html", null, true)) : (""));
            yield "</td>
                                <td>
                                    <button class=\"link js-edit-equipment\" type=\"button\" data-edit-url=\"";
            // line 93
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_equipments_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["row"], "id", [], "any", false, false, false, 93)]), "html", null, true);
            yield "\">Edit</button>
                                    <form action=\"";
            // line 94
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_equipments_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["row"], "id", [], "any", false, false, false, 94)]), "html", null, true);
            yield "\" method=\"post\" style=\"display:inline\" data-ajax-form=\"1\">
                                        <input type=\"hidden\" name=\"_token\" value=\"";
            // line 95
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken(("delete_equipment_" . CoreExtension::getAttribute($this->env, $this->source, $context["row"], "id", [], "any", false, false, false, 95))), "html", null, true);
            yield "\">
                                        <button class=\"link danger\" type=\"submit\">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        ";
            $context['_iterated'] = true;
        }
        // line 100
        if (!$context['_iterated']) {
            // line 101
            yield "                            <tr>
                                <td colspan=\"5\">No equipment found yet.</td>
                            </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['row'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 105
        yield "                    </tbody>
                </table>
            </div>

            <div class=\"crud-form\" id=\"equipment-form\">
                <h3>Create / Edit equipement</h3>
                <form method=\"post\" action=\"";
        // line 111
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["formAction"]) || array_key_exists("formAction", $context) ? $context["formAction"] : (function () { throw new RuntimeError('Variable "formAction" does not exist.', 111, $this->source); })()), "html", null, true);
        yield "\" data-ajax-form=\"1\" novalidate>
                    <input type=\"hidden\" name=\"form_type\" value=\"equipment\">
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Nom</span>
                            <input class=\"input\" type=\"text\" name=\"name\" placeholder=\"Equipment name\" value=\"";
        // line 116
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["equipment"] ?? null), "name", [], "any", true, true, false, 116) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 116, $this->source); })()), "name", [], "any", false, false, false, 116)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 116, $this->source); })()), "name", [], "any", false, false, false, 116), "html", null, true)) : (""));
        yield "\" required>
                        </label>
                        <label class=\"field\">
                            <span>Type</span>
                            <input class=\"input\" type=\"text\" name=\"type\" placeholder=\"Harvest, spray\" value=\"";
        // line 120
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["equipment"] ?? null), "type", [], "any", true, true, false, 120) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 120, $this->source); })()), "type", [], "any", false, false, false, 120)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 120, $this->source); })()), "type", [], "any", false, false, false, 120), "html", null, true)) : (""));
        yield "\" required>
                        </label>
                        <label class=\"field\">
                            <span>Etat</span>
                            <select class=\"input\" name=\"status\" required>
                                ";
        // line 125
        $context["currentStatus"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["equipment"] ?? null), "status", [], "any", true, true, false, 125) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 125, $this->source); })()), "status", [], "any", false, false, false, 125)))) ? (CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 125, $this->source); })()), "status", [], "any", false, false, false, 125)) : ("Ready"));
        // line 126
        yield "                                <option value=\"Ready\" ";
        if (((isset($context["currentStatus"]) || array_key_exists("currentStatus", $context) ? $context["currentStatus"] : (function () { throw new RuntimeError('Variable "currentStatus" does not exist.', 126, $this->source); })()) == "Ready")) {
            yield "selected";
        }
        yield ">Ready</option>
                                <option value=\"Service\" ";
        // line 127
        if (((isset($context["currentStatus"]) || array_key_exists("currentStatus", $context) ? $context["currentStatus"] : (function () { throw new RuntimeError('Variable "currentStatus" does not exist.', 127, $this->source); })()) == "Service")) {
            yield "selected";
        }
        yield ">Service</option>
                                <option value=\"Offline\" ";
        // line 128
        if (((isset($context["currentStatus"]) || array_key_exists("currentStatus", $context) ? $context["currentStatus"] : (function () { throw new RuntimeError('Variable "currentStatus" does not exist.', 128, $this->source); })()) == "Offline")) {
            yield "selected";
        }
        yield ">Offline</option>
                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Date achat</span>
                            <input class=\"input\" type=\"date\" name=\"purchase_date\" value=\"";
        // line 133
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 133, $this->source); })()), "purchaseDate", [], "any", false, false, false, 133)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 133, $this->source); })()), "purchaseDate", [], "any", false, false, false, 133), "Y-m-d"), "html", null, true)) : (""));
        yield "\">
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\">";
        // line 137
        yield (((($tmp = (isset($context["isEditing"]) || array_key_exists("isEditing", $context) ? $context["isEditing"] : (function () { throw new RuntimeError('Variable "isEditing" does not exist.', 137, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Update") : ("Save"));
        yield "</button>
                        <a class=\"ghost\" href=\"";
        // line 138
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_equipments");
        yield "\">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Maintenance</h2>
                <p>Service history and maintenance costs.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\" onclick=\"location.href='#maintenance-form'\">Add maintenance</button>
            </div>
        </div>

        ";
        // line 157
        $context["maintenanceTotal"] = ((CoreExtension::getAttribute($this->env, $this->source, ($context["equipmentStats"] ?? null), "maintenanceCount", [], "any", true, true, false, 157)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipmentStats"]) || array_key_exists("equipmentStats", $context) ? $context["equipmentStats"] : (function () { throw new RuntimeError('Variable "equipmentStats" does not exist.', 157, $this->source); })()), "maintenanceCount", [], "any", false, false, false, 157), Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["maintenances"]) || array_key_exists("maintenances", $context) ? $context["maintenances"] : (function () { throw new RuntimeError('Variable "maintenances" does not exist.', 157, $this->source); })())))) : (Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["maintenances"]) || array_key_exists("maintenances", $context) ? $context["maintenances"] : (function () { throw new RuntimeError('Variable "maintenances" does not exist.', 157, $this->source); })()))));
        // line 158
        yield "        ";
        $context["maintenanceSafeTotal"] = ((((isset($context["maintenanceTotal"]) || array_key_exists("maintenanceTotal", $context) ? $context["maintenanceTotal"] : (function () { throw new RuntimeError('Variable "maintenanceTotal" does not exist.', 158, $this->source); })()) > 0)) ? ((isset($context["maintenanceTotal"]) || array_key_exists("maintenanceTotal", $context) ? $context["maintenanceTotal"] : (function () { throw new RuntimeError('Variable "maintenanceTotal" does not exist.', 158, $this->source); })())) : (1));
        // line 159
        yield "        <div style=\"display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:10px; margin-bottom:14px;\">
            <div class=\"pill\">Total maintenances: ";
        // line 160
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["maintenanceTotal"]) || array_key_exists("maintenanceTotal", $context) ? $context["maintenanceTotal"] : (function () { throw new RuntimeError('Variable "maintenanceTotal" does not exist.', 160, $this->source); })()), "html", null, true);
        yield "</div>
            <div class=\"pill\">Total cost: ";
        // line 161
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(((CoreExtension::getAttribute($this->env, $this->source, ($context["equipmentStats"] ?? null), "totalCost", [], "any", true, true, false, 161)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipmentStats"]) || array_key_exists("equipmentStats", $context) ? $context["equipmentStats"] : (function () { throw new RuntimeError('Variable "equipmentStats" does not exist.', 161, $this->source); })()), "totalCost", [], "any", false, false, false, 161), 0)) : (0)), 2, ".", ","), "html", null, true);
        yield "</div>
            <div class=\"pill\">Average cost: ";
        // line 162
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(((CoreExtension::getAttribute($this->env, $this->source, ($context["equipmentStats"] ?? null), "averageCost", [], "any", true, true, false, 162)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipmentStats"]) || array_key_exists("equipmentStats", $context) ? $context["equipmentStats"] : (function () { throw new RuntimeError('Variable "equipmentStats" does not exist.', 162, $this->source); })()), "averageCost", [], "any", false, false, false, 162), 0)) : (0)), 2, ".", ","), "html", null, true);
        yield "</div>
        </div>
        <div style=\"display:grid; gap:8px; margin-bottom:14px;\">
            ";
        // line 165
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(((array_key_exists("maintenanceTypeLegend", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["maintenanceTypeLegend"]) || array_key_exists("maintenanceTypeLegend", $context) ? $context["maintenanceTypeLegend"] : (function () { throw new RuntimeError('Variable "maintenanceTypeLegend" does not exist.', 165, $this->source); })()), [])) : ([])));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 166
            yield "                <div>
                    <p style=\"margin:0 0 4px 0; font-size:0.85rem;\">";
            // line 167
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "label", [], "any", false, false, false, 167), "html", null, true);
            yield " (";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "value", [], "any", false, false, false, 167), "html", null, true);
            yield ")</p>
                    <div style=\"height:10px; background:#ece8de; border-radius:999px;\"><span style=\"display:block; width:";
            // line 168
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::round(((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "value", [], "any", false, false, false, 168) / (isset($context["maintenanceSafeTotal"]) || array_key_exists("maintenanceSafeTotal", $context) ? $context["maintenanceSafeTotal"] : (function () { throw new RuntimeError('Variable "maintenanceSafeTotal" does not exist.', 168, $this->source); })())) * 100), 1), "html", null, true);
            yield "%; height:10px; border-radius:999px; background:";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "color", [], "any", false, false, false, 168), "html", null, true);
            yield ";\"></span></div>
                </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 171
        yield "        </div>

        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" id=\"maintenance-search\" type=\"search\" placeholder=\"Search maintenance\" autocomplete=\"off\">
                    <select class=\"input\" id=\"maintenance-search-column\">
                        <option value=\"all\">All columns</option>
                        <option value=\"equipment\">Equipement</option>
                        <option value=\"maintenanceDate\">DateMaintenance</option>
                        <option value=\"maintenanceType\">TypeMaintenance</option>
                        <option value=\"cost\">Cout</option>
                    </select>
                    <span class=\"pill\">";
        // line 184
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["maintenances"]) || array_key_exists("maintenances", $context) ? $context["maintenances"] : (function () { throw new RuntimeError('Variable "maintenances" does not exist.', 184, $this->source); })())), "html", null, true);
        yield " records</span>
                </div>

                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Equipement</th>
                            <th>DateMaintenance</th>
                            <th>TypeMaintenance</th>
                            <th>Cout</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id=\"maintenance-table-body\">
                        ";
        // line 198
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["maintenances"]) || array_key_exists("maintenances", $context) ? $context["maintenances"] : (function () { throw new RuntimeError('Variable "maintenances" does not exist.', 198, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 199
            yield "                            <tr data-equipment=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["row"], "equipment", [], "any", false, false, false, 199)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["row"], "equipment", [], "any", false, false, false, 199), "name", [], "any", false, false, false, 199)) : ("-"))), "html_attr");
            yield "\" data-maintenance-date=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["row"], "maintenanceDate", [], "any", false, false, false, 199)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "maintenanceDate", [], "any", false, false, false, 199), "Y-m-d")) : (""))), "html_attr");
            yield "\" data-maintenance-type=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["row"], "maintenanceType", [], "any", true, true, false, 199)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "maintenanceType", [], "any", false, false, false, 199), "")) : (""))), "html_attr");
            yield "\" data-cost=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["row"], "cost", [], "any", true, true, false, 199)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "cost", [], "any", false, false, false, 199), "")) : (""))), "html_attr");
            yield "\">
                                <td>";
            // line 200
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["row"], "equipment", [], "any", false, false, false, 200)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["row"], "equipment", [], "any", false, false, false, 200), "name", [], "any", false, false, false, 200), "html", null, true)) : ("-"));
            yield "</td>
                                <td>";
            // line 201
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["row"], "maintenanceDate", [], "any", false, false, false, 201)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "maintenanceDate", [], "any", false, false, false, 201), "Y-m-d"), "html", null, true)) : (""));
            yield "</td>
                                <td>";
            // line 202
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "maintenanceType", [], "any", false, false, false, 202), "html", null, true);
            yield "</td>
                                <td>";
            // line 203
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "cost", [], "any", false, false, false, 203), "html", null, true);
            yield "</td>
                                <td>
                                    <button class=\"link js-edit-maintenance\" type=\"button\" data-edit-url=\"";
            // line 205
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_maintenance_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["row"], "id", [], "any", false, false, false, 205)]), "html", null, true);
            yield "\">Edit</button>
                                    <form action=\"";
            // line 206
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_maintenance_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["row"], "id", [], "any", false, false, false, 206)]), "html", null, true);
            yield "\" method=\"post\" style=\"display:inline\" data-ajax-form=\"1\">
                                        <input type=\"hidden\" name=\"_token\" value=\"";
            // line 207
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken(("delete_maintenance_" . CoreExtension::getAttribute($this->env, $this->source, $context["row"], "id", [], "any", false, false, false, 207))), "html", null, true);
            yield "\">
                                        <button class=\"link danger\" type=\"submit\">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        ";
            $context['_iterated'] = true;
        }
        // line 212
        if (!$context['_iterated']) {
            // line 213
            yield "                            <tr>
                                <td colspan=\"5\">No maintenance found yet.</td>
                            </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['row'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 217
        yield "                    </tbody>
                </table>
            </div>

            <div class=\"crud-form\" id=\"maintenance-form\">
                <h3>Create / Edit maintenance</h3>
                <form method=\"post\" action=\"";
        // line 223
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["maintenanceAction"]) || array_key_exists("maintenanceAction", $context) ? $context["maintenanceAction"] : (function () { throw new RuntimeError('Variable "maintenanceAction" does not exist.', 223, $this->source); })()), "html", null, true);
        yield "\" data-ajax-form=\"1\" novalidate>
                    <input type=\"hidden\" name=\"form_type\" value=\"maintenance\">
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Equipement</span>
                            ";
        // line 228
        $context["currentEquipmentId"] = (((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 228, $this->source); })()), "equipment", [], "any", false, false, false, 228)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 228, $this->source); })()), "equipment", [], "any", false, false, false, 228), "id", [], "any", false, false, false, 228)) : (null));
        // line 229
        yield "                            <input type=\"hidden\" name=\"equipment_id\" id=\"maintenance-equipment-id\" value=\"";
        yield (((array_key_exists("currentEquipmentId", $context) &&  !(null === $context["currentEquipmentId"]))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["currentEquipmentId"], "html", null, true)) : (""));
        yield "\" required>
                            <button class=\"input\" type=\"button\" id=\"equipment-picker-toggle\" style=\"text-align:left;\" ";
        // line 230
        if (Twig\Extension\CoreExtension::testEmpty((isset($context["equipments"]) || array_key_exists("equipments", $context) ? $context["equipments"] : (function () { throw new RuntimeError('Variable "equipments" does not exist.', 230, $this->source); })()))) {
            yield "disabled";
        }
        yield ">
                                <span id=\"equipment-picker-label\">
                                    ";
        // line 232
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 232, $this->source); })()), "equipment", [], "any", false, false, false, 232)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 233
            yield "                                        ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 233, $this->source); })()), "equipment", [], "any", false, false, false, 233), "name", [], "any", false, false, false, 233), "html", null, true);
            yield "
                                    ";
        } else {
            // line 235
            yield "                                        Select equipment
                                    ";
        }
        // line 237
        yield "                                </span>
                            </button>
                            <div id=\"equipment-picker-panel\" style=\"display:none; border:1px solid var(--stroke); border-radius:12px; padding:10px; background:#fff; margin-top:8px;\">
                                <input class=\"input\" type=\"search\" id=\"equipment-picker-search\" placeholder=\"Search equipment\" autocomplete=\"off\" ";
        // line 240
        if (Twig\Extension\CoreExtension::testEmpty((isset($context["equipments"]) || array_key_exists("equipments", $context) ? $context["equipments"] : (function () { throw new RuntimeError('Variable "equipments" does not exist.', 240, $this->source); })()))) {
            yield "disabled";
        }
        yield ">
                                <div id=\"equipment-picker-list\" style=\"margin-top:8px; max-height:180px; overflow:auto; display:grid; gap:6px;\">
                                    ";
        // line 242
        if (Twig\Extension\CoreExtension::testEmpty((isset($context["equipments"]) || array_key_exists("equipments", $context) ? $context["equipments"] : (function () { throw new RuntimeError('Variable "equipments" does not exist.', 242, $this->source); })()))) {
            // line 243
            yield "                                        <span class=\"pill\">Add equipment first</span>
                                    ";
        } else {
            // line 245
            yield "                                        ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["equipments"]) || array_key_exists("equipments", $context) ? $context["equipments"] : (function () { throw new RuntimeError('Variable "equipments" does not exist.', 245, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["eq"]) {
                // line 246
                yield "                                            <button
                                                class=\"ghost js-pick-equipment\"
                                                type=\"button\"
                                                data-equipment-id=\"";
                // line 249
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "id", [], "any", false, false, false, 249), "html", null, true);
                yield "\"
                                                data-equipment-name=\"";
                // line 250
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "name", [], "any", false, false, false, 250), "html", null, true);
                yield "\"
                                                style=\"justify-content:flex-start; text-align:left;\"
                                            >
                                                ";
                // line 253
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "name", [], "any", false, false, false, 253), "html", null, true);
                yield "
                                            </button>
                                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['eq'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 256
            yield "                                    ";
        }
        // line 257
        yield "                                </div>
                            </div>
                        </label>
                        <label class=\"field\">
                            <span>Date maintenance</span>
                            <input class=\"input\" type=\"date\" name=\"maintenance_date\" value=\"";
        // line 262
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 262, $this->source); })()), "maintenanceDate", [], "any", false, false, false, 262)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 262, $this->source); })()), "maintenanceDate", [], "any", false, false, false, 262), "Y-m-d"), "html", null, true)) : (""));
        yield "\" required>
                        </label>
                        <label class=\"field\">
                            <span>Type maintenance</span>
                            <input class=\"input\" type=\"text\" name=\"maintenance_type\" placeholder=\"Inspection, repair\" value=\"";
        // line 266
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["maintenance"] ?? null), "maintenanceType", [], "any", true, true, false, 266) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 266, $this->source); })()), "maintenanceType", [], "any", false, false, false, 266)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 266, $this->source); })()), "maintenanceType", [], "any", false, false, false, 266), "html", null, true)) : (""));
        yield "\" required>
                        </label>
                        <label class=\"field\">
                            <span>Cout</span>
                            <input class=\"input\" type=\"number\" name=\"cost\" placeholder=\"0\" step=\"0.01\" value=\"";
        // line 270
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["maintenance"] ?? null), "cost", [], "any", true, true, false, 270) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 270, $this->source); })()), "cost", [], "any", false, false, false, 270)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["maintenance"]) || array_key_exists("maintenance", $context) ? $context["maintenance"] : (function () { throw new RuntimeError('Variable "maintenance" does not exist.', 270, $this->source); })()), "cost", [], "any", false, false, false, 270), "html", null, true)) : (""));
        yield "\" required>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\">";
        // line 274
        yield (((($tmp = (isset($context["isMaintenanceEditing"]) || array_key_exists("isMaintenanceEditing", $context) ? $context["isMaintenanceEditing"] : (function () { throw new RuntimeError('Variable "isMaintenanceEditing" does not exist.', 274, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Update") : ("Save"));
        yield "</button>
                        <a class=\"ghost\" href=\"";
        // line 275
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("management_equipments");
        yield "\">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
(() => {
    let isUpdatingSection = false;

    async function fetchHtml(url, options = {}) {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            ...options,
        });

        if (!response.ok) {
            throw new Error('Request failed with status ' + response.status);
        }

        return response.text();
    }

    function applySearchFilter(inputSelector, tbodySelector, columnSelector) {
        const input = document.querySelector(inputSelector);
        const tbody = document.querySelector(tbodySelector);
        if (!input || !tbody) {
            return;
        }

        const rows = Array.from(tbody.querySelectorAll('tr'));
        const query = input.value.trim().toLowerCase();
        const columnSelect = columnSelector ? document.querySelector(columnSelector) : null;
        const column = columnSelect ? columnSelect.value : 'all';

        rows.forEach((row) => {
            const text = column && column !== 'all'
                ? String(row.dataset[column] || '').toLowerCase()
                : row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    }

    function wireSearchInputs() {
        const equipmentSearch = document.querySelector('#equipment-search');
        const maintenanceSearch = document.querySelector('#maintenance-search');

        if (equipmentSearch) {
            equipmentSearch.addEventListener('input', () => {
                applySearchFilter('#equipment-search', '#equipment-table-body', '#equipment-search-column');
            });
        }

        const equipmentSearchColumn = document.querySelector('#equipment-search-column');
        if (equipmentSearchColumn) {
            equipmentSearchColumn.addEventListener('change', () => {
                applySearchFilter('#equipment-search', '#equipment-table-body', '#equipment-search-column');
            });
        }

        if (maintenanceSearch) {
            maintenanceSearch.addEventListener('input', () => {
                applySearchFilter('#maintenance-search', '#maintenance-table-body', '#maintenance-search-column');
            });
        }

        const maintenanceSearchColumn = document.querySelector('#maintenance-search-column');
        if (maintenanceSearchColumn) {
            maintenanceSearchColumn.addEventListener('change', () => {
                applySearchFilter('#maintenance-search', '#maintenance-table-body', '#maintenance-search-column');
            });
        }
    }

    function wireEquipmentPicker() {
        const toggle = document.querySelector('#equipment-picker-toggle');
        const panel = document.querySelector('#equipment-picker-panel');
        const search = document.querySelector('#equipment-picker-search');

        if (!toggle || !panel) {
            return;
        }

        toggle.addEventListener('click', () => {
            const isOpen = panel.style.display === 'block';
            panel.style.display = isOpen ? 'none' : 'block';

            if (!isOpen && search) {
                search.focus();
            }
        });

        if (search) {
            search.addEventListener('input', () => {
                const query = search.value.trim().toLowerCase();
                const options = Array.from(document.querySelectorAll('.js-pick-equipment'));

                options.forEach((option) => {
                    const name = (option.dataset.equipmentName || '').toLowerCase();
                    option.style.display = name.includes(query) ? '' : 'none';
                });
            });
        }
    }

    function updateCrudSectionFromHtml(html) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newSection = doc.querySelector('.crud-section');
        const currentSection = document.querySelector('.crud-section');

        if (!newSection || !currentSection) {
            throw new Error('Unable to refresh CRUD section.');
        }

        currentSection.replaceWith(newSection);
        wireSearchInputs();
        wireEquipmentPicker();
    }

    async function submitAjaxForm(form) {
        if (isUpdatingSection) {
            return;
        }

        isUpdatingSection = true;
        const submitButton = form.querySelector('button[type=\"submit\"]');
        const originalText = submitButton ? submitButton.textContent : '';

        try {
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Saving...';
            }

            const body = new URLSearchParams(new FormData(form));
            const html = await fetchHtml(form.action, {
                method: form.method || 'POST',
                body,
            });

            updateCrudSectionFromHtml(html);
        } catch (error) {
            console.error(error);
            alert('Operation failed. Please try again.');
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            }

            isUpdatingSection = false;
        }
    }

    async function openEditForm(url) {
        if (isUpdatingSection) {
            return;
        }

        isUpdatingSection = true;

        try {
            const html = await fetchHtml(url, { method: 'GET' });
            updateCrudSectionFromHtml(html);
            const formSection = document.querySelector('#equipment-form, #maintenance-form');
            if (formSection) {
                formSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        } catch (error) {
            console.error(error);
            alert('Unable to open edit form.');
        } finally {
            isUpdatingSection = false;
        }
    }

    document.addEventListener('submit', (event) => {
        const form = event.target.closest('form[data-ajax-form=\"1\"]');
        if (!form) {
            return;
        }

        event.preventDefault();
        submitAjaxForm(form);
    });

    document.addEventListener('click', (event) => {
        const equipmentEditButton = event.target.closest('.js-edit-equipment');
        if (equipmentEditButton) {
            event.preventDefault();
            openEditForm(equipmentEditButton.dataset.editUrl);
            return;
        }

        const maintenanceEditButton = event.target.closest('.js-edit-maintenance');
        if (maintenanceEditButton) {
            event.preventDefault();
            openEditForm(maintenanceEditButton.dataset.editUrl);
            return;
        }

        const pickEquipmentButton = event.target.closest('.js-pick-equipment');
        if (pickEquipmentButton) {
            event.preventDefault();

            const idInput = document.querySelector('#maintenance-equipment-id');
            const label = document.querySelector('#equipment-picker-label');
            const panel = document.querySelector('#equipment-picker-panel');

            if (idInput) {
                idInput.value = pickEquipmentButton.dataset.equipmentId || '';
            }

            if (label) {
                label.textContent = pickEquipmentButton.dataset.equipmentName || 'Select equipment';
            }

            if (panel) {
                panel.style.display = 'none';
            }
        }
    });

    wireSearchInputs();
    wireEquipmentPicker();
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
        return "management/equipments.html.twig";
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
        return array (  717 => 275,  713 => 274,  706 => 270,  699 => 266,  692 => 262,  685 => 257,  682 => 256,  673 => 253,  667 => 250,  663 => 249,  658 => 246,  653 => 245,  649 => 243,  647 => 242,  640 => 240,  635 => 237,  631 => 235,  625 => 233,  623 => 232,  616 => 230,  611 => 229,  609 => 228,  601 => 223,  593 => 217,  584 => 213,  582 => 212,  572 => 207,  568 => 206,  564 => 205,  559 => 203,  555 => 202,  551 => 201,  547 => 200,  536 => 199,  531 => 198,  514 => 184,  499 => 171,  488 => 168,  482 => 167,  479 => 166,  475 => 165,  469 => 162,  465 => 161,  461 => 160,  458 => 159,  455 => 158,  453 => 157,  431 => 138,  427 => 137,  420 => 133,  410 => 128,  404 => 127,  397 => 126,  395 => 125,  387 => 120,  380 => 116,  372 => 111,  364 => 105,  355 => 101,  353 => 100,  343 => 95,  339 => 94,  335 => 93,  330 => 91,  327 => 90,  321 => 88,  317 => 86,  315 => 85,  312 => 84,  310 => 83,  305 => 81,  301 => 80,  290 => 79,  285 => 78,  268 => 64,  253 => 51,  242 => 48,  236 => 47,  233 => 46,  229 => 45,  223 => 42,  219 => 41,  215 => 40,  211 => 39,  208 => 38,  205 => 37,  203 => 36,  188 => 23,  179 => 21,  174 => 20,  168 => 19,  159 => 17,  154 => 16,  150 => 15,  146 => 13,  144 => 12,  142 => 11,  140 => 10,  138 => 9,  128 => 8,  112 => 6,  95 => 5,  78 => 4,  61 => 3,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("﻿{% extends 'management/layout.html.twig' %}

{% block title %}Equipments Management{% endblock %}
{% block eyebrow %}Equipments Management{% endblock %}
{% block heading %}Equipment management{% endblock %}
{% block subhead %}{% endblock %}

{% block body %}
{% set isEditing = editing ?? false %}
{% set formAction = isEditing ? path('management_equipments_edit', { id: equipment.id }) : path('management_equipments') %}
{% set isMaintenanceEditing = maintenanceEditing ?? false %}
{% set maintenanceAction = isMaintenanceEditing ? path('management_maintenance_edit', { id: maintenance.id }) : path('management_equipments') %}

<section class=\"crud-section\">
    {% for errors in app.flashes('errors') %}
        {% for message in errors %}
            <div class=\"form-warning\">{{ message }}</div>
        {% endfor %}
    {% endfor %}
    {% for message in app.flashes('error') %}
        <div class=\"form-warning\">{{ message }}</div>
    {% endfor %}

    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Equipement</h2>
                <p>Manage equipment inventory and status.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\" onclick=\"location.href='#equipment-form'\">Add equipement</button>
            </div>
        </div>

        {% set equipmentTotal = equipmentStats.equipmentCount|default(equipments|length) %}
        {% set equipmentSafeTotal = equipmentTotal > 0 ? equipmentTotal : 1 %}
        <div style=\"display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:10px; margin-bottom:14px;\">
            <div class=\"pill\">Total equipments: {{ equipmentTotal }}</div>
            <div class=\"pill\">Ready: {{ equipmentStats.readyCount|default(0) }}</div>
            <div class=\"pill\">Service: {{ equipmentStats.serviceCount|default(0) }}</div>
            <div class=\"pill\">Offline: {{ equipmentStats.offlineCount|default(0) }}</div>
        </div>
        <div style=\"display:grid; gap:8px; margin-bottom:14px;\">
            {% for item in equipmentStatusLegend|default([]) %}
                <div>
                    <p style=\"margin:0 0 4px 0; font-size:0.85rem;\">{{ item.label }} ({{ item.value }})</p>
                    <div style=\"height:10px; background:#ece8de; border-radius:999px;\"><span style=\"display:block; width:{{ ((item.value / equipmentSafeTotal) * 100)|round(1) }}%; height:10px; border-radius:999px; background:{{ item.color }};\"></span></div>
                </div>
            {% endfor %}
        </div>

        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" id=\"equipment-search\" type=\"search\" placeholder=\"Search equipements\" autocomplete=\"off\">
                    <select class=\"input\" id=\"equipment-search-column\">
                        <option value=\"all\">All columns</option>
                        <option value=\"name\">Nom</option>
                        <option value=\"type\">Type</option>
                        <option value=\"status\">Etat</option>
                        <option value=\"purchaseDate\">DateAchat</option>
                    </select>
                    <span class=\"pill\">{{ equipments|length }} records</span>
                </div>

                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>Etat</th>
                            <th>DateAchat</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id=\"equipment-table-body\">
                        {% for row in equipments %}
                            <tr data-name=\"{{ row.name|default('')|lower|e('html_attr') }}\" data-type=\"{{ row.type|default('')|lower|e('html_attr') }}\" data-status=\"{{ row.status|default('')|lower|e('html_attr') }}\" data-purchase-date=\"{{ (row.purchaseDate ? row.purchaseDate|date('Y-m-d') : '')|lower|e('html_attr') }}\">
                                <td>{{ row.name }}</td>
                                <td>{{ row.type }}</td>
                                <td>
                                    {% if row.status == 'Ready' %}
                                        <span class=\"status ok\">Ready</span>
                                    {% elseif row.status == 'Service' %}
                                        <span class=\"status warn\">Service</span>
                                    {% else %}
                                        <span class=\"status danger\">{{ row.status }}</span>
                                    {% endif %}
                                </td>
                                <td>{{ row.purchaseDate ? row.purchaseDate|date('Y-m-d') : '' }}</td>
                                <td>
                                    <button class=\"link js-edit-equipment\" type=\"button\" data-edit-url=\"{{ path('management_equipments_edit', { id: row.id }) }}\">Edit</button>
                                    <form action=\"{{ path('management_equipments_delete', { id: row.id }) }}\" method=\"post\" style=\"display:inline\" data-ajax-form=\"1\">
                                        <input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token('delete_equipment_' ~ row.id) }}\">
                                        <button class=\"link danger\" type=\"submit\">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        {% else %}
                            <tr>
                                <td colspan=\"5\">No equipment found yet.</td>
                            </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>

            <div class=\"crud-form\" id=\"equipment-form\">
                <h3>Create / Edit equipement</h3>
                <form method=\"post\" action=\"{{ formAction }}\" data-ajax-form=\"1\" novalidate>
                    <input type=\"hidden\" name=\"form_type\" value=\"equipment\">
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Nom</span>
                            <input class=\"input\" type=\"text\" name=\"name\" placeholder=\"Equipment name\" value=\"{{ equipment.name ?? '' }}\" required>
                        </label>
                        <label class=\"field\">
                            <span>Type</span>
                            <input class=\"input\" type=\"text\" name=\"type\" placeholder=\"Harvest, spray\" value=\"{{ equipment.type ?? '' }}\" required>
                        </label>
                        <label class=\"field\">
                            <span>Etat</span>
                            <select class=\"input\" name=\"status\" required>
                                {% set currentStatus = equipment.status ?? 'Ready' %}
                                <option value=\"Ready\" {% if currentStatus == 'Ready' %}selected{% endif %}>Ready</option>
                                <option value=\"Service\" {% if currentStatus == 'Service' %}selected{% endif %}>Service</option>
                                <option value=\"Offline\" {% if currentStatus == 'Offline' %}selected{% endif %}>Offline</option>
                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Date achat</span>
                            <input class=\"input\" type=\"date\" name=\"purchase_date\" value=\"{{ equipment.purchaseDate ? equipment.purchaseDate|date('Y-m-d') : '' }}\">
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\">{{ isEditing ? 'Update' : 'Save' }}</button>
                        <a class=\"ghost\" href=\"{{ path('management_equipments') }}\">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Maintenance</h2>
                <p>Service history and maintenance costs.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\" onclick=\"location.href='#maintenance-form'\">Add maintenance</button>
            </div>
        </div>

        {% set maintenanceTotal = equipmentStats.maintenanceCount|default(maintenances|length) %}
        {% set maintenanceSafeTotal = maintenanceTotal > 0 ? maintenanceTotal : 1 %}
        <div style=\"display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:10px; margin-bottom:14px;\">
            <div class=\"pill\">Total maintenances: {{ maintenanceTotal }}</div>
            <div class=\"pill\">Total cost: {{ equipmentStats.totalCost|default(0)|number_format(2, '.', ',') }}</div>
            <div class=\"pill\">Average cost: {{ equipmentStats.averageCost|default(0)|number_format(2, '.', ',') }}</div>
        </div>
        <div style=\"display:grid; gap:8px; margin-bottom:14px;\">
            {% for item in maintenanceTypeLegend|default([]) %}
                <div>
                    <p style=\"margin:0 0 4px 0; font-size:0.85rem;\">{{ item.label }} ({{ item.value }})</p>
                    <div style=\"height:10px; background:#ece8de; border-radius:999px;\"><span style=\"display:block; width:{{ ((item.value / maintenanceSafeTotal) * 100)|round(1) }}%; height:10px; border-radius:999px; background:{{ item.color }};\"></span></div>
                </div>
            {% endfor %}
        </div>

        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" id=\"maintenance-search\" type=\"search\" placeholder=\"Search maintenance\" autocomplete=\"off\">
                    <select class=\"input\" id=\"maintenance-search-column\">
                        <option value=\"all\">All columns</option>
                        <option value=\"equipment\">Equipement</option>
                        <option value=\"maintenanceDate\">DateMaintenance</option>
                        <option value=\"maintenanceType\">TypeMaintenance</option>
                        <option value=\"cost\">Cout</option>
                    </select>
                    <span class=\"pill\">{{ maintenances|length }} records</span>
                </div>

                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Equipement</th>
                            <th>DateMaintenance</th>
                            <th>TypeMaintenance</th>
                            <th>Cout</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id=\"maintenance-table-body\">
                        {% for row in maintenances %}
                            <tr data-equipment=\"{{ (row.equipment ? row.equipment.name : '-')|lower|e('html_attr') }}\" data-maintenance-date=\"{{ (row.maintenanceDate ? row.maintenanceDate|date('Y-m-d') : '')|lower|e('html_attr') }}\" data-maintenance-type=\"{{ row.maintenanceType|default('')|lower|e('html_attr') }}\" data-cost=\"{{ row.cost|default('')|lower|e('html_attr') }}\">
                                <td>{{ row.equipment ? row.equipment.name : '-' }}</td>
                                <td>{{ row.maintenanceDate ? row.maintenanceDate|date('Y-m-d') : '' }}</td>
                                <td>{{ row.maintenanceType }}</td>
                                <td>{{ row.cost }}</td>
                                <td>
                                    <button class=\"link js-edit-maintenance\" type=\"button\" data-edit-url=\"{{ path('management_maintenance_edit', { id: row.id }) }}\">Edit</button>
                                    <form action=\"{{ path('management_maintenance_delete', { id: row.id }) }}\" method=\"post\" style=\"display:inline\" data-ajax-form=\"1\">
                                        <input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token('delete_maintenance_' ~ row.id) }}\">
                                        <button class=\"link danger\" type=\"submit\">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        {% else %}
                            <tr>
                                <td colspan=\"5\">No maintenance found yet.</td>
                            </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>

            <div class=\"crud-form\" id=\"maintenance-form\">
                <h3>Create / Edit maintenance</h3>
                <form method=\"post\" action=\"{{ maintenanceAction }}\" data-ajax-form=\"1\" novalidate>
                    <input type=\"hidden\" name=\"form_type\" value=\"maintenance\">
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Equipement</span>
                            {% set currentEquipmentId = maintenance.equipment ? maintenance.equipment.id : null %}
                            <input type=\"hidden\" name=\"equipment_id\" id=\"maintenance-equipment-id\" value=\"{{ currentEquipmentId ?? '' }}\" required>
                            <button class=\"input\" type=\"button\" id=\"equipment-picker-toggle\" style=\"text-align:left;\" {% if equipments is empty %}disabled{% endif %}>
                                <span id=\"equipment-picker-label\">
                                    {% if maintenance.equipment %}
                                        {{ maintenance.equipment.name }}
                                    {% else %}
                                        Select equipment
                                    {% endif %}
                                </span>
                            </button>
                            <div id=\"equipment-picker-panel\" style=\"display:none; border:1px solid var(--stroke); border-radius:12px; padding:10px; background:#fff; margin-top:8px;\">
                                <input class=\"input\" type=\"search\" id=\"equipment-picker-search\" placeholder=\"Search equipment\" autocomplete=\"off\" {% if equipments is empty %}disabled{% endif %}>
                                <div id=\"equipment-picker-list\" style=\"margin-top:8px; max-height:180px; overflow:auto; display:grid; gap:6px;\">
                                    {% if equipments is empty %}
                                        <span class=\"pill\">Add equipment first</span>
                                    {% else %}
                                        {% for eq in equipments %}
                                            <button
                                                class=\"ghost js-pick-equipment\"
                                                type=\"button\"
                                                data-equipment-id=\"{{ eq.id }}\"
                                                data-equipment-name=\"{{ eq.name }}\"
                                                style=\"justify-content:flex-start; text-align:left;\"
                                            >
                                                {{ eq.name }}
                                            </button>
                                        {% endfor %}
                                    {% endif %}
                                </div>
                            </div>
                        </label>
                        <label class=\"field\">
                            <span>Date maintenance</span>
                            <input class=\"input\" type=\"date\" name=\"maintenance_date\" value=\"{{ maintenance.maintenanceDate ? maintenance.maintenanceDate|date('Y-m-d') : '' }}\" required>
                        </label>
                        <label class=\"field\">
                            <span>Type maintenance</span>
                            <input class=\"input\" type=\"text\" name=\"maintenance_type\" placeholder=\"Inspection, repair\" value=\"{{ maintenance.maintenanceType ?? '' }}\" required>
                        </label>
                        <label class=\"field\">
                            <span>Cout</span>
                            <input class=\"input\" type=\"number\" name=\"cost\" placeholder=\"0\" step=\"0.01\" value=\"{{ maintenance.cost ?? '' }}\" required>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\">{{ isMaintenanceEditing ? 'Update' : 'Save' }}</button>
                        <a class=\"ghost\" href=\"{{ path('management_equipments') }}\">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
(() => {
    let isUpdatingSection = false;

    async function fetchHtml(url, options = {}) {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            ...options,
        });

        if (!response.ok) {
            throw new Error('Request failed with status ' + response.status);
        }

        return response.text();
    }

    function applySearchFilter(inputSelector, tbodySelector, columnSelector) {
        const input = document.querySelector(inputSelector);
        const tbody = document.querySelector(tbodySelector);
        if (!input || !tbody) {
            return;
        }

        const rows = Array.from(tbody.querySelectorAll('tr'));
        const query = input.value.trim().toLowerCase();
        const columnSelect = columnSelector ? document.querySelector(columnSelector) : null;
        const column = columnSelect ? columnSelect.value : 'all';

        rows.forEach((row) => {
            const text = column && column !== 'all'
                ? String(row.dataset[column] || '').toLowerCase()
                : row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    }

    function wireSearchInputs() {
        const equipmentSearch = document.querySelector('#equipment-search');
        const maintenanceSearch = document.querySelector('#maintenance-search');

        if (equipmentSearch) {
            equipmentSearch.addEventListener('input', () => {
                applySearchFilter('#equipment-search', '#equipment-table-body', '#equipment-search-column');
            });
        }

        const equipmentSearchColumn = document.querySelector('#equipment-search-column');
        if (equipmentSearchColumn) {
            equipmentSearchColumn.addEventListener('change', () => {
                applySearchFilter('#equipment-search', '#equipment-table-body', '#equipment-search-column');
            });
        }

        if (maintenanceSearch) {
            maintenanceSearch.addEventListener('input', () => {
                applySearchFilter('#maintenance-search', '#maintenance-table-body', '#maintenance-search-column');
            });
        }

        const maintenanceSearchColumn = document.querySelector('#maintenance-search-column');
        if (maintenanceSearchColumn) {
            maintenanceSearchColumn.addEventListener('change', () => {
                applySearchFilter('#maintenance-search', '#maintenance-table-body', '#maintenance-search-column');
            });
        }
    }

    function wireEquipmentPicker() {
        const toggle = document.querySelector('#equipment-picker-toggle');
        const panel = document.querySelector('#equipment-picker-panel');
        const search = document.querySelector('#equipment-picker-search');

        if (!toggle || !panel) {
            return;
        }

        toggle.addEventListener('click', () => {
            const isOpen = panel.style.display === 'block';
            panel.style.display = isOpen ? 'none' : 'block';

            if (!isOpen && search) {
                search.focus();
            }
        });

        if (search) {
            search.addEventListener('input', () => {
                const query = search.value.trim().toLowerCase();
                const options = Array.from(document.querySelectorAll('.js-pick-equipment'));

                options.forEach((option) => {
                    const name = (option.dataset.equipmentName || '').toLowerCase();
                    option.style.display = name.includes(query) ? '' : 'none';
                });
            });
        }
    }

    function updateCrudSectionFromHtml(html) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newSection = doc.querySelector('.crud-section');
        const currentSection = document.querySelector('.crud-section');

        if (!newSection || !currentSection) {
            throw new Error('Unable to refresh CRUD section.');
        }

        currentSection.replaceWith(newSection);
        wireSearchInputs();
        wireEquipmentPicker();
    }

    async function submitAjaxForm(form) {
        if (isUpdatingSection) {
            return;
        }

        isUpdatingSection = true;
        const submitButton = form.querySelector('button[type=\"submit\"]');
        const originalText = submitButton ? submitButton.textContent : '';

        try {
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Saving...';
            }

            const body = new URLSearchParams(new FormData(form));
            const html = await fetchHtml(form.action, {
                method: form.method || 'POST',
                body,
            });

            updateCrudSectionFromHtml(html);
        } catch (error) {
            console.error(error);
            alert('Operation failed. Please try again.');
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            }

            isUpdatingSection = false;
        }
    }

    async function openEditForm(url) {
        if (isUpdatingSection) {
            return;
        }

        isUpdatingSection = true;

        try {
            const html = await fetchHtml(url, { method: 'GET' });
            updateCrudSectionFromHtml(html);
            const formSection = document.querySelector('#equipment-form, #maintenance-form');
            if (formSection) {
                formSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        } catch (error) {
            console.error(error);
            alert('Unable to open edit form.');
        } finally {
            isUpdatingSection = false;
        }
    }

    document.addEventListener('submit', (event) => {
        const form = event.target.closest('form[data-ajax-form=\"1\"]');
        if (!form) {
            return;
        }

        event.preventDefault();
        submitAjaxForm(form);
    });

    document.addEventListener('click', (event) => {
        const equipmentEditButton = event.target.closest('.js-edit-equipment');
        if (equipmentEditButton) {
            event.preventDefault();
            openEditForm(equipmentEditButton.dataset.editUrl);
            return;
        }

        const maintenanceEditButton = event.target.closest('.js-edit-maintenance');
        if (maintenanceEditButton) {
            event.preventDefault();
            openEditForm(maintenanceEditButton.dataset.editUrl);
            return;
        }

        const pickEquipmentButton = event.target.closest('.js-pick-equipment');
        if (pickEquipmentButton) {
            event.preventDefault();

            const idInput = document.querySelector('#maintenance-equipment-id');
            const label = document.querySelector('#equipment-picker-label');
            const panel = document.querySelector('#equipment-picker-panel');

            if (idInput) {
                idInput.value = pickEquipmentButton.dataset.equipmentId || '';
            }

            if (label) {
                label.textContent = pickEquipmentButton.dataset.equipmentName || 'Select equipment';
            }

            if (panel) {
                panel.style.display = 'none';
            }
        }
    });

    wireSearchInputs();
    wireEquipmentPicker();
})();
</script>
{% endblock %}
", "management/equipments.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\management\\equipments.html.twig");
    }
}
