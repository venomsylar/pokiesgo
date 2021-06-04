jQuery(document).ready(function () {
    jQuery('.select_tab_links').on('click',function () {
        let tabKey = jQuery(this).attr('data-tab-key');
        localStorage.setItem('acfMessageFilter', tabKey);
    });

    if(jQuery('body').hasClass('toplevel_page_theme-general-settings')) {
        let tabKey = localStorage.getItem('acfMessageFilter');
        if(tabKey) {
            jQuery('.acf-tab-button[data-key="' + tabKey + '"]').click();
            localStorage.removeItem('acfMessageFilter');
        }
    }
});