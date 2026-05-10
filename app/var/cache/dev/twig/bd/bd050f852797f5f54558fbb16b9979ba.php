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

/* auth/form.html.twig */
class __TwigTemplate_7b0534ee549f1c71cf231bf6ad2ad0b3 extends Template
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
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "auth/form.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>";
        // line 6
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new RuntimeError('Variable "title" does not exist.', 6, $this->source); })()), "html", null, true);
        yield " | AgriSense 360</title>
    <link rel=\"stylesheet\" href=\"";
        // line 7
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/styles/home.css"), "html", null, true);
        yield "\">
    <link rel=\"stylesheet\" href=\"";
        // line 8
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/styles/auth.css"), "html", null, true);
        yield "\">
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
</head>
<body class=\"auth-page";
        // line 13
        if (((isset($context["mode"]) || array_key_exists("mode", $context) ? $context["mode"] : (function () { throw new RuntimeError('Variable "mode" does not exist.', 13, $this->source); })()) == "admin")) {
            yield " admin-mode";
        }
        yield "\">
    <main class=\"auth-shell\">
        <section class=\"auth-layout\">
            <aside class=\"auth-hero\">
                <a class=\"auth-back\" href=\"";
        // line 17
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("intro", ["mode" => (isset($context["mode"]) || array_key_exists("mode", $context) ? $context["mode"] : (function () { throw new RuntimeError('Variable "mode" does not exist.', 17, $this->source); })())]), "html", null, true);
        yield "\">Back to Intro</a>
                <p class=\"auth-kicker\">";
        // line 18
        yield ((((isset($context["mode"]) || array_key_exists("mode", $context) ? $context["mode"] : (function () { throw new RuntimeError('Variable "mode" does not exist.', 18, $this->source); })()) == "admin")) ? ("Admin Access") : ("User Access"));
        yield "</p>
                <h1>";
        // line 19
        yield ((((isset($context["mode"]) || array_key_exists("mode", $context) ? $context["mode"] : (function () { throw new RuntimeError('Variable "mode" does not exist.', 19, $this->source); })()) == "admin")) ? ("A calmer control room for your team") : ("A softer way to manage the farm day"));
        yield "</h1>
                <p class=\"auth-sub\">";
        // line 20
        yield ((((isset($context["mode"]) || array_key_exists("mode", $context) ? $context["mode"] : (function () { throw new RuntimeError('Variable "mode" does not exist.', 20, $this->source); })()) == "admin")) ? ("Admin mode keeps operations clear and fast.") : ("User mode keeps daily tasks simple and smooth."));
        yield "</p>

                <div class=\"auth-points\">
                    <div class=\"auth-point\">
                        <strong>Secure session</strong>
                        <span>Encrypted sign-in and role-based routing.</span>
                    </div>
                    <div class=\"auth-point\">
                        <strong>Quick resume</strong>
                        <span>Typed values stay visible after validation errors.</span>
                    </div>
                    <div class=\"auth-point\">
                        <strong>Gentle motion</strong>
                        <span>Subtle motion follows your typing and focus.</span>
                    </div>
                </div>

                <section class=\"auth-live-visual\" id=\"auth-live-visual\" data-stage=\"0\" data-active=\"0\" aria-live=\"polite\">
                    <div class=\"auth-live-orbit\" aria-hidden=\"true\">
                        <span class=\"live-dot live-dot--one\"></span>
                        <span class=\"live-dot live-dot--two\"></span>
                        <span class=\"live-dot live-dot--three\"></span>
                        <span class=\"live-dot live-dot--four\"></span>
                        <span class=\"live-ring live-ring--inner\"></span>
                        <span class=\"live-ring live-ring--outer\"></span>
                        <span class=\"live-core\"></span>
                    </div>
                    <div class=\"auth-live-meta\">
                        <div class=\"auth-live-meter\" role=\"progressbar\" aria-label=\"Form completion\" aria-valuemin=\"0\" aria-valuemax=\"100\" aria-valuenow=\"0\">
                            <span id=\"auth-live-meter-fill\"></span>
                        </div>
                        <p class=\"auth-live-text\" id=\"auth-live-text\">Start typing to wake the field.</p>
                    </div>
                </section>
            </aside>

            <section class=\"auth-card\">
                <div class=\"auth-card__glow auth-card__glow--one\"></div>
                <div class=\"auth-card__glow auth-card__glow--two\"></div>

                <div class=\"auth-card__header\">
                    <div>
                        <p class=\"auth-chip\">";
        // line 62
        yield ((((isset($context["authType"]) || array_key_exists("authType", $context) ? $context["authType"] : (function () { throw new RuntimeError('Variable "authType" does not exist.', 62, $this->source); })()) == "signup")) ? ("Create account") : ("Welcome back"));
        yield "</p>
                        <h2>";
        // line 63
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new RuntimeError('Variable "title" does not exist.', 63, $this->source); })()), "html", null, true);
        yield "</h2>
                    </div>
                    <span class=\"auth-mode-badge\">";
        // line 65
        yield ((((isset($context["mode"]) || array_key_exists("mode", $context) ? $context["mode"] : (function () { throw new RuntimeError('Variable "mode" does not exist.', 65, $this->source); })()) == "admin")) ? ("Admin") : ("User"));
        yield "</span>
                </div>

                <p class=\"auth-card__sub\">Use your AgriSense credentials to continue.</p>

                ";
        // line 70
        if ((($tmp = (isset($context["errorMessage"]) || array_key_exists("errorMessage", $context) ? $context["errorMessage"] : (function () { throw new RuntimeError('Variable "errorMessage" does not exist.', 70, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 71
            yield "                    <div class=\"auth-alert error\" role=\"alert\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["errorMessage"]) || array_key_exists("errorMessage", $context) ? $context["errorMessage"] : (function () { throw new RuntimeError('Variable "errorMessage" does not exist.', 71, $this->source); })()), "html", null, true);
            yield "</div>
                ";
        }
        // line 73
        yield "
                ";
        // line 74
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 74, $this->source); })()), "flashes", ["error"], "method", false, false, false, 74));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 75
            yield "                    <div class=\"auth-alert error\" role=\"alert\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "</div>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 77
        yield "                ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 77, $this->source); })()), "flashes", ["success"], "method", false, false, false, 77));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 78
            yield "                    <div class=\"auth-alert success\" role=\"status\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "</div>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 80
        yield "
                <form method=\"post\" class=\"auth-form\" novalidate>
                    ";
        // line 82
        if (((isset($context["authType"]) || array_key_exists("authType", $context) ? $context["authType"] : (function () { throw new RuntimeError('Variable "authType" does not exist.', 82, $this->source); })()) == "signup")) {
            // line 83
            yield "                        <div class=\"auth-grid\">
                            <label class=\"field\">
                                <span>First name</span>
                                <input class=\"input\" type=\"text\" name=\"first_name\" value=\"";
            // line 86
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["formValues"] ?? null), "firstName", [], "any", true, true, false, 86)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["formValues"]) || array_key_exists("formValues", $context) ? $context["formValues"] : (function () { throw new RuntimeError('Variable "formValues" does not exist.', 86, $this->source); })()), "firstName", [], "any", false, false, false, 86), "")) : ("")), "html", null, true);
            yield "\" autocomplete=\"given-name\" required>
                                ";
            // line 87
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["fieldErrors"] ?? null), "first_name", [], "any", true, true, false, 87)) {
                // line 88
                yield "                                    <small class=\"field-warning\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["fieldErrors"]) || array_key_exists("fieldErrors", $context) ? $context["fieldErrors"] : (function () { throw new RuntimeError('Variable "fieldErrors" does not exist.', 88, $this->source); })()), "first_name", [], "any", false, false, false, 88), "html", null, true);
                yield "</small>
                                ";
            }
            // line 90
            yield "                            </label>
                            <label class=\"field\">
                                <span>Last name</span>
                                <input class=\"input\" type=\"text\" name=\"last_name\" value=\"";
            // line 93
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["formValues"] ?? null), "lastName", [], "any", true, true, false, 93)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["formValues"]) || array_key_exists("formValues", $context) ? $context["formValues"] : (function () { throw new RuntimeError('Variable "formValues" does not exist.', 93, $this->source); })()), "lastName", [], "any", false, false, false, 93), "")) : ("")), "html", null, true);
            yield "\" autocomplete=\"family-name\" required>
                                ";
            // line 94
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["fieldErrors"] ?? null), "last_name", [], "any", true, true, false, 94)) {
                // line 95
                yield "                                    <small class=\"field-warning\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["fieldErrors"]) || array_key_exists("fieldErrors", $context) ? $context["fieldErrors"] : (function () { throw new RuntimeError('Variable "fieldErrors" does not exist.', 95, $this->source); })()), "last_name", [], "any", false, false, false, 95), "html", null, true);
                yield "</small>
                                ";
            }
            // line 97
            yield "                            </label>
                        </div>
                    ";
        }
        // line 100
        yield "
                    <label class=\"field\">
                        <span>Email</span>
                        <input class=\"input\" type=\"email\" name=\"email\" value=\"";
        // line 103
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["formValues"] ?? null), "email", [], "any", true, true, false, 103)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (isset($context["formValues"]) || array_key_exists("formValues", $context) ? $context["formValues"] : (function () { throw new RuntimeError('Variable "formValues" does not exist.', 103, $this->source); })()), "email", [], "any", false, false, false, 103), "")) : ("")), "html", null, true);
        yield "\" autocomplete=\"email\" required>
                        ";
        // line 104
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["fieldErrors"] ?? null), "email", [], "any", true, true, false, 104)) {
            // line 105
            yield "                            <small class=\"field-warning\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["fieldErrors"]) || array_key_exists("fieldErrors", $context) ? $context["fieldErrors"] : (function () { throw new RuntimeError('Variable "fieldErrors" does not exist.', 105, $this->source); })()), "email", [], "any", false, false, false, 105), "html", null, true);
            yield "</small>
                        ";
        }
        // line 107
        yield "                    </label>

                    <label class=\"field\">
                        <span>Password</span>
                        <input class=\"input\" type=\"password\" name=\"password\" autocomplete=\"";
        // line 111
        if (((isset($context["authType"]) || array_key_exists("authType", $context) ? $context["authType"] : (function () { throw new RuntimeError('Variable "authType" does not exist.', 111, $this->source); })()) == "signup")) {
            yield "new-password";
        } else {
            yield "current-password";
        }
        yield "\" required>
                        ";
        // line 112
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["fieldErrors"] ?? null), "password", [], "any", true, true, false, 112)) {
            // line 113
            yield "                            <small class=\"field-warning\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["fieldErrors"]) || array_key_exists("fieldErrors", $context) ? $context["fieldErrors"] : (function () { throw new RuntimeError('Variable "fieldErrors" does not exist.', 113, $this->source); })()), "password", [], "any", false, false, false, 113), "html", null, true);
            yield "</small>
                        ";
        }
        // line 115
        yield "                    </label>

                    <button class=\"primary auth-submit\" type=\"submit\">";
        // line 117
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["submitLabel"]) || array_key_exists("submitLabel", $context) ? $context["submitLabel"] : (function () { throw new RuntimeError('Variable "submitLabel" does not exist.', 117, $this->source); })()), "html", null, true);
        yield "</button>
                </form>

                <div class=\"auth-switch\">
                    ";
        // line 121
        if (((isset($context["authType"]) || array_key_exists("authType", $context) ? $context["authType"] : (function () { throw new RuntimeError('Variable "authType" does not exist.', 121, $this->source); })()) == "login")) {
            // line 122
            yield "                        <span>Need an account?</span>
                        <a href=\"";
            // line 123
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("auth_signup", ["mode" => (isset($context["mode"]) || array_key_exists("mode", $context) ? $context["mode"] : (function () { throw new RuntimeError('Variable "mode" does not exist.', 123, $this->source); })())]), "html", null, true);
            yield "\">Sign up</a>
                    ";
        } else {
            // line 125
            yield "                        <span>Already have an account?</span>
                        <a href=\"";
            // line 126
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("auth_login", ["mode" => (isset($context["mode"]) || array_key_exists("mode", $context) ? $context["mode"] : (function () { throw new RuntimeError('Variable "mode" does not exist.', 126, $this->source); })())]), "html", null, true);
            yield "\">Log in</a>
                    ";
        }
        // line 128
        yield "                </div>
            </section>
        </section>
    </main>

    <script>
        (() => {
            const form = document.querySelector('.auth-form');
            const visual = document.getElementById('auth-live-visual');
            const meter = document.getElementById('auth-live-meter-fill');
            const text = document.getElementById('auth-live-text');

            if (!form || !visual || !meter || !text) {
                return;
            }

            const inputs = Array.from(form.querySelectorAll('input.input'));
            const progressBar = visual.querySelector('.auth-live-meter');

            function updateVisual() {
                const total = inputs.length || 1;
                const filled = inputs.filter((input) => input.value.trim() !== '').length;
                const progress = Math.round((filled / total) * 100);
                const stage = Math.min(4, Math.max(0, Math.ceil((filled / total) * 4)));

                visual.dataset.stage = String(stage);
                meter.style.width = progress + '%';

                if (progressBar) {
                    progressBar.setAttribute('aria-valuenow', String(progress));
                }

                if (filled === 0) {
                    text.textContent = 'Start typing to wake the field.';
                } else if (filled < total) {
                    text.textContent = filled + ' / ' + total + ' fields ready';
                } else {
                    text.textContent = 'All fields complete. Ready to continue.';
                }
            }

            inputs.forEach((input) => {
                input.addEventListener('input', updateVisual);
                input.addEventListener('focus', () => {
                    visual.dataset.active = '1';
                });
                input.addEventListener('blur', () => {
                    visual.dataset.active = '0';
                });
            });

            updateVisual();

            form.addEventListener('submit', () => {
                document.body.classList.add('is-leaving');
            });
        })();
    </script>
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
        return "auth/form.html.twig";
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
        return array (  302 => 128,  297 => 126,  294 => 125,  289 => 123,  286 => 122,  284 => 121,  277 => 117,  273 => 115,  267 => 113,  265 => 112,  257 => 111,  251 => 107,  245 => 105,  243 => 104,  239 => 103,  234 => 100,  229 => 97,  223 => 95,  221 => 94,  217 => 93,  212 => 90,  206 => 88,  204 => 87,  200 => 86,  195 => 83,  193 => 82,  189 => 80,  180 => 78,  175 => 77,  166 => 75,  162 => 74,  159 => 73,  153 => 71,  151 => 70,  143 => 65,  138 => 63,  134 => 62,  89 => 20,  85 => 19,  81 => 18,  77 => 17,  68 => 13,  60 => 8,  56 => 7,  52 => 6,  45 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>{{ title }} | AgriSense 360</title>
    <link rel=\"stylesheet\" href=\"{{ asset('assets/styles/home.css') }}\">
    <link rel=\"stylesheet\" href=\"{{ asset('assets/styles/auth.css') }}\">
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
</head>
<body class=\"auth-page{% if mode == 'admin' %} admin-mode{% endif %}\">
    <main class=\"auth-shell\">
        <section class=\"auth-layout\">
            <aside class=\"auth-hero\">
                <a class=\"auth-back\" href=\"{{ path('intro', { mode: mode }) }}\">Back to Intro</a>
                <p class=\"auth-kicker\">{{ mode == 'admin' ? 'Admin Access' : 'User Access' }}</p>
                <h1>{{ mode == 'admin' ? 'A calmer control room for your team' : 'A softer way to manage the farm day' }}</h1>
                <p class=\"auth-sub\">{{ mode == 'admin' ? 'Admin mode keeps operations clear and fast.' : 'User mode keeps daily tasks simple and smooth.' }}</p>

                <div class=\"auth-points\">
                    <div class=\"auth-point\">
                        <strong>Secure session</strong>
                        <span>Encrypted sign-in and role-based routing.</span>
                    </div>
                    <div class=\"auth-point\">
                        <strong>Quick resume</strong>
                        <span>Typed values stay visible after validation errors.</span>
                    </div>
                    <div class=\"auth-point\">
                        <strong>Gentle motion</strong>
                        <span>Subtle motion follows your typing and focus.</span>
                    </div>
                </div>

                <section class=\"auth-live-visual\" id=\"auth-live-visual\" data-stage=\"0\" data-active=\"0\" aria-live=\"polite\">
                    <div class=\"auth-live-orbit\" aria-hidden=\"true\">
                        <span class=\"live-dot live-dot--one\"></span>
                        <span class=\"live-dot live-dot--two\"></span>
                        <span class=\"live-dot live-dot--three\"></span>
                        <span class=\"live-dot live-dot--four\"></span>
                        <span class=\"live-ring live-ring--inner\"></span>
                        <span class=\"live-ring live-ring--outer\"></span>
                        <span class=\"live-core\"></span>
                    </div>
                    <div class=\"auth-live-meta\">
                        <div class=\"auth-live-meter\" role=\"progressbar\" aria-label=\"Form completion\" aria-valuemin=\"0\" aria-valuemax=\"100\" aria-valuenow=\"0\">
                            <span id=\"auth-live-meter-fill\"></span>
                        </div>
                        <p class=\"auth-live-text\" id=\"auth-live-text\">Start typing to wake the field.</p>
                    </div>
                </section>
            </aside>

            <section class=\"auth-card\">
                <div class=\"auth-card__glow auth-card__glow--one\"></div>
                <div class=\"auth-card__glow auth-card__glow--two\"></div>

                <div class=\"auth-card__header\">
                    <div>
                        <p class=\"auth-chip\">{{ authType == 'signup' ? 'Create account' : 'Welcome back' }}</p>
                        <h2>{{ title }}</h2>
                    </div>
                    <span class=\"auth-mode-badge\">{{ mode == 'admin' ? 'Admin' : 'User' }}</span>
                </div>

                <p class=\"auth-card__sub\">Use your AgriSense credentials to continue.</p>

                {% if errorMessage %}
                    <div class=\"auth-alert error\" role=\"alert\">{{ errorMessage }}</div>
                {% endif %}

                {% for message in app.flashes('error') %}
                    <div class=\"auth-alert error\" role=\"alert\">{{ message }}</div>
                {% endfor %}
                {% for message in app.flashes('success') %}
                    <div class=\"auth-alert success\" role=\"status\">{{ message }}</div>
                {% endfor %}

                <form method=\"post\" class=\"auth-form\" novalidate>
                    {% if authType == 'signup' %}
                        <div class=\"auth-grid\">
                            <label class=\"field\">
                                <span>First name</span>
                                <input class=\"input\" type=\"text\" name=\"first_name\" value=\"{{ formValues.firstName|default('') }}\" autocomplete=\"given-name\" required>
                                {% if fieldErrors.first_name is defined %}
                                    <small class=\"field-warning\">{{ fieldErrors.first_name }}</small>
                                {% endif %}
                            </label>
                            <label class=\"field\">
                                <span>Last name</span>
                                <input class=\"input\" type=\"text\" name=\"last_name\" value=\"{{ formValues.lastName|default('') }}\" autocomplete=\"family-name\" required>
                                {% if fieldErrors.last_name is defined %}
                                    <small class=\"field-warning\">{{ fieldErrors.last_name }}</small>
                                {% endif %}
                            </label>
                        </div>
                    {% endif %}

                    <label class=\"field\">
                        <span>Email</span>
                        <input class=\"input\" type=\"email\" name=\"email\" value=\"{{ formValues.email|default('') }}\" autocomplete=\"email\" required>
                        {% if fieldErrors.email is defined %}
                            <small class=\"field-warning\">{{ fieldErrors.email }}</small>
                        {% endif %}
                    </label>

                    <label class=\"field\">
                        <span>Password</span>
                        <input class=\"input\" type=\"password\" name=\"password\" autocomplete=\"{% if authType == 'signup' %}new-password{% else %}current-password{% endif %}\" required>
                        {% if fieldErrors.password is defined %}
                            <small class=\"field-warning\">{{ fieldErrors.password }}</small>
                        {% endif %}
                    </label>

                    <button class=\"primary auth-submit\" type=\"submit\">{{ submitLabel }}</button>
                </form>

                <div class=\"auth-switch\">
                    {% if authType == 'login' %}
                        <span>Need an account?</span>
                        <a href=\"{{ path('auth_signup', { mode: mode }) }}\">Sign up</a>
                    {% else %}
                        <span>Already have an account?</span>
                        <a href=\"{{ path('auth_login', { mode: mode }) }}\">Log in</a>
                    {% endif %}
                </div>
            </section>
        </section>
    </main>

    <script>
        (() => {
            const form = document.querySelector('.auth-form');
            const visual = document.getElementById('auth-live-visual');
            const meter = document.getElementById('auth-live-meter-fill');
            const text = document.getElementById('auth-live-text');

            if (!form || !visual || !meter || !text) {
                return;
            }

            const inputs = Array.from(form.querySelectorAll('input.input'));
            const progressBar = visual.querySelector('.auth-live-meter');

            function updateVisual() {
                const total = inputs.length || 1;
                const filled = inputs.filter((input) => input.value.trim() !== '').length;
                const progress = Math.round((filled / total) * 100);
                const stage = Math.min(4, Math.max(0, Math.ceil((filled / total) * 4)));

                visual.dataset.stage = String(stage);
                meter.style.width = progress + '%';

                if (progressBar) {
                    progressBar.setAttribute('aria-valuenow', String(progress));
                }

                if (filled === 0) {
                    text.textContent = 'Start typing to wake the field.';
                } else if (filled < total) {
                    text.textContent = filled + ' / ' + total + ' fields ready';
                } else {
                    text.textContent = 'All fields complete. Ready to continue.';
                }
            }

            inputs.forEach((input) => {
                input.addEventListener('input', updateVisual);
                input.addEventListener('focus', () => {
                    visual.dataset.active = '1';
                });
                input.addEventListener('blur', () => {
                    visual.dataset.active = '0';
                });
            });

            updateVisual();

            form.addEventListener('submit', () => {
                document.body.classList.add('is-leaving');
            });
        })();
    </script>
</body>
</html>
", "auth/form.html.twig", "C:\\Users\\user\\Desktop\\pis\\AgriSense360\\app\\templates\\auth\\form.html.twig");
    }
}
