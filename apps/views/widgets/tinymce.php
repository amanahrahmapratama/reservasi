<script src="<?php echo base_url('media/js/tinymce/tinymce.min.js'); ?>"></script>
<script type="text/javascript">
tinymce.init({
        menu: {// this is the complete default configuration
            file: {title: 'File', items: 'newdocument'},
            edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
            insert: {title: 'Insert', items: 'link media | template hr'},
            view: {title: 'View', items: 'visualaid'},
            format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
            table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
            tools: {title: 'Tools', items: 'spellchecker code'}
        }
    });
tinymce.init({
    selector: 'textarea',
    plugins: "table, paste",
    tools: "inserttable",
    paste_as_text: true,
    theme_advanced_buttons2_add : "apwot",
    branding: false
});
</script>
