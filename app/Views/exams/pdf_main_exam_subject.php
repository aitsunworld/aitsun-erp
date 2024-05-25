<style type="text/css">
    table{width: 100%;}
    table td{padding: 0 5px;}
    .pr-5{
        padding-left: 50px;
    }
    .pb-5{
        padding-bottom: 20px;
    }
    .mxw-5{
        width: 50%;
        width: 50%;
    }
    .tab_b td{
        border: 1px solid black;
    }
</style>
<table cellspacing="0">
    <tr>
        <td colspan="3">
            <h3><?= $main_exam['exam_name']; ?></h3>
            <p><b>Date :</b> <?= get_date_format($main_exam['start_date'],'d M Y'); ?> - <?= get_date_format($main_exam['end_date'],'d M Y'); ?></p>
            <p><b>Class :</b> 
                <?php $classnm=''; foreach ($time_ex as $te): ?>
                    <?php $classnm=class_name($te['exam_for_class']); ?>
                <?php endforeach ?>
                <?= $classnm; ?>


            </p>
            <p><b>Details : <br></b><?= $main_exam['description']; ?></p>
          <hr>
        </td>

    </tr>
</table>

    <table cellspacing="0" border="1" style="border-collapse:collapse">
    
     <tr>
        <td><b>Date</b></td>
        <td><b>Time</b></td>
        <td><b>Subject</b></td>
    </tr>
    <?php foreach ($time_ex as $mc): ?>
    <tr>
        <td><?= get_date_format($mc['date'],'d M Y'); ?></td>
        <td><?= get_date_format($mc['from'],'h:i A'); ?> - <?= get_date_format($mc['to'],'h:i A'); ?></td>
        <td><?= subjects_name($mc['exam_for_subject']); ?></td>
    </tr>
   <?php endforeach ?>
    
</table>