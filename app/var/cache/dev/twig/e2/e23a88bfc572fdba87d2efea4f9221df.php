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

/* management/users.html.twig */
class __TwigTemplate_57bea22000071e9227703922ad4aff7a extends Template
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
            'body_state_class' => [$this, 'block_body_state_class'],
            'eyebrow' => [$this, 'block_eyebrow'],
            'heading' => [$this, 'block_heading'],
            'subhead' => [$this, 'block_subhead'],
            'body' => [$this, 'block_body'],
            'scripts' => [$this, 'block_scripts'],
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
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "management/users.html.twig"));

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

        if ((($tmp = ((array_key_exists("adminMode", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 3, $this->source); })()), false)) : (false))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "User Management";
        } else {
            yield "Profile";
        }
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 4
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body_state_class(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body_state_class"));

        if ((($tmp = ((array_key_exists("adminMode", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 4, $this->source); })()), false)) : (false))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " users-management-view";
        }
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_eyebrow(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "eyebrow"));

        if ((($tmp = ((array_key_exists("adminMode", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 5, $this->source); })()), false)) : (false))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "User Management";
        } else {
            yield "Profile";
        }
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 6
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_heading(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "heading"));

        if ((($tmp = ((array_key_exists("adminMode", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 6, $this->source); })()), false)) : (false))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "Users, access, and roles";
        } else {
            yield "My account profile";
        }
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 7
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_subhead(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "subhead"));

        if ((($tmp = ((array_key_exists("adminMode", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 7, $this->source); })()), false)) : (false))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "Manage all user accounts, role assignments, and status analytics from one console.";
        } else {
            yield "View and update your account information.";
        }
        
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
        yield "<section class=\"crud-section\">
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
    ";
        // line 27
        if ((($tmp =  !((array_key_exists("adminMode", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 27, $this->source); })()), false)) : (false))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 28
            yield "    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>My Profile</h2>
                <p>General profile information and credentials.</p>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <span class=\"pill\">1 profile</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#US-";
            // line 53
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "id", [], "any", true, true, false, 53)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 53, $this->source); })()), "id", [], "any", false, false, false, 53), 0)) : (0)), "html", null, true);
            yield "</td>
                            <td>";
            // line 54
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "lastName", [], "any", true, true, false, 54)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 54, $this->source); })()), "lastName", [], "any", false, false, false, 54), "-")) : ("-")), "html", null, true);
            yield "</td>
                            <td>";
            // line 55
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "firstName", [], "any", true, true, false, 55)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 55, $this->source); })()), "firstName", [], "any", false, false, false, 55), "-")) : ("-")), "html", null, true);
            yield "</td>
                            <td>";
            // line 56
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "email", [], "any", true, true, false, 56)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 56, $this->source); })()), "email", [], "any", false, false, false, 56), "-")) : ("-")), "html", null, true);
            yield "</td>
                            <td><span class=\"status ok\">";
            // line 57
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "status", [], "any", true, true, false, 57)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 57, $this->source); })()), "status", [], "any", false, false, false, 57), "Active")) : ("Active")), "html", null, true);
            yield "</span></td>
                            <td>
                                <span class=\"link\">Profile</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Update My Profile</h3>
                <form method=\"post\" novalidate>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Nom</span>
                            <input class=\"input\" type=\"text\" name=\"last_name\" value=\"";
            // line 71
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "lastName", [], "any", true, true, false, 71)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 71, $this->source); })()), "lastName", [], "any", false, false, false, 71), "")) : ("")), "html", null, true);
            yield "\" required>
                        </label>
                        <label class=\"field\">
                            <span>Prenom</span>
                            <input class=\"input\" type=\"text\" name=\"first_name\" value=\"";
            // line 75
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "firstName", [], "any", true, true, false, 75)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 75, $this->source); })()), "firstName", [], "any", false, false, false, 75), "")) : ("")), "html", null, true);
            yield "\" required>
                        </label>
                        <label class=\"field\">
                            <span>Email</span>
                            <input class=\"input\" type=\"email\" name=\"email\" value=\"";
            // line 79
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "email", [], "any", true, true, false, 79)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 79, $this->source); })()), "email", [], "any", false, false, false, 79), "")) : ("")), "html", null, true);
            yield "\" required>
                        </label>
                        <label class=\"field\">
                            <span>New Password</span>
                            <input class=\"input\" type=\"password\" name=\"password\" placeholder=\"Leave empty to keep current password\">
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    ";
        } else {
            // line 94
            yield "
    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>User Analytics</h2>
                <p>Quick stats and distribution for all accounts.</p>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <span class=\"pill\">";
            // line 105
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["userStats"] ?? null), "total", [], "any", true, true, false, 105)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["userStats"]) || array_key_exists("userStats", $context) ? $context["userStats"] : (function () { throw new RuntimeError('Variable "userStats" does not exist.', 105, $this->source); })()), "total", [], "any", false, false, false, 105), 0)) : (0)), "html", null, true);
            yield " total</span>
                </div>
                <table class=\"data-table\">
                    <tbody>
                        <tr><th>Total Users</th><td>";
            // line 109
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["userStats"] ?? null), "total", [], "any", true, true, false, 109)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["userStats"]) || array_key_exists("userStats", $context) ? $context["userStats"] : (function () { throw new RuntimeError('Variable "userStats" does not exist.', 109, $this->source); })()), "total", [], "any", false, false, false, 109), 0)) : (0)), "html", null, true);
            yield "</td></tr>
                        <tr><th>Admins</th><td>";
            // line 110
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["userStats"] ?? null), "admins", [], "any", true, true, false, 110)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["userStats"]) || array_key_exists("userStats", $context) ? $context["userStats"] : (function () { throw new RuntimeError('Variable "userStats" does not exist.', 110, $this->source); })()), "admins", [], "any", false, false, false, 110), 0)) : (0)), "html", null, true);
            yield "</td></tr>
                        <tr><th>Normal Users</th><td>";
            // line 111
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["userStats"] ?? null), "normal", [], "any", true, true, false, 111)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["userStats"]) || array_key_exists("userStats", $context) ? $context["userStats"] : (function () { throw new RuntimeError('Variable "userStats" does not exist.', 111, $this->source); })()), "normal", [], "any", false, false, false, 111), 0)) : (0)), "html", null, true);
            yield "</td></tr>
                        <tr><th>Active</th><td>";
            // line 112
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["userStats"] ?? null), "active", [], "any", true, true, false, 112)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["userStats"]) || array_key_exists("userStats", $context) ? $context["userStats"] : (function () { throw new RuntimeError('Variable "userStats" does not exist.', 112, $this->source); })()), "active", [], "any", false, false, false, 112), 0)) : (0)), "html", null, true);
            yield "</td></tr>
                        <tr><th>Pending</th><td>";
            // line 113
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["userStats"] ?? null), "pending", [], "any", true, true, false, 113)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["userStats"]) || array_key_exists("userStats", $context) ? $context["userStats"] : (function () { throw new RuntimeError('Variable "userStats" does not exist.', 113, $this->source); })()), "pending", [], "any", false, false, false, 113), 0)) : (0)), "html", null, true);
            yield "</td></tr>
                        <tr><th>Suspended</th><td>";
            // line 114
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["userStats"] ?? null), "suspended", [], "any", true, true, false, 114)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["userStats"]) || array_key_exists("userStats", $context) ? $context["userStats"] : (function () { throw new RuntimeError('Variable "userStats" does not exist.', 114, $this->source); })()), "suspended", [], "any", false, false, false, 114), 0)) : (0)), "html", null, true);
            yield "</td></tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Role / Status Distribution</h3>
                ";
            // line 120
            $context["totalUsers"] = (((((CoreExtension::getAttribute($this->env, $this->source, ($context["userStats"] ?? null), "total", [], "any", true, true, false, 120)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["userStats"]) || array_key_exists("userStats", $context) ? $context["userStats"] : (function () { throw new RuntimeError('Variable "userStats" does not exist.', 120, $this->source); })()), "total", [], "any", false, false, false, 120), 0)) : (0)) > 0)) ? (CoreExtension::getAttribute($this->env, $this->source, (isset($context["userStats"]) || array_key_exists("userStats", $context) ? $context["userStats"] : (function () { throw new RuntimeError('Variable "userStats" does not exist.', 120, $this->source); })()), "total", [], "any", false, false, false, 120)) : (1));
            // line 121
            yield "                ";
            $context["adminWidth"] = Twig\Extension\CoreExtension::round(((((CoreExtension::getAttribute($this->env, $this->source, ($context["userStats"] ?? null), "admins", [], "any", true, true, false, 121)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["userStats"]) || array_key_exists("userStats", $context) ? $context["userStats"] : (function () { throw new RuntimeError('Variable "userStats" does not exist.', 121, $this->source); })()), "admins", [], "any", false, false, false, 121), 0)) : (0)) / (isset($context["totalUsers"]) || array_key_exists("totalUsers", $context) ? $context["totalUsers"] : (function () { throw new RuntimeError('Variable "totalUsers" does not exist.', 121, $this->source); })())) * 100), 1);
            // line 122
            yield "                ";
            $context["normalWidth"] = Twig\Extension\CoreExtension::round(((((CoreExtension::getAttribute($this->env, $this->source, ($context["userStats"] ?? null), "normal", [], "any", true, true, false, 122)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["userStats"]) || array_key_exists("userStats", $context) ? $context["userStats"] : (function () { throw new RuntimeError('Variable "userStats" does not exist.', 122, $this->source); })()), "normal", [], "any", false, false, false, 122), 0)) : (0)) / (isset($context["totalUsers"]) || array_key_exists("totalUsers", $context) ? $context["totalUsers"] : (function () { throw new RuntimeError('Variable "totalUsers" does not exist.', 122, $this->source); })())) * 100), 1);
            // line 123
            yield "                ";
            $context["activeWidth"] = Twig\Extension\CoreExtension::round(((((CoreExtension::getAttribute($this->env, $this->source, ($context["userStats"] ?? null), "active", [], "any", true, true, false, 123)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["userStats"]) || array_key_exists("userStats", $context) ? $context["userStats"] : (function () { throw new RuntimeError('Variable "userStats" does not exist.', 123, $this->source); })()), "active", [], "any", false, false, false, 123), 0)) : (0)) / (isset($context["totalUsers"]) || array_key_exists("totalUsers", $context) ? $context["totalUsers"] : (function () { throw new RuntimeError('Variable "totalUsers" does not exist.', 123, $this->source); })())) * 100), 1);
            // line 124
            yield "                ";
            $context["pendingWidth"] = Twig\Extension\CoreExtension::round(((((CoreExtension::getAttribute($this->env, $this->source, ($context["userStats"] ?? null), "pending", [], "any", true, true, false, 124)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["userStats"]) || array_key_exists("userStats", $context) ? $context["userStats"] : (function () { throw new RuntimeError('Variable "userStats" does not exist.', 124, $this->source); })()), "pending", [], "any", false, false, false, 124), 0)) : (0)) / (isset($context["totalUsers"]) || array_key_exists("totalUsers", $context) ? $context["totalUsers"] : (function () { throw new RuntimeError('Variable "totalUsers" does not exist.', 124, $this->source); })())) * 100), 1);
            // line 125
            yield "                ";
            $context["suspendedWidth"] = Twig\Extension\CoreExtension::round(((((CoreExtension::getAttribute($this->env, $this->source, ($context["userStats"] ?? null), "suspended", [], "any", true, true, false, 125)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["userStats"]) || array_key_exists("userStats", $context) ? $context["userStats"] : (function () { throw new RuntimeError('Variable "userStats" does not exist.', 125, $this->source); })()), "suspended", [], "any", false, false, false, 125), 0)) : (0)) / (isset($context["totalUsers"]) || array_key_exists("totalUsers", $context) ? $context["totalUsers"] : (function () { throw new RuntimeError('Variable "totalUsers" does not exist.', 125, $this->source); })())) * 100), 1);
            // line 126
            yield "                <div style=\"display:grid; gap:12px;\">
                    <div>
                        <p style=\"margin-bottom:6px;\">Admins ";
            // line 128
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["adminWidth"]) || array_key_exists("adminWidth", $context) ? $context["adminWidth"] : (function () { throw new RuntimeError('Variable "adminWidth" does not exist.', 128, $this->source); })()), "html", null, true);
            yield "%</p>
                        <div style=\"height:10px; background:#e9e3d8; border-radius:999px;\"><span style=\"display:block; height:10px; width:";
            // line 129
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["adminWidth"]) || array_key_exists("adminWidth", $context) ? $context["adminWidth"] : (function () { throw new RuntimeError('Variable "adminWidth" does not exist.', 129, $this->source); })()), "html", null, true);
            yield "%; background:#7b8cc5; border-radius:999px;\"></span></div>
                    </div>
                    <div>
                        <p style=\"margin-bottom:6px;\">Normal ";
            // line 132
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["normalWidth"]) || array_key_exists("normalWidth", $context) ? $context["normalWidth"] : (function () { throw new RuntimeError('Variable "normalWidth" does not exist.', 132, $this->source); })()), "html", null, true);
            yield "%</p>
                        <div style=\"height:10px; background:#e9e3d8; border-radius:999px;\"><span style=\"display:block; height:10px; width:";
            // line 133
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["normalWidth"]) || array_key_exists("normalWidth", $context) ? $context["normalWidth"] : (function () { throw new RuntimeError('Variable "normalWidth" does not exist.', 133, $this->source); })()), "html", null, true);
            yield "%; background:#69ad7a; border-radius:999px;\"></span></div>
                    </div>
                    <div>
                        <p style=\"margin-bottom:6px;\">Active ";
            // line 136
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["activeWidth"]) || array_key_exists("activeWidth", $context) ? $context["activeWidth"] : (function () { throw new RuntimeError('Variable "activeWidth" does not exist.', 136, $this->source); })()), "html", null, true);
            yield "%</p>
                        <div style=\"height:10px; background:#e9e3d8; border-radius:999px;\"><span style=\"display:block; height:10px; width:";
            // line 137
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["activeWidth"]) || array_key_exists("activeWidth", $context) ? $context["activeWidth"] : (function () { throw new RuntimeError('Variable "activeWidth" does not exist.', 137, $this->source); })()), "html", null, true);
            yield "%; background:#57a565; border-radius:999px;\"></span></div>
                    </div>
                    <div>
                        <p style=\"margin-bottom:6px;\">Pending ";
            // line 140
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["pendingWidth"]) || array_key_exists("pendingWidth", $context) ? $context["pendingWidth"] : (function () { throw new RuntimeError('Variable "pendingWidth" does not exist.', 140, $this->source); })()), "html", null, true);
            yield "%</p>
                        <div style=\"height:10px; background:#e9e3d8; border-radius:999px;\"><span style=\"display:block; height:10px; width:";
            // line 141
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["pendingWidth"]) || array_key_exists("pendingWidth", $context) ? $context["pendingWidth"] : (function () { throw new RuntimeError('Variable "pendingWidth" does not exist.', 141, $this->source); })()), "html", null, true);
            yield "%; background:#d8ac4e; border-radius:999px;\"></span></div>
                    </div>
                    <div>
                        <p style=\"margin-bottom:6px;\">Suspended ";
            // line 144
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["suspendedWidth"]) || array_key_exists("suspendedWidth", $context) ? $context["suspendedWidth"] : (function () { throw new RuntimeError('Variable "suspendedWidth" does not exist.', 144, $this->source); })()), "html", null, true);
            yield "%</p>
                        <div style=\"height:10px; background:#e9e3d8; border-radius:999px;\"><span style=\"display:block; height:10px; width:";
            // line 145
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["suspendedWidth"]) || array_key_exists("suspendedWidth", $context) ? $context["suspendedWidth"] : (function () { throw new RuntimeError('Variable "suspendedWidth" does not exist.', 145, $this->source); })()), "html", null, true);
            yield "%; background:#cb6464; border-radius:999px;\"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Admin Profile</h2>
                <p>Your administrator identity in this portal.</p>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#US-";
            // line 173
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "id", [], "any", true, true, false, 173)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 173, $this->source); })()), "id", [], "any", false, false, false, 173), 0)) : (0)), "html", null, true);
            yield "</td>
                            <td>";
            // line 174
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "lastName", [], "any", true, true, false, 174)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 174, $this->source); })()), "lastName", [], "any", false, false, false, 174), "-")) : ("-")), "html", null, true);
            yield "</td>
                            <td>";
            // line 175
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "firstName", [], "any", true, true, false, 175)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 175, $this->source); })()), "firstName", [], "any", false, false, false, 175), "-")) : ("-")), "html", null, true);
            yield "</td>
                            <td>";
            // line 176
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "email", [], "any", true, true, false, 176)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 176, $this->source); })()), "email", [], "any", false, false, false, 176), "-")) : ("-")), "html", null, true);
            yield "</td>
                            <td><span class=\"status ok\">";
            // line 177
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "roleName", [], "any", true, true, false, 177)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 177, $this->source); })()), "roleName", [], "any", false, false, false, 177), "ADMIN")) : ("ADMIN")), "html", null, true);
            yield "</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\" style=\"display:flex; align-items:center;\">
                <p>Admin profile is managed from the dedicated profile page. Use the section below to manage all users and role permissions.</p>
            </div>
        </div>
    </div>

    <div class=\"crud-card users-accounts-card\">
        <div class=\"crud-head\">
            <div>
                <h2>All User Accounts</h2>
                <p>Create, edit, delete, and change roles/status for any account.</p>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" id=\"users-search\" type=\"search\" placeholder=\"Search users\" autocomplete=\"off\">
                    <select class=\"input\" id=\"users-search-column\">
                        <option value=\"all\">All columns</option>
                        <option value=\"id\">Id</option>
                        <option value=\"lastName\">Nom</option>
                        <option value=\"firstName\">Prenom</option>
                        <option value=\"email\">Email</option>
                        <option value=\"status\">Statut</option>
                        <option value=\"role\">Role</option>
                    </select>
                    <span class=\"pill\">";
            // line 208
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["users"]) || array_key_exists("users", $context) ? $context["users"] : (function () { throw new RuntimeError('Variable "users" does not exist.', 208, $this->source); })())), "html", null, true);
            yield " records</span>
                </div>
                <div class=\"table-scroll users-table-scroll\">
                    <table class=\"data-table users-data-table\">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Email</th>
                                <th>Statut</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id=\"users-table-body\">
                            ";
            // line 224
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(((array_key_exists("users", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["users"]) || array_key_exists("users", $context) ? $context["users"] : (function () { throw new RuntimeError('Variable "users" does not exist.', 224, $this->source); })()), [])) : ([])));
            $context['_iterated'] = false;
            foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
                // line 225
                yield "                                <tr data-id=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", true, true, false, 225)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 225), "")) : ("")), "html_attr");
                yield "\" data-last-name=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["user"], "lastName", [], "any", true, true, false, 225)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "lastName", [], "any", false, false, false, 225), "")) : (""))), "html_attr");
                yield "\" data-first-name=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["user"], "firstName", [], "any", true, true, false, 225)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "firstName", [], "any", false, false, false, 225), "")) : (""))), "html_attr");
                yield "\" data-email=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["user"], "email", [], "any", true, true, false, 225)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "email", [], "any", false, false, false, 225), "")) : (""))), "html_attr");
                yield "\" data-status=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["user"], "status", [], "any", true, true, false, 225)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "status", [], "any", false, false, false, 225), "")) : (""))), "html_attr");
                yield "\" data-role=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), ((CoreExtension::getAttribute($this->env, $this->source, $context["user"], "roleName", [], "any", true, true, false, 225)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "roleName", [], "any", false, false, false, 225), "")) : (""))), "html_attr");
                yield "\">
                                    <td>#US-";
                // line 226
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 226), "html", null, true);
                yield "</td>
                                    <td>";
                // line 227
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "lastName", [], "any", false, false, false, 227), "html", null, true);
                yield "</td>
                                    <td>";
                // line 228
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "firstName", [], "any", false, false, false, 228), "html", null, true);
                yield "</td>
                                    <td>";
                // line 229
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "email", [], "any", false, false, false, 229), "html", null, true);
                yield "</td>
                                    <td><span class=\"status ";
                // line 230
                yield (((Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["user"], "status", [], "any", false, false, false, 230)) == "active")) ? ("ok") : ("warn"));
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "status", [], "any", false, false, false, 230), "html", null, true);
                yield "</span></td>
                                    <td><span class=\"status ";
                // line 231
                yield ((CoreExtension::matches("/ADMIN/", Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["user"], "roleName", [], "any", false, false, false, 231)))) ? ("warn") : ("ok"));
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "roleName", [], "any", false, false, false, 231), "html", null, true);
                yield "</span></td>
                                    <td>
                                        <button
                                            class=\"link\"
                                            type=\"button\"
                                            data-edit-user
                                            data-id=\"";
                // line 237
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 237), "html", null, true);
                yield "\"
                                            data-last-name=\"";
                // line 238
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "lastName", [], "any", false, false, false, 238), "html", null, true);
                yield "\"
                                            data-first-name=\"";
                // line 239
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "firstName", [], "any", false, false, false, 239), "html", null, true);
                yield "\"
                                            data-email=\"";
                // line 240
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "email", [], "any", false, false, false, 240), "html", null, true);
                yield "\"
                                            data-status=\"";
                // line 241
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "status", [], "any", false, false, false, 241), "html", null, true);
                yield "\"
                                            data-role=\"";
                // line 242
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "roleName", [], "any", false, false, false, 242), "html", null, true);
                yield "\"
                                        >Edit</button>
                                        <form method=\"post\" style=\"display:inline;\">
                                            <input type=\"hidden\" name=\"user_action\" value=\"delete\">
                                            <input type=\"hidden\" name=\"id\" value=\"";
                // line 246
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 246), "html", null, true);
                yield "\">
                                            <button class=\"link danger\" type=\"submit\" ";
                // line 247
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 247) == ((CoreExtension::getAttribute($this->env, $this->source, ($context["currentUser"] ?? null), "id", [], "any", true, true, false, 247)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 247, $this->source); })()), "id", [], "any", false, false, false, 247), 0)) : (0)))) {
                    yield "disabled";
                }
                yield ">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            ";
                $context['_iterated'] = true;
            }
            // line 251
            if (!$context['_iterated']) {
                // line 252
                yield "                                <tr>
                                    <td colspan=\"7\">No users found.</td>
                                </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['user'], $context['_parent'], $context['_iterated']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 256
            yield "                        </tbody>
                    </table>
                </div>
            </div>
            <div class=\"crud-form\">
                <h3>Create / Update user</h3>
                <form method=\"post\" id=\"user-account-form\" novalidate>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>User ID (for update)</span>
                            <input class=\"input\" type=\"number\" id=\"user-form-id\" name=\"id\" placeholder=\"Leave empty to create\">
                        </label>
                        <label class=\"field\">
                            <span>Nom</span>
                            <input class=\"input\" type=\"text\" id=\"user-form-last-name\" name=\"last_name\" placeholder=\"Last name\" required>
                        </label>
                        <label class=\"field\">
                            <span>Prenom</span>
                            <input class=\"input\" type=\"text\" id=\"user-form-first-name\" name=\"first_name\" placeholder=\"First name\" required>
                        </label>
                        <label class=\"field\">
                            <span>Email</span>
                            <input class=\"input\" type=\"email\" id=\"user-form-email\" name=\"email\" placeholder=\"email@domain.tn\" required>
                        </label>
                        <label class=\"field\">
                            <span>Password</span>
                            <input class=\"input\" type=\"password\" id=\"user-form-password\" name=\"password\" placeholder=\"Optional on update\">
                        </label>
                        <label class=\"field\">
                            <span>Status</span>
                            <select class=\"input\" id=\"user-form-status\" name=\"status\">
                                <option>Active</option>
                                <option>Pending</option>
                                <option>Suspended</option>
                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Role</span>
                            <select class=\"input\" id=\"user-form-role\" name=\"role_name\">
                                <option value=\"USER\">USER</option>
                                <option value=\"ADMIN\">ADMIN</option>
                            </select>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\" name=\"user_action\" value=\"create\">Create</button>
                        <button class=\"ghost\" type=\"submit\" name=\"user_action\" value=\"update\" id=\"user-update-button\">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    ";
        }
        // line 309
        yield "</section>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 312
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "scripts"));

        // line 313
        yield "    ";
        yield from $this->yieldParentBlock("scripts", $context, $blocks);
        yield "
    ";
        // line 314
        if ((($tmp = ((array_key_exists("adminMode", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["adminMode"]) || array_key_exists("adminMode", $context) ? $context["adminMode"] : (function () { throw new RuntimeError('Variable "adminMode" does not exist.', 314, $this->source); })()), false)) : (false))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 315
            yield "    <script>
        (function () {
            const form = document.getElementById('user-account-form');
            if (!form) {
                return;
            }

            const idInput = document.getElementById('user-form-id');
            const lastNameInput = document.getElementById('user-form-last-name');
            const firstNameInput = document.getElementById('user-form-first-name');
            const emailInput = document.getElementById('user-form-email');
            const passwordInput = document.getElementById('user-form-password');
            const statusSelect = document.getElementById('user-form-status');
            const roleSelect = document.getElementById('user-form-role');
            const updateButton = document.getElementById('user-update-button');
            const usersSearchInput = document.getElementById('users-search');
            const usersSearchColumn = document.getElementById('users-search-column');
            const usersRows = Array.from(document.querySelectorAll('#users-table-body tr'));

            function applyUsersSearch() {
                if (!usersSearchInput || !usersRows.length) {
                    return;
                }

                const query = usersSearchInput.value.trim().toLowerCase();
                const column = usersSearchColumn ? usersSearchColumn.value : 'all';

                usersRows.forEach((row) => {
                    const haystack = column === 'all'
                        ? row.textContent.toLowerCase()
                        : String(row.dataset[column] || '').toLowerCase();
                    row.style.display = haystack.includes(query) ? '' : 'none';
                });
            }

            if (usersSearchInput) {
                usersSearchInput.addEventListener('input', applyUsersSearch);
            }

            if (usersSearchColumn) {
                usersSearchColumn.addEventListener('change', applyUsersSearch);
            }

            document.querySelectorAll('[data-edit-user]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    idInput.value = btn.dataset.id || '';
                    lastNameInput.value = btn.dataset.lastName || '';
                    firstNameInput.value = btn.dataset.firstName || '';
                    emailInput.value = btn.dataset.email || '';
                    statusSelect.value = btn.dataset.status || 'Active';
                    roleSelect.value = (btn.dataset.role || 'USER').toUpperCase().includes('ADMIN') ? 'ADMIN' : 'USER';
                    passwordInput.value = '';
                    form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    updateButton.focus();
                });
            });
        })();
    </script>
    ";
        }
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "management/users.html.twig";
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
        return array (  734 => 315,  732 => 314,  727 => 313,  717 => 312,  708 => 309,  653 => 256,  644 => 252,  642 => 251,  631 => 247,  627 => 246,  620 => 242,  616 => 241,  612 => 240,  608 => 239,  604 => 238,  600 => 237,  589 => 231,  583 => 230,  579 => 229,  575 => 228,  571 => 227,  567 => 226,  552 => 225,  547 => 224,  528 => 208,  494 => 177,  490 => 176,  486 => 175,  482 => 174,  478 => 173,  447 => 145,  443 => 144,  437 => 141,  433 => 140,  427 => 137,  423 => 136,  417 => 133,  413 => 132,  407 => 129,  403 => 128,  399 => 126,  396 => 125,  393 => 124,  390 => 123,  387 => 122,  384 => 121,  382 => 120,  373 => 114,  369 => 113,  365 => 112,  361 => 111,  357 => 110,  353 => 109,  346 => 105,  333 => 94,  315 => 79,  308 => 75,  301 => 71,  284 => 57,  280 => 56,  276 => 55,  272 => 54,  268 => 53,  241 => 28,  239 => 27,  236 => 26,  227 => 23,  224 => 22,  219 => 21,  210 => 18,  207 => 17,  202 => 16,  196 => 15,  187 => 13,  182 => 12,  178 => 11,  175 => 10,  165 => 9,  144 => 7,  123 => 6,  102 => 5,  83 => 4,  62 => 3,  46 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends adminMode|default(false) ? 'admin/layout.html.twig' : 'management/layout.html.twig' %}

