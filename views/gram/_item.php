<tr>
  <td><a href="/eyew/gram/lookup/?id=<?= $m->id ?>"><?= $m->id ?></a></td>
  <td><a href="https://instagram.com/<?= $m->user->username ?>"><?= $m->user->username ?></a></td>
  <td><a href="<?= $m->link ?>"><img src="<?= $m->images->thumbnail->url ?>"></a></td>
  <td>
    <?php
    echo (isset($m->caption->text)?$m->caption->text:'');
    ?>
  </td>
  <td><?= $m->created_time ?></td>
</tr>