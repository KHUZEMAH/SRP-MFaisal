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

/* form/editor.html */
class __TwigTemplate_5f4139ffc29836a67ced03ff2051064ad40a83cf6b15a9fa6a5d4823c527fc7f extends \MailPoetVendor\Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'after_css' => [$this, 'block_after_css'],
            'container' => [$this, 'block_container'],
            'translations' => [$this, 'block_translations'],
            'after_javascript' => [$this, 'block_after_javascript'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("layout.html", "form/editor.html", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_after_css($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo $this->extensions['MailPoet\Twig\Assets']->generateStylesheet("mailpoet-form-editor.css");
        echo "
";
        // line 5
        echo $this->extensions['MailPoet\Twig\Assets']->generateStylesheet("mailpoet-public.css");
        echo "
";
    }

    // line 8
    public function block_container($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 9
        echo "
<script type=\"text/javascript\">
  var mailpoet_beacon_articles = [
    '5e43d3ec2c7d3a7e9ae79da9',
  ];
</script>

<div class=\"block-editor\">
    <div id=\"mailpoet_form_edit\" class=\"block-editor__container\">
    </div>
</div>

<script>
  ";
        // line 23
        echo "  var mailpoet_form_data = ";
        echo json_encode(($context["form"] ?? null));
        echo ";
  var mailpoet_form_exports = ";
        // line 24
        echo json_encode(($context["form_exports"] ?? null));
        echo ";
  var mailpoet_form_segments = ";
        // line 25
        echo json_encode(($context["segments"] ?? null));
        echo ";
  var mailpoet_form_pages = ";
        // line 26
        echo json_encode(($context["pages"] ?? null));
        echo ";
  var mailpoet_custom_fields = ";
        // line 27
        echo json_encode(($context["custom_fields"] ?? null));
        echo ";
  var mailpoet_date_types = ";
        // line 28
        echo json_encode(($context["date_types"] ?? null));
        echo ";
  var mailpoet_date_formats = ";
        // line 29
        echo json_encode(($context["date_formats"] ?? null));
        echo ";
  var mailpoet_month_names = ";
        // line 30
        echo json_encode(($context["month_names"] ?? null));
        echo ";
  var mailpoet_form_preview_page = ";
        // line 31
        echo json_encode(($context["preview_page_url"] ?? null));
        echo ";
  var mailpoet_custom_fonts = ";
        // line 32
        echo json_encode(($context["custom_fonts"] ?? null));
        echo ";
  var mailpoet_translations = ";
        // line 33
        echo json_encode(($context["translations"] ?? null));
        echo ";
  var mailpoet_close_icons_url = '";
        // line 34
        echo $this->extensions['MailPoet\Twig\Assets']->generateImageUrl("form_close_icon");
        echo "';
  ";
        // line 36
        echo "</script>

<style id=\"mailpoet-form-editor-form-styles\"></style>
";
    }

    // line 41
    public function block_translations($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 42
        echo $this->extensions['MailPoet\Twig\I18n']->localize(["addFormName" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Add form name", "A placeholder for form name input"), "changesNotSaved" => $this->extensions['MailPoet\Twig\I18n']->translate("Your changes you made may not be saved"), "back" => $this->extensions['MailPoet\Twig\I18n']->translate("Back"), "form" => $this->extensions['MailPoet\Twig\I18n']->translate("Form"), "formSettings" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Settings", "A settings section heading"), "formSettingsStyles" => $this->extensions['MailPoet\Twig\I18n']->translate("Styles"), "formSettingsStylesBackgroundColor" => $this->extensions['MailPoet\Twig\I18n']->translate("Background Color"), "formSettingsStylesBackgroundImage" => $this->extensions['MailPoet\Twig\I18n']->translate("Background Image"), "formSettingsStylesSelectImage" => $this->extensions['MailPoet\Twig\I18n']->translate("Select Image…"), "formSettingsStylesFontSize" => $this->extensions['MailPoet\Twig\I18n']->translate("Font Size"), "formSettingsStylesFontColor" => $this->extensions['MailPoet\Twig\I18n']->translate("Font Color"), "formSettingsStylesFontColorInherit" => $this->extensions['MailPoet\Twig\I18n']->translate("Inherit from theme"), "formSettingsInheritStyleFromTheme" => $this->extensions['MailPoet\Twig\I18n']->translate("Inherit style from theme"), "formSettingsDisplayFullWidth" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Display Fullwidth", "A label for checkbox in form style settings"), "formSettingsBold" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Bold", "A label for checkbox in form style settings"), "formSettingsBorderSize" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Border Size", "A label for checkbox in form style settings"), "formSettingsBorderRadius" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Border Radius", "A label for checkbox in form style settings"), "formSettingsInputPadding" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Input Padding", "A label for form style settings"), "formSettingsFormPadding" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Form Padding", "A label for form style settings"), "formSettingsAlignment" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Alignment", "A label for form style settings"), "formSettingsAlignmentLeft" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("left", "An alignment value for form editor"), "formSettingsAlignmentCenter" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("center", "An alignment value for form editor"), "formSettingsAlignmentRight" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("right", "An alignment value for form editor"), "formSettingsBorderColor" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Border Color", "A label for checkbox in form style settings"), "formSettingsApplyToAll" => $this->extensions['MailPoet\Twig\I18n']->translate("Apply styles to all inputs"), "formSettingsWidth" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Form width", "A label for form width settings"), "customFieldSettings" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Custom field settings", "A settings section heading"), "customFieldsFormSettings" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Form settings", "A settings section heading"), "formPlacement" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Form Placement", "A settings section heading"), "formPlacementLabel" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Form placement", "A label for a select box"), "customCss" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Custom CSS", "A settings section heading"), "formSaved" => $this->extensions['MailPoet\Twig\I18n']->translate("Form saved."), "formSavedAppendix" => $this->extensions['MailPoet\Twig\I18n']->translate("Cookies reset — you will see all your dismissed popup forms again."), "customFieldSaved" => $this->extensions['MailPoet\Twig\I18n']->translate("Custom field saved."), "placeFixedBarFormOnPages" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Fixed bar", "This is a text on a widget that leads to settings for form placement - form type is fixed bar"), "placeFixedBarFormOnPagesDescription" => $this->extensions['MailPoet\Twig\I18n']->translate("Display your form in a fixed horizontal bar at the top or bottom of posts or pages."), "placeSlideInFormOnPages" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Slide–in", "This is a text on a widget that leads to settings for form placement - form type is slide in"), "placeSlideInFormOnPagesDescription" => $this->extensions['MailPoet\Twig\I18n']->translate("Display your form in a slide–in form on top of your page content."), "placePopupFormOnPages" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Pop up", "This is a text on a widget that leads to settings for form placement - form type is pop up, it will be displayed on page in a small modal window"), "placePopupFormOnPagesDescription" => $this->extensions['MailPoet\Twig\I18n']->translate("Display your form in a pop up window."), "placeFormBellowPages" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Below pages", "This is a text on a widget that leads to settings for form placement"), "placeFormBellowPagesDescription" => $this->extensions['MailPoet\Twig\I18n']->translate("This form placement allows you to add this form at the end of all the pages or posts, below the content."), "placeFormOnAllPages" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Display on all pages", "This is a text on a switch if a form should be displayed bellow all pages"), "placeFormOnAllPosts" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Display on all posts", "This is a text on a switch if a form should be displayed bellow all posts"), "placeFormOthers" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Others (widget)", "Placement of the form using theme widget"), "formPlacementDelay" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Display with a delay of", "Label on a selection of different times"), "formPlacementPlacementPosition" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Position", "Placement of a fixed bar form, on top of the page or on the bottom"), "formPlacementPlacementPositionTop" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("top", "Placement of a fixed bar form, on top of the page or on the bottom"), "formPlacementPlacementPositionBottom" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("bottom", "Placement of a fixed bar form, on top of the page or on the bottom"), "formPlacementPlacementPositionLeft" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("left", "Placement of a slide in form, on the left or right side of the page"), "formPlacementPlacementPositionRight" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("right", "Placement of a slide in  form, on the left or right side of the page"), "formPlacementDelaySeconds" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("%1s sec", "times selection should be in the end \"30 sec\""), "formPlacementSave" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Close", "Text on a button to save and close a form"), "formPlacementOtherLabel" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Other", "Label in the form placement section (Other form placements)"), "addFormWidgetHint" => $this->extensions['MailPoet\Twig\I18n']->translate("You can add this form to a [link]widget area of your theme[/link] (new tab)."), "addFormShortcodeHint" => $this->extensions['MailPoet\Twig\I18n']->translate("Or in any page or post as a block, or with this shortcode if you prefer [shortcode]."), "addFormPhpIframeHint" => $this->extensions['MailPoet\Twig\I18n']->translate("Use [link]PHP[/link] or [link]iFrame[/link]."), "settingsListLabel" => $this->extensions['MailPoet\Twig\I18n']->translate("This form adds the subscribers to these lists"), "settingsAfterSubmit" => $this->extensions['MailPoet\Twig\I18n']->translate("After submit…"), "settingsShowMessage" => $this->extensions['MailPoet\Twig\I18n']->translate("Show message"), "settingsGoToPage" => $this->extensions['MailPoet\Twig\I18n']->translate("Go to Page"), "settingsPleaseSelectList" => $this->extensions['MailPoet\Twig\I18n']->translate("Please select a list"), "fieldsBlocksCategory" => $this->extensions['MailPoet\Twig\I18n']->translate("Fields"), "customFieldsBlocksCategory" => $this->extensions['MailPoet\Twig\I18n']->translate("Custom Fields"), "layoutBlocksCategory" => $this->extensions['MailPoet\Twig\I18n']->translate("Layout"), "customFieldNumberOfLines" => $this->extensions['MailPoet\Twig\I18n']->translate("Number of lines"), "customFieldSaveCTA" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Update custom field", "Text on the save button"), "customFieldDeleteCTA" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Delete this custom field", "Text on the delete button"), "customFieldDeleteConfirm" => $this->extensions['MailPoet\Twig\I18n']->translate("This field will be deleted for all your subscribers. Are you sure?"), "customFieldTypeText" => $this->extensions['MailPoet\Twig\I18n']->translate("Text Input"), "customFieldTypeTextarea" => $this->extensions['MailPoet\Twig\I18n']->translate("Text Area"), "customFieldTypeRadio" => $this->extensions['MailPoet\Twig\I18n']->translate("Radio buttons"), "customFieldTypeCheckbox" => $this->extensions['MailPoet\Twig\I18n']->translate("Checkbox"), "customFieldTypeSelect" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Select", "Form input type"), "customFieldTypeDate" => $this->extensions['MailPoet\Twig\I18n']->translate("Date"), "customFieldDateType" => $this->extensions['MailPoet\Twig\I18n']->translate("Type of date"), "customFieldDateFormat" => $this->extensions['MailPoet\Twig\I18n']->translate("Order"), "customFieldDefaultToday" => $this->extensions['MailPoet\Twig\I18n']->translate("Preselect today’s date"), "customFieldDay" => $this->extensions['MailPoet\Twig\I18n']->translate("Day"), "customFieldMonth" => $this->extensions['MailPoet\Twig\I18n']->translate("Month"), "customFieldYear" => $this->extensions['MailPoet\Twig\I18n']->translate("Year"), "customField1Line" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("1 line", "Number of rows in textarea"), "customField2Lines" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("2 lines", "Number of rows in textarea"), "customField3Lines" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("3 lines", "Number of rows in textarea"), "customField4Lines" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("4 lines", "Number of rows in textarea"), "customField5Lines" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("5 lines", "Number of rows in textarea"), "customFieldValidateFor" => $this->extensions['MailPoet\Twig\I18n']->translate("Validate for"), "customFieldValidateNothing" => $this->extensions['MailPoet\Twig\I18n']->translate("Nothing"), "customFieldValidateNumbersOnly" => $this->extensions['MailPoet\Twig\I18n']->translate("Numbers only"), "customFieldValidateAlphanumerical" => $this->extensions['MailPoet\Twig\I18n']->translate("Alphanumerical"), "customFieldValidatePhoneNumber" => $this->extensions['MailPoet\Twig\I18n']->translate("Phone number, (+,-,#,(,) and spaces allowed)"), "customFieldAddItem" => $this->extensions['MailPoet\Twig\I18n']->translate("Add item"), "blockMandatory" => $this->extensions['MailPoet\Twig\I18n']->translate("Mandatory field"), "blockFirstName" => $this->extensions['MailPoet\Twig\I18n']->translate("First name"), "blockFirstNameDescription" => $this->extensions['MailPoet\Twig\I18n']->translate("Input field used to catch subscribers’ first names."), "blockLastName" => $this->extensions['MailPoet\Twig\I18n']->translate("Last name"), "blockLastNameDescription" => $this->extensions['MailPoet\Twig\I18n']->translate("Input field used to catch subscribers’ last names."), "blockSegmentSelect" => $this->extensions['MailPoet\Twig\I18n']->translate("List selection"), "blockLastNameDescription" => $this->extensions['MailPoet\Twig\I18n']->translate("Allow your subscribers to select which list(s) they want to subscribe to."), "blockSegmentSelectLabel" => $this->extensions['MailPoet\Twig\I18n']->translate("Select list(s):"), "blockSegmentSelectNoLists" => $this->extensions['MailPoet\Twig\I18n']->translate("Please select at least one list"), "blockSegmentSelectListLabel" => $this->extensions['MailPoet\Twig\I18n']->translate("Select the segment that you want to add"), "blockEmail" => $this->extensions['MailPoet\Twig\I18n']->translate("Email"), "blockEmailDescription" => $this->extensions['MailPoet\Twig\I18n']->translate("Input field used to catch subscribers’ email addresses."), "blockSubmit" => $this->extensions['MailPoet\Twig\I18n']->translate("Submit button"), "blockSubmitDescription" => $this->extensions['MailPoet\Twig\I18n']->translate("Button used to submit the form."), "blockSubmitLabel" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Subscribe!", "a default value for a subscription form button"), "missingObligatoryBlock" => $this->extensions['MailPoet\Twig\I18n']->translate("Email input or submit is missing. Try reloading the form editor."), "label" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Label", "settings for a label of an input"), "displayLabelWithinInput" => $this->extensions['MailPoet\Twig\I18n']->translate("Display label within input"), "displayLabel" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Display label", "Settings - if label should be displayed"), "blockDivider" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Divider / Spacer", "The name of the block in the editor"), "blockCustomHtml" => $this->extensions['MailPoet\Twig\I18n']->translate("Custom HTML"), "blockCustomHtmlDescription" => $this->extensions['MailPoet\Twig\I18n']->translate("Display custom text or HTML code in your form."), "blockCustomHtmlDefault" => $this->extensions['MailPoet\Twig\I18n']->translate("Subscribe to our newsletter and join [mailpoet_subscribers_count] other subscribers."), "blockCustomHtmlContentLabel" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Custom text", "Textarea label"), "blockCustomHtmlNl2br" => $this->extensions['MailPoet\Twig\I18n']->translate("Automatically add paragraphs"), "blockAddCustomField" => $this->extensions['MailPoet\Twig\I18n']->translate("Create Custom Field"), "blockAddCustomFieldDescription" => $this->extensions['MailPoet\Twig\I18n']->translate("Create a new custom field for your subscribers."), "blockAddCustomFieldFormHeading" => $this->extensions['MailPoet\Twig\I18n']->translate("New Custom Field."), "blockCreateButton" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Create", "Label on form submit button."), "customFieldName" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Field name", "Label for form field for custom input name"), "selectCustomFieldType" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Select a field type", "Label for form field for custom input type"), "customFieldWithNameExists" => $this->extensions['MailPoet\Twig\I18n']->translate("The custom field [name] already exists. Please choose another name."), "successMessage" => $this->extensions['MailPoet\Twig\I18n']->translate("This is what the success message looks like."), "errorMessage" => $this->extensions['MailPoet\Twig\I18n']->translate("This is what the error message looks like."), "formPreview" => $this->extensions['MailPoet\Twig\I18n']->translate("Form Preview"), "formSettingsStylesFontFamily" => $this->extensions['MailPoet\Twig\I18n']->translate("Font Family"), "formFontsDefaultTheme" => $this->extensions['MailPoet\Twig\I18n']->translate("Theme’s default fonts"), "formFontsStandard" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Standard fonts", "Heading in the font selection list: Arial, Times, ..."), "formFontsCustom" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Custom fonts", "Heading in the font selection list for a list of custom fonts"), "blockSpacerHeight" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Height", "Settings in the spacer block"), "blockSpacerEnableDivider" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Enable Divider", "Settings in the spacer block"), "imagePlacementScale" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Scale", "How a background image will be rendered: scale, fit or tile"), "imagePlacementFit" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Fit", "How a background image will be rendered: scale, fit or tile"), "imagePlacementTile" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Tile", "How a background image will be rendered: scale, fit or tile"), "blockDividerStyle" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Divider Style", "Settings in the divider block (solid, dotted, …)"), "blockDividerStyleSolid" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Solid", "Setting in the divider block"), "blockDividerStyleDashed" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Dashed", "Setting in the divider block"), "blockDividerStyleDotted" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Dotted", "Setting in the divider block"), "blockDividerDividerHeight" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Divider Height", "Settings in the divider block"), "blockDividerDividerWidth" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Divider Width", "Settings in the divider block"), "blockDividerColor" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Color", "Settings in the divider block"), "successValidationColorTitle" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Success Message Color", "heading above the settings"), "errorValidationColorTitle" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Error Message Color", "heading above the settings"), "formPreviewDesktop" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Desktop", "Desktop browser preview mode"), "formPreviewMobile" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Mobile", "Mobile browser preview mode"), "formPreviewOthersDisclaimer" => $this->extensions['MailPoet\Twig\I18n']->translate("Psssst. We try our best to show you what the widget might look like, but better check the final result on your website."), "formPreviewMobileDisclaimer" => $this->extensions['MailPoet\Twig\I18n']->translate("Psssst. Forms on mobile appear smaller automatically because it’s better for SEO."), "closeButtonHeading" => $this->extensions['MailPoet\Twig\I18n']->translate("Close Button Style"), "noName" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("no name", "fallback for forms without a name in a form list")]);
        // line 194
        echo "
";
    }

    // line 197
    public function block_after_javascript($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 198
        echo $this->extensions['MailPoet\Twig\Assets']->generateJavascript("form_editor.js");
        echo "
";
    }

    public function getTemplateName()
    {
        return "form/editor.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  153 => 198,  149 => 197,  144 => 194,  142 => 42,  138 => 41,  131 => 36,  127 => 34,  123 => 33,  119 => 32,  115 => 31,  111 => 30,  107 => 29,  103 => 28,  99 => 27,  95 => 26,  91 => 25,  87 => 24,  82 => 23,  67 => 9,  63 => 8,  57 => 5,  53 => 4,  49 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "form/editor.html", "/www/slowrisepizza_805/public/wp-content/plugins/mailpoet/views/form/editor.html");
    }
}
