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

/* form/templatesLegacy/settings/required.hbs */
class __TwigTemplate_9084d9cf5dd9678c493e22148475b26adefbb8794b0b8fcb186697895f2ee8ac extends \MailPoetVendor\Twig\Template
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
        echo "<p class=\"clearfix\">
  <label>";
        // line 2
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Is this field mandatory?");
        echo "</label>
  <span class=\"group\">
    <label>
      <input type=\"radio\"
        class=\"mailpoet_radio\"
        name=\"params[required]\"
        value=\"1\"
        {{#if params.required}}checked=\"checked\"{{/if}} />";
        // line 9
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Yes");
        echo "
    </label>
    <label>
      <input
        class=\"mailpoet_radio\"
        type=\"radio\"
        name=\"params[required]\"
        value=\"\"
        {{#unless params.required}}checked=\"checked\"{{/unless}} />";
        // line 17
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("No");
        echo "
    </label>
  </span>
</p>";
    }

    public function getTemplateName()
    {
        return "form/templatesLegacy/settings/required.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 17,  43 => 9,  33 => 2,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "form/templatesLegacy/settings/required.hbs", "/home/slowrise/public_html/wp-content/plugins/mailpoet/views/form/templatesLegacy/settings/required.hbs");
    }
}
