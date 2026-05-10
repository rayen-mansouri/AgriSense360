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

/* equipment/show.html.twig */
class __TwigTemplate_3909156b325b42d05bae67757d977cc7 extends Template
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
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "equipment/show.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>Equipment Details</title>
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
                <p class=\"eyebrow\">Equipment Details</p>
                <h1>";
        // line 17
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 17, $this->source); })()), "name", [], "any", false, false, false, 17), "html", null, true);
        yield "</h1>
            </div>
            <div class=\"actions\">
                <a class=\"btn ghost\" href=\"";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("equipment_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 20, $this->source); })()), "id", [], "any", false, false, false, 20)]), "html", null, true);
        yield "\">Edit</a>
                ";
        // line 21
        yield from $this->load("equipment/_delete_form.html.twig", 21)->unwrap()->yield($context);
        // line 22
        yield "            </div>
        </header>

        <section class=\"card\">
            <dl class=\"details\">
                <div>
                    <dt>ID</dt>
                    <dd>";
        // line 29
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 29, $this->source); })()), "id", [], "any", false, false, false, 29), "html", null, true);
        yield "</dd>
                </div>
                <div>
                    <dt>Name</dt>
                    <dd>";
        // line 33
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 33, $this->source); })()), "name", [], "any", false, false, false, 33), "html", null, true);
        yield "</dd>
                </div>
                <div>
                    <dt>Type</dt>
                    <dd>";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 37, $this->source); })()), "type", [], "any", false, false, false, 37), "html", null, true);
        yield "</dd>
                </div>
                <div>
                    <dt>Status</dt>
                    <dd>";
        // line 41
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 41, $this->source); })()), "status", [], "any", false, false, false, 41), "html", null, true);
        yield "</dd>
                </div>
                <div>
                    <dt>Purchase Date</dt>
                    <dd>";
        // line 45
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 45, $this->source); })()), "purchaseDate", [], "any", false, false, false, 45)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["equipment"]) || array_key_exists("equipment", $context) ? $context["equipment"] : (function () { throw new RuntimeError('Variable "equipment" does not exist.', 45, $this->source); })()), "purchaseDate", [], "any", false, false, false, 45), "Y-m-d"), "html", null, true)) : ("-"));
        yield "</dd>
                </div>
            </dl>
        </section>

        <a class=\"link\" href=\"";
        // line 50
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("equipment_index");
        yield "\">Back to list</a>
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
        return "equipment/show.html.twig";
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
        return array (  123 => 50,  115 => 45,  108 => 41,  101 => 37,  94 => 33,  87 => 29,  78 => 22,  76 => 21,  72 => 20,  66 => 17,  53 => 7,  45 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>Equipment Details</title>
    <link rel=\"stylesheet\" href=\"{{ asset('assets/styles/equipment.css') }}\">
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
</head>
<body>
    <div class=\"page\">
        <header class=\"page-header\">
            <div>
                <p class=\"eyebrow\">Equipment Details</p>
                <h1>{{ equipment.name }}</h1>
            </div>
            <div class=\"actions\">
                <a class=\"btn ghost\" href=\"{{ path('equipment_edit', {'id': equipment.id}) }}\">Edit</a>
                {% include 'equipment/_delete_form.html.twig' %}
            </div>
        </header>

        <section class=\"card\">
            <dl class=\"details\">
                <div>
                    <dt>ID</dt>
                    <dd>{{ equipment.id }}</dd>
                </div>
                <div>
                    <dt>Name</dt>
                    <dd>{{ equipment.name }}</dd>
                </div>
                <div>
                    <dt>Type</dt>
                    <dd>{{ equipment.type }}</dd>
                </div>
                <div>
                    <dt>Status</dt>
                    <dd>{{ equipment.status }}</dd>
                </div>
                <div>
                    <dt>Purchase Date</dt>
                    <dd>{{ equipment.purchaseDate ? equipment.purchaseDate|date('Y-m-d') : '-' }}</dd>
                </div>
            </dl>
        </section>

        <a class=\"link\" href=\"{{ path('equipment_index') }}\">Back to list</a>
    </div>
</body>
</html>
", "equipment/show.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\equipment\\show.html.twig");
    }
}
