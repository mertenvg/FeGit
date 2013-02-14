<?php
return array(
    'service_manager' => array(
        'initializers' => array(
            array('FeGit\Service\Initializers', 'SshConnect'),
        ),
    ),
);
