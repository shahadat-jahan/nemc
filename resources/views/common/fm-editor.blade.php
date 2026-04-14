<script>
    var route_prefix = "{{ url(config('lfm.url_prefix', config('lfm.prefix'))) }}";
</script>
<!-- TinyMCE init -->
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    var editor_config = {
        path_absolute: "",
        selector: ".text-editor",
        entity_encoding: "raw",
        apply_source_formatting : false,
        verify_html : false,
        valid_elements : '*[*]',
        valid_children: '*[*]',
        // element_format : 'html',
        allow_script_urls: true,
        // cleanup : false,
        // schema: "html5",
        // extended_valid_elements:"script[charset|defer|language|src|type]",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        // for customizing menu items
        // menu: {
        //     file: {title: 'File', items: 'newdocument'},
        //     edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
        //     insert: {title: 'Insert', items: 'link media | template hr'},
        //     view: {title: 'View', items: 'visualaid'},
        //     format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
        //     table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
        //     tools: {title: 'Tools', items: 'spellchecker code'}
        // },
        menubar: 'file edit insert view format tools help',
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright | preview code | link image',
        relative_urls: false,
        height: 500,
        file_browser_callback: function (field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + route_prefix + '?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }
            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'File Manager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no"
            });
        }
    };
    tinymce.init(editor_config);
</script>
<script src="{!! asset('vendor/laravel-filemanager/js/lfm.js') !!}"></script>
<script>
    $('#lfm').filemanager('image', {prefix: route_prefix});
    $('#lfm2').filemanager('file', {prefix: route_prefix});
</script>
