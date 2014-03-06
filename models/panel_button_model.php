<?php

class PanelButtonModel extends Model {

    /**
     * @var boolean The status specifies whether operation was succeed.
     *  
     */
    private $status;

    public function __construct() {
    }

    public function button_active($button) {
        $db =& Db::get_instance();
        $source = <<<EOD
select scene_uuid from panel_buttons where panel_uuid = {$button['controller_id']} and button_id = '{$button['button_id']}';
EOD;
        $res = $db->query($source);
        if(! $res) {
            $this->status = array(
                'status_code' => 1,
                'message' => ''
            );
        }

        /**
         * 在创建或者更新控制器的时候, 如果某个按钮的 scene_uuid 没有指定, 则默认是 0,
         * 所以, 这里只要 scene_uuid > 0, 就可以认为其已被指定
         */
        if(($scene = $res->fetchArray(SQLITE3_ASSOC)) && $scene['scene_uuid'] > 0) {
            $this->status = array(
                'status_code' => 0,
                'message' => ''
            );

            $socket = Socket::get_instance();
            if(! $socket) {
                return ;
            }

            $msg = sprintf("C S%03s\n", $scene_uuid);
            socket_send($socket, $msg, strlen($msg), MSG_EOF);
        } else {
            $this->status = array(
                'status_code' => 1,
                'message' => 'no such button or no scene designated'
            );
        }
    }

    public function get_status() {
        return $this->status;
    }
}
