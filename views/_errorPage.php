<?php
/**
 * @var $exception Exception
 */

?>
<h3 class="mt-4">
    <?php if ($exception) echo $exception->getCode() . " - " . $exception->getMessage() ?>
</h3>
