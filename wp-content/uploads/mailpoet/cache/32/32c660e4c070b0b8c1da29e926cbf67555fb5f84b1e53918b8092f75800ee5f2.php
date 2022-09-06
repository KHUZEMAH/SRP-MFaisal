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

/* subscribers/importExport/import.html */
class __TwigTemplate_27603f10eb34499376ab498fb541ada9b4e50c69c30ae694e77dd60bb3345caa extends \MailPoetVendor\Twig\Template
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
        // line 2
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        $context["csvDescription"] = $this->env->getExtension('MailPoet\Twig\I18n')->translate("This file needs to be formatted in a CSV style (comma-separated-values). Look at some [link]examples on our support site[/link].");
        // line 2
        $this->parent = $this->loadTemplate("layout.html", "subscribers/importExport/import.html", 2);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        // line 4
        echo "<div id=\"mailpoet_subscribers_import\" class=\"wrap\">
  <h1 class=\"title\">
    ";
        // line 6
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Import");
        echo "
    <a class=\"page-title-action\" href=\"?page=mailpoet-subscribers#/\">";
        // line 7
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Back to Subscribers");
        echo "</a>
  </h1>
  <!-- STEP subscriber data manipulation -->
  ";
        // line 10
        $this->loadTemplate("subscribers/importExport/import/step_data_manipulation.html", "subscribers/importExport/import.html", 10)->display($context);
        // line 11
        echo "  <div id=\"import_container\"></div>
</div>

<script type=\"text/javascript\">
  var
    maxPostSize = '";
        // line 16
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["maxPostSize"] ?? null), "html", null, true);
        echo "',
    roleBasedEmails = ";
        // line 17
        echo ($context["role_based_emails"] ?? null);
        echo ",
    maxPostSizeBytes = '";
        // line 18
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["maxPostSizeBytes"] ?? null), "html", null, true);
        echo "',
    importData = {},
    mailpoetColumnsSelect2 = ";
        // line 20
        echo ($context["subscriberFieldsSelect2"] ?? null);
        echo ",
    mailpoetColumns = ";
        // line 21
        echo ($context["subscriberFields"] ?? null);
        echo ",
    mailpoetSegments = ";
        // line 22
        echo ($context["segments"] ?? null);
        echo ";
    ";
        // line 23
        $context["newUser"] = (((($context["is_new_user"] ?? null) == true)) ? ("true") : ("false"));
        // line 24
        echo "    var mailpoet_is_new_user = ";
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["newUser"] ?? null), "html", null, true);
        echo ";
    var mailpoet_beacon_articles = [
      '57ce07ffc6979108399a044b',
      '57ce079f903360649f6e56fc',
      '5b16db842c7d3a0fa9a2aa15',
      '5d96ecd204286364bc8ff8f5',
      '58a5a7502c7d3a576d353c78',
      '5d0a1da404286318cac46fe5'
    ];
