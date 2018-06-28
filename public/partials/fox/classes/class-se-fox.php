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
			'hide_logo' => true,
			'site'	    => 'iis',
		),
		'internetdagarna.se' => array(
			'hide_logo' => false,
			'site'	    => 'internetdagarna',
		),
		'stage.internetdagarna.se' => array(
			'hide_logo' => false,
			'site'	    => 'internetdagarna',
		),
		'www.internetfonden.se' => array(
			'hide_logo' => false,
			'site'	    => 'internetfonden',
		),
		'www.internetstatistik.se' => array(
			'hide_logo' => false,
			'site'	    => 'internetstatistik',
		),
		'www.soi2013.se' => array(
			'hide_logo' => false,
			'site'	    => 'soi2013',
		),
		'www.soi2014.se' => array(
			'hide_logo' => false,
			'site'	    => 'soi2014',
		),
		'www.soi2015.se' => array(
			'hide_logo' => false,
			'site'	    => 'soi2015',
		),
		'digitalalektioner.iis.se' => array(
			'hide_logo' => false,
			'site'	    => 'digitalalektioner',
		),
		'www.poi2014.se' => array(
			'hide_logo' => false,
			'site'	    => 'poi2014',
		),
		'www.sajtkollen.se' => array(
			'hide_logo' => false,
			'site'	    => 'sajtkollen',
		),
		'www.internetmuseum.se' => array(
			'hide_logo' => false,
			'site'	    => 'internetmuseum',
		),
		'www.styleguide.se' => array(
			'hide_logo' => false,
			'site'	    => 'styleguide',
		),
		'kurser.iis.se' => array(
			'hide_logo' => true,
			'site'	    => 'kurser',
		),
		'www.datahotell.se' => array(
			'hide_logo' => false,
			'site'	    => 'datahotell',
		),
		'webbpedagog.se' => array(
			'hide_logo' => false,
			'site'	    => 'webbpedagog',
		),
		'zonemaster.iis.se' => array(
			'hide_logo' => false,
			'site'	    => 'zonemaster',
		),
		'statistik.bredbandskollen.se' => array(
			'hide_logo' => false,
			'site'	    => 'statistikbredbandskollen',
		),
		'www.soi2016.se' => array(
			'hide_logo' => false,
			'site'	    => 'soi2016',
		),
		'www.goto10.se' => array(
			'hide_logo' => false,
			'site'	    => 'goto10',
		),
		'www.soi2017.se' => array(
			'hide_logo' => false,
			'site'	    => 'soi2017',
		),
	);

	/**
	 * Decide which links to display for each site
	 * To add a new site, you insert a new item into the array $fox_mapping, example:
	 * $fox_mapping['www.the-new-site-com'] = array( 'digitalalektioner', 'bredbandskollen', 'soi' );
	 * @since 1.2.1 arkiv.internetmuseum.se
	*/
	private static $fox_mapping = array(
		'www.iis.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'internetdagarna.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'goto10',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'stage.internetdagarna.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'goto10',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.internetfonden.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
			'soi',
			'iisblogg',
			'guider',
			'internetmuseum',
		),
		'www.internetstatistik.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.internetmuseum.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
			'soi',
			'iisblogg',
			'guider',
		),
		'www.soi2013.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.soi2014.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.soi2015.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.poi2014.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'digitalalektioner.iis.se' => array(
			'domaner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
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
			'goto10',
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
			'goto10',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'arkiv.internetmuseum.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
			'soi',
			'iisblogg',
			'guider',
		),
		'kurser.iis.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.datahotell.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'webbpedagog.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'zonemaster.iis.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
			'soi',
			'iisblogg',
			'guider',
			'internetmuseum',
		),
		'statistik.bredbandskollen.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.soi2016.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.goto10.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'soi',
			'iisblogg',
			'guider',
			'internetfonden',
			'internetmuseum',
		),
		'www.soi2017.se' => array(
			'domaner',
			'digitalalektioner',
			'bredbandskollen',
			'internetdagarna',
			'goto10',
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
			'link' => 'https://www.iis.se/domaner',
			'hashtags' => '',
			'name' => 'Domäner',
			'content' => 'Registrera din .se- eller .nu-domän här',
			'linktext' => 'Till domäner',
		),
		'bredbandskollen' => array(
			'link' => 'https://www.bredbandskollen.se',
			'hashtags' => '',
			'name' => 'Bredbandskollen',
			'content' => 'Verktyget som hjälper dig att testa uppkopplingen på ditt bredband',
			'linktext' => 'Till bredbandskollen.se',
		),
		'digitalalektioner' => array(
			'link' => 'https://digitalalektioner.iis.se',
			'hashtags' => '',
			'name' => 'Digitala lektioner',
			'content' => 'Fritt material för lärare i digital kompetens',
			'linktext' => 'Till digitalalektioner.iis.se',
		),
		'internetdagarna' => array(
			'link' => 'https://internetdagarna.se',
			'hashtags' => '',
			'name' => 'Internetdagarna',
			'content' => 'Sveriges viktigaste mötesplats för alla som jobbar med internet',
			'linktext' => 'Till internetdagarna.se',
		),
		'goto10' => array(
			'link' => 'https://www.goto10.se',
			'hashtags' => '',
			'name' => 'Goto 10',
			'content' => 'Kostnadsfri start- och mötesplats för alla som vill utveckla sin internetidé',
			'linktext' => 'Till goto10.se',
		),
		'soi' => array(
			'link' => 'http://www.svenskarnaochinternet.se',
			'hashtags' => '',
			'name' => 'Svenskarna & internet',
			'content' => 'Sveriges viktigaste undersökning om svenskarnas internetvanor',
			'linktext' => 'Till svenskarnaochinternet.se',
		),
		'iisblogg' => array(
			'link' => 'https://www.iis.se/blogg',
			'hashtags' => '',
			'name' => 'IIS-bloggen',
			'content' => 'Nyheter och kommentarer från internetvärlden',
			'linktext' => 'Till IIS-bloggen',
		),
		'guider' => array(
			'link' => 'https://www.iis.se/fakta/',
			// hashtags måste skrivas ut efter utm_source etc för att fungera, anges därför som egen variabel
			'hashtags' => '#typ=internetguider',
			'name' => 'Internetguider',
			'content' => 'Gratis kunskap om internet, paketerat i lättillgängliga guider',
			'linktext' => 'Till internetguider',
		),
		'internetfonden' => array(
			'link' => 'https://www.internetfonden.se',
			'hashtags' => '',
			'name' => 'Internetfonden',
			'content' => 'Finansierar projekt som syftar till att förbättra internet i Sverige',
			'linktext' => 'Till internetfonden.se',
		),
		'internetmuseum' => array(
			'link' => 'http://www.internetmuseum.se',
			'hashtags' => '',
			'name' => 'Internetmuseum',
			'content' => 'Här tar vi dig med på en resa genom den svenska internethistorien',
			'linktext' => 'Till internetmuseum.se',
		),
	);

	/* NO NEED TO CHANGE THE CODE BELOW */


	/**
	 * Delay loading of the fox plugin until after functions.php is loaded
	 */
	function _fox_after_setup_theme() {
		$load_fox = true;
		$load_fox = apply_filters( 'fox_load', $load_fox );
		if ( $load_fox ) {
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


	function body_class( $classes ) {
		$domain = $this::get_fox_domain();

		$classes[] = 'sewebb-nav-space';
		$domain    = str_replace( 'www.', '', str_replace( '.se', '', $domain ) );
		//Eftersom vi annars får en del ogiltiga klasser som ex kurser.iis
		$classes[] = str_replace( '.', '-', $domain );

		return $classes;
	}

	function get_fox_domain() {
		$domain = $_SERVER['SERVER_NAME'];
		$domain = str_replace( '.dev', '.se', $domain );
		$domain = str_replace( 'local.', 'www.', $domain );
		$domain = str_replace( 'vvv.kurser.se', 'kurser.iis.se', $domain );
		$domain = str_replace( 'vvv.zonemaster.se', 'zonemaster.iis.se', $domain );
		$domain = str_replace( 'vvv.', 'www.', $domain );
		$domain = str_replace( 'www.stage.', 'www.', $domain );
		$domain = str_replace( 'stage.arkiv.', 'arkiv.', $domain );
		$domain = str_replace( 'stage.zonemaster.', 'zonemaster.', $domain );
		$domain = str_replace( 'stage.internetdagarna.', 'internetdagarna.', $domain );
		$domain = str_replace( 'stage.', 'www.', $domain );
		$domain = str_replace( 'iis.web1.common.', 'www.', $domain );
		$domain = str_replace( 'soi.se', 'www.soi2017.se', $domain );
		return $domain;
	}

	function get_site_config() {
		$domain = $this::get_fox_domain();
		$domain_is_declared = isset( self::$fox_mapping[ $domain ] );
		if ( $domain_is_declared ) {
			return self::$fox_site_config[ $domain ];
		}

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
					$domain_is_declared = isset( self::$fox_mapping[ $domain ] );
					if ( $domain_is_declared ) {
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
						<?php endforeach;
					}
					?>
				</ul>
			</section>
		</section>
		<?php
	}
}
