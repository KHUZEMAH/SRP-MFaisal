<?php

use MailPoetVendor\Twig\Environment;
use MailPoetVendor\Twig\Error\LoaderError;
use MailPoetVendor\Twig\Error\RuntimeError;
use MailPoetVendor\Twig\Markup;
use MailPoetVendor\Twig\Sandbox\SecurityError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedTagError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFilterError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFunctionError;
use MailPoetVendor\Twig\Source;
use MailPoetVendor\Twig\Template;

/* subscribers/importExport/export.html */
class __TwigTemplate_2f485e77ff1df03a1b924f649d48a74afb66035bfce98ad0da2d07d7013ac130 extends \MailPoetVendor\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->blocks = [
            'content' => [$this, 'block_content'],
            'translations' => [$this, 'block_translations'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent = $this->loadTemplate("layout.html", "subscribers/importExport/export.html", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        // line 4
        echo "<div id=\"mailpoet_subscribers_export\" class=\"wrap\">
  <h1 class=\"title\">
    ";
        // line 6
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Export");
        echo "
    <a class=\"page-title-action\" href=\"?page=mailpoet-subscribers#/\">";
        // line 7
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Back to Subscribers");
        echo "</a>
  </h1>
  ";
        // line 9
        if (\MailPoetVendor\twig_test_empty(($context["segments"] ?? null))) {
            // line 10
            echo "  <div class=\"error\">
    <p>";
            // line 11
            echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Yikes! Couldn't find any subscribers");
            echo "</p>
  </div>
  ";
        }
        // line 14
        echo "  <div class=\"inside\">
    <!-- Template data -->
  </div>
</div>
<script id=\"mailpoet_subscribers_export_template\" type=\"text/x-handlebars-template\">
  <div id=\"export_result_notice\" class=\"updated mailpoet_hidden\">
    <!-- Result message -->
  </div>
  <table class=\"form-table\">
    <tbody>
    {{#if segments}}
    <tr>
      <th scope=\"row\">
        <label for=\"export_lists\">
          ";
        // line 28
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Pick one or multiple lists");
        echo "
        </label>
      </th>
      <td>
        <select id=\"export_lists\" data-placeholder=\"";
        // line 32
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Select", "Verb");
        echo "\" multiple=\"multiple\"></select>
      </td>
    </tr>
    {{/if}}
    <tr>
      <th scope=\"row\">
        <label for=\"export_columns\">
          ";
        // line 39
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("List of fields to export");
        echo "
          <p class=\"description\">
            ";
        // line 41
        echo MailPoet\Util\Helpers::replaceLinkTags($this->env->getExtension('MailPoet\Twig\I18n')->translate("[link]Read about the Global status.[/link]"), "https://kb.mailpoet.com/article/245-what-is-global-status", ["target" => "_blank", "data-beacon-article" => "5a9548782c7d3a75495122f9"]);
        // line 44
        echo "
          </p>
        </label>
      </th>
      <td>
        <select id=\"export_columns\" data-placeholder=\"";
        // line 49
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Select", "Verb");
        echo "\" multiple=\"multiple\"></select>
      </td>
    </tr>
    {{#if groupBySegmentOption}}
    <tr class=\"mailpoet_group_by_list mailpoet_hidden\">
      <th scope=\"row\">
        ";
        // line 55
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Group subscribers by list");
        echo "
      </th>
      <td>
        <input type=\"checkbox\" name=\"option_group_by_list\" checked>
      </td>
    </tr>
    {{/if}}
    <tr>
      <th scope=\"row\">
        ";
        // line 64
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Format");
        echo "
      </th>
      <td>
        <label>
          <input type=\"radio\" name=\"option_format\"
           value=\"csv\"
           checked>";
        // line 70
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("CSV file");
        echo "
        </label>
        &nbsp;<br>
        <label>
          <input type=\"radio\" name=\"option_format\"
           value=\"xlsx\" ";
        // line 75
        if ( !($context["zipExtensionLoaded"] ?? null)) {
            echo " disabled=\"disabled\" ";
        }
        echo ">";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Excel file");
        echo "
        </label>
        ";
        // line 77
        if ( !($context["zipExtensionLoaded"] ?? null)) {
            // line 78
            echo "          <div class=\"inline notice notice-warning\">
            <p>";
            // line 79
            echo $this->env->getExtension('MailPoet\Twig\I18n')->translate(MailPoet\Util\Helpers::replaceLinkTags("ZIP extension is required to create Excel files. Please refer to the [link]official PHP ZIP installation guide[/link] or contact your hosting provider’s technical support for instructions on how to install and load the ZIP extension.", "http://php.net/manual/en/zip.installation.php"));
            echo "</p>
          </div>
        ";
        }
        // line 82
        echo "      </td>
    </tr>
    <tr class=\"mailpoet_export_process\">
      <th scope=\"row\">
        <a href=\"javascript:;\"
         class=\"button-primary button-disabled wysija mailpoet_export_process\">";
        // line 87
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Export");
        echo "</a>
      </th>
    </tr>
    </tbody>
  </table>
</script>
</div>

<script type=\"text/javascript\">
  var
    segments = ";
        // line 97
        echo ($context["segments"] ?? null);
        echo ",
    subscriberFieldsSelect2 =
      ";
        // line 99
        echo ($context["subscriberFieldsSelect2"] ?? null);
        echo ",
    exportData = {
     segments: segments.length || null
    };
</script>
";
    }

    // line 106
    public function block_translations($context, array $blocks = [])
    {
        // line 107
        echo $this->env->getExtension('MailPoet\Twig\I18n')->localize(["serverError" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Server error:"), "exportMessage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%1\$s subscribers were exported. Get the exported file [link]here[/link].")]);
        // line 110
        echo "
";
    }

    public function getTemplateName()
    {
        return "subscribers/importExport/export.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  212 => 110,  210 => 107,  207 => 106,  197 => 99,  192 => 97,  179 => 87,  172 => 82,  166 => 79,  163 => 78,  161 => 77,  152 => 75,  144 => 70,  135 => 64,  123 => 55,  114 => 49,  107 => 44,  105 => 41,  100 => 39,  90 => 32,  83 => 28,  67 => 14,  61 => 11,  58 => 10,  56 => 9,  51 => 7,  47 => 6,  43 => 4,  40 => 3,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "subscribers/importExport/export.html", "/home/slowrise/public_html/wp-content/plugins/mailpoet/views/subscribers/importExport/export.html");
    }
}
