<?php
// When not looking at a product, use post/page metadata
if(get_post_meta($post->ID, 'cc_fb_button_count', true) != ''){
	$cc['fb_button_count'] = get_post_meta($post->ID, 'cc_fb_button_count', true);
	$cc['gp_button_count'] = get_post_meta($post->ID, 'cc_gp_button_count', true);
	$cc['tw_button_count'] = get_post_meta($post->ID, 'cc_tw_button_count', true);
}else{
	$cc['fb_button_count'] = SHARE_FACEBOOK;
	$cc['gp_button_count'] = SHARE_GOOGLE;
	$cc['tw_button_count'] = SHARE_TWITTER;
}
?>
		<div class="navbar-text" style="font-size:16px;vertical-align:super;padding-top:2px;margin-left:0px;">
			<div class="cc-like-rapper">
			<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fsigecig.com%2F&amp;width&amp;layout=button&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=20&amp;appId=<?php echo SHARE_FACEBOOK_APP_ID;?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:20px; width:48px" allowTransparency="true"></iframe><div class="like-cc"><div class="connect_widget_button_count_including" style="margin-left:2px;"><table class="uiGrid" style="margin:0px;padding:0px;"><tbody><tr><td><div class="thumbs_up hidden_elem"></div></td><td><div class="undo hidden_elem"></div></td></tr><tr><td><div class="connect_widget_button_count_nub"><s style="border-right-color:#898f9c;"></s><i></i></div></td><td><div class="connect_widget_button_count_count" style="border: 1px solid #898f9c;border-radius:2px;height:19px;"><?php echo $cc['fb_button_count'];?></div></td></tr></tbody></table></div></div></div>

			<div class="cc-like-rapper" style="display: inline-table;margin-left:8px;">
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://sigecig.com/" data-text="<?php echo SHARE_TWITTER_MESSAGE;?>" data-via="" data-dnt="true" data-count="none">Tweet</a><div class="like-cc" style="margin:3px;"><div class="connect_widget_button_count_including" style="margin-left:2px;"><table class="uiGrid"  style="margin:0px;padding:0px;"><tbody><tr><td><div class="thumbs_up hidden_elem"></div></td><td><div class="undo hidden_elem"></div></td></tr><tr><td><div class="connect_widget_button_count_nub"><s></s><i></i></div></td><td><div class="connect_widget_button_count_count" style="border-radius:4px;height:20px;padding:2px 3px 0px 3px;"><?php echo $cc['tw_button_count'];?></div></td></tr></tbody></table></div></div></div>

			<div class="cc-like-rapper" style="display: inline-table;margin-left:8px;">
				<div class="g-plusone" data-size="medium" data-annotation="none" style="float:left;"></div>
				<div class="like-cc"><div class="connect_widget_button_count_including" style="margin-left:2px;"><table class="uiGrid"  style="margin:0px;padding:0px;"><tbody><tr><td><div class="thumbs_up hidden_elem"></div></td><td><div class="undo hidden_elem"></div></td></tr><tr><td><div class="connect_widget_button_count_nub"><s style="border-right-color:#ccc;"></s><i></i></div></td><td><div class="connect_widget_button_count_count" style="border: 1px solid #ccc;border-radius:2px;height:19px;color:#666;padding:4px;line-height:10px;"><?php echo $cc['gp_button_count'];?></div></td></tr></tbody></table></div></div></div>
		</div>
