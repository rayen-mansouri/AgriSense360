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

/* admin/profile.html.twig */
class __TwigTemplate_0536d3e0e485ca36a0d3fe0a80f3f95c extends Template
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
            'body_state_class' => [$this, 'block_body_state_class'],
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
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/profile.html.twig"));

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

        yield "Profile Management";
        
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

        yield "Profile Management";
        
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

        yield "Administrator profile";
        
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

        yield "Technical account details and self-service profile updates for the current admin session.";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 7
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body_state_class(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body_state_class"));

        yield " profile-management-view";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 9
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 10
        yield "<section class=\"crud-section profile-page\">
    ";
        // line 11
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 11, $this->source); })()), "flashes", ["errors"], "method", false, false, false, 11));
        foreach ($context['_seq'] as $context["_key"] => $context["errors"]) {
            // line 12
            yield "        ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable($context["errors"]);
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 13
                yield "            <div class=\"form-warning\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
                yield "</div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 15
            yield "    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['errors'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        yield "    ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 16, $this->source); })()), "flashes", ["error"], "method", false, false, false, 16));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 17
            yield "        <div class=\"crud-card\" style=\"border-color: rgba(216, 74, 74, 0.35);\">
            <p style=\"color:#8c2121; font-weight:600;\">";
            // line 18
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "</p>
        </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        yield "    ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 21, $this->source); })()), "flashes", ["success"], "method", false, false, false, 21));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 22
            yield "        <div class=\"crud-card\" style=\"border-color: rgba(76, 170, 102, 0.35);\">
            <p style=\"color:#2d6e41; font-weight:600;\">";
            // line 23
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "</p>
        </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        yield "
    <div class=\"profile-layout\">
        <section class=\"crud-card profile-summary-card\">
            <div class=\"crud-head\">
                <div>
                    <h2>My profile</h2>
                    <p>Update your identity and keep your admin account current.</p>
                </div>
            </div>
            <div class=\"profile-summary-grid\">
                <div class=\"crud-list profile-summary-list\">
                    <table class=\"data-table profile-summary-table\">
                        <tbody>
                            <tr><th>Account ID</th><td>#US-";
        // line 39
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "id", [], "any", true, true, false, 39)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 39, $this->source); })()), "id", [], "any", false, false, false, 39), 0)) : (0)), "html", null, true);
        yield "</td></tr>
                            <tr><th>First name</th><td>";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "firstName", [], "any", true, true, false, 40)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 40, $this->source); })()), "firstName", [], "any", false, false, false, 40), "-")) : ("-")), "html", null, true);
        yield "</td></tr>
                            <tr><th>Last name</th><td>";
        // line 41
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "lastName", [], "any", true, true, false, 41)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 41, $this->source); })()), "lastName", [], "any", false, false, false, 41), "-")) : ("-")), "html", null, true);
        yield "</td></tr>
                            <tr><th>Email</th><td>";
        // line 42
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "email", [], "any", true, true, false, 42)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 42, $this->source); })()), "email", [], "any", false, false, false, 42), "-")) : ("-")), "html", null, true);
        yield "</td></tr>
                            <tr><th>Status</th><td><span class=\"status ok\">";
        // line 43
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "status", [], "any", true, true, false, 43)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 43, $this->source); })()), "status", [], "any", false, false, false, 43), "Active")) : ("Active")), "html", null, true);
        yield "</span></td></tr>
                            <tr><th>Role</th><td><span class=\"status warn\">";
        // line 44
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["technicalInfo"] ?? null), "roleLabel", [], "any", true, true, false, 44)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["technicalInfo"]) || array_key_exists("technicalInfo", $context) ? $context["technicalInfo"] : (function () { throw new RuntimeError('Variable "technicalInfo" does not exist.', 44, $this->source); })()), "roleLabel", [], "any", false, false, false, 44), "ADMIN")) : ("ADMIN")), "html", null, true);
        yield "</span></td></tr>
                            <tr><th>Created at</th><td>";
        // line 45
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 45, $this->source); })()), "createdAt", [], "any", false, false, false, 45)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 45, $this->source); })()), "createdAt", [], "any", false, false, false, 45), "Y-m-d"), "html", null, true)) : ("-"));
        yield "</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class=\"crud-form profile-form-card\">
                    <h3>Edit profile</h3>
                    <form method=\"post\" class=\"profile-form\" novalidate>
                        <div class=\"form-grid\">
                            <label class=\"field\">
                                <span>Nom</span>
                                <input class=\"input\" type=\"text\" name=\"last_name\" value=\"";
        // line 55
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "lastName", [], "any", true, true, false, 55)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 55, $this->source); })()), "lastName", [], "any", false, false, false, 55), "")) : ("")), "html", null, true);
        yield "\" required>
                            </label>
                            <label class=\"field\">
                                <span>Prenom</span>
                                <input class=\"input\" type=\"text\" name=\"first_name\" value=\"";
        // line 59
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "firstName", [], "any", true, true, false, 59)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 59, $this->source); })()), "firstName", [], "any", false, false, false, 59), "")) : ("")), "html", null, true);
        yield "\" required>
                            </label>
                            <label class=\"field profile-field-wide\">
                                <span>Email</span>
                                <input class=\"input\" type=\"email\" name=\"email\" value=\"";
        // line 63
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "email", [], "any", true, true, false, 63)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 63, $this->source); })()), "email", [], "any", false, false, false, 63), "")) : ("")), "html", null, true);
        yield "\" required>
                            </label>
                            <label class=\"field profile-field-wide\">
                                <span>Password</span>
                                <input class=\"input\" type=\"password\" name=\"password\" placeholder=\"Leave empty to keep current password\">
                            </label>
                        </div>
                        <div class=\"form-actions\">
                            <button class=\"primary\" type=\"submit\">Save profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class=\"crud-card profile-technical-card\">
            <div class=\"crud-head\">
                <div>
                    <h2>Technical info</h2>
                    <p>Session and platform details for this admin account.</p>
                </div>
            </div>
            <div class=\"crud-list profile-technical-list\">
                <table class=\"data-table profile-technical-table\">
                    <tbody>
                        <tr><th>Session role</th><td>";
        // line 88
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["technicalInfo"] ?? null), "sessionRole", [], "any", true, true, false, 88)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["technicalInfo"]) || array_key_exists("technicalInfo", $context) ? $context["technicalInfo"] : (function () { throw new RuntimeError('Variable "technicalInfo" does not exist.', 88, $this->source); })()), "sessionRole", [], "any", false, false, false, 88), "admin")) : ("admin")), "html", null, true);
        yield "</td></tr>
                        <tr><th>Session user ID</th><td>";
        // line 89
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["technicalInfo"] ?? null), "sessionUserId", [], "any", true, true, false, 89)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["technicalInfo"]) || array_key_exists("technicalInfo", $context) ? $context["technicalInfo"] : (function () { throw new RuntimeError('Variable "technicalInfo" does not exist.', 89, $this->source); })()), "sessionUserId", [], "any", false, false, false, 89), 0)) : (0)), "html", null, true);
        yield "</td></tr>
                        <tr><th>Active users</th><td>";
        // line 90
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["technicalInfo"] ?? null), "userCount", [], "any", true, true, false, 90)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["technicalInfo"]) || array_key_exists("technicalInfo", $context) ? $context["technicalInfo"] : (function () { throw new RuntimeError('Variable "technicalInfo" does not exist.', 90, $this->source); })()), "userCount", [], "any", false, false, false, 90), 0)) : (0)), "html", null, true);
        yield "</td></tr>
                        <tr><th>Equipment rows</th><td>";
        // line 91
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["technicalInfo"] ?? null), "equipmentCount", [], "any", true, true, false, 91)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["technicalInfo"]) || array_key_exists("technicalInfo", $context) ? $context["technicalInfo"] : (function () { throw new RuntimeError('Variable "technicalInfo" does not exist.', 91, $this->source); })()), "equipmentCount", [], "any", false, false, false, 91), 0)) : (0)), "html", null, true);
        yield "</td></tr>
                        <tr><th>Maintenance rows</th><td>";
        // line 92
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["technicalInfo"] ?? null), "maintenanceCount", [], "any", true, true, false, 92)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["technicalInfo"]) || array_key_exists("technicalInfo", $context) ? $context["technicalInfo"] : (function () { throw new RuntimeError('Variable "technicalInfo" does not exist.', 92, $this->source); })()), "maintenanceCount", [], "any", false, false, false, 92), 0)) : (0)), "html", null, true);
        yield "</td></tr>
                        <tr><th>Profile created</th><td>";
        // line 93
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["technicalInfo"] ?? null), "profileAge", [], "any", true, true, false, 93)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["technicalInfo"]) || array_key_exists("technicalInfo", $context) ? $context["technicalInfo"] : (function () { throw new RuntimeError('Variable "technicalInfo" does not exist.', 93, $this->source); })()), "profileAge", [], "any", false, false, false, 93), "-")) : ("-")), "html", null, true);
        yield "</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
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
        return "admin/profile.html.twig";
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
        return array (  332 => 93,  328 => 92,  324 => 91,  320 => 90,  316 => 89,  312 => 88,  284 => 63,  277 => 59,  270 => 55,  257 => 45,  253 => 44,  249 => 43,  245 => 42,  241 => 41,  237 => 40,  233 => 39,  218 => 26,  209 => 23,  206 => 22,  201 => 21,  192 => 18,  189 => 17,  184 => 16,  178 => 15,  169 => 13,  164 => 12,  160 => 11,  157 => 10,  147 => 9,  130 => 7,  113 => 6,  96 => 5,  79 => 4,  62 => 3,  45 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'admin/layout.html.twig' %}

