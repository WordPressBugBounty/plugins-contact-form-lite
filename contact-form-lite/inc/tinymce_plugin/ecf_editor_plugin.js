(function () {

    function ecfIsGutenbergActive() {
        return typeof wp !== 'undefined' && typeof wp.blocks !== 'undefined';
    }

    tinymce.create('tinymce.plugins.ecficons', {

        init: function (ed, url) {

            var t = this;
            t.url = url;

            if (ecfIsGutenbergActive()) {

                ed.addButton('ecficons', {
                    id: 'ecficons_gut_shorcode',
                    classes: 'ecficons_gut_shorcode_btn',
                    text: 'Easy Contact Form',
                    title: 'Easy Contact Form',
                    cmd: 'mceecficons_mce',
                    image: url + '/ecf_sc_manager.png'
                });

            }

        },

    });

    tinymce.PluginManager.add('ecficons', tinymce.plugins.ecficons);
})();