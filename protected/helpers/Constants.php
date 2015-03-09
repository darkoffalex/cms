<?php

class Constants
{
    /**
     * Access-Groups ID's. Systems group can be managed only by developer through database.
     * After adding/deleting group you should update this constant list.
     */
    const GROUP_ROOT = 1;
    const GROUP_ADMIN = 2;
    const GROUP_USER = 3;
}

?>