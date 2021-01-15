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

    document.querySelectorAll('.ww_input--item').forEach(element => {
        element.addEventListener('click', function () {
            document.querySelector('.ww_input').textContent = element.childNodes[1].textContent;
            document.querySelector('.ww_input').setAttribute('data-callback', this.getAttribute('data-ww-callback'))
            console.log(document.querySelector('.ww_input').getAttribute('data-callback'))
            document.querySelector('#webhook-name').style.display = 'block';
            document.querySelector('#webhook-url').style.display = 'block';
        })
    });
    
    // jQuery('.ww_input--item');
    
    
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
        } );
    
    });

})(jQuery);



