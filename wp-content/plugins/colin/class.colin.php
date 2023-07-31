<?php

  class Colin {
    public static function init() {
      if ( ! self::$initiated ) {
        self::init_hooks();
      }
    }
    public function init_hooks() {
      add_action( 'save_post', array( 'Colin', 'post_test' ), 10, 3 );
    }
    public function post_test( $post_ID, $post, $update) {
      echo 'sdfasklasjdkfjalsdjfl';
      print_r($post);
      return $post_ID;
    }
    public static function plugin_activation() {

    }

    /**
     * Removes all connection options
     * @static
     */
    public static function plugin_deactivation( ) {

    }
  }
