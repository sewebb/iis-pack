<?php
class Se_Fox extends Se_Plugin_Base {

	/**
	 * Plats för övrig sajt-konfigurering
	 * width     default: auto
	 * load_font default: true
	 * hide_logo default: false
	 */
	private static $fox_site_config = array(
		'www.iis.se' => array(
			'load_font' => false,
			'hide_logo' => true,
			'site'	    => 'iis',
		),
		'internetdagarna.se' => array(
			'load_font' => true,
			'hide_logo' => false,
			'site'	    => 'internetdagarna',
		),
		'stage.internetdagarna.se' => array(
			'load_font' => true,
			'hide_logo' => false,
			'site'	    => 'internetdagarna',
		),
		'www.internetfonden.se' => array(
			'load_font' => true,
			'hide_logo' => false,
			'site'	    => 'internetfonden',
		),
		'www.internetstatistik.se' => array(
			'load_font' => true,
			'hide_logo' => false,
			'site'	    => 'internetstatistik',
		),
		'www.soi2013.se' => array(
			'load_font' => true,
			'hide_logo' => false,
			'site'	    => 'soi2013',
		),
		'www.soi2014.se' => array(
			'load_font' => true,
			'hide_logo' => false,
			'site'	    => 'soi2014',
		),
		'www.soi2015.se' => array(
			'load_font' => true,
			'hide_logo' => false,
			'site'	    => 'soi2015',
		),
		'www.webbstjarnan.se' => array(
			'load_font' => true,
			'hide_logo' => false,
			'site'	    => 'webbstjarnan',
		),
		'www.poi2014.se' => array(
			'load_font' => true,
			'hide_logo' => false,
			'site'	    => 'poi2014',
		),
		'www.sajtkollen.se' => array(
			'load_font' => false,
			'hide_logo' => false,
			'site'	    => 'sajtkollen',
		),
		'www.internetmuseum.se' => array(
			'load_font' => false,
			'hide_logo' => false,
			'site'	    => 'internetmuseum',
		),
		'www.styleguide.se' => array(
			'load_font' => false,
			'hide_logo' => false,
			'site'	    => 'styleguide',
		),
		'kurser.iis.se' => array(
			'load_font' => false,
			'hide_logo' => false,
			'site'	    => 'kurser',
		)
	);

