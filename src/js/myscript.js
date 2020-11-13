import 'code-prettify';
//code-prettify is for the export tab for custom post type manager

// code for the tabs in admin
window.addEventListener("load", function() {
    PR.prettyPrint();
    //store tabs variables
    var tabs = document.querySelectorAll( "ul.nav-tabs > li" );
    //run through each tab and on click run function switchTab
    var i = 0;
    for( i = 0; i < tabs.length; i++ ) {
        tabs[i].addEventListener( "click", switchTab );
    }
    function switchTab( event ) {
        // prevents the #tab-2 in the href from being added to URL
        event.preventDefault(); 
        // removes the active class from tabs and panes when others are clicked
        document.querySelector("ul.nav-tabs li.active").classList.remove("active");
        document.querySelector(".tab-pane.active").classList.remove("active");
        // variables
        var clickedTab = event.currentTarget
        var anchor = event.target;
        var activePaneID = anchor.getAttribute("href");
        // Adds active class to tab that is clicked and selects the corresponding pane id
        clickedTab.classList.add("active");
        document.querySelector(activePaneID).classList.add("active");
    }
});

// media widget image select button
jQuery(document).ready(function ($) {
    $(document).on('click', '.js-image-upload', function (e) {
        e.preventDefault();
        var $button = $(this);
        var file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select or Upload an Image',
            library: {
                type: 'image' // mime type
            },
            button: {
                text: 'Select Image'
            },
            multiple: false
        });
        file_frame.on('select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            $button.siblings('.image-upload').val(attachment.url);
        });
        file_frame.open();
    });
});
