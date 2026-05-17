<?php
session_start();
session_unset();
session_destroy();
header('Location: ../../../public/assets/index.php?logout=success');
exit();
?>