</script>
";
    }

    // line 37
    public function block_translations($context, array $blocks = [])
    {
        // line 38
        echo $this->env->getExtension('MailPoet\Twig\I18n')->localize(["noMailChimpLists" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("No active lists found"), "serverError" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Server error:"), "select" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select", "Form input type"), "wrongFileFormat" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Only comma-separated (CSV) file formats are supported."), "maxPostSizeNotice" => \MailPoetVendor\twig_replace_filter($this->env->getExtension('MailPoet\Twig\I18n')->translate("Your CSV is over %s and is too big to process. Please split the file into two or more sections."), ["%s" =>         // line 43
($context["maxPostSize"] ?? null)]), "dataProcessingError" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Your data could not be processed. Please make sure it is in the correct format."), "noValidRecords" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("No valid records were found. This file needs to be formatted in a CSV style (comma-separated). Look at some [link]examples on our support site.[/link]"), "importNoticeSkipped" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%1\$s records had issues and were skipped."), "importNoticeInvalid" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%1\$s emails are not valid: %2\$s"), "importNoticeRoleBased" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("%1\$s [link]role-based addresses[/link] are not permitted: %2\$s", "Error message when importing addresses like postmaster@domain.com"), "importNoticeDuplicate" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%1\$s emails appear more than once in your file: %2\$s"), "hideDetails" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Hide details"), "showDetails" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Show more details"), "segmentSelectionRequired" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Please select at least one list"), "addNewList" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Add new list"), "addNewField" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Add new field"), "addNewColumuserColumnsn" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Add new list"), "userColumns" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("User fields"), "selectedValueAlreadyMatched" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("The selected value is already matched to another field."), "confirmCorrespondingColumn" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Confirm that this field corresponds to the selected field."), "columnContainInvalidElement" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("One of the fields contains an invalid email. Please fix it before continuing."), "january" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("January"), "february" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("February"), "march" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("March"), "april" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("April"), "may" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("May"), "june" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("June"), "july" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("July"), "august" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("August"), "september" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("September"), "october" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("October"), "november" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("November"), "december" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("December"), "noDateFieldMatch" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Do not match as a 'date field' if most of the rows for that field return the same error."), "emptyFirstRowDate" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("First row date cannot be empty."), "verifyDateMatch" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Verify that the date in blue matches the original date."), "pm" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("PM"), "am" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("AM"), "dateMatchError" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Error matching date"), "columnContainsInvalidDate" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("One of the fields contains an invalid date. Please fix before continuing."), "listCreateError" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Error adding a new list:"), "columnContainsInvalidElement" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("One of the fields contains an invalid email. Please fix before continuing."), "customFieldCreateError" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Custom field could not be created"), "subscribersCreated" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%1\$s subscribers added to %2\$s."), "subscribersUpdated" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%1\$s existing subscribers were updated and added to %2\$s."), "importNoAction" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("No subscribers were added or updated."), "importNoWelcomeEmail" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Note: Imported subscribers will not receive any Welcome Emails"), "readSupportArticle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Read the support article."), "validationStepHeading" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Are you importing an existing list or contacts from your address book?", "Question for importing subscribers into MailPoet"), "validationStepRadio1" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Existing list", "User choice to import an existing email list"), "validationStepRadio2" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Contacts from my address book", "User choice to import his address book contacts"), "validationStepBlock1" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("You will need to ask your contacts to join your list instead of importing them. This is a standard practice to ensure good email deliverability.", "Paragraph explaining the user what to do when importing his contacts."), "validationStepBlock2" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("If you send with MailPoet, we will detect if you import subscribers without their explicit consent and suspend your account.", "Paragraph warning what happens if user imports his contacts and sends with MailPoet"), "validationStepBlock3" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Lists quickly start having invalid addresses because people change jobs and stop using their addresses. This is known as hard bounces and is a primary factor for detecting bad sending practices."), "validationStepBlock4" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("If you send with MailPoet, we will quickly detect and suspend your account, even if you have just 5% of hard bounces.", "Paragraph explaining the user how that MailPoet will ban users with list that have invalid email addresses"), "validationStepBlockButton" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("How to ask your contacts to join your list", "Button to visit a support article"), "validationStepLastSentHeading" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("When did you last send an email to this list?", "Question for users importing their list"), "validationStepLastSentOption1" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Over 2 years ago"), "validationStepLastSentOption2" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Between 1 and 2 years ago"), "validationStepLastSentOption3" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Within the last year"), "validationStepLastSentOption4" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Within the last 3 months"), "validationStepLastSentNext" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Next"), "previousStep" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Previous step"), "nextStep" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Next step"), "seeVideo" => $this->env->getExtension('MailPoet\Twig\I18n')->translate(" See video guide"), "importAgain" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Import again"), "viewSubscribers" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("View subscribers"), "offerMigrationHead" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Let a MailPoet expert help you for free"), "offerMigrationSubhead" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("You have a nice list! Our amazing support team can help you, all for free, with the following"), "offerMigrationList1" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Review your list for best practices to ensure top deliverability"), "offerMigrationList2" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Review your Settings to make sure everything is set up correctly"), "offerMigrationList3" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Design a beautiful template that matches your brand"), "offerMigrationList4" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Review your forms to get more subscribers"), "offerMigrationCTA" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Contact us for free"), "methodPaste" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Paste the data into a text box"), "pickLists" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Pick one or more list(s)"), "pickListsDescription" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Pick the list that you want to import these subscribers to."), "select" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Select", " Verb"), "createANewList" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Create a new list"), "updateExistingSubscribers" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Update existing subscribers' information"), "updateExistingSubscribersYes" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Yes"), "updateExistingSubscribersNo" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("No"), "addSubscribersToSegment" => $this->env->getExtension('MailPoet\Twig\I18n')->translate(" To add subscribers to a mailing segment, [link]create a list[/link]."), "methodUpload" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Upload a file"), "methodMailChimp" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Import from MailChimp"), "methodMailChimpLabel" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Enter your MailChimp API key"), "methodMailChimpVerify" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Verify"), "methodMailChimpSelectList" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select list(s)"), "methodMailChimpSelectPlaceholder" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Select", "Verb"), "matchData" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Match data"), "showMoreDetails" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Show more details"), "pasteLabel" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Copy and paste your subscribers from Excel/Spreadsheets"), "pasteDescription" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("This file needs to be formatted in a CSV style (comma-separated-values.) Look at some [link]examples on our support site[/link]."), "methodSelectionHead" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("How would you like to import subscribers?")]);
        // line 133
        echo "
";
    }

    public function getTemplateName()
    {
        return "subscribers/importExport/import.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  118 => 133,  116 => 43,  115 => 38,  112 => 37,  96 => 24,  94 => 23,  90 => 22,  86 => 21,  82 => 20,  77 => 18,  73 => 17,  69 => 16,  62 => 11,  60 => 10,  54 => 7,  50 => 6,  46 => 4,  43 => 3,  38 => 2,  36 => 1,  30 => 2,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "subscribers/importExport/import.html", "/home/slowrise/public_html/wp-content/plugins/mailpoet/views/subscribers/importExport/import.html");
    }
}
