(function($){

    const state = {
        triggers: {},
        actions: {},
    }

    $("#plugin_rating").bind( 'rated', function(){
        $(this).rateit( 'readonly', true );

        var form        =   {
            action:         'r_rate_recipe',
            rid:            $(this).data( 'rid' ),
            rating:         $(this).rateit( 'value' )
        };

        
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

    
    $('.ww_input--item').each(function (element) {
        $(this).on('click', function () {
            $('.ww_input').text(this.childNodes[1].textContent);
            $('.ww_input').attr('ww-data-callback', this.getAttribute('data-ww-callback'))

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
        
    const clear_error = () => {
        setTimeout(() => {
            $('.ww_alert').removeClass('ww_alert--active alert-danger alert-success');
            $('.ww_alert').text('');
        }, 5000);
    }
    
    $( "#ww_submit" ).on( "click", function(e) {
        let error = [];
        e.preventDefault();
        const webhook_group = document.querySelector('.ww_input').textContent;
        const webhook_callback = $( '.ww_input').attr( 'ww-data-callback' );
        const webhook_url = $( '#webhook-url').val();
        const webhook_name = $( '#webhook-name').val();
        const webhook_current_url = $( '#ww-current-url' ).val();  

        if(!webhook_group){
            error.push( "Please select a trigger");
            $('.ww_alert').addClass('ww_alert--active alert-danger');
            $('.ww_alert').text(error);
            clear_error();
            return;
        }
        else{
            if(!webhook_name){
                error.push( "Please enter a name for your webhook trigger");
                $('.ww_alert').addClass('ww_alert--active alert-danger ');
                $('.ww_alert').text(error);
                clear_error();
                return;
            }
            if(!webhook_url){
                error.push( "Please enter a url for your webhook trigger");
                $('.ww_alert').addClass('ww_alert--active alert-danger');
                $('.ww_alert').text(error);
                clear_error();
                return;
            }
        }
        
    
        $.ajax({
            url : ww_ajax.ajax_url,
            type : 'post',
            data : {
                action : 'ww_create_webhook_trigger',
                webhook_url,
                webhook_name,
                webhook_status: 'active',
                webhook_group,
                webhook_callback,
                current_url : webhook_current_url,
                ww_nonce: ww_ajax.ajax_nonce
            },
            success : function( $response ) {
                let webhook = $.parseJSON( $response );
                setTimeout(function(){
                   //load spinner here
                    $( '#webhook-url' ).val( '' );
                    $( '#webhook-name' ).val( '' );
    
                    if( webhook['success'] != 'false' && webhook['success'] != false ){
                        $('.ww_alert').addClass('ww_alert--active alert-success');
                        $('.ww_alert').text("Trigger was successfully created");
                        clear_error();
                       
                        state.triggers[webhook['webhook']] = webhook;
                        display_webhook_triggers();
                    } else {
                        $( this ).css( { 'background': '#a70000' } );
                        confirm( webhook['msg'] );
                        
                    }
    
                }, 200);
                setTimeout(function(){
                    $( this ).css( { 'background': '' } );
                }, 2700);
            },
            error: function( errorThrown ){
                setTimeout(function(){
                    $( this ).children( '.ironikus-save-text' ).toggleClass( 'active' );
                    $( this ).children( '.ironikus-loader' ).toggleClass( 'active' );
                    $( this ).css( { 'background': '#a70000' } );
                }, 200);
                setTimeout(function(){
                    $( this ).css( { 'background': '' } );
                }, 2700);
            }
        });
    });

    $( "#ww_create--action" ).on( "click", function(e) {
        let error = [];
        e.preventDefault();
        const webhook_name = $( '#ww_webook--action').val();
        
        if(!webhook_name){
            error.push( "Please enter a name for your webhook action");
            $('.ww_alert').addClass('ww_alert--active alert-danger ');
            $('.ww_alert').text(error);
            clear_error();
            return;
            
        }
        
    
        $.ajax({
            url : ww_ajax.ajax_url,
            type : 'post',
            data : {
                action : 'ww_create_webhook_action',
                webhook_name,
                webhook_status: 'active',
                ww_nonce: ww_ajax.ajax_nonce
            },
            success : function( $response ) {
                let webhook = $.parseJSON( $response );
                setTimeout(function(){
                   //load spinner here
                    $( '#ww_webook--action' ).val( '' );
    
                    if( webhook['success'] != 'false' && webhook['success'] != false ){
                        $('.ww_alert').addClass('ww_alert--active alert-success');
                        $('.ww_alert').text("Trigger was successfully created");
                        clear_error();
                       
                        state.actions[webhook['webhook']] = webhook;
                        display_webhook_actions();
                    } else {
                        $( this ).css( { 'background': '#a70000' } );
                        confirm( webhook['msg'] );
                        
                    }
    
                }, 200);
                setTimeout(function(){
                    $( this ).css( { 'background': '' } );
                }, 2700);
            },
            error: function( errorThrown ){
                setTimeout(function(){
                    $( this ).children( '.ironikus-save-text' ).toggleClass( 'active' );
                    $( this ).children( '.ironikus-loader' ).toggleClass( 'active' );
                    $( this ).css( { 'background': '#a70000' } );
                }, 200);
                setTimeout(function(){
                    $( this ).css( { 'background': '' } );
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
            e.preventDefault();
            // const short_description     =   $(this).siblings()[0].value;
            // const return_value          =   $(this).siblings()[1].value;
           
           $.ajax({
            url     :   ww_ajax.ajax_url,
            type    :   'get',
            data    :   {
                action  :   'ww_get_trigger_description',
                id      :   e.target.id
            },

            success : function( response ) {     
                console.log(response)       
                $('#home').html(response.data.page);
                $('#profile').html(response.data.page);
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
            let form_data = $(this).serialize();
            let btn = $( `#${e.target.id} .ww_btn` );
            let btn_text = btn.children()[0];
            let btn_loader = btn.children()[1];
            
    
            $.ajax({
                url : ww_ajax.ajax_url,
                type : 'post',
                data : {
                    action,
                    form_data,
                    ww_nonce: ww_ajax.ajax_nonce
                },
                success : ( response ) => {
    
                    setTimeout(() => {
                        $(btn_text).addClass('ww_btn--text_inactive');
                        $(btn_loader).addClass('ww_btn--icon_active');
                        $(btn).prop('disabled', true);

                    }, 200);

                    setTimeout(() => {
                    $('.ww_alert').addClass('ww_alert--active');
                    $(btn_loader).removeClass('ww_btn--icon_active');
                    $(btn_text).removeClass('ww_btn--text_inactive');
                    $(btn).prop('disabled', false);
                    }, 4000);

                    setTimeout(() => {
                        $('.ww_alert').removeClass('ww_alert--active');
                    }, 10000);
                
                },
                error: function( errorThrown ){
                    console.log(errorThrown);
                }
            });
        }
    
    }

    function send_demo(e, element) {
        e.preventDefault();
        let webhook = $( element ).attr( 'ww-data-trigger' );
        let webhook_callback = $( element ).attr( 'ww-data-callback' );
        let webhook_group = $( element ).attr( 'ww-data-webhook-group' );
        let data = {
            action : 'ww_test_webhook_trigger',
            webhook : webhook,
            webhook_group,
            webhook_callback,
            ww_nonce: ww_ajax.ajax_nonce
        };

        $.ajax({
            url : ww_ajax.ajax_url,
            type : 'post',
            data ,
            success : ( response ) => {
                let webhook_response = $.parseJSON( response );

                setTimeout(() => {

                    if( webhook_response['success'] != 'false' ){
                        $( element ).css( { 'color': '#00a73f' } );
                    } else {
                        $( element ).css( { 'color': '#a70000' } );
                    }

                }, 200);
                setTimeout(() => {
                    $( element ).css( { 'color': '' } );
                }, 2700);
            },
            error: ( errorThrown ) => {
                console.log(errorThrown);
            }
        } );
    }

    function deactivate_trigger(e, element) {
        e.preventDefault();
        let webhook = $( element ).attr( 'ww-data-trigger' );
        let webhook_status = $( element ).attr( 'ww-data-webhook-status' );
        let data = {
            action : 'ww_deactivate_webhook',
            webhook,
            webhook_status,
            ww_nonce: ww_ajax.ajax_nonce
        };

        $.ajax({
            url : ww_ajax.ajax_url,
            type : 'post',
            data,
            success : ( response ) => {
                let webhook_response = $.parseJSON( response );
                
                if(webhook_status === 'active' ){
                    $( element ).attr( 'ww-data-webhook-status', 'inactive');
                    if(Object.entries(state.triggers).length !== 0){
                        state.triggers[data.webhook]['status'] = 'inactive';
                    }
                    if(Object.entries(state.actions).length !== 0){
                        state.actions[data.webhook]['status'] = 'inactive'
                    }
                    $(e.target.parentNode).css({ 'color': '#28b485' });
                    $($(element).siblings()[0]).addClass('ww_action--icon__inactive');
                    $($(element).siblings()[1]).addClass('ww_action--icon__active');
                }
                else{
                    $( element ).attr( 'ww-data-webhook-status', 'active');
                    if(Object.entries(state.triggers).length !== 0){
                        state.triggers[data.webhook]['status'] = 'active';
                    }
                    if(Object.entries(state.actions).length !== 0){
                        state.actions[data.webhook]['status'] = 'active'
                    }

                    $(e.target.parentNode).css({ 'color': '#ff7730' });
                    $($(element).siblings()[0]).removeClass('ww_action--icon__inactive');
                    $($(element).siblings()[1]).removeClass('ww_action--icon__active');
                }
                $(element).text(webhook_response.new_status_name);
                
            },
            error: function( errorThrown ){
                console.log(errorThrown);
            }
        });
    
    }

    function delete_trigger(e, element) {
        e.preventDefault();
        if (confirm("Are you sure you want to delete this webhook?")){
            let webhook = $(element).attr( 'ww-data-trigger' );
            $.ajax({
                url : ww_ajax.ajax_url,
                type : 'post',
                data : {
                    action : 'ww_delete_webhook_trigger',
                    webhook,
                    ww_nonce: ww_ajax.ajax_nonce
                },
                success : function( response ) {
                    let webhook_response = $.parseJSON( response );
                    delete(state.triggers[webhook_response['webhook']]);
                    display_webhook_triggers();
                    if( webhook_response['success'] != 'false' ){
                        $( element.parentNode ).remove();
                    }
                    
                },
                error: function( errorThrown ){
                    console.log(errorThrown);
                }
            });

        }

    }

    function delete_action(e, element) {
        e.preventDefault();
        if (confirm("Are you sure you want to delete this webhook?")){
            let webhook = $(element).attr( 'ww-data-trigger' );
            $.ajax({
                url : ww_ajax.ajax_url,
                type : 'post',
                data : {
                    action : 'ww_delete_webhook_action',
                    webhook,
                    ww_nonce: ww_ajax.ajax_nonce
                },
                success : function( response ) {
                    let webhook_response = $.parseJSON( response );
                    console.log(webhook_response)
                    console.log(state.actions[webhook_response['webhook']])
                    delete(state.actions[webhook_response['webhook']]);
                    display_webhook_actions();
                    if( webhook_response['success'] != 'false' ){
                        $( element.parentNode ).remove();
                    }
                    
                },
                error: function( errorThrown ){
                    console.log(errorThrown);
                }
            });

        }

    }
    
    $( "tbody" ).on( "click", function(e) {
        let element = $(e.target);
        if(element.attr('ww-data-callback')){
            send_demo(e, element);
        }
        else if(element.attr('ww-data-delete-trigger')){
            delete_trigger(e, element);
        }
        else if(element.attr('ww-data-delete-action')){
            delete_action(e, element);
        }
        else if(element.attr('ww-data-webhook-status')){
            deactivate_trigger(e, element);
        }
        
    });


    const display_webhook_triggers = (term='', filter='') => {
        
        const data =  {...state.triggers};
        const keys = Object.keys(data);
        let values = Object.values(data);
        let webhook_html = '';

        if(filter){
            values = values.filter(element => {
                if (element['webhook_name'] === filter) {
                    return element;
                }
            })
        }
                 
        if(term){
            const arr = [];
            keys.forEach(element => {
                if(element.includes(term)){
                    arr.push(data[element]);
                }
            });
            values = [...arr]

            if(values.length === 0){
                $( '.ww_send--table > tbody' ).html( `<div class="alert alert-info">"${term}" does not match any trigger</div>` );
        return;
            }
        }

        const compare = (a, b) => b.date_created.localeCompare(a.date_created);
        values.sort( compare );

        if(values.length === 0){
            $( '.ww_send--table > tbody' ).html( `<svg class="" xmlns="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/1999/xlink" width='50' height='50' viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
						
            <circle cx="50" cy="50" r="24" stroke-width="6" stroke="#fff" stroke-dasharray="50.26548245743669 50.26548245743669" fill="none" stroke-linecap="round">
            <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1.5s" keyTimes="0;1" values="0 50 50;360 50 50"/>
            </circle>
        </svg>` );
        }

        values.forEach((webhook, index) => {   
                        
            const webhook_slug = keys.find(element => {
                if(state.triggers[element] === webhook){
                    return element
                }
            });
            let webhook_name = webhook_slug;
            let webhook_url = webhook['webhook_url'];
            let webhook_callback = webhook['webhook_callback'];
            let webhook_group =    webhook['webhook_name'];
            let webhook_status =    webhook['status'];

            let status = 'active';
            let status_name = 'Deactivate';
            if( webhook_status && webhook_status == 'inactive' ){
                status = 'inactive';
                status_name = 'Activate';
            }
            
            
            webhook_html += '<tr id= ww_trigger--' + webhook_name + '"><th scope="row">' + webhook_name + '</th>';
            webhook_html += '<td>' + webhook_url + '</td>';
            webhook_html += '<td>' + webhook_group + '</td>';
            webhook_html += '<td class="d-flex mr-auto">';
            

            webhook_html    += `<div class="ww_action--items ww_action--demo">
            <svg class="ww_action--icon" xmlns="http://www.w3.org/2000/svg" width="31.5" height="27" viewBox="0 0 31.5 27">
                <path d="M3.015,31.5,34.5,18,3.015,4.5,3,15l22.5,3L3,21Z" transform="translate(-3 -4.5)" fill="#5643fa" />
            </svg>

                <a href="#" 
                ww-data-trigger=${webhook_name} 
                ww-data-callback=${webhook_callback} 
                ww-data-webhook-group= ${webhook_group}
                class="ww_action--links ww_trigger--demo">Demo</a>
            </div>`;
            
            webhook_html    += `<div class="ww_action--items ww_action--settings">
            <svg class="ww_action--icon" xmlns="http://www.w3.org/2000/svg" width="12.26" height="12.263" viewBox="0 0 12.26 12.263">
                <path style="fill: currentColor" id="Icon_ionic-ios-settings" data-name="Icon ionic-ios-settings" d="M15.748,10.63A1.578,1.578,0,0,1,16.76,9.158,6.253,6.253,0,0,0,16,7.335a1.6,1.6,0,0,1-.642.137,1.574,1.574,0,0,1-1.44-2.216A6.235,6.235,0,0,0,12.1,4.5a1.576,1.576,0,0,1-2.944,0,6.253,6.253,0,0,0-1.823.757A1.574,1.574,0,0,1,5.9,7.472a1.547,1.547,0,0,1-.642-.137A6.392,6.392,0,0,0,4.5,9.161a1.577,1.577,0,0,1,0,2.944,6.253,6.253,0,0,0,.757,1.823,1.575,1.575,0,0,1,2.078,2.078,6.29,6.29,0,0,0,1.823.757,1.573,1.573,0,0,1,2.937,0,6.253,6.253,0,0,0,1.823-.757A1.576,1.576,0,0,1,16,13.928a6.29,6.29,0,0,0,.757-1.823A1.585,1.585,0,0,1,15.748,10.63Zm-5.089,2.551a2.554,2.554,0,1,1,2.554-2.554A2.553,2.553,0,0,1,10.659,13.181Z" transform="translate(-4.5 -4.5)" fill="#395ff5"/>
            </svg>

                <a href="#" class="ww_action--links ww_trigger--settings">settings</a>
            </div>`;

            webhook_html   +=      `<div class="ww_action--items ww_action--deactivate">
                <svg class="ww_action--icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11.438 11.438">
                    <path style="fill: currentColor" id="Icon_awesome-stop-circle" data-name="Icon awesome-stop-circle" d="M6.281.563A5.719,5.719,0,1,0,12,6.281,5.718,5.718,0,0,0,6.281.563ZM8.495,8.126a.37.37,0,0,1-.369.369H4.436a.37.37,0,0,1-.369-.369V4.436a.37.37,0,0,1,.369-.369h3.69a.37.37,0,0,1,.369.369Z" transform="translate(-0.563 -0.563)" fill="#395ff5"/>
                </svg>

                <svg class="ww_action--icon__abs" xmlns="http://www.w3.org/2000/svg" width="7.464" height="9.5" viewBox="0 0 7.464 9.5">
                    <path style="fill: currentColor" d="M12,7.5V17l7.464-4.75Z" transform="translate(-12 -7.5)" fill="#395ff5"/>
                </svg>
                <a 
                    href="#" 
                    class="ww_action--links ww_trigger--deactivate" 
                    ww-data-webhook-status=${status} 
                    ww-data-trigger="${webhook_name}" 
                >
                    ${status_name}
                </a>
            </div>`;
    
            webhook_html    +=  `<div class="ww_action--items ww_action--delete">
            <svg class="ww_action--icon" xmlns="http://www.w3.org/2000/svg" width="7.98" height="10.26" viewBox="0 0 7.98 10.26">
                <path style="fill: currentColor" d="M8.07,13.62a1.143,1.143,0,0,0,1.14,1.14h4.56a1.143,1.143,0,0,0,1.14-1.14V6.78H8.07Zm7.41-8.55H13.485l-.57-.57h-2.85l-.57.57H7.5V6.21h7.98Z" transform="translate(-7.5 -4.5)" fill="#395ff5"/>
            </svg>
            <a 
                href="#" 
                class="ww_action--links ww_trigger--delete"
                ww-data-delete-trigger="Are you sure you want to delete <b>${webhook_group}></b> trigger?"
                ww-data-trigger="${webhook_name}" 
            >
            delete
            </a>`

            webhook_html    += '</td>';


            
            //keiks read this
            if( webhook['webhook_callback'] != '' ){
                webhook_html += '<br><span class="ironikus-send-demo" ironikus-demo-data-callback="' + webhook['webhook_callback'] + '" ironikus-webhook="' + webhook['webhook'] + '" ironikus-group="' + webhook['webhook_group'] + '" >Send demo</span>';
            }

            webhook_html += '</div></td></tr>';

            

            
        });

        $( '.ww_send--table > tbody' ).html( webhook_html );

        let status    =   $('.ww_action--deactivate > .ww_trigger--deactivate');
        if(status){
            status.each(function(element) {
                if($(this).text().trim() === 'Activate'){
                    $(this.parentNode).css({ 'color': '#00a73f' })
                    $($(this).siblings()[0]).addClass('ww_action--icon__inactive');
                    $($(this).siblings()[1]).addClass('ww_action--icon__active');
                }
            });
        }
        
    }

    const display_webhook_actions = (term='') => {
        
        const data =  {...state.actions};
        const keys = Object.keys(data);
        let values = Object.values(data);
        let webhook_html = '';
         if(term){
            const arr = [];
            keys.forEach(element => {
                if(element.includes(term)){
                    arr.push(data[element]);
                }
            });
            values = [...arr]

            if(values.length === 0){
                $( '.ww_send--table > tbody' ).html( `<div class="alert alert-info">"${term}" does not match any trigger</div>` );
        return;
            }
        }

        const compare = (a, b) => b.date_created.localeCompare(a.date_created);
        values.sort( compare );

        if(values.length === 0){
            $( '.ww_send--table > tbody' ).html( `<svg class="" xmlns="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/1999/xlink" width='50' height='50' viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
						
            <circle cx="50" cy="50" r="24" stroke-width="6" stroke="#fff" stroke-dasharray="50.26548245743669 50.26548245743669" fill="none" stroke-linecap="round">
            <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1.5s" keyTimes="0;1" values="0 50 50;360 50 50"/>
            </circle>
        </svg>` );
        }

        values.forEach((webhook, index) => {   
                        
            const webhook_slug = keys.find(element => {
                if(state.actions[element] === webhook){
                    return element
                }
            });
            let webhook_name = webhook_slug;
            let webhook_url = webhook['webhook_url'];
            let webhook_callback = webhook['webhook_callback'];
            let webhook_api_key =    webhook['api_key'];
            let webhook_group =    webhook['api_key'];
            let webhook_status =    webhook['status'];

            let status = 'active';
            let status_name = 'Deactivate';
            if( webhook_status && webhook_status == 'inactive' ){
                status = 'inactive';
                status_name = 'Activate';
            }
            
            
            webhook_html += '<tr id= ww_trigger--' + webhook_name + '"><th scope="row">' + webhook_name + '</th>';
            webhook_html += '<td><input style="width: 90%" type=text value =' + webhook_url + ' readonly/>';
            webhook_html += '<td><input style="width: 90%" type=text value =' + webhook_api_key + ' readonly/>';
            webhook_html += '<td class="d-flex mr-auto">';
            
            webhook_html    += `<div class="ww_action--items ww_action--settings">
            <svg class="ww_action--icon" xmlns="http://www.w3.org/2000/svg" width="12.26" height="12.263" viewBox="0 0 12.26 12.263">
                <path style="fill: currentColor" id="Icon_ionic-ios-settings" data-name="Icon ionic-ios-settings" d="M15.748,10.63A1.578,1.578,0,0,1,16.76,9.158,6.253,6.253,0,0,0,16,7.335a1.6,1.6,0,0,1-.642.137,1.574,1.574,0,0,1-1.44-2.216A6.235,6.235,0,0,0,12.1,4.5a1.576,1.576,0,0,1-2.944,0,6.253,6.253,0,0,0-1.823.757A1.574,1.574,0,0,1,5.9,7.472a1.547,1.547,0,0,1-.642-.137A6.392,6.392,0,0,0,4.5,9.161a1.577,1.577,0,0,1,0,2.944,6.253,6.253,0,0,0,.757,1.823,1.575,1.575,0,0,1,2.078,2.078,6.29,6.29,0,0,0,1.823.757,1.573,1.573,0,0,1,2.937,0,6.253,6.253,0,0,0,1.823-.757A1.576,1.576,0,0,1,16,13.928a6.29,6.29,0,0,0,.757-1.823A1.585,1.585,0,0,1,15.748,10.63Zm-5.089,2.551a2.554,2.554,0,1,1,2.554-2.554A2.553,2.553,0,0,1,10.659,13.181Z" transform="translate(-4.5 -4.5)" fill="#395ff5"/>
            </svg>

                <a href="#" class="ww_action--links ww_trigger--settings">settings</a>
            </div>`;

            webhook_html   +=      `<div class="ww_action--items ww_action--deactivate">
                <svg class="ww_action--icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11.438 11.438">
                    <path style="fill: currentColor" id="Icon_awesome-stop-circle" data-name="Icon awesome-stop-circle" d="M6.281.563A5.719,5.719,0,1,0,12,6.281,5.718,5.718,0,0,0,6.281.563ZM8.495,8.126a.37.37,0,0,1-.369.369H4.436a.37.37,0,0,1-.369-.369V4.436a.37.37,0,0,1,.369-.369h3.69a.37.37,0,0,1,.369.369Z" transform="translate(-0.563 -0.563)" fill="#395ff5"/>
                </svg>

                <svg class="ww_action--icon__abs" xmlns="http://www.w3.org/2000/svg" width="7.464" height="9.5" viewBox="0 0 7.464 9.5">
                    <path style="fill: currentColor" d="M12,7.5V17l7.464-4.75Z" transform="translate(-12 -7.5)" fill="#395ff5"/>
                </svg>
                <a 
                    href="#" 
                    class="ww_action--links ww_trigger--deactivate" 
                    ww-data-webhook-status=${status} 
                    ww-data-trigger="${webhook_name}" 
                >
                    ${status_name}
                </a>
            </div>`;
    
            webhook_html    +=  `<div class="ww_action--items ww_action--delete">
            <svg class="ww_action--icon" xmlns="http://www.w3.org/2000/svg" width="7.98" height="10.26" viewBox="0 0 7.98 10.26">
                <path style="fill: currentColor" d="M8.07,13.62a1.143,1.143,0,0,0,1.14,1.14h4.56a1.143,1.143,0,0,0,1.14-1.14V6.78H8.07Zm7.41-8.55H13.485l-.57-.57h-2.85l-.57.57H7.5V6.21h7.98Z" transform="translate(-7.5 -4.5)" fill="#395ff5"/>
            </svg>
            <a 
                href="#" 
                class="ww_action--links ww_trigger--delete"
                ww-data-delete-action="Are you sure you want to delete <b>${webhook_name}></b> webhook action?"
                ww-data-trigger="${webhook_name}" 
            >
            delete
            </a>`

            webhook_html    += '</td>';

            webhook_html += '</div></td></tr>';

            

            
        });

        $( '.ww_receive--table > tbody' ).html( webhook_html );

        let status    =   $('.ww_action--deactivate > .ww_trigger--deactivate');
        if(status){
            status.each(function(element) {
                if($(this).text().trim() === 'Activate'){
                    $(this.parentNode).css({ 'color': '#00a73f' })
                    $($(this).siblings()[0]).addClass('ww_action--icon__inactive');
                    $($(this).siblings()[1]).addClass('ww_action--icon__active');
                }
            });
        }
        
    }

    $(window).on('load', function () {
        let send_table = $('.ww_senddata--text');
        let receive_table = $('.ww_receivedata--text');
        if(send_table.length) {
            get_webhook_triggers().then(success => {
                state.triggers = success.data;
                display_webhook_triggers();
            });
        }

        if(receive_table.length) {
            get_webhook_actions().then(success => {
                state.actions = success.data;
                display_webhook_actions();
            });
        }
    });

    const get_webhook_triggers = () => {
        return $.ajax({
            url : ww_ajax.ajax_url,
            type : 'get',
            data :  {
                action : 'ww_get_webhook_triggers',   
            } 
        })
    }

    const get_webhook_actions = () => {
        return $.ajax({
            url : ww_ajax.ajax_url,
            type : 'get',
            data :  {
                action : 'ww_get_webhook_actions',   
            }      
        })
    }

    $('#ww_search--term').on('input', function (e) {
        e.preventDefault();
        const timer = setTimeout(() => {
            clearTimeout(timer);
            if(Object.entries(state.triggers).length !== 0) {
                display_webhook_triggers(e.target.value);
                $('#ww_filter--trigger').val('');

            }
            if(Object.entries(state.actions).length !== 0) display_webhook_actions(e.target.value);
        }, 2000)

        

    });

    $('#ww_filter--trigger').on('change', function (e) {
        display_webhook_triggers('', e.target.value);     
        $('#ww_search--term').val('');
    });
    

})(jQuery);




