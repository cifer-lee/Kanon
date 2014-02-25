<?php

class PanelsModel extends Model {
    private $panels;
    private $status;

    public function __construct() {
    }

    public function get_all_panels() {
        $db = new SQLite3('lighting-server.db');
        $source = <<<EOD
select panels.uuid, panels.name, panels.type, panel_buttons.button_id, panel_buttons.scene_uuid from panels left join panel_buttons on panels.uuid = panel_buttons.panel_uuid;
EOD;
        $res = $db->query($source);

        while(($row = $res->fetchArray(SQLITE3_ASSOC))) {
            if($pre_panel_uuid == $row['uuid']) {
                $num = count($this->panels);
                $this->panels[$num - 1]['buttons'][] = array("{$row['button_id']}" => "{$row['scene_uuid']}");
            } else {
                $pre_panel_uuid = $row['uuid'];
                $this->panels[] = array(
                    'uuid' => $row['uuid'],
                    'name' => $row['name'],
                    'type' => $row['type'],
                    'buttons' => array(
                        array("{$row['button_id']}" => "{$row['scene_uuid']}")
                    )
                );
            }
        }

        return $this->panels;
    }

    public function create_panel($panel) {
        $db = new SQLite3('lighting-server.db');

        $source = <<<EOD
insert into panels (name, type, map_uuid) values ('{$panel['name']}', {$panel['type']}, {$panel['map_uuid']});
EOD;
        $ret = $db->exec($source);

        if(! $ret) {
            $error_code = $db->lastErrorCode();
            $this->status = array(
                'failure' => array(
                    'uri' => '/controllers', 
                    'desc' => "error code: {$error_code}"
                )
            );
        }

        $panel_uuid = $db->lastInsertRowId();

        $source = 'insert into panel_buttons (button_id, panel_uuid, scene_uuid) values ';
        foreach($panel['buttons'] as $value) {
            $source .= "('{$value}', {$panel_uuid}, 0),"; 
        }
        $source[strlen($source) - 1] = ';';

        $ret = $db->exec($source);

        if($ret) {
            $this->status = array(
                'success' => array(
                    'uri' => '/controllers', 
                    'desc' => "{$panel_uuid}"
                )
            );
        }
    }

    public function get_status() {
        return $this->status;
    }
}
