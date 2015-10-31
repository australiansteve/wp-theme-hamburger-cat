var header_image_field;
jQuery(function($){
  $(document).on('click', 'input.select-header-img', function(evt){
    header_image_field = $(this).siblings('.img');
    tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
    return false;
  });
  window.send_to_editor = function(html) {
    imgurl = $('img', html).attr('src');
    header_image_field.val(imgurl);
    tb_remove();
  }
});