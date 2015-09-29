<div class="panel panel-default">
  <div class="panel-heading"><?php echo $heading_title; ?></div>
  <ul class="list-group">
    <?php foreach ($filter_groups as $filter_group) { ?>
    <li class="list-group-item"><i class="fa fa-plus-square-o"></i> <?php echo $filter_group['name']; ?></li>
    <li class="list-group-item">
    
      
    
    
      <div id="filter-group<?php echo $filter_group['filter_group_id']; ?>">
        <?php foreach ($filter_group['filter'] as $filter) { ?>
        <?php if (in_array($filter['filter_id'], $filter_category)) { ?>
        <label class="checkbox">
          <input name="filter[]" type="checkbox" value="<?php echo $filter['filter_id']; ?>" checked="checked" />
          <?php echo $filter['name']; ?></label>
        <?php } else { ?>
        <label class="checkbox">
          <input name="filter[]" type="checkbox" value="<?php echo $filter['filter_id']; ?>" />
          <?php echo $filter['name']; ?></label>
        <?php } ?>
        <?php } ?>
      </div>
      
      
    </li>
    <?php } ?>
  </ul>
  <div class="panel-footer text-right">
    <button type="button" id="button-filter" class="btn btn-primary"><?php echo $button_filter; ?></button>
  </div>
</div>
<script type="text/javascript"><!--
$('.button-filter').on('click', function() {
	$('#product-filter').nextSibling().on('click');
});

$('#button-filter').on('click', function() {
	filter = [];
	
	$('input[name^=\'filter\']:checked').each(function(element) {
		filter.push(this.value);
	});
	
	location = '<?php echo $action; ?>&filter=' + filter.join(',');
});
//--></script> 
