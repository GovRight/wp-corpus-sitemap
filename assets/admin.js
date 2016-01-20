(function($) {
    $(document).ready(function() {

        ['create', 'remove', 'gxmls_add', 'gxmls_remove'].forEach(function(x) {
            add_action(x);
        });

        function add_action(action) {
            $('#wpcs_' + action).click(function(e) {
                $('.wpcs_spinner_' + action).show();
                $.post(ajaxurl, {
                    action: 'wpcs_' + action
                }, function(data) {
                    if(data && data.error) {
                        alert(data.error);
                    } else {
                        //window.location.reload();
                    }
                });
                e.preventDefault();
                e.stopPropagation();
                return false;
            });
        }
    });
})(jQuery);
