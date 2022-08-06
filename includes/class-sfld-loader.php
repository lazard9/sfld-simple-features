<?php defined( 'WPINC' ) or die();

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://digitalapps.com
 */

namespace SFLD\Includes;

if( ! class_exists('SFLD_Loader') ) : final class SFLD_Loader 
{

    /**
	 * Unique instance.
	 */
    private static $_instance = null;

    /**
     * Protected class constructor to prevent direct object creation
     *
     * This is meant to be overridden in the classes which implement
     * this trait. This is ideal for doing stuff that you only want to
     * do once, such as hooking into actions and filters, etc.
     */
    public function __construct() {
    }

    /**
     * Prevent object cloning.
     */
    final protected function __clone() {
	}
    
    /**
     * Method to get the unique instance.
     */
    public static function get_instance() {
        // Create the instance if it does not exist.
        if (!isset(self::$_instance)) {
            self::$_instance = new self;
        }

        // Return the unique instance.
        return self::$_instance;
    }

    /**
     * The array of actions registered with WordPress.
     *
     * 
     * @access   protected
     * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
     */
    protected $actions;

    /**
     * The array of filters registered with WordPress.
     *
     * 
     * @access   protected
     * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
     */
    protected $filters;

    /**
     * The array of filters registered with WordPress.
     *
     * 
     * @access   protected
     * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
     */
    protected $shortcodes;

    /**
     * Initialize the collections used to maintain the actions and filters.
     *
     * 
     */
    public function hooks() {

        $this->actions = array();
        $this->filters = array();
        $this->shortcodes = array();

    }

    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * 
     * @param    string               $hook             The name of the WordPress action that is being registered.
     * @param    object               $component        A reference to the instance of the object on which the action is defined.
     * @param    string               $callback         The name of the function definition on the $component.
     * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
     * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
     */
    public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
        $this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * 
     * @param    string               $hook             The name of the WordPress filter that is being registered.
     * @param    object               $component        A reference to the instance of the object on which the filter is defined.
     * @param    string               $callback         The name of the function definition on the $component.
     * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
     * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
     */
    public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
        $this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * 
     * @param    string               $hook             The name of the WordPress filter that is being registered.
     * @param    object               $component        A reference to the instance of the object on which the filter is defined.
     * @param    string               $callback         The name of the function definition on the $component.
     * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
     * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
     */
    public function add_shortcode( $tag, $component, $callback ) {
        // $this->shortcodes[] = array( 'tag'=> $tag, 'component' => $component, 'callback'=> $callback );
        $this->shortcodes = $this->add_shortcodes( $this->shortcodes, $tag, $component, $callback );
    }

    /**
     * A utility function that is used to register the actions and hooks into a single
     * collection.
     *
     * 
     * @access   private
     * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
     * @param    string               $hook             The name of the WordPress filter that is being registered.
     * @param    object               $component        A reference to the instance of the object on which the filter is defined.
     * @param    string               $callback         The name of the function definition on the $component.
     * @param    int                  $priority         The priority at which the function should be fired.
     * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
     * @return   array                                  The collection of actions and filters registered with WordPress.
     */
    private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

        $hooks[] = array(
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args
        );

        return $hooks;

    }

    /**
     * A utility function that is used to register the shortcodes into a single
     * collection.
     */
    private function add_shortcodes( $shortcodes, $tag, $component, $callback ) {
        
        $shortcodes[] = array(
            'tag'          => $tag,
            'component'    => $component,
            'callback'     => $callback,
        );

        return $shortcodes;

    }

    /**
     * Register the filters and actions with WordPress.
     *
     * 
     */
    public function run_hooks() {

        foreach ( $this->actions as $hook ) {
            add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
        }

        foreach ( $this->filters as $hook ) {
            add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
        }
        
        foreach ( $this->shortcodes as $tag ) {
            add_shortcode( $tag['tag'], array( $tag['component'], $tag['callback'] ) );
        }

    }

} endif;