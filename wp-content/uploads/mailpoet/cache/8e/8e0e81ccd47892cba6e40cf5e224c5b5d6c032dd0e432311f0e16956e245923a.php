<?php

use MailPoetVendor\Twig\Environment;
use MailPoetVendor\Twig\Error\LoaderError;
use MailPoetVendor\Twig\Error\RuntimeError;
use MailPoetVendor\Twig\Extension\SandboxExtension;
use MailPoetVendor\Twig\Markup;
use MailPoetVendor\Twig\Sandbox\SecurityError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedTagError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFilterError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFunctionError;
use MailPoetVendor\Twig\Source;
use MailPoetVendor\Twig\Template;

/* mss_pitch_translations.html */
class __TwigTemplate_1d4ec912d076a6e2f5ca578afbaff15f0a9028fb4a984f43642cf66a29bc8931 extends \MailPoetVendor\Twig\Template
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
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo $this->extensions['MailPoet\Twig\I18n']->localize(["welcomeWizardMSSFreeTitle" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("MailPoet Premium is entirely free for you. Sign up!", "Promotion for our email sending service: Title"), "welcomeWizardMSSFreeSubtitle" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Did you know? Users with 1,000 subscribers or less get the Premium for free.", "Promotion for our email sending service: Paragraph"), "welcomeWizardMSSFreeListTitle" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("You’ll get", "Promotion for our email sending service: Paragraph"), "welcomeWizardMSSList1" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Access to detailed analytics", "Promotion for our email sending service: Feature item"), "welcomeWizardMSSList2" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("MailPoet sending your emails for great deliverability", "Promotion for our email sending service: Feature item"), "welcomeWizardMSSList4" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Fast, priority support", "Promotion for our email sending service: Feature item"), "welcomeWizardMSSList5" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("The MailPoet logo removed from the footer of your emails", "Promotion for our email sending service: Feature item"), "welcomeWizardMSSFreeButton" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Sign up for free!", "Promotion for our email sending service: Button"), "welcomeWizardMSSNotFreeTitle" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("It’s now time to take your MailPoet to the next level", "Promotion for our email sending service: Title"), "welcomeWizardMSSNotFreeSubtitle" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Starting at only \$13 per month, MailPoet Premium offers the following features", "Promotion for our email sending service: Paragraph"), "welcomeWizardMSSNotFreeButton" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Sign up now", "Promotion for our email sending service: Button"), "welcomeWizardMSSNoThanks" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("No thanks!", "Promotion for our email sending service: Skip link")]);
        // line 14
        echo "
";
    }

    public function getTemplateName()
    {
        return "mss_pitch_translations.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 14,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "mss_pitch_translations.html", "/home3/slowrise345/public_html/wp-content/plugins/mailpoet/views/mss_pitch_translations.html");
    }
}
