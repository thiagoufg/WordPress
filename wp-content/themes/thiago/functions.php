<?php
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles',99);
function child_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	 wp_enqueue_style( 'child-style',get_stylesheet_directory_uri() . '/custom.css', array( $parent_style ));
}
if ( get_stylesheet() !== get_template() ) {
    add_filter( 'pre_update_option_theme_mods_' . get_stylesheet(), function ( $value, $old_value ) {
         update_option( 'theme_mods_' . get_template(), $value );
         return $old_value; // prevent update to child theme mods
    }, 10, 2 );
    add_filter( 'pre_option_theme_mods_' . get_stylesheet(), function ( $default ) {
        return get_option( 'theme_mods_' . get_template(), $default );
    } );
}

// Password Protected Page Message
function custom_password_form($form) {
  $subs = array(
    '#<p>Este conte(.*?)protegido por senha. Para (.*?), digite sua senha abaixo:</p>#' => '<p>Este artigo esta em construcao. Em breve estara disponivel.</p>',
	'#Senha:#' => '',
	'#Protegido(.*?)#' => 'Em construcao',
    '#<form(.*?)>#' => '<form$1 class="passwordform">',
    '#<input(.*?)type="password"(.*?) />#' => '<input$1type="password"$2 class="text" style="display:none" />',
    '#<input(.*?)type="submit"(.*?) />#' => '<input$1type="submit"$2 class="button" style="display:none" />'
  );

  echo preg_replace(array_keys($subs), array_values($subs), $form);
}

add_filter('the_password_form', 'custom_password_form');
?>