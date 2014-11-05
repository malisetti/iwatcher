<?php

namespace Abbiya\Watcher\Event;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Events
 *
 * @author seshachalam
 */
final class Events {

    const IN_ACCESS = IN_ACCESS; //'in_access'; //- read of the file
    const IN_MODIFY = IN_MODIFY; //'in_modify'; //- last modification
    const IN_ATTRIB = IN_ATTRIB; //'in_attrib'; //- attributes of file change
    const IN_OPEN = IN_OPEN; //'in_open'; //- open of file
    const IN_CLOSE_WRITE = IN_CLOSE_WRITE; //'in_close_write'; //- sent when a file opened for writing is closed
    const IN_CLOSE_NOWRITE = IN_CLOSE_NOWRITE; //'in_close_nowrite'; //- sent when a file opened not for writing is closed
    const IN_MOVED_FROM = IN_MOVED_FROM; //'in_moved_from'; //and IN_MOVED_TO - when the file is moved or renamed
    const IN_DELETE = IN_DELETE; //'in_delete'; //- a file/directory deleted
    const IN_CREATE = IN_CREATE; //'in_create'; //- a file in a watched directory is created
    const IN_DELETE_SELF = IN_DELETE_SELF; //'in_delete_self'; //- file monitored is deleted

    private static $watchableEvents = array(self::IN_ACCESS => 'onInAccess', self::IN_MODIFY => 'onInModify', self::IN_ATTRIB => 'onInAttrib', self::IN_OPEN => 'onInOpen', self::IN_CLOSE_WRITE => 'onInCloseWrite', self::IN_CLOSE_NOWRITE => 'onInCloseNoWrite', self::IN_MOVED_FROM => 'onInMovedFrom', self::IN_DELETE => 'onInDelete', self::IN_CREATE => 'onInCreate', self::IN_DELETE_SELF => 'onInDeleteSelf');

    public static function getAllEventsBit() {
        return (IN_ACCESS | IN_MODIFY | IN_ATTRIB | IN_OPEN | IN_CLOSE_WRITE | IN_CLOSE_NOWRITE | IN_MOVED_FROM | IN_DELETE | IN_CREATE | IN_DELETE_SELF);
    }

    public static function getAllWatchableEvents() {
        return self::$watchableEvents;
    }

}
