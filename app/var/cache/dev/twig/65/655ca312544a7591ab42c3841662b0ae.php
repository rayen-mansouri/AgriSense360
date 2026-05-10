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

/* equipment/index.html.twig */
class __TwigTemplate_886167aa2583a2ead39c252aa53fca86 extends Template
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
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "equipment/index.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>Equipment Management</title>
    <link rel=\"stylesheet\" href=\"";
        // line 7
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/styles/equipment.css"), "html", null, true);
        yield "\">
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
</head>
<body>
    <div class=\"page\">
        <header class=\"page-header\">
            <div>
                <p class=\"eyebrow\">Equipment Management</p>
                <h1>Track, update, and maintain your farm equipment.</h1>
            </div>
            <a class=\"btn primary\" href=\"";
        // line 19
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("equipment_new");
        yield "\">Add equipment</a>
        </header>

        <section class=\"card\">
            <table>
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
        // line 35
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["equipments"]) || array_key_exists("equipments", $context) ? $context["equipments"] : (function () { throw new RuntimeError('Variable "equipments" does not exist.', 35, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["equipment"]) {
            // line 36
            yield "                    <tr>
                        <td>";
            // line 37
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipment"], "id", [], "any", false, false, false, 37), "html", null, true);
            yield "</td>
                        <td>";
            // line 38
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipment"], "name", [], "any", false, false, false, 38), "html", null, true);
            yield "</td>
                        <td>";
            // line 39
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipment"], "type", [], "any", false, false, false, 39), "html", null, true);
            yield "</td>
                        <td>";
            // line 40
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["equipment"], "status", [], "any", false, false, false, 40), "html", null, true);
            yield "</td>
                        <td>";
            // line 41
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["equipment"], "purchaseDate", [], "any", false, false, false, 41)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["equipment"], "purchaseDate", [], "any", false, false, false, 41), "Y-m-d"), "html", null, true)) : ("-"));
            yield "</td>
                        <td class=\"actions\">
                            <a class=\"btn ghost\" href=\"";
            // line 43
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("equipment_show", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["equipment"], "id", [], "any", false, false, false, 43)]), "html", null, true);
            yield "\">View</a>
                            <a class=\"btn ghost\" href=\"";
            // line 44
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("equipment_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["equipment"], "id", [], "any", false, false, false, 44)]), "html", null, true);
            yield "\">Edit</a>
                        </td>
                    </tr>
                ";
            $context['_iterated'] = true;
        }
        // line 47
        if (!$context['_iterated']) {
            // line 48
            yield "                    <tr>
                        <td colspan=\"6\" class=\"empty\">No equipment yet.</td>
                    </tr>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['equipment'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 52
        yield "                </tbody>
            </table>
        </section>

        <a class=\"link\" href=\"";
        // line 56
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("home");
        yield "\">Back to homepage</a>
    </div>
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
        return "equipment/index.html.twig";
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
        return array (  145 => 56,  139 => 52,  130 => 48,  128 => 47,  120 => 44,  116 => 43,  111 => 41,  107 => 40,  103 => 39,  99 => 38,  95 => 37,  92 => 36,  87 => 35,  68 => 19,  53 => 7,  45 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>Equipment Management</title>
    <link rel=\"stylesheet\" href=\"{{ asset('assets/styles/equipment.css') }}\">
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
</head>
<body>
    <div class=\"page\">
        <header class=\"page-header\">
            <div>
                <p class=\"eyebrow\">Equipment Management</p>
                <h1>Track, update, and maintain your farm equipment.</h1>
            </div>
            <a class=\"btn primary\" href=\"{{ path('equipment_new') }}\">Add equipment</a>
        </header>

        <section class=\"card\">
            <table>
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
                {% for equipment in equipments %}
                    <tr>
                        <td>{{ equipment.id }}</td>
                        <td>{{ equipment.name }}</td>
                        <td>{{ equipment.type }}</td>
                        <td>{{ equipment.status }}</td>
                        <td>{{ equipment.purchaseDate ? equipment.purchaseDate|date('Y-m-d') : '-' }}</td>
                        <td class=\"actions\">
                            <a class=\"btn ghost\" href=\"{{ path('equipment_show', {'id': equipment.id}) }}\">View</a>
                            <a class=\"btn ghost\" href=\"{{ path('equipment_edit', {'id': equipment.id}) }}\">Edit</a>
                        </td>
                    </tr>
                {% else %}
                    <tr>
                        <td colspan=\"6\" class=\"empty\">No equipment yet.</td>
                    </tr>
                {% endfor %}
                </tbody>
            </table>
        </section>

        <a class=\"link\" href=\"{{ path('home') }}\">Back to homepage</a>
    </div>
</body>
</html>
", "equipment/index.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\equipment\\index.html.twig");
    }
}
