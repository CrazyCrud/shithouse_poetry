var StateManager = (function(){
	var state = null;

	var viewportWidth = null;

	var states = {
		SMALL: 1,
		MEDIUM: 2,
		LARGE: 3,
		properties: {
			1: {name: "Small", value: 640},
			2: {name: "Medium", value: 1024},
			3: {name: "Large"}
		}
	};

	var setState = function(){
		if (viewportWidth <= states.properties[states.SMALL].value) {
			state = states.properties[states.SMALL].name;
		}
		else if (viewportWidth > states.properties[states.SMALL].value &&
			viewportWidth <= states.properties[states.MEDIUM].value){
			state = states.properties[states.MEDIUM].name;
		}else{
			state = states.properties[states.LARGE].name;
		}
	};

	return {
		init : function(){
			$(window).resize(function(event) {
				viewportWidth = $(window).width();
			});
			setState();
		},
		getState : function(){
			return state;
		},
		States : states
	}
}());

StateManager.init();