<?php
/*
 * Plugin Name: FH OÖ Gastvortrag - Hands on Gutenberg
 * Plugin URI: https://github.com/iantsch/fh-ooe-gutenberg
 * Description: SVG Support für WordPress Mediathek und Gutenberg Blocks
 * Version: 1.0.0
 * Author: Christian Tschugg
 * Author URI: http://www.MMCAGENTUR.at
 * Copyright: Christian Tschugg
 * Text Domain: fh-ooe-gutenberg
*/

if (!function_exists('get_svg')) {
    function get_svg($key, $class = [])
    {
        return Svg::getSvg($key, $class);
    }
}

if (!function_exists('wp_get_attachment_image_or_svg')){
    function wp_get_attachment_image_or_svg($attachmentId, $size = 'thumbnail', $attr = '') {
        $attachedFile = get_post_meta($attachmentId, '_wp_attached_file', true);
        if (strpos($attachedFile, '.svg') !== false) {
            $key = basename($attachedFile,'.svg');
            $class = [];
            if (is_array($attr) && array_key_exists('class', $attr)) {
                $class[] = $attr['class'];
            }
            $width = 0;
            $height = 0;
            if (is_array($size)) {
                $width = $size[0];
                $height = $size[1];
            }
            return get_svg(basename($key,'.svg'), $class);
        }
        return wp_get_attachment_image($attachmentId, $size, false, $attr);
    }
}

trait Singleton
{
    protected static $instance = null;

    /**
     * @return static::class
     */
    public static function init()
    {
        if (!is_a(static::$instance, static::class)) {
            static::$instance = new static;
        }

        return static::$instance;
    }
}

class Svg
{

    use Singleton;

    private static $baseClass = 'svg';
    private static $cssStyle = '--';
    private static $handle = 'fh-ooe/gutenberg';
    private static $blocks = [];

    private function __construct()
    {
        add_filter('plugin_row_meta', [$this, 'donateBeer'], 10, 4);
        add_filter('wp_check_filetype_and_ext', [$this, 'checkFileType'], 10, 4);
        add_filter('upload_mimes', [$this, 'addSvgMime']);
        add_filter('wp_get_attachment_image_src', [$this, 'getSvgThumbnail'], 10, 4);
        add_filter('wp_prepare_attachment_for_js', [$this, 'prepareSvgForJs'], 10, 3);
        add_filter('Svg/Markup', [$this, 'addMarkup'], 10, 4);
        if (!static::hasSupport()) {
            return;
        }
        add_action('render_block', [$this, 'renderSvg'], 10, 2);
        add_action('enqueue_block_assets', [$this, 'enqueueBlock']);
    }

    static function hasSupport()
    {
        global $wp_version;

        return (!version_compare($wp_version, '5.0.0', '<') || function_exists('register_block_type'));
    }

    public function donateBeer($meta, $basename, $data, $status)
    {
        if ($basename !== plugin_basename(__FILE__)) {
            return $meta;
        }
        $meta[] = '<a href="//paypal.me/iantsch/5" target="_blank" rel="noopener external">Buy me a 🍺</a>';

        return $meta;
    }

    public function checkFileType($compact, $file, $filename, $mimes)
    {
        $filetype = wp_check_filetype($filename, $mimes);

        return [
            'ext' => $filetype['ext'],
            'type' => $filetype['type'],
            'proper_filename' => $compact['proper_filename'],
        ];
    }

    public function addSvgMime($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';

        return $mimes;
    }

    public function getSvgThumbnail($image, $attachmentId, $size, $icon)
    {
        if ($icon && get_post_mime_type($attachmentId) === 'image/svg+xml') {
            $attachedFile = get_post_meta($attachmentId, '_wp_attached_file', true);
            $dimensions = $this->getDimension($attachedFile);
            $svgUrl = wp_get_attachment_image_url($attachmentId);
            $image[0] = $svgUrl;
            $image[1] = $dimensions->width;
            $image[2] = $dimensions->height;
        }

        return $image;
    }

    public function prepareSvgForJs($response, $attachment, $meta)
    {
        if ('image/svg+xml' !== $response['mime']) {
            return $response;
        }
        $attachedFile = get_post_meta($attachment->ID, '_wp_attached_file', true);
        $dimensions = $this->getDimension($attachedFile);
        $svgUrl = wp_get_attachment_image_url($attachment->ID);
        $response['url'] = $svgUrl;
        $response['sizes'] = [
            'full' => [
                'url' => $svgUrl,
                'width' => $dimensions->width,
                'height' => $dimensions->height,
                'orientation' => $dimensions->width > $dimensions->height ? 'landscape' : 'portrait',
            ],
        ];

        return $response;
    }

    private function getDimension($attachedFile)
    {
        $width = $height = 0;
        $svg = simplexml_load_file($attachedFile, 'SimpleXMLElement', LIBXML_NOWARNING);
        if ($svg) {
            $attributes = $svg->attributes();
            if (isset($attributes->width)) {
                $width = (string)$attributes->width;
            }
            if (isset($attributes->height)) {
                $height = (string)$attributes->height;
            }
            if (isset($attributes->viewBox) && ($width === 0 || $height === 0)) {
                $viewBox = explode(' ', (string)$attributes->viewBox);
                $width = $viewBox[2] - $viewBox[0];
                $height = $viewBox[3] - $viewBox[1];
            }
        }

        return (object)compact('width', 'height');
    }

    function addMarkup($markup, $content, $doc, $svg)
    {
        foreach ($content->childNodes as $node) {
            $markup .= $node->C14N();
        }
        return $markup;
    }

    static function getSvg($key, $class = []) {
        $id = sanitize_title($key);
        $class[] = static::$baseClass . static::$cssStyle . $id;

        global $wpdb;
        $file = $wpdb->get_var($wpdb->prepare(
            "SELECT key1.meta_value
            FROM $wpdb->postmeta key1
            WHERE key1.meta_value LIKE %s AND key1.meta_key = '_wp_attached_file'"
            , '%/' . $key . '.svg'));

        if (strpos($file, '/') !== 0) {
            $uploads = wp_upload_dir();
            $file = trailingslashit($uploads['basedir']) . $file;
        }
        if (!file_exists($file)) {
            return new WP_Error(404, __('SVG not found', 'mbt'));
        }
        $svg = @file_get_contents($file);
        $doc = new \DOMDocument();
        $doc->preserveWhiteSpace = false;
        $doc->loadXML($svg);
        $content = $doc->documentElement;

        $svg = (object)[
            'viewBox' => (string)$content->getAttribute('viewBox'),
            'markup' => apply_filters('Svg/Markup', '', $content, $doc, $svg),
        ];

        $svgMarkup = '<svg role="img" class="' . implode(' ', $class) . '"';
        $svgMarkup .= " viewBox=\"{$svg->viewBox}\">";
        $svgMarkup .= $svg->markup;
        $svgMarkup .= '</svg>';
        return $svgMarkup;
    }

    public function enqueueBlock() {
        wp_enqueue_script(
            static::$handle,
            plugin_dir_url( __FILE__ ) . 'dist/svg.js',
            ['wp-blocks', 'wp-i18n']
        );
    }

    public function renderSvg($content, $block)
    {
        return $content;
    }
}

Svg::init();