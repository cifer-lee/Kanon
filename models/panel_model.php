<?php

class PanelModel extends Model {
    /**
     * @var array Stores the current panel
     */
    private $panel;

    /**
     * @var boolean The status specifies whether operation was succeed.
     *  
     */
    private $status;

    public function __construct() {
    }

    /**
     * Fetch the panel info specified by $panel_uuid, and store it in $this->panel
     *
     * @return no return value
     */
    public function panel_info($panel_uuid) {
        $this->panel = array('button1', 'button2', 'button3');
    }

    /**
     * Update a panel
     *
     * @param $panel array  The panel's new information
     */
    public function panel_update($panel) {
        $this->status = true;
    }

    /**
     * Build relationships between panel buttons and scenes.
     */
    public function panel_configure($configure) {
        $this->status = true;
    }

    /**
     * Used by PanelView to get the current panel info
     *
     * @return array The panel info
     */
    public function get_panel() {
        return $this->panel;
    }

    /**
     * Used by PanelView to get the last operation's status
     *
     * @return boolean The last operation's status
     */
    public function get_status() {
        return $this->status;
    }
}
