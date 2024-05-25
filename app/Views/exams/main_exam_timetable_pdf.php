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
            <h3><?= $main_exam_da['exam_name']; ?></h3>
            <p><b>Date : <?= get_date_format($main_exam_da['start_date'],'d M Y'); ?> - <?= get_date_format($main_exam_da['end_date'],'d M Y'); ?></b> </p>
            <p><b>Details : <br></b><?= $main_exam_da['description']; ?></p>
          <hr>
        </td>


    </tr>
</table>

    
     <?php $i=0; foreach (classes_array(company($user['id'])) as $ca): $i++; ?>
        
        <h4 style="padding:0px; margin-bottom: 3px;">Class Name :<?=$ca['class']; ?></h4>
    <table cellspacing="0" class="tab_b">
     <tr>
        <td><b>Date</b></td>
        <td><b>Time</b></td>
        <td><b>Subject</b></td>
    </tr>
   <?php $x=0; foreach (get_exam_time_table_array(company($user['id']),$ca['id'],$main_exam_da['id']) as $ex): $x++; ?>
    <tr>
        <td><?= get_date_format($ex['date'],'d M Y'); ?></td>
        <td><?= get_date_format($ex['from'],'h:i A'); ?> - <?= get_date_format($ex['to'],'h:i A'); ?></td>
        <td><?= subjects_name($ex['exam_for_subject']); ?></td>
    </tr>
    <?php endforeach ?>
    <?php if ($x==0): ?>
        <tr>
            <td colspan="3" style="text-align: center;"><h4>No exams </h4></td>
        </tr>
                
   <?php endif ?>

    </table>
   <?php endforeach ?>
    <?php if ($i==0): ?>
                <h4 style="text-align:center;">No class </h4>
   <?php endif ?>
    
