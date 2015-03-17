<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InstagramSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Instagrams';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instagram-index">
  <table class="table">
      <thead>
      <tr class="small-header">
        <td>Image ID</td>
        <td>User</td>
         <td >Thumbnail</td>
         <td >Caption</td>
         <td >Created at</td>
    </tr>
     </thead>
<?php
  foreach ($media as $m) {    
    echo $this->render('_item', [
        'm' => $m,
    ]);
  }
?>
</table>

</div>

