<?php

if (!defined('ABSPATH'))
  exit;

if (!class_exists('WPECF7_admin_menu')) {

  class WPECF7_admin_menu {

    protected static $WPECF7_instance;
    /**
     * Registers ADL Post Slider post type.
     */

    function WPECF7_submenu_page() {
        add_submenu_page( 'woocommerce', 'Enquiry Form', 'Enquiry Form', 'manage_options', 'enquiry-form',array($this, 'WPECF7_callback'));
    }

    function WPECF7_callback() {
    ?>    
        <div class="wrap">
            <h2>Enquiry Settings</h2>
        </div>
        <div class="wpecf7-container">
            <form method="post" >
                <?php wp_nonce_field( 'wpecf7_nonce_action', 'wpecf7_nonce_field' ); ?>
                <h2>Display Setting</h2>
                <div class="wpecf7_cover_div">
                    <table class="wpecf7_data_table">
                        <tr>
                            <th>Product single page</th>
                            <td>
                                <input type="checkbox" name="wpecf7_sin_pro_page" value="yes" <?php if (get_option( 'wpecf7_sin_pro_page' ) == "yes" || empty(get_option( 'wpecf7_sin_pro_page' ))) {echo 'checked="checked"';} ?>>
                                <strong><?php echo esc_html( __( 'Add Enquiry Button On single Product Page.', WPECF7_DOMAIN ) );
                                ?></strong>

                            </td>
                        </tr>
                        <tr>
                            <th>Product catalogue page</th>
                            <td>
                                <input type="checkbox" name="wpecf7_shop_page" value="yes" <?php if (get_option( 'wpecf7_shop_page' ) == "yes" || empty(get_option( 'wpecf7_shop_page' ))) {echo 'checked="checked"';} ?>>
                                <strong><?php echo esc_html( __( 'Add Enquiry Button On Shop & Catalogue Product Page.', WPECF7_DOMAIN ) );?></strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Product</th>
                            <td>
                                <input type="radio" name="wpecf7_rd_dis_pro" value="outofstock" <?php if (get_option( 'wpecf7_rd_dis_pro' ) == "outofstock" ) {echo 'checked="checked"';} ?>><?php echo esc_html( __( 'Only For Out Of Stock', WPECF7_DOMAIN ) );?></br>
                                <input type="radio" name="wpecf7_rd_dis_pro" value="all" <?php if (get_option( 'wpecf7_rd_dis_pro' ) == "all" || empty(get_option( 'wpecf7_rd_dis_pro' ))) {echo 'checked="checked"';} ?>><?php echo esc_html( __( 'For All Product', WPECF7_DOMAIN ) );?>
                            </td>
                        </tr>
                    </table>
                </div>
                <h2>Button Setting</h2>
                <div class="wpecf7_cover_div">
                    <table class="wpecf7_data_table">
                        <tr>
                            <th>Button Label</th>
                            <td>
                                <input type="text" name="wpecf7_btn_lbl" value="<?php if(!empty(get_option( 'wpecf7_btn_lbl' ))){ echo get_option( 'wpecf7_btn_lbl' ); }else{ echo "Enquiry";} ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>Button Text color</th>
                            <td>
                                <input type="color" name="wpecf7_btn_ft_clr" value="<?php if(!empty(get_option( 'wpecf7_btn_ft_clr' ))){ echo get_option( 'wpecf7_btn_ft_clr' ); }else{ echo "#ffffff";} ?>">
                            </td>
                        </tr>
                       
                        <tr>
                            <th>Button background color</th>
                            <td>
                                <input type="color" name="wpecf7_btn_bg_clr" value="<?php if(!empty(get_option( 'wpecf7_btn_bg_clr' ))){ echo get_option( 'wpecf7_btn_bg_clr' ); }else{ echo "#000000";} ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>Button Position</th>
                            <td>
                                <input type="radio" name="wpecf7_rd_btn_pos" value="before_add_cart" <?php if (get_option( 'wpecf7_rd_btn_pos' ) == "before_add_cart" ) {echo 'checked="checked"';} ?>><?php echo esc_html( __( 'Before Add To Cart', WPECF7_DOMAIN ) );?></br>
                                <input type="radio" name="wpecf7_rd_btn_pos" value="after_add_cart" <?php if (get_option( 'wpecf7_rd_btn_pos' ) == "after_add_cart" || empty(get_option( 'wpecf7_rd_btn_pos' ))) {echo 'checked="checked"';} ?>><?php echo esc_html( __( 'After Add To Cart', WPECF7_DOMAIN ) );?></br>
                            </td>
                        </tr>
                    </table>
                </div>
                <h2>User Setting</h2>
                <div class="wpecf7_cover_div">
                    <table class="wpecf7_data_table">
                        <tr>
                            <th>Allow Guest User</th>
                            <td>
                                <input type="checkbox" name="wpecf7_alw_gust_usr" value="yes" <?php if (get_option( 'wpecf7_alw_gust_usr' ) == "yes" ) {echo 'checked="checked"';} ?>>
                                <strong><?php echo esc_html( __( 'Allow Enquiry For Guest User.', WPECF7_DOMAIN ) );?></strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Select Contact Form</th>
                            <td>
                                <?php 
                                    $args = array('post_type' => 'wpcf7_contact_form', 
                                                  'posts_per_page' => -1); 
                                    $cf7Forms = get_posts( $args );
                                    
                                    
                                    $form_titles = wp_list_pluck( $cf7Forms , 'post_title', 'ID' );
                                    // echo "<pre>";
                                    // print_r($form_titles);
                                    // echo "</pre>";
                                ?>
                                <select name="wpecf7_cntact_frm">
                                    <?php
                                        foreach ($form_titles as $key => $value) {
                                            ?>
                                            <option value="<?php echo $key; ?>" <?php if(get_option( 'wpecf7_cntact_frm' ) == $key){ echo "selected"; } ?>><?php echo $value; ?></option>
                                            <?php
                                        } 
                                    ?>
                                    
                                </select>
                                <p><?php echo esc_html( __( 'Select here contact form 7 which are created for enquiry form.', WPECF7_DOMAIN ) );?></p>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="example_td">
                                <p>Give "product-name" to contact form 7 text field name for product name</p>
                                <p class="example_class">Example: </p><xmp><label> Product Name
    [text product-name] </label></xmp>
                            </td>
                        </tr>   
                    </table>
                </div>
                <input type="hidden" name="action" value="wpecf7_save_option">
                <input type="submit" value="Save changes" name="submit" class="button-primary" id="wfc-btn-space">
            </form>  
        </div>
    <?php
    }


    function WPECF7_save_options(){
        if( current_user_can('administrator') ) { 
          if($_REQUEST['action'] == 'wpecf7_save_option'){
            if(!isset( $_POST['wpecf7_nonce_field'] ) || !wp_verify_nonce( $_POST['wpecf7_nonce_field'], 'wpecf7_nonce_action' ) ){
                print 'Sorry, your nonce did not verify.';
                exit;
            }else{
                
                $sin_page = (!empty(sanitize_text_field( $_REQUEST['wpecf7_sin_pro_page'] )))? sanitize_text_field( $_REQUEST['wpecf7_sin_pro_page'] ) : 'no';

                update_option('wpecf7_sin_pro_page', $sin_page, 'yes');

                $shop_page = (!empty(sanitize_text_field( $_REQUEST['wpecf7_shop_page'] )))? sanitize_text_field( $_REQUEST['wpecf7_shop_page'] ) : 'no';

                update_option('wpecf7_shop_page', $shop_page, 'yes');


                update_option('wpecf7_rd_dis_pro', sanitize_text_field( $_REQUEST['wpecf7_rd_dis_pro'] ), 'yes');



                update_option('wpecf7_btn_lbl', sanitize_text_field( $_REQUEST['wpecf7_btn_lbl'] ), 'yes');
                update_option('wpecf7_btn_ft_clr', sanitize_text_field( $_REQUEST['wpecf7_btn_ft_clr'] ), 'yes');
                //update_option('wpecf7_btn_ft_size', sanitize_text_field( $_REQUEST['wpecf7_btn_ft_size'] ), 'yes');
                update_option('wpecf7_btn_bg_clr', sanitize_text_field( $_REQUEST['wpecf7_btn_bg_clr'] ), 'yes');
                update_option('wpecf7_rd_btn_pos', sanitize_text_field( $_REQUEST['wpecf7_rd_btn_pos'] ), 'yes');


                $gust_usr = (!empty(sanitize_text_field( $_REQUEST['wpecf7_alw_gust_usr'] )))? sanitize_text_field( $_REQUEST['wpecf7_alw_gust_usr'] ) : 'no';

                update_option('wpecf7_alw_gust_usr', $gust_usr, 'yes');

                update_option('wpecf7_cntact_frm', sanitize_text_field( $_REQUEST['wpecf7_cntact_frm'] ), 'yes');

            }
          }
        }
      }

    function init() {
        add_action( 'admin_menu',  array($this, 'WPECF7_submenu_page'));
        add_action( 'init',  array($this, 'WPECF7_save_options'));
    }

    public static function WPECF7_instance() {
      if (!isset(self::$WPECF7_instance)) {
        self::$WPECF7_instance = new self();
        self::$WPECF7_instance->init();
      }
      return self::$WPECF7_instance;
    }

  }

  WPECF7_admin_menu::WPECF7_instance();
}

