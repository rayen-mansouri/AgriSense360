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

/* management/culture.html.twig */
class __TwigTemplate_efd20327828a610339a361995dc1cb99 extends Template
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
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "management/culture.html.twig"));

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

        yield "Culture Management";
        
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

        yield "Culture Management";
        
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

        yield "Crops, parcels, and treatments";
        
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

        yield "CRUD UI for Parcelle, Culture, and Traitement. Actions are visual only.";
        
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
        yield "<section class=\"crud-section\">
    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Parcelle</h2>
                <p>Register parcels, soil type, and status.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\">Add parcelle</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" type=\"search\" placeholder=\"Search parcelles\">
                    <span class=\"pill\">2 records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Localisation</th>
                            <th>Surface</th>
                            <th>TypeSol</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#PA-01</td>
                            <td>East Field</td>
                            <td>12.4 ha</td>
                            <td>Loam</td>
                            <td><span class=\"status ok\">Active</span></td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#PA-07</td>
                            <td>South Ridge</td>
                            <td>8.1 ha</td>
                            <td>Clay</td>
                            <td><span class=\"status warn\">Resting</span></td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Create / Edit parcelle</h3>
                <form>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Localisation</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Area or zone\">
                        </label>
                        <label class=\"field\">
                            <span>Surface</span>
                            <input class=\"input\" type=\"text\" placeholder=\"ha\">
                        </label>
                        <label class=\"field\">
                            <span>Type sol</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Loam, clay\">
                        </label>
                        <label class=\"field\">
                            <span>Statut</span>
                            <select class=\"input\">
                                <option>Active</option>
                                <option>Resting</option>
                                <option>Planned</option>
                            </select>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"button\">Save</button>
                        <button class=\"ghost\" type=\"button\">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Culture</h2>
                <p>Plan plantings, harvest dates, and surface area.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\">Add culture</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" type=\"search\" placeholder=\"Search cultures\">
                    <span class=\"pill\">2 records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>DatePlantation</th>
                            <th>DateRecoltePrevue</th>
                            <th>Superficie</th>
                            <th>Etat</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#CU-16</td>
                            <td>Wheat</td>
                            <td>Cereal</td>
                            <td>2025-10-01</td>
                            <td>2026-05-20</td>
                            <td>6.5 ha</td>
                            <td><span class=\"status ok\">On track</span></td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#CU-19</td>
                            <td>Sunflower</td>
                            <td>Oilseed</td>
                            <td>2025-04-15</td>
                            <td>2025-09-10</td>
                            <td>4.2 ha</td>
                            <td><span class=\"status warn\">At risk</span></td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Create / Edit culture</h3>
                <form>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Nom</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Crop name\">
                        </label>
                        <label class=\"field\">
                            <span>Type</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Cereal, oilseed\">
                        </label>
                        <label class=\"field\">
                            <span>Date plantation</span>
                            <input class=\"input\" type=\"date\">
                        </label>
                        <label class=\"field\">
                            <span>Date recolte prevue</span>
                            <input class=\"input\" type=\"date\">
                        </label>
                        <label class=\"field\">
                            <span>Superficie</span>
                            <input class=\"input\" type=\"text\" placeholder=\"ha\">
                        </label>
                        <label class=\"field\">
                            <span>Etat</span>
                            <select class=\"input\">
                                <option>On track</option>
                                <option>At risk</option>
                                <option>Harvested</option>
                            </select>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"button\">Save</button>
                        <button class=\"ghost\" type=\"button\">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Traitement</h2>
                <p>Track recommended doses and frequency.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\">Add traitement</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" type=\"search\" placeholder=\"Search traitements\">
                    <span class=\"pill\">2 records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>DoseRecommandee</th>
                            <th>Frequence</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#TR-03</td>
                            <td>Fungicide A</td>
                            <td>Protection</td>
                            <td>2.5 L/ha</td>
                            <td>Every 14 days</td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#TR-09</td>
                            <td>Foliar Feed</td>
                            <td>Nutrition</td>
                            <td>1.2 L/ha</td>
                            <td>Every 21 days</td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Create / Edit traitement</h3>
                <form>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Nom</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Treatment name\">
                        </label>
                        <label class=\"field\">
                            <span>Type</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Protection, nutrition\">
                        </label>
                        <label class=\"field\">
                            <span>Dose recommandee</span>
                            <input class=\"input\" type=\"text\" placeholder=\"L/ha\">
                        </label>
                        <label class=\"field\">
                            <span>Frequence</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Every 14 days\">
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"button\">Save</button>
                        <button class=\"ghost\" type=\"button\">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "management/culture.html.twig";
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
        return array (  138 => 9,  128 => 8,  111 => 6,  94 => 5,  77 => 4,  60 => 3,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends adminMode|default(false) ? 'admin/layout.html.twig' : 'management/layout.html.twig' %}