{% block title %}{% if adminMode|default(false) %}User Management{% else %}Profile{% endif %}{% endblock %}
{% block body_state_class %}{% if adminMode|default(false) %} users-management-view{% endif %}{% endblock %}
{% block eyebrow %}{% if adminMode|default(false) %}User Management{% else %}Profile{% endif %}{% endblock %}
{% block heading %}{% if adminMode|default(false) %}Users, access, and roles{% else %}My account profile{% endif %}{% endblock %}
{% block subhead %}{% if adminMode|default(false) %}Manage all user accounts, role assignments, and status analytics from one console.{% else %}View and update your account information.{% endif %}{% endblock %}

{% block body %}
<section class=\"crud-section\">
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

    {% if not adminMode|default(false) %}
    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>My Profile</h2>
                <p>General profile information and credentials.</p>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <span class=\"pill\">1 profile</span>
                </div>
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#US-{{ currentUser.id|default(0) }}</td>
                            <td>{{ currentUser.lastName|default('-') }}</td>
                            <td>{{ currentUser.firstName|default('-') }}</td>
                            <td>{{ currentUser.email|default('-') }}</td>
                            <td><span class=\"status ok\">{{ currentUser.status|default('Active') }}</span></td>
                            <td>
                                <span class=\"link\">Profile</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Update My Profile</h3>
                <form method=\"post\" novalidate>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>Nom</span>
                            <input class=\"input\" type=\"text\" name=\"last_name\" value=\"{{ currentUser.lastName|default('') }}\" required>
                        </label>
                        <label class=\"field\">
                            <span>Prenom</span>
                            <input class=\"input\" type=\"text\" name=\"first_name\" value=\"{{ currentUser.firstName|default('') }}\" required>
                        </label>
                        <label class=\"field\">
                            <span>Email</span>
                            <input class=\"input\" type=\"email\" name=\"email\" value=\"{{ currentUser.email|default('') }}\" required>
                        </label>
                        <label class=\"field\">
                            <span>New Password</span>
                            <input class=\"input\" type=\"password\" name=\"password\" placeholder=\"Leave empty to keep current password\">
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {% else %}

    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>User Analytics</h2>
                <p>Quick stats and distribution for all accounts.</p>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <span class=\"pill\">{{ userStats.total|default(0) }} total</span>
                </div>
                <table class=\"data-table\">
                    <tbody>
                        <tr><th>Total Users</th><td>{{ userStats.total|default(0) }}</td></tr>
                        <tr><th>Admins</th><td>{{ userStats.admins|default(0) }}</td></tr>
                        <tr><th>Normal Users</th><td>{{ userStats.normal|default(0) }}</td></tr>
                        <tr><th>Active</th><td>{{ userStats.active|default(0) }}</td></tr>
                        <tr><th>Pending</th><td>{{ userStats.pending|default(0) }}</td></tr>
                        <tr><th>Suspended</th><td>{{ userStats.suspended|default(0) }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\">
                <h3>Role / Status Distribution</h3>
                {% set totalUsers = userStats.total|default(0) > 0 ? userStats.total : 1 %}
                {% set adminWidth = ((userStats.admins|default(0) / totalUsers) * 100)|round(1) %}
                {% set normalWidth = ((userStats.normal|default(0) / totalUsers) * 100)|round(1) %}
                {% set activeWidth = ((userStats.active|default(0) / totalUsers) * 100)|round(1) %}
                {% set pendingWidth = ((userStats.pending|default(0) / totalUsers) * 100)|round(1) %}
                {% set suspendedWidth = ((userStats.suspended|default(0) / totalUsers) * 100)|round(1) %}
                <div style=\"display:grid; gap:12px;\">
                    <div>
                        <p style=\"margin-bottom:6px;\">Admins {{ adminWidth }}%</p>
                        <div style=\"height:10px; background:#e9e3d8; border-radius:999px;\"><span style=\"display:block; height:10px; width:{{ adminWidth }}%; background:#7b8cc5; border-radius:999px;\"></span></div>
                    </div>
                    <div>
                        <p style=\"margin-bottom:6px;\">Normal {{ normalWidth }}%</p>
                        <div style=\"height:10px; background:#e9e3d8; border-radius:999px;\"><span style=\"display:block; height:10px; width:{{ normalWidth }}%; background:#69ad7a; border-radius:999px;\"></span></div>
                    </div>
                    <div>
                        <p style=\"margin-bottom:6px;\">Active {{ activeWidth }}%</p>
                        <div style=\"height:10px; background:#e9e3d8; border-radius:999px;\"><span style=\"display:block; height:10px; width:{{ activeWidth }}%; background:#57a565; border-radius:999px;\"></span></div>
                    </div>
                    <div>
                        <p style=\"margin-bottom:6px;\">Pending {{ pendingWidth }}%</p>
                        <div style=\"height:10px; background:#e9e3d8; border-radius:999px;\"><span style=\"display:block; height:10px; width:{{ pendingWidth }}%; background:#d8ac4e; border-radius:999px;\"></span></div>
                    </div>
                    <div>
                        <p style=\"margin-bottom:6px;\">Suspended {{ suspendedWidth }}%</p>
                        <div style=\"height:10px; background:#e9e3d8; border-radius:999px;\"><span style=\"display:block; height:10px; width:{{ suspendedWidth }}%; background:#cb6464; border-radius:999px;\"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=\"crud-card\">
        <div class=\"crud-head\">
            <div>
                <h2>Admin Profile</h2>
                <p>Your administrator identity in this portal.</p>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <table class=\"data-table\">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#US-{{ currentUser.id|default(0) }}</td>
                            <td>{{ currentUser.lastName|default('-') }}</td>
                            <td>{{ currentUser.firstName|default('-') }}</td>
                            <td>{{ currentUser.email|default('-') }}</td>
                            <td><span class=\"status ok\">{{ currentUser.roleName|default('ADMIN') }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=\"crud-form\" style=\"display:flex; align-items:center;\">
                <p>Admin profile is managed from the dedicated profile page. Use the section below to manage all users and role permissions.</p>
            </div>
        </div>
    </div>

    <div class=\"crud-card users-accounts-card\">
        <div class=\"crud-head\">
            <div>
                <h2>All User Accounts</h2>
                <p>Create, edit, delete, and change roles/status for any account.</p>
            </div>
        </div>
        <div class=\"crud-grid\">
            <div class=\"crud-list\">
                <div class=\"list-head\">
                    <input class=\"input\" id=\"users-search\" type=\"search\" placeholder=\"Search users\" autocomplete=\"off\">
                    <select class=\"input\" id=\"users-search-column\">
                        <option value=\"all\">All columns</option>
                        <option value=\"id\">Id</option>
                        <option value=\"lastName\">Nom</option>
                        <option value=\"firstName\">Prenom</option>
                        <option value=\"email\">Email</option>
                        <option value=\"status\">Statut</option>
                        <option value=\"role\">Role</option>
                    </select>
                    <span class=\"pill\">{{ users|length }} records</span>
                </div>
                <div class=\"table-scroll users-table-scroll\">
                    <table class=\"data-table users-data-table\">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Email</th>
                                <th>Statut</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id=\"users-table-body\">
                            {% for user in users|default([]) %}
                                <tr data-id=\"{{ user.id|default('')|e('html_attr') }}\" data-last-name=\"{{ user.lastName|default('')|lower|e('html_attr') }}\" data-first-name=\"{{ user.firstName|default('')|lower|e('html_attr') }}\" data-email=\"{{ user.email|default('')|lower|e('html_attr') }}\" data-status=\"{{ user.status|default('')|lower|e('html_attr') }}\" data-role=\"{{ user.roleName|default('')|lower|e('html_attr') }}\">
                                    <td>#US-{{ user.id }}</td>
                                    <td>{{ user.lastName }}</td>
                                    <td>{{ user.firstName }}</td>
                                    <td>{{ user.email }}</td>
                                    <td><span class=\"status {{ user.status|lower == 'active' ? 'ok' : 'warn' }}\">{{ user.status }}</span></td>
                                    <td><span class=\"status {{ user.roleName|upper matches '/ADMIN/' ? 'warn' : 'ok' }}\">{{ user.roleName }}</span></td>
                                    <td>
                                        <button
                                            class=\"link\"
                                            type=\"button\"
                                            data-edit-user
                                            data-id=\"{{ user.id }}\"
                                            data-last-name=\"{{ user.lastName }}\"
                                            data-first-name=\"{{ user.firstName }}\"
                                            data-email=\"{{ user.email }}\"
                                            data-status=\"{{ user.status }}\"
                                            data-role=\"{{ user.roleName }}\"
                                        >Edit</button>
                                        <form method=\"post\" style=\"display:inline;\">
                                            <input type=\"hidden\" name=\"user_action\" value=\"delete\">
                                            <input type=\"hidden\" name=\"id\" value=\"{{ user.id }}\">
                                            <button class=\"link danger\" type=\"submit\" {% if user.id == currentUser.id|default(0) %}disabled{% endif %}>Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            {% else %}
                                <tr>
                                    <td colspan=\"7\">No users found.</td>
                                </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class=\"crud-form\">
                <h3>Create / Update user</h3>
                <form method=\"post\" id=\"user-account-form\" novalidate>
                    <div class=\"form-grid\">
                        <label class=\"field\">
                            <span>User ID (for update)</span>
                            <input class=\"input\" type=\"number\" id=\"user-form-id\" name=\"id\" placeholder=\"Leave empty to create\">
                        </label>
                        <label class=\"field\">
                            <span>Nom</span>
                            <input class=\"input\" type=\"text\" id=\"user-form-last-name\" name=\"last_name\" placeholder=\"Last name\" required>
                        </label>
                        <label class=\"field\">
                            <span>Prenom</span>
                            <input class=\"input\" type=\"text\" id=\"user-form-first-name\" name=\"first_name\" placeholder=\"First name\" required>
                        </label>
                        <label class=\"field\">
                            <span>Email</span>
                            <input class=\"input\" type=\"email\" id=\"user-form-email\" name=\"email\" placeholder=\"email@domain.tn\" required>
                        </label>
                        <label class=\"field\">
                            <span>Password</span>
                            <input class=\"input\" type=\"password\" id=\"user-form-password\" name=\"password\" placeholder=\"Optional on update\">
                        </label>
                        <label class=\"field\">
                            <span>Status</span>
                            <select class=\"input\" id=\"user-form-status\" name=\"status\">
                                <option>Active</option>
                                <option>Pending</option>
                                <option>Suspended</option>
                            </select>
                        </label>
                        <label class=\"field\">
                            <span>Role</span>
                            <select class=\"input\" id=\"user-form-role\" name=\"role_name\">
                                <option value=\"USER\">USER</option>
                                <option value=\"ADMIN\">ADMIN</option>
                            </select>
                        </label>
                    </div>
                    <div class=\"form-actions\">
                        <button class=\"primary\" type=\"submit\" name=\"user_action\" value=\"create\">Create</button>
                        <button class=\"ghost\" type=\"submit\" name=\"user_action\" value=\"update\" id=\"user-update-button\">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {% endif %}
</section>
{% endblock %}

{% block scripts %}
    {{ parent() }}
    {% if adminMode|default(false) %}
    <script>
        (function () {
            const form = document.getElementById('user-account-form');
            if (!form) {
                return;
            }

            const idInput = document.getElementById('user-form-id');
            const lastNameInput = document.getElementById('user-form-last-name');
            const firstNameInput = document.getElementById('user-form-first-name');
            const emailInput = document.getElementById('user-form-email');
            const passwordInput = document.getElementById('user-form-password');
            const statusSelect = document.getElementById('user-form-status');
            const roleSelect = document.getElementById('user-form-role');
            const updateButton = document.getElementById('user-update-button');
            const usersSearchInput = document.getElementById('users-search');
            const usersSearchColumn = document.getElementById('users-search-column');
            const usersRows = Array.from(document.querySelectorAll('#users-table-body tr'));

            function applyUsersSearch() {
                if (!usersSearchInput || !usersRows.length) {
                    return;
                }

                const query = usersSearchInput.value.trim().toLowerCase();
                const column = usersSearchColumn ? usersSearchColumn.value : 'all';

                usersRows.forEach((row) => {
                    const haystack = column === 'all'
                        ? row.textContent.toLowerCase()
                        : String(row.dataset[column] || '').toLowerCase();
                    row.style.display = haystack.includes(query) ? '' : 'none';
                });
            }

            if (usersSearchInput) {
                usersSearchInput.addEventListener('input', applyUsersSearch);
            }

            if (usersSearchColumn) {
                usersSearchColumn.addEventListener('change', applyUsersSearch);
            }

            document.querySelectorAll('[data-edit-user]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    idInput.value = btn.dataset.id || '';
                    lastNameInput.value = btn.dataset.lastName || '';
                    firstNameInput.value = btn.dataset.firstName || '';
                    emailInput.value = btn.dataset.email || '';
                    statusSelect.value = btn.dataset.status || 'Active';
                    roleSelect.value = (btn.dataset.role || 'USER').toUpperCase().includes('ADMIN') ? 'ADMIN' : 'USER';
                    passwordInput.value = '';
                    form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    updateButton.focus();
                });
            });
        })();
    </script>
    {% endif %}
{% endblock %}
", "management/users.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\management\\users.html.twig");
    }
}
