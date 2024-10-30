'use strict';
(function ($) {
    $(function () {

        if ($('#jhljs-script').length) {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone(wp.codeEditor.defaultSettings) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2,
                    mode: 'javascript',
                }
            );
            var editor = wp.codeEditor.initialize($('#jhljs-script'), editorSettings);
        }

    });
})(jQuery);