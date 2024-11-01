<?php
/*
Plugin Name: Wireclub Chat
Version: 1.2
Plugin URI: http://www.wireclub.com/chat
Description: Embedded Chat for Wordpress
Author: Wireclub Media Inc.
Author URI: http://www.wireclub.com

Copyright 2009-2012  Wireclub Media Inc.  (email : sysop@wireclub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/            

// [embedchat name="value" height="value"]
function embedchat_func($atts, $content=null) {

  $embedCode = '<div>
                  <iframe src="http://www.wireclub.com/chat/room/####/embed" width="100%" height="@@@@" scrolling="no" frameborder="0" allowtransparency="true" hspace="0" vspace="0" marginheight="0" marginwidth="0">
                  </iframe>
                  <div style="text-align: right;">
                    <a href="http://www.wireclub.com">Chat Rooms by Wireclub</a>
                  </div>
                </div>';

	extract(shortcode_atts(array('name' => get_option('ChatRoomName'), 'height' => get_option('ChatRoomHeight'), ), $atts));
	$code = str_replace('@@@@', $height, $embedCode);
	
	$replace = preg_replace('/\W/i', '_', $name);
	$lowercase = strtolower($replace);
	$code = str_replace('####', urlencode($lowercase), $code);
	return $code;
}

// [chatbadge name="value"]
function chatbadge_func($atts, $content=null) {
  
  $badgeCode = '<a href="http://www.wireclub.com/chat/rooms/####/embed">
                  <img alt="Chat in my room: @@@@" src="http://static.wireclub.com/content/images/promotions/chat.png"/>
                </a>';

	extract(shortcode_atts(array('name' => get_option('ChatRoomName')), $atts));

	$replace = preg_replace('/\W/i', '_', $name);
	$lowercase = strtolower($replace);
	$code = str_replace('@@@@', $name, $badgeCode);
  $code = str_replace('####', urlencode($lowercase), $code);
  return $code;
}

function EmbeddedChatMenu() {
  add_options_page('Embedded Chat Options', 'Chat', 8, __FILE__, 'EmbeddedChatOptions');
}

function EmbeddedChatOptions() {
?>
<div class="wrap">
  <h2>Wireclub Embedded Chat for Wordpress</h2>
  <p>
    I hope you enjoy our embedded chat plug-in. It is completely free and we just ask that you do not remove our links because this is how we are able keep it as a free service. If you remove our links, you can expect to be punished by karma. What goes around...comes around!
  </p>
  <p>
    <b>Important note about room names:</b> Rooms are globaly shared across all users of this plug-in. Example: if you and a friend want to have a shared room, just install the plug-in and pick the same room name. If you want to make sure your room isn't shared, just pick a unique name!
  </p>
  <p>
    To know more about Wireclub: <a href='http://www.wireclub.com'>http://www.wireclub.com</a>
  </p>
  <p>
  <h2>Shortcodes</h2>
  <p>
    To add a chatroom: <b>[embedchat name="your room name" height="desired height"]</b> or simply <b>[embedchat]</b> to use the default values
  </p>  
  <p>
    To add a badge: <b>[chatbadge name="your room name"]</b> or simply <b>[chatbadge]</b> to use the default values
  </p>  
  <h2>Options</h2>
  <form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>
    <table class="form-table">
      <tr valign="top">
        <th scope="row">Default room:</th>
        <td><input type="text" name="ChatRoomName" value="<?php echo get_option('ChatRoomName'); ?>" /></td>
        <th scope="row">Default height:</th>
        <td><input type="text" name="ChatRoomHeight" value="<?php echo get_option('ChatRoomHeight'); ?>" /></td>
      </tr>
    </table>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="ChatRoomName, ChatRoomHeight" />
    <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
  </form>
</div>
<?php
}

add_option('ChatRoomHeight', '500');
add_option('ChatRoomName', str_replace('http://', '', get_bloginfo('url')));
add_action('admin_menu', 'EmbeddedChatMenu');
add_shortcode('embedchat', 'embedchat_func');
add_shortcode('chatbadge', 'chatbadge_func');
add_filter('widget_text', 'do_shortcode');

?>