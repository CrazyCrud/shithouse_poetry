var $searchLink = $("#link-search");
var $overlayBackground;
var $overlay;
var $backButton;
var $submitButton;
var $searchInput;
var autocompleteList = [];
var tags = [];
var types = [];
var sex = ["Männer", "Frauen", "Unisex"];

var searchTemplate = null; 

$(document).ready(function() {
	searchTemplate = _.template($("script.search-template").html());

	$searchLink.click(function(event) {
		ImgurManager.getSystemTags(getSearchTags);
		// ImgurManager.getUserTags(getSearchTags);
		ImgurManager.getTypes(getSearchTypes);
		appendSearchOverlay();
	});
});

function appendSearchOverlay(){
	createOverlayBackground();

	$("body").append(searchTemplate());

	$overlay = $(".overlaycontent");
	$searchLink = $("#link-search");
	$backButton = $("#back-button");
	$submitButton = $("#search-button");
	$searchInput = $("#search-input");
	$filterSwitch = $("#myonoffswitch");
	$filterTypesContainer = $(".filter-type-container");

	$backButton.click(function(event) {
		removeOverlayBackground();
		$overlay.remove();
	});

	$submitButton.click(function(event) {
		if($searchInput.val().length > 0){
			var url = 'search.php?query=' + $.trim($searchInput.val());
			window.location = url;
		}else if($filterSwitch.is(":checked")){
			var filterFor = $("input:radio[name=filtertype]:checked").val();
			var values = [];
			$.each($('.tag-active').children('span'), function() {
				 values[values.length] = $(this).html();
			});
			if(values.length > 0){
				var url = 'search.php?type=' + filterFor + "&values=" + values;
				window.location = url;
			}
		}
	});

	$filterSwitch.change(function(event) {
		if($(this).is(":checked")){
			$filterTypesContainer.fadeIn(400, function(){
				$searchInput.prop('disabled', true);
				$searchInput.attr('placeholder', '');
				$("#tag-list").hide();
				appendSearchTags($("input:radio[name=filtertype]:checked").val());

		    	$("input:radio[name=filtertype]").change(function(event) {
		    		var filterFor = $("input:radio[name=filtertype]:checked").val();
		    		$("#tag-list").hide();
		    		$("#tag-list").empty();
		    		if(filterFor == "sex"){
		    			appendSearchTags(filterFor, true);
		    		}else{
		    			appendSearchTags(filterFor, false);
		    		}
		    	});
			});
			
		}else{
			$("#tag-list").empty();
			$searchInput.attr('placeholder', 'Suche nach...');
			$searchInput.prop('disabled', false);
			$filterTypesContainer.fadeOut(400);
		}
	});

	$searchInput.on('keypress', function(event) {
		var code = event.which;
		if(code == 13){
			$submitButton.trigger('click');
		}
	});
}

function appendSearchTags(which, singleValue){
	switch(which){
		case "tag":
			for(var i = 0; i < tags.length; i++){
				if(!_.isUndefined(tags[i])){
					appendSingleTag(tags[i], singleValue);
				}
			}
			break;
		case "type":
			for(var i = 0; i < types.length; i++){
				if(!_.isUndefined(types[i])){
					appendSingleTag(types[i], singleValue);
				}
			}
			break;
		case "sex":
			for(var i = 0; i < sex.length; i++){
				if(!_.isUndefined(sex[i])){
					appendSingleTag(sex[i], singleValue);
				}
			}
			break;
	}
	$("#tag-list").fadeIn();
}

function appendSingleTag(tag, singleValue){
	var $tagItem = $("<li><span>" + tag + "</span></li>");

	$tagItem.click(function(event) {
		tagFunctionality($(this), singleValue);
	});

	$("#tag-list").append($tagItem);
}

function tagFunctionality(tag, singleValue){
	var $tag = $(tag);
	if($tag.hasClass('tag-active')){
		$tag.removeClass('tag-active');
		$tag.children('span').removeClass('tag-active-text');
	}else{
		if(singleValue){
			console.log("sasds");
			$.each($('.tag-active'), function() {
				$(this).removeClass('tag-active');
			});
		}
		$tag.addClass('tag-active');
		$tag.children('span').addClass('tag-active-text');
	}
}

function getSearchTags(tagData){
	if(_.isUndefined(tagData) || _.isNull(tagData)){
		return;
	}else{
		if(_.isEmpty(tagData)){
			return;
		}else{
			tags = _.pluck(tagData, 'tag');
		}
	}
}

function getSearchTypes(typeData){
	if(_.isUndefined(typeData) || _.isNull(typeData)){
		return;
	}else{
		if(_.isEmpty(typeData)){
			return;
		}else{
			types = _.pluck(typeData, 'name');
		}
	}
}





