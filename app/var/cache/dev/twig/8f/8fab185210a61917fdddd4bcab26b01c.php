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

/* management/stock.html.twig */
class __TwigTemplate_296908fd8ea5d1a3cfcf854faace2118 extends Template
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
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "management/stock.html.twig"));

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

        yield "Stock Management";
        
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

        yield "Stock Management";
        
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

        yield "Stock, products, and storage";
        
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

        yield "CRUD UI for Produit, Stock, and LieuStockage. Actions are visual only.";
        
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
                <h2>Produit</h2>
                <p>Manage product catalog and units.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\">Add produit</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" type=\"search\" placeholder=\"Search produits\">
                    <span class=\"pill\">2 records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Categorie</th>
                            <th>Unite</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#PR-014</td>
                            <td>Fertilizer NPK</td>
                            <td>Input</td>
                            <td>kg</td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#PR-021</td>
                            <td>Sunflower Seeds</td>
                            <td>Seed</td>
                            <td>bag</td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Create / Edit produit</h3>
                <form>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Nom</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Produit name\">
                        </label>
                        <label class=\"field\">
                            <span>Categorie</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Input, seed, feed\">
                        </label>
                        <label class=\"field\">
                            <span>Unite</span>
                            <input class=\"input\" type=\"text\" placeholder=\"kg, bag, unit\">
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
                <h2>Stock</h2>
                <p>Track quantities and alert thresholds.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\">Add stock</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" type=\"search\" placeholder=\"Search stock\">
                    <span class=\"pill\">2 records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>QuantiteStockee</th>
                            <th>SeuilAlerte</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ST-188</td>
                            <td>320</td>
                            <td>120</td>
                            <td><span class=\"status ok\">Healthy</span></td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#ST-204</td>
                            <td>70</td>
                            <td>100</td>
                            <td><span class=\"status warn\">Low</span></td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Create / Edit stock</h3>
                <form>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Quantite stockee</span>
                            <input class=\"input\" type=\"number\" placeholder=\"0\">
                        </label>
                        <label class=\"field\">
                            <span>Seuil alerte</span>
                            <input class=\"input\" type=\"number\" placeholder=\"0\">
                        </label>
                        <label class=\"field\">
                            <span>Statut</span>
                            <select class=\"input\">
                                <option>Healthy</option>
                                <option>Low</option>
                                <option>Critical</option>
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
                <h2>LieuStockage</h2>
                <p>Define storage locations and capacities.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\">Add lieu</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" type=\"search\" placeholder=\"Search lieux\">
                    <span class=\"pill\">2 records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>CapaciteMax</th>
                            <th>Localisation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#LS-03</td>
                            <td>Central Silo</td>
                            <td>Grain</td>
                            <td>900</td>
                            <td>North Yard</td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#LS-11</td>
                            <td>Cold Room</td>
                            <td>Refrigerated</td>
                            <td>120</td>
                            <td>Processing Wing</td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Create / Edit lieu</h3>
                <form>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Nom</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Storage name\">
                        </label>
                        <label class=\"field\">
                            <span>Type</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Grain, refrigerated\">
                        </label>
                        <label class=\"field\">
                            <span>Capacite max</span>
                            <input class=\"input\" type=\"number\" placeholder=\"0\">
                        </label>
                        <label class=\"field\">
                            <span>Localisation</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Location\">
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
        return "management/stock.html.twig";
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

{% block title %}Stock Management{% endblock %}
{% block eyebrow %}Stock Management{% endblock %}
{% block heading %}Stock, products, and storage{% endblock %}
{% block subhead %}CRUD UI for Produit, Stock, and LieuStockage. Actions are visual only.{% endblock %}

{% block body %}
<section class=\"crud-section\">
    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Produit</h2>
                <p>Manage product catalog and units.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\">Add produit</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" type=\"search\" placeholder=\"Search produits\">
                    <span class=\"pill\">2 records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Categorie</th>
                            <th>Unite</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#PR-014</td>
                            <td>Fertilizer NPK</td>
                            <td>Input</td>
                            <td>kg</td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#PR-021</td>
                            <td>Sunflower Seeds</td>
                            <td>Seed</td>
                            <td>bag</td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Create / Edit produit</h3>
                <form>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Nom</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Produit name\">
                        </label>
                        <label class=\"field\">
                            <span>Categorie</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Input, seed, feed\">
                        </label>
                        <label class=\"field\">
                            <span>Unite</span>
                            <input class=\"input\" type=\"text\" placeholder=\"kg, bag, unit\">
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
                <h2>Stock</h2>
                <p>Track quantities and alert thresholds.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\">Add stock</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" type=\"search\" placeholder=\"Search stock\">
                    <span class=\"pill\">2 records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>QuantiteStockee</th>
                            <th>SeuilAlerte</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ST-188</td>
                            <td>320</td>
                            <td>120</td>
                            <td><span class=\"status ok\">Healthy</span></td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#ST-204</td>
                            <td>70</td>
                            <td>100</td>
                            <td><span class=\"status warn\">Low</span></td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Create / Edit stock</h3>
                <form>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Quantite stockee</span>
                            <input class=\"input\" type=\"number\" placeholder=\"0\">
                        </label>
                        <label class=\"field\">
                            <span>Seuil alerte</span>
                            <input class=\"input\" type=\"number\" placeholder=\"0\">
                        </label>
                        <label class=\"field\">
                            <span>Statut</span>
                            <select class=\"input\">
                                <option>Healthy</option>
                                <option>Low</option>
                                <option>Critical</option>
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
                <h2>LieuStockage</h2>
                <p>Define storage locations and capacities.</p>
            </div>
            <div class=\"crud-actions\">
                <button class=\"ghost\" type=\"button\">Import</button>
                <button class=\"primary\" type=\"button\">Add lieu</button>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" type=\"search\" placeholder=\"Search lieux\">
                    <span class=\"pill\">2 records</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>CapaciteMax</th>
                            <th>Localisation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#LS-03</td>
                            <td>Central Silo</td>
                            <td>Grain</td>
                            <td>900</td>
                            <td>North Yard</td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#LS-11</td>
                            <td>Cold Room</td>
                            <td>Refrigerated</td>
                            <td>120</td>
                            <td>Processing Wing</td>
                            <td>
                                <button class=\"link\" type=\"button\">Edit</button>
                                <button class=\"link danger\" type=\"button\">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Create / Edit lieu</h3>
                <form>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Nom</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Storage name\">
                        </label>
                        <label class=\"field\">
                            <span>Type</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Grain, refrigerated\">
                        </label>
                        <label class=\"field\">
                            <span>Capacite max</span>
                            <input class=\"input\" type=\"number\" placeholder=\"0\">
                        </label>
                        <label class=\"field\">
                            <span>Localisation</span>
                            <input class=\"input\" type=\"text\" placeholder=\"Location\">
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
", "management/stock.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\management\\stock.html.twig");
    }
}
