<?php
	/* Lädt die JS vom dazugehörigen Block */
	add_action('init', function(){
	    wp_enqueue_script(
	        'mbgi-aktuelles', //name
	        get_template_directory_uri() . '/blocks/mbgi-aktuelles.js', //pfad zur js
	        array('mbgi-block-lib','jquery'), //dependency
			filemtime(get_template_directory() . '/blocks/mbgi-aktuelles.js'), // Version aktualisiert sich mit dem Änderungsdatum
	    );
	    
	    register_block_type('modulbuero/aktuelles', [
			'editor_script' => 'mbgi-aktuelles',
			'render_callback' => 'mb_get_aktuelles_block',
		]);
	});
	
	/* Erstellt die Frontend-Struktur vom Block */
	function mb_get_aktuelles_block($attr, $content) {
		setlocale(LC_TIME, 'de_DE', 'de', 'ge'); // wird hier noch nicht von den einstellungen übernommen. also nochmals setzen

		$posts = get_posts(array(
			'post_type' => isset($_GET["posttype"]) && !empty($_GET['posttype']) ? $_GET["posttype"] : array('post', 'presse', 'medien', 'reden', 'video', 'antraege', 'parlament'),
            'numberposts' => -1,
		));
		if(count($posts) <= 0) return;
		$limit 	= get_option('posts_per_page'); // posts per page
		$page 	= !empty( $_GET["mbgi-aktuelles-page"]) ? (int) $_GET["mbgi-aktuelles-page"] : 1; // aktuelle seite
		$total 	= count($posts); // anzahl beiträge
		$totalPages = ceil($total / $limit); // anzahl seiten
		$page 	= max($page,1); // erste seite wenn page <= 0
		$page 	= min($page, $totalPages); // letzte seite wenn seitenzahl > gesamtseitenanzahl
		$offset = ($page -1) * $limit; // offset an posts
		if($offset < 0) $offset = 0; // fehlerminimierung
		$link 	= get_the_permalink();
		$ansicht 	= isset($_GET['ansicht']) ? $_GET['ansicht'] : "kacheln";
		$posttype 	= isset($_GET['posttype']) ? $_GET['posttype'] : "";
		$result 	= "";
		$filterMenu = "";
		if(!is_admin()) {
			$link .= "?mbgi-aktuelles-page=%d";
			$link .= "&ansicht=$ansicht";
			$link .= "&posttype=$posttype";
			$link .= "#menueanchor";
		}
		$posts = array_slice($posts, $offset, $limit); // teil der posts der angezeigt werden soll auf der seite
		$curr_theme = wp_get_theme()->get('TextDomain');
		
		if(post_type_exists('presse')):
			$hasPressePost = get_posts([
				'post_type' => 'presse', 
		        'posts_per_page' => 1,
		        'fields' => 'ids'
				]
			);
			$hasMedienPost = get_posts([
				'post_type' => 'medien', 
		        'posts_per_page' => 1,
		        'fields' => 'ids'
				]
			);
			$hasVideoPost = get_posts([
				'post_type' => 'video', 
		        'posts_per_page' => 1,
		        'fields' => 'ids'
				]
			);
			$hasRedenPost = get_posts([
				'post_type' => 'reden', 
		        'posts_per_page' => 1,
		        'fields' => 'ids'
				]
			);
			$hasAntraegePost = get_posts([
				'post_type' => 'antraege', 
		        'posts_per_page' => 1,
		        'fields' => 'ids'
				]
			);
			$hasParlamentPost = get_posts([
				'post_type' => 'parlament', 
		        'posts_per_page' => 1,
		        'fields' => 'ids'
				]
			);
			$filterMenu = "<div class='mbgi-aktuelles-filter-menu mbgi-is-$curr_theme'>
				<ul>
					<li". ($ansicht === "kacheln" ? " class='active'" : "") .">
						<a href='?mbgi-aktuelles-page=$page&ansicht=kacheln&posttype=$posttype#menueanchor'><i class='fas fa-border-all'></i><span>Kacheln</span></a>
					</li>
					<li". ($ansicht === "liste" ? " class='active'" : "") .">
						<a href='?mbgi-aktuelles-page=$page&ansicht=liste&posttype=$posttype#menueanchor'><i class='fas fa-bars'></i><span>Liste</span></a>
					</li>";

				if($curr_theme == 'gruenesinternet-komplex'){
				
					$filterMenu .= 
						"<li". (empty($posttype) ? " class='active'" : "") .">
							<a href='?mbgi-aktuelles-page=1&ansicht=$ansicht#menueanchor'>Alle</a>
						</li>
						<li>
							<span class='mbgi-filter-item'>Filter</span>
							<ul class='mbgi-filter-menu'>
								<span class='mbgi-filter-menu-close'></span>
								<li". ($posttype === "post" ? " class='active'" : "") .">
									<a href='?mbgi-aktuelles-page=1&ansicht=$ansicht&posttype=post#menueanchor'>Beiträge</a>
								</li>";
								
								if($hasPressePost):
								$filterMenu .="
								<li". ($posttype === "presse" ? " class='active'" : "") .">
									<a href='?mbgi-aktuelles-page=1&ansicht=$ansicht&posttype=presse#menueanchor'>Pressemitteilungen</a>
								</li>";
								endif;
									
								if($hasRedenPost):
								$filterMenu .="
								<li". ($posttype === "reden" ? " class='active'" : "") .">
									<a href='?mbgi-aktuelles-page=1&ansicht=$ansicht&posttype=reden#menueanchor'>Reden</a>
								</li>
								";
								endif;
								if($hasMedienPost):
								$filterMenu .="
								<li". ($posttype === "medien" ? " class='active'" : "") .">
									<a href='?mbgi-aktuelles-page=1&ansicht=$ansicht&posttype=medien#menueanchor'>In den Medien</a>
								</li>";
								endif;
								if($hasVideoPost):
								$filterMenu .="
								<li". ($posttype === "video" ? " class='active'" : "") .">
									<a href='?mbgi-aktuelles-page=1&ansicht=$ansicht&posttype=video#menueanchor'>Videos</a>
								</li>";
								endif;
								if($hasAntraegePost):
									$filterMenu .="
									<li". ($posttype === "antraege" ? " class='active'" : "") .">
										<a href='?mbgi-aktuelles-page=1&ansicht=$ansicht&posttype=antraege#menueanchor'>Anträge</a>
									</li>";
								endif;
								if($hasParlamentPost):
									$filterMenu .="
									<li". ($posttype === "parlament" ? " class='active'" : "") .">
										<a href='?mbgi-aktuelles-page=1&ansicht=$ansicht&posttype=parlament#menueanchor'>parl. Initiativen</a>
									</li>";
								endif;

							$filterMenu .="
							</ul>
						</li>";
				}	
				
				$filterMenu .="
				</ul>
			</div>";

		endif;
		$listenansicht = ($ansicht == "liste")?'listenansicht':"";
		$result .= "<span id='menueanchor'></span>";
		$result .= "<div class='mbgi-block mbgi-block-aktuelles ".$listenansicht."'>";
			if (empty($posttype)) {
				$result .= "<h2>Aktuelles</h2>";
			} else {
				$result .= "<h2>". mb_aktuelles_posttype2string($posttype) ."</h2>";
			}
            $result .= $filterMenu;
            $result .= "<div class='block-aktuelles-wrap post-loop-single-wrap'>";
			if (!empty($listenansicht)) {
			    $result .= "<div class='mbgi-listenansicht-head'>";
			    	$result .= "<div class='mbgi-listenansicht-content'>";
				        $result .= "<div class='mbgi-listenansicht-head-title'>Inhaltstyp</div>";
				        $result .= "<div class='mbgi-listenansicht-head-title'>Titel</div>";
			        $result .= "</div>";
			        $result .= "<div class='mbgi-listenansicht-time'>";
			        	$result .= "<div class='mbgi-listenansicht-head-title'>Datum</div>";
			        $result .= "</div>";
			    $result .= "</div>";
  				}
			//Wenn das ding leer ist dann mach nix, wenn was drin ist, baue die grüne Zeile auf
            foreach ($posts as $val) { // Die Darstellung entspricht dem content-single-looped template
				ob_start();
				post_class('', $val->ID);
				$post_class = ob_get_clean();
                $result .= "<article $post_class>";
                	if ($val->post_type == "video") {
	                    $result .= "<a class='link' href='". esc_attr( get_post_meta( $val->ID, 'mbgi-youtube-link-meta-box', true ) )."' target='_blank'></a>";
                    } elseif ($val->post_type == "medien") {
	                    $result .= "<a class='link' href='". esc_attr( get_post_meta( $val->ID, 'mbgi-medien-link', true ) )."' target='_blank'></a>";
                    } else {
                    	$result .= "<a class='link' href='". get_the_permalink($val)."'></a>";
                    }
                    $result .= "<div class='date-wrap-container'>";
	                    $result .= "<div class='date-wrap'>";
	                        $result .= "<span class='more'>weiterlesen</span>";
	                        $result .= "<span class='publish-date'>".str_replace("\xe4","ä",strftime('%d. %B %Y',strtotime($val->post_date)))."</span>";
	                    $result .= "</div>";
					$result .= "</div>";
                    $result .= "<div class='post-content'>";
                        if (empty($listenansicht) && has_post_thumbnail( $val )) 
                            $result .= "<div class='thumbnail' style='background-image: url(".get_the_post_thumbnail_url($val->ID,'full').");'></div>";
                         $result .= "<div class='post-content-wrapper'>";
	                        $result .= "<h6 class='post-loop-title'>".get_the_title($val)."</h6>";
	                        if(!has_post_thumbnail($val->ID)){
		                        add_filter('excerpt_length','mb_excerpt_length');
	                        }
	                        
	                        $result .= "<p class='excerpt'>".mb_cut_excerpt(get_the_excerpt($val))."</p>";
	                        
	                        remove_filter('excerpt_length','mb_excerpt_length');
	                        $result .= "<span class='post-type'>";
	                        if(get_post_type($val) == 'post'){
								$result .= 'Beitrag';
							}elseif(get_post_type($val) == 'reden'){
								$result .= 'Rede';
							}elseif(get_post_type($val) == 'presse'){
								$result .= 'Pressemitteilung';
							}elseif(get_post_type($val) == 'parlament'){
								$result .= 'Parlamentarische Initiative';
							}elseif(get_post_type($val) == 'antraege'){
								$result .= 'Antrag';
							}else{
								$result .= ucfirst(get_post_type($val));
							}
	                    $result .= "</span>";
                    $result .= "</div></div>";
               $result .= "</article>";
            }
            $result .= "</div>";
			if($total > $limit):
			$result .= "<nav class='block-aktuelles-nav'>"; // Navigationsleiste wo die seitenzahlen stehen mit entsprechenden links
				$result .= "<div class='nav-links'>"; //seiten links wrap
					if($page > 1){  // zeige den pfeil nach links und letzte seite ab seite 2
						$result .= sprintf("<a class='page-numbers page-first arrow' href='$link'><i class='fas fa-chevron-left'></i></a>", 1); // verlinkt auf die erste seite
						$result .= sprintf("<a class='page-numbers page-before' href='$link'>".($page-1)."</a>", $page-1); // verlinkt auf die vorige seite
					}

					$result .= "<span class='page-numbers current-page'>$page</span>"; // aktuelle seite nicht als link

					if($page < $totalPages){ // zeigt den pfeil nach rechts und nächste seite wenn nicht letzte seite angezeigt wird 
						$result .= sprintf("<a class='page-numbers page-after' href='$link'>".($page+1)."</a>", $page+1); // verlinkt auf die nächste seite
						$result .= sprintf("<a class='page-numbers page-last arrow' href='$link'><i class='fas fa-chevron-right'></i></a>", $totalPages); // verlinkt auf die letzte seite
					}
				$result .= "</div><!-- nav-links -->";
			$result .= "</nav>";
			endif;
		$result .= "</div><!-- mbgi-block -->";

        get_template_part('mbgi', 'frontpage-aktuelles-filtermenu');

		return $result;
	}
	
	/* Enqueue Style für den Block-Editor */
	function mb_enqueue_block_aktuelles_style() {
		$theme = wp_get_theme();
		if($parent = $theme->get('Template')) {
			$child = $theme;
			$theme = wp_get_theme($parent);
		}
		$version = $theme->get( 'Version' );
		wp_enqueue_style('aktuelles-block-css', get_template_directory_uri() . '/blocks/mbgi-aktuelles.css', array('mbgi-main-style'), $version);
	}
	add_action('init', 'mb_enqueue_block_aktuelles_style');
	add_action('admin_init', function(){
		wp_enqueue_style('aktuelles-block-admin-loop-style', get_template_directory_uri() . '/style/style-postloop.css');
	});
	function mb_aktuelles_posttype2string($posttype){
		switch($posttype){
			case 'antraege':
				return 'Anträge';
				break;
			case 'parlament':
				return 'Parlamentarische Initiativen';
				break;
			case 'presse':
				return 'Pressemitteilungen';
				break;
			case 'medien':
				return 'In den Medien';
				break;
			case 'video':
				return 'Videos';
				break;
			case 'reden':
				return 'Reden';
				break;
			case 'post':
				return 'Aktuelles';
				break;
			default:
				return 'Aktuelles';
				break;
		}
	}