<?php

if(class_exists('MetaSlide')) :

class VantageSimpleSlide extends MetaSlide {

    /**
     * Register slide type
     */
    public function __construct() {
        add_filter('metaslider_get_test_slide', array($this, 'get_slide'), 10, 2);
        add_action('metaslider_save_test_slide', array($this, 'save_slide'), 5, 3);
        add_action('wp_ajax_create_test_slide', array($this, 'ajax_create_slide'));
    }

    /**
     * Create a new slide and echo the admin HTML
     */
    public function ajax_create_slide() {
        $slide_id = intval($_POST['slide_id']);
        $slider_id = intval($_POST['slider_id']);

        $this->set_slide($slide_id);
        $this->set_slider($slider_id);
        $this->tag_slide_to_slider();

        $this->add_or_update_or_delete_meta($slide_id, 'type', 'image');

        echo $this->get_admin_slide();
        die();
    }

    /**
     * Return the HTML used to display this slide in the admin screen
     *
     * @return string slide html
     */
    protected function get_admin_slide() {
        // get some slide settings
        $thumb   = $this->get_thumb();
        $full    = wp_get_attachment_image_src($this->slide->ID, 'full');
        $url     = get_post_meta($this->slide->ID, 'ml-slider_url', true);
        $target  = get_post_meta($this->slide->ID, 'ml-slider_new_window', true) ? 'checked=checked' : '';
        $caption = htmlentities($this->slide->post_excerpt, ENT_QUOTES, 'UTF-8');

        // localisation
        $str_caption    = __("Caption", 'metaslider');
        $str_new_window = __("New Window", 'metaslider');
        $str_url        = __("URL", 'metaslider');

        // slide row HTML
        $row  = "<tr class='slide flex responsive nivo coin'>";
        $row .= "    <td class='col-1'>";
        $row .= "        <div class='thumb' style='background-image: url({$thumb})'>";
        $row .= "            <a class='delete-slide confirm' href='?page=metaslider&id={$this->slider->ID}&deleteSlide={$this->slide->ID}'>x</a>";
        $row .= "            <span class='slide-details'>Image {$full[1]} x {$full[2]}</span>";
        $row .= "        </div>";
        $row .= "    </td>";
        $row .= "    <td class='col-2'>";
        $row .= "        <textarea name='attachment[{$this->slide->ID}][post_excerpt]' placeholder='{$str_caption}'>{$caption}</textarea>";
        $row .= "        <input class='url' type='url' name='attachment[{$this->slide->ID}][url]' placeholder='{$str_url}' value='{$url}' />";
        $row .= "        <div class='new_window'>";
        $row .= "            <label>{$str_new_window}<input type='checkbox' name='attachment[{$this->slide->ID}][new_window]' {$target} /></label>";
        $row .= "        </div>";
        $row .= "        <input type='hidden' name='attachment[{$this->slide->ID}][type]' value='image' />";
        $row .= "        <input type='hidden' class='menu_order' name='attachment[{$this->slide->ID}][menu_order]' value='{$this->slide->menu_order}' />";
        $row .= "    </td>";
        $row .= "</tr>";

        return $row;
    }

    /**
     * Returns the HTML for the public slide
     *
     * @return string slide html
     */
    protected function get_public_slide() {
        // get the image url (and handle cropping)
        $imageHelper = new MetaSliderImageHelper(
            $this->slide->ID,
            $this->settings['width'],
            $this->settings['height'],
            isset($this->settings['smartCrop']) ? $this->settings['smartCrop'] : 'false'
        );

        $url = $imageHelper->get_image_url();

        if (is_wp_error($url)) {
            return ""; // bail out here. todo: look at a way of notifying the admin
        }

        // store the slide details
        $slide = array(
            'thumb' => $url,
            'url' => get_post_meta($this->slide->ID, 'ml-slider_url', true),
            'alt' => get_post_meta($this->slide->ID, '_wp_attachment_image_alt', true),
            'target' => get_post_meta($this->slide->ID, 'ml-slider_new_window', true) ? '_blank' : '_self',
            'caption' => html_entity_decode($this->slide->post_excerpt, ENT_NOQUOTES, 'UTF-8'),
            'caption_raw' => $this->slide->post_excerpt
        );

        // return the slide HTML
        switch($this->settings['type']) {
            case "coin":
                return $this->get_coin_slider_markup($slide);
            case "flex":
                return $this->get_flex_slider_markup($slide);
            case "nivo":
                return $this->get_nivo_slider_markup($slide);
            case "responsive":
                return $this->get_responsive_slides_markup($slide);
            default:
                return $this->get_flex_slider_markup($slide);
        }
    }

