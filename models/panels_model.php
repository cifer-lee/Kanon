<?php

class PanelsModel extends Model {
    private $panels;
    private $status;

    public function __construct() {
    }

    public function get_all_panels() {
        $db =& Db::get_instance();
        $source = <<<EOD
select panels.uuid, panels.name, panels.type, panel_buttons.button_id, panel_buttons.scene_uuid from panels left join panel_buttons on panels.uuid = panel_buttons.panel_uuid;
EOD;
        $res = $db->query($source);

        while(($row = $res->fetchArray(SQLITE3_ASSOC))) {
            if($pre_panel_uuid == $row['uuid']) {
                $num = count($this->panels);
                $this->panels[$num - 1]['buttons'][] = array('button_id' => "{$row['button_id']}", 'scene_uuid' => "{$row['scene_uuid']}");
            } else {
                $pre_panel_uuid = $row['uuid'];
                $this->panels[] = array(
                    'uuid' => $row['uuid'],
                    'name' => $row['name'],
                    'type' => $row['type'],
                    'buttons' => array(
                        array('button_id' => "{$row['button_id']}", 'scene_uuid' => "{$row['scene_uuid']}")
                    )
                );
            }
        }

        return $this->panels;
    }

    public function create_panel($panel) {
        $db =& Db::get_instance();
        $db->exec('begin;');

        $source = <<<EOD
insert into panels (name, type, map_uuid) values ('{$panel['name']}', {$panel['type']}, {$panel['map_uuid']});
EOD;
        $ret = $db->exec($source);

        if(! $ret) {
            $error_code = $db->lastErrorCode();
            $this->status = array(
                'status_code' => $error_code,
                'message' => ''
            );

            $db->exec('rollback;');
            return ;
        }

        $panel_uuid = $db->lastInsertRowId();

        /**
         * 生产环境上的 sqlite 版本不支持 insert into _tablename_ (col1, col2) values (val1, val2),(val11, val12),(val22, val33)...
         * 这种语法
         */
        foreach($panel['buttons'] as $value) {
            $source = "insert into panel_buttons (button_id, panel_uuid, scene_uuid) values ('{$value}', {$panel_uuid}, 0);";

            $ret = $db->exec($source);

            if(! $ret) {
                $this->status = array(
                    'status_code' => 1,
                    'message' => ""
                );
                $db->exec('rollback;');
                return ;
            }
        }

        $this->status = array(
            'status_code' => 0,
            'message' => "{$panel_uuid}"
        );
        $db->exec('commit;');
    }

    public function get_status() {
        return $this->status;
    }
}
