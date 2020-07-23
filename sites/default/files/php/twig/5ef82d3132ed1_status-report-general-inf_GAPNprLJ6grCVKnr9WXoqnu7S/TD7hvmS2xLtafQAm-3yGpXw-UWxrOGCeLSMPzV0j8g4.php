<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* core/themes/seven/templates/status-report-general-info.html.twig */
class __TwigTemplate_dfb0ab5b7847dfa5b12ed555b5f713d8cb3a9c8b764afaa092027c9e12eca6d2 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = array("if" => 40);
        $filters = array("t" => 33, "escape" => 39);
        $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['t', 'escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 32
        echo "<div class=\"system-status-general-info\">
  <h2 class=\"system-status-general-info__header\">";
        // line 33
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("General System Information"));
        echo "</h2>
  <div class=\"system-status-general-info__items\">
    <div class=\"system-status-general-info__item\">
      <span class=\"system-status-general-info__item-icon system-status-general-info__item-icon--drupal\"></span>
      <div class=\"system-status-general-info__item-details\">
        <h3 class=\"system-status-general-info__item-title\">";
        // line 38
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Drupal Version"));
        echo "</h3>
        ";
        // line 39
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["drupal"] ?? null), "value", [], "any", false, false, true, 39), 39, $this->source), "html", null, true);
        echo "
        ";
        // line 40
        if (twig_get_attribute($this->env, $this->source, ($context["drupal"] ?? null), "description", [], "any", false, false, true, 40)) {
            // line 41
            echo "          <div class=\"description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["drupal"] ?? null), "description", [], "any", false, false, true, 41), 41, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 43
        echo "      </div>
    </div>
    <div class=\"system-status-general-info__item\">
      <span class=\"system-status-general-info__item-icon system-status-general-info__item-icon--clock\"></span>
      <div class=\"system-status-general-info__item-details\">
        <h3 class=\"system-status-general-info__item-title\">";
        // line 48
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Last Cron Run"));
        echo "</h3>
        ";
        // line 49
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["cron"] ?? null), "value", [], "any", false, false, true, 49), 49, $this->source), "html", null, true);
        echo "
        ";
        // line 50
        if (twig_get_attribute($this->env, $this->source, ($context["cron"] ?? null), "run_cron", [], "any", false, false, true, 50)) {
            // line 51
            echo "          <div class=\"system-status-general-info__run-cron\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["cron"] ?? null), "run_cron", [], "any", false, false, true, 51), 51, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 53
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["cron"] ?? null), "description", [], "any", false, false, true, 53)) {
            // line 54
            echo "          <div class=\"system-status-general-info__description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["cron"] ?? null), "description", [], "any", false, false, true, 54), 54, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 56
        echo "      </div>
    </div>
    <div class=\"system-status-general-info__item\">
      <span class=\"system-status-general-info__item-icon system-status-general-info__item-icon--server\"></span>
      <div class=\"system-status-general-info__item-details\">
        <h3 class=\"system-status-general-info__item-title\">";
        // line 61
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Web Server"));
        echo "</h3>
        ";
        // line 62
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["webserver"] ?? null), "value", [], "any", false, false, true, 62), 62, $this->source), "html", null, true);
        echo "
        ";
        // line 63
        if (twig_get_attribute($this->env, $this->source, ($context["webserver"] ?? null), "description", [], "any", false, false, true, 63)) {
            // line 64
            echo "          <div class=\"description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["webserver"] ?? null), "description", [], "any", false, false, true, 64), 64, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 66
        echo "      </div>
    </div>
    <div class=\"system-status-general-info__item\">
      <span class=\"system-status-general-info__item-icon system-status-general-info__item-icon--php\"></span>
      <div class=\"system-status-general-info__item-details\">
        <h3 class=\"system-status-general-info__item-title\">";
        // line 71
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("PHP"));
        echo "</h3>
        <h4 class=\"system-status-general-info__sub-item-title\">";
        // line 72
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Version"));
        echo "</h4>";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["php"] ?? null), "value", [], "any", false, false, true, 72), 72, $this->source), "html", null, true);
        echo "
        ";
        // line 73
        if (twig_get_attribute($this->env, $this->source, ($context["php"] ?? null), "description", [], "any", false, false, true, 73)) {
            // line 74
            echo "          <div class=\"description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["php"] ?? null), "description", [], "any", false, false, true, 74), 74, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 76
        echo "
        <h4 class=\"system-status-general-info__sub-item-title\">";
        // line 77
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Memory limit"));
        echo "</h4>";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["php_memory_limit"] ?? null), "value", [], "any", false, false, true, 77), 77, $this->source), "html", null, true);
        echo "
        ";
        // line 78
        if (twig_get_attribute($this->env, $this->source, ($context["php_memory_limit"] ?? null), "description", [], "any", false, false, true, 78)) {
            // line 79
            echo "          <div class=\"description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["php_memory_limit"] ?? null), "description", [], "any", false, false, true, 79), 79, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 81
        echo "      </div>
    </div>
    <div class=\"system-status-general-info__item\">
      <span class=\"system-status-general-info__item-icon system-status-general-info__item-icon--database\"></span>
      <div class=\"system-status-general-info__item-details\">
        <h3 class=\"system-status-general-info__item-title\">";
        // line 86
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Database"));
        echo "</h3>
        <h4 class=\"system-status-general-info__sub-item-title\">";
        // line 87
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Version"));
        echo "</h4>";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["database_system_version"] ?? null), "value", [], "any", false, false, true, 87), 87, $this->source), "html", null, true);
        echo "
        ";
        // line 88
        if (twig_get_attribute($this->env, $this->source, ($context["database_system_version"] ?? null), "description", [], "any", false, false, true, 88)) {
            // line 89
            echo "          <div class=\"description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["database_system_version"] ?? null), "description", [], "any", false, false, true, 89), 89, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 91
        echo "
        <h4 class=\"system-status-general-info__sub-item-title\">";
        // line 92
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("System"));
        echo "</h4>";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["database_system"] ?? null), "value", [], "any", false, false, true, 92), 92, $this->source), "html", null, true);
        echo "
        ";
        // line 93
        if (twig_get_attribute($this->env, $this->source, ($context["database_system"] ?? null), "description", [], "any", false, false, true, 93)) {
            // line 94
            echo "          <div class=\"description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["database_system"] ?? null), "description", [], "any", false, false, true, 94), 94, $this->source), "html", null, true);
            echo "</div>
        ";
        }
        // line 96
        echo "      </div>
    </div>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "core/themes/seven/templates/status-report-general-info.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  228 => 96,  222 => 94,  220 => 93,  214 => 92,  211 => 91,  205 => 89,  203 => 88,  197 => 87,  193 => 86,  186 => 81,  180 => 79,  178 => 78,  172 => 77,  169 => 76,  163 => 74,  161 => 73,  155 => 72,  151 => 71,  144 => 66,  138 => 64,  136 => 63,  132 => 62,  128 => 61,  121 => 56,  115 => 54,  112 => 53,  106 => 51,  104 => 50,  100 => 49,  96 => 48,  89 => 43,  83 => 41,  81 => 40,  77 => 39,  73 => 38,  65 => 33,  62 => 32,);
    }

    public function getSourceContext()
    {
        return new Source("", "core/themes/seven/templates/status-report-general-info.html.twig", "/var/www/html/drupal9/core/themes/seven/templates/status-report-general-info.html.twig");
    }
}