	/**
	 * Decide which links to display for each site
	 * To add a new site, you insert a new item into the array $fox_mapping, example:
	 * $fox_mapping['www.the-new-site-com'] = array( 'webbstjarnan', 'bredbandskollen', 'soi' );
	 * @since 1.2.1 arkiv.internetmuseum.se
	 */
	private static $fox_mapping = array(
		'www.iis.se' => array(
			'domaner',
			'webbstjarnan',
			'bredbandskollen',
			'internetdagarna',
			'internetstatistik',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'internetdagarna.se' => array(
			'domaner',
			'webbstjarnan',
			'bredbandskollen',
			'internetstatistik',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'stage.internetdagarna.se' => array(
			'domaner',
			'webbstjarnan',
			'bredbandskollen',
			'internetstatistik',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.internetfonden.se' => array(
			'domaner',
			'webbstjarnan',
			'bredbandskollen',
			'internetdagarna',
			'internetstatistik',
			'soi',
			'iisblogg',
			'guider',
			'internetmuseum',
		),
		'www.internetstatistik.se' => array(
			'domaner',
			'webbstjarnan',
			'bredbandskollen',
			'internetdagarna',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.internetmuseum.se' => array(
			'domaner',
			'webbstjarnan',
			'bredbandskollen',
			'internetdagarna',
			'internetstatistik',
			'soi',
			'iisblogg',
			'guider',
		),
		'www.soi2013.se' => array(
			'domaner',
			'webbstjarnan',
			'bredbandskollen',
			'internetdagarna',
			'internetstatistik',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.soi2014.se' => array(
			'domaner',
			'webbstjarnan',
			'bredbandskollen',
			'internetdagarna',
			'internetstatistik',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.soi2015.se' => array(
			'domaner',
			'webbstjarnan',
			'bredbandskollen',
			'internetdagarna',
			'internetstatistik',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.poi2014.se' => array(
			'domaner',
			'webbstjarnan',
			'bredbandskollen',
			'internetdagarna',
			'internetstatistik',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.webbstjarnan.se' => array(
			'domaner',
			'bredbandskollen',
			'internetdagarna',
			'internetstatistik',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.sajtkollen.se' => array(
			'domaner',
			'bredbandskollen',
			'internetdagarna',
			'internetstatistik',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.styleguide.se' => array(
			'domaner',
			'bredbandskollen',
			'internetdagarna',
			'internetstatistik',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'arkiv.internetmuseum.se' => array(
			'domaner',
			'webbstjarnan',
			'bredbandskollen',
			'internetdagarna',
			'internetstatistik',
			'soi',
			'iisblogg',
			'guider',
		),
		'kurser.iis.se' => array(
			'domaner',
			'webbstjarnan',
			'bredbandskollen',
			'internetdagarna',
			'internetstatistik',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
	);

	/**
	 * All the available links for the top bar.
	 * @since 1.2 hashtags i egen variabel (Statistik & Fakta)
	 */
	private static $fox_items = array(
		'domaner' => array(
			'link' => 'http://www.iis.se/domaner',
			'hashtags' => '',
			'name' => 'Domäner',
			// 'image' => 'domaner.svg',
			'content' => 'Registrera din .se- eller .nu-domän här',
			'linktext' => 'Till domäner',
		),
		'bredbandskollen' => array(
			'link' => 'http://www.bredbandskollen.se',
			'hashtags' => '',
			'name' => 'Bredbandskollen',
			// 'image' => 'bbk.svg',
			'content' => 'Verktyget som hjälper dig att testa uppkopplingen på ditt bredband',
			'linktext' => 'Till bredbandskollen.se',
		),
		'webbstjarnan' => array(
			'link' => 'http://www.webbstjarnan.se',
			'hashtags' => '',
			'name' => 'Webbstjärnan',
			// 'image' => 'ws.svg',
			'content' => 'Skoltävling där lärare och elever lär sig att skapa webbplatser',
			'linktext' => 'Till webbstjärnan.se',
		),
		'internetdagarna' => array(
			'link' => 'https://internetdagarna.se',
			'hashtags' => '',
			'name' => 'Internetdagarna',
			// 'image' => 'ind.svg',
			'content' => 'Sveriges viktigaste mötesplats för alla som jobbar med internet',
			'linktext' => 'Till internetdagarna.se',
		),
		'internetstatistik' => array(
			'link' => 'http://www.internetstatistik.se',
			'hashtags' => '',
			'name' => 'Internetstatistik',
			// 'image' => 'inetstat.svg',
			'content' => 'Aktuell statistik om internet i Sverige',
			'linktext' => 'Till internetstatistik.se',
		),
		'soi' => array(
			'link' => 'http://www.soi2015.se',
			'hashtags' => '',
			'name' => 'Svenskarna & internet',
			// 'image' => 'soi.svg',
			'content' => 'Sveriges viktigaste undersökning om svenskarnas internetvanor',
			'linktext' => 'Till soi2015.se',
		),
		'iisblogg' => array(
			'link' => 'https://www.iis.se/blogg',
			'hashtags' => '',
			'name' => 'IIS-bloggen',
			// 'image' => 'bloggen.svg',
			'content' => 'Nyheter och kommentarer från internetvärlden',
			'linktext' => 'Till IIS-bloggen',
		),
		'guider' => array(
			'link' => 'https://www.iis.se/fakta/',
			// hashtags måste skrivas ut efter utm_source etc för att fungera, anges därför som egen variabel
			'hashtags' => '#typ=internetguider',
			'name' => 'Internetguider',
			// 'image' => 'guider.svg',
			'content' => 'Gratis kunskap om internet, paketerat i lättillgängliga guider',
			'linktext' => 'Till internetguider',
		),
		'internetfonden' => array(
			'link' => 'http://www.internetfonden.se',
			'hashtags' => '',
			'name' => 'Internetfonden',
			// 'image' => 'fonden.svg',
			'content' => 'Finansierar projekt som syftar till att förbättra internet i Sverige',
			'linktext' => 'Till internetfonden.se',
		),
		'internetmuseum' => array(
			'link' => 'http://www.internetmuseum.se',
			'hashtags' => '',
			'name' => 'Internetmuseum',
			// 'image' => 'fonden.svg',
			'content' => 'Här tar vi dig med på en resa genom den svenska internethistorien',
			'linktext' => 'Till internetmuseum.se',
		)
	);

	/* NO NEED TO CHANGE THE CODE BELOW */


	/**
	 * Delay loading of the fox plugin until after functions.php is loaded
	 */
	function _fox_after_setup_theme() {
		$load_fox = true;
		$load_fox = apply_filters( 'fox_load', $load_fox );
		if ( $load_fox ) {
			// add_action( 'wp_head', array( $this, 'inline_style' ) );
			add_filter( 'body_class', array( $this, 'body_class' ) );
			add_action( 'wp_footer', array( $this, 'add_foxbar' ) );
		} else {
			add_filter( 'body_class', array( $this, '_fox_no_fox_class' ) );
		}
	}

	/**
	 * Add "no-fox" to body class if fox is not loaded
	 * @param  array $classes Old classes
	 * @return array          New classes
	 */
	function _fox_no_fox_class( $classes ) {
		$classes[] = 'no-fox';
		return $classes;
	}

	function _setup() {
		add_action( 'after_setup_theme', array( $this, '_fox_after_setup_theme' ) );
	}

	// function enqueue_scripts() {
	// 	wp_enqueue_style( 'iis-fox', plugins_url( '/css/style.php', dirname( __FILE__ ) ), array(), '0.0.1' );
	// }
	function inline_style() {
		$site_config = $this->get_site_config();

		$width     = 'auto';
		$max_width = '1023px';
		$padding   = 'padding: 0 15px 0 10px;';

		if ( ! empty( $site_config ) ) {
			if ( ! empty( $site_config[ 'width' ] ) ) {
				$width     = $site_config[ 'width' ];
				$max_width = $width;
				$padding   = '';
			}
			if ( $site_config[ 'load_font' ] ) {
				echo "<link href='//fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>";
			}
		}
		?>

		<style type="text/css">
		.sewebb-nav-space { border-top: 32px solid transparent; }
		<?php
		if ( 'webbstjarnan' === $site_config[ 'site' ] ) {
			// /* Webbstjärnan */ ?>
			.sewebb-nav-space.webbstjarnan > #header { margin-top: 32px; }
			<?php
		} // /* sajtkollen */
		if ( 'sajtkollen' === $site_config[ 'site' ] ) {?>
			.sewebb-nav-space.sajtkollen .brand-nav { z-index: 9999; } .sewebb-nav-space.sajtkollen.home #masthead { top: 32px; }
		<?php
		} ?>
		<?php // /* Om man är inloggad i WP och ser WP:s admin-meny. */ ?>
		.logged-in .brand-nav { border-top: 32px solid transparent; }

		<?php // /* Bakgrund, fullbredds-wrapper */ ?>
		.brand-nav {
			position: absolute; top: 0; width: 100%; background: #323232; font-family: 'Open Sans', Helvetica, Arial, sans-serif; font-size: 11px;
			line-height: 12px; color: #b3b3b3; -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility; }
		.brand-nav-fullgrid { position: relative; display: block; width: 1160px; margin: 0 auto; }
		.brand-nav a { text-decoration: none; }
		.brand-nav a:hover { text-decoration: none; }

		<?php // /* Länkmeny */ ?>
		.brand-nav-list { width: 100%; margin: 0; padding: 0; list-style: none; margin-bottom: 0; list-style: none; }
		.brand-nav-list > li, .brand-nav-list > li > section { position: relative; float: left; margin: 0; padding: 0; }
		.brand-nav-list > li > .brand-nav-headline, .brand-nav-list > li > section { display: block; padding: 9px 10px; color: #b3b3b3; transition: none; }
		.brand-nav-list > li { padding: 0; line-height: normal; }
		.brand-nav-list > li > .brand-nav-headline { padding: 8px 8px 9px 8px; }

		<?php // /* Utfälld yta vid hover */ ?>
		.brand-nav-list > li > section {
			z-index: 10000; float: none; position: absolute; left: -9999px; width: auto; margin: 0; padding: 0;
			background: #fff; list-style: none; font-size: 18px; line-height: 24px;
			box-shadow: 8px 0 6px -6px rgba(0,0,0,0.2), -8px 0 6px -6px rgba(0,0,0,0.2), 0 8px 6px -6px rgba(0,0,0,0.2);
		}

		.brand-nav-list > li > section > a span.linkedelement { display: block; float: left; width: 220px; padding: 12px 20px; }
		.brand-nav-list > li > section > a span.filcontent { width: 220px; color: #000; }
		.brand-nav-list > li > section > a span.fillinktext { display: block; margin-top: 5px; font-size: 11px; color: #000; }
		.brand-nav-list > li > section > a span.fillinktext:hover { color: #4d4d4d; }
		.brand-nav-list > li:hover { background: #fff; }
		.brand-nav-list > li:hover > section { left: 0; }
		.brand-nav-list > li:hover > .brand-nav-headline, .brand-nav-list > li:hover > section { color: #000; }
		.brand-nav-list > li > section > .brand-nav-icon { width: 50px; }

		<?php // /* .SE-logo och text */ ?>
		.brand-nav-logo-text { float: left; padding: 11px 5px 0 0; }
		.brand-nav-logo-symbol { width: 28px; height: 28px; margin-top: 2px; opacity: 0.5; }
		.brand-nav-logo:hover .brand-nav-logo-symbol { opacity: 1; }
		.brand-nav-logo-bg { fill: transparent; }
		.brand-nav-logo-part { fill: #fff; }
		.brand-nav-logo:hover .brand-nav-logo-bg { fill: #ffdf00; }
		.brand-nav-logo:hover .brand-nav-logo-part { fill: #2d83c0; }
		.brand-nav > .brand-nav-fullgrid > .brand-nav-logo { display: block; float: right; padding: 0; font-size: 11px; color: #b3b3b3; }
		.brand-nav > .brand-nav-fullgrid > .brand-nav-logo > span { display: block; margin-top: 0; }

		<?php // /* Göm logo om det är inställt så */ ?>
		.brand-nav > .brand-nav-fullgrid > .hide.brand-nav-logo { display: none; }
		.brand-nav-fullgrid { width: <?php echo $width; ?>; <?php echo $padding; ?>}
		.buorg { top: 32px!important; }
		<?php
		if ( 'webbstjarnan' === $site_config[ 'site' ] ) {
			// /* Webbstjärnan */ ?>
			.sewebb-nav-space.webbstjarnan .buorg { margin-top: -64px; }
		<?php
		}
		if ( 'internetfonden' === $site_config[ 'site' ] ) {
			// /* Webbstjärnan */ ?>
			.sewebb-nav-space.internetfonden .buorg { margin-top: -68px; }
		<?php
		} ?>

		@media ( max-width: <?php echo $max_width; ?> ) {
			.brand-nav { display: none; } .sewebb-nav-space { border: 0; } .buorg { top: 0!important;}
			<?php
			if ( 'webbstjarnan' === $site_config[ 'site' ] ) {
				// /* Webbstjärnan */ ?>
				.sewebb-nav-space.webbstjarnan > #header { margin-top: 0; } .sewebb-nav-space.webbstjarnan .buorg { margin-top: -32px; }
			<?php
			}
			if ( 'internetfonden' === $site_config[ 'site' ] ) {
			// /* internetfonden */ ?>
				.sewebb-nav-space.internetfonden .buorg { margin-top: -35px; }
			<?php
			} ?>
		}

		</style>
		<?php

	}

	function body_class( $classes ) {
		$domain = $this::get_fox_domain();

		$classes[] = 'sewebb-nav-space';
		$classes[] = str_replace( 'www.', '', str_replace( '.se', '', $domain ) );

		return $classes;
	}

	function get_fox_domain() {
		$domain = $_SERVER['SERVER_NAME'];
		$domain = str_replace( '.dev', '.se', $domain );
		$domain = str_replace( 'local.', 'www.', $domain );
		$domain = str_replace( 'vvv.kurser.se', 'kurser.iis.se', $domain );
		$domain = str_replace( 'vvv.', 'www.', $domain );
		$domain = str_replace( 'www.stage.', 'www.', $domain );
		$domain = str_replace( 'stage.arkiv.', 'arkiv.', $domain );
		$domain = str_replace( 'stage.', 'www.', $domain );
		$domain = str_replace( 'iis.web1.common.', 'www.', $domain );
		$domain = str_replace( 'soi.se', 'www.soi2015.se', $domain );
		return $domain;
	}

	function get_site_config() {
		$domain = $this::get_fox_domain();
		return self::$fox_site_config[ $domain ];
	}

	function add_foxbar() {
		$domain      = $this->get_fox_domain();
		$utm_source  = str_replace( '.', '_', $domain );
		$site_config = $this->get_site_config();
		// Vi vill inte ha med 'utm_source' när det är "interna" IIS-länkar
		// Just logo-länken borde egentligen inte hända på IIS eftersom vi inte visar den där men...
		if ( 'www_iis_se' !== $utm_source ) {
			$print_utm_source = '&utm_source=' . $utm_source;
		} else {
			$print_utm_source = '';
		}
		?>

		<section class="brand-nav" id="iis-fox-menu">
			<section class="brand-nav-fullgrid">
				<a href="https://www.iis.se/?utm_medium=fox&utm_campaign=Fox<?php echo $print_utm_source; ?>" class="brand-nav-logo<?php echo ( $site_config['hide_logo'] ) ? ' hide' : ''; ?>">
					<span class="brand-nav-logo-text">En webbplats från</span>

					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						 viewBox="0 0 141.7 141.7" enable-background="new 0 0 141.7 141.7" xml:space="preserve" class="brand-nav-logo-symbol">
						<g>
							<rect x="0" y="0" fill="#FFE100" width="141.7" height="141.7" class="brand-nav-logo-bg"/>
							<g>
								<path fill="#3284BF" d="M104.7,56.2h17.8c0-0.4,0.1-1.1,0.1-1.9c0-13.3-10.5-22.7-24.3-22.7s-24.4,9.6-24.4,23.2
									c0,14.4,11.4,18.8,21.1,22.5c6.6,2.6,10.1,4.7,10.1,8.6c0,4.1-2.6,6.9-6.8,6.9c-4.3,0-7.1-3.3-7.1-7.9V84H72.9
									c0,0.4-0.1,1.1-0.1,1.7c0,14.4,10.8,24,25.4,24c14.4,0,25.4-9.8,25.4-24c0-15.1-11.3-19.7-21.3-23.3c-7.4-2.7-10.7-4.6-10.7-8.6
									c0-3.6,2.6-6.2,6.3-6.2c4,0,6.8,2.9,6.8,7.6V56.2z" class="brand-nav-logo-part"/>
								<rect x="47.8" y="32.2" fill="#3284BF" width="19.1" height="24" class="brand-nav-logo-part"/>
								<rect x="19.1" y="32.2" fill="#3284BF" width="19.1" height="24" class="brand-nav-logo-part"/>
								<rect x="19.1" y="65.7" fill="#3284BF" width="19.1" height="43.1" class="brand-nav-logo-part"/>
								<rect x="47.8" y="65.7" fill="#3284BF" width="19.1" height="43.1" class="brand-nav-logo-part"/>
							</g>
						</g>
					</svg>
				</a>

				<ul class="brand-nav-list">
					<?php
					foreach ( self::$fox_mapping[ $domain ] as $fox_item ) :
						$fi   = self::$fox_items[ $fox_item ];
						$link = $fi['link'];
						// Vi vill inte ha med 'utm_source' när det är "interna" IIS-länkar
						if ( 'www_iis_se' === $utm_source && strpos( $link, 'www.iis.se' ) !== false ) {
							$link_utm_source = '';
						} else {
							$link_utm_source = '&utm_source=' . $utm_source;
						}

						?>
						<li>
							<a href="<?php echo $link; ?>?utm_medium=fox&utm_campaign=Fox<?php echo $fi['hashtags']; ?><?php echo $link_utm_source; ?>" class="brand-nav-headline"><?php echo $fi['name']; ?></a>
								<section>
								<a href="<?php echo $link; ?>?utm_medium=fox&utm_campaign=Fox<?php echo $fi['hashtags']; ?><?php echo $link_utm_source; ?>">
									<span class="linkedelement">
										<span class="filcontent"><?php echo $fi['content']; ?></span>
										<span class="fillinktext"><?php echo $fi['linktext']; ?> ›</span>
									</span>
								</a>
								</section>

						</li>
					<?php endforeach; ?>
				</ul>
			</section>
		</section>
		<?php
	}
}
