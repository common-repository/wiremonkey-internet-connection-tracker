<?php

class WiremonkeyAdminSettings
{

    private $options;

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'wiremokey_admin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }


    
    public function wiremokey_admin_page()
    {

        add_options_page(
            'Settings Admin', 
            'Wiremonkey Setting', 
            'manage_options', 
            'wiremonkey-setting-admin', 
            array( $this, 'showSettings' )
        );
    }

 
 

    public function page_init()
    {        
        register_setting(
            'wiremonkey_option_group', 
            'wiremonkey_opt', 
            array( $this, 'sanitize' ) 
        );

        add_settings_section(
            'setting_section_id', 
            'Wiremonkey Settings', 
            array($this,'showBanner'), 
            'wiremonkey-setting-admin' 
        );  



        add_settings_field(
            'isenabled', 
            'Enable', 
            array( $this, 'checkboxSwitch' ), 
            'wiremonkey-setting-admin', 
            'setting_section_id'           
        );  

         add_settings_field(
            'showicon',
            'Show icon',  
            array( $this, 'checkboxIcon' ), 
            'wiremonkey-setting-admin', 
            'setting_section_id'            
        );      
    

         add_settings_field(
            'alwaystop',
            'Mobile (display at bottom)',  
            array( $this, 'checkboxTop' ), 
            'wiremonkey-setting-admin', 
            'setting_section_id'            
        );      
    

        add_settings_field(
            'theme', 
            'Theme', 
            array( $this, 'dropdownTheme' ), 
            'wiremonkey-setting-admin', 
            'setting_section_id'
        );      


        add_settings_field(
            'disconnect_message', 
            'Disconnect message', 
            array( $this, 'disconnect_message_callback' ), 
            'wiremonkey-setting-admin', 
            'setting_section_id'
        ); 

          add_settings_field(
            'connect_message', 
            'Connect message', 
            array( $this, 'connect_message_callback' ), 
            'wiremonkey-setting-admin', 
            'setting_section_id'
        );   
    }

    
    public function showBanner(){
        $logo = plugins_url("../assets/icon-256x256.png",__FILE__);
        $like = '<iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fgalactas%2F&width=51&layout=button&action=like&size=small&show_faces=false&share=false&height=65&appId" width="51" height="20" style="border:none;overflow:hidden;float: inherit;margin-left: 7px;" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>';
        $banner = "<div class='wiremonkey-banner-wrapper'><img src='{$logo}' /><h3>Wiremonkey Internet Connection Tracker{$like}</h3><p>This plugin developed and maintained by <a href='https://www.galactas.com'>Galactas (M) Sdn Bhd (Pte Ltd)</a>.</br>Please support us by liking our Facebook page <a href='https://www.facebook.com/galactas'>here</a> or by simply clicking the like button above.It will encourage us to create more free plugins for you.</a></p></p></div>";
        echo $banner;
        
    }
    public function sanitize( $input )
    {
         
          
        $new_input = array();

        if( !isset( $input['isenabled'] ) ){
            $isenabled = 0;
            $new_input['isenabled'] = absint( $isenabled);
        }else{
            $isenabled = 1;
            $new_input['isenabled'] = absint( $isenabled);
        }
            

          if( !isset( $input['showicon'] ) ){
            $showicon = 0;
            $new_input['showicon'] = absint( $showicon);
        }else{
            $showicon = 1;
            $new_input['showicon'] = absint( $showicon);
        }

        if( !isset( $input['alwaystop'] ) ){
            $alwaystop = 0;
            $new_input['alwaystop'] = absint( $alwaystop);
        }else{
            $alwaystop = 1;
            $new_input['alwaystop'] = absint( $alwaystop);
        }

        if(isset($input['theme'])){
       
            $new_input['theme'] = sanitize_text_field( $input['theme'] );
        }


        if( isset( $input['disconnect_message'] ) )
            $new_input['disconnect_message'] = sanitize_text_field( $input['disconnect_message'] );


        if( isset( $input['connect_message'] ) )
            $new_input['connect_message'] = sanitize_text_field( $input['connect_message'] );

        return $new_input;
    }


   



    public function dropdownTheme(){

                $options = array(1=>"Dark",2=>"Light");

                $select_field = "<select name='wiremonkey_opt[theme]'>";
                foreach ($options as $opt_id => $opt_value) {

                    $isselected = $this->options["theme"] == $opt_id ? "selected": "";
                    $select_field .= "<option value='".$opt_id."' $isselected>".$opt_value."</option>";
                }
                $select_field .= "</select>";
                echo $select_field;
        
        
    }


    public function checkboxSwitch($status){
            $checkbox= "<input type='checkbox' value='1' name='wiremonkey_opt[isenabled]' ".($this->options['isenabled'] == 1 ? "checked":"")."/>";
            echo $checkbox;
    }

     public function checkboxIcon($status){
            $checkbox= "<input type='checkbox' value='1' name='wiremonkey_opt[showicon]' ".($this->options['showicon'] == 1 ? "checked":"")."/>";
            echo $checkbox;
    }

     public function checkboxTop($status){
            $checkbox= "<input type='checkbox' value='1' name='wiremonkey_opt[alwaystop]' ".($this->options['alwaystop'] == 1 ? "checked":"")."/>";
            echo $checkbox;
    }





    public function disconnect_message_callback()
    {
        printf(
            '<input type="text" size=80 id="disconnect_message" name="wiremonkey_opt[disconnect_message]" value="%s" />',
            isset( $this->options['disconnect_message'] ) ? esc_attr( $this->options['disconnect_message']) : ''
        );
    }

    public function connect_message_callback()
    {
        printf(
            '<input type="text" size=80  id="connect_message" name="wiremonkey_opt[connect_message]" value="%s" />',
            isset( $this->options['connect_message'] ) ? esc_attr( $this->options['connect_message']) : ''
        );
    }

       public function showSettings()
    {
       

        $default_opt = array(
            "isenabled"=>1,
            "showicon"=>1,
            "theme"=>1,
            "alwaystop"=>0,
            "connect_message" => "Connected to internet.",
            "disconnect_message" => "No internet, please check the connection."
            );
        $this->options = wp_parse_args(get_option('wiremonkey_opt'),$default_opt);

        ?>
        <div class="wrap">
            <form method="post" action="options.php">
            <?php
                settings_fields( 'wiremonkey_option_group' );
                do_settings_sections( 'wiremonkey-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }


}

if( is_admin() )
    $my_settings_page = new WiremonkeyAdminSettings();