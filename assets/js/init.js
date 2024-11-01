//initializing wiremonkey 

;(function($){
window.onload = function(){

	wmky = wmky_settings;

	array_preload_icon = ["img/no-wifi-light.png","img/no-wifi.png","img/wifi.png","img/wifi-light.png"];

	for(n in array_preload_icon){
		var img = new Image();
		img.src = wmky.plugins_url+array_preload_icon[n];
	}
	
	WireMonkey.on("disconnected",function(){
		noticebar = $().tostie({alwaystop:wmky.alwaystop,icon:wmky.showicon,theme:wmky.theme,type:"notice", toastDuration: 2222, message:wmky.disconnect_message});
		})
	.on("connected",function(){
		noticebar.remove();
		$().tostie({alwaystop:wmky.alwaystop,icon:wmky.showicon,theme:wmky.theme,type:"success", message:wmky.connect_message});
		})
	.init(false);
}

}(jQuery));