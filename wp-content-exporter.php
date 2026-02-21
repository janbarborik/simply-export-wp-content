<?php
/**
 * Plugin Name: Simply Export Your WordPress Content
 * Plugin URI: https://marketingonmyown.com
 * Description: Export your WordPress content (pages, posts, and custom post types) to RTF or Markdown format. Strips Divi shortcodes, HTML tags, images, and iframes — giving you clean, plain text. Perfect for building an AI knowledge base from your own website content.
 * Version: 1.1.0
 * Author: Jan Barborík
 * Author URI: https://marketingonmyown.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: simply-export-wp-content
 * Requires at least: 5.0
 * Tested up to: 6.7
 * Requires PHP: 7.4
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Simply_Export_WP_Content {

    private $plugin_slug = 'simply-export-wp-content';

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_init', array( $this, 'handle_export' ) );
        add_action( 'admin_head', array( $this, 'admin_styles' ) );
    }

    /**
     * Inline admin styles
     */
    public function admin_styles() {
        echo '<style>
            .sewc-banner {
                background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
                color: #fff;
                padding: 20px 24px;
                border-radius: 8px;
                margin-top: 30px;
                display: flex;
                align-items: center;
                gap: 20px;
                flex-wrap: wrap;
            }
            .sewc-banner .sewc-banner-text { flex: 1; min-width: 200px; }
            .sewc-banner h3 { margin: 0 0 6px; font-size: 16px; color: #e0e0ff; }
            .sewc-banner p  { margin: 0; font-size: 13px; color: #aab4d4; line-height: 1.5; }
            .sewc-banner .sewc-btn {
                display: inline-block;
                background: #e94560;
                color: #fff;
                padding: 9px 18px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: 600;
                font-size: 13px;
                white-space: nowrap;
                transition: background .2s;
            }
            .sewc-banner .sewc-btn:hover { background: #c73652; color: #fff; }
            .sewc-banner .sewc-btn-secondary {
                display: inline-block;
                background: transparent;
                color: #aab4d4;
                padding: 9px 18px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: 600;
                font-size: 13px;
                white-space: nowrap;
                border: 1px solid #aab4d4;
                margin-left: 8px;
                transition: border-color .2s, color .2s;
            }
            .sewc-banner .sewc-btn-secondary:hover { border-color: #fff; color: #fff; }
            .sewc-format-selector { display: flex; gap: 16px; margin-top: 4px; }
            .sewc-format-selector label { display: flex; align-items: center; gap: 6px; cursor: pointer; font-weight: 600; }
        </style>';
    }

    /**
     * Add menu page under Tools
     */
    public function add_admin_menu() {
        add_management_page(
            'Simply Export Your Content',
            'Simply Export Content',
            'manage_options',
            $this->plugin_slug,
            array( $this, 'render_admin_page' )
        );
    }

    /**
     * Render the admin page
     */
    public function render_admin_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $post_types = get_post_types( array( 'public' => true ), 'objects' );

        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

            <div class="notice notice-info">
                <p><strong>How it works:</strong></p>
                <ul style="list-style: disc; margin-left: 20px;">
                    <li>Choose which <strong>content types</strong> you want to export — pages, posts, or any custom post type</li>
                    <li>The plugin automatically strips Divi shortcodes, HTML tags, images, and iframes</li>
                    <li>Only <strong>published</strong> content is exported</li>
                    <li>Choose your output format: <strong>RTF</strong> (compatible with Word, LibreOffice) or <strong>Markdown</strong> (great for AI tools &amp; Notion)</li>
                    <li>The plugin only <strong>reads</strong> data — it never modifies your database</li>
                </ul>
                <p style="margin-top: 8px;">
                    💡 <strong>Pro tip:</strong> Export your content to Markdown, upload it to Google Drive or a knowledge base tool, and connect it to your AI assistant — instantly creating an AI trained on your own website content.
                </p>
            </div>

            <form method="post" action="">
                <?php wp_nonce_field( 'sewc_export_action', 'sewc_nonce' ); ?>

                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label>Content types to export:</label>
                        </th>
                        <td>
                            <?php foreach ( $post_types as $post_type ) : ?>
                                <label style="display: block; margin-bottom: 10px;">
                                    <input type="checkbox"
                                           name="post_types[]"
                                           value="<?php echo esc_attr( $post_type->name ); ?>"
                                           <?php checked( in_array( $post_type->name, array( 'page', 'post' ), true ) ); ?>>
                                    <strong><?php echo esc_html( $post_type->label ); ?></strong>
                                    <span style="color: #666;">(<?php echo esc_html( $post_type->name ); ?>)</span>
                                </label>
                            <?php endforeach; ?>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="include_excerpts">Include excerpts:</label>
                        </th>
                        <td>
                            <input type="checkbox" id="include_excerpts" name="include_excerpts" value="1">
                            <span class="description">Adds short excerpts when available</span>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label>Export format:</label>
                        </th>
                        <td>
                            <div class="sewc-format-selector">
                                <label>
                                    <input type="radio" name="export_format" value="rtf" checked>
                                    RTF
                                    <span style="color:#666; font-weight:400;">(Word, LibreOffice)</span>
                                </label>
                                <label>
                                    <input type="radio" name="export_format" value="markdown">
                                    Markdown
                                    <span style="color:#666; font-weight:400;">(AI tools, Notion, Obsidian)</span>
                                </label>
                            </div>
                        </td>
                    </tr>
                </table>

                <?php submit_button( 'Export Content', 'primary', 'export_content' ); ?>
            </form>

            <!-- Marketing banner -->
            <div class="sewc-banner">
                <div class="sewc-banner-text">
                    <h3>Want to master online marketing on your own?</h3>
                    <p>Learn how to use AI tools, build effective content strategy, and grow your business without an agency.
                    Practical guides in English &amp; Czech — written by Jan Barborík.</p>
                </div>
                <div>
                    <a href="https://marketingonmyown.com" target="_blank" rel="noopener noreferrer" class="sewc-btn">
                        marketingonmyown.com
                    </a>
                    <a href="https://samsobemarketerem.cz" target="_blank" rel="noopener noreferrer" class="sewc-btn-secondary">
                        samsobemarketerem.cz
                    </a>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Handle export form submission
     */
    public function handle_export() {
        if ( ! isset( $_POST['export_content'] ) ) {
            return;
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'You do not have permission to perform this action.' );
        }

        if ( ! isset( $_POST['sewc_nonce'] ) ||
             ! wp_verify_nonce( $_POST['sewc_nonce'], 'sewc_export_action' ) ) {
            wp_die( 'Security check failed.' );
        }

        if ( empty( $_POST['post_types'] ) || ! is_array( $_POST['post_types'] ) ) {
            add_action( 'admin_notices', function () {
                echo '<div class="notice notice-error"><p>Please select at least one content type to export.</p></div>';
            } );
            return;
        }

        $post_types      = array_map( 'sanitize_text_field', $_POST['post_types'] );
        $include_excerpts = isset( $_POST['include_excerpts'] );
        $export_format   = isset( $_POST['export_format'] ) && $_POST['export_format'] === 'markdown'
                           ? 'markdown'
                           : 'rtf';

        if ( $export_format === 'markdown' ) {
            $this->generate_markdown_export( $post_types, $include_excerpts );
        } else {
            $this->generate_rtf_export( $post_types, $include_excerpts );
        }
    }

    // -------------------------------------------------------------------------
    // RTF EXPORT
    // -------------------------------------------------------------------------

    /**
     * Generate and stream RTF export
     */
    private function generate_rtf_export( $post_types, $include_excerpts ) {
        $posts = $this->get_posts( $post_types );

        if ( empty( $posts ) ) {
            add_action( 'admin_notices', function () {
                echo '<div class="notice notice-warning"><p>No published content found for the selected types.</p></div>';
            } );
            return;
        }

        $rtf_content  = $this->get_rtf_header();
        $current_type = '';

        foreach ( $posts as $post ) {
            if ( $current_type !== $post->post_type ) {
                $current_type  = $post->post_type;
                $post_type_obj = get_post_type_object( $post->post_type );
                $type_label    = $post_type_obj ? $post_type_obj->label : $post->post_type;
                $rtf_content  .= '\pard\sa200\sb200\b\fs32 ' . $this->rtf_encode( strtoupper( $type_label ) ) . '\b0\fs24\par' . "\n";
            }

            $rtf_content .= '\pard\sa100\sb100\b\fs28 ' . $this->rtf_encode( $post->post_title ) . '\b0\fs24\par' . "\n";

            if ( $include_excerpts && ! empty( $post->post_excerpt ) ) {
                $excerpt      = $this->clean_content( $post->post_excerpt );
                $rtf_content .= '\pard\sa50\i ' . $this->rtf_encode( $excerpt ) . '\i0\par' . "\n";
            }

            $content      = $this->clean_content( $post->post_content );
            $rtf_content .= '\pard\sa100 ' . $this->rtf_encode( $content ) . '\par' . "\n";
            $rtf_content .= '\pard\sa200\par' . "\n" . '\line\line' . "\n";
        }

        $rtf_content .= '}';

        $filename = 'wp-content-export-' . gmdate( 'Y-m-d-H-i-s' ) . '.rtf';

        header( 'Content-Type: application/rtf' );
        header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
        header( 'Content-Length: ' . strlen( $rtf_content ) );
        header( 'Cache-Control: must-revalidate' );
        header( 'Pragma: public' );

        echo $rtf_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        exit;
    }

    /**
     * RTF document header
     */
    private function get_rtf_header() {
        return '{\\rtf1\\ansi\\deff0' . "\n" .
               '{\\fonttbl{\\f0\\fnil\\fcharset0 Arial;}}' . "\n" .
               '\\viewkind4\\uc1\\pard\\lang1033\\f0\\fs24' . "\n\n";
    }

    /**
     * Encode text for RTF
     */
    private function rtf_encode( $text ) {
        $text = str_replace( '\\', '\\\\', $text );
        $text = str_replace( '{', '\\{', $text );
        $text = str_replace( '}', '\\}', $text );
        $text = $this->unicode_to_rtf( $text );
        $text = str_replace( "\r\n", "\\line\n", $text );
        $text = str_replace( "\n", "\\line\n", $text );
        return $text;
    }

    /**
     * Convert Unicode characters to RTF escape sequences
     */
    private function unicode_to_rtf( $text ) {
        $result = '';
        $length = mb_strlen( $text, 'UTF-8' );
        for ( $i = 0; $i < $length; $i++ ) {
            $char   = mb_substr( $text, $i, 1, 'UTF-8' );
            $code   = $this->utf8_ord( $char );
            $result .= ( $code < 128 ) ? $char : '\\u' . $code . '?';
        }
        return $result;
    }

    /**
     * Get Unicode code point of a UTF-8 character
     */
    private function utf8_ord( $char ) {
        $ord = ord( $char );
        if ( $ord < 128 )   return $ord;
        if ( $ord < 224 )   return ( $ord - 192 ) * 64   + ( ord( $char[1] ) - 128 );
        if ( $ord < 240 )   return ( $ord - 224 ) * 4096 + ( ord( $char[1] ) - 128 ) * 64   + ( ord( $char[2] ) - 128 );
        return ( $ord - 240 ) * 262144 + ( ord( $char[1] ) - 128 ) * 4096 + ( ord( $char[2] ) - 128 ) * 64 + ( ord( $char[3] ) - 128 );
    }

    // -------------------------------------------------------------------------
    // MARKDOWN EXPORT
    // -------------------------------------------------------------------------

    /**
     * Generate and stream Markdown export
     */
    private function generate_markdown_export( $post_types, $include_excerpts ) {
        $posts = $this->get_posts( $post_types );

        if ( empty( $posts ) ) {
            add_action( 'admin_notices', function () {
                echo '<div class="notice notice-warning"><p>No published content found for the selected types.</p></div>';
            } );
            return;
        }

        $md_content   = '';
        $current_type = '';

        foreach ( $posts as $post ) {
            if ( $current_type !== $post->post_type ) {
                $current_type  = $post->post_type;
                $post_type_obj = get_post_type_object( $post->post_type );
                $type_label    = $post_type_obj ? $post_type_obj->label : $post->post_type;
                $md_content   .= '# ' . strtoupper( $type_label ) . "\n\n";
            }

            $md_content .= '## ' . $post->post_title . "\n\n";

            if ( $include_excerpts && ! empty( $post->post_excerpt ) ) {
                $excerpt     = $this->clean_content( $post->post_excerpt );
                $md_content .= '*' . $excerpt . "*\n\n";
            }

            $content     = $this->clean_content( $post->post_content );
            $md_content .= $content . "\n\n---\n\n";
        }

        $filename = 'wp-content-export-' . gmdate( 'Y-m-d-H-i-s' ) . '.md';

        header( 'Content-Type: text/markdown; charset=UTF-8' );
        header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
        header( 'Content-Length: ' . strlen( $md_content ) );
        header( 'Cache-Control: must-revalidate' );
        header( 'Pragma: public' );

        echo $md_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        exit;
    }

    // -------------------------------------------------------------------------
    // SHARED HELPERS
    // -------------------------------------------------------------------------

    /**
     * Fetch published posts for the given post types, ordered by type then title
     */
    private function get_posts( $post_types ) {
        $query = new WP_Query( array(
            'post_type'      => $post_types,
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => array( 'type' => 'ASC', 'title' => 'ASC' ),
        ) );

        $posts = $query->posts;
        wp_reset_postdata();
        return $posts;
    }

    /**
     * Strip Divi shortcodes, all shortcodes, HTML tags, and extra whitespace
     */
    private function clean_content( $content ) {
        // Remove Divi shortcodes
        $content = preg_replace( '/\[et_pb_[^\]]*\]/', '', $content );
        $content = preg_replace( '/\[\/et_pb_[^\]]*\]/', '', $content );

        // Remove all remaining shortcodes
        $content = preg_replace( '/\[[^\]]*\]/', '', $content );

        // Strip HTML tags
        $content = wp_strip_all_tags( $content );

        // Decode HTML entities
        $content = html_entity_decode( $content, ENT_QUOTES | ENT_HTML5, 'UTF-8' );

        // Collapse excessive blank lines
        $content = preg_replace( '/\n\s*\n\s*\n/', "\n\n", $content );

        return trim( $content );
    }
}

// Bootstrap
function sewc_init() {
    new Simply_Export_WP_Content();
}
add_action( 'plugins_loaded', 'sewc_init' );
