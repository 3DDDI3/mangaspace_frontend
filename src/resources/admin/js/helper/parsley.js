import 'parsleyjs';
import 'parsleyjs/dist/i18n/ru';

$.extend(window.Parsley.options, {
    focus: "first",
    excluded:
        "input[type=button], input[type=submit], input[type=reset], .search, .ignore",
    triggerAfterFailure: "change input blur",
    errorsContainer: function (element) { },
    trigger: "change input",
    successClass: "is-valid",
    errorClass: "is-invalid",
    classHandler: function (el) {
        return el.$element.closest(".form-group")
    },
    errorsContainer: function (el) {
        return el.$element.closest(".form-group")
    },
    errorsWrapper: '<div class="parsley-error"></div>',
    errorTemplate: "<span></span>",
})

Parsley.on("field:validated", function (el) {
    var elNode = $(el)[0]

    if (elNode && !elNode.isValid()) {
        var rqeuiredValResult = elNode.validationResult.filter(function (vr) {
            return vr.assert.name === "required"
        })
        if (rqeuiredValResult.length > 0) {
            var fieldNode = $(elNode.element)
            var formGroupNode = fieldNode.closest(".form-group")
            var lblNode = formGroupNode.find(".form-label:first")
            if (lblNode.length > 0) {
                // change default error message to include field label
                var errorNode = formGroupNode.find(
                    "div.parsley-error span[class*=parsley-]"
                )
                if (errorNode.length > 0) {
                    var lblText = lblNode.text()
                    if (lblText) {
                        errorNode.html(lblText + " is required.")
                    }
                }
            }
        }
    }
})