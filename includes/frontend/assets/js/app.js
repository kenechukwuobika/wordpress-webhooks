const display_input = (id='', name='', label='', placeholder='', value='', required=false, readonly='') => {
    return `
    <div class="ant-row ant-form-item" style="width: 25rem;">
        <div class="ant-col ant-form-item-label">
            <label for="${id}" class="${required ? 'ant-form-item-required' : ''}" title="${label}">${label}</label>
        </div>
        <div class="ant-col ant-form-item-control">
            <div class="ant-form-item-control-input">
                <div class="ant-form-item-control-input-content">
                    <span class="ant-input-affix-wrapper">
                        <input type="text" id=${id} name=${name} style="min-width:15rem;" class="ant-input" placeholder="${placeholder}" value="${value}" ${readonly} />
                    </span>
                </div>
            </div>
        </div>
    </div>
    `
}

const display_options = (arr, name='', title='', required=false, label='keiks', options='') => {
 
    return `
        <div class="ant-select-dropdown ant-select-dropdown-placement-bottomLeft ant-select-dropdown-hidden" >
            <div role="listbox" id="rc_select_7_list" style="height: 0px; width: 0px; overflow: hidden;">
                <div aria-label="All" role="option" id="rc_select_7_list_0" aria-selected="true">${title}</div>
                    <div aria-label="Cloths" role="option" id="rc_select_7_list_1" aria-selected="false">${title}</div>
                </div>
                <div class="rc-virtual-list" style="position: relative;">
                    <div class="rc-virtual-list-holder" style="max-height: 256px; overflow-y: hidden; overflow-anchor: none;"><div>
                    <div class="rc-virtual-list-holder-inner" style="display: flex; flex-direction: column;">
                        <div aria-selected="true" class="ant-select-item ant-select-item-option ant-select-item-option-active ant-select-item-option-selected" title="All">
                            <div class="ant-select-item-option-content">${title}</div>
                            <span class="ant-select-item-option-state" unselectable="on" aria-hidden="true" style="user-select: none;"></span>
                        </div>
                        
                        ${options}
                        
                    </div>
                </div>
                <div class="rc-virtual-list-scrollbar" style="width: 8px; top: 0px; bottom: 0px; right: 0px; position: absolute; display: none;">
                    <div class="rc-virtual-list-scrollbar-thumb" style="width: 100%; height: 128px; top: 0px; left: 0px; position: absolute; background: rgba(0, 0, 0, 0.5); border-radius: 99px; cursor: pointer; user-select: none;"></div>
                </div>
            </div>
        </div>

    `;
}

const display_select = (id='', name='', title='', required=false, label='') => {
     
    return `
    <div class="ant-row ant-form-item" style="width: 25rem;">
        <div class="ant-col ant-form-item-label">
            <label for="${id}" class="${required ? 'ant-form-item-required' : ''}" title="${label}">${label}</label>
        </div>
        <div class="ant-select ant-select-single ant-select-show-arrow ant-select-open" style="height:32px">
            <div class="ant-select-selector">
            
            <span class="ant-select-selection-search">
                <input autocomplete="off" name="${name}" id="${id}" type="search" class="ant-select-selection-search-input" role="combobox" aria-haspopup="listbox" aria-owns="rc_select_7_list" aria-autocomplete="list" aria-controls="rc_select_7_list" aria-activedescendant="rc_select_7_list_0" readonly="" unselectable="on" value="" id="rc_select_7" style="opacity: 0;" aria-expanded="true">
            </span>
            <span class="ant-select-selection-item" title="${title}">${title}</span>
        </div>
        <span class="ant-select-arrow" unselectable="on" aria-hidden="true" style="user-select: none;">
            <span role="img" aria-label="down" class="anticon anticon-down ant-select-suffix">
                <svg viewBox="64 64 896 896" focusable="false" data-icon="down" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                    <path d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z"></path>
                </svg>
            </span>
        </span>

        <div class="ant-select-dropdown ant-select-dropdown-placement-bottomLeft ant-select-dropdown-hidden" >
        <div role="listbox" id="rc_select_7_list" style="height: 0px; width: 0px; overflow: hidden;">
            <div aria-label="All" role="option" id="rc_select_7_list_0" aria-selected="true">Select an option</div>
                <div aria-label="Cloths" role="option" id="rc_select_7_list_1" aria-selected="false">Select an option</div>
            </div>
            <div class="rc-virtual-list" style="position: relative;">
                <div class="rc-virtual-list-holder" style="max-height: 256px; overflow-y: hidden; overflow-anchor: none;"><div>
                <div class="rc-virtual-list-holder-inner" style="display: flex; flex-direction: column;">
                    <div aria-selected="true" class="ant-select-item ant-select-item-option ant-select-item-option-active ant-select-item-option-selected" title="All">
                        <div class="ant-select-item-option-content">Select an option</div>
                        <span class="ant-select-item-option-state" unselectable="on" aria-hidden="true" style="user-select: none;"></span>
                    </div>
                    <div aria-selected="false" class="ant-select-item ant-select-item-option" title="Add to header">
            <div class="ant-select-item-option-content" ww-data-value="header">Add to header</div>
            <span class="ant-select-item-option-state" unselectable="on" aria-hidden="true" style="user-select: none;"></span>
        </div>

        <div aria-selected="false" class="ant-select-item ant-select-item-option" title="Add to body">
            <div class="ant-select-item-option-content" ww-data-value="body">Add to body</div>
            <span class="ant-select-item-option-state" unselectable="on" aria-hidden="true" style="user-select: none;"></span>
        </div>

        <div aria-selected="false" class="ant-select-item ant-select-item-option" title="Add to header and body">
            <div class="ant-select-item-option-content" ww-data-value="both">Add to header and body</div>
            <span class="ant-select-item-option-state" unselectable="on" aria-hidden="true" style="user-select: none;"></span>
        </div>
                </div>
            </div>
            <div class="rc-virtual-list-scrollbar" style="width: 8px; top: 0px; bottom: 0px; right: 0px; position: absolute; display: none;">
                <div class="rc-virtual-list-scrollbar-thumb" style="width: 100%; height: 128px; top: 0px; left: 0px; position: absolute; background: rgba(0, 0, 0, 0.5); border-radius: 99px; cursor: pointer; user-select: none;"></div>
            </div>
        </div>
    </div>

        
				
    </div>
    `
}


(function($){

    const state = {
        triggers: {},
        actions: {},
        auth_templates: [],
    }

    $('[data-toggle="popover"]').popover();
    

    $('.ww_input--item').each(function (element) {
        $(this).on('click', function () {
            $('.ww_input--select').text(this.childNodes[1].textContent);
            $('.ww_input--select').attr('ww-data-callback', this.getAttribute('data-ww-callback'))

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
            $('.ww_alert').removeClass('ww_alert--active ant-alert-error ant-alert-success');
            $('.ant-alert-message').text('');
        }, 5000);
    }
    
    $( "#ww_submit" ).on( "click", function(e) {
        let error = [];
        let $this = this;
        e.preventDefault();
        const webhook_group = document.querySelector('.ww_input--select').textContent;
        const webhook_callback = $( '.ww_input--select').attr( 'ww-data-callback' );
        const webhook_url = $( '#webhook-url').val();
        const webhook_name = $( '#webhook-name').val();
        const webhook_current_url = $( '#ww-current-url' ).val();  

        if(!webhook_callback){
            error.push( "Please select a trigger");
            $('.ww_alert').addClass('ww_alert--active ant-alert-error');
            $('.ant-alert-message').text(error);
            clear_error();
            return;
        }
        else{
            if(!webhook_name){
                error.push( "Please enter a name for your webhook trigger");
                $('.ww_alert').addClass('ww_alert--active ant-alert-error');
                $('.ant-alert-message').text(error);
                clear_error();
                return;
            }
            if(!webhook_url){
                error.push( "Please enter a url for your webhook trigger");
                $('.ww_alert').addClass('ww_alert--active ant-alert-error');
                $('.ant-alert-message').text(error);
                clear_error();
                return;
            }
        }
        
        $('.ant-btn .ant-btn-loading-icon').css({'display': 'inline-block' });
        $(this).prop('disabled', true);
        
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
            success : ( $response ) => {
                let webhook = $.parseJSON( $response );
                setTimeout(function(){
                    $( '#webhook-url' ).val( '' );
                    $( '#webhook-name' ).val( '' );
    
                    if( webhook['success'] != 'false' && webhook['success'] != false ){
                        $('.ww_alert').addClass('ww_alert--active ant-alert-success');
                        $('.ww_alert').text("Trigger was successfully created");
                        clear_error();
                       
                        state.triggers[webhook['webhook']] = webhook;
                        display_webhook_triggers();
                    } else {
                        $( this ).css( { 'background': '#a70000' } );
                        confirm( webhook['msg'] );
                        
                    }

                    $($this).prop('disabled', false);
                    $('.ant-btn .ant-btn-loading-icon').css({'display': 'none' });
    
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
        e.preventDefault();
        let error = [];
        let $this = this;
        const webhook_name = $( '#ww_webook--action').val();
        
        if(!webhook_name){
            error.push( "Please enter a name for your webhook action");
            $('.ww_alert').addClass('ww_alert--active ant-alert-error ');
            $('.ww_alert').text(error);
            clear_error();
            return;
            
        }

        $('.ant-btn .ant-btn-loading-icon').css({'display': 'inline-block' });
        $(this).prop('disabled', true);
    
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
                    $( '#ww_webook--action' ).val( '' );
    
                    if( webhook['success'] != 'false' && webhook['success'] != false ){
                        $('.ww_alert').addClass('ww_alert--active ant-alert-success');
                        $('.ww_alert').text("Trigger was successfully created");
                        clear_error();
                       
                        state.actions[webhook['webhook']] = webhook;
                        display_webhook_actions();
                    } else {
                        $( this ).css( { 'background': '#a70000' } );
                        confirm( webhook['msg'] );
                        
                    }

                    $($this).prop('disabled', false);
                    $('.ant-btn .ant-btn-loading-icon').css({'display': 'none' });
    
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

    $( "#ww_create--auth" ).on( "click", function(e) {
        e.preventDefault();
        console.log($('#ww_auth--form').serialize());
        // return
        let error = [];
        let values = [];
        // console.log($('.ww_append').children());
        $('.ww_append').children().each(function (el) {
            values.push({'name': $(this['name']).selector, 'value': $(this).val()})
        });

        const template = $.param(values);
        
        const template_name = $( '#ww_template--name').val();
        const auth_type = $( '#ww_choose--auth').val();

        
        if(!template_name){
            error.push( "Please enter a name for your auth template");
            $('.ww_alert').addClass('ww_alert--active ant-alert-error ');
            $('.ww_alert').text(error);
            clear_error();
            return;
            
        }

        else if(!auth_type){
            error.push( "Please select an auth type");
            $('.ww_alert').addClass('ww_alert--active ant-alert-error ');
            $('.ww_alert').text(error);
            clear_error();
            return;
            
        }

        $.ajax({
            url : ww_ajax.ajax_url,
            type : 'post',
            data : {
                action : 'ww_create_auth_template',
                template_name,
                auth_type,
                template,
                ww_nonce: ww_ajax.ajax_nonce
            },
            success : function( $response ) {
                let auth_template = $.parseJSON( $response );
                console.log(auth_template.id)
                setTimeout(function(){
                    $( '#ww_webook--action' ).val( '' );
    
                    if( auth_template['success'] != 'false' && auth_template['success'] != false ){
                        $('.ww_alert').addClass('ww_alert--active ant-alert-success');
                        $('.ww_alert').text("Auth template was successfully created");
                        clear_error();

                        state.auth_templates[auth_template.id] = auth_template
                       
                        setTimeout(()=>{
                            window.location.reload();
                        }, 2000);
                        
                    } else {
                        $( this ).css( { 'background': '#a70000' } );
                        confirm( auth_template['msg'] );
                        
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
        console.log('clicked')
    });

    $('.ww_modal--close').on('click', function (e) {
        e.stopPropagation();
        $('.ww_modal').removeClass('ww_modal--active');
        $('.ww_modal--1').css({ 'display': 'block' });
        $('.ww_modal--2').css({ 'display': 'none' });
    });

    $(".ww_actions--links").each(function () {
        $(this).on('click', function (e) {
            e.preventDefault();
            // const short_description     =   $(this).siblings()[0].value;
            // const return_value          =   $(this).siblings()[1].value;
           
           $.ajax({
            url     :   ww_ajax.ajax_url,
            type    :   'get',
            data    :   {
                action  :   'ww_get_trigger_description',
                id      :   'create_user'
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


    $('#ww_trigger--settings_form').on('submit', function(e) {
    
        e.preventDefault();
        let trigger_settings = $(this).serialize();
        // console.log(trigger_settings); return
        let webhook = $( this ).attr( 'ww-webhook-name' );
        let btn = $( `.ww_trigger--setting_btn` );
        let btn_text = btn.children()[0];
        let btn_loader = btn.children()[1];
        

        $.ajax({
            url : ww_ajax.ajax_url,
            type : 'post',
            data : {
                action: 'ww_save_webhook_trigger_settings',
                trigger_settings,
                webhook,
                ww_nonce: ww_ajax.ajax_nonce
            },
            success : ( response ) => {
                setTimeout(() => {
                    $(btn_text).addClass('ww_btn--text_inactive');
                    $(btn_loader).addClass('ww_btn--icon_active');
                    $(btn).prop('disabled', true);

                }, 200);

                setTimeout(() => {
                $('.ww_alert').addClass('ww_alert--active ant-alert-sucess');
                $(btn_loader).removeClass('ww_btn--icon_active');
                $(btn_text).removeClass('ww_btn--text_inactive');
                $(btn).prop('disabled', false);

                    
                    
                }, 4000);

                setTimeout(() => {
                    $('.ww_alert').remove();

                    
                }, 10000);
                
            
                setTimeout(() => {
                    // window.location.reload();
                }, 6000);
            },
            error: function( errorThrown ){
                console.log(errorThrown);
            }
        });
    
    
    })

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
                    $('.ww_alert').addClass('ww_alert--active ant-alert-success');
                    $(btn_loader).removeClass('ww_btn--icon_active');
                    $(btn_text).removeClass('ww_btn--text_inactive');
                    $(btn).prop('disabled', false);

                        
                        
                    }, 4000);

                    // setTimeout(() => {
                    //     $('.ww_alert').removeClass('ww_alert--active');

                        
                    // }, 10000);
                    
                
                    setTimeout(() => {
                        window.location.reload();
                    }, 6000);
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

    function delete_auth_template (e, element) {
        e.preventDefault();
        let auth_id = $(element).attr('ww-data-id');

        console.log(auth_id);
        if( auth_id && confirm( "Are you sure you want to delete this template?" ) ){
            $.ajax({
                url : ww_ajax.ajax_url,
                type : 'post',
                data : {
                    action : 'ww_delete_auth_template',
                    auth_id,
                    ww_nonce: ww_ajax.ajax_nonce
                },
                success : function( $response ) {
                    let auth_template = $.parseJSON( $response );
                    setTimeout(function(){
        
                        if( auth_template['success'] != 'false' && auth_template['success'] != false ){
                            delete(state.auth_templates[auth_id]);
                            display_auth_templates();
                        } else {
                            $( this ).css( { 'background': '#a70000' } );
                            confirm( auth_template['msg'] );
                            
                        }
        
                    }, 200);
                    setTimeout(function(){
                        $( this ).css( { 'background': '' } );
                    }, 2700);
                },
                error: function( errorThrown ){
                   console.log(errorThrown)
                }
            });

        }   
    };

    function ww_get_auth_methods() {
        return $.ajax({
            url : ww_ajax.ajax_url,
            type : 'get',
            data : {
                action : 'ww_get_auth_methods',
                ww_nonce: ww_ajax.ajax_nonce
            }
        })
    }

    function ww_get_post_type() {
        return $.ajax({
            url : ww_ajax.ajax_url,
            type : 'get',
            data : {
                action : 'ww_get_post_types',
                ww_nonce: ww_ajax.ajax_nonce
            }
        })
    }
    
    
    async function ww_trigger_settings(e, element) {

        const ww_auth_methods_obj = await ww_get_auth_methods();
        const ww_auth_methods = Object.values(ww_auth_methods_obj.data);
        const ww_get_post_types_obj = await ww_get_post_type();
        const ww_get_post_types = Object.values(ww_get_post_types_obj.data);
        

        const ww_data_request_type = ['JSON', 'XML', 'X-WWW-FORM-URLENCODE'];
        const ww_data_request_method = ['POST', 'GET', 'PUT', 'PATCH', 'DELETE', 'TRACE', 'OPTIONS', 'HEAD'];
        const ww_post_status = ['Draft', 'Pending Review', 'Private', 'Published'];
        let webhook_name = e.target.getAttribute('ww-webhook-name');
        let trigger = state.triggers[webhook_name];        
        let data1 = '';
        let data2 = '';
        let data3 = '';
        let data4 = '';
        let data5 = '';
        let post_settings ='';

        let has_post_types = [];
        let not_has_post_types = [];
        let has_post_status = [];
        let not_has_post_status = [];

        ww_get_post_types.forEach(element => {
            if(trigger['settings']){
                if(trigger['settings']['ww_post--type']){
                    trigger['settings']['ww_post--type'].forEach(element1 => {                    

                        if(element === element1){
                            has_post_types.push(element1);

                        }
                        else{
                           
                            if(!has_post_types.includes(element) && !not_has_post_types.includes(element)){
                                not_has_post_types.push(element);           
                            }
                        }
                    })
                }
            }

        });

        for (let i = 0; i < ww_get_post_types.length; i++) {
            if(trigger['settings'] && trigger['settings']['ww_post--type']){
                for (let j = 0; j < trigger['settings']['ww_post--type'].length; j++) {
                    if (trigger['settings']['ww_post--type'][j] === ww_get_post_types[i]) {
                        data4 += `<option value="${trigger['settings']['ww_post--type'][j]}" selected>${trigger['settings']['ww_post--type'][j]}</option>`;
                        break;
                    }                
                    else{
                        if(!has_post_types.includes(ww_get_post_types[i]) && not_has_post_types.includes(ww_get_post_types[i]) ){
                            data4 += `<option value="${ww_get_post_types[i]}">${ww_get_post_types[i]}</option>`;
                            break;
                        }
    
                        else{
                            data4+='';
                        }
                        
                    }
                }
            }

            else{
                data4 += `<option value="${ww_get_post_types[i]}">${ww_get_post_types[i]}</option>`;
            }
            
        }

        ww_post_status.forEach(element => {
            if(trigger['settings']){
                if(trigger['settings']['ww_post--status']){
                    trigger['settings']['ww_post--status'].forEach(element1 => {                    

                        if(element === element1){
                            has_post_status.push(element1);
                            console.log(has_post_status)

                        }
                        else{
                           
                            if(!has_post_status.includes(element) && !not_has_post_status.includes(element)){
                                not_has_post_status.push(element);           
                            }
                        }
                    })
                }
            }

        });

        for (let i = 0; i < ww_post_status.length; i++) {
           if (trigger['settings'] && trigger['settings']['ww_post--status']) {
                for (let j = 0; j < trigger['settings']['ww_post--status'].length; j++) {
                    if (trigger['settings']['ww_post--status'][j] === ww_post_status[i]) {
                        data5 += `<option value="${trigger['settings']['ww_post--status'][j]}" selected>${trigger['settings']['ww_post--status'][j]}</option>`;
                        break;
                    }                
                    else{
                        if(!has_post_status.includes(ww_post_status[i]) && not_has_post_status.includes(ww_post_status[i]) ){
                            data5 += `<option value="${ww_post_status[i]}">${ww_post_status[i]}</option>`;
                            break;
                        }

                        else{
                            data5+='';
                        }
                        
                    }
                }
            }

            else{
                data5 += `<option value="${ww_post_status[i]}">${ww_post_status[i]}</option>`;
            }
            
        }


        ww_post_status.forEach(element => {
            if(trigger['settings'] && trigger['settings']['ww_post--status']){
                trigger['settings']['ww_post--status'].forEach(element1 => {
                    if(element === element1){
                        data5 += `<option value="${element}" selected>${element}</option>`;
                    }
                    else{
                        data5 += `<option value="${element}">${element}</option>`;
                    }
                });
                
            }
            
        });

        if(trigger.webhook_name.includes('post') || trigger.webhook_name.includes('custom')){
            post_settings += `<div class="d-flex align-items-center mb-4">
                <label class="switch mr-4">
                <input class="default primary" name="user_logged_in" type="checkbox" class="regular-text" ${trigger['settings'] && trigger['settings']['user_logged_in'] === 'on' ? 'checked' : ''} />
                    <span class="slider round"></span>
                </label>
                
                <span class="mr-2">User must be logged in</span>
                <svg data-container="body" data-toggle="popover" data-placement="right" data-content="Check this button if you want to fire this webhook only when the user is logged in ( is_user_logged_in() function is used )." xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"><path d="M17.563,9.063a8.5,8.5,0,1,1-8.5-8.5A8.5,8.5,0,0,1,17.563,9.063ZM9.291,3.373A4.439,4.439,0,0,0,5.3,5.558a.412.412,0,0,0,.093.557l1.189.9a.411.411,0,0,0,.571-.073c.612-.777,1.032-1.227,1.964-1.227.7,0,1.566.451,1.566,1.13,0,.513-.424.777-1.115,1.164-.806.452-1.873,1.015-1.873,2.422v.137a.411.411,0,0,0,.411.411h1.919a.411.411,0,0,0,.411-.411v-.046c0-.976,2.851-1.016,2.851-3.656C13.285,4.881,11.222,3.373,9.291,3.373Zm-.228,8.5a1.577,1.577,0,1,0,1.577,1.577A1.578,1.578,0,0,0,9.063,11.873Z" transform="translate(-0.563 -0.563)" fill="#5643fa"/></svg>

            </div>`;

            post_settings += `<div class="d-flex align-items-center mb-4">
                <label class="switch mr-4">
                <input class="default primary" name="user_logged_out" type="checkbox" class="regular-text" ${trigger['settings'] && trigger['settings']['user_logged_out'] === 'on' ? 'checked' : ''} />
                    <span class="slider round"></span>
                </label>
                
                <span class="mr-2">User must be logged out</span>
                <svg data-container="body" data-toggle="popover" data-placement="right" data-content="Check this button if you want to fire this webhook only when the user is logged in ( !is_user_logged_in() function is used )." xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"><path d="M17.563,9.063a8.5,8.5,0,1,1-8.5-8.5A8.5,8.5,0,0,1,17.563,9.063ZM9.291,3.373A4.439,4.439,0,0,0,5.3,5.558a.412.412,0,0,0,.093.557l1.189.9a.411.411,0,0,0,.571-.073c.612-.777,1.032-1.227,1.964-1.227.7,0,1.566.451,1.566,1.13,0,.513-.424.777-1.115,1.164-.806.452-1.873,1.015-1.873,2.422v.137a.411.411,0,0,0,.411.411h1.919a.411.411,0,0,0,.411-.411v-.046c0-.976,2.851-1.016,2.851-3.656C13.285,4.881,11.222,3.373,9.291,3.373Zm-.228,8.5a1.577,1.577,0,1,0,1.577,1.577A1.578,1.578,0,0,0,9.063,11.873Z" transform="translate(-0.563 -0.563)" fill="#5643fa"/></svg>

            </div>`;

            post_settings += `<div class="d-flex align-items-center mb-4">
            <label class="switch mr-4">
            <input class="default primary" name="trigger_backend" type="checkbox" class="regular-text" ${trigger['settings'] && trigger['settings']['trigger_backend'] === 'on' ? 'checked' : ''} />
                <span class="slider round"></span>
            </label>
            
            <span class="mr-2">Trigger from backend only</span>
            <svg data-container="body" data-toggle="popover" data-placement="right" data-content="Check this button if you want to fire this trigger only from the backend. Every post submitted through the frontend is ignored ( is_admin() function is used )." xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"><path d="M17.563,9.063a8.5,8.5,0,1,1-8.5-8.5A8.5,8.5,0,0,1,17.563,9.063ZM9.291,3.373A4.439,4.439,0,0,0,5.3,5.558a.412.412,0,0,0,.093.557l1.189.9a.411.411,0,0,0,.571-.073c.612-.777,1.032-1.227,1.964-1.227.7,0,1.566.451,1.566,1.13,0,.513-.424.777-1.115,1.164-.806.452-1.873,1.015-1.873,2.422v.137a.411.411,0,0,0,.411.411h1.919a.411.411,0,0,0,.411-.411v-.046c0-.976,2.851-1.016,2.851-3.656C13.285,4.881,11.222,3.373,9.291,3.373Zm-.228,8.5a1.577,1.577,0,1,0,1.577,1.577A1.578,1.578,0,0,0,9.063,11.873Z" transform="translate(-0.563 -0.563)" fill="#5643fa"/></svg>

            </div>`;

            post_settings += `<div class="d-flex align-items-center mb-4">
            <label class="switch mr-4">
            <input class="default primary" name="trigger_frontend" type="checkbox" class="regular-text" ${trigger['settings'] && trigger['settings']['trigger_frontend'] === 'on' ? 'checked' : ''} />
                <span class="slider round"></span>
            </label>
            
            <span class="mr-2">Trigger from frontend only</span>
            <svg data-container="body" data-toggle="popover" data-placement="right" data-content="Check this button if you want to fire this trigger only from the frontend. Every post submitted through the backend is ignored ( is_admin() function is used )." xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"><path d="M17.563,9.063a8.5,8.5,0,1,1-8.5-8.5A8.5,8.5,0,0,1,17.563,9.063ZM9.291,3.373A4.439,4.439,0,0,0,5.3,5.558a.412.412,0,0,0,.093.557l1.189.9a.411.411,0,0,0,.571-.073c.612-.777,1.032-1.227,1.964-1.227.7,0,1.566.451,1.566,1.13,0,.513-.424.777-1.115,1.164-.806.452-1.873,1.015-1.873,2.422v.137a.411.411,0,0,0,.411.411h1.919a.411.411,0,0,0,.411-.411v-.046c0-.976,2.851-1.016,2.851-3.656C13.285,4.881,11.222,3.373,9.291,3.373Zm-.228,8.5a1.577,1.577,0,1,0,1.577,1.577A1.578,1.578,0,0,0,9.063,11.873Z" transform="translate(-0.563 -0.563)" fill="#5643fa"/></svg>

            </div>`;

            if(trigger.webhook_name.includes('post') ){
                post_settings +=`<div class="d-flex align-items-center mb-4">
                    <select multiple=multiple class="mr-2" name="ww_post--type[]" id="ww_post--type">
                    ${data4}
                        
                    </select>
                    <svg data-container="body" data-toggle="popover" data-placement="right" data-content="Select only the post types you want to fire the trigger on. You can also choose multiple ones. If none is selected, all are triggered." xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"><path d="M17.563,9.063a8.5,8.5,0,1,1-8.5-8.5A8.5,8.5,0,0,1,17.563,9.063ZM9.291,3.373A4.439,4.439,0,0,0,5.3,5.558a.412.412,0,0,0,.093.557l1.189.9a.411.411,0,0,0,.571-.073c.612-.777,1.032-1.227,1.964-1.227.7,0,1.566.451,1.566,1.13,0,.513-.424.777-1.115,1.164-.806.452-1.873,1.015-1.873,2.422v.137a.411.411,0,0,0,.411.411h1.919a.411.411,0,0,0,.411-.411v-.046c0-.976,2.851-1.016,2.851-3.656C13.285,4.881,11.222,3.373,9.291,3.373Zm-.228,8.5a1.577,1.577,0,1,0,1.577,1.577A1.578,1.578,0,0,0,9.063,11.873Z" transform="translate(-0.563 -0.563)" fill="#5643fa"/></svg>
                </div>`;
            }

        if(trigger.webhook_name === 'post_create'){
            post_settings +=`<div class="d-flex align-items-center mb-4">
            <select multiple=multiple class="mr-2" name="ww_post--status[]" id="ww_post--status">
                ${data5}
                
            </select>
            <svg data-container="body" data-toggle="popover" data-placement="right" data-content="Select only the post status you want to fire the trigger on. You can also choose multiple ones. Important: This trigger only fires after the initial post status change. If you change the status after again, it doesn't fire anymore. We also need to set a post meta value in the database after you chose the post status functionality." xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"><path d="M17.563,9.063a8.5,8.5,0,1,1-8.5-8.5A8.5,8.5,0,0,1,17.563,9.063ZM9.291,3.373A4.439,4.439,0,0,0,5.3,5.558a.412.412,0,0,0,.093.557l1.189.9a.411.411,0,0,0,.571-.073c.612-.777,1.032-1.227,1.964-1.227.7,0,1.566.451,1.566,1.13,0,.513-.424.777-1.115,1.164-.806.452-1.873,1.015-1.873,2.422v.137a.411.411,0,0,0,.411.411h1.919a.411.411,0,0,0,.411-.411v-.046c0-.976,2.851-1.016,2.851-3.656C13.285,4.881,11.222,3.373,9.291,3.373Zm-.228,8.5a1.577,1.577,0,1,0,1.577,1.577A1.578,1.578,0,0,0,9.063,11.873Z" transform="translate(-0.563 -0.563)" fill="#5643fa"/></svg>
        </div>`;
        }



            
        }
        ww_data_request_type.forEach(element => {
            if(trigger['settings']){
                if(element === trigger['settings']['ww_data--request_type']){
                    data1 += `<option value="${element}" selected>${element}</option>`;
                }
                else{
                    data1 += `<option value="${element}">${element}</option>`;
                }
            }else{
                data1 += `<option value="${element}">${element}</option>`;
            }
            
        });

        ww_data_request_method.forEach(element => {
            if(trigger['settings']){
                if(element === trigger['settings']['ww_data--request_method']){
                    data2 += `<option value="${element}" selected>${element}</option>`;
                }
            }
            data2 += `<option value="${element}">${element}</option>`;
        });

        ww_auth_methods.forEach(element => {
            if(trigger['settings']){
                if(element.id === trigger['settings']['ww_auth--template']){
                    data3 += `<option value="${element.id}" selected>${element.name}</option>`;
                }
            }
            data3 += `<option value="${element.id}">${element.name}</option>`;
        });

        $('#ww_trigger--settings_form').attr( 'ww-webhook-name', $(element).attr( 'ww-webhook-name' ) );
        let html = '';
        html += `<div class="d-flex align-items-center mb-4">
        <select class="mr-2" name="ww_data--request_type" id="ww_data--request_method">
            
            ${data1}
            
        </select>
        <svg data-container="body" data-toggle="popover" data-placement="right" data-content="Set a custom request type for the data that gets send to the specified URL. Default is JSON." xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"><path d="M17.563,9.063a8.5,8.5,0,1,1-8.5-8.5A8.5,8.5,0,0,1,17.563,9.063ZM9.291,3.373A4.439,4.439,0,0,0,5.3,5.558a.412.412,0,0,0,.093.557l1.189.9a.411.411,0,0,0,.571-.073c.612-.777,1.032-1.227,1.964-1.227.7,0,1.566.451,1.566,1.13,0,.513-.424.777-1.115,1.164-.806.452-1.873,1.015-1.873,2.422v.137a.411.411,0,0,0,.411.411h1.919a.411.411,0,0,0,.411-.411v-.046c0-.976,2.851-1.016,2.851-3.656C13.285,4.881,11.222,3.373,9.291,3.373Zm-.228,8.5a1.577,1.577,0,1,0,1.577,1.577A1.578,1.578,0,0,0,9.063,11.873Z" transform="translate(-0.563 -0.563)" fill="#5643fa"/></svg>
    </div>
    
    
    <div class="d-flex align-items-center mb-4">
        <select class="mr-2" name="ww_data--request_method" id="ww_data--request_method">
        ${data2}
            
        </select>
        <svg data-container="body" data-toggle="popover" data-placement="right" data-content="Set a custom request method for the data that gets send to the specified URL. Default is POST." xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"><path d="M17.563,9.063a8.5,8.5,0,1,1-8.5-8.5A8.5,8.5,0,0,1,17.563,9.063ZM9.291,3.373A4.439,4.439,0,0,0,5.3,5.558a.412.412,0,0,0,.093.557l1.189.9a.411.411,0,0,0,.571-.073c.612-.777,1.032-1.227,1.964-1.227.7,0,1.566.451,1.566,1.13,0,.513-.424.777-1.115,1.164-.806.452-1.873,1.015-1.873,2.422v.137a.411.411,0,0,0,.411.411h1.919a.411.411,0,0,0,.411-.411v-.046c0-.976,2.851-1.016,2.851-3.656C13.285,4.881,11.222,3.373,9.291,3.373Zm-.228,8.5a1.577,1.577,0,1,0,1.577,1.577A1.578,1.578,0,0,0,9.063,11.873Z" transform="translate(-0.563 -0.563)" fill="#5643fa"/></svg>
    </div>

    <div class="d-flex align-items-center mb-4">
        <select class="mr-2" name="ww_auth--template" id="ww_auth--template">
        ${data3}           
        </select>
        <svg data-container="body" data-toggle="popover" data-placement="right" data-content="Set a custom request method for the data that gets send to the specified URL. Default is POST." xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"><path d="M17.563,9.063a8.5,8.5,0,1,1-8.5-8.5A8.5,8.5,0,0,1,17.563,9.063ZM9.291,3.373A4.439,4.439,0,0,0,5.3,5.558a.412.412,0,0,0,.093.557l1.189.9a.411.411,0,0,0,.571-.073c.612-.777,1.032-1.227,1.964-1.227.7,0,1.566.451,1.566,1.13,0,.513-.424.777-1.115,1.164-.806.452-1.873,1.015-1.873,2.422v.137a.411.411,0,0,0,.411.411h1.919a.411.411,0,0,0,.411-.411v-.046c0-.976,2.851-1.016,2.851-3.656C13.285,4.881,11.222,3.373,9.291,3.373Zm-.228,8.5a1.577,1.577,0,1,0,1.577,1.577A1.578,1.578,0,0,0,9.063,11.873Z" transform="translate(-0.563 -0.563)" fill="#5643fa"/></svg>
    </div>
    
    <div class="d-flex align-items-center mb-4">
        <label class="switch mr-4">
        <input class="default primary" name="url" type="checkbox" class="regular-text" ${trigger['settings'] && trigger['settings']['url'] === 'on' ? 'checked' : ''} />
            <span class="slider round"></span>
        </label>
        
        <span class="mr-2">Allow unsafe URLs</span>
        <svg data-container="body" data-toggle="popover" data-placement="right" data-content="Activating this setting allows you to use unsafe looking URLs like zfvshjhfbssdf.szfdhdf.com." xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"><path d="M17.563,9.063a8.5,8.5,0,1,1-8.5-8.5A8.5,8.5,0,0,1,17.563,9.063ZM9.291,3.373A4.439,4.439,0,0,0,5.3,5.558a.412.412,0,0,0,.093.557l1.189.9a.411.411,0,0,0,.571-.073c.612-.777,1.032-1.227,1.964-1.227.7,0,1.566.451,1.566,1.13,0,.513-.424.777-1.115,1.164-.806.452-1.873,1.015-1.873,2.422v.137a.411.411,0,0,0,.411.411h1.919a.411.411,0,0,0,.411-.411v-.046c0-.976,2.851-1.016,2.851-3.656C13.285,4.881,11.222,3.373,9.291,3.373Zm-.228,8.5a1.577,1.577,0,1,0,1.577,1.577A1.578,1.578,0,0,0,9.063,11.873Z" transform="translate(-0.563 -0.563)" fill="#5643fa"/></svg>

    </div>

    <div class="d-flex align-items-center mb-4">
        <label class="switch mr-4">
        
            <input class="default primary" name="ssl" type="checkbox" class="regular-text" ${trigger['settings'] && trigger['settings']['ssl'] === 'on' ? 'checked' : ''} />
            <span class="slider round"></span>
        </label>
        
        <span class="mr-2">Allow unverified SSL</span>
        <svg data-container="body" data-toggle="popover" data-placement="right" data-content="Activating this setting allows you to use unverified SSL connections for this URL (We won't verify the SSL for this webhook URL)." xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"><path d="M17.563,9.063a8.5,8.5,0,1,1-8.5-8.5A8.5,8.5,0,0,1,17.563,9.063ZM9.291,3.373A4.439,4.439,0,0,0,5.3,5.558a.412.412,0,0,0,.093.557l1.189.9a.411.411,0,0,0,.571-.073c.612-.777,1.032-1.227,1.964-1.227.7,0,1.566.451,1.566,1.13,0,.513-.424.777-1.115,1.164-.806.452-1.873,1.015-1.873,2.422v.137a.411.411,0,0,0,.411.411h1.919a.411.411,0,0,0,.411-.411v-.046c0-.976,2.851-1.016,2.851-3.656C13.285,4.881,11.222,3.373,9.291,3.373Zm-.228,8.5a1.577,1.577,0,1,0,1.577,1.577A1.578,1.578,0,0,0,9.063,11.873Z" transform="translate(-0.563 -0.563)" fill="#5643fa"/></svg>

    </div>
    ${post_settings}
    `;

    $('.modal-body').html(html);
    $('[data-toggle="popover"]').popover();
    
    }
    
    $( ".tbody" ).on( "click", function(e) {
        e.preventDefault();
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
        else if(element.attr('ww-data-id')){
            delete_auth_template(e, element);
        }

        else if(element.attr('ww-trigger-setting')){
            ww_trigger_settings(e, element);
        }
        
    });


    const display_webhook_triggers = (term='', filter='') => {
        
        const data =  {...state.triggers};        
        const keys = Object.keys(data);
        let values = Object.values(data);

        if(values.length === 0){
            $( '.ww_append' ).html( `<div class="alert alert-info">There are no available webhook triggers</div>` );
            return;
        }
        let webhook_html = ``;

    
        if(filter){
            values = values.filter(element => {
                if (element['webhook_name'] === filter) {
                    return element;
                }
            });

            if(values.length === 0){
                $( '.ww_send--table > tbody' ).html( `` );
                $( '.ww_append' ).html( `<div class="alert alert-info"> No trigger was found under '${filter}'</div>` );
                return;
            }
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
                $( '.ww_send--table > tbody' ).html( `` );
                $( '.ww_append' ).html( `<div class="alert alert-info">"${term}" does not match any trigger</div>` );
                return;
            }
        }

        const compare = (a, b) => b.date_created.localeCompare(a.date_created);
        values.sort( compare );

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

                <a href="#" 
                    class="ww_action--links ww_trigger--settings" 
                    data-toggle="modal" 
                    data-target="#exampleModalCenter" 
                    ww-webhook-name=${webhook_name} 
                    ww-trigger-setting=true
                    ww-webhook-group=${webhook_group} 
                >
                settings</a>
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

        
            $( '.ww_loader--container' ).remove();
            $( '.ww_append' ).html('');
            $( '.ww_send--table > tbody' ).html( webhook_html );

        let status    =   $('.ww_action--deactivate > .ww_trigger--deactivate');
        if(status){
            status.each(function() {
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
        // console.log(data)
        const keys = Object.keys(data);
        let values = Object.values(data);
        if(values.length === 0){

            $( '.tbody' ).html( `<div class="alert alert-info">There are no available webhook actions</div>` );
            return;
        }
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
            
            webhook_html += 
            `<td>
            ${display_input(`webhook_name_${index}`, `webhook_name_${index}`, '', '', webhook_url, '', 'readonly')}
                
            </td>`;

            webhook_html += 
            `<td>
            ${display_input(`webhook_api_key_${index}`, `webhook_api_key_${index}`, '', '', webhook_api_key, '', 'readonly')}
            </td>`;
            webhook_html += '<td class="d-flex mr-auto">';
            

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

        $( '.ww_loader--container' ).remove();
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

    const display_auth_templates = (term='', filter='') => {

        const filtered =  filter.toLowerCase().split(' ').join('_');
        const data =  {...state.auth_templates};
        const keys = Object.keys(data);
        let values = Object.values(data);
        if(values.length === 0){
            $( '.ww_append' ).html( `<div class="alert alert-info">There are no available auth templates</div>` );
            return;
        }
        let html = '';
        
        
        if(filter){
            values = values.filter(element => {
                if (element['auth_type'] === filtered) {
                    return element;
                }
            });

            if(values.length === 0){
                $( '.ww_auth--table > tbody' ).html( `` );
                $( '.ww_append' ).html( `<div class="alert alert-info"> No templates was found under '${filter}'</div>` );
                return;
            }
        }

         if(term){
            const arr = [];
            values.forEach(element => {
                if(element.name.includes(term)){
                    arr.push(element);
                }
            });
            values = [...arr]

            if(values.length === 0){
                $( '.ww_append' ).html( `<div class="alert alert-info">"${term}" does not match any templates</div>` );
                return;
            }
        }

        const compare = (a, b) => b.id.localeCompare(a.id);
        values.sort( compare );

        if(values.length === 0){
            $( '.ww_apend' ).html( `<svg class="" xmlns="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/1999/xlink" width='50' height='50' viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
						
            <circle cx="50" cy="50" r="24" stroke-width="6" stroke="#fff" stroke-dasharray="50.26548245743669 50.26548245743669" fill="none" stroke-linecap="round">
            <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1.5s" keyTimes="0;1" values="0 50 50;360 50 50"/>
            </circle>
        </svg>` );
        }

        values.forEach((template, index) => { 
            let id = template['id'];
            let name = template['name'];
            let auth_type =    template['auth_type'];
            let template_ =    template['template'];
            let log_time =    template['log_time'];
            
            
            html += `<tr><th scope="row"> ${name} </th>`;
            html += `<td class=ant-table-cell> ${auth_type} </td>`;
            html += '<td class="d-flex mr-auto">';
            
            html    +=  `<div class="ww_action--items ww_action--delete">
            <svg class="ww_action--icon" xmlns="http://www.w3.org/2000/svg" width="7.98" height="10.26" viewBox="0 0 7.98 10.26">
                <path style="fill: currentColor" d="M8.07,13.62a1.143,1.143,0,0,0,1.14,1.14h4.56a1.143,1.143,0,0,0,1.14-1.14V6.78H8.07Zm7.41-8.55H13.485l-.57-.57h-2.85l-.57.57H7.5V6.21h7.98Z" transform="translate(-7.5 -4.5)" fill="#395ff5"/>
            </svg>
            <a 
                href="#" 
                class="ww_action--links ww_delete--auth"
                ww-data-id=${id}
            >
            delete
            </a>`

            html    += '</div></td></tr>';

        

            

            
        });

        $( '.ww_loader--container' ).remove();
        $( '.tbody' ).html( html );
        $( '.ww_append' ).html( '' );
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
    
    $('#ww_choose--auth').on('change', function () {
        let auth_type = $(this).val();
        let form_html = '';


        switch (auth_type) {
            case 'api_key':
                // form_html += '<input type="text" class="ww_input mb-4 form-control" name="ww_template--key" id="ww_template--key" placeholder="Enter key" required>';
                // form_html += display_input('ww_template--key', 'ww_template--key', 'Enter key');
                form_html += '<input type="text" class="ww_input mb-4 form-control" name="ww_template--value" id="ww_template--value" placeholder="Enter value" required>';
                form_html += `<select type="text" class="ww_input mb-4 form-control" name="ww_template--attach" id="ww_template--attach" required>
                    <option value=header>Add to header</option>
                    <option value=body>Add to body</option>
                    <option value=both>Add to header and body</option>
                </select>`;
            break;

            case 'basic_auth':
                form_html += '<input type="text" class="ww_input mb-4 form-control" name="ww_template--username" id="ww_template--username" placeholder="Enter username" required>';
                form_html += '<input type="text" class="ww_input mb-4 form-control" name="ww_template--password" id="ww_template--password" placeholder="Enter password" required>';
            break;

            case 'bearer_token':
                form_html += '<input type="text" class="ww_input mb-4 form-control" name="ww_template--token" id="ww_template--token" placeholder="Enter token" required>';
            break;

            case 'digest_auth':
                
            break;
        
            default:
            break;

        }

        $('.ww_append').html(form_html);

    });

    $(window).on('load', function () {
        let send_table = $('.ww_send--table');
        let receive_table = $('.ww_receive--table');
        let auth_table = $('.ww_auth--table');
        if(send_table.length) {
            get_webhook_triggers().then(success => {
                state.triggers = success.data;
                display_webhook_triggers();
            });
        }

        else if(receive_table.length) {
            get_webhook_actions().then(success => {
                state.actions = success.data;
                console.log(success.data)
                display_webhook_actions();
            });
        }

        else if(auth_table.length) {
            get_auth_templates().then(success => {
                state.auth_templates = success.data;
                display_auth_templates();
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

    const get_actions = () => {
        return $.ajax({
            url : ww_ajax.ajax_url,
            type : 'get',
            data :  {
                action : 'ww_get_actions',   
            }      
        })
    }
    
    const get_auth_templates = () => {
        return $.ajax({
            url : ww_ajax.ajax_url,
            type : 'get',
            data :  {
                action : 'ww_get_auth_templates',   
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
            if(Object.entries(state.auth_templates).length !== 0) display_auth_templates(e.target.value);
        }, 2000)

        

    });

    $('.ww_filter--trigger').on('click', function (e) {
        console.log('leiks')
        display_webhook_triggers('', $(this).attr('ww-data-value'));     
        $('#ww_search--term').val('');
    }); 


    $('.ww_filter--auth').on('click', function (e) {
        display_auth_templates('', $(this).attr('ww-data-value'));     
        $('#ww_search--auth').val('');
    });

    $('#ww_test--webhook').on('change', function (e) {
        const webhook_url      =   $('#ww_test--webhook').val();
        $('.ww_test--form').attr('action', webhook_url);
    });
    
    $('#ww_test--action').on('change', function (e) {
        webhook_action     =   $(this).val();
        action              =   '';

        if(!webhook_action){
            $('.ww_parameter--group').html('');
            return;
        }

        get_actions().then(result => {
            let values = Object.values(result.data)
            let action = values.find(element => {
                if(element.action === webhook_action){
                    return element;
                }
            })

            let parameters = Object.keys(action.parameter);
            let html = '';
            parameters.forEach(element => {
                html += `<input type="text" class="ww_input--sm ww_param mb-4 mt-4 form-control" name=${element} placeholder=${element} >`
            });
            html += `<input type="text" class="ww_input--sm ww_param mb-4 mt-4 form-control" name="access_token" placeholder="access token" >`


            $('.ww_parameter--group').html(html);
        
        });
        
    });

    $('.ant-select-selection-item').each(function () {
        $(this).on('click', function (e) { 
            const parentNode = $(e.target).parent().parent().parent().children('.ant-select').children('.ant-select-dropdown');
            parentNode.toggleClass('ant-select-dropdown-hidden');
        });
    });
    
    $('.ant-select-item-option-content').on('click', function () { 
        const parentNode = $(this).parent().parent().parent().parent().parent().parent().parent().parent();
        const input = $(parentNode).children('.ant-select').children('.ant-select-selector').children('.ant-select-selection-search').children('.ant-select-selection-search-input');
        const selectText = $(parentNode).children('.ant-select').children('.ant-select-selector').children('.ant-select-selection-item');

            selectText.attr('ww-data-value', $(this).attr('ww-data-value'));
            selectText.text($(this).text());
            input.val($(this).attr('ww-data-value'));
            console.log(input.val());
            let auth_type = input.val();
            selectText.css({'color': '#455560'})
            $('.ant-select-dropdown').addClass('ant-select-dropdown-hidden');

    });

    $('#ww_change--auth .ant-select-item-option-content').on('click', function () { 
        const parentNode = $(this).parent().parent().parent().parent().parent().parent().parent().parent();
        const input = $(parentNode).children('.ant-select').children('.ant-select-selector').children('.ant-select-selection-search').children('.ant-select-selection-search-input');
        const selectText = $(parentNode).children('.ant-select').children('.ant-select-selector').children('.ant-select-selection-item');

            console.log($(this));
            selectText.attr('ww-data-value', $(this).attr('ww-data-value'));
            selectText.text($(this).text());
            input.val($(this).attr('ww-data-value'));
            let auth_type = input.val();
            selectText.css({'color': '#455560'})
            $('.ant-select-dropdown').addClass('ant-select-dropdown-hidden');

            let form_html = '';


        switch (auth_type) {
            case 'api_key':
                form_html += display_input('ww_template--key', 'ww_template--key', 'Key', 'Enter key');
                form_html += display_input('ww_template--value', 'ww_template--value', 'Value', 'Enter value');
                form_html += display_select('ww_template--attach', 'ww_template--attach', 'Select an option', false, 'choose');
                
            break;

            case 'basic_auth':
                form_html += display_input('ww_template--username', 'ww_template--username', 'Username', 'Enter username');
                form_html += display_input('ww_template--password', 'ww_template--password', 'Password', 'Enter password');
            break;

            case 'bearer_token':
                form_html += display_input('ww_template--token', 'ww_template--token', 'Token', 'Enter token');
            break;

            case 'digest_auth':
                
            break;
        
            default:
            break;

        }

        $('.ww_append').html(form_html);

    });
    

    $('.ww_append').on('click', function (e) { 
           
            
            const form_parentnode = $(e.target).parent().parent().parent().parent().parent().parent().parent().parent();
           const dropdown_parentnode = $(e.target).parent().parent().parent();
           const dropdown = dropdown_parentnode.children('.ant-select').children('.ant-select-dropdown');
           const input = $(form_parentnode).children('.ant-select').children('.ant-select-selector').children('.ant-select-selection-search').children('.ant-select-selection-search-input');
           const selectText = $(form_parentnode).children('.ant-select').children('.ant-select-selector').children('.ant-select-selection-item');
           if($(e.target).hasClass('ant-select-item-option-content')){
                $(e.target).parent().parent().parent().parent().parent().parent().toggleClass('ant-select-dropdown-hidden');  
            }

            else if($(e.target).hasClass('ant-select-selection-item')){
                dropdown.toggleClass('ant-select-dropdown-hidden');
            }
         

            selectText.attr('ww-data-value', $(e.target).attr('ww-data-value'));
            selectText.text($(e.target).text());
            input.val($(e.target).attr('ww-data-value'));
            let auth_type = input.val();
            selectText.css({'color': '#455560'})

            let form_html = '';

    });
    

    

})(jQuery);




