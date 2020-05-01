<style>
    table, td {
        text-align: center;
        vertical-align: central;
        border: 2px solid;
        border-collapse: collapse;
        padding: 2px;
    }

    .wrapper {
        overflow-x: auto;
        padding-top: 30px;
    }
</style>

<?php
echo "<div class='wrapper'>";
include Yii::getAlias('@export/base-templates/ServiceInformation.php');
echo "</div>";
