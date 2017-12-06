jQuery('document').ready(function(){
        jQuery('.dfw-unit:not(.dfw-lazy-load)').dfp({
                dfpID: dfw.code,
                collapseEmptyDivs: false,
                setTargeting: dfw.targeting,
                sizeMapping: dfw.mappings
	});
});
