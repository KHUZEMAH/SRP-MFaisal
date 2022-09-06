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

/* subscribers/importExport/import/step_data_manipulation.html */
class __TwigTemplate_1d239d173ffab83e6fb2b7b998500ede85e0fa2f994a3ae6dcf0c701be5f95d3 extends \MailPoetVendor\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<div id=\"step_data_manipulation\" class=\"mailpoet_hidden\">
  <div class=\"inside\">

    <!-- New segment template -->
    <script id=\"new_segment_template\" type=\"text/x-handlebars-template\">
      <p>
        <label>";
        // line 7
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Name");
        echo ":</label>
        <input id=\"new_segment_name\" type=\"text\" name=\"name\"/>
      </p>
      <p class=\"mailpoet_validation_error\" data-error=\"segment_name_required\">
        ";
        // line 11
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Please specify a name.");
        echo "
      </p>
      <p class=\"mailpoet_validation_error\" data-error=\"segment_name_not_unique\">
        ";
        // line 14
        echo \MailPoetVendor\twig_escape_filter($this->env, sprintf($this->env->getExtension('MailPoet\Twig\I18n')->translate("Another record already exists. Please specify a different \"%1\$s\"."), "name"), "html", null, true);
        echo "
      </p>
      <p>
        <label>";
        // line 17
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Description");
        echo ":</label>
        <br/>
        <textarea id=\"new_segment_description\" cols=\"40\" rows=\"3\" name=\"description\"/>
      </p>

      <hr/>

      <p class=\"mailpoet_align_right\">
        <input type=\"submit\" value=\"";
        // line 25
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Done");
        echo "\" id=\"new_segment_process\"
         class=\"button-primary \"/>
        <input type=\"submit\" value=\"";
        // line 27
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Cancel");
        echo "\" id=\"new_segment_cancel\"
         class=\"button-primary\"/>
      </p>

      </form>
    </script>

    <!-- New custom field logic -->
    ";
        // line 35
        $this->loadTemplate("form/custom_fields_legacy.html", "subscribers/importExport/import/step_data_manipulation.html", 35)->display($context);
        // line 36
        echo "  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "subscribers/importExport/import/step_data_manipulation.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  86 => 36,  84 => 35,  73 => 27,  68 => 25,  57 => 17,  51 => 14,  45 => 11,  38 => 7,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "subscribers/importExport/import/step_data_manipulation.html", "/home/slowrise/public_html/wp-content/plugins/mailpoet/views/subscribers/importExport/import/step_data_manipulation.html");
    }
}
