<?php
class ThemeView {

	public $themeKey;
	public $navbarBackgroundColor;
	public $navbarBackgroundColorActive;
	public $navbarBorderColor;
	public $navbarTextColor;
	public $navbarTextColorHover;
	public $navbarTextColorActive;
	public $contentPanelHeadingTextColor;
	public $contentPanelHeadingBackgroundColor;
	
	public function __construct() {
	

		$themeKey = Channel::getThemeKey($_SESSION['channelID']);

		$core = Core::getInstance();
		$query = "
			SELECT 
				navbarBackgroundColor, 
				navbarBackgroundColorActive, 
				navbarBorderColor, 
				navbarTextColor, 
				navbarTextColorHover, 
				navbarTextColorActive, 
				contentPanelHeadingTextColor, 
				contentPanelHeadingBackgroundColor
			FROM jaga_theme
			WHERE themeKey = :themeKey
			LIMIT 1
		";
		$statement = $core->database->prepare($query);
		$statement->execute(array(':themeKey' => $themeKey));
		$row = $statement->fetch();

		$this->themeKey = $themeKey;
		$this->navbarBackgroundColor = $row['navbarBackgroundColor'];
		$this->navbarBackgroundColorActive = $row['navbarBackgroundColorActive'];
		$this->navbarBorderColor = $row['navbarBorderColor'];
		$this->navbarTextColor = $row['navbarTextColor'];
		$this->navbarTextColorHover = $row['navbarTextColorHover'];
		$this->navbarTextColorActive = $row['navbarTextColorActive'];
		$this->contentPanelHeadingTextColor = $row['contentPanelHeadingTextColor'];
		$this->contentPanelHeadingBackgroundColor = $row['contentPanelHeadingBackgroundColor'];
		
	}
	
	public function getTheme() {
	
		$themeKey = $this->themeKey;
		
		$navbarBackgroundColor = $this->navbarBackgroundColor;
		$navbarBackgroundColorActive = $this->navbarBackgroundColorActive;
		$navbarBorderColor = $this->navbarBorderColor;
		$navbarTextColor = $this->navbarTextColor;
		$navbarTextColorHover = $this->navbarTextColorHover;
		$navbarTextColorActive = $this->navbarTextColorActive; // #$navbarTextColorActive : active color
		
		$contentPanelHeadingTextColor = $this->contentPanelHeadingTextColor;
		$contentPanelHeadingBackgroundColor = $this->contentPanelHeadingBackgroundColor;
		
		$css = "/* WELCOME TO THE KUTCHANNEL */\n/* This channel is using the " . strtoupper($themeKey) . " theme. */\n";
		
		$css .= "

			#footer {
				color:#$contentPanelHeadingTextColor;
				background-color:#$navbarBackgroundColor;

			}
			
			#footer a {
				text-decoration:none;
				color:#$navbarTextColor !important;
			}
			
			div.jagaContentPanelHeading {
				color:#$contentPanelHeadingTextColor !important;
				background-color:#$contentPanelHeadingBackgroundColor !important;
			}
			
			div.jagaContentPanelHeading > a {
				color:#$contentPanelHeadingTextColor !important;
				text-decoration:none;
			}
			
			div.jagaContentPanelHeading > h4 > a {
				color:#$contentPanelHeadingTextColor !important;
				text-decoration:none;
			}
			
			div.jagaContentPanelHeading > a:hover {
				color:#$navbarBackgroundColor !important;
			}
			
			div.jagaContentPanelHeading > h4 > a:hover {
				color:#$navbarBackgroundColor !important;
			}
			
			div.jagaCommentPanelHeading {
				background-color:#f5f5f5 !important;
			}
			
			.jagaFormButton {
				color:#$navbarTextColor;
				background-color:#$navbarBackgroundColor;
			}
		
			.navbar-default {
				background-color: #$navbarBackgroundColor;
				border-color: #$navbarBorderColor;
			}
			/* title */
			.navbar-default .navbar-brand {
				color: #$navbarTextColor;
			}
			.navbar-default .navbar-brand:hover,
			.navbar-default .navbar-brand:focus {
				color: #5E5E5E;
			}
			/* link */
			.navbar-default .navbar-nav > li > a {
				color: #$navbarTextColor;
			}
			.navbar-default .navbar-nav > li > a:hover,
			.navbar-default .navbar-nav > li > a:focus {
				color: #$navbarTextColorHover;
			}
			.navbar-default .navbar-nav > .active > a, 
			.navbar-default .navbar-nav > .active > a:hover, 
			.navbar-default .navbar-nav > .active > a:focus {
				color: #$navbarTextColorActive;
				background-color: #$navbarBorderColor;
			}
			.navbar-default .navbar-nav > .open > a, 
			.navbar-default .navbar-nav > .open > a:hover, 
			.navbar-default .navbar-nav > .open > a:focus {
				color: #$navbarTextColorActive;
				background-color: #$navbarBackgroundColorActive;
			}
			/* caret */
			.navbar-default .navbar-nav > .dropdown > a .caret {
				border-top-color: #$navbarTextColor;
				border-bottom-color: #$navbarTextColor;
			}
			.navbar-default .navbar-nav > .dropdown > a:hover .caret,
			.navbar-default .navbar-nav > .dropdown > a:focus .caret {
				border-top-color: #$navbarTextColorHover;
				border-bottom-color: #$navbarTextColorHover;
			}
			.navbar-default .navbar-nav > .open > a .caret, 
			.navbar-default .navbar-nav > .open > a:hover .caret, 
			.navbar-default .navbar-nav > .open > a:focus .caret {
				border-top-color: #$navbarTextColorActive;
				border-bottom-color: #$navbarTextColorActive;
			}
			/* mobile version */
			.navbar-default .navbar-toggle {
				border-color: #DDD;
			}
			.navbar-default .navbar-toggle:hover,
			.navbar-default .navbar-toggle:focus {
				background-color: #DDD;
			}
			.navbar-default .navbar-toggle .icon-bar {
				background-color: #CCC;
			}
			@media (max-width: 767px) {
				.navbar-default .navbar-nav .open .dropdown-menu > li > a {
					color: #$navbarTextColor;
				}
				.navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
				.navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
					color: #$navbarTextColorHover;
				}
			}

			.jagaClickableRow:hover {
				cursor:pointer;
			}

			li.list-group-item.active, li.list-group-item.active:hover {
				color:#333;
				background-color:#ccc;
				border-color: #aaa;
			}
		
		";
		
		return $css;
	
	}

	/* BEGIN STATIC */
	
	public static function getThemeDropdown($thisThemeKey) {
		
		$core = Core::getInstance();
		$query = "SELECT themeKey FROM jaga_theme ORDER BY themeKey";
		$statement = $core->database->prepare($query);
		$statement->execute();
		
		$html = "<select name=\"themeKey\" class=\"form-control\">\n";
			while ($row = $statement->fetch()) {
				$themeKey = $row['themeKey'];
				$html .= "<option value=\"$themeKey\"";
					if ($themeKey == $thisThemeKey) { $html .= " selected"; }
				$html .= ">$themeKey</option>\n";
			}
		$html .= "</select>\n";

		return $html;

	}
}

?>