<nav aria-label="Page navigation example" class="template-paging">
  <ul class="pagination">
    <li class="page-item <?=$offset == 1 || $offset == '' ? 'disabled':''?>">
      <a class="page-link prev btnStep" href="javascript:;" aria-label="Previous" offset="<?=$offset-1?>">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    <?php if ($offset == '' || $offset == '1'): ?>
      <li class="page-item"><a class="page-link active" href="javascript:;">1</a></li>
      <?=ceil($data/$limit)>=2?'<li class="page-item"><a class="page-link paging" href="javascript:;" offset="2">2</a></li>':''?>
      <?=ceil($data/$limit)>=3?'<li class="page-item"><a class="page-link paging" href="javascript:;" offset="3">3</a></li>':''?>
    <?php else: ?>
      <li class="page-item"><a class="page-link paging" href="javascript:;" offset="<?=$offset-1?>"><?=$offset-1?></a></li>
      <li class="page-item"><a class="page-link active" href="javascript:;" offset="<?=$offset-1?>"><?=$offset?></a></li>
      <?php if (ceil($data/$limit)>=$offset+1): ?>
        <li class="page-item"><a class="page-link paging" href="javascript:;" offset="<?=$offset+1?>"><?=$offset+1?></a></li>
      <?php endif ?>
    <?php endif ?>
    <li class="page-item <?=$offset == ceil($data/$limit)?'disabled':''?>">
      <a class="page-link next btnStep" href="javascript:;" aria-label="Next" offset="<?=$offset+1?>">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
</nav>