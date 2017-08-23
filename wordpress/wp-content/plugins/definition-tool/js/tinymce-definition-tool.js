( function() {
    tinymce.PluginManager.add( 'definition_tool', function( editor, url ) {
        // Add a button that opens a window
        editor.addButton( 'definition_tool', {
            text: 'Definition Tool',
            icon: false,
            onclick: function() {
                // Open window
                editor.windowManager.open( {
                    title: 'Enter definition',
                    body: [{
                        type: 'textbox',
                        name: 'title',
                        label: 'Definition'
                    }],
                    onsubmit: function( e ) {
                        // Insert content when the window form is submitted
                        var text = editor.selection.getContent({
                            'format': 'html'
                        });
                        if ( text.length === 0 ) {
                            return;
                        }
                        
                        editor.execCommand('mceReplaceContent', false, '[definition_tool text="'+e.data.title+'"]' + text + '[/definition_tool]');
                    }
                } );
            }
        } );
    } );
} )();