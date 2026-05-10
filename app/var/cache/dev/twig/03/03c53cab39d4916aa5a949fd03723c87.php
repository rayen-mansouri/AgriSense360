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

/* equipment/edit.html.twig */
class __TwigTemplate_e010447b3ff10d67d8211af7f3bbf090 extends Template
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
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "equipment/edit.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>Edit Equipment</title>
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
                <p class=\"eyebrow\">Edit Equipment</p>
                <h1>Update equipment details.</h1>
            </div>
        </header>

        <section class=\"card\">
            ";
        // line 22
        yield from $this->load("equipment/_form.html.twig", 22)->unwrap()->yield(CoreExtension::merge($context, ["button_label" => "Update"]));
        // line 23
        yield "        </section>

        <section class=\"inline-actions\">
            ";
        // line 26
        yield from $this->load("equipment/_delete_form.html.twig", 26)->unwrap()->yield($context);
        // line 27
        yield "            <a class=\"link\" href=\"";
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("equipment_index");
        yield "\">Back to list</a>
        </section>
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
        return "equipment/edit.html.twig";
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
        return array (  80 => 27,  78 => 26,  73 => 23,  71 => 22,  53 => 7,  45 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>Edit Equipment</title>
    <link rel=\"stylesheet\" href=\"{{ asset('assets/styles/equipment.css') }}\">
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
</head>
<body>
    <div class=\"page\">
        <header class=\"page-header\">
            <div>
                <p class=\"eyebrow\">Edit Equipment</p>
                <h1>Update equipment details.</h1>
            </div>
        </header>

        <section class=\"card\">
            {% include 'equipment/_form.html.twig' with {'button_label': 'Update'} %}
        </section>

        <section class=\"inline-actions\">
            {% include 'equipment/_delete_form.html.twig' %}
            <a class=\"link\" href=\"{{ path('equipment_index') }}\">Back to list</a>
        </section>
    </div>
</body>
</html>
", "equipment/edit.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\equipment\\edit.html.twig");
    }
}