{% block title %}Culture Management{% endblock %}
{% block eyebrow %}Culture Management{% endblock %}
{% block heading %}Crops, parcels, and treatments{% endblock %}
{% block subhead %}CRUD UI for Parcelle, Culture, and Traitement. Actions are visual only.{% endblock %}

{% block body %}
<section class=\"crud-section\">
    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Parcelle</h2>
                <p>Register parcels, soil type, and status.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\">Add parcelle</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" type=\"search\" placeholder=\"Search parcelles\">
                    <span class=\"pill\">2 records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Localisation</th>
                            <th>Surface</th>
                            <th>TypeSol</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#PA-01</td>
                            <td>East Field</td>
                            <td>12.4 ha</td>
                            <td>Loam</td>
                            <td><span class=\"status ok\">Active</span></td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#PA-07</td>
                            <td>South Ridge</td>
                            <td>8.1 ha</td>
                            <td>Clay</td>
                            <td><span class=\"status warn\">Resting</span></td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Create / Edit parcelle</h3>
                <form>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Localisation</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Area or zone\">
                        </label>
                        <label class=\"field\">
                            <span>Surface</span>
                            <input class=\"input\" type=\"text\" placeholder=\"ha\">
                        </label>
                        <label class=\"field\">
                            <span>Type sol</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Loam, clay\">
                        </label>
                        <label class=\"field\">
                            <span>Statut</span>
                            <select class=\"input\">
                                <option>Active</option>
                                <option>Resting</option>
                                <option>Planned</option>
                            </select>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"button\">Save</button>
                        <button class=\"ghost\" type=\"button\">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Culture</h2>
                <p>Plan plantings, harvest dates, and surface area.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\">Add culture</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" type=\"search\" placeholder=\"Search cultures\">
                    <span class=\"pill\">2 records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>DatePlantation</th>
                            <th>DateRecoltePrevue</th>
                            <th>Superficie</th>
                            <th>Etat</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#CU-16</td>
                            <td>Wheat</td>
                            <td>Cereal</td>
                            <td>2025-10-01</td>
                            <td>2026-05-20</td>
                            <td>6.5 ha</td>
                            <td><span class=\"status ok\">On track</span></td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#CU-19</td>
                            <td>Sunflower</td>
                            <td>Oilseed</td>
                            <td>2025-04-15</td>
                            <td>2025-09-10</td>
                            <td>4.2 ha</td>
                            <td><span class=\"status warn\">At risk</span></td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Create / Edit culture</h3>
                <form>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Nom</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Crop name\">
                        </label>
                        <label class=\"field\">
                            <span>Type</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Cereal, oilseed\">
                        </label>
                        <label class=\"field\">
                            <span>Date plantation</span>
                            <input class=\"input\" type=\"date\">
                        </label>
                        <label class=\"field\">
                            <span>Date recolte prevue</span>
                            <input class=\"input\" type=\"date\">
                        </label>
                        <label class=\"field\">
                            <span>Superficie</span>
                            <input class=\"input\" type=\"text\" placeholder=\"ha\">
                        </label>
                        <label class=\"field\">
                            <span>Etat</span>
                            <select class=\"input\">
                                <option>On track</option>
                                <option>At risk</option>
                                <option>Harvested</option>
                            </select>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"button\">Save</button>
                        <button class=\"ghost\" type=\"button\">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Traitement</h2>
                <p>Track recommended doses and frequency.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\">Add traitement</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" type=\"search\" placeholder=\"Search traitements\">
                    <span class=\"pill\">2 records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>DoseRecommandee</th>
                            <th>Frequence</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#TR-03</td>
                            <td>Fungicide A</td>
                            <td>Protection</td>
                            <td>2.5 L/ha</td>
                            <td>Every 14 days</td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#TR-09</td>
                            <td>Foliar Feed</td>
                            <td>Nutrition</td>
                            <td>1.2 L/ha</td>
                            <td>Every 21 days</td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Create / Edit traitement</h3>
                <form>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Nom</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Treatment name\">
                        </label>
                        <label class=\"field\">
                            <span>Type</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Protection, nutrition\">
                        </label>
                        <label class=\"field\">
                            <span>Dose recommandee</span>
                            <input class=\"input\" type=\"text\" placeholder=\"L/ha\">
                        </label>
                        <label class=\"field\">
                            <span>Frequence</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Every 14 days\">
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"button\">Save</button>
                        <button class=\"ghost\" type=\"button\">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
{% endblock %}
", "management/culture.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\management\\culture.html.twig");
    }
}