{% block title %}Profile Management{% endblock %}
{% block eyebrow %}Profile Management{% endblock %}
{% block heading %}Administrator profile{% endblock %}
{% block subhead %}Technical account details and self-service profile updates for the current admin session.{% endblock %}
{% block body_state_class %} profile-management-view{% endblock %}

{% block body %}
<section class=\"crud-section profile-page\">
    {% for errors in app.flashes('errors') %}
        {% for message in errors %}
            <div class=\"form-warning\">{{ message }}</div>
        {% endfor %}
    {% endfor %}
    {% for message in app.flashes('error') %}
        <div class=\"crud-card\" style=\"border-color: rgba(216, 74, 74, 0.35);\">
            <p style=\"color:#8c2121; font-weight:600;\">{{ message }}</p>
        </div>
    {% endfor %}
    {% for message in app.flashes('success') %}
        <div class=\"crud-card\" style=\"border-color: rgba(76, 170, 102, 0.35);\">
            <p style=\"color:#2d6e41; font-weight:600;\">{{ message }}</p>
        </div>
    {% endfor %}

    <div class=\"profile-layout\">
        <section class=\"crud-card profile-summary-card\">
            <div class=\"crud-head\">
                <div>
                    <h2>My profile</h2>
                    <p>Update your identity and keep your admin account current.</p>
                </div>
            </div>
            <div class=\"profile-summary-grid\">
                <div class=\"crud-list profile-summary-list\">
                    <table class=\"data-table profile-summary-table\">
                        <tbody>
                            <tr><th>Account ID</th><td>#US-{{ currentUser.id|default(0) }}</td></tr>
                            <tr><th>First name</th><td>{{ currentUser.firstName|default('-') }}</td></tr>
                            <tr><th>Last name</th><td>{{ currentUser.lastName|default('-') }}</td></tr>
                            <tr><th>Email</th><td>{{ currentUser.email|default('-') }}</td></tr>
                            <tr><th>Status</th><td><span class=\"status ok\">{{ currentUser.status|default('Active') }}</span></td></tr>
                            <tr><th>Role</th><td><span class=\"status warn\">{{ technicalInfo.roleLabel|default('ADMIN') }}</span></td></tr>
                            <tr><th>Created at</th><td>{{ currentUser.createdAt ? currentUser.createdAt|date('Y-m-d') : '-' }}</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class=\"crud-form profile-form-card\">
                    <h3>Edit profile</h3>
                    <form method=\"post\" class=\"profile-form\" novalidate>
                        <div class=\"form-grid\">
                            <label class=\"field\">
                                <span>Nom</span>
                                <input class=\"input\" type=\"text\" name=\"last_name\" value=\"{{ currentUser.lastName|default('') }}\" required>
                            </label>
                            <label class=\"field\">
                                <span>Prenom</span>
                                <input class=\"input\" type=\"text\" name=\"first_name\" value=\"{{ currentUser.firstName|default('') }}\" required>
                            </label>
                            <label class=\"field profile-field-wide\">
                                <span>Email</span>
                                <input class=\"input\" type=\"email\" name=\"email\" value=\"{{ currentUser.email|default('') }}\" required>
                            </label>
                            <label class=\"field profile-field-wide\">
                                <span>Password</span>
                                <input class=\"input\" type=\"password\" name=\"password\" placeholder=\"Leave empty to keep current password\">
                            </label>
                        </div>
                        <div class=\"form-actions\">
                            <button class=\"primary\" type=\"submit\">Save profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class=\"crud-card profile-technical-card\">
            <div class=\"crud-head\">
                <div>
                    <h2>Technical info</h2>
                    <p>Session and platform details for this admin account.</p>
                </div>
            </div>
            <div class=\"crud-list profile-technical-list\">
                <table class=\"data-table profile-technical-table\">
                    <tbody>
                        <tr><th>Session role</th><td>{{ technicalInfo.sessionRole|default('admin') }}</td></tr>
                        <tr><th>Session user ID</th><td>{{ technicalInfo.sessionUserId|default(0) }}</td></tr>
                        <tr><th>Active users</th><td>{{ technicalInfo.userCount|default(0) }}</td></tr>
                        <tr><th>Equipment rows</th><td>{{ technicalInfo.equipmentCount|default(0) }}</td></tr>
                        <tr><th>Maintenance rows</th><td>{{ technicalInfo.maintenanceCount|default(0) }}</td></tr>
                        <tr><th>Profile created</th><td>{{ technicalInfo.profileAge|default('-') }}</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</section>
{% endblock %}", "admin/profile.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\admin\\profile.html.twig");
    }
}
