<?php
require SB_TBFA_INC_PATH . '/sb-plugin-install.php';

if(!sb_tbfa_check_core() || !sb_tbfa_is_core_valid()) {
    return;
}

require SB_TBFA_INC_PATH . '/sb-plugin-functions.php';

require SB_TBFA_INC_PATH . '/sb-plugin-hook.php';

require SB_TBFA_INC_PATH . '/sb-plugin-admin.php';