    /**
     * Generate nivo slider markup
     *
     * @return string slide html
     */
    private function get_nivo_slider_markup($slide) {
        $caption = htmlentities($slide['caption_raw'], ENT_QUOTES, 'UTF-8');

        $html = "<img height='{$this->settings['height']}' width='{$this->settings['width']}' src='{$slide['thumb']}' title=\"{$caption}\" alt='{$slide['alt']}' />";

        if (strlen($slide['url'])) {
            $html = "<a href='{$slide['url']}' target='{$slide['target']}'>" . $html . "</a>";
        }

        return $html;
    }

    /**
     * Generate flex slider markup
     *
     * @return string slide html
     */
    private function get_flex_slider_markup($slide) {
        $html = "                <img height='{$this->settings['height']}' width='{$this->settings['width']}' src='{$slide['thumb']}' alt='{$slide['alt']}' />";

        if (strlen($slide['url'])) {
            $html = "                <a href='{$slide['url']}' target='{$slide['target']}'>        " . $html . "                    </a>";
        }

        if (strlen($slide['caption'])) {
            $html .= "\n                    <div class='caption-wrap'>";
            $html .= "\n                        <div class='caption'>" . $slide['caption'] . "</div>";
            $html .= "\n                    </div>";
        }

        return $html;
    }

    /**
     * Generate coin slider markup
     *
     * @return string slide html
     */
    private function get_coin_slider_markup($slide) {
        $url = strlen($slide['url']) ? $slide['url'] : 'javascript:void(0)'; // coinslider always wants a URL

        $html  = "            <a href='" . $url . "' style='display: none;'>";
        $html .= "\n                <img height='{$this->settings['height']}' width='{$this->settings['width']}' src='{$slide['thumb']}' alt='{$slide['alt']}'   />"; // target doesn't work with coin
        $html .= "\n                <span>{$slide['caption']}</span>";
        $html .= "\n            </a>";
        return $html;
    }

    /**
     * Generate responsive slides markup
     *
     * @return string slide html
     */
    private function get_responsive_slides_markup($slide) {
        $html = "                <img height='{$this->settings['height']}' width='{$this->settings['width']}' src='{$slide['thumb']}' alt='{$slide['alt']}' />";

        if (strlen($slide['caption'])) {
            $html .= "\n                    <div class='caption-wrap'>";
            $html .= "\n                        <div class='caption'>{$slide['caption']}</div>";
            $html .= "\n                    </div>";
        }

        if (strlen($slide['url'])) {
            $html = "                <a href='{$slide['url']}' target='{$slide['target']}'>    " . $html . "                </a>";
        }

        return $html;
    }

    /**
     * Save
     */
    protected function save($fields) {
        // update the slide
        wp_update_post(array(
            'ID' => $this->slide->ID,
            'post_excerpt' => $fields['post_excerpt'],
            'menu_order' => $fields['menu_order']
        ));

        // store the URL as a meta field against the attachment
        $this->add_or_update_or_delete_meta($this->slide->ID, 'url', $fields['url']);

        // store the 'new window' setting
        $new_window = isset($fields['new_window']) && $fields['new_window'] == 'on' ? 'true' : 'false';

        $this->add_or_update_or_delete_meta($this->slide->ID, 'new_window', $new_window);
    }
}

function vantage_slider_init() {
	new VantageSimpleSlide();
}
add_action('after_setup_theme', 'vantage_slider_init');

endif;