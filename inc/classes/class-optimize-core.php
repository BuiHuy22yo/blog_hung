<?php

/**
* Optimize_Core
*
* @package Ctwp
*/

namespace CTWP_THEME\Inc;

use CTWP_THEME\Inc\Traits\Singleton;

class Optimize_Core {
	use Singleton;
    public function __construct()
    {
        $this->setup_hooks();
    }
    protected function setup_hooks() {
		/**
		 * Actions.
		 */        
        add_action('wp_head', array($this,'meta_facebook'),5);
        add_filter( 'style_loader_tag', array($this,'add_rel_preload'), 10, 4 );

	}

    public function meta_facebook() {
        echo '<meta property="fb:app_id" content="466900214051933" />';
    }
    
public function add_rel_preload($html, $handle, $href, $media) {
if (is_admin())
return $html;
if($handle === 'ctwp-first-screen')
return $html;
$html = <<<EOT
<link rel='preload' as='style' onload="this.onload=null;this.rel='stylesheet'" 
id='$handle' href='$href' type='text/css' media='all' />
EOT;

return $html;
}	

}