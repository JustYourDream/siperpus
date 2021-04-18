<?php
/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);
?>
<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
  <ul class="pagination">
    <?php if ($pager->hasPrevious()) : ?>
      <li><a href="<?= $pager->getPrevious() ?>" data-original-title="" title=""><span aria-hidden="true">&laquo;</span></a></li>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
      <li <?= $link['active'] ? 'class="active"' : '' ?> ><a href="<?= $link['uri'] ?>" data-original-title=""><?= $link['title'] ?></a></li>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
      <li><a href="<?= $pager->getNext() ?>" data-original-title="" title=""><span aria-hidden="true">&raquo;</span></a></li>
    <?php endif ?>
  </ul>

</nav>
