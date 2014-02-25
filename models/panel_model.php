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
        $db = new SQLite3('lighting-server.db');
        $res = $db->query("select * from panels where uuid = {$panel_uuid}");

        if(! ($panel = $res->fetchArray(SQLITE3_ASSOC))) {
            // no such panel

            $this->panel = array();
            return ;
        }

        $res = $db->query("select panel_buttons.button_id, panel_buttons.scene_uuid from panels left join panel_buttons on panel_buttons.panel_uuid = panels.uuid where panels.uuid = {$panel_uuid};");

        while(($button = $res->fetchArray(SQLITE3_ASSOC))) {
            $panel['buttons'][] = array("{$button['button_id']}" => "{$button['scene_uuid']}");
        }

        $this->panel = $panel;
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
        foreach($configure['buttons'] as $value) {
            foreach($value as $btn_id => $scene_id) {
                $this->status[] = array('success' => array('uri' => "/controllers/{$configure['uuid']}/buttons/{$btn_id}", 'desc' => "{$scene_id}"));
            }
        }
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
