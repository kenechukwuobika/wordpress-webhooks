(function($){
    $("#plugin_rating").bind( 'rated', function(){
        $(this).rateit( 'readonly', true );

        var form        =   {
            action:         'r_rate_recipe',
            rid:            $(this).data( 'rid' ),
            rating:         $(this).rateit( 'value' )
        };

        // $.post( recipe_obj.ajax_url, form, function(data){
            
        // });
    });

    $("#recipe-form").on( 'submit', function(e){
        e.preventDefault();

        $(this).hide();
        $("#recipe-status").html(
            '<div class="alert alert-info">Please wait! We are submitting your recipe.</div>'
        );

        var form                    =   {
            action:                     'r_submit_user_recipe',
            title:                      $("#r_inputTitle").val(),
            content:                    tinymce.activeEditor.getContent()
        }

        $.post( recipe_obj.ajax_url, form, function(data){
            if( data.status == 2 ){
                $('#recipe-status').html(
                    '<div class="alert alert-success">Recipe submitted successfully!</div>'
                );
            }else{
                $('#recipe-status').html(
                    '<div class="alert alert-danger">Unable to submit recipe. Please fill in all fields.</div>'
                );
                $("#recipe-form").show();
            }
        });
    });

    $(document).on( 'submit', '#register-form', function(e){
        e.preventDefault();

        $("#register-status").html(
            '<div class="alert alert alert-info">Please wait!</div>'
        );
        $(this).hide();

        var form                            =   {
            _wpnonce:                           $("#_wpnonce").val(),
            action:                             "recipe_create_account",
            name:                               $("#register-form-name").val(),
            username:                           $("#register-form-username").val(),
            email:                              $("#register-form-email").val(),
            pass:                               $("#register-form-password").val(),
            confirm_pass:                       $("#register-form-repassword").val()
        };

        $.post( recipe_obj.ajax_url, form ).always(function(data){
            if( data.status == 2 ){
                $("#register-status").html(
                    '<div class="alert alert-success">Account created!</div>'
                );
                location.href               =   recipe_obj.home_url;
            }else{
                $("#register-status").html(
                    '<div class="alert alert-danger">Unable to create an account.</div>'
                );
                $("#register-form").show();
            }
        });
    });

    $(document).on( 'submit', '#login-form', function(e){
        e.preventDefault();

        $("#login-status").html('<div class="alert alert-info">Please wait while we log you in.</div>');
        $(this).hide();

        var form                                    =   {
            _wpnonce:                                   $("#_wpnonce").val(),
            action:                                     "recipe_user_login",
            username:                                   $("#login-form-username").val(),
            pass:                                       $("#login-form-password").val()
        };

        $.post( recipe_obj.ajax_url, form ).always(function(data){
            if( data.status == 2 ){
                $("#login-status").html('<div class="alert alert-success">Success!</div>');
                location.href                       =   recipe_obj.home_url;
            }else{
                $("#login-status").html(
                    '<div class="alert alert-danger">Unable to login.</div>'
                );
                $("#login-form").show();
            }
        });
    });

    
    $('.ww_htmitem').each(function () {
        $(this).on('click', function () {
            console.log($(this).children());
            $('.ww_input').text(this.childNodes[1].textContent);
            $('.ww_input').attr('data-callback', this.getAttribute('data-ww-callback'))

            $('#webhook-name').css({ 'visibility': 'visible'});
            $('#webhook-name').css({ 'opacity': '1'});
            $('#webhook-name').css({ 'transform': 'translateY(0rem)'});
            $('#webhook-name').css({ 'position': 'relative'});

            $('#webhook-url').css({ 'visibility': 'visible'});
            $('#webhook-url').css({ 'opacity': '1'});
            $('#webhook-url').css({ 'transform': 'translateY(0rem)'});
            $('#webhook-url').css({ 'position': 'relative'});
        })
    })

    $('.ww_input--item').each(function () {
        




    })
        
    
    $( "#ww_submit" ).on( "click", function(e) {
    e.preventDefault();
    const $this = $( this );
        const webhook_id = document.querySelector('.ww_input').textContent;
        const webhook_callback = $( '.ww_input').attr( 'data-callback' );
        const webhook_url = $( '#webhook-url').val();
        const webhook_name = $( '#webhook-name').val();
        const webhook_current_url = $( '#ww-current-url' ).val();  
    
        $.ajax({
            url : ww_ajax.ajax_url,
            type : 'post',
            data : {
                action : 'ww_create_webhook_trigger',
                 webhook_url,
                webhook_name,
                webhook_group : webhook_id,
                webhook_callback,
                current_url : webhook_current_url,
                ww_nonce: ww_ajax.ajax_nonce
            },
            success : function( $response ) {
                let $webhook = $.parseJSON( $response );
    
                setTimeout(function(){
                   //load spinner here
                    $( '#webhook-url' ).val( '' );
                    $( '#webhook-name' ).val( '' );
    
                    if( $webhook['success'] != 'false' && $webhook['success'] != false ){
                        $( $this ).css( { 'background': '#00a73f' } );
    
                        let $webhook_html = '<tr id= '+webhook_id + '-' + $webhook['webhook'] + '"><th scope="row">' + $webhook['webhook'] + '</th>';
                        $webhook_html += '<td>' + $webhook['webhook_url'] + '</td>';
                        $webhook_html += '<td>' + webhook_id + '</td>';
                        $webhook_html += '<td><a href="#" class="btn btn-primary">demo</a><a href="#" class="btn btn-danger">delete</a><a href="#" class="btn btn-primary">deactivate</a><a href="#" class="btn btn-primary">settings</a></td>';

                        
                        //keiks read this
                        if( $webhook['webhook_callback'] != '' ){
                            $webhook_html += '<br><span class="ironikus-send-demo" ironikus-demo-data-callback="' + $webhook['webhook_callback'] + '" ironikus-webhook="' + $webhook['webhook'] + '" ironikus-group="' + $webhook['webhook_group'] + '" >Send demo</span>';
                        }
    
                        $webhook_html += '</div></td></tr>';
    
                        $( '.ww_send--table > tbody' ).prepend( $webhook_html );
                    } else {
                        $( $this ).css( { 'background': '#a70000' } );
                        confirm( $webhook['msg'] );
                        
                    }
    
                }, 200);
                setTimeout(function(){
                    $( $this ).css( { 'background': '' } );
                }, 2700);
            },
            error: function( errorThrown ){
                setTimeout(function(){
                    $( $this ).children( '.ironikus-save-text' ).toggleClass( 'active' );
                    $( $this ).children( '.ironikus-loader' ).toggleClass( 'active' );
                    $( $this ).css( { 'background': '#a70000' } );
                }, 200);
                setTimeout(function(){
                    $( $this ).css( { 'background': '' } );
                }, 2700);
            }
        });
    });

    $('.ww_doc--help').on('click', function () {
        $('.ww_modal').addClass('ww_modal--active');
    });

    $('.ww_modal--close').on('click', function (e) {
        e.stopPropagation();
        $('.ww_modal').removeClass('ww_modal--active');
        $('.ww_modal--1').css({ 'display': 'block' });
        $('.ww_modal--2').css({ 'display': 'none' });
    });

    $(".ww_triggers--links").each(function () {
        $(this).on('click', function (e) {
            const short_description     =   $(this).siblings()[0].value;
            const return_value          =   $(this).siblings()[1].value;
            e.preventDefault();
           
           $.ajax({
            url     :   ww_ajax.ajax_url,
            type    :   'get',
            data    :   {
                action  :   'ww_get_trigger_description',
                id      :   e.target.id
            },

            success : function( response ) {            
                $('#home').html(response.data.page);
            }
    
           });

            $('.ww_modal--1').css({ 'display': 'none' });
            $('.ww_modal--2').css({ 'display': 'block' });
        });
    });

    //Save the general settings via Ajax
    $("#ww_form--general").on( "submit", submitForm('ww_save_general_settings'));
    //Save the trigger settings via Ajax
    $("#ww_form--trigger").on( "submit", submitForm('ww_save_trigger_settings'));
    //Save the action settings via Ajax
    $("#ww_form--action").on( "submit", submitForm('ww_save_action_settings'));

    function submitForm(action) {
        return function (e) {
        
            e.preventDefault();
            console.log(e);
            let $this = this;
            let form_data = $(this).serialize();
            console.log(form_data);
    
    
            //Prevent from clicking again
            // if( $( $this ).children( '.ironikus-loader' ).hasClass( 'active' ) ){
            //     return;
            // }
            //todo change button HTML within the settings page to the one in the thickbox
            // $( $this ).children( '.ironikus-save-text' ).toggleClass( 'active' );
            // $( $this ).children( '.ironikus-loader' ).toggleClass( 'active' );
    
            $.ajax({
                url : ww_ajax.ajax_url,
                type : 'post',
                data : {
                    action,
                    form_data,
                    ww_nonce: ww_ajax.ajax_nonce
                },
                success : function( $response ) {
                    // var $settings_response = $.parseJSON( $response );
    
                    // window.location = window.location.href;location.reload();
    
                    // if( $settings_response['success'] != 'false' ){
                    //    $( '#ironikus-webhook-id-' + $webhook ).remove();
                    // }
    
                    setTimeout(function(){
                        $( $this ).children( '.ironikus-save-text' ).toggleClass( 'active' );
                        $( $this ).children( '.ironikus-loader' ).toggleClass( 'active' );
    
                        $( $this ).css( { 'background': '#00a73f', 'border-color': '#00a73f' } );
                    }, 200);
                    setTimeout(function(){
                        $( $this ).css( { 'background': '', 'border-color': '' } );
                    }, 2700);
                
                },
                error: function( errorThrown ){
                    console.log(errorThrown);
                }
            });
        }
    
    }
    

})(jQuery);




