jQuery(function(e) {
    jQuery('.latepoint-admin').on("change", ".os-select-all-toggler", function() {
        var t = jQuery(this).closest(".white-box").find(".os-complex-agents-selector .agent");
        return e(this).is(":checked") ? latepoint_complex_selector_select(t) : latepoint_complex_selector_deselect(t),
            !1
    })
});
