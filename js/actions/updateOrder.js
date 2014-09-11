$(window).load(function(){

  $(".list-view").addClass("reorderable-items");

  // $(".list-view-item").each(function(i, el) {
  //   // $(el).append($("<img src='<?php echo Yii::app()->mataAssetUrl . "/images/" . "drag-item.png" ?>' class='reorder-marker' />"));
  // })

$(".list-view .items").sortable({
  cursor: 'move',
  delay: 200,
  revert: true,
  placeholder: "sortable-highlight",
  tolerance: 'pointer',
  helper:'clone',
  connectWith: ".sortable",
  start: function(e, ui){
    ui.placeholder.height(ui.item.height());
  },
  update: function() {
    var str = "";
    $(".list-view-item").each(function(i){
      str += $(this).attr('data-id')+",";
    });
    $.ajax({
      type: "POST",
      url: window.location.pathname + "/updateOrder",
      data: {'reorder-ids':str},
      dataType: "json",
      success: function(data) {
        $('body').append('<div class="flash-success">Order Updated.</div>');
        handleFlashMessage();
      },
      error: function() {
        $('body').append('<div class="flash-error">Order not Updated. Please get in touch with your support team </div>');
        handleFlashMessage();
      }
    });
  }
});
})