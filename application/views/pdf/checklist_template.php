<?php
$dayWidth = 70 / 31;

//   print_r($items);
//   print_r($dataMap);
?>

<table border="1" cellpadding="3" cellspacing="0" width="100%">

    <!-- LOGO -->
    <tr>
        <td colspan="33" align="center">
            <img src="<?= $logo ?>" width="200">
        </td>
    </tr>

    <!-- TITLE -->
    <tr>
        <td colspan="33" align="center">
            <b style="font-size:10px;"><?= $title ?></b>
        </td>
    </tr>

    <!-- YEAR / MONTH -->
    <tr>
        <td colspan="33" align="right">
            <b>YEAR : <?= $year ?></b><br>
            <b>MONTH : <?= $month_name ?></b>
        </td>
    </tr>

    <!-- HEADER -->
    <tr>
        <th width="5%" align="center"><b>Sl.N</b></th>
        <th width="25%" align="center"><b>Description</b></th>

        <?php for ($i = 1; $i <= 31; $i++): ?>
            <th width="<?= $dayWidth ?>%" align="center"><b><?= $i ?></b></th>
        <?php endfor; ?>
    </tr>

    <!-- DATA ROWS -->
    <?php $sn = 1; 
  
    ?>

   <?php foreach ($items as $item): ?>
    <tr>
        <td align="center"><?= $sn++ ?></td>

        <!-- ✅ correct key -->
        <td><?= $item['question'] ?></td>

        <?php for ($day = 1; $day <= 31; $day++): ?>

            <?php
            $checked = '';

            // ✅ safe check (avoid undefined index warnings)
            if (!empty($dataMap[$item['id']][$day])) {

                $value = $dataMap[$item['id']][$day];

                if ($value == 'comply') {
                    $checked = '<span style="font-size:10px; color:green;"><b>✔</b></span>'; // ✔
                } elseif ($value == 'non-comply') {
                    $checked = '<span style="font-size:10px; color:red;"><b>✖</b></span>'; // ✖
                }
            }
            ?>

            <td align="center"><?= $checked ?></td>

        <?php endfor; ?>
    </tr>
<?php endforeach; ?>

    <!-- FOOTER -->
    <tr>
        <td colspan="33">Tech Signature</td>
    </tr>
    <tr>
        <td colspan="33">Manager Signature</td>
    </tr>
    <tr>
        <td colspan="33"><b>REMARKS:</b></td>
    </tr>

</table>