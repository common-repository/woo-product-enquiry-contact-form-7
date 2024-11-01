<?php

if (!defined('ABSPATH'))
  exit;

if (!class_exists('WPECF7_front')) {

    class WPECF7_front {

        protected static $instance;
     
        function headererrr(){       
            $wpecf7_object = get_queried_object();
            // echo "<pre>";
            // print_r($wpecf7_object);
            // echo "</pre>";
            
            $id = $wpecf7_object->ID;
            $product = wc_get_product( $id );
            if(get_option( 'wpecf7_alw_gust_usr' ) == "yes"){
                if(get_option( 'wpecf7_sin_pro_page' ) == "yes"){
                    if(is_product()){
                        if(get_option( 'wpecf7_rd_btn_pos' ) == "after_add_cart" ){
                            if(get_option( 'wpecf7_rd_dis_pro' ) == "outofstock"){
                                if( ! $product->is_in_stock()){
                                    add_action('woocommerce_product_meta_start', array( $this, 'create_button' ));
                                } 
                            }else{
                                if( ! $product->is_in_stock()){
                                    add_action('woocommerce_product_meta_start', array( $this, 'create_button' ),0);
                                }else{
                                    add_action('woocommerce_after_add_to_cart_form', array( $this, 'create_button' ));
                                }      
                            }   
                        }elseif(get_option( 'wpecf7_rd_btn_pos' ) == "before_add_cart"){
                            if(get_option( 'wpecf7_rd_dis_pro' ) == "outofstock"){
                                if( ! $product->is_in_stock()){
                                    add_action('woocommerce_single_product_summary', array( $this, 'create_button' ));
                                } 
                            }else{
                                
                                if( ! $product->is_in_stock()){
                                    add_action('woocommerce_single_product_summary', array( $this, 'create_button' ));
                                }else{
                                    if ( $product->is_type( 'variable' ) ) {
                                        add_action('woocommerce_single_variation', array( $this, 'create_button' ));
                                    }else{
                                        add_action('woocommerce_before_add_to_cart_form', array( $this, 'create_button' ));
                                    }
                                    
                                }      
                            }
                        }
                    }
                }
                if(get_option( 'wpecf7_shop_page' ) == "yes") {
                    if(is_shop() || $wpecf7_object->taxonomy == "product_cat"){
                        if(get_option( 'wpecf7_rd_btn_pos' ) == "after_add_cart" ){
                            add_action('woocommerce_after_shop_loop_item', array( $this, 'create_button_shop' ), 11);
                        }elseif(get_option( 'wpecf7_rd_btn_pos' ) == "before_add_cart"){
                            add_action('woocommerce_after_shop_loop_item', array( $this, 'create_button_shop' ), 9);
                        }
                    }
                }
            }
            if(get_option( 'wpecf7_alw_gust_usr' ) == "no"){
                if(is_user_logged_in()){
                    if(get_option( 'wpecf7_sin_pro_page' ) == "yes"){
                        if(is_product()){
                            if(get_option( 'wpecf7_rd_btn_pos' ) == "after_add_cart" ){
                                if(get_option( 'wpecf7_rd_dis_pro' ) == "outofstock"){
                                    if( ! $product->is_in_stock()){
                                        add_action('woocommerce_product_meta_start', array( $this, 'create_button' ));
                                    } 
                                }else{
                                    if( ! $product->is_in_stock()){
                                        add_action('woocommerce_product_meta_start', array( $this, 'create_button' ));
                                    }else{
                                        add_action('woocommerce_after_add_to_cart_form', array( $this, 'create_button' ));
                                    }      
                                }   
                            }elseif(get_option( 'wpecf7_rd_btn_pos' ) == "before_add_cart"){
                                if(get_option( 'wpecf7_rd_dis_pro' ) == "outofstock"){
                                    if( ! $product->is_in_stock()){
                                        add_action('woocommerce_single_product_summary', array( $this, 'create_button' ));
                                    } 
                                }else{
                                    if( ! $product->is_in_stock()){
                                        add_action('woocommerce_single_product_summary', array( $this, 'create_button' ));
                                    }else{
                                        add_action('woocommerce_before_add_to_cart_form', array( $this, 'create_button' ));
                                    }      
                                }
                            }
                        }
                    }
                    if(get_option( 'wpecf7_shop_page' ) == "yes") {
                        if(is_shop() || $wpecf7_object->taxonomy == "product_cat"){
                            if(get_option( 'wpecf7_rd_btn_pos' ) == "after_add_cart" ){
                                add_action('woocommerce_after_shop_loop_item', array( $this, 'create_button_shop' ));
                            }elseif(get_option( 'wpecf7_rd_btn_pos' ) == "before_add_cart"){
                                add_action('woocommerce_after_shop_loop_item', array( $this, 'create_button_shop' ), 1);
                            }
                        }
                    }
                } 
            }   
        }

        function create_button_shop(){
            $getID = get_option( 'wpecf7_cntact_frm' );
            $proID = get_the_ID();
            $product = wc_get_product( $proID );
            if(get_option( 'wpecf7_rd_dis_pro' ) == "outofstock"){
                if( ! $product->is_in_stock()){
                    ?>
                    <div class="enquiry_btn_div">
                        <button class="form_opn" data-id="<?php echo $getID; ?>" proname="<?php echo $product->get_title(); ?>" style="background-color: <?php echo get_option( 'wpecf7_btn_bg_clr' ) ?>;color: <?php echo get_option( 'wpecf7_btn_ft_clr' ) ?>;"><?php echo get_option( 'wpecf7_btn_lbl' ); ?></button>
                    </div>
                    
                    <?php
                } 
            }else{
                ?>
                <div class="enquiry_btn_div">
                    <button class="form_opn" data-id="<?php echo $getID; ?>" proname="<?php echo $product->get_title(); ?>" style="background-color: <?php echo get_option( 'wpecf7_btn_bg_clr' ) ?>;color: <?php echo get_option( 'wpecf7_btn_ft_clr' ) ?>;"><?php echo get_option( 'wpecf7_btn_lbl' ); ?></button>
                </div>    
                <?php   
            }  
        }


        function create_button(){
            $getID = get_option( 'wpecf7_cntact_frm' );
            $proID = get_the_ID();
            $product = wc_get_product( $proID );
            
            ?>
            <div class="enquiry_btn_div">
                <button class="form_opn" data-id="<?php echo $getID; ?>" proname="<?php echo $product->get_title(); ?>" style="background-color: <?php echo get_option( 'wpecf7_btn_bg_clr' ) ?>;color: <?php echo get_option( 'wpecf7_btn_ft_clr' ) ?>;"><?php echo get_option( 'wpecf7_btn_lbl' ); ?></button>
            </div>
            <?php
        }


       
        function popup_div_footer(){
            ?>
            <div id="enquiry_popup" class="enquiry_popup_class">
            </div>
            <?php
        }



        function popup_open() {
            $popup_id = sanitize_text_field( $_REQUEST['popup_id'] );
            echo '<div class="enquiry_modal-content">';
            echo '<div class="popup_header">';
            echo '<h1>Enquiry Form</h1>';
            echo '<span class="enquired_close">&times;</span>';
            echo '</div>';
            echo '<div class="popup_body">';
            echo '<div class="popup_data">';
            echo '<div class="popup_padding_div">';
            echo do_shortcode('[contact-form-7 id="'.$popup_id.'"]');
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }


        function init() {
            add_action('wp_head', array( $this, 'headererrr' ));
            add_action('wp_footer', array( $this, 'popup_div_footer' ));
            add_action( 'wp_ajax_productscomments', array( $this, 'popup_open' ));
            add_action( 'wp_ajax_nopriv_productscomments', array( $this, 'popup_open' ));
        }

        public static function instance() {
            if (!isset(self::$instance)) {
                self::$instance = new self();
                self::$instance->init();
            }
             return self::$instance;
        }

    }

    WPECF7_front::instance();
